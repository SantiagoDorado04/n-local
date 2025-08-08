<?php

namespace App\Models;

use App\Models\Traits\HasUserTracking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineRegistrationTestItem extends Model
{
    use HasUserTracking;
    use HasFactory;

    protected $table = 'online_registrations_tests_items';

    protected $fillable = [
        'text',
        'position',
        'or_test_id',
        'user_created_at',
        'user_updated_at',
        'user_deleted_at',
    ];

    public function test()
    {
        return $this->belongsTo(OnlineRegistrationTestContent::class, 'or_test_id');
    }
    public function response()
    {
        return $this->belongsTo(OnlineRegistrationTestResponse::class, 'response', 'id');
    }

    public function choices()
    {
        return $this->hasMany(OnlineRegistrationTestChoice::class, 'or_item_id');
    }
}
