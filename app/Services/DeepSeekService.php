<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class DeepSeekService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('DEEPSEEK_API_KEY');
    }

    public function generateText(string $prompt, array $options = []): string
    {
        $model = 'deepseek-chat';

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->post('https://api.deepseek.com/chat/completions', [
            'model' => $model,
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'You are a helpful assistant.',
                ],
                [
                    'role' => 'user',
                    'content' => $prompt,
                ]
            ],
            'stream' => false,
        ]);

        if ($response->failed()) {
            throw new \Exception('Error en la solicitud: ' . $response->body());
        }

        return $response->json('choices.0.message.content') ?? 'Error: No se generó ningún texto.';
    }
}
