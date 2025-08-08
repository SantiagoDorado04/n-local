<?php

namespace App\Http\Livewire\Admin\OnlineRegistrationCourses;

use App\Contact;
use App\Models\OnlineRegistrationContactCourse;
use App\Models\OnlineRegistrationContactDocument;
use App\Models\OnlineRegistrationCourse;
use App\Models\OnlineRegistrationCourseSession;
use App\Models\OnlineRegistrationDocument;
use App\Models\OnlineRegistrationSessionAttendee;
use Livewire\Component;
use Livewire\WithPagination;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Str;

class OnlineRegistrationCoursesCertificateComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $course_id;
    public $onlineRegistrationCourse;
    protected $contactsCourse;
    public $userAssistance;
    public $attendancePercentage;
    public $sessions;
    public $totalSessions;
    public $contactsStats;
    public $searchName = '';


    public function mount($id)
    {
        $this->course_id = $id;
        $this->onlineRegistrationCourse = OnlineRegistrationCourse::find($this->course_id);
        $this->sessions = OnlineRegistrationCourseSession::where('or_course_id', $this->course_id)->pluck('id');
        $this->totalSessions = $this->sessions->count();
    }

    public function render()
    {
        $query = OnlineRegistrationContactCourse::where('or_course_id', $this->course_id);

        if (!empty($this->searchName)) {
            $query->whereHas('contact', function ($q) {
                $q->where('name', 'like', '%' . $this->searchName . '%')
                    ->orWhere('email', 'like', '%' . $this->searchName . '%')
                    ->orWhere('nit', 'like', '%' . $this->searchName . '%');
            });
        }

        $this->contactsCourse = $query->paginate(25);

        $this->contactsStats = [];

        foreach ($this->contactsCourse as $contact) {
            $contactId = $contact->contact_id;

            $contactsAttendees = OnlineRegistrationSessionAttendee::whereIn('session_id', $this->sessions)
                ->where('contact_id', $contactId)
                ->count();

            $percentage = $this->totalSessions > 0
                ? ($contactsAttendees / $this->totalSessions) * 100
                : 0;

            $submittedDocuments = OnlineRegistrationContactDocument::where('contact_id', $contactId)
                ->whereHas('document', function ($query) {
                    $query->where('type', 'I');
                })
                ->get()
                ->keyBy('or_document_id'); // indexamos por el ID del documento para acceso rápido

            $certificate = $contact->certificate;

            $this->contactsStats[] = [
                'contact' => $contact,
                'assistance_count' => $contactsAttendees,
                'percentage' => $percentage,
                'certificate' => $certificate,
                'submitted_documents' => $submittedDocuments,
            ];
        }
        // Obtener los documentos requeridos para el curso
        $requiredDocuments = OnlineRegistrationDocument::where('or_course_id', $this->course_id)
            ->where('type', 'I') // Solo documentos de tipo ingreso
            ->get();

        $outputDocuments = OnlineRegistrationDocument::where('or_course_id', $this->course_id)
            ->where('type', 'O')
            ->get();

        return view('livewire.admin.online-registration-courses.online-registration-courses-certificate-component', [
            'contactsCourse' => $this->contactsCourse,
            'requiredDocuments' => $requiredDocuments,
            'outputDocuments' => $outputDocuments,
        ]);
    }

    public function toggleApproval($id)
    {
        $contactCourse = OnlineRegistrationContactCourse::findOrFail($id);
        $contactCourse->update(['certificate' => !$contactCourse->certificate]);

        $message = $contactCourse->certificate ? 'Certificacion aprobada' : 'Certificacion no aprobada';
        $this->emit('alert', ['type' => $contactCourse->certificate ? 'success' : 'error', 'message' => $message]);
    }

    public function generateDocumentFromContact(Contact $contact, OnlineRegistrationDocument $document)
    {
        $templatePath = storage_path('app/public/' . $document->url);

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

            return response()->download($tempFilePath, $fileName)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            $this->emit('alert', [
                'type' => 'error',
                'message' => 'Error al generar el documento: ' . $e->getMessage()
            ]);
        }
    }
}
