<?php

namespace App\Models;

use App\Contact;
use App\IndividualEmail;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends \TCG\Voyager\Models\User
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function contact()
    {
        return $this->hasOne(Contact::class);
    }

    public function individualEmails()
    {
        return $this->hasMany(IndividualEmail::class, 'created_by');
    }

    public function campaigns()
    {
        return $this->hasMany(IndividualEmail::class, 'created_by');
    }

}
