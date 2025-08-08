<?php

namespace App\Http\Livewire\Admin\CommercialManagement\MailingTemplates;

use App\EmailTemplate;
use Livewire\Component;

class MailingTemplatesComponent extends Component
{    
    
    public $searchTitle;
    
    public function render()
    {
        $templates=EmailTemplate::when($this->searchTitle, function ($query, $searchTitle) {
            return $query->where('title', 'like', '%' . $searchTitle . '%');
        })->get();
        return view('livewire.admin.commercial-management.mailing-templates.mailing-templates-component',[
            'templates'=>$templates
        ]);
    }

}
