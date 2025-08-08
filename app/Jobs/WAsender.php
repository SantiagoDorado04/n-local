<?php

namespace App\Jobs;

use App\Models\OnlineRegistrationChannel;
use App\Models\OnlineRegistrationExternalExecution;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class WAsender implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $contactCourse;
    protected $comunication;
    protected $channel;



    public function __construct($contactCourse, $comunication, $channel)
    {
        $this->contactCourse = $contactCourse;
        $this->comunication = $comunication;
        $this->channel = $channel;

    }

    public function handle()
    {
        // Obtener contacto y verificar
        $contact = $this->contactCourse->contact;
        if (!$contact) {
            return;
        }

        // Decodificar la estructura correctamente
        $structure = json_decode($this->channel->structure, true);


        // Decodificar el mensaje del cuerpo
        $message = json_decode($this->comunication->message, true);

        // Limpiar el número de contacto
        $number = $this->contactCourse->contact->whatsapp ?? $this->contactCourse->contact->phone;
        $cleanedNumber = preg_replace('/\D/', '', $number);

        // Asegurarse de que el número tenga el formato correcto (agregar '57' si no lo tiene)
        if (!str_starts_with($cleanedNumber, '57')) {
            $cleanedNumber = '57' . $cleanedNumber;
        }

        // Unir los textos de structure y message
        $structureText = $structure['body']['text'] ?? '';
        $messageText = $message['body']['text'] ?? '';
        $combinedText = trim($structureText . "\n" . $messageText);

        // Construir el body final con el texto combinado
        $body = $structure['body'];  // Usamos la estructura del canal
        $body['text'] = $combinedText;
        $body['number'] = $cleanedNumber;

    

        // Construir headers
        $headers = [
            'Accept' => '*/*',
            'User-Agent' => 'LaravelApp/1.0',
            'Content-Type' => 'application/json',
            'apikey' => $structure['headers']['apikey'] ?? null,
        ];

        // Enviar la solicitud HTTP
        $url = $this->channel->url;

        try {
            $response = Http::withHeaders($headers)
                ->post($url, $body);

            // Crear registro de ejecución externa
            OnlineRegistrationExternalExecution::create([
                'method' => 'POST',
                'url' => $url,
                'request' => $response->body(),
                'status' => $response->status(),
                'message' => json_encode($body),
                'type' => 'trigger'
            ]);

            if ($response->successful()) {
            } else {
            }
        } catch (\Exception $e) {
            // Registrar el error en external execution
            OnlineRegistrationExternalExecution::create([
                'method' => 'POST',
                'url' => $url,
                'request' => $response->body(),
                'status' => $response->status(),
                'message' => json_encode($body),
                'type' => 'trigger'
            ]);
            }
    }
}
