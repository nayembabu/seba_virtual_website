<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TinCertificate extends Model
{
    protected $table = 'tin_certificates'; // adjust to your actual table name

    protected $fillable = [
        'name',
        'fatherName',
        'motherName',
        'dob',
        'certDate',
        'curr_line1',
        'curr_line2',
        'currDistrict',
        'currThana',
        'curr_post',
        'perm_line1',
        'perm_line2',
        'permDistrict',
        'permThana',
        'perm_post',
        'taxesCircle',
        'taxesZone',
        'officeAddress',
        'officePhone',
        'tin_number',
        'generate_tin', // if you store this flag
    ];
}
