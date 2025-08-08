<?php

namespace App\Models;

use App\Contact;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactsCourseRegistrationForm extends Model
{
    use HasFactory;

    protected $table  = 'contacts_course_registration_forms';

    protected $fillable = ['contact_id', 'course_registration_form_id', 'approved', 'feedback'];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function courseRegistrationForm()
    {
        return $this->belongsTo(CourseRegistrationForm::class);
    }

    // public function informationFormAnswers()
    // {
    //     return $this->hasMany(InformationFormAnswer::class, 'contact_id', 'contact_id')
    //         ->where('information_form_id', $this->courseRegistrationForm->form->id);
    // }
}
