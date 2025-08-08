<?php

namespace App\Http\Livewire\Admin\InformationForms;

use App\Models\Step;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\InformationForm;

class InformationFormsComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $name,
        $description,
        $embebed,
        $points,
        $required_points,
        $reminder_message,
        $reminder_message_date,
        $reminder_message_mean,
        $congratulation_message,
        $congratulation_message_date,
        $congratulation_message_mean,
        $stepId,
        $formId;

    public $form;

    public $searchName;

    public function mount($id){
        $this->stepId = $id;

    }

    public function render()
    {
        $forms = InformationForm::when($this->searchName, function ($query, $searchName) {
            return $query->where('name', 'like', '%' . $searchName . '%');
        })
        ->where('step_id','=',$this->stepId)
            ->orderBy('created_at', 'desc')
            ->paginate(6);

        $firstItem = $forms->firstItem();
        $lastItem = $forms->lastItem();
        $step = Step::find($this->stepId);

        $paginationText = "Mostrando de {$firstItem} a {$lastItem} de {$forms->total()} registros";

        return view('livewire.admin.information-forms.information-forms-component', [
            'forms' => $forms,
            'paginationText' => $paginationText,
            'step' => $step
        ]);
    }

    public function show($id)
    {
        $this->formId = $id;

        $form = InformationForm::find($id);
        $this->name = $form->name;
        $this->description = $form->description;
        $this->embebed = $form->embebed;
        $this->points = $form->points;
        $this->required_points = $form->required_points;
        $this->reminder_message = $form->reminder_message;
        $this->reminder_message_date = $form->reminder_message_date;
        $this->reminder_message_mean = $form->reminder_message_mean;
        $this->congratulation_message = $form->congratulation_message;
        $this->congratulation_message_date = $form->congratulation_message_date;
        $this->congratulation_message_mean = $form->congratulation_message_mean;
    }

    public function store()
    {
        $this->validate([
            'name' => [
                'required',
                function ($attribute, $value, $fail) {
                    $existingInformationForm = InformationForm::where('name', $value)
                        ->where('step_id', $this->stepId)
                        ->where('id', '!=', $this->formId) //
                        ->first();
                    if ($existingInformationForm) {
                        $fail('El nombre del formulario ya existe en este paso.');
                    }
                },
            ],
            'description' => 'required',
            'embebed' => 'nullable',
            'points' => 'nullable|numeric',
            'required_points' => 'nullable|numeric',
            'reminder_message' => 'nullable',
            'reminder_message_date' => 'nullable|date|after_or_equal:today',
            'reminder_message_mean' => 'nullable',
            'congratulation_message' => 'nullable',
            'congratulation_message_date' => 'nullable|date|after_or_equal:today',
            'congratulation_message_mean' => 'nullable',
        ], [], [
            'name' => 'nombre',
            'description' => 'descripción',
            'embebed' => 'embebido',
            'points' => 'puntos',
            'points' => 'puntos requeridos',
            'reminder_message' => 'Mensaje recordatorio',
            'reminder_message_date' => 'Fecha Mensaje recordatorio',
            'reminder_message_mean' => 'Medio Mensaje recordatorio',
            'congratulation_message' => 'Mensaje felicitacion',
            'congratulation_message_date' => 'Fecha Mensaje felicitacion',
            'congratulation_message_mean' => 'Medio Mensaje felicitacion',
        ]);

        $form = new InformationForm();
        $form->name = $this->name;
        $form->description = $this->description;
        $form->embebed = $this->embebed;
        $form->step_id = $this->stepId;
        $form->points = $this->points;
        $form->required_points = $this->required_points ?: null;
        $form->reminder_message = $this->reminder_message;
        $form->reminder_message_date = $this->reminder_message_date ?: null;
        $form->reminder_message_mean = $this->reminder_message_mean;
        $form->congratulation_message = $this->congratulation_message;
        $form->congratulation_message_date = $this->congratulation_message_date ?: null;
        $form->congratulation_message_mean = $this->congratulation_message_mean;
        $form->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Formulario creado correctamente']);
        $this->cancel();
    }

    public function edit($id)
    {
        $this->formId = $id;

        $form = InformationForm::find($id);
        $this->name = $form->name;
        $this->description = $form->description;
        $this->embebed = $form->embebed;
        $this->points = $form->points;
        $this->required_points = $form->required_points;
        $this->reminder_message = $form->reminder_message;
        $this->reminder_message_date = $form->reminder_message_date;
        $this->reminder_message_mean = $form->reminder_message_mean;
        $this->congratulation_message = $form->congratulation_message;
        $this->congratulation_message_date = $form->congratulation_message_date;
        $this->congratulation_message_mean = $form->congratulation_message_mean;
    }

    public function update()
    {

        $this->validate([
            'name' => [
                'required',
                function ($attribute, $value, $fail) {
                    $existingInformationForm = InformationForm::where('name', $value)
                        ->where('step_id', $this->stepId)
                        ->where('id', '!=', $this->formId) //
                        ->first();
                    if ($existingInformationForm) {
                        $fail('El nombre del formulario ya existe en este paso.');
                    }
                },
            ],
            'description' => 'required',
            'embebed' => 'nullable',
            'points' => 'nullable|numeric',
            'required_points' => 'nullable|numeric',
            'reminder_message' => 'nullable',
            'reminder_message_date' => 'nullable|date|after_or_equal:today',
            'reminder_message_mean' => 'nullable',
            'congratulation_message' => 'nullable',
            'congratulation_message_date' => 'nullable|date|after_or_equal:today',
            'congratulation_message_mean' => 'nullable',
        ], [], [
            'name' => 'nombre',
            'description' => 'descripción',
            'embebed' => 'embebido',
            'points' => 'puntos',
            'required_points' => 'puntos requeridos',
            'reminder_message' => 'Mensaje recordatorio',
            'reminder_message_date' => 'Fecha Mensaje recordatorio',
            'reminder_message_mean' => 'Medio Mensaje recordatorio',
            'congratulation_message' => 'Mensaje felicitacion',
            'congratulation_message_date' => 'Fecha Mensaje felicitacion',
            'congratulation_message_mean' => 'Medio Mensaje felicitacion',
        ]);

        $form = InformationForm::find($this->formId);
        $form->name = $this->name;
        $form->description = $this->description;
        $form->embebed = $this->embebed;
        $form->points = $this->points;
        $form->required_points = $this->required_points ?: null;
        $form->reminder_message = $this->reminder_message;
        $form->reminder_message_date = $this->reminder_message_date ?: null;
        $form->reminder_message_mean = $this->reminder_message_mean;
        $form->congratulation_message = $this->congratulation_message;
        $form->congratulation_message_date = $this->congratulation_message_date ?: null;
        $form->congratulation_message_mean = $this->congratulation_message_mean;

        $form->update();

        $this->emit('alert', ['type' => 'success', 'message' => 'Formulario actualizado correctamente']);
        $this->cancel();
    }

    public function delete($id)
    {
        $this->formId = $id;
    }

    public function destroy()
    {
        $form = InformationForm::find($this->formId);
        $form->delete();

        $this->emit('alert', ['type' => 'success', 'message' => 'Formulario eliminado correctamente']);
        $this->cancel();
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->description = '';
        $this->embebed = '';
        $this->points = '';
        $this->required_points = '';
        $this->reminder_message = '';
        $this->reminder_message_date = '';
        $this->reminder_message_mean = '';
        $this->congratulation_message = '';
        $this->congratulation_message_date = '';
        $this->congratulation_message_mean = '';
        $this->formId = '';
    }

    public function cancel()
    {
        $this->resetInputFields();

        $this->resetErrorBag();
        $this->resetValidation();

        $this->emit('close-modal');
    }

    public function preview($id){
        $this->formId = $id;

        $this->form = InformationForm::find($id);
    }

    public function slugify($text) {
        $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
        $text = preg_replace('~[^\\pL\d-]+~u', '-', $text);
        $text = trim($text, '-');
        $text = strtolower($text);
        $text = preg_replace('~[-]+~', '-', $text);

        return $text;
    }
}
