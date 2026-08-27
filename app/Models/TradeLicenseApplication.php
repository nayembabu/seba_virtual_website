<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradeLicenseApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'city', 'license_no', 'business_name', 'owner_name',
        'father_husband_name', 'mother_name', 'business_nature', 'business_type',
        'business_address_house', 'business_address_road', 'business_address_block',
        'business_address_ward', 'business_address_thana', 'business_address_district',
        'business_address_postcode', 'business_zone', 'business_ward_market',
        'business_address_area', 'nid_passport_birth_no', 'bin_no', 'phone', 'email',
        'financial_year', 'business_start_date',
        'current_address_holding', 'current_address_road', 'current_address_village',
        'current_address_thana', 'current_address_district', 'current_address_division',
        'current_address_postcode', 'same_as_current_address',
        'permanent_address_holding', 'permanent_address_road', 'permanent_address_village',
        'permanent_address_thana', 'permanent_address_district', 'permanent_address_division',
        'permanent_address_postcode',
        'license_fee', 'surcharge', 'tax', 'due_amount', 'amendment_fee',
        'signboard_fee', 'vat', 'book_price', 'form_fee', 'other_fee', 'total_fee',
        'license_validity_date', 'owner_photo', 'other_documents', 'status'
    ];

    protected $casts = [
        'business_start_date' => 'date',
        'license_validity_date' => 'date',
        'same_as_current_address' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
