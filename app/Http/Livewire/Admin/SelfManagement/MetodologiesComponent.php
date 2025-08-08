<?php

namespace App\Http\Livewire\Admin\SelfManagement;

use App\Problem;
use App\Solution;
use App\Metodology;
use App\Models\Project;
use Livewire\Component;
use App\AnnouncementsContact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class MetodologiesComponent extends Component
{
    use AuthorizesRequests;

    public $title,
        $description,
        $solutionId,
        $solution=[],
        $problem = [],
        $project=[],
        $announcement=[],
        $metodologyId;

    public $searchName;
    
    public function mount($solution){
        $this->solution=Solution::find($solution);
        $this->solutionId=$solution;
        $this->problem = Problem::find($this->solution->problem_id);
        $this->project=Project::find($this->problem->project_id);
        $this->announcement=AnnouncementsContact::find($this->project->announcement_contact_id);

    }

    public function render()
    {
        $metodologies = Metodology::when($this->searchName, function ($query, $searchName) {
            return $query->where('title', 'like', '%' . $searchName . '%');
        })
        ->where('solution_id','=',$this->solutionId)
        ->get();

        return view('livewire.admin.self-management.metodologies-component',[
            'metodologies'=>$metodologies
        ]);
    }

    public function show($id)
    {
        $this->metodologyId = $id;

        $metodology = Metodology::find($id);
        $this->title = $metodology->title;
        $this->description = $metodology->description;
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

        $metodology = new Metodology();
        $metodology->title = $this->title;
        $metodology->description = $this->description;
        $metodology->solution_id=$this->solutionId;
        $metodology->user_id=Auth::user()->id;
        $metodology->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Metodologia creada correctamente']);
        $this->cancel();
    }

    public function edit($id)
    {

        $this->metodologyId = $id;

        $metodology = Metodology::find($id);
        $this->title = $metodology->title;
        $this->description = $metodology->description;
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

        $metodology = Metodology::find($this->metodologyId);
        $metodology->title = $this->title;
        $metodology->description = $this->description;
        $metodology->update();

        $this->emit('alert', ['type' => 'success', 'message' => 'Metodologia actualizada correctamente']);
        $this->cancel();
    }

    public function delete($id)
    {
        $this->metodologyId = $id;
    }

    public function destroy()
    {
        $metodology = Metodology::find($this->metodologyId);
        $metodology->delete();

        $this->emit('alert', ['type' => 'success', 'message' => 'Metodologia eliminada correctamente']);
        $this->cancel();
    }

    public function resetInputFields()
    {
        $this->title = '';
        $this->description = '';
        $this->metodologyId = '';
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }
}
