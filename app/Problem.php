<?php

namespace App;


use App\Solution;
use App\Models\Project;
use Illuminate\Database\Eloquent\Model;


class Problem extends Model
{
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function solutions()
    {
        return $this->hasMany(Solution::class);
    }
}
