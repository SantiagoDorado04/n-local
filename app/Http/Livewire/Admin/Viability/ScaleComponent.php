<?php

namespace App\Http\Livewire\Admin\Viability;

use App\Models\Project;
use App\Models\Scaling;
use Livewire\Component;
use App\AnnouncementsContact;

class ScaleComponent extends Component
{

    public $project, $projectId, $scalingId;

    public $kpis= [];

    public
        $regulations,
        $tamTerritory, $tamUsd, $tamUsers, $tamSegment,
        $samTerritory, $samUsd, $samUsers, $samSegment,
        $somTerritory, $somUsd, $somUsers, $somSegment;

    public function mount($project)
    {
        $this->project = Project::find($project);
        $this->projectId = $this->project->id;

        $scaling=Scaling::where('project_id','=',$this->projectId)->first();
        if($scaling!=''){

            $this->scalingId=$scaling->id;

            $this->regulations=$scaling->regulations;

            $market = json_decode($scaling->market);
            $this->tamTerritory = $market->tam->territory;
            $this->tamUsd = $market->tam->usd;
            $this->tamUsers = $market->tam->users;
            $this->tamSegment = $market->tam->segment;

            $this->samTerritory = $market->sam->territory;
            $this->samUsd = $market->sam->usd;
            $this->samUsers = $market->sam->users;
            $this->samSegment = $market->sam->segment;

            $this->somTerritory = $market->som->territory;
            $this->somUsd = $market->som->usd;
            $this->somUsers = $market->som->users;
            $this->somSegment = $market->som->segment;

            $this->kpis= json_decode($scaling->traction);
        }
    }

    public function render()
    {
        return view('livewire.admin.viability.scale-component');
    }

    public function addKpi()
    {
        $nuevaFila = [
            'indicator' => '',
            'last_year' => '',
            'current_year' => '',
            'measurement' => '',
        ];

        array_push($this->kpis, $nuevaFila);
    }

    public function removeKpi($index)
    {
        unset($this->kpis[$index]);
        $this->kpis = array_values($this->kpis);
    }

    public function update()
    {
        $this->validate([
            'regulations' => 'required',
            'tamTerritory' => 'required',
            'tamUsd' => 'required',
            'tamUsers' => 'required',
            'tamSegment' => 'required',
            'samTerritory' => 'required',
            'samUsd' => 'required',
            'samUsers' => 'required',
            'samSegment' => 'required',
            'somTerritory' => 'required',
            'somUsd' => 'required',
            'somUsers' => 'required',
            'somSegment' => 'required',
            'kpis.*.indicator' => 'required',
            'kpis.*.last_year' => 'required',
            'kpis.*.current_year' => 'required',
            'kpis.*.measurement' => 'required',
            'kpis' => 'required'
        ], [
            'kpis.required' => 'Agregue al menos un KPI'
        ], [
            'regulations' => 'regulaciones',
            'tamTerritory' => 'territorio',
            'tamUsd' => 'USD',
            'tamUsers' => 'usuarios',
            'tamSegment' => 'segmento',
            'samTerritory' => 'territorio',
            'samUsd' => 'USD',
            'samUsers' => 'usuarios',
            'samSegment' => 'segmento',
            'somTerritory' => 'territorio',
            'somUsd' => 'USD',
            'somUsers' => 'usuarios',
            'somSegment' => 'segmento',
            'kpis.*.last_year' => 'campo',
            'kpis.*.current_year' => 'campo',
            'kpis.*.measurement' => 'campo',
        ]);

        $market=array(
            'tam'=>array(
                'territory'=>$this->tamTerritory,
                'usd'=>$this->tamUsd,
                'users'=>$this->tamUsers,
                'segment'=>$this->tamSegment
            ),
            'sam'=>array(
                'territory'=>$this->samTerritory,
                'usd'=>$this->samUsd,
                'users'=>$this->samUsers,
                'segment'=>$this->samSegment
            ),
            'som'=>array(
                'territory'=>$this->somTerritory,
                'usd'=>$this->somUsd,
                'users'=>$this->somUsers,
                'segment'=>$this->somSegment
            ),
        );

        if($this->scalingId==''){
            $scaling = new Scaling();
            $scaling->regulations=$this->regulations;
            $scaling->market = json_encode($market);
            $scaling->traction = json_encode($this->kpis);
            $scaling->project_id=$this->projectId;
            $scaling->save();

            $this->scalingId=$scaling->id;

            $this->emit('alert', ['type' => 'success', 'message' => 'Escala agregada correctamente']);

        }else{
            $scaling = Scaling::find($this->scalingId);
            $scaling->regulations=$this->regulations;
            $scaling->market = json_encode($market);
            $scaling->traction = json_encode($this->kpis);
            $scaling->update();

            $this->emit('alert', ['type' => 'success', 'message' => 'Escala actualizada correctamente']);
        }
    }
}
