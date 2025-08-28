<?php

namespace App\Services;

use App\Models\AlquimiaAgentConnection;
use Illuminate\Support\Facades\Http;

class AIService
{
    /**
     * Envía un prompt a la API definida en la conexión.
     *
     * @param string $prompt
     * @param AlquimiaAgentConnection $connection
     * @return string
     */
    public function generateText(string $prompt, AlquimiaAgentConnection $connection): string
    {
        // Reemplazar [$message] en el request_body con el prompt real
        $bodyTemplate = $connection->request_body;
        $bodyJson = str_replace('[$message]', $prompt, $bodyTemplate);
        $body = json_decode($bodyJson, true);

        if (!$body) {
            throw new \Exception("El request_body no es un JSON válido.");
        }

        // Llamada a la API
        $response = Http::withHeaders([
            'Content-Type'  => 'application/json',
            'Authorization' => 'Bearer ' . $connection->apikey,
        ])->post($connection->url, $body);

        $rawResponse = $response->body();

        // Ejecutar el transformer si existe
        if ($connection->response_transformer) {
            $transformer = eval($connection->response_transformer); // <- cuidado, ejecuta código de DB
            if (is_callable($transformer)) {
                return $transformer($rawResponse);
            }
        }

        // Si no hay transformer, devolvemos la respuesta cruda
        return $rawResponse;
    }

    /**
     * Permite transformar dinámicamente la respuesta según un "path"
     * guardado en response_transformer (ej: "choices.0.text").
     */
    private function applyResponseTransformer(array $response, string $transformer): string
    {
        $keys = explode('.', $transformer);
        $data = $response;

        foreach ($keys as $key) {
            if (is_array($data) && array_key_exists($key, $data)) {
                $data = $data[$key];
            } elseif (is_numeric($key) && isset($data[(int)$key])) {
                $data = $data[(int)$key];
            } else {
                return json_encode($response);
            }
        }

        return is_string($data) ? $data : json_encode($data);
    }
}
