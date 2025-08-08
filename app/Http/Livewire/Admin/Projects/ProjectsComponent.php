<?php

namespace App\Http\Livewire\Admin\Projects;

use App\Models\Project;
use Livewire\Component;

class ProjectsComponent extends Component
{
    public function render()
    {
        $projects=Project::all();
        return view('livewire.admin.projects.projects-component',[
            'projects'=>$projects
        ]);
    }

    public function cancel(){
        $this->emit('close-modal');
    }
}
