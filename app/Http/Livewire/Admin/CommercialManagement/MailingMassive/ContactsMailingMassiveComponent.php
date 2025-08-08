<?php

namespace App\Http\Livewire\Admin\CommercialManagement\MailingMassive;

use App\Campaign;
use App\CampaignContact;
use Livewire\Component;

class ContactsMailingMassiveComponent extends Component
{

    public $campaignId, $campaign = [], $details=[];

    public function mount($id){
        $this->campaign = Campaign::find($id);
        $this->campaignId = $id;
    }
    public function render()
    {
        return view('livewire.admin.commercial-management.mailing-massive.contacts-mailing-massive-component');
    }

    public function getLinks($id){
        $this->details = CampaignContact::find($id);
    }

    public function cancel(){
        $this->emit('close-modal');
    }
}
