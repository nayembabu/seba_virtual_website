<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NagorikSonod extends Model
{
    use HasFactory;

    protected $table = 'nagorik_sonods';

    protected $fillable = [
        'user_id',
        'union_name',
        'union_address',
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
        'photo'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'issue_date' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}