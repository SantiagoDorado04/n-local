<?php

namespace App;

use App\Support;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;


class SupportsResponse extends Model
{
    public function support()
    {
        return $this->belongsTo(Support::class);
    }

    public function responseUser() {
        return $this->belongsTo(User::class, 'response_user_id');
    }
}
