<?php

namespace App\Http\Livewire\Admin\Projects;

use App\Models\Project;
use Livewire\Component;

class ProjectMapComponent extends Component
{

    public  $proyect;

    public function mount($id){
        $this->proyect = Project::find($id);

        dd($this->proyect);
    }
    public function render()
    {
        return view('livewire.admin.projects.project-map-component');
    }
}
