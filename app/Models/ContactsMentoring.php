<?php

namespace App\Models;

use App\Contact;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactsMentoring extends Model
{
    
    use HasFactory;

    protected $table = 'contacts_mentoring';

    protected $fillable = ['contact_id', 'step_id', 'mentor_id', 'date', 'start', 'end','attended','feedback'];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
