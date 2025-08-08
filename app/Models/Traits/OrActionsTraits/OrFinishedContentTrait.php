<?php

namespace App\Models\Traits\OrActionsTraits;

use App\Jobs\OrSendApiRequestJob;
use App\Models\OrCourseComunication;

trait OrFinishedContentTrait
{
    public static function bootOrFinishedContentTrait()
    {
        static::created(function ($model) {
            $comunication = OrCourseComunication::where('action', 'FC') // Finished Content
                ->where('or_course_id', $model->or_course_id)
                ->first();

            if (empty($comunication)) {
                return;
            } else {
                $channel = $comunication->onlineRegistrationChannel;
            }

            if ($channel) {
                $structure = json_decode($channel->structure, true);

                // Asegurar que existen los campos
                if (isset($structure['body']['text'])) {
                    $courseName = $model->course->name ?? 'Sin nombre del curso';
                    $session = $model->course->onlineRegistrationCourseSessions->first();
                    $sessionName = $session ? $session->name : 'Sin sesión';

                    $structure['body']['text'] = "Curos: $courseName | Sesión: $sessionName\n" . $structure['body']['text'];

                    $channel->structure = json_encode($structure);
                }
            }

            if ($comunication) {
                $channel = $comunication->onlineRegistrationChannel;

                if ($channel && self::validateStructureMatch($channel->structure, $comunication->message)) {
                    OrSendApiRequestJob::dispatch($model, $comunication, $channel, $structure);
                } else {
                }
            }
        });
    }

    protected static function validateStructureMatch($structureJson, $messageJson)
    {
        $structure = json_decode($structureJson, true);
        $message = json_decode($messageJson, true);

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
