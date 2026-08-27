<?php

namespace App\Models;

use App\Http\Traits\Notify;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, Notify;
    
    protected $guarded = ['id'];
    protected $hidden = ['remember_token'];

    public function loginLogs()
    {
        return $this->hasMany(LoginLog::class);
    }

    public function recharges()
    {
        return $this->hasMany(Recharge::class);
    }

    // Define the relationship with Support model
    public function supports()
    {
        return $this->hasMany(Support::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}