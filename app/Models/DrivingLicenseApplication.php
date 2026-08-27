<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrivingLicenseApplication extends Model
{
    use HasFactory;

    protected $table = 'driving_license_applications';

    // Mass assignable attributes
    protected $fillable = [
        'photo',
        'sign',
        'name',
        'dob',
        'bloodGroup',
        'fatherOrHusband',
        'address',
        'licenceNo',
        'authority',
        'issuDate',
        'firstIssuDate',
        'validityDate',
        'refNo',
        'drivingClass',
    ];

    // Date casting for better handling
    protected $casts = [
        'dob'           => 'date',
        'issuDate'      => 'date',
        'firstIssuDate' => 'date',
        'validityDate'  => 'date',
    ];
}