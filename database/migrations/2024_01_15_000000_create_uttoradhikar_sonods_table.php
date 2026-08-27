<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUttoradhikarSonodsTable extends Migration
{
    public function up()
    {
        Schema::create('uttoradhikar_sonods', function (Blueprint $table) {
            $table->id();
            $table->string('certificate_number');
            $table->string('person_bn');
            $table->string('person_en');
            $table->string('guardian_bn');
            $table->string('guardian_en');
            $table->string('village_id');
            $table->string('gender');
            $table->string('he_she_is');
            $table->string('death_certificates_id')->nullable();
            $table->date('dod')->nullable();
            $table->string('bengali_dod')->nullable(); // Add this line
            $table->json('relatives');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('uttoradhikar_sonods');
    }
}
