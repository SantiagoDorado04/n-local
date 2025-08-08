<?php

namespace App\Http\Livewire\Admin\CommercialManagement\MailingIndividual;

use App\IndividualEmail;
use Livewire\Component;

class HistoryMailingIndividualComponent extends Component
{
    public function render()
    {
        $emails=IndividualEmail::orderBy('send_date','desc')->get();
        return view('livewire.admin.commercial-management.mailing-individual.history-mailing-individual-component',[
            'emails'=>$emails
        ]);
    }
}
