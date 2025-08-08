<?php

namespace App\Exports;

use App\Contact;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class ContactsExport implements FromCollection, WithHeadings,ShouldAutoSize
{
    use Exportable;

    protected $contacts;

    public function __construct($contacts = null)
    {
        $this->contacts = $contacts;
    }


    public function collection()
    {
        $this->contacts->transform(function ($i) {
            unset($i->id);
            unset($i->form_action_id);
            unset($i->created_at);
            unset($i->updated_at);
            unset($i->deleted_at);
            return $i;
        });

    }

    public function headings(): array
    {
        return [
            'Razón social',
            'NIT',
            'Teléfono',
            'Correo electrónico',
            'WhatsApp',
            'Página web',
            'Nombre persona de contacto',
            'Calificación Oportunidad',
            'Medio de almacenamiento',
            'Fecha de registro',
            'Terreno Comercial',
            'Estrategia Comercial',
            'Acción Comercial',
            'Formulario Widget'
        ];
    }
}
