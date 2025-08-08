<?php

namespace App\Http\Livewire\Contacts\MyOnlineRegistrationCourses\OrMyCourseSessions;

use App\Contact;
use App\Models\OnlineRegistrationCourse;
use App\Models\OnlineRegistrationCourseSession;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class OrMyCourseSessionsComponent extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $name, $description, $start_date, $end_date;

    public $course_id, $course,$courseId;

    public $contactId;

    public $searchName;

    public function mount($id)
    {
        $this->course_id = $id;
        $user = Auth::user();
        $contact = Contact::where('user_id', '=', $user->id)->first();
        $this->contactId = $contact->id;
        $course = OnlineRegistrationCourse::find($id);
        $this->courseId = $course;
    }

    public function render()
    {

        $sessions = OnlineRegistrationCourseSession::where('or_course_id', $this->course_id)
            ->when($this->searchName, function ($query, $searchName) {
                return $query->where('name', 'like', '%' . $searchName . '%');
            })->paginate(6);


        $firstItem = $sessions->firstItem();
        $lastItem = $sessions->lastItem();

        $paginationText = "Mostrando {$firstItem}-{$lastItem} de {$sessions->total()} registros";

        return view('livewire.contacts.my-online-registration-courses.or-my-course-sessions.or-my-course-sessions-component', [
            'sessions' => $sessions,
            'firstItem' => $firstItem,
            'lastItem' => $lastItem,
            'paginationText' => $paginationText,
        ]);
    }

    public function show($id)
    {
        $session = OnlineRegistrationCourseSession::findOrFail($id);
        $this->name = $session->name;
        $this->description = $session->description;
        $this->start_date = $session->start_date;
        $this->end_date = $session->end_date;
        $this->course = $session->onlineRegistrationCourse->name;
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->emit('close-modal');
    }

    private function resetInputFields()
    {
        $this->description = '';
        $this->name = '';
        $this->start_date = '';
        $this->end_date = '';
    }
}
