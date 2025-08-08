<?php

namespace App\Http\Livewire\Admin\SelfManagement;

use App\AnnouncementsContact;
use App\Problem;
use App\Solution;
use App\Models\Project;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SolutionsComponent extends Component
{
    use AuthorizesRequests;

    public $title,
        $description,
        $problemId,
        $problem = [],
        $project=[],
        $announcement=[],
        $solutionId;

    public $searchName;

    public function mount($problem)
    {
        $this->problem = Problem::find($problem);
        $this->problemId = $problem;
        $this->project=Project::find($this->problem->project_id);
        $this->announcement=AnnouncementsContact::find($this->project->announcement_contact_id);
    }

    public function render()
    {
        $solutions = Solution::when($this->searchName, function ($query, $searchName) {
            return $query->where('title', 'like', '%' . $searchName . '%');
        })
        ->where('problem_id','=',$this->problemId)
        ->get();

        return view('livewire.admin.self-management.solutions-component', [
            'solutions' => $solutions
        ]);
    }

    public function show($id)
    {
        $this->solutionId = $id;

        $solution = Solution::find($id);
        $this->title = $solution->title;
        $this->description = $solution->description;
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

        $solution = new Solution();
        $solution->title = $this->title;
        $solution->description = $this->description;
        $solution->problem_id = $this->problemId;
        $solution->user_id = Auth::user()->id;
        $solution->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Solución creada correctamente']);
        $this->cancel();
    }

    public function edit($id)
    {

        $this->solutionId = $id;

        $solution = Solution::find($id);
        $this->title = $solution->title;
        $this->description = $solution->description;
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

        $solution = Solution::find($this->solutionId);
        $solution->title = $this->title;
        $solution->description = $this->description;
        $solution->update();

        $this->emit('alert', ['type' => 'success', 'message' => 'Solución actualizada correctamente']);
        $this->cancel();
    }

    public function delete($id)
    {
        $this->solutionId = $id;
    }

    public function destroy()
    {
        $solution = Solution::find($this->solutionId);
        $solution->delete();

        $this->emit('alert', ['type' => 'success', 'message' => 'Solución eliminada correctamente']);
        $this->cancel();
    }

    public function resetInputFields()
    {
        $this->title = '';
        $this->description = '';
        $this->solutionId = '';
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }
}
