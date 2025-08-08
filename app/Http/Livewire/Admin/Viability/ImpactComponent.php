<?php

namespace App\Http\Livewire\Admin\Viability;

use App\Models\Impact;
use App\Models\Project;
use Livewire\Component;
use App\ImpactsAttachment;
use App\AnnouncementsContact;
use Livewire\WithFileUploads;

class ImpactComponent extends Component
{
    use WithFileUploads;

    public $impacts = [];

    public $project, $projectId, $impact = [], $impactId;

    public $data_collection,$attachment,$attachment_name,$attachmentId;

    public function mount($project)
    {
        $this->project = Project::find($project);
        $this->projectId = $this->project->id;

        $impact = Impact::where('project_id', '=', $this->projectId)->first();
        if ($impact != '') {

            $this->impactId =$impact->id;
            $this->impacts = json_decode($impact->metrics);

            $this->data_collection = $impact->data_collection;
        }
    }

    public function render()
    {
        $attachments=[];

        if($this->impactId != ''){
            $attachments=ImpactsAttachment::where('impact_id','=',$this->impactId)->get();
        }
        return view('livewire.admin.viability.impact-component',[
            'attachments'=>$attachments
        ]);
    }

    public function addImpact()
    {
        $nuevaFila = [
            'impact' => '',
            'last_year' => '',
            'current_year' => '',
            'measurement' => '',
        ];

        array_push($this->impacts, $nuevaFila);
    }

    public function removeImpact($index)
    {
        unset($this->impacts[$index]);
        $this->impacts = array_values($this->impacts);
    }

    public function update()
    {
        $this->validate([
            'impacts.*.impact' => 'required',
            'impacts.*.last_year' => 'required',
            'impacts.*.current_year' => 'required',
            'impacts.*.measurement' => 'required',
            'impacts' => 'required',
            'data_collection' => 'required'
        ], [
            'impacts.required' => 'Agregue al menos un impacto'
        ], [
            'impacts.*.impact' => 'campo',
            'impacts.*.last_year' => 'campo',
            'impacts.*.current_year' => 'campo',
            'impacts.*.measurement' => 'campo',
            'data_collection' => 'técnica recolección de datos'
        ]);

        if ($this->impactId == '') {

            $impact = new Impact();
            $impact->metrics = json_encode($this->impacts);
            $impact->data_collection =     $this->data_collection;
            $impact->project_id = $this->projectId;
            $impact->save();

            $this->impactId = $impact->id;

            $this->emit('alert', ['type' => 'success', 'message' => 'Impacto agregado correctamente']);
        } else {
            $impact = Impact::find($this->impactId);
            $impact->metrics = json_encode($this->impacts);
            $impact->data_collection =     $this->data_collection;
            $impact->update();

            $this->emit('alert', ['type' => 'success', 'message' => 'Impacto actualizado correctamente']);
        }
    }

    public function upload(){

        if ($this->impactId != '') {
            $this->validate([
                'attachment'=>'required|file|mimes:pdf',
                'attachment_name'=>'required'
            ],[],[
                'attachment'=>'archivo adjunto',
                'attachment_name'=>'nombre dela evidencia'
            ]);

            $extension = $this->attachment->getClientOriginalExtension();
            $name=str_replace(' ', '-', (strtolower($this->attachment_name).    '.'.$extension));

            $path = $this->attachment->storeAs('public/impacts', $name);
            $attachment= new ImpactsAttachment();
            $attachment->url=$path;
            $attachment->name=$this->attachment_name;
            $attachment->impact_id=$this->impactId;
            $attachment->save();

            $this->emit('alert', ['type' => 'success', 'message' => 'Evidencia subida correctamente']);

        }else{
            $this->emit('alert', ['type' => 'error', 'message' => 'Primero guarde la información del impacto.']);
        }

    }

    public function delete($id){
        $this->attachmentId=$id;
    }
}
