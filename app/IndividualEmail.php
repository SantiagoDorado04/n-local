<?php

namespace App;

use App\Contact;
use TCG\Voyager\Models\User;
use Illuminate\Database\Eloquent\Model;


class IndividualEmail extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
