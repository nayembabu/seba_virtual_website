<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('electricity_bills', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');

            // General info
            $table->string('feeder')->nullable();
            $table->string('meter_seal')->nullable();
            $table->string('bill_no')->nullable();
            $table->string('cd')->nullable();
            $table->string('issue_date')->nullable();
            $table->string('office_code')->nullable();
            $table->string('bill_group')->nullable();
            $table->string('book')->nullable();
            $table->string('walk_order')->nullable();
            $table->string('bill_type')->nullable();

            // Customer info
            $table->string('customer_name')->nullable();
            $table->string('address')->nullable();
            $table->string('area_zone')->nullable();
            $table->string('customer_no')->nullable();
            $table->string('prev_acc')->nullable();
            $table->string('cust_cat')->nullable();
            $table->string('cust_status')->nullable();
            $table->string('conn_type')->nullable();

            // Meter info
            $table->string('tariff')->nullable();
            $table->string('std_rules')->nullable();
            $table->string('meter_no')->nullable();
            $table->string('meter_type')->nullable();
            $table->string('meter_cond')->nullable();
            $table->string('omf')->nullable();
            $table->string('load_val')->nullable();

            // Bill calculation
            $table->string('curr_date')->nullable();
            $table->string('prev_date')->nullable();
            $table->string('old_unit')->nullable();
            $table->string('curr_read')->nullable();
            $table->string('prev_read')->nullable();
            $table->string('consumed')->nullable();
            $table->string('cost_unit')->nullable();
            $table->string('demand_chg')->nullable();
            $table->string('rent')->nullable();
            $table->string('trans_rent')->nullable();
            $table->string('trans_loss')->nullable();
            $table->string('pfc')->nullable();
            $table->string('principal')->nullable();
            $table->string('vat')->nullable();
            $table->string('total_bill')->nullable();

            // Arrear & adjustment
            $table->string('arr_start')->nullable();
            $table->string('arr_end')->nullable();
            $table->string('prin_adj')->nullable();
            $table->string('lps_adj')->nullable();
            $table->string('vat_adj')->nullable();
            $table->string('prin_arr')->nullable();
            $table->string('curr_lps')->nullable();
            $table->string('vat_arr')->nullable();
            $table->string('total_vat')->nullable();
            $table->string('total_pay')->nullable();
            $table->string('last_date')->nullable();
            $table->string('after_due')->nullable();
            $table->string('pay_after_due')->nullable();
            $table->string('pay_desc')->nullable();

            // Bank info
            $table->string('pay_at')->nullable();
            $table->string('bank_code')->nullable();
            $table->string('branch_code')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('electricity_bills');
    }
};