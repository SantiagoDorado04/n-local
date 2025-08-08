<?php

namespace App\Http\Livewire\Admin\SelfManagement;

use App\Problem;
use App\Solution;
use App\Indicator;
use App\Metodology;
use App\Models\Project;
use Livewire\Component;
use App\AnnouncementsContact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class IndicatorsComponent extends Component
{

    use AuthorizesRequests;

    public $title,
        $description,
        $metodologyId,
        $metodology=[],
        $solution=[],
        $problem = [],
        $project=[],
        $announcement=[],
        $indicatorId;

    public $searchName;
    
    public function mount($metodology){
        $this->metodology=Metodology::find($metodology);
        $this->metodologyId=$metodology;
        $this->solution=Solution::find($this->metodology->solution_id);
        $this->problem = Problem::find($this->solution->problem_id);
        $this->project=Project::find($this->problem->project_id);
        $this->announcement=AnnouncementsContact::find($this->project->announcement_contact_id);

    }

    public function render()
    {
        $indicators = Indicator::when($this->searchName, function ($query, $searchName) {
            return $query->where('title', 'like', '%' . $searchName . '%');
        })
        ->where('metodology_id','=',$this->metodologyId)
        ->get();
        
        return view('livewire.admin.self-management.indicators-component',[
            'indicators'=>$indicators
        ]);
    }


    public function show($id)
    {
        $this->indicatorId = $id;

        $indicator = Indicator::find($id);
        $this->title = $indicator->title;
        $this->description = $indicator->description;
    }

    public function store()
    {
        $this->validate([
            'title' => 'required',
            'description' => 'required',
        ], [], [
            'title' => 'nombre',
            'description' => 'descripción',
        ]);

        $indicator = new Indicator();
        $indicator->title = $this->title;
        $indicator->description = $this->description;
        $indicator->metodology_id=$this->metodologyId;
        $indicator->user_id=Auth::user()->id;
        $indicator->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Indicador creado correctamente']);
        $this->cancel();
    }

    public function edit($id)
    {

        $this->indicatorId = $id;

        $indicator = Indicator::find($id);
        $this->title = $indicator->title;
        $this->description = $indicator->description;
    }

    public function update()
    {

        $this->validate([
            'title' => 'required',
            'description' => 'required',
        ], [], [
            'title' => 'nombre',
            'description' => 'descripción',
        ]);

        $indicator = Indicator::find($this->indicatorId);
        $indicator->title = $this->title;
        $indicator->description = $this->description;
        $indicator->update();

        $this->emit('alert', ['type' => 'success', 'message' => 'Indicador actualizado correctamente']);
        $this->cancel();
    }

    public function delete($id)
    {
        $this->indicatorId = $id;
    }

    public function destroy()
    {
        $indicator = Indicator::find($this->indicatorId);
        $indicator->delete();

        $this->emit('alert', ['type' => 'success', 'message' => 'Indicador eliminado correctamente']);
        $this->cancel();
    }

    public function resetInputFields()
    {
        $this->title = '';
        $this->description = '';
        $this->indicatorId = '';
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }
}
