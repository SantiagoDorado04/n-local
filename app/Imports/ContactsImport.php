<?php

namespace App\Imports;

use App\Contact;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;


class ContactsImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    use Importable;

    private $rows = 0;

    public function model(array $row)
    {
        
        return new Contact([
            "name" => $row['nombre'],
            "nit" => $row['nit'],
            "phone" => $row['telefono'],
            "email" => $row['correo'],
            "whatsapp" => $row['whatsapp'],
            "website" => $row['web'],
            "contact_person_name" => $row['contacto'],
            "form_action_id" => $row['formulario'],
            "storage" => "excel"
        ]);

        $this->rows=$this->rows+1;

    }

    public function rules(): array
    {
        return [
            'nombre' => 'required',
            "nit" => 'required',
            "telefono" => 'required',
            "correo" => 'required',
            "whatsapp" => 'required',
            "web" => 'required',
            "contacto" => 'required'
        ];
    }
    public function getRowCount(): int
    {
        return $this->rows;
    }
}
