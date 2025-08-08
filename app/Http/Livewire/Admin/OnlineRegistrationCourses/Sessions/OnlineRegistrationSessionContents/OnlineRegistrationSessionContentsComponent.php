<?php

namespace App\Http\Livewire\Admin\OnlineRegistrationCourses\Sessions\OnlineRegistrationSessionContents;

use App\Models\OnlineRegistrationCourse;
use App\Models\OnlineRegistrationCourseSession;
use App\Models\OnlineRegistrationLessonContent;
use App\Models\OnlineRegistrationSessionContent;
use App\Models\OnlineRegistrationSlideContent;
use App\Models\OnlineRegistrationTestContent;
use App\Models\OnlineRegistrationVideoContent;
use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;

class OnlineRegistrationSessionContentsComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $session_id;
    public $onlineRegistrationCourseSession;
    public $onlineRegistrationCourse;
    public $online_registration_session_contents_id;
    public $content;
    public $title, $description, $type, $step;
    public $searchName;
    public $user_created_at;
    public $user_updated_at;

    public $sessions_contents;


    public function mount($id)
    {
        $this->session_id = $id;
        $this->onlineRegistrationCourseSession = OnlineRegistrationCourseSession::find($this->session_id);
        $this->onlineRegistrationCourse = OnlineRegistrationCourse::find($this->onlineRegistrationCourseSession)
            ->first();
    }
    public function render()
    {
        $contents = OnlineRegistrationSessionContent::when($this->searchName, function ($query, $searchName) {
            return $query->where('title', 'like', '%' . $searchName . '%');
        })
            ->where('session_id', '=', $this->session_id)
            ->orderBy('step', 'asc')
            ->paginate(6);
        $firstItem = $contents->firstItem();
        $lastItem = $contents->lastItem();
        $paginationText = "Mostrando {$firstItem}-{$lastItem} de {$contents->total()} registros";

        return view('livewire.admin.online-registration-courses.sessions.online-registration-session-contents.online-registration-session-contents-component', [

            'contents' => $contents,
            'paginationText' => $paginationText,
        ]);
    }
    public function show($id)
    {

        $this->online_registration_session_contents_id = $id;
        $contents = OnlineRegistrationSessionContent::find($id);
        $this->title = $contents->title;
        $this->description = $contents->description;
        $this->type = $contents->type;
        $this->step = $contents->step;
        $userCreate = User::find($contents->user_created_at);
        $this->user_created_at = $userCreate ? $userCreate->name : 'Sin creador';
        $userUpdate = User::find($contents->user_updated_at);
        $this->user_updated_at = $userUpdate ? $userUpdate->name : 'Sin modificación';
    }

    public function delete($id)
    {
        $this->sessions_contents = $id;
    }

    public function destroy()
    {
        $type = $onlineRegistrationsSessionsContents = OnlineRegistrationSessionContent::find($this->sessions_contents)->type;
        $onlineRegistrationsSessionsContents = OnlineRegistrationSessionContent::find($this->sessions_contents);

        if ($type) {
            switch ($type) {
                case 'L':
                    $lessonContent = OnlineRegistrationLessonContent::where('content_id', $this->sessions_contents)->first();
                    $lessonContent->delete();
                    break;
                case 'S':
                    $slideContent = OnlineRegistrationSlideContent::where('content_id', $this->sessions_contents)->first();
                    if ($slideContent && $slideContent->banner_image) {
                        $filePath = 'public/' . $slideContent->banner_image;
                        if (Storage::exists($filePath)) {
                            Storage::delete($filePath);
                        }
                    }
                    $slideContent->delete();
                    break;
                case 'V':
                    $videoContent = OnlineRegistrationVideoContent::where('content_id', $this->sessions_contents)->first();
                    $videoContent->delete();
                    break;
                case 'T':
                    $testContent = OnlineRegistrationTestContent::where('content_id', $this->sessions_contents)->first();
                    $testContent->delete();
                    break;
                default:
                    $this->emit('alert', ['type' => 'warning', 'message' => 'No se borro correctamente']);
            }
        } else {
            $this->emit('alert', ['type' => 'warning', 'message' => 'No se encontro el contenido']);
        }
        $onlineRegistrationsSessionsContents->delete();
        $this->emit('alert', ['type' => 'success', 'message' => 'Sesion del curso eliminada correctamente']);
        $this->cancel();
    }

    public function resetInputFields()
    {
        $this->title = '';
        $this->description = '';
        $this->online_registration_session_contents_id = '';
        $this->user_created_at = '';
        $this->user_updated_at = '';
    }
    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('close-modal');
    }

    public function updateOrder($order)
    {
        //  dd($order);
        foreach ($order as $index => $id) {
            $step = OnlineRegistrationSessionContent::find($id);
            if ($step) {
                // dd($step);
                $step->step = $index + 1;
                $step->save();
            }
        }

        $this->emit('orderUpdated');
    }
}
