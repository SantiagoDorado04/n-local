<?php

namespace App\Models;

use App\Contact;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessAlquimiaAgentAnswer extends Model
{
    use HasFactory;

    protected $table  = 'process_alquimia_agent_answers';


    protected $fillable = [
        'answer',
        'contact_id',
        'process_alquimia_agent_id',
        'paa_question_id',
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }

    public function processAlquimiaAgent()
    {
        return $this->belongsTo(ProcessAlquimiaAgent::class);
    }

    public function question()
    {
        return $this->belongsTo(ProcessAlquimiaAgentQuestion::class, 'paa_question_id');
    }

    public function contactStage()
    {
        return $this->belongsTo(ContactsStage::class, 'contact_id', 'contact_id');
    }
}
