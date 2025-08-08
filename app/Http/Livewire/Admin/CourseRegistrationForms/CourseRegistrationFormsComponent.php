<?php

namespace App\Http\Livewire\Admin\CourseRegistrationForms;

use App\CommercialAction;
use App\CommercialLand;
use App\CommercialStrategy;
use App\Models\CourseRegistrationForm;
use App\Models\InformationForm;
use App\Models\OnlineRegistration;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;


class CourseRegistrationFormsComponent extends Component
{

    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $name,
        $description,
        $token,
        $embebed_video,
        $file,
        $reminder_message,
        $reminder_message_date,
        $active = 1,
        $course_registration_form_id;

    public
        $online_registration_id, $onlineRegistration;

    public $searchName;

    public $currentFile;

    public $lands, $strategies, $actions;
    public $land_id, $strategy_id, $action_id;

    public $formId, $form,  $courseRegistrationForm;


    public function mount($id)
    {
        $this->lands = CommercialLand::all();
        $this->strategies = collect();
        $this->actions = collect();
        $this->online_registration_id = $id;
        $this->onlineRegistration = OnlineRegistration::find($this->online_registration_id);
    }

    public function render()
    {

        $coursesRegistrationForms = CourseRegistrationForm::when($this->searchName, function ($query, $searchName) {
            return $query->where('name', 'like', '%' . $searchName . '%');
        })
            ->where('online_registration_id', '=', $this->online_registration_id)
            ->paginate(6);

        $firstItem = $coursesRegistrationForms->firstItem();
        $lastItem = $coursesRegistrationForms->lastItem();


        $paginationText = "Mostrando {$firstItem}-{$lastItem} de {$coursesRegistrationForms->total()} registros";

        return view('livewire..admin.course-registration-forms.course-registration-forms-component', [
            'coursesRegistrationForms' => $coursesRegistrationForms,
            'paginationText' => $paginationText,
        ]);
    }

    public function show($id)
    {
        $this->course_registration_form_id = $id;

        $courseRegistrationForm = CourseRegistrationForm::find($id);
        $this->name = $courseRegistrationForm->name;
        $this->description = $courseRegistrationForm->description;
        $this->embebed_video = $courseRegistrationForm->embebed_video;
        $this->file = $courseRegistrationForm->file;
        $this->land_id = $courseRegistrationForm->land ? $courseRegistrationForm->land->name :  null;
        $this->strategy_id = $courseRegistrationForm->strategy ? $courseRegistrationForm->strategy->name :  null;
        $this->action_id = $courseRegistrationForm->action ? $courseRegistrationForm->action->name :  null;
        $this->active = $courseRegistrationForm->active;
        $this->embebed_video = $courseRegistrationForm->embebed_video;
        $this->reminder_message = $courseRegistrationForm->reminder_message;
        $this->reminder_message_date = $courseRegistrationForm->reminder_message_date;
    }

    public function store()
    {
        $this->validate([
            'name' => [
                'required',
                Rule::unique('course_registration_forms')->where(function ($query) {
                    return $query->where('online_registration_id', $this->online_registration_id);
                })
            ],
            'description' => 'required',
            'embebed_video' => 'nullable',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf|max:51200',
            'land_id' => 'required',
            'strategy_id' => 'required',
            'action_id' => 'required',
            'reminder_message' => 'nullable',
            'reminder_message_date' => 'nullable',
            'active' => 'required'
        ], [], [
            'name' => 'nombre',
            'description' => 'descripción',
            'embebed_video' => 'embebido de video',
            'file' => 'arte o poster',
            'land_id' => 'terreno comercial',
            'strategy_id' => 'estrategia comercial',
            'action_id' => 'acción comercial',
            'reminder_message' => 'mensaje de recordatorio',
            'reminder_message_date' => 'fecha del mensaje de recordatorio',
            'active' => 'activo'
        ]);

        $courseRegistrationForm = new CourseRegistrationForm();
        $courseRegistrationForm->name = $this->name;
        $courseRegistrationForm->description = $this->description;
        $courseRegistrationForm->embebed_video = $this->embebed_video;
        $courseRegistrationForm->online_registration_id = $this->online_registration_id;
        $courseRegistrationForm->land_id = $this->land_id;
        $courseRegistrationForm->strategy_id = $this->strategy_id;
        $courseRegistrationForm->action_id = $this->action_id;
        $courseRegistrationForm->active = $this->active;
        $courseRegistrationForm->reminder_message = $this->reminder_message;
        $courseRegistrationForm->reminder_message_date = $this->reminder_message_date;
        if ($this->file) {
            $originalFileName = $this->file->getClientOriginalName();
            $filePath = $this->file->storeAs('public/files', $originalFileName);
            $courseRegistrationForm->file = Storage::url($filePath);
        }
        $courseRegistrationForm->save();

        $onlineRegistration = OnlineRegistration::find($this->online_registration_id);
        $form =  new InformationForm();
        $form->name = $courseRegistrationForm->name;
        $form->description = $courseRegistrationForm->description;
        $form->token = $this->slugify($form->name . ' ' . $onlineRegistration->name . ' ' . 'control de registro');
        $form->course_registration_form_id = $courseRegistrationForm->id;
        $form->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Formulario de control de registro creado correctamente']);
        $this->cancel();
    }

