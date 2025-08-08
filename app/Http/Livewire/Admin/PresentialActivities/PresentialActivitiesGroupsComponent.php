<?php

namespace App\Http\Livewire\Admin\PresentialActivities;

use App\Models\PresentialActivitiesGroup;
use App\Models\PresentialActivity;
use Livewire\Component;
use Livewire\WithPagination;

class PresentialActivitiesGroupsComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    // 'name',
    //     'date',
    //     'hour',
    //     'quota',
    //     'presential_activity_id',

    public $name,
        $date,
        $hour,
        $quota,
        $groupId
        ;

    public $presential_activity_id;

    public $searchName;

    public function mount($id)
    {
        $this->presential_activity_id = $id;
    }

    public function render()
    {
        $groups = PresentialActivitiesGroup::when($this->searchName, function ($query, $searchName) {
            return $query->where('name', 'like', '%' . $searchName . '%');
        })
            ->where('presential_activity_id', '=', $this->presential_activity_id)
            ->orderBy('created_at', 'desc')
            ->paginate(6);

        $firstItem = $groups->firstItem();
        $lastItem = $groups->lastItem();
        $presentialActivity = PresentialActivity::find($this->presential_activity_id);

        $paginationText = "Mostrando de {$firstItem} a {$lastItem} de {$groups->total()} registros";

        return view('livewire.admin.presential-activities.presential-activities-groups-component', [

            'groups' => $groups,
            'paginationText' => $paginationText,
            'presentialActivity' => $presentialActivity

        ]);

    }

    public function show($id)
    {
        $this->groupId = $id;

        $group = PresentialActivitiesGroup::find($id);
        $this->name = $group->name;
        $this->date = $group->date;
        $this->hour = $group->hour;
        $this->quota = $group->quota;

    }

    public function store()
    {
        $this->validate([
            'name' => [
                'required',
                function ($attribute, $value, $fail) {
                    $existingGroup = PresentialActivitiesGroup::where('name', $value)
                        ->where('presential_activity_id', $this->presential_activity_id)
                        ->where('id', '!=', $this->groupId)
                        ->first();
                    if ($existingGroup) {
                        $fail('El nombre del grupo ya existe en esta actividad.');
                    }
                },
            ],
            'date' => 'required',
            'hour' => 'required',
            'quota' => 'required',
        ], [], [
            'name' => 'nombre',
            'date' => 'fecha',
            'hour' => 'hora',
            'quota' => 'cuota',
        ]);

        $group = new PresentialActivitiesGroup();
        $group->name = $this->name;
        $group->date = $this->date;
        $group->hour = $this->hour;
        $group->quota = $this->quota;

        $group->presential_activity_id = $this->presential_activity_id;
        $group->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Grupo creado correctamente']);
        $this->cancel();
    }

    public function edit($id)
    {
        $this->groupId = $id;

        $group = PresentialActivitiesGroup::find($id);

        $this->name = $group->name;
        $this->date = $group->date;
        $this->hour = $group->hour;
        $this->quota = $group->quota;

    }

    public function update()
    {
        $this->validate([
            'name' => 'required|unique:presential_activities_groups,name,' . $this->groupId,
            'date' => 'required',
            'hour' => 'required',
            'quota' => 'required',
        ], [], [
            'name' => 'nombre',
            'date' => 'fecha',
            'hour' => 'hora',
            'quota' => 'cuota',
        ]);

        $group = PresentialActivitiesGroup::find($this->groupId);
        $group->name = $this->name;
        $group->date = $this->date;
        $group->hour = $this->hour;
        $group->quota = $this->quota;
        $group->update();

        $this->emit('alert', ['type' => 'success', 'message' => 'Grupo actualizado correctamente']);
        $this->cancel();
    }

    public function delete($id)
    {
        $this->groupId = $id;
    }

    public function destroy()
    {
        $group = PresentialActivitiesGroup::find($this->groupId);
        $group->delete();

        $this->emit('alert', ['type' => 'success', 'message' => 'Grupo eliminado correctamente']);
        $this->cancel();
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->date = '';
        $this->hour = '';
        $this->quota = '';
        $this->groupId = '';
    }

    public function cancel()
    {
        $this->resetInputFields();

        $this->resetErrorBag();
        $this->resetValidation();

        $this->emit('close-modal');
    }
}
