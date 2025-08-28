<?php

namespace App\Models;

use App\Models\Topic;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'protected_video',
        'video',
        'file',
        'content',
        'topic_id',
        'order',
        'duration',
        'published',
    ];

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
}
