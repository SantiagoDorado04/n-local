<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Exception;

class PublitioService
{
    protected $base;
    protected $token;

    public function __construct()
    {
        $this->base  = rtrim(env('PUBLITIO_API_BASE', 'https://api.publit.io/v1'), '/');
        $this->token = env('PUBLITIO_API_TOKEN');
    }

    protected function callApi(string $method, string $path, array $params = [])
    {
        if (!$this->token) {
            throw new Exception('Falta la variable PUBLITIO_API_TOKEN en el .env');
        }

        $url = "{$this->base}/" . ltrim($path, '/');

        $client = Http::withToken($this->token);

        if (strtolower($method) === 'get') {
            $response = $client->get($url, $params);
        } elseif (strtolower($method) === 'post') {
            $response = $client->post($url, $params);
        } else {
            throw new Exception("Método HTTP no soportado: $method");
        }

        if ($response->failed()) {
            throw new Exception("Error en Publitio API ({$url}): " . $response->body());
        }

        return $response->json();
    }

    public function getFileInfo(string $fileId): ?array
    {
        $result = $this->callApi('get', "files/show/{$fileId}");

        if (!empty($result['id'])) {
            return $result;
        }

        return null;
    }





    /**
     * Obtiene URL firmada de reproducción (stream o embed).
     */
    public function getSignedUrlFromId(string $fileId): ?string
    {
        $file = $this->getFileInfo($fileId);

        if (!$file) {
            return null;
        }

        if (!empty($file['url_stream'])) {
            return $file['url_stream'];
        }

        if (!empty($file['url_embed'])) {
            return $file['url_embed'];
        }

        return null;
    }


    public function findByPublicId(string $publicId, ?string $folder = null): ?array
    {
        $params = ['public_id' => $publicId];
        if ($folder) {
            $params['folder'] = $folder;
        }

        $files = $this->callApi('get', 'files/list', $params);

        if (!empty($files['files'])) {
            foreach ($files['files'] as $file) {
                if (
                    $file['public_id'] === $publicId &&
                    (!$folder || trim($file['folder'], '/') === trim($folder, '/'))
                ) {
                    return $file;
                }
            }
        }

        return null;
    }

    public function debugFileShow(string $fileId): array
    {
        $path = "files/show/{$fileId}";
        $url  = "{$this->base}/{$path}";

        try {
            $resp = Http::withToken($this->token)->get($url);

            return [
                'status' => $resp->status(),
                'ok'     => $resp->ok(),
                'body'   => $resp->body(),
                'json'   => $resp->ok() ? $resp->json() : null,
            ];
        } catch (\Exception $e) {
            return ['exception' => $e->getMessage(), 'requested_url' => $url];
        }
    }

    public function debugFilesList(): array
    {
        try {
            $resp = Http::withToken($this->token)->get("{$this->base}/files/list");

            return [
                'status' => $resp->status(),
                'ok'     => $resp->ok(),
                'json'   => $resp->ok() ? $resp->json() : null,
            ];
        } catch (\Exception $e) {
            return ['exception' => $e->getMessage()];
        }
    }

    public function getSignedUrlFromIdOrPublic(string $idOrPublicId): ?string
    {
        $file = $this->getFileInfo($idOrPublicId);

        if (!$file) {
            $file = $this->findByPublicId($idOrPublicId);
        }

        if (!$file) {
            return null;
        }

        if (!empty($file['url_embed'])) {
            return $file['url_embed'];
        }

        if (!empty($file['url_stream'])) {
            return $file['url_stream'];
        }

        return null;
    }
}
