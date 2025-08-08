<?php

namespace App\Http\Livewire\Admin\BusinessModel;

use App\Contact;
use App\BusinessModel;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class BusinessModelComponent extends Component
{

    use WithFileUploads;

    //variables para los modelos de negocio

    public $name,
        $description,
        $b2b,
        $b2c,
        $b2g,
        $source_income,
        $income,
        $bills,
        $business_plan,
        $modelId;

    public $errorSum = '';

    public $searchName;

    public $contact, $contactId;

    public function mount()
    {
        $contact = Contact::where('user_id', '=', Auth::user()->id)->first();
        $this->contactId = $contact->id;
        $this->contactId;
    }

    public function render()
    {
        $models= BusinessModel::when($this->searchName, function ($query, $searchName) {
            return $query->where('name', 'like', '%' . $searchName . '%');
        })
        ->where('contact_id','=',$this->contactId)->get();

        return view('livewire.admin.business-model.business-model-component',[
            'models'=>$models
        ]);
    }

    public function show($id){

        $model = BusinessModel::find($id);
        $this->modelId = $id;

        $this->name = $model->name;
        $this->description = $model->description;
        $this->b2b = $model->b2b;
        $this->b2c = $model->b2c;
        $this->b2g = $model->b2g;
        $this->source_income = $model->source_income;
        $this->income = $model->income;
        $this->bills = $model->bills;
        $this->business_plan = $model->business_plan;

    }

    public function store()
    {
        $this->validate([
            'b2b' => 'required|numeric|min:0|max:100',
            'b2c' => 'required|numeric|min:0|max:100',
            'b2g' => 'required|numeric|min:0|max:100',
            'name' => 'required',
            'description' => 'required',
            'source_income' => 'required',
            'income' => 'required|numeric|min:0',
            'bills' => 'required|numeric|min:0'
        ], [], []);

        $suma = (int)$this->b2b + (int)$this->b2c + (int)$this->b2g;

        if ($suma > 100) {

            $this->errorSum = 'La suma de los porcentajes no debe superar el 100%';
        } else {

            $this->errorSum = '';

            $model = new BusinessModel();
            $model->name = $this->name;
            $model->description = $this->description;
            $model->b2b = $this->b2b;
            $model->b2c = $this->b2c;
            $model->b2g = $this->b2g;
            $model->source_income = $this->source_income;
            $model->income = $this->income;
            $model->bills = $this->bills;

            if ($this->business_plan != '') {
                $path = $this->business_plan->store('public/business_plan');
                $model->business_plan = $path;
            }

            $model->contact_id = $this->contactId;
            $model->save();

            $this->emit('alert', ['type' => 'success', 'message' => 'Modelo de negocio creado correctamente']);
            $this->cancel();
        }
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->description = '';
        $this->b2b = '';
        $this->b2c = '';
        $this->b2g = '';
        $this->source_income = '';
        $this->income = '';
        $this->bills = '';
        $this->business_plan = '';
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }

    public function edit($id){
        $model = BusinessModel::find($id);
        $this->modelId = $id;

        $this->name = $model->name;
        $this->description = $model->description;
        $this->b2b = $model->b2b;
        $this->b2c = $model->b2c;
        $this->b2g = $model->b2g;
        $this->source_income = $model->source_income;
        $this->income = $model->income;
        $this->bills = $model->bills;
        $this->business_plan = $model->business_plan;
    }

    public function update(){
        $this->validate([
            'b2b' => 'required|numeric|min:0|max:100',
            'b2c' => 'required|numeric|min:0|max:100',
            'b2g' => 'required|numeric|min:0|max:100',
            'name' => 'required',
            'description' => 'required',
            'source_income' => 'required',
            'income' => 'required|numeric|min:0',
            'bills' => 'required|numeric|min:0'
        ], [], []);

        $this->validate([
            'b2b' => 'required|numeric|min:0|max:100',
            'b2c' => 'required|numeric|min:0|max:100',
            'b2g' => 'required|numeric|min:0|max:100',
            'name' => 'required',
            'description' => 'required',
            'source_income' => 'required',
            'income' => 'required|numeric|min:0',
            'bills' => 'required|numeric|min:0'
        ], [], []);

        $suma = (int)$this->b2b + (int)$this->b2c + (int)$this->b2g;

        if ($suma > 100) {

            $this->errorSum = 'La suma de los porcentajes no debe superar el 100%';
        } else {

            $this->errorSum = '';

            $model = BusinessModel::find($this->modelId);
            $model->name = $this->name;
            $model->description = $this->description;
            $model->b2b = $this->b2b;
            $model->b2c = $this->b2c;
            $model->b2g = $this->b2g;
            $model->source_income = $this->source_income;
            $model->income = $this->income;
            $model->bills = $this->bills;

            if ($this->business_plan != '') {
                $path = $this->business_plan->store('public/business_plan');
                $model->business_plan = $path;
            }

            $model->contact_id = $this->contactId;
            $model->update();

            $this->emit('alert', ['type' => 'success', 'message' => 'Modelo de negocio actualizado correctamente']);
            $this->cancel();
        }
    }

    public function delete($id){
        $this->modelId = $id;
    }

    public function destroy(){
        $model = BusinessModel::find($this->modelId);
        $model->delete();

        $this->emit('alert', ['type' => 'success', 'message' => 'Modelo de negocio eliminado correctamente']);
        $this->cancel();
    }
}
