<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models\Step;


class Canva extends Model
{

    public $fillable = [
        'url_file',
        'information_form_id',
        'step_id'
    ];

    public function step()
    {
        return $this->belongsTo(Step::class);
    }
}
