<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKhatiansTable extends Migration
{
    public function up()
    {
        Schema::create('khatians', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('khatian_no')->nullable();
            $table->string('district')->nullable();
            $table->string('upazila')->nullable();
            $table->string('mouza')->nullable();
            $table->string('jl_no')->nullable();
            $table->string('app_no')->nullable();
            $table->string('app_date')->nullable();
            $table->string('mutation_case_no')->nullable();
            $table->string('dcr_no')->nullable();
            $table->string('khatian_pid')->nullable();
            $table->string('ac_name')->nullable();
            $table->text('seal')->nullable();
            $table->string('total_land_val')->nullable();
            $table->string('amount_in_words')->nullable();
            $table->text('owners_json')->nullable();
            $table->text('lands_json')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('khatians');
    }
}
