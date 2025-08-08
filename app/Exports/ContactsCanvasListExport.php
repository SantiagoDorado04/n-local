<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class ContactsCanvasListExport implements FromView
{
    use Exportable;

    protected $contacts;
    protected $form;

    public function __construct($form, $contacts)
    {
        $this->contacts = $contacts;
        $this->form = $form;
    }

    public function view(): View
    {
        return view('exports.contactsCanvasList', [
            'contacts' => $this->contacts->get(),
            'form' => $this->form,
        ]);
    }
}
