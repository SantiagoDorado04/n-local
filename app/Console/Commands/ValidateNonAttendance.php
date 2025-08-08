<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\OnlineRegistrationCourseSession;
use App\Models\OnlineRegistrationSessionAttendee;
use App\Models\OnlineRegistrationContactCourse;
use Carbon\Carbon;

class ValidateNonAttendance extends Command
{
    protected $signature = 'sessions:validate-non-attendance';

    protected $description = 'Valida asistencia a sesiones finalizadas hoy y ejecuta acciones si no asistieron';

    public function handle()
    {
        $today = Carbon::now()->toDateString();

        $sessions = OnlineRegistrationCourseSession::whereDate('end_date', $today)->get();

        if (!$sessions->isEmpty()) {
            foreach ($sessions as $session) {
                $course = $session->onlineRegistrationCourse;

                $registeredContacts = $course->onlineRegistrationContactsCourses()->pluck('contact_id');

                $attendedContacts = $session->sesionAttendees()->pluck('contact_id');

                $nonAttendees = $registeredContacts->diff($attendedContacts);

                if ($session->non_attendance_message && $nonAttendees->isNotEmpty()) {
                    foreach ($nonAttendees as $contactId) {
                    }
                }
            }
        }
    }
}