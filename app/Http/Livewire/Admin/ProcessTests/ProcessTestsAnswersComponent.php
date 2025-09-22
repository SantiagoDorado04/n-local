<?php

namespace App\Http\Livewire\Admin\ProcessTests;

use App\Models\ContactsStage;
use App\Models\ProcessContactTest;
use App\Models\ProcessTest;
use App\Models\ProcessTestAnswer;
use App\Models\ProcessTestOption;
use App\Models\Step;
use Livewire\Component;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use QuickChart;

class ProcessTestsAnswersComponent extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $nit,
        $name,
        $filePostulates,
        $feedback,
        $phone,
        $email,
        $whatsapp,
        $website,
        $contact_person_name,
        $contactId;

    public $deleteContactId;

    public $questionId,  $text,
        $type,
        $position;
    public $answers = [];
    public $contact_test_id;
    public $test_id;

    public $searchName;
    public $idFeedback;

    public $step_id;
    public $step;
    public $sortDirection = 'asc';

    public $test;
    public $preview;
    public $info;
    public $questionsInfo;
    public $answerInfo;
    public $sortField = 'id';

    public function mount($id)
    {
        $this->info = collect();
        $this->step = Step::find($id);
        $this->test = ProcessTest::where('step_id', $id)->first();
        $this->test_id = $this->test->id;
        $this->step_id = $this->step->id;
    }

    public function render()
    {
        // Construir la consulta base
        $query = ContactsStage::where('stage_id', $this->step->stage_id)
            ->with(['contact' => function ($q) {
                $q->select('id', 'nit', 'name', 'email', 'phone', 'whatsapp', 'contact_person_name');
            }])
            ->select('contact_id')
            ->distinct();


        // Filtro por búsqueda de nombre o NIT
        if ($this->searchName) {
            $query->whereHas('contact', function ($q) {
                $q->where('name', 'like', '%' . $this->searchName . '%')
                    ->orWhere('email', 'like', '%' . $this->searchName . '%')
                    ->orWhere('nit', 'like', '%' . $this->searchName . '%');
            });
        }

        // Paginación
        $registers = $query->paginate(20);

        // Generar texto de paginación
        $firstItem = $registers->firstItem();
        $lastItem = $registers->lastItem();
        $paginationText = "Mostrando {$firstItem}-{$lastItem} de {$registers->total()} registros";

        return view('livewire..admin.process-tests.process-tests-answers-component', [
            'registers' => $registers,
            'paginationText' => $paginationText,
            'test' => $this->test,
        ]);
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }

    public function preview($contactId)
    {
        $this->contactId = $contactId;

        if ($this->test) {
            $this->preview = ProcessTestAnswer::where('process_test_id', $this->test->id)
                ->where('contact_id', $this->contactId)
                ->with(['question', 'option']) // Relación con las preguntas y opciones
                ->get()
                ->map(function ($item) {
                    // Procesar las respuestas
                    if (strpos($item->answer, ',') !== false) {
                        // Si es una respuesta múltiple (separada por comas)
                        $optionIds = explode(',', $item->answer);
                        $optionTexts = ProcessTestOption::whereIn('id', $optionIds)->pluck('text')->toArray();
                        $item->answer_text = implode(', ', $optionTexts);
                    } elseif ($item->option) {
                        // Si es una respuesta simple con opción
                        $item->answer_text = $item->option->text;
                    } else {
                        // Si es una respuesta de texto libre
                        $item->answer_text = $item->answer;
                    }

                    return $item;
                });
        } else {
            $this->preview = collect();
        }
    }

    public function delete($contactId)
    {
        $this->deleteContactId = $contactId;
    }

    public function destroy()
    {
        if (!$this->deleteContactId || !$this->test) {
            return;
        }

        ProcessTestAnswer::where('contact_id', $this->deleteContactId)
            ->where('process_test_id', $this->test->id)
            ->delete();

        // 2. Eliminar registro de ProcessContactTest
        ProcessContactTest::where('contact_id', $this->deleteContactId)
            ->where('process_test_id', $this->test->id)
            ->delete();

        $this->cancel();

        // Notificar
        $this->emit('alert', ['type' => 'danger', 'message' => 'Respuestas eliminadas correctamente.']);
    }

    public function resetInputFields()
    {
        $this->answers = [];
        $this->feedback = '';
        $this->nit = '';
        $this->name = '';
        $this->phone = '';
        $this->email = '';
        $this->whatsapp = '';
        $this->website = '';
        $this->contact_person_name = '';
        $this->filePostulates = null;
        $this->contactId = '';
        $this->deleteContactId = null;
    }

    private function getChartAsBase64($chartUrl)
    {
        try {
            $context = stream_context_create([
                'http' => [
                    'timeout' => 30,
                    'user_agent' => 'Mozilla/5.0 (compatible; PHP Chart Downloader)',
                    'follow_location' => true
                ]
            ]);

            $imageData = file_get_contents($chartUrl, false, $context);

            return $imageData ? 'data:image/png;base64,' . base64_encode($imageData) : null;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function downloadResult($contactId)
    {
        $processTest = $this->test;

        $answers = ProcessTestAnswer::with(['question.subcategory.category', 'option'])
            ->where('contact_id', $contactId)
            ->where('process_test_id', $processTest->id)
            ->get();

        $totalPoints = $answers->sum('points');

        $totalMaxPoints = $processTest->questions->sum(fn($q) => $q->options->max('points'));

        $generalAppreciation = $processTest->appreciations()
            ->where('start_points', '<=', $totalPoints)
            ->where('end_points', '>=', $totalPoints)
            ->first();

        $categories = $processTest->categories()
            ->with(['subcategories.questions.options', 'appreciations', 'subcategories.appreciations'])
            ->get()
            ->map(function ($category) use ($answers) {
                $categoryPoints = $answers->whereIn('p_test_subcategory_id', $category->subcategories->pluck('id'))->sum('points');
                $categoryMaxPoints = $category->subcategories->sum(fn($sub) => $sub->questions->sum(fn($q) => $q->options->max('points')));

                $appreciation = $category->appreciations
                    ->where('start_points', '<=', $categoryPoints)
                    ->where('end_points', '>=', $categoryPoints)
                    ->first();

                $category->score = $categoryPoints;
                $category->max_score = $categoryMaxPoints;
                $category->appreciation_result = $appreciation;

                $category->subcategories = $category->subcategories->map(function ($sub) use ($answers) {
                    $subPoints = $answers->where('p_test_subcategory_id', $sub->id)->sum('points');
                    $subMaxPoints = $sub->questions->sum(fn($q) => $q->options->max('points'));

                    $subAppreciation = $sub->appreciations
                        ->where('start_points', '<=', $subPoints)
                        ->where('end_points', '>=', $subPoints)
                        ->first();

                    $sub->score = $subPoints ?? 0;
                    $sub->max_score = $subMaxPoints ?? 0;
                    $sub->appreciation_result = $subAppreciation;

                    return $sub;
                });

                return $category;
            });

        if (!Storage::exists('temp/charts')) {
            Storage::makeDirectory('temp/charts');
        }

        $generalPercent = $totalMaxPoints > 0
            ? number_format(($totalPoints / $totalMaxPoints) * 100, 2, '.', '')
            : 0;
        $generalRestante = number_format(100 - $generalPercent, 2, '.', '');

        $qcGeneral = new QuickChart();
        $qcGeneral->setWidth(500);
        $qcGeneral->setHeight(400);
        $qcGeneral->setConfig([
            'type' => 'doughnut',
            'data' => [
                'labels' => [
                    'Obtenido (' . $generalPercent . '%)',
                    'Posibilidad de mejora (' . $generalRestante . '%)'
                ],
                'datasets' => [[
                    'data' => [$generalPercent, $generalRestante],
                    'backgroundColor' => ['#4CAF50', '#E0E0E0'],
                    'borderWidth' => 2,
                    'borderColor' => '#ffffff'
                ]]
            ],
            'options' => [
                'responsive' => false,
                'plugins' => [
                    'legend' => ['display' => true, 'position' => 'bottom'],
                    'title' => ['display' => true, 'text' => 'Puntuación General (%)'],
                    'tooltip' => ['callbacks' => [
                        'label' => "function(context) { return context.label + ': ' + context.parsed + '%'; }"
                    ]]
                ],
                'cutout' => '50%'
            ]
        ]);
        $generalChartBase64 = $this->getChartAsBase64($qcGeneral->getUrl());

        $categories = $categories->map(function ($category) {
            if ($category->subcategories->count() > 0 && $category->max_score > 0) {
                $labels = [];
                $percentages = [];
                $colors = ['#2196F3', '#4CAF50', '#FF9800', '#F44336', '#9C27B0', '#607D8B', '#795548', '#3F51B5'];
                $backgroundColors = [];

                foreach ($category->subcategories as $i => $sub) {
                    $subPercent = $category->max_score > 0
                        ? number_format(($sub->score / $category->max_score) * 100, 2, '.', '')
                        : 0;
                    $labels[] = $sub->name . ' (' . $subPercent . '%)';
                    $percentages[] = $subPercent;
                    $backgroundColors[] = $colors[$i % count($colors)];
                }

                $restante = max(0, number_format(100 - array_sum($percentages), 2, '.', ''));
                if ($restante > 0) {
                    $labels[] = 'Posibilidad de mejora (' . $restante . '%)';
                    $percentages[] = $restante;
                    $backgroundColors[] = '#E0E0E0';
                }

                $qc = new QuickChart();
                $qc->setWidth(600);
                $qc->setHeight(400);
                $qc->setConfig([
                    'type' => 'doughnut',
                    'data' => [
                        'labels' => $labels,
                        'datasets' => [[
                            'data' => $percentages,
                            'backgroundColor' => $backgroundColors,
                            'borderColor' => '#fff',
                            'borderWidth' => 2
                        ]]
                    ],
                    'options' => [
                        'responsive' => false,
                        'plugins' => [
                            'legend' => ['display' => true, 'position' => 'bottom'],
                            'title' => ['display' => true, 'text' => 'Distribución Subcategorías: ' . $category->name],
                            'tooltip' => ['callbacks' => [
                                'label' => "function(context) { return context.label + ': ' + context.parsed + '%'; }"
                            ]]
                        ],
                        'cutout' => '50%'
                    ]
                ]);

                $category->chartBase64 = $this->getChartAsBase64($qc->getUrl());
            }
            return $category;
        });

        $pdf = Pdf::loadView('pdfs.process-test-result', [
            'processTest' => $processTest,
            'totalPoints' => $totalPoints,
            'totalMaxPoints' => $totalMaxPoints,
            'generalAppreciation' => $generalAppreciation,
            'categories' => $categories,
            'answers' => $answers,
            'generalChartBase64' => $generalChartBase64,
        ])
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'DejaVu Sans',
                'dpi' => 150,
            ]);

        return Response::streamDownload(
            fn() => print($pdf->output()),
            'resultado-test-' . $contactId . '-' . date('Y-m-d-H-i-s') . '.pdf'
        );
    }
}
