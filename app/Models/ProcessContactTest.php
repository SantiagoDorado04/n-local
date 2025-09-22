<?php

namespace App\Models;

use App\Contact;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessContactTest extends Model
{
    use HasFactory;

    protected $table = 'process_contacts_tests';

    protected $fillable = [
        'date_completed',
        'approved',
        'contact_id',
        'process_test_id',
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }

    public function processTest()
    {
        return $this->belongsTo(ProcessTest::class);
    }
}
