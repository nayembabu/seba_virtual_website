<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NidData extends Model
{
    protected $table = 'nid_data';
    
    protected $fillable = [
        'user_id',
        'nid_no',
        'voter_area',
        'name_bn',
        'name_en',
        'dob',
        'fathers_name',
        'mothers_name',
        'gender',
        'religion',
        'blood_grp',
        'occupation',
        'permanent_addr',
        'district',
        'present_addr',
        'photo',
        'expire_time'
    ];

    protected $dates = [
        'dob',
        'expire_time',
        'created_at',
        'updated_at'
    ];
}