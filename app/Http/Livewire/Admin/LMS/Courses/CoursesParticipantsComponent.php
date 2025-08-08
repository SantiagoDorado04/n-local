<?php

namespace App\Http\Livewire\Admin\LMS\Courses;

use App\Contact;
use App\Models\Course;
use App\ContactsCourse;
use Livewire\Component;
use Livewire\WithPagination;
use App\ContactsPointsDetail;
use App\Models\ContactsStage;

class CoursesParticipantsComponent extends Component
{

    use WithPagination;

    protected $paginationTheme = 'simple-bootstrap';

    public $searchName;
    public $courseId;
    public $feedback;

    public function mount($id)
    {
        $this->courseId = $id;
    }


    public function render()
    {
        $course = Course::find($this->courseId);
        $coursesContacts = ContactsCourse::where('course_id', '=', $this->courseId)->get();
        $query = ContactsStage::with('contact')
            ->where('stage_id', $course->step->stage_id);

        if ($this->searchName) {
            $query->whereHas('contact', function ($q) {
                $q->where('name', 'like', '%' . $this->searchName . '%')
                    ->orWhere('email', 'like', '%' . $this->searchName . '%')
                    ->orWhere('nit', 'like', '%' . $this->searchName . '%');
            });
        }

        $contactsStage = $query->paginate(25);



        return view('livewire.admin.l-m-s.courses.courses-participants-component', [
            'course' => $course,
            'coursesContacts' => $coursesContacts,
            'contactsStage' => $contactsStage
        ]);
    }

    // public function toggleApprovalForm($id)
    // {
    //     $contactForm = ContactsInformationForm::findOrFail($id);

    //     $form = InformationForm::find($this->formId);
    //     $contactDetail = Contact::find($contactForm->contact_id);

    //     //Update approved form
    //     $contactForm->update(['approved' => !$contactForm->approved]);

    //     if ($contactForm->approved) {

    //         //Add Points
    //         $contactDetail->points = $contactDetail->points + $form->points;
    //         $contactDetail->update();

    //         //Add Detail Points
    //         $detail = new ContactsPointsDetail();
    //         $detail->detail = 'Se te han asignado +' . $form->points . ' por el registro del formulario "' . $form->name . '"';
    //         $detail->points = $form->points;
    //         $detail->date = date('Y-m-d H:i:s');
    //         $detail->contact_id = $contactDetail->id;
    //         $detail->save();

    //         //Congratulations
    //         $contact = Contact::find($contactDetail->id);
    //         $content = $form->congratulation_message;

    //         switch ($form->reminder_message_mean) {
    //             case 'email':
    //                 NewSendEmailJob::dispatch($contact->email, 'Registro formulario', $content);
    //                 break;
    //             case 'whatsapp':
    //                 WaOfiJob::dispatch('+57' . $contact->phone, $content);
    //                 break;
    //             case 'sms':
    //                 SendSmsUser::dispatch('+57' . $contact->phone, $content);
    //                 break;
    //             default:
    //                 break;
    //         }

    //         $this->emit('alert', ['type' => 'success', 'message' => 'Formulario revisado']);
    //     } else {

    //         $this->emit('alert', ['type' => 'error', 'message' => 'Formulario no aprobado']);

    //         $contactDetail->points = $contactDetail->points - $form->points;
    //         $contactDetail->update();
    //     }
    // }


    public function toggleApproval($contactId)
    {
        $course = Course::find($this->courseId);
        $contact = ContactsCourse::findOrFail($contactId);
        $contact->update(['approved' => !$contact->approved]);
        $contactDetail = Contact::find($contact->contact_id);

        if ($contact->approved) {

            $contactDetail->points = $contactDetail->points + $course->points;
            $contactDetail->update();

            //Add Detail Points
            $detail = new ContactsPointsDetail();
            $detail->detail = 'Se te han asignado +' . $course->points . ' por aprobar el curso: "' . $course->name . '"';
            $detail->points = $course->points;
            $detail->date = date('Y-m-d H:i:s');
            $detail->contact_id = $contactDetail->id;
            $detail->save();

            $this->emit('alert', ['type' => 'success', 'message' => 'Curso aprobado']);
        } else {

            $this->emit('alert', ['type' => 'error', 'message' => 'Curso no aprobado']);

            $contactDetail->points = $contactDetail->points - $course->points;
            $contactDetail->update();
        }
    }

    public function feedback($id)
    {
        $contact = ContactsCourse::findOrFail($id);
        $this->feedback = $contact->feedback;

        $this->courseId = $contact->id;
    }

    public function storeFeedback()
    {

        $this->validate([
            'feedback' => 'required',
        ]);

        $contact = ContactsCourse::findOrFail($this->courseId);
        $contact->feedback =  $this->feedback;
        $contact->update();

        $this->emit('alert', ['type' => 'success', 'message' => 'Feedback agregado correctamente']);
        $this->cancel();
    }

    public function resetInputFields()
    {
        $this->feedback = '';
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }
}
