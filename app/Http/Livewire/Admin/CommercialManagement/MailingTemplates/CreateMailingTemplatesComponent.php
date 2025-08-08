<?php

namespace App\Http\Livewire\Admin\CommercialManagement\MailingTemplates;

use App\EmailTemplate;
use Livewire\Component;

class CreateMailingTemplatesComponent extends Component
{
    public $title, $content, $templateId;

    public $template;

    public function mount($template = NULL)
    {
        $this->template = EmailTemplate::find($template);
        if ($this->template != '') {
            $this->templateId = $this->template->id;
            $this->title = $this->template->title;
            $this->content = $this->template->content;
        }
    }

    public function render()
    {
        return view('livewire.admin.commercial-management.mailing-templates.create-mailing-templates-component');
    }

    public function save(){
        $this->validate([
            'title' => 'required|unique:email_templates,title,' . $this->templateId,
            'content' => 'required',
        ], [], [
            'title' => 'nombre',
            'content' => 'contenido',
        ]);

        if( $this->templateId==''){
            $template = new EmailTemplate();
            $template->title = $this->title;
            $template->content= $this->content;
            $template->save();
            $this->emit('alert', ['type' => 'success', 'message' => 'Template creado correctamente']);

            $this->templateId=$template->id;
        
        }else{
            $template = EmailTemplate::find($this->templateId);
            $template->title = $this->title;
            $template->content= $this->content;
            $template->update();
            $this->emit('alert', ['type' => 'success', 'message' => 'Template actualizado correctamente']);
        }
    }
}
