<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificateApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'certificate_no', 'office_type', 'union_no', 'union_name', 'upazila',
        'cert_type', 'language', 'issue_date', 'applicant_name', 'nid_no', 'income_amount',
        'father_name', 'mother_name', 'spouse_name',
        'present_village', 'present_post', 'present_upazila', 'present_district',
        'members', 'prepared_by', 'prepared_seal_en',
        'authority_title', 'authority_name', 'authority_seal_en',
        'fee', 'status',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'members' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
