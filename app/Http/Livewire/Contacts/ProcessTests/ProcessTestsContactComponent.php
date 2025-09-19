<?php

namespace App\Http\Livewire\Contacts\ProcessTests;

use App\Models\ProcessContactTest;
use App\Models\ProcessTestAnswer;
use App\Models\ProcessTestOption;
use App\Models\Step;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use QuickChart;

class ProcessTestsContactComponent extends Component
{

    protected $paginationTheme = 'bootstrap';

    public $searchName;

    public $processTestId;
    public $stepId;
    public $processTest;
    public $questions;
    public $options;
    public $contactId;

    public $input;
    public $message = '';
    public $count = 1;


    public $stageActive = false;

    public function mount($id)
    {
        $step = Step::with('processTest')->findOrFail($id);

        if ($step->stage->active == 1) {
            $this->stageActive = true;
        }
        $this->processTestId = $step->processTest->id;
        $this->processTest = $step->processTest;
        $this->questions = $this->processTest->questions;
        $this->options = ProcessTestOption::all();

        $this->stepId = $this->processTest->step_id;

        if (Auth::check() && Auth::user()->role_id == 7 || Auth::user()->role_id == 4) {
            $this->count = 2;
            $this->contactId = Auth::user()->contact->id;
        }
    }

    public function render()
    {
        $answers = ProcessTestAnswer::where('contact_id', '=', $this->contactId)
            ->where('process_test_id', '=', $this->processTestId)
            ->get()
            ->keyBy('p_test_question_id');
        return view('livewire..contacts.process-tests.process-tests-contact-component', [
            'processTest' => $this->processTest,
            'hasAnswers' => $answers->isNotEmpty(),
            'answers' => $answers
        ]);
    }

    public function submit($formData)
    {
        // Crear registro del contacto que completó el test
        $contacttest = new ProcessContactTest();
        $contacttest->fill([
            'contact_id' => $this->contactId,
            'process_test_id' => $this->processTestId,
            'date_completed' => now(),
        ])->save();

        // Recorrer todas las preguntas del test
        foreach ($this->questions as $question) {
            $questionKey = 'question_' . $question->id;

            if (isset($formData[$questionKey])) {
                $selectedOptionId = $formData[$questionKey];

                // Buscar la opción elegida
                $option = ProcessTestOption::find($selectedOptionId);

                if ($option) {
                    $answer = new ProcessTestAnswer();
                    $answer->contact_id = $this->contactId;
                    $answer->process_test_id = $this->processTestId;
                    $answer->p_test_question_id = $question->id;
                    $answer->p_test_subcategory_id = $question->p_test_subcategory_id; // viene desde la pregunta
                    $answer->answer = $option->id; // guardamos el id de la opción seleccionada
                    $answer->points = $option->points; // guardamos los puntos de la opción
                    $answer->save();
                }
            }
        }

        $this->emit('alert', ['type' => 'success', 'message' => '¡Test enviado correctamente!']);
        $this->render();
    }

    private function downloadChartImage($chartUrl, $filename)
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

            if ($imageData === false) {
                throw new \Exception("No se pudo descargar la imagen");
            }

            $path = "temp/charts/{$filename}";
            Storage::put($path, $imageData);