    public function edit($id)
    {
        $this->course_registration_form_id = $id;
        $courseRegistrationForm = CourseRegistrationForm::find($id);
        $this->name = $courseRegistrationForm->name;
        $this->description = $courseRegistrationForm->description;
        $this->embebed_video = $courseRegistrationForm->embebed_video;
        $this->currentFile = $courseRegistrationForm->file; // Archivo actual
        $this->file = null;
        $this->active = $courseRegistrationForm->active;
        $this->reminder_message = $courseRegistrationForm->reminder_message;
        $this->reminder_message_date = $courseRegistrationForm->reminder_message_date;

        $this->land_id = $courseRegistrationForm->land_id;
        $this->strategies = CommercialStrategy::where('commercial_land_id', '=', $this->land_id)->get();
        $this->strategy_id = $courseRegistrationForm->strategy_id;
        $this->actions = CommercialAction::where('commercial_strategy_id', '=', $this->strategy_id)->get();
        $this->action_id = $courseRegistrationForm->action_id;
    }

    public function update()
    {
        $this->validate([
            'name' => [
                'required',
                Rule::unique('course_registration_forms')
                    ->where(function ($query) {
                        return $query->where('online_registration_id', $this->online_registration_id);
                    })
                    ->ignore($this->course_registration_form_id),
            ],
            'description' => 'required',
            'embebed_video' => 'nullable',
            'file' => 'nullable',
            'land_id' => 'required',
            'strategy_id' => 'required',
            'action_id' => 'required',
            'reminder_message' => 'nullable',
            'reminder_message_date' => 'nullable',
            'active' => 'required'
        ], [], [
            'name' => 'nombre',
            'description' => 'descripción',
            'embebed_video' => 'embebido de video',
            'file' => 'arte o poster',
            'land_id' => 'terreno comercial',
            'strategy_id' => 'estrategia comercial',
            'action_id' => 'acción comercial',
            'reminder_message' => 'mensaje de recordatorio',
            'reminder_message_date' => 'fecha del mensaje de recordatorio',
            'active' => 'activo'
        ]);

        $courseRegistrationForm = CourseRegistrationForm::find($this->course_registration_form_id);
        $courseRegistrationForm->name = $this->name;
        $courseRegistrationForm->description = $this->description;
        $courseRegistrationForm->embebed_video = $this->embebed_video;
        $courseRegistrationForm->active = $this->active;
        $courseRegistrationForm->reminder_message = $this->reminder_message;
        $courseRegistrationForm->reminder_message_date = $this->reminder_message_date;
        $courseRegistrationForm->land_id = $this->land_id;
        $courseRegistrationForm->strategy_id = $this->strategy_id;
        $courseRegistrationForm->action_id = $this->action_id;
        if ($this->file) {
            $originalFileName = $this->file->getClientOriginalName();
            $filePath = $this->file->storeAs('public/files', $originalFileName);
            $courseRegistrationForm->file = Storage::url($filePath);
        } elseif ($this->currentFile === null) {
            $courseRegistrationForm->file = null;
        }
        $courseRegistrationForm->update();

        $onlineRegistration = OnlineRegistration::find($this->online_registration_id);
        $form = InformationForm::where('course_registration_form_id', $courseRegistrationForm->id)->first();
        $form->name = $courseRegistrationForm->name;
        $form->description = $courseRegistrationForm->description;
        $form->token = $this->slugify($form->name . ' ' . $onlineRegistration->name . ' ' . 'control de registro');
        $form->update();

        $this->emit('alert', ['type' => 'success', 'message' => 'Formulario de control de registro actualizado correctamente']);
        $this->cancel();
    }

    public function delete($id)
    {
        $this->course_registration_form_id = $id;
    }

    public function destroy()
    {
        $courseRegistrationForm = CourseRegistrationForm::with('form')->find($this->course_registration_form_id);

        $courseRegistrationForm->delete();

        $this->emit('alert', ['type' => 'success', 'message' => 'Formulario de control de registro eliminado correctamente']);
        $this->cancel();
    }

    public function removeFile()
    {
        $this->currentFile = null;
        $this->file = null;
    }



    public function resetInputFields()
    {
        $this->name = '';
        $this->description = '';
        $this->embebed_video = '';
        $this->token = '';
        $this->course_registration_form_id = '';
        $this->land_id = '';
        $this->strategy_id = '';
        $this->action_id = '';
        $this->formId = '';
        $this->form = '';
        $this->strategies = collect();
        $this->actions = collect();
        $this->active = 1;
        $this->file = '';
        $this->currentFile = '';
        $this->reminder_message = '';
        $this->reminder_message_date = '';
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }



    public function slugify($text)
    {
        $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
        $text = preg_replace('~[^\\pL\d-]+~u', '-', $text);
        $text = trim($text, '-');
        $text = strtolower($text);
        $text = preg_replace('~[-]+~', '-', $text);

        return $text;
    }

    public function getToken($id)
    {
        $courseRegistrationForm = CourseRegistrationForm::find($id);

        $form = InformationForm::where('id', '=', $courseRegistrationForm->form->id)->first();
        $token = $form->token;
        $this->token = url('external-registration-form/' . $token);
    }

    public function updatedLandId($land)
    {
        if ($land != '') {
            $this->strategies = CommercialStrategy::where('commercial_land_id', '=', $land)->get();
        } else {
            $this->strategies = collect();
            $this->actions = collect();
            $this->land_id = '';
            $this->strategy_id = '';
            $this->action_id = '';
        }
    }

    public function updatedStrategyId($strategy)
    {
        if ($strategy != '') {
            $this->actions = CommercialAction::where('commercial_strategy_id', '=', $strategy)->get();
        } else {
            $this->actions = collect();
            $this->strategy_id = '';
            $this->action_id = '';
        }
    }

    public function preview($id)
    {
        $this->courseRegistrationForm = CourseRegistrationForm::find($id);
        if ($this->courseRegistrationForm) {
            $this->form = InformationForm::where('course_registration_form_id', $this->courseRegistrationForm->id)->first();
            $this->formId = $this->form ? $this->form->id : null;
        } else {
            $this->form = null;
            $this->formId = null;
        }
    }

    public function hydrate()
    {
        $this->emit('select2');
    }
}
