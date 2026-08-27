<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('golden_cards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('card_no', 50)->unique();
            $table->string('name_bn', 255);
            $table->string('mother_bn', 255);
            $table->string('father_bn', 255);
            $table->string('disability_bn', 255);
            $table->string('dob', 20);
            $table->string('id_no', 50);
            $table->text('address_bn');
            $table->string('issue_date', 20);
            $table->string('name_en', 255);
            $table->string('mother_en', 255);
            $table->string('father_en', 255);
            $table->string('disability_en', 255);
            $table->string('blood_group', 20)->nullable();
            $table->string('mobile', 20);
            $table->text('address_en');
            $table->string('photo', 255)->nullable();
            $table->string('signature', 255)->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index('user_id');
            $table->index('card_no');
        });
    }

    public function down()
    {
        Schema::dropIfExists('golden_cards');
    }
};
