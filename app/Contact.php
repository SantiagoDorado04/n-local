<?php

namespace App;

use App\Stage;
use App\Models\User;
use App\Announcement;
use App\CompanyCharge;
use App\CampaignContact;
use App\IndividualEmail;
use App\Models\Challenge;
use App\ContactsAttachment;
use App\AnnouncementsContact;
use App\ContactsAssignedForm;
use App\Models\OnlineRegistrationCertificationRegister;
use App\Models\OnlineRegistrationContactDocument;
use Illuminate\Database\Eloquent\Model;


class Contact extends Model
{
    protected $fillable = [
        'nit',
        'name',
        'main_sector',
        'secondary_sector',
        'company_type_id',
        'commercial_action_id',
        'form_action_id',
        'address',
        'city_id',
        'phone',
        'email',
        'whatsapp',
        'website',
        'contact_person_name',
        'leader_name',
        'leader_position',
        'leader_email',
        'leader_phone',
        'leader_gender',
        'leader_age',
        'storage',
        'rate',
        'commercial_form_id',
        'user_id',
        'points'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function attachments()
    {
        return $this->hasMany(ContactsAttachment::class, 'contact_id');
    }

    public function assignedForms()
    {
        return $this->hasMany(ContactsAssignedForm::class, 'contact_id');
    }

    public function announcements()
    {
        return $this->belongsToMany(Announcement::class, 'announcements_contacts');
    }

    public function contar()
    {
        return Contact::where()->count();
    }

    public function announcementContact()
    {
        return $this->hasOne(AnnouncementsContact::class, 'contact_id');
    }

    public function individualEmails()
    {
        return $this->hasMany(IndividualEmail::class);
    }

    public function campaignContacts()
    {
        return $this->hasMany(CampaignContact::class);
    }

    public function contactProposals()
    {
        return $this->hasMany(ContactProposal::class);
    }

    public function mainSector()
    {
        return $this->belongsTo(EconomicSector::class, 'main_sector');
    }

    public function secondarySector()
    {
        return $this->belongsTo(EconomicSector::class, 'secondary_sector');
    }

    public function companyType()
    {
        return $this->belongsTo(CompanyType::class, 'company_type_id');
    }

    public function leaderPosition()
    {
        return $this->belongsTo(CompanyCharge::class, 'leader_position');
    }

    public function commercialForm()
    {
        return $this->belongsTo(CommercialForm::class, 'commercial_form_id');
    }

    public function commercialAction()
    {
        return $this->belongsTo(CommercialAction::class, 'commercial_action_id');
    }

    public function stages()
    {
        return $this->belongsToMany(Stage::class, 'contacts_stages');
    }

    public function challenges()
    {
        return $this->belongsToMany(Challenge::class, 'contacts_challenges');
    }

    public function orContactDocuments()
    {
        return $this->hasMany(OnlineRegistrationContactDocument::class, 'contact_id');
    }

    public function OrCertificationRegisters()
    {
        return $this->hasMany(OnlineRegistrationCertificationRegister::class, 'contact_id');
    }

}
