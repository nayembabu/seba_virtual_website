<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BmetEc extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ec_no',
        'birth_date',
        'passport_no',
        'passport_issue_date',
        'passport_expire_date',
        'visa_no',
        'visa_issue_date',
        'visa_expire_date',
        'recruiting_agency',
        'rl_id',
        'employer',
        'country',
        'bmet_no',
        'name',
        'father_name',
        'mother_name',
        'gender',
        'blood_group',
        'nid',
        'profile_photo',
    ];
}
