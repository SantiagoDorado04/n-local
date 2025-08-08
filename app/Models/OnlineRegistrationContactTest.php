<?php

namespace App\Models;

use App\Contact;
use App\Models\Traits\HasUserTracking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineRegistrationContactTest extends Model
{
    use HasUserTracking;
    use HasFactory;

    protected $table = 'online_registrations_contacts_tests';

    protected $fillable = [
        'contact_id',
        'or_test_id',
        'approved',
        'attempts',
        'hits',
        'user_created_at',
        'user_updated_at',
        'user_deleted_at',
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }

    public function test()
    {
        return $this->belongsTo(OnlineRegistrationTestContent::class, 'or_test_id');
    }

}
