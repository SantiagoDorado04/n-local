<?php

namespace App;

use App\ProposalTemplatesQuestion;
use Illuminate\Database\Eloquent\Model;


class ProposalTemplate extends Model
{
    public function questions()
    {
        return $this->hasMany(ProposalTemplatesQuestion::class);
    }

    public function contactProposals()
    {
        return $this->hasMany(ContactProposal::class);
    }
}
