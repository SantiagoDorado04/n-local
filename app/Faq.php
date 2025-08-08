<?php

namespace App;

use App\Categoryfaq;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;


class Faq extends Model
{
    public function category() {
        return $this->belongsTo(Categoryfaq::class, 'category_faq_id');
    }

    public function questionUser() {
        return $this->belongsTo(User::class, 'question_user_id');
    }

    public function responseUser() {
        return $this->belongsTo(User::class, 'response_user_id');
    }

    public function updateUser() {
        return $this->belongsTo(User::class, 'update_user_id');
    }
}
