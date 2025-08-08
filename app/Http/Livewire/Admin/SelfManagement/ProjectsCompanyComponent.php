<?php

namespace App\Http\Livewire\Admin\SelfManagement;

use App\AnnouncementsContact;
use App\Models\Project;
use Livewire\Component;

class ProjectsCompanyComponent extends Component
{

    public $projectId,$projectD,$announcementContactId,$contactId;

    public $title,
        $description;

    public function mount($announcement,$project=NULL){
        
       
        if($project!=''){
            $this->projectD=$project;
            $project=Project::find($this->projectD);
            $this->announcementContactId=$project->announcement_contact_id	;
        }else{
          
            $this->announcementContactId=$announcement;
            $announcement=AnnouncementsContact::find($this->announcementContactId);
            $this->contactId=$announcement->contact_id;
        }
    }

    public function render()
    {
        if($this->projectD!=''){
            $projects = Project::where('id','=',$this->projectD)->get();
        }else{
            $projects = Project::where('announcement_contact_id','=',$this->announcementContactId)
            ->get();
        }


        return view('livewire.admin.self-management.projects-company-component',[
            'projects'=>$projects
        ]);
    }

    public function show($id)
    {
        $this->projectId = $id;

        $project =Project::find($id);
        $this->title = $project->title;
        $this->description = $project->description;
    }

    public function store()
    {
        $this->validate([
            'title' => 'required|unique:projects,title',
            'description' => 'required',
        ], [], [
            'name' => 'nombre',
            'description' => 'descripción',
        ]);

        $project = new Project();
        $project->title = $this->title;
        $project->description = $this->description;
        $project->announcement_contact_id=$this->announcementContactId;
        $project->contact_id = $this->contactId;
        $project->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Proyecto creado correctamente']);
        $this->cancel();
    }

    public function edit($id)
    {

        $this->projectId = $id;

        $project = Project::find($id);
        $this->title = $project->title;
        $this->description = $project->description;
    }

    public function update()
    {

        $this->validate([
            'title' => 'required|unique:projects,title,' . $this->projectId,
            'description' => 'required',
        ], [], [
            'title' => 'nombre',
            'description' => 'descripción',
        ]);

        $project = Project::find($this->projectId);
        $project->title = $this->title;
        $project->description = $this->description;
        $project->update();

        $this->emit('alert', ['type' => 'success', 'message' => 'Proyecto actualizado correctamente']);
        $this->cancel();
    }

    public function delete($id)
    {
        $this->projectId = $id;
    }

    public function destroy()
    {
        $project = Project::find($this->projectId);
        $project->delete();

        $this->emit('alert', ['type' => 'success', 'message' => 'Proyecto eliminado correctamente']);
        $this->cancel();
    }



    public function resetInputFields()
    {
        $this->title = '';
        $this->description = '';
        $this->projectId = '';
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }
}
