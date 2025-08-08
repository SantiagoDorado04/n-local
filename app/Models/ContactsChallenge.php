<?php

namespace App\Models;

use App\Contact;
use App\Models\Challenge;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactsChallenge extends Model
{
    use HasFactory;

    protected $table = 'contacts_challenges';

    protected $fillable = ['text', 'file', 'challenge_id', 'contact_id','feedback','approved'];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function challenge()
    {
        return $this->belongsTo(Challenge::class);
    }

    public function contactStage()
    {
        return $this->belongsTo(ContactsStage::class, 'contact_id');
    }
}
