<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoldenCard extends Model
{
    protected $table = 'golden_cards';

    protected $fillable = [
        'user_id',
        'card_no',
        'name_bn',
        'mother_bn',
        'father_bn',
        'disability_bn',
        'dob',
        'id_no',
        'address_bn',
        'issue_date',
        'name_en',
        'mother_en',
        'father_en',
        'disability_en',
        'blood_group',
        'mobile',
        'address_en',
        'photo',
        'signature',
        'status',
    ];
}
