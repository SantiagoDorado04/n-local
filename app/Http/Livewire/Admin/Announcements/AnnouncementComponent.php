<?php

namespace App\Http\Livewire\Admin\Announcements;

use App\Announcement;
use Livewire\Component;
use Livewire\WithPagination;

class AnnouncementComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    
    //Vars Announcements
    public $name,
        $description,
        $announcementId;

    public $searchName;

    public function render()
    {
        $announcements = Announcement::when($this->searchName, function ($query, $searchName) {
            return $query->where('name', 'like', '%' . $searchName . '%');
        })
        ->orderBy('created_at','desc')
        ->paginate(6);
        
        $firstItem = $announcements->firstItem();
        $lastItem = $announcements->lastItem();

        $paginationText = "Mostrando de {$firstItem} a {$lastItem} de {$announcements->total()} registros";

        return view('livewire.admin.announcements.announcement-component', [
            'announcements' => $announcements,
            'paginationText'=>$paginationText
        ]);
    }

    public function show($id){
        $this->announcementId = $id;

        $announcement = Announcement::find($id);
        $this->name = $announcement->name;
        $this->description = $announcement->description;
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|unique:announcements,name',
            'description' => 'required',
        ], [], [
            'name' => 'nombre',
            'description' => 'descripción',
        ]);

        $announcement = new Announcement();
        $announcement->name = $this->name;
        $announcement->description = $this->description;
        $announcement->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Convocatoria creada correctamente']);
        $this->cancel();
    }

    public function edit($id)
    {
        $this->announcementId = $id;

        $announcement = Announcement::find($id);
        $this->name = $announcement->name;
        $this->description = $announcement->description;
    }

    public function update()
    {

        $this->validate([
            'name' => 'required',
            'description' => 'required',
        ], [], [
            'name' => 'nombre',
            'description' => 'descripción',
        ]);

        $announcement = Announcement::find($this->announcementId);
        $announcement->name = $this->name;
        $announcement->description = $this->description;
        $announcement->update();

        $this->emit('alert', ['type' => 'success', 'message' => 'Convocatoria actualizada correctamente']);
        $this->cancel();
    }

    public function delete($id)
    {
        $this->announcementId = $id;
    }

    public function destroy()
    {
        $announcement = Announcement::find($this->announcementId);
        $announcement->delete();

        $this->emit('alert', ['type' => 'success', 'message' => 'Convocatoria eliminada correctamente']);
        $this->cancel();
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->description = '';
        $this->announcementId = '';
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }
}
