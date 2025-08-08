<?php

namespace App\Models;

use App\Contact;
use App\Interview;
use App\Models\Stage;
use App\Models\Course;
use App\Models\Process;
use App\Models\InformationForm;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Step extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'order', 'available_from', 'type', 'step_type', 'process_id'];

    public function process()
    {
        return $this->belongsTo(Process::class);
    }

    public function stage()
    {
        return $this->belongsTo(Stage::class, 'stage_id');
    }

    public function informationForm()
    {
        return $this->hasOne(InformationForm::class, 'step_id');
    }

    public function contacts()
    {
        return $this->belongsToMany(Contact::class, 'contacts_stages');
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'step_id');
    }

    public function interview()
    {
        return $this->hasOne(Interview::class, 'step_id');
    }
}
