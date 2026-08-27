<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Surokkha extends Model
{
    protected $guarded = [];
    
    protected $table = 'surokkha';
    
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    
    
}