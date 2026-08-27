<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Police extends Model
{
    protected $guarded = [];
    
    protected $table = 'police_clearances';
    
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    
    
}