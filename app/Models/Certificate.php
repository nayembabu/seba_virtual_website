<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'certificate_number',
        'name',
        'father_name',
        'mother_name',
        'husband_name',
        'address',
        'ward_no',
        'nid_number',
        'birth_date',
        'issue_date',
        'union_name',
        'union_address',
        'photo_path'
    ];
}
