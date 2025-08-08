<?php

namespace App;

use App\Contact;
use App\CommercialFormAction;
use Illuminate\Database\Eloquent\Model;


class ContactsAssignedForm extends Model
{
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function commercialFormAction()
    {
        return $this->belongsTo(CommercialFormAction::class, 'commercial_form_action_id');
    }
}
