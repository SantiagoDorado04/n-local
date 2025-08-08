<?php

namespace App\Models;

use App\Models\Traits\HasUserTracking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineRegistrationTestChoice extends Model
{
    use HasUserTracking;
    use HasFactory;

    protected $table = 'online_registrations_tests_choices';

    protected $fillable = [
        'text',
        'value',
        'position',
        'is_correct',
        'or_item_id',
        'user_created_at',
        'user_updated_at',
        'user_deleted_at',
    ];

    public function item()
    {
        return $this->belongsTo(OnlineRegistrationTestItem::class, 'or_item_id');
    }
}
