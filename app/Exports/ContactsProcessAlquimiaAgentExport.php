<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class ContactsProcessAlquimiaAgentExport implements FromView
{

    use Exportable;

    protected $contacts;
    protected $agent;

    public function __construct($agent = null, $contacts = null)
    {
        $this->contacts = $contacts;
        $this->agent = $agent;
    }

    public function view(): View
    {
        return view('exports.contactsProcessAlquimiaAgentList', [
            'contacts' => $this->contacts->get(),
            'form' => $this->agent,
        ]);
    }
}
