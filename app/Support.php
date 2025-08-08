<?php

namespace App;

use App\Models\User;
use App\SupportsResponse;
use Illuminate\Database\Eloquent\Model;


class Support extends Model
{
    public function category() {
        return $this->belongsTo(Categorysupport::class, 'category_supports_id');
    }

    public function supportUser() {
        return $this->belongsTo(User::class, 'support_user_id');
    }
    public function responses()
    {
        return $this->hasMany(SupportsResponse::class);
    }

}
