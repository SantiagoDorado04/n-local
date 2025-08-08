<?php

namespace App\Jobs;

use App\Models\OnlineRegistrationExternalExecution;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class OrSendApiRequestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $model;
    protected $comunication;
    protected $channel;
    protected $customStructure; // Nuevo

    public function __construct($model, $comunication, $channel, $customStructure = null)
    {
        $this->model = $model;
        $this->comunication = $comunication;
        $this->channel = $channel;
        $this->customStructure = $customStructure;
    }

    public function handle(): void
    {
        // Asegurarse que los headers son un array
        $structure = $this->customStructure ?? json_decode($this->channel->structure, true);

        $headersRaw = $structure['headers'] ?? [];
        $headers = is_string($headersRaw) ? json_decode($headersRaw, true) : $headersRaw;

        $bodyRaw = $structure['body'] ?? [];
        $bodyParsed = is_string($bodyRaw) ? json_decode($bodyRaw, true) : $bodyRaw;
        $bodyParsed = is_array($bodyParsed) ? $bodyParsed : [];
        $body = $this->replacePlaceholders($bodyParsed, $this->model);

        // Asegurar que el texto del mensaje esté presente
        $structureText = $bodyParsed['text'] ?? '';
        $message = json_decode($this->comunication->message, true);
        $messageText = $message['body']['text'] ?? '';

        $combinedText = trim($structureText . "\n" . $messageText);
        $body['text'] = $combinedText;


        if (!is_array($headers)) {
            $headers = [];
        }

        $contact = $this->model->contact ?? null;

        if (
            $this->requiresPhoneWithPrefix($this->channel->name) &&
            !isset($body['number']) &&
            $contact
        ) {
            // Usar whatsapp si está presente y no vacío
            $rawNumber = !empty($contact->whatsapp)
                ? $contact->whatsapp
                : (!empty($contact->phone) ? $contact->phone : null);

            if ($rawNumber) {
                $cleanedNumber = preg_replace('/\D/', '', $rawNumber);
                if (!str_starts_with($cleanedNumber, '57')) {
                    $cleanedNumber = '57' . $cleanedNumber;
                }
                $body['number'] = $cleanedNumber;
            } else {

            }
        }


        // Agregar correo si es Email
        if ($this->requiresEmail($this->channel->name) && !isset($body['email']) && $contact) {
            $email = $contact->email ?? null;
            if ($email) {
                $body['email'] = $email;
            }
        }



        try {

            $response = Http::withHeaders($headers)
                ->post($this->channel->url, $body);

            OnlineRegistrationExternalExecution::create([
                'method' => 'POST',
                'url' => $this->channel->url,
                'request' => json_encode($body),
                'status' => $response->status(),
                'message' => json_encode($response->json()),
                'type' => 'trigger',
            ]);

        } catch (\Exception $e) {


            OnlineRegistrationExternalExecution::create([
                'method' => 'POST',
                'url' => $this->channel->url,
                'request' => json_encode($body),
                'status' => 500,
                'message' => $e->getMessage(),
                'type' => 'trigger',
            ]);
        }
    }

    protected function requiresPhoneWithPrefix($channelName): bool
    {
        return str_contains(strtolower($channelName), 'whatsapp');
    }

    protected function requiresEmail($channelName): bool
    {
        return str_contains(strtolower($channelName), 'email') || str_contains(strtolower($channelName), 'correo');
    }

    protected function replacePlaceholders($body, $model)
    {
        if (!is_array($body)) {
            return [];
        }

        foreach ($body as $key => $value) {
            if (is_string($value) && str_contains($value, '{{')) {
                preg_match_all('/\{\{(.*?)\}\}/', $value, $matches);
                foreach ($matches[1] as $match) {
                    $replaced = data_get($model, $match, '');
                    $value = str_replace("{{{$match}}}", $replaced, $value);
                }
                $body[$key] = $value;
            }
        }

        return $body;
    }
}
