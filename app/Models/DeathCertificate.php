<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeathCertificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'registration_no',
        'office_name',
        'office_address',
        'date_of_death',
        'gender',
        'name_bengali',
        'name_english',
        'father_name_bengali',
        'father_name_english',
        'mother_name_bengali',
        'mother_name_english',
        'place_of_death_bengali',
        'place_of_death_english',
        'permanent_address_bengali',
        'permanent_address_english',
        'registration_date',
        'issue_date',
        'email',
    ];

    protected $casts = [
        'date_of_death' => 'date',
        'registration_date' => 'date',
        'issue_date' => 'date',
    ];
}