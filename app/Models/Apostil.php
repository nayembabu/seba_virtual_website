<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apostil extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'apostil_no',
        'certificate_image',
        'place', // Added place
        'user_id', // Added user_id
    ];

    /**
     * Get the user that owns the apostil.
     */
    public function user()
    {
        return $this->belongsTo(User::class); // Assuming your User model is App\Models\User or App\User
    }
}