            return storage_path("app/{$path}");
        } catch (\Exception $e) {
            dd("Error descargando gráfico: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Genera imagen en base64 para embedding directo
     */
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

            if ($imageData === false) {
                return null;
            }

            return 'data:image/png;base64,' . base64_encode($imageData);
        } catch (\Exception $e) {
            dd("Error convirtiendo gráfico a base64: " . $e->getMessage());
            return null;
        }
    }

    public function downloadResult()
    {
        $processTest = $this->processTest;

        $answers = ProcessTestAnswer::with(['question.subcategory.category', 'option'])
            ->where('contact_id', $this->contactId)
            ->where('process_test_id', $this->processTestId)
            ->get();

        $totalPoints = $answers->sum('points');

        // Calcular puntaje máximo posible del test
        $totalMaxPoints = $processTest->questions->sum(function ($question) {
            return $question->options->max('points');
        });

        // Apreciación general del test
        $generalAppreciation = $processTest->appreciations()
            ->where('start_points', '<=', $totalPoints)
            ->where('end_points', '>=', $totalPoints)
            ->first();

        // --- Cargar categorías con subcategorías y apreciaciones ---
        $categories = $processTest->categories()
            ->with(['subcategories.questions.options', 'appreciations', 'subcategories.appreciations'])
            ->get()
            ->map(function ($category) use ($answers) {
                $categoryPoints = $answers
                    ->whereIn('p_test_subcategory_id', $category->subcategories->pluck('id'))
                    ->sum('points');

                $categoryMaxPoints = $category->subcategories->sum(function ($sub) {
                    return $sub->questions->sum(function ($q) {
                        return $q->options->max('points');
                    });
                });
                // Buscar apreciación de la categoría en base a puntos (NO porcentaje)
                $appreciation = $category->appreciations
                    ->where('start_points', '<=', $categoryPoints)
                    ->where('end_points', '>=', $categoryPoints)
                    ->first();

                $category->score = $categoryPoints;
                $category->max_score = $categoryMaxPoints;
                $category->appreciation_result = $appreciation;

                // Subcategorías con sus apreciaciones
                $category->subcategories = $category->subcategories->map(function ($sub) use ($answers) {
                    $subPoints = $answers->where('p_test_subcategory_id', $sub->id)->sum('points');
                    $subMaxPoints = $sub->questions->sum(function ($q) {
                        return $q->options->max('points');
                    });

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

        // --- Gráfico general tipo doughnut en porcentajes ---
        $generalPercent = $totalMaxPoints > 0 ? round(($totalPoints / $totalMaxPoints) * 100, 1) : 0;
        $qcGeneral = new QuickChart();
        $qcGeneral->setWidth(500);
        $qcGeneral->setHeight(400);
        $qcGeneral->setConfig([
            'type' => 'doughnut',
            'data' => [
                'labels' => ['Obtenido (' . $generalPercent . '%)', 'Restante'],
                'datasets' => [[
                    'data' => [$generalPercent, 100 - $generalPercent],
                    'backgroundColor' => ['#4CAF50', '#E0E0E0'],
                    'borderWidth' => 2,
                    'borderColor' => '#ffffff'
                ]]
            ],
            'options' => [
                'responsive' => false,
                'plugins' => [
                    'legend' => ['display' => true, 'position' => 'bottom'],
                    'title' => [
                        'display' => true,
                        'text' => 'Puntuación General (%)'
                    ],
                    'tooltip' => [
                        'callbacks' => [
                            'label' => "function(context) {
                    return context.label + ': ' + context.parsed + '%';
                }"
                        ]
                    ]
                ],
                'cutout' => '50%'
            ]
        ]);
        $generalChartBase64 = $this->getChartAsBase64($qcGeneral->getUrl());

        // --- Gráficos de categorías tipo doughnut en porcentajes ---
        $categories = $categories->map(function ($category) {
            if ($category->subcategories->count() > 0 && $category->max_score > 0) {
                $labels = [];
                $percentages = [];
                $colors = [
                    '#2196F3',
                    '#4CAF50',
                    '#FF9800',
                    '#F44336',
                    '#9C27B0',
                    '#607D8B',
                    '#795548',
                    '#3F51B5'
                ];
                $backgroundColors = [];

                // Agregar cada subcategoría como % del total de la categoría
                foreach ($category->subcategories as $i => $sub) {
                    $subPercent = $category->max_score > 0
                        ? round(($sub->score / $category->max_score) * 100, 1)
                        : 0;

                    $labels[] = $sub->name . ' (' . $subPercent . '%)';
                    $percentages[] = $subPercent;
                    $backgroundColors[] = $colors[$i % count($colors)];
                }

                // Restante global en gris
                $restante = max(0, 100 - array_sum($percentages));
                if ($restante > 0) {
                    $labels[] = 'Restante';
                    $percentages[] = $restante;
                    $backgroundColors[] = '#E0E0E0';
                }

                $config = [
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
                            'title' => [
                                'display' => true,
                                'text' => 'Distribución Subcategorías: ' . $category->name
                            ],
                            'tooltip' => [
                                'callbacks' => [
                                    'label' => "function(context) {
                            return context.label + ': ' + context.parsed + '%';
                        }"
                                ]
                            ]
                        ],
                        'cutout' => '50%'
                    ]
                ];

                $qc = new QuickChart();
                $qc->setWidth(600);
                $qc->setHeight(400);
                $qc->setConfig($config);

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
                'enable_php' => false,
                'chroot' => public_path(),
                'enable_remote' => true
            ]);

        return Response::streamDownload(
            fn() => print($pdf->output()),
            'resultado-test-' . $this->contactId . '-' . date('Y-m-d-H-i-s') . '.pdf'
        );
    }


    /**
     * Limpia archivos temporales de gráficos
     */
    private function cleanupTempFiles()
    {
        try {
            $files = Storage::files('temp/charts');
            $cutoff = now()->subHours(2);

            foreach ($files as $file) {
                if (Storage::lastModified($file) < $cutoff->timestamp) {
                    Storage::delete($file);
                }
            }
        } catch (\Exception $e) {
            dd("Error limpiando archivos temporales: " . $e->getMessage());
        }
    }
}
