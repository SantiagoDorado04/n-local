<?php

namespace App\Http\Livewire\Admin\Viability;

use App\AnnouncementsContact;
use App\Models\Innovation;
use App\Models\Project;
use App\Technology;
use Livewire\Component;

class InnovationComponent extends Component
{

    public $project, $projectId, $innovationId;

    public $title, $description, $technology, $benchmarking;

    public $tc, $cc, $tcs = [], $ccs = [];

    public function mount($project)
    {
        $this->project = Project::find($project);
        $this->projectId = $this->project->id;

        $innovation = Innovation::where('project_id', '=', $this->projectId)->first();
        if ($innovation != '') {

            $this->innovationId = $innovation->id;
            $this->title = $innovation->title;
            $this->description = $innovation->description;
            $this->tcs = json_decode($innovation->technical_features);
            $this->ccs = json_decode($innovation->commercial_features);
            $this->technology = $innovation->technology;
            $this->benchmarking = $innovation->benchmarking;
            $this->projectId = $innovation->project_id;
        }
    }

    public function render()
    {
        $technologies = Technology::all();
        return view('livewire.admin.viability.innovation-component', [
            'technologies' => $technologies
        ]);
    }

    public function addTc()
    {
        $this->validate(
            [
                'tc' => 'required'
            ],
            [],
            [
                'tc' => 'categoria técnica'
            ]
        );
        array_push($this->tcs, $this->tc);
        $this->tc = '';
    }


    public function addCc()
    {
        $this->validate(
            [
                'cc' => 'required'
            ],
            [],
            [
                'cc' => 'categoria comerical'
            ]
        );
        array_push($this->ccs, $this->cc);
        $this->cc = '';
    }

    public function removeTc($value)
    {
        unset($this->tcs[$value]);
        $this->tcs = array_values($this->tcs);
        $this->ccs = array_values($this->ccs);
    }

    public function removeCc($value)
    {
        unset($this->ccs[$value]);
        $this->tcs = array_values($this->tcs);
        $this->ccs = array_values($this->ccs);
    }

    public function update()
    {
        $this->validate([
            'title' => 'required',
            'description' => 'required',
            'tcs' => 'required',
            'ccs' => 'required',
            'technology' => 'required',
            'benchmarking' => 'required'
        ], [
            'tcs.required' => 'Agregue al menos una caracteristica tecnologica',
            'ccs.required' => 'Agregue al menos una caracteristica comercial'
        ], [
            'title' => 'título',
            'description' => 'descripción',
            'technology' => 'tecnología',
            'benchmarking' => 'benchmarking'
        ]);

        if ($this->innovationId == '') {

            $innovation = new Innovation();
            $innovation->title = $this->title;
            $innovation->description = $this->description;
            $innovation->technical_features = json_encode($this->tcs);
            $innovation->commercial_features = json_encode($this->ccs);
            $innovation->technology = $this->technology;
            $innovation->benchmarking = $this->benchmarking;
            $innovation->project_id = $this->projectId;
            $innovation->save();

            $this->innovationId = $innovation->id;

            $this->emit('alert', ['type' => 'success', 'message' => 'Innovación agregada correctamente']);
        } else {
            $innovation = Innovation::find($this->innovationId);
            $innovation->title = $this->title;
            $innovation->description = $this->description;
            $innovation->technical_features = json_encode($this->tcs);
            $innovation->commercial_features = json_encode($this->ccs);
            $innovation->technology = $this->technology;
            $innovation->benchmarking = $this->benchmarking;
            $innovation->update();

            $this->emit('alert', ['type' => 'success', 'message' => 'Innovación actualizada correctamente']);
        }
    }
}
