<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UttoradhikarSonod extends Model
{
    protected $fillable = [
        'user_id',
        'certificate_number',
        'union_name',
        'union_address',
        'village_id',
        'word_no',
        'village_name',
        'post_office',
        'thana',
        'upozila',
        'zila',
        'gender',
        'he_she_is',
        'death_certificates_id',
        'dod',
        'person_bn',
        'person_en',
        'guardian_bn',
        'guardian_en',
        'relatives'
    ];

    protected $casts = [
        'relatives' => 'array',
        'dod' => 'date:Y-m-d',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
