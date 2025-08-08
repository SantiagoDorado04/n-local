<?php

namespace App\Http\Livewire\Contacts\MyOnlineRegistrationCourses;

use App\Contact;
use App\Models\OnlineRegistration;
use App\Models\OnlineRegistrationCertificationRegister;
use App\Models\OnlineRegistrationContactCourse;
use App\Models\OnlineRegistrationContactDocument;
use App\Models\OnlineRegistrationCourse;
use App\Models\OnlineRegistrationDocument;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use PhpOffice\PhpWord\TemplateProcessor;

class MyOnlineRegistrationCoursesComponent extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    public $description, $online_registration, $online_registration_category;
    public $searchName;
    public $courseId;
    public $courseDocumentNoRequired;
    public  $contactId;
    public  $contactCourse;
    public  $courseDocumentComplete;
    public  $findDocument;
    public  $existArchive = false;

    public  $embedVideo;
    public  $file, $registers;
    public  $certificate = false;

    public  $courseDocument = [];

    public function mount()
    {
        $user = Auth::user();
        $contact = Contact::where('user_id', '=', $user->id)->first();
        $this->contactId = $contact->id;
    }


    public function render()
    {
        $registrations = OnlineRegistrationContactCourse::where('contact_id', $this->contactId)
            ->when($this->searchName, function ($query, $searchName) {
                return $query->whereHas('onlineRegistrationCourse', function ($subQuery) use ($searchName) {
                    $subQuery->where('name', 'like', '%' . $searchName . '%');
                });
            })
            ->paginate(6);

        $firstItem = $registrations->firstItem();
        $lastItem = $registrations->lastItem();

        $paginationText = "Mostrando {$firstItem}-{$lastItem} de {$registrations->total()} registros";

        return view('livewire.contacts.my-online-registration-courses.my-online-registration-courses-component', [
            'registrations' => $registrations,
            'firstItem' => $firstItem,
            'lastItem' => $lastItem,
            'paginationText' => $paginationText,
        ]);
    }

    public function show($id)
    {
        $course = OnlineRegistrationCourse::findOrFail($id);
        $this->description = $course->description;
        $this->online_registration_category = $course->onlineRegistrationCategory->name;
        $this->online_registration = $course->onlineRegistrationCategory->onlineRegistration->name;
    }


    public function status($id)
    {
        $this->courseId = $id;
        $user = Auth::user();

        $this->courseDocument = OnlineRegistrationDocument::where('or_course_id', $id)
            ->where('type', 'I')
            ->where('required', true)
            ->get();

        $this->courseDocumentComplete = OnlineRegistrationDocument::where('or_course_id', $id)
            ->where('type', 'O')
            ->get();

        $this->courseDocumentNoRequired = OnlineRegistrationDocument::where('or_course_id', $id)
            ->where('type', 'I')
            ->where('required', false)
            ->get();

        //  dd($this->courseDocumentNoRequired);
        $this->contactCourse = OnlineRegistrationContactCourse::where('or_course_id', $id)
            ->where('contact_id', $this->contactId)
            ->first();

        $this->registers = OnlineRegistrationCertificationRegister::whereHas('document', function ($query) {
            $query->where('or_course_id', $this->courseId); // Filtra documentos que pertenezcan al curso
        })
            ->with('document') // Carga la relación con los documentos
            ->where('contact_id', $this->contactId) // Filtra por contacto
            ->orderBy('or_document_id') // Ordena por documento
            ->orderBy('last_download_date', 'desc') // Ordena por fecha de descarga descendente
            ->get()
            ->groupBy('or_document_id') // Agrupa por documento
            ->map(function ($group) {
                return $group->first(); // Toma solo el más reciente por grupo
            });

        // dd($this->registers);

        $this->certificate = $this->contactCourse->certificate;

        // Verificar para cada documento si ya fue enviado
        foreach ($this->courseDocument as $doc) {
            $exists = OnlineRegistrationContactDocument::where('or_course_id', $this->contactCourse->id)
                ->where('contact_id', $this->contactId)
                ->where('or_document_id', $doc->id)
                ->exists();

            // Le agregamos una propiedad temporal al objeto
            $doc->sent = $exists;
        }

        foreach ($this->courseDocumentNoRequired as $docNoRequired) {
            $exists = OnlineRegistrationContactDocument::where('or_course_id', $this->contactCourse->id)
                ->where('contact_id', $this->contactId)
                ->where('or_document_id', $docNoRequired->id)
                ->exists();

            // Le agregamos una propiedad temporal al objeto
            $docNoRequired->sent = $exists;
        }
        // Verificar para cada documento si ya fue enviado
        foreach ($this->courseDocument as $docs) {

            $this->existArchive = OnlineRegistrationContactDocument::where('contact_id', $this->contactId)
                ->where('or_course_id', $this->contactCourse->id)
                ->where('or_document_id', $docs->id)
                ->first();
            // Le agregamos una propiedad temporal al objeto
        }

        if ($this->file) {
            $originalFileName = $this->file->getClientOriginalName();
            $uniqueName = Str::uuid() . '_' . $originalFileName;
            $filePath = $this->file->storeAs('or-documents-files/courses-documents', $uniqueName);

            $this->courseDocumentNoRequired->url = $filePath; // solo guarda la ruta relativa
        }
    }

    public function upload_file($id)
    {
        $this->statusSend();
        $this->validate([
            'file' => 'required|file|max:10240',
        ], [
            'file.required' => 'Debe subir un archivo antes de enviarlo.',
            'file.file' => 'El archivo debe ser válido.',
            'file.max' => 'El archivo no debe superar los 10 MB.',
        ]);


        if (!$this->file) {
            session()->flash('error', 'Debe subir un archivo antes de enviarlo.');
            return;
        }
        /* if ($this->file) {
            return $this->statusSend();
        } */

        $originalFileName = $this->file->getClientOriginalName();
        $uniqueName = Str::uuid() . '_' . $originalFileName;
        $path = $this->file->storeAs('or-documents-files/contacts-documents', $uniqueName);

        OnlineRegistrationContactDocument::create([
            'url' => $path,
            'or_course_id' => $this->contactCourse->id,
            'contact_id' => $this->contactId,
            'or_document_id' => $id,
        ]);
        // 🔁 Actualizar la lista con el nuevo estado

        $this->status($this->contactCourse->or_course_id);

        session()->flash('message', 'Archivo subido exitosamente.');
    }

    public function status_video($id)
    {
        $document = OnlineRegistrationDocument::where('id', $id)->first();
        $this->embedVideo = $document->video_embebed;
    }


    public function cancel()
    {
        $this->resetInputFields();
        $this->emit('close-modal');
    }

    public function statusSend()
    {
        foreach ($this->courseDocumentNoRequired as $docNoRequired) {
            $exists = OnlineRegistrationContactDocument::where('or_course_id', $this->contactCourse->id)
                ->where('contact_id', $this->contactId)
                ->where('or_document_id', $docNoRequired->id)
                ->exists();

            // Le agregamos una propiedad temporal al objeto
            $docNoRequired->sent = $exists;
        }
        foreach ($this->courseDocument as $doc) {
            $exists = OnlineRegistrationContactDocument::where('or_course_id', $this->contactCourse->id)
                ->where('contact_id', $this->contactId)
                ->where('or_document_id', $doc->id)
                ->exists();
            // Le agregamos una propiedad temporal al objeto
            $doc->sent = $exists;
        }

        $this->registers = OnlineRegistrationCertificationRegister::whereHas('document', function ($query) {
            $query->where('or_course_id', $this->courseId); // Filtra documentos que pertenezcan al curso
        })
            ->with('document') // Carga la relación con los documentos
            ->where('contact_id', $this->contactId) // Filtra por contacto
            ->orderBy('or_document_id') // Ordena por documento
            ->orderBy('last_download_date', 'desc') // Ordena por fecha de descarga descendente
            ->get()
            ->groupBy('or_document_id') // Agrupa por documento
            ->map(function ($group) {
                return $group->first(); // Toma solo el más reciente por grupo
            });

        /*          $register = OnlineRegistrationCertificationRegister::where('or_document_id', $document->id)
            ->latest('id') // Obtiene el último registro por el campo 'id'
            ->first();

        if ($register) {
            // Si ya existe, aumentamos el contador
            OnlineRegistrationCertificationRegister::create([
                'last_download_date' => now(),
                'count_downloads' => $register->count_downloads + 1,
                'contact_id' => $contact->id,
                'or_document_id' => $document->id,
            ]);
        } else {
            // Si no existe, creamos un nuevo registro
            OnlineRegistrationCertificationRegister::create([
                'last_download_date' => now(),
                'count_downloads' => 1,
                'contact_id' => $contact->id,
                'or_document_id' => $document->id,
            ]);
        } */
    }

    public function cancel_2nd()
    {
        $this->statusSend();
        $this->emit('close-modal-2nd');
    }


    private function resetInputFields()
    {
        $this->description = '';
        $this->online_registration_category = '';
        $this->online_registration = '';
    }

    public function generateDocumentFromContact(Contact $contact, OnlineRegistrationDocument $document)
    {
        $templatePath = storage_path('app/' . $document->url);

        if (!file_exists($templatePath)) {
            $this->emit('alert', ['type' => 'error', 'message' => 'No se encontró el archivo base.']);
            return;
        }

        $extension = pathinfo($document->url, PATHINFO_EXTENSION);

        if (strtolower($extension) !== 'docx') {
            return response()->download($templatePath);
        }

        try {
            $templateProcessor = new TemplateProcessor($templatePath);
            $templateVars = $templateProcessor->getVariables();

            $contactFields = $contact->getFillable();

            foreach ($templateVars as $var) {
                if (in_array($var, $contactFields)) {
                    $templateProcessor->setValue($var, $contact->$var ?? '');
                } else {
                    $templateProcessor->setValue($var, '');
                }
            }

            $fileName = 'documento_' . Str::slug($contact->name) . '.docx';
            $tempFilePath = tempnam(sys_get_temp_dir(), 'word_') . '.docx';
            $templateProcessor->saveAs($tempFilePath);

            $register = OnlineRegistrationCertificationRegister::where('or_document_id', $document->id)
                ->latest('id') // Obtiene el último registro por el campo 'id'
                ->first();

            if ($register) {
                // Si ya existe, aumentamos el contador
                OnlineRegistrationCertificationRegister::create([
                    'last_download_date' => now(),
                    'count_downloads' => $register->count_downloads + 1,
                    'contact_id' => $contact->id,
                    'or_document_id' => $document->id,
                ]);
            } else {
                // Si no existe, creamos un nuevo registro
                OnlineRegistrationCertificationRegister::create([
                    'last_download_date' => now(),
                    'count_downloads' => 1,
                    'contact_id' => $contact->id,
                    'or_document_id' => $document->id,
                ]);
            }

            $this->statusSend();

            return response()->download($tempFilePath, $fileName)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            $this->emit('alert', [
                'type' => 'error',
                'message' => 'Error al generar el documento: ' . $e->getMessage()
            ]);
        }

        // Registra la información en la tabla or_certifications_register

    }
    public function downloadDocument($url)
    {
            $filePath = storage_path('app/' . $url);
            return response()->download($filePath);

    }
}
