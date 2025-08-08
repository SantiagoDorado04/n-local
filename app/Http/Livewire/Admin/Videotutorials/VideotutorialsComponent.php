<?php

namespace App\Http\Livewire\Admin\Videotutorials;

use App\Tutorial;
use Livewire\Component;
use App\Categorytutorial;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class VideotutorialsComponent extends Component
{
    public $tutorialId,
        $embed,
        $title,
        $description,
        $category_tutorials_id,
        $state,
        $attached,
        $tutorial = [];

    public function render()
    {
        $categories = Categorytutorial::all();
        $tutorials = Tutorial::all();
        return view('livewire.admin.videotutorials.videotutorials-component', [
            'categories' => $categories,
            'tutorials' => $tutorials
        ]);
    }

    public function show($id)
    {
        $tutorial = Tutorial::find($id);
        $this->tutorial = $tutorial;
    }

    public function store()
    {
        $this->validate([
            'title' => 'required|unique:tutorials,title',
            'description' => 'required',
            'category_tutorials_id' => 'required',
            'state' => 'required',
            'embed' => 'required'
        ], [], [
            'title' => 'título',
            'description' => 'descripción',
            'category_tutorials_id' => 'categoría',
            'state' => 'estado',
            'embed' => 'embebido'
        ]);

        $tutorial =  new Tutorial();
        $tutorial->title = $this->title;
        $tutorial->slug =  Str::slug($this->title);
        $tutorial->description = $this->description;
        $tutorial->category_tutorials_id = $this->category_tutorials_id;
        $tutorial->create_user_id = Auth::user()->id;
        $tutorial->update_user_id = Auth::user()->id;
        $tutorial->state = $this->state;
        $tutorial->embed = $this->embed;

        if ($this->attached != '') {
            $tutorial->attached = $this->attached->store('public/tutorials');
        }
        $tutorial->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Tutorial creado correctamente']);
        $this->cancel();
    }

    public function edit($id)
    {

        $tutorial = Tutorial::find($id);
        $this->tutorialId = $tutorial->id;
        $this->title = $tutorial->title;
        $this->description = $tutorial->description;
        $this->category_tutorials_id = $tutorial->category_tutorials_id;
        $this->state = $tutorial->state;
        $this->embed = $tutorial->embed;

        $this->emit('load-cke');
    }

    public function update()
    {
        $this->validate([
            'title' => 'required|unique:tutorials,title,'.$this->tutorialId,
            'description' => 'required',
            'category_tutorials_id' => 'required',
            'state' => 'required',
            'embed' => 'required'
        ], [], [
            'title' => 'título',
            'description' => 'descripción',
            'category_tutorials_id' => 'categoría',
            'state' => 'estado',
            'embed' => 'embebido'
        ]);

        $tutorial = Tutorial::find($this->tutorialId);
        $tutorial->title = $this->title;
        $tutorial->slug =  Str::slug($this->title);
        $tutorial->description = $this->description;
        $tutorial->category_tutorials_id = $this->category_tutorials_id;
        $tutorial->update_user_id = Auth::user()->id;
        $tutorial->state = $this->state;
        $tutorial->embed = $this->embed;

        if ($this->attached != '') {
            $tutorial->attached = $this->attached->store('public/tutorials');
        }
        $tutorial->update();

        $this->emit('alert', ['type' => 'success', 'message' => 'Tutorial actualizado correctamente']);
        $this->cancel();
    }

    public function delete($id)
    {
        $tutorial = Tutorial::find($id);
        $this->tutorialId = $tutorial->id;
    }

    public function destroy()
    {
        $tutorial = Tutorial::find($this->tutorialId);
        $tutorial->delete();

        $this->emit('alert', ['type' => 'success', 'message' => 'Tutorial eliminado correctamente']);
        $this->cancel();
    }

    public function resetInputFields()
    {

        $this->tutorialId = '';
        $this->title = '';
        $this->description = '';
        $this->category_tutorials_id = '';
        $this->state = '';
        $this->embed = '';

        $this->emit('load-cke');
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }
}
