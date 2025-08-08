<?php

namespace App\Http\Livewire\Admin\CommercialManagement\MailingMassive;

use App\Campaign;
use Livewire\Component;

class HistoryMailingMassiveComponent extends Component
{
    public function render()
    {
        $campaigns = Campaign::all();
        return view('livewire.admin.commercial-management.mailing-massive.history-mailing-massive-component',[
            'campaigns'=>$campaigns
        ]);
    }
}
