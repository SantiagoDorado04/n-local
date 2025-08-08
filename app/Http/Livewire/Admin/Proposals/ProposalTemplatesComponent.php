<?php

namespace App\Http\Livewire\Admin\Proposals;

use Livewire\Component;
use App\ProposalTemplate;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class ProposalTemplatesComponent extends Component
{
    use WithFileUploads;
    
    public $name,
        $description,
        $file,
        $templateId;

    public function render()
    {
        $templates = ProposalTemplate::all();
        return view('livewire.admin.proposals.proposal-templates-component',[
            'templates'=>$templates
        ]);
    }

    public function show($id)
    {
        $this->templateId = $id;

        $template = ProposalTemplate::find($this->templateId);
        $this->name = $template->name;
        $this->description = $template->description;
    }

    public function store(){

        $this->validate([
            'name' => 'required',
            'description' => 'required',
            'file' => 'required'
        ]);

        $template =  new ProposalTemplate();
        $template->name = $this->name;
        $template->description = $this->description;
        if ($this->file != '') {
            $file = $this->file;
            $path = $file->store('public');
            $url = Storage::url($path);
            $template->url_file = $url;
        }
        $template->save();

        $this->emit('alert', ['type' => 'success', 'message' => 'Plantilla guardada correctamente']);
        $this->cancel();

    }

    public function edit($id){
        
        $this->templateId = $id;

        $template = ProposalTemplate::find($this->templateId);
        $this->name = $template->name;
        $this->description = $template->description;

    }

    public function update(){

        $this->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $template = ProposalTemplate::find($this->templateId);
        $template->name = $this->name;
        $template->description = $this->description;
        if ($this->file != '') {
            $file = $this->file;
            $path = $file->store('public');
            $url = Storage::url($path);
            $template->url_file = $url;
        }
        $template->update();

        $this->emit('alert', ['type' => 'success', 'message' => 'Plantilla actualizada correctamente']);
        $this->cancel();
    }

    public function delete($id){
        
        $this->templateId = $id;

    }

    public function destroy(){

        $template = ProposalTemplate::find($this->templateId);
        $template->delete();

        $this->emit('alert', ['type' => 'success', 'message' => 'Plantilla eliminada correctamente']);
        $this->cancel();

    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->description = '';
        $this->file = '';
        $this->templateId = '';
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }
}
