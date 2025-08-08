<?php

namespace App;

use App\Faq;
use Illuminate\Database\Eloquent\Model;


class Categoryfaq extends Model
{
    public function faqs() {
        return $this->hasMany(Faq::class, 'category_faq_id');
    }
}
