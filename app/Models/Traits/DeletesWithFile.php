<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Storage;

trait DeletesWithFile
{
    protected static function bootDeletesWithFile()
    {
        static::deleting(function ($model) {
            if ($model->url && Storage::disk('public')->exists($model->url)) {
                Storage::disk('public')->delete($model->url);
            }
        });
    }

    protected static function bootDeletesWithLogoFile()
    {
        static::deleting(function ($model) {
            if ($model->logo_file && Storage::disk('public')->exists($model->logo_file)) {
                Storage::disk('public')->delete($model->logo_file);
            }
        });
    }
}
