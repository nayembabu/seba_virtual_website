<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServerCopy extends Model
{
    protected $table = 'server_copy';

    protected $fillable = [
        'user_id','user_mail', 'nameBn', 'nameEn', 'nationalId',
        'pin', 'voter_no', 'photo_path', 'sign_path',
        'api_response', 'parent_id', 'search_by', 'specify',
    ];

    protected $casts = [
        'api_response' => 'array',
    ];

    // Helper: get full photo URL
    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo_path
            ? asset('storage/' . $this->photo_path)
            : null;
    }

    // Helper: get full sign URL
    public function getSignUrlAttribute(): ?string
    {
        return $this->sign_path
            ? asset('storage/' . $this->sign_path)
            : null;
    }
}
