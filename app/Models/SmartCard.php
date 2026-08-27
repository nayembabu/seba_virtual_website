<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SmartCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name_bn',
        'name_en',
        'father_name',
        'mother_name',
        'photo',
        'signature',
        'date_of_birth',
        'nid_no',
        'blood_group',
        'address',
        'place_of_birth',
        'issue_date'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'issue_date' => 'date'
    ];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
