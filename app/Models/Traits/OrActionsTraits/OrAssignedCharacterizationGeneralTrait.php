<?php

namespace App\Models\Traits\OrActionsTraits;

use App\Models\OnlineRegistrationCourseSession;
use App\Models\OnlineRegistrationCharacterization;
use App\Models\OrAssignedCharacterization;

trait OrAssignedCharacterizationGeneralTrait
{
    public static function bootOrAssignedCharacterizationGeneralTrait()
    {
        static::created(function ($model) {
            // Verificar que el modelo tenga una relación válida con el curso
            $course = $model->onlineRegistrationCourse;

            if ($course) {
                // Obtener las sesiones asociadas al curso
                $sessions = OnlineRegistrationCourseSession::where('or_course_id', $course->id)->pluck('id');

                if ($sessions->isNotEmpty()) {
                    // Obtener las caracterizaciones de tipo "G" asociadas a las sesiones
                    $characterizations = OnlineRegistrationCharacterization::whereIn('session_id', $sessions)
                        ->where('type', 'G')
                        ->get();

                    if ($characterizations->isNotEmpty()) {
                        // Construir los datos para inserción masiva
                        $assignments = $characterizations->map(function ($characterization) use ($model) {
                            return [
                                'contact_id' => $model->contact_id,
                                'characterization_id' => $characterization->id,
                                'answered' => false, // o el valor predeterminado según tu lógica
                                'feedback' => null, // o el valor predeterminado
                            ];
                        })->toArray();

                        // Insertar en la tabla de asignaciones
                        OrAssignedCharacterization::insert($assignments);
                    }
                }
            }
        });
    }
}
