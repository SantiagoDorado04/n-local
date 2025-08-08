<?php

namespace App\Models;

use App\Contact;
use App\Models\Traits\HasUserTracking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineRegistrationTestResponse extends Model
{
    use HasUserTracking;
    use HasFactory;

    protected $table = 'online_registrations_tests_responses';

    protected $fillable = [
        'contact_id',
        'or_test_id',
        'or_item_id',
        'response',
        'is_correct',
        'user_created_at',
        'user_updated_at',
        'user_deleted_at',
    ];

    public function test()
    {
        return $this->belongsTo(OnlineRegistrationTestContent::class, 'or_test_id');
    }

    public function item()
    {
        return $this->belongsTo(OnlineRegistrationTestItem::class, 'or_item_id');
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }

    public function choices()
    {
        return $this->hasMany(OnlineRegistrationTestChoice::class, 'response');
    }
}
