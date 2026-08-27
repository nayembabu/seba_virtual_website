<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ElectricityBill extends Model
{
    protected $table = 'electricity_bills';

    protected $fillable = [
        'user_id',
        // General
        'feeder', 'meter_seal', 'bill_no', 'cd', 'issue_date', 'office_code',
        'bill_group', 'book', 'walk_order', 'bill_type',
        // Customer
        'customer_name', 'address', 'area_zone', 'customer_no', 'prev_acc',
        'cust_cat', 'cust_status', 'conn_type',
        // Meter
        'tariff', 'std_rules', 'meter_no', 'meter_type', 'meter_cond',
        'omf', 'load_val',
        // Bill
        'curr_date', 'prev_date', 'old_unit', 'curr_read', 'prev_read',
        'consumed', 'cost_unit', 'demand_chg', 'rent', 'trans_rent',
        'trans_loss', 'pfc', 'principal', 'vat', 'total_bill',
        // Arrear
        'arr_start', 'arr_end', 'prin_adj', 'lps_adj', 'vat_adj',
        'prin_arr', 'curr_lps', 'vat_arr', 'total_vat', 'total_pay',
        'last_date', 'after_due', 'pay_after_due', 'pay_desc',
        // Bank
        'pay_at', 'bank_code', 'branch_code',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}