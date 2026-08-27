<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cv extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'education' => 'array',
        'experience' => 'array',
        'references' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
