<?php

namespace App\Models\Traits\OrActionsTraits;

use App\Jobs\OrSendApiRequestJob;
use App\Jobs\WAsender;
use App\Models\OrCourseComunication;

trait OrAssignedCharacterizationTrait
{
    public static function bootOrAssignedCharacterizationTrait()
    {
        static::created(function ($model) {
            $comunication = OrCourseComunication::where('action', 'AC') //Abreviacion finished Content
                ->where('or_course_id', $model->characterization->session->onlineRegistrationCourse->id)
                ->first();

            if ($comunication) {
                $channel = $comunication->onlineRegistrationChannel;

                if ($channel) {
                    $structure = json_decode($channel->structure, true);

                    // Asegurar que existen los campos
                    if (isset($structure['body']['text'])) {
                        $characterizationName = $model->characterization->name ?? 'Sin nombre';
                        $sessionName = $model->characterization->session->name ?? 'Sin sesión';
                        $structure['body']['text'] = "Caracterización: $characterizationName | Sesión: $sessionName\n" . $structure['body']['text'];

                        $channel->structure = json_encode($structure);
                    }
                }

                if ($channel && self::validateStructureMatch($channel->structure, $comunication->message)) {
                    // Paso nuevo: enviar la estructura modificada
                    OrSendApiRequestJob::dispatch($model, $comunication, $channel, $structure);
                }else{
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
