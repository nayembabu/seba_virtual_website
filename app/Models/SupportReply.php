<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportReply extends Model
{
    protected $fillable = [
        'support_id', 'user_id', 'reply', 'photo',
    ];

    public function support()
    {
        return $this->belongsTo(Support::class);
    }
    public function replies()
{
    return $this->hasMany(SupportReply::class);
}

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
