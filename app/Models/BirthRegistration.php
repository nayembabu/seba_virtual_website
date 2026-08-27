<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BirthRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'office_name_bn',
        'district_info_bn',
        'pdf_qr_link',
        'qr_letter',
        'gender',
        'date_of_birth',
        'registration_no',
        'issue_date',
        'registration_date',
        'name_en',
        'name_bn',
        'mother_name_en',
        'mother_name_bn',
        'father_name_en',
        'father_name_bn',
        'birth_place_bn',
        'birth_place_en',
        'permanent_address_bn',
        'permanent_address_en',
        'father_nationality_bn',
        'father_nationality_en',
        'mother_nationality_bn',
        'mother_nationality_en',
    ];

    protected $dates = [
        'date_of_birth',
        'issue_date',
        'registration_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
