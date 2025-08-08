<?php

namespace App\Models\Traits\OrActionsTraits;

use App\Jobs\OrSendApiRequestJob;
use App\Models\OrCourseComunication;
use App\Jobs\WAsender;

trait OrSessionAttendeeTrait
{
    public static function bootOrSessionAttendeeTrait()
    {
        static::created(function ($model) {
            $session = $model->onlineRegistrationCourseSession;

            if (!$session) {
                return;
            }

            $course = $session->onlineRegistrationCourse;

            if (!$course) {
                return;
            }

            $comunication = OrCourseComunication::where('action', 'SA') // SA = Sesión Asistencia
                ->where('or_course_id', $course->id)
                ->first();

            if (!$comunication) {

                return;
            }

            $channel = $comunication->onlineRegistrationChannel;

            if (!$channel) {
                return;
            }

            $structure = json_decode($channel->structure, true);

            if (isset($structure['body']['text'])) {
                $sessionName = $session->name ?? 'Sin nombre de sesión';
                $courseName = $course->name ?? 'Sin nombre de curso';
                $structure['body']['text'] = $structure['body']['text'] . "\nNueva asistencia registrada al curso: $courseName | sesión: $sessionName\n";
                // Convertimos de nuevo a JSON para dejarlo actualizado
                $channel->structure = json_encode($structure);
            }

            if (self::validateStructureMatch($channel->structure, $comunication->message)) {
                OrSendApiRequestJob::dispatch($model, $comunication, $channel, $structure)->onQueue('wa');
            }
        });
    }

    protected static function validateStructureMatch($structureJson, $messageJson)
    {
        $structure = is_array($structureJson) ? $structureJson : json_decode($structureJson, true);
        $message = is_array($messageJson) ? $messageJson : json_decode($messageJson, true);

        if (!$structure || !$message) return false;

        foreach ($structure['body'] ?? [] as $key => $val) {
            if (!array_key_exists($key, $message['body'] ?? [])) return false;
        }
        foreach ($structure['headers'] ?? [] as $key => $val) {
            if (!array_key_exists($key, $message['headers'] ?? [])) return false;
        }

        return true;
    }
}
