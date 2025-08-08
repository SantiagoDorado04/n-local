<?php

namespace App\Http\Livewire\Admin\Canvas;

use App\Canva;
use App\Models\Step;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\InformationForm;
use Illuminate\Validation\Rule;
use App\Models\InformationFormQuestion;
use PhpOffice\PhpWord\TemplateProcessor;

class CanvasComponent extends Component
{

    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';
    public $stepId;
    public $template;
    public $formId, $questionId, $text, $type, $position;

    public function mount($id)
    {
        $this->stepId = $id;
    }

    public function render()
    {
        $step = Step::find($this->stepId);
        $canva = Canva::where('step_id', $this->stepId)->first();
        $form = InformationForm::find($canva->information_form_id);
        $this->formId  = $form->id;
        $questions = InformationFormQuestion::where('information_form_id', '=', $form->id)->get();

        return view('livewire.admin.canvas.canvas-component', [
            'step' => $step,
            'canva' => $canva,
            'form' => $form,
            'questions' => $questions,
            'convertToVariable' => fn($text) => $this->convertToVariable($text),
        ]);
    }

    public function upload()
    {

        $this->validate([
            'template' => 'required|file|mimes:doc,docx',
        ]);

        $path = $this->template->store('templates');

        $canva = Canva::where('step_id', '=', $this->stepId)->first();
        if ($canva) {
            $canva->url_file = $path;
            $canva->save();
        }

        $this->emit('alert', ['type' => 'success', 'message' => 'Archivo cargado correctamente']);
    }

    public function downloadTemplate()
    {
        $canva = Canva::where('step_id', $this->stepId)->first();
        if ($canva && $canva->url_file) {
            $filePath = storage_path('app/' . $canva->url_file);
            return response()->download($filePath);
        }
    }

    public function store()
    {
        $this->validate([
            'text' => [
                'required',
                Rule::unique('information_form_questions', 'text')->where(function ($query) {
                    return $query->where('information_form_id', '=', $this->formId);
                }),
            ],
            'position' => 'sometimes|nullable|integer',
        ], [], [
            'text' => 'texto',
            'position' => 'posición',
        ]);        

        if ($this->position == '') {
            $maxPosition = InformationFormQuestion::where('information_form_id', $this->formId)->max('position');
            $this->position = is_null($maxPosition) ? 1 : $maxPosition + 1;
        }

        $question = new InformationFormQuestion();
        $question->text = $this->text;
        $question->type = 'AL';
        $question->position = $this->position;
        $question->information_form_id = $this->formId;
        $question->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Pregunta creada correctamente']);
        $this->cancel();
    }

    public function edit($id)
    {
        $this->questionId = $id;

        $question = InformationFormQuestion::find($id);
        $this->text = $question->text;
        $this->type = $question->type;
        $this->position = $question->position;
    }

    public function update()
    {

        $this->validate([
            'text' => 'required|unique:information_form_questions,text,' . $this->questionId,
        ], [], [
            'text' => 'texto',
        ]);

        $question = InformationFormQuestion::find($this->questionId);
        $question->text = $this->text;
        $question->update();

        $this->emit('alert', ['type' => 'success', 'message' => 'Pregunta actualizada correctamente']);
        $this->cancel();
    }

    public function delete($id)
    {
        $this->questionId = $id;
    }

    public function destroy()
    {
        $question = InformationFormQuestion::find($this->questionId);
        $question->delete();

        $this->emit('alert', ['type' => 'success', 'message' => 'Pregunta eliminada correctamente']);
        $this->cancel();
    }

    public function resetInputFields()
    {
        $this->text = '';
        $this->type = '';
        $this->position = '';
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }

    private function convertToVariable($text)
    {
        $lowercaseText = strtolower($text);
        $underscoredText = str_replace(' ', '_', $lowercaseText);
        $variable = '${' . $underscoredText . '}';
        return $variable;
    }
}
