<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmartCardsTable extends Migration
{
    public function up()
    {
        Schema::create('smart_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name_bn');
            $table->string('name_en');
            $table->string('father_bn');
            $table->string('mother_bn');
            $table->string('profile_image');
            $table->string('signature_image');
            $table->date('dob');
            $table->string('nid_no');
            $table->text('address');
            $table->string('place_of_birth');
            $table->date('issue_date');
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('smart_cards');
    }
}
