<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('trade_license_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('city', ['dncc', 'dscc']);
            $table->string('license_no');
            $table->string('business_name');
            $table->string('owner_name');
            $table->string('father_husband_name');
            $table->string('mother_name');
            $table->string('business_nature');
            $table->string('business_type');
            $table->string('business_address_house')->nullable();
            $table->string('business_address_road')->nullable();
            $table->string('business_address_block')->nullable();
            $table->string('business_address_ward')->nullable();
            $table->string('business_address_thana')->nullable();
            $table->string('business_address_district')->nullable();
            $table->string('business_address_postcode')->nullable();
            $table->string('business_zone')->nullable();
            $table->string('business_ward_market')->nullable();
            $table->string('business_address_area')->nullable();
            $table->string('nid_passport_birth_no');
            $table->string('bin_no')->nullable();
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('financial_year');
            $table->date('business_start_date');
            $table->string('current_address_holding')->nullable();
            $table->string('current_address_road')->nullable();
            $table->string('current_address_village')->nullable();
            $table->string('current_address_thana')->nullable();
            $table->string('current_address_district')->nullable();
            $table->string('current_address_division')->nullable();
            $table->string('current_address_postcode')->nullable();
            $table->boolean('same_as_current_address')->default(false);
            $table->string('permanent_address_holding')->nullable();
            $table->string('permanent_address_road')->nullable();
            $table->string('permanent_address_village')->nullable();
            $table->string('permanent_address_thana')->nullable();
            $table->string('permanent_address_district')->nullable();
            $table->string('permanent_address_division')->nullable();
            $table->string('permanent_address_postcode')->nullable();
            $table->decimal('license_fee', 12, 2)->default(0);
            $table->decimal('surcharge', 12, 2)->default(0);
            $table->decimal('tax', 12, 2)->default(0);
            $table->decimal('due_amount', 12, 2)->default(0);
            $table->decimal('amendment_fee', 12, 2)->default(0);
            $table->decimal('signboard_fee', 12, 2)->default(0);
            $table->decimal('vat', 12, 2)->default(0);
            $table->decimal('book_price', 12, 2)->default(0);
            $table->decimal('form_fee', 12, 2)->default(0);
            $table->decimal('other_fee', 12, 2)->default(0);
            $table->decimal('total_fee', 12, 2)->default(0);
            $table->date('license_validity_date');
            $table->string('owner_photo')->nullable();
            $table->text('other_documents')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('trade_license_applications');
    }
};
