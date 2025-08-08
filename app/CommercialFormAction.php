<?php

namespace App;

use App\CommercialAction;
use App\ContactsAssignedForm;
use Illuminate\Database\Eloquent\Model;


class CommercialFormAction extends Model
{
    public function commercialForm()
    {
        return $this->belongsTo(CommercialForm::class);
    }

    public function commercialAction()
    {
        return $this->belongsTo(CommercialAction::class);
    }

    public function contactsAssignedForm()
    {
        return $this->hasMany(ContactsAssignedForm::class, 'commercial_form_action_id');
    }
}
