<?php
// app/Services/WasabiService.php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class WasabiService
{
    protected $disk;

    public function __construct()
    {
        $this->disk = Storage::disk('wasabi');
    }

    public function generateTemporaryUrl($path, $minutos = 30)
    {
        if ($this->disk->exists($path)) {
            return $this->disk->temporaryUrl($path, now()->addMinutes($minutos));
        }

        return null;
    }


    public function obtenerArchivosConUrls($carpeta = 'uploads')
    {
        return collect($this->disk->files($carpeta))->map(function ($archivo) {
            return [
                'nombre' => basename($archivo),
                'url_firmada' => $this->generateTemporaryUrl($archivo),
                'path' => $archivo,
            ];
        });
    }

    public function exists($path)
    {
        return $this->disk->exists($path);
    }

    public function delete($path)
    {
        return $this->disk->delete($path);
    }
}
