<?php

namespace App\Http\Livewire\Admin\SelfManagement;

use App\Problem;
use Livewire\Component;
use App\AnnouncementsContact;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProblemsComponent extends Component
{
    use AuthorizesRequests;

    public $title,
        $description,
        $problemId;

    public $project,$announcement, $projectId;
    public $searchName;
        

    public function mount($project)
    {
        $this->project = Project::find($project);
        $this->projectId = $this->project->id;
        $this->announcement = AnnouncementsContact::find($this->project->announcement_contact_id);
        

    }

    public function render()
    {
        $problems = Problem::when($this->searchName, function ($query, $searchName) {
            return $query->where('title', 'like', '%' . $searchName . '%');
        })
        ->where('project_id','=',$this->projectId)
        ->get();

        return view('livewire.admin.self-management.problems-component',[
            'problems'=>$problems
        ]);
    }

    public function show($id)
    {
        $this->problemId = $id;

        $problem = Problem::find($id);
        $this->title = $problem->title;
        $this->description = $problem->description;
    }

    public function store()
    {
        $this->validate([
            'title' => 'required|max:300',
            'description' => 'required',
        ], [], [
            'title' => 'nombre',
            'description' => 'descripción',
        ]);

        $problem = new Problem();
        $problem->title = $this->title;
        $problem->description = $this->description;
        $problem->user_id=Auth::user()->id;
        $problem->project_id= $this->projectId;
        $problem->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Problema creado correctamente']);
        $this->cancel();
    }

    public function edit($id)
    {

        $this->problemId = $id;

        $problem = Problem::find($id);
        $this->title = $problem->title;
        $this->description = $problem->description;
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

        $problem = Problem::find($this->problemId);
        $problem->title = $this->title;
        $problem->description = $this->description;
        $problem->update();

        $this->emit('alert', ['type' => 'success', 'message' => 'Problema actualizado correctamente']);
        $this->cancel();
    }

    public function delete($id)
    {
        $this->problemId = $id;
    }

    public function destroy()
    {
        $problem = Problem::find($this->problemId);
        $problem->delete();

        $this->emit('alert', ['type' => 'success', 'message' => 'Problema eliminado correctamente']);
        $this->cancel();
    }

    public function resetInputFields()
    {
        $this->title = '';
        $this->description = '';
        $this->problemId = '';
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }
}
