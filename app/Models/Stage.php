<?php

namespace App\Models;

use App\CommercialAction;
use App\CommercialLand;
use App\CommercialStrategy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    use HasFactory;


    protected $fillable = [
        'name', 'description', 'embebed', 'link', 'process_id',
    ];

    public function process()
    {
        return $this->belongsTo(Process::class, 'process_id');
    }

    public function form()
    {
        return $this->hasOne(InformationForm::class, 'stage_id');
    }

    public function land()
    {
        return $this->belongsTo(CommercialLand::class, 'land_id');
    }

    public function strategy()
    {
        return $this->belongsTo(CommercialStrategy::class, 'strategy_id');
    }

    public function action()
    {
        return $this->belongsTo(CommercialAction::class, 'action_id');
    }

    public function contactsStages()
    {
        return $this->hasMany(ContactsStage::class, 'stage_id');
    }
}
