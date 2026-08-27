<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarriageCertificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'certificate_id',
        'name',
        'father_name',
        'mother_name',
        'date_of_birth',
        'birth_registration_number',
        'nid',
        'holding_number',
        'ward_no',
        'village',
        'post_office',
        'upazila',
        'district',
        'verification_code',
        'photo_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
