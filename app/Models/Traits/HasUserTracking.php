<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Auth;

trait HasUserTracking
{
    public static function bootHasUserTracking()
    {
        static::creating(function ($model) {
            $model->user_created_at = self::getUserId();
        });

        static::updating(function ($model) {
            $model->user_updated_at = self::getUserId();
        });

        static::deleting(function ($model) {
            $model->user_deleted_at = self::getUserId();
            $model->save(); // Important
        });
    }
    /**
     * Auth User.
     */
    public static function getUserId()
    {
        return Auth::id();
    }
}
