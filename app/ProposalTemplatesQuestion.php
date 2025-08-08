<?php

namespace App;

use App\ProposalTemplate;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;


class ProposalTemplatesQuestion extends Model
{
    public function template()
    {
        return $this->belongsTo(ProposalTemplate::class);
    }
}
