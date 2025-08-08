<?php

namespace App\Http\Livewire\Admin\OnlineRegistrationCourses\Attendees;

use App\Models\OnlineRegistrationContactCourse;
use App\Models\OnlineRegistrationCourse;
use App\Models\OnlineRegistrationSessionAttendee;
use Livewire\Component;

class OnlineRegistrationCoursesAttendeesComponent extends Component
{
    public $course, $or_course_id;
    public $attendances = []; // Array para almacenar los checkboxes seleccionados

    public $searchName;

    public function mount($id)
    {
        $this->or_course_id = $id;
        $this->course = OnlineRegistrationCourse::where('id', $this->or_course_id)->firstOrFail();


        // Cargar asistencias existentes en el array
        $this->loadAttendances();
    }

    // public function loadAttendances()
    // {
    //     $this->attendances = OnlineRegistrationSessionAttendee::whereIn(
    //         'contact_id', // Filtramos por contact_id en lugar de contact_course_id
    //         OnlineRegistrationContactCourse::where('or_course_id', $this->or_course_id)->pluck('contact_id')
    //     )->pluck('session_id', 'contact_id')->toArray();
    // }


    // public function toggleAttendance($contactCourseId, $sessionId)
    // {
    //     $attendance = OnlineRegistrationSessionAttendee::where([
    //         'contact_id' => $contactCourseId,
    //         'session_id' => $sessionId
    //     ])->first();

    //     if ($attendance) {
    //         // Si existe, eliminarlo
    //         $attendance->delete();
    //         $this->emit('alert', ['type' => 'error', 'message' => 'Asistencia eliminada correctamente.']);
    //     } else {
    //         // Si no existe, crearlo
    //         OnlineRegistrationSessionAttendee::create([
    //             'contact_id' => $contactCourseId,
    //             'session_id' => $sessionId,
    //             'attended' => 1,
    //         ]);
    //         $this->emit('alert', ['type' => 'success', 'message' => 'Asistencia registrada correctamente']);
    //     }

    //     // Recargar asistencias para reflejar cambios en la vista
    //     $this->loadAttendances();
    // }



    public function loadAttendances()
    {
        // Obtener asistencias existentes en la base de datos
        $attendances = OnlineRegistrationSessionAttendee::whereIn(
            'contact_id',
            OnlineRegistrationContactCourse::where('or_course_id', $this->or_course_id)->pluck('contact_id')
        )->get();

        // Reiniciar el array para evitar datos obsoletos
        $this->attendances = [];

        foreach ($attendances as $attendance) {
            $contactId = (int) $attendance->contact_id;
            $sessionId = (int) $attendance->session_id; // Asegurarse de usar 'session_id' correctamente

            if (!isset($this->attendances[$contactId])) {
                $this->attendances[$contactId] = [];
            }

            // Corregido: usar el session_id como clave en lugar de '0'
            $this->attendances[$contactId][$sessionId] = true;
        }

        // Depuración: Verificar estructura final
    }



    public function saveAttendances()
    {
        // Recorrer todas las asistencias marcadas en la vista
        foreach ($this->attendances as $contact_id => $sessions) {
            foreach ($sessions as $session_id => $attended) {
                // Validar que $session_id no sea null ni vacío
                if (empty($session_id) || !is_numeric($session_id)) {
                    continue; // Saltar valores inválidos
                }

                if ($attended) {
                    // Si está marcado, actualizar o crear el registro con 'attended' = true
                    OnlineRegistrationSessionAttendee::updateOrCreate([
                        'contact_id' => $contact_id,
                        'session_id' => $session_id,
                    ], [
                        'attended' => true,
                    ]);
                } else {
                    // Si está desmarcado, eliminar el registro de la base de datos
                    OnlineRegistrationSessionAttendee::where([
                        'contact_id' => $contact_id,
                        'session_id' => $session_id,
                    ])->delete();
                }
            }
        }

        // Recargar los datos para reflejar los cambios en la vista
        $this->loadAttendances();

        // Mensaje de confirmación
        $this->emit('alert', ['type' => 'success', 'message' => 'Asistencias actualizadas correctamente']);
    }



    public function render()
    {
        $query = OnlineRegistrationContactCourse::with([
            'contact',
            'onlineRegistrationCourse.onlineRegistrationCourseSessions',
            'onlineRegistrationSessionAttendees'
        ])->where('or_course_id', $this->or_course_id);

        if ($this->searchName) {
            $query->whereHas('contact', function ($q) {
                $q->where('name', 'like', '%' . $this->searchName . '%')
                    ->orWhere('nit', 'like', '%' . $this->searchName . '%');
            });
        }

        $onlineRegistrationContactsCourse = $query->get(); // O usa ->paginate(10)

        return view('livewire.admin.online-registration-courses.attendees.online-registration-courses-attendees-component', [
            'ContactsCourse' => $onlineRegistrationContactsCourse,
            'course' => $this->course,
            'sessions' => $this->course->onlineRegistrationCourseSessions,
        ]);
    }
}
