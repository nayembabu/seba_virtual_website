<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SignCopyOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'form_type',
        'form_type_name',
        'name',
        'nid',
        'dob',
        'form_data',
        'status',
        'status_note',
        'admin_note',
        'pdf_file',
        'is_money_back',
        'cost'
    ];

    protected $casts = [
        'form_data' => 'json',
        'dob' => 'date',
        'is_money_back' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFormTypeTextAttribute()
    {
        return match($this->form_type) {
            1 => '১০/১২/১৭ দিয়ে সাইন',
            2 => 'ফরম/নিবন্ধন নং দিয়ে সাইন',
            3 => 'অফিসিয়াল সারভার কপি',
            4 => 'NID CMS COPY',
            5 => 'নাম ঠিকানা দিয়ে সাইন',
            6 => 'ম্যাচ ফাউন্ড কপি',
            default => 'অজানা'
        };
    }

    public function getPriceAttribute()
    {
        return match($this->form_type) {
            1 => 50.00,
            2 => 60.00,
            3 => 70.00,
            4 => 80.00,
            5 => 90.00,
            6 => 100.00,
            default => 0.00
        };
    }
}