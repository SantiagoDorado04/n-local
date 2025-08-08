<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class MistralService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('MISTRAL_API_KEY');
    }

    public function generateText(string $prompt, array $options = []): string
    {
        $model = 'mistral-large-latest';

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->post('https://api.mistral.ai/v1/chat/completions', [
            'model' => $model ?? 'mistral-large-latest',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $prompt,
                ]
            ],
        ]);

        if ($response->failed()) {
            throw new \Exception('Error en la solicitud: ' . $response->body());
        }

        return $response->json('choices.0.message.content') ?? 'Error: No se generó ningún texto.';
    }
}
