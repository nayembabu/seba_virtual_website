<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dcrs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('office_address')->nullable();
            $table->string('dcr_no')->nullable();
            $table->string('deposit_date')->nullable();
            $table->string('office_logo')->nullable();
            $table->string('commissioner_name')->nullable();
            $table->string('signature_img')->nullable();
            $table->string('applicant_name')->nullable();
            $table->string('application_no')->nullable();
            $table->text('applicant_address')->nullable();
            $table->string('mutation_case_no')->nullable();
            $table->string('mutation_khatian_no')->nullable();
            $table->string('mutation_order_date')->nullable();
            $table->string('mutation_holding_no')->nullable();
            $table->string('mouza')->nullable();
            $table->string('jl_no')->nullable();
            $table->string('prev_khatian_type')->nullable();
            $table->string('prev_khatian_no')->nullable();
            $table->string('dag_no')->nullable();
            $table->string('land_amount')->nullable();
            $table->string('total_land_amount')->nullable();
            $table->string('dcr_fee')->nullable();
            $table->string('grand_total')->nullable();
            $table->string('unique_code')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dcrs');
    }
};
