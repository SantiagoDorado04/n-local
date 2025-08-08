<?php

namespace App\Models;

use App\ImpactsAttachment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Impact extends Model
{
    use HasFactory;
    
    public function attachments()
    {
        return $this->hasMany(ImpactsAttachment::class, 'impact_id');
    }
}
