<?php

namespace App\Imports;

use App\Contact;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\ContactsStage;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class PostulatesImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    use Importable;

    private $rows = 0;
    private $stageId;
    private $approved = 1;

    public function __construct($stageId)
    {
        $this->stageId = $stageId;
    }

    public function model(array $row)
    {
        $nit = trim($row['nit']);

        $existingContact = Contact::where('nit', $nit)->first();

        if ($existingContact) {
            $existingContactStage = ContactsStage::where('contact_id', $existingContact->id)
                ->where('stage_id', $this->stageId)
                ->first();

            if (!$existingContactStage) {
                $contactsStage = new ContactsStage([
                    'contact_id' => $existingContact->id,
                    'stage_id' => $this->stageId,
                    'approved' => $this->approved,
                ]);
                $contactsStage->save();
            }
        } else {
            $user = new User([
                'name' => $row['nombre'],
                'email' => $row['correo'],
                'password' => Hash::make($nit),
                'role_id' => '7',
            ]);
            $user->save();

            $contact = new Contact([
                "name" => $row['nombre'],
                "nit" => $nit,
                "phone" => $row['telefono'],
                "email" => $row['correo'],
                "whatsapp" => $row['whatsapp'],
                "website" => $row['web'],
                "contact_person_name" => $row['contacto'],
                "user_id" => $user->id,
                "storage" => "excel"
            ]);
            $contact->save();

            $contactsStage = new ContactsStage([
                'contact_id' => $contact->id,
                'stage_id' => $this->stageId,
                'approved' => $this->approved,
            ]);
            $contactsStage->save();
        }

        $this->rows += 1;

        return $existingContact ?? $contact;
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required',
            "nit" => 'required',
            "telefono" => 'required',
            "correo" => 'required',
            "whatsapp" => 'required',
            "web" => 'nullable',
            "contacto" => 'required'
        ];
    }

    public function getRowCount(): int
    {
        return $this->rows;
    }
}
