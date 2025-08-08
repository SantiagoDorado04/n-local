<?php

namespace App\Models\Traits\OrActionsTraits;

use App\Jobs\OrSendApiRequestJob;
use App\Models\OrCourseComunication;
use App\Jobs\WAsender;

trait OrRegisterContactCourseTrait
{
    public static function bootOrRegisterContactCourseTrait()
    {
        static::created(function ($model) {
            $comunication = OrCourseComunication::where('action', 'CR') //Abreviacion Course Registration
                ->where('or_course_id', $model->or_course_id)
                ->first();

            if ($comunication) {
                $channel = $comunication->onlineRegistrationChannel;

                if ($channel) {
                    $structure = json_decode($channel->structure, true);

                    // Asegurar que existen los campos
                    if (isset($structure['body']['text'])) {
                        $courseName = $model->onlineRegistrationCourse->name ?? 'Sin nombre';
                        $proccesName = $model->onlineRegistrationCourse->onlineRegistrationCategory->onlineRegistration->name ?? 'Sin sesión';
                        $structure['body']['text'] = "Nueva inscripción al curso: $courseName del proceso: $proccesName\n" . $structure['body']['text'];

                        $channel->structure = json_encode($structure);
                    }
                }

                if ($comunication) {
                    $channel = $comunication->onlineRegistrationChannel;

                    if ($channel && self::validateStructureMatch($channel->structure, $comunication->message)) {
                        OrSendApiRequestJob::dispatch($model, $comunication, $channel, $structure);
                    }
                }
            }
        });
    }

    protected static function validateStructureMatch($structureJson, $messageJson)
    {
        $structure = json_decode($structureJson, true);
        $message = json_decode($messageJson, true);

        if (!$structure || !$message) return false;

        // Verificar que el mensaje tenga todas las claves del structure
        foreach ($structure['body'] ?? [] as $key => $val) {
            if (!array_key_exists($key, $message['body'] ?? [])) return false;
        }
        foreach ($structure['headers'] ?? [] as $key => $val) {
            if (!array_key_exists($key, $message['headers'] ?? [])) return false;
        }

        return true;
    }
}