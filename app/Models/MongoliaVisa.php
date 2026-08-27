<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MongoliaVisa extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'visa_permit_number',
        'first_name',
        'middle_name',
        'last_name',
        'gender',
        'date_of_birth',
        'nationality',
        'passport_number',
        'passport_issue_date',
        'passport_expiry_date',
        'inviting_company',
        'visa_class',
        'type_of_visa',
        'entry_type',
        'visa_issue_date',
        'visa_effective_date',
        'visa_validity_days',
        'application_date',
        'remaining_stay_days',
        'port_of_entry',
        'contact_number',
        'notice_section_date'
    ];

    protected $dates = [
        'date_of_birth',
        'passport_issue_date',
        'passport_expiry_date',
        'visa_issue_date',
        'visa_effective_date',
        'application_date',
        'notice_section_date'
    ];
}
