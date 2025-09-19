<?php

namespace App\Models;

use App\Contact;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessTestAnswer extends Model
{
    use HasFactory;

    protected $table = 'process_test_answers';

    protected $fillable = [
        'answer',
        'contact_id',
        'points',
        'process_test_id',
        'p_test_subcategory_id',
        'p_test_question_id',
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function processTest()
    {
        return $this->belongsTo(ProcessTest::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(ProcessTestSubcategory::class, 'p_test_subcategory_id');
    }

    public function question()
    {
        return $this->belongsTo(ProcessTestQuestion::class, 'p_test_question_id');
    }

    public function option()
    {
        return $this->belongsTo(ProcessTestOption::class, 'answer');
    }
}
