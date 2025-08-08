<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class OpenAIService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('OPENAI_API_KEY');
    }

    public function generateText(string $prompt, array $options = []): string
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->post('https://api.openai.com/v1/completions', [
            'model' => 'babbage-002',
            'prompt' => $prompt,
            'max_tokens' => $options['max_tokens'] ?? 150,
            'temperature' => $options['temperature'] ?? 0.7,
        ]);

        if ($response->failed()) {
            throw new \Exception('Error en la solicitud: ' . $response->body());
        }

        return $response->json('choices.0.text') ?? 'Error: No se generó ningún texto.';
    }
}