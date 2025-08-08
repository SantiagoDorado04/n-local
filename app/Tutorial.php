<?php

namespace App;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;


class Tutorial extends Model
{
    public function category() {
        return $this->belongsTo(Categorytutorial::class, 'category_tutorials_id');
    }

    public function createUser() {
        return $this->belongsTo(User::class, 'create_user_id');
    }

    public function updateUser() {
        return $this->belongsTo(User::class, 'update_user_id');
    }

}
