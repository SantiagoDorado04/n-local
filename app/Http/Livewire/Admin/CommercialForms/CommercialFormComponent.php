<?php

namespace App\Http\Livewire\Admin\CommercialForms;

use App\CommercialForm;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CommercialFormComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';


    //vars forms
    public $name,
        $description,
        $formId;

    public $val;

    public $searchName;

    public function mount($val = NULL)
    {
        $this->val=$val;
    }

    public function render()
    {
        //get all forms
        $forms = CommercialForm::when($this->searchName, function ($query, $searchName) {
            return $query->where('name', 'like', '%' . $searchName . '%');
        })
        ->orderBy('created_at','desc')
            ->paginate(6);

        $firstItem = $forms->firstItem();
        $lastItem = $forms->lastItem();

        $paginationText = "Mostrando de {$firstItem} a {$lastItem} de {$forms->total()} registros";

        return view('livewire.admin.commercial-forms.commercial-form-component', [
            'forms' => $forms,
            'paginationText' => $paginationText,
        ]);
    }

    /**
     * It takes the id of a form, finds the form, and sets the name and description of the form to the
     * name and description of the form
     * 
     * @param id The id of the form you want to show.
     */
    public function show($id)
    {
        $this->formId = $id;

        $form = CommercialForm::find($id);
        $this->name = $form->name;
        $this->description = $form->description;
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|unique:commercial_forms,name',
            'description' => 'required',
        ], [], [
            'name' => 'nombre',
            'description' => 'descripción',
        ]);

        $form = new CommercialForm();
        $form->name = $this->name;
        $form->description = $this->description;
        $form->save();

        //Create table results answers
        $nameTable = 'answers_form_' . $form->id;
        $nameDatabase = DB::connection()->getDatabaseName();

        $arrayColumns = array();
        array_push($arrayColumns, ' id INT NOT NULL AUTO_INCREMENT ');
        array_push($arrayColumns, " commercial_action_id INTEGER(11) NULL ");
        array_push($arrayColumns, " contact_id INTEGER(11) NULL ");
        array_push($arrayColumns, ' created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP');
        array_push($arrayColumns, ' updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        array_push($arrayColumns, ' PRIMARY KEY  (id)');

        $stringCampos = implode(", ", $arrayColumns);

        $createTable =
            "CREATE TABLE $nameDatabase.$nameTable ( " . $stringCampos . ") ENGINE = InnoDB;";
        DB::statement($createTable);

        $this->emit('alert', ['type' => 'success', 'message' => 'Formulario creado correctamente']);
        $this->cancel();
    }

    /**
     * The function is called edit and it takes one parameter, . The function then sets the formId
     * property to the value of . It then finds the CommercialForm with the id of  and sets the
     * name and description properties to the values of the CommercialForm's name and description
     * 
     * @param id The id of the form you want to edit.
     */
    public function edit($id)
    {
        $this->formId = $id;

        $form = CommercialForm::find($id);
        $this->name = $form->name;
        $this->description = $form->description;
    }

    /**
     * It validates the form data, then updates the form data
     */
    public function update()
    {
        $this->validate([
            'name' => 'required|unique:commercial_forms,name,' . $this->formId,
            'description' => 'required',
        ], [], [
            'name' => 'nombre',
            'description' => 'descripción',
        ]);

        //Update form data
        $form = CommercialForm::find($this->formId);
        $form->name = $this->name;
        $form->description = $this->description;
        $form->update();

        $this->emit('alert', ['type' => 'success', 'message' => 'Formulario actualizado correctamente']);
        $this->cancel();
    }

    public function delete($id)
    {
        $this->formId = $id;
    }

    /**
     * The function deletes the form and emits an alert to the user
     */
    public function destroy()
    {

        $form = CommercialForm::find($this->formId);
        $form->delete();

        $this->emit('alert', ['type' => 'success', 'message' => 'Formulario eliminado correctamente']);
        $this->cancel();
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->description = '';
        $this->formId = '';
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }
}
