<?php

namespace App\Console\Commands;

use App\Jobs\OrSendApiRequestJob;
use App\Models\OnlineRegistrationCourseSession;
use App\Models\OrCourseComunication;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class SendSessionReminders extends Command
{
    protected $signature = 'sessions:send-reminders';
    protected $description = 'Enviar recordatorios a los asistentes de las sesiones de hoy';


    public function handle(): void
    {
        $tomorrow = Carbon::tomorrow()->startOfDay();
        $endTomorrow = Carbon::tomorrow()->endOfDay();

        $sessions = OnlineRegistrationCourseSession::with('onlineRegistrationCourse.onlineRegistrationContactsCourses.contact')
            ->whereBetween('start_date', [$tomorrow, $endTomorrow])
            ->get();

        foreach ($sessions as $session) {
            $course = $session->onlineRegistrationCourse;

            if (!$course) continue;

            $comunication = OrCourseComunication::where('action', 'AR') // Attendance Reminder
                ->where('or_course_id', $course->id)
                ->first();

            $channel = $comunication->onlineRegistrationChannel;

            $structure = json_decode($channel->structure, true);

            if (isset($structure['body']['text'])) {
                $sessionName = $session->name ?? 'Sin nombre de sesión';
                $courseName = $course->name ?? 'Sin nombre de curso';

                $startDateFormatted = Carbon::parse($session->start_date)
                    ->locale('es')
                    ->isoFormat('D [de] MMMM [del] YYYY [a las] h:mm A');

                $structure['body']['text'] .= "\nRecordatorio: curso \"$courseName\" - sesión \"$sessionName\" el $startDateFormatted.\n";
            }


            // Aquí usamos directamente los registrados (contactCourses)
            $contactCourses = $course->onlineRegistrationContactsCourses()->with('contact')->get();

            foreach ($contactCourses as $contactCourse) {

                dispatch(new OrSendApiRequestJob(
                    $contactCourse,
                    $comunication,
                    $channel,
                    $structure
                ));
            }
        }
    }
}
