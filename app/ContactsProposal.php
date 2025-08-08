<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ContactsProposal extends Model
{
    public function proposal()
    {
        return $this->belongsTo(ProposalTemplate::class,'proposal_template_id');
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }
}
