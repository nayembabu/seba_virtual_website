<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisaApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visa_applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('visa_number', 50);
            $table->string('full_name', 255);
            $table->date('date_of_birth');
            $table->string('citizenship', 100);
            $table->string('passport_number', 50);
            $table->string('travel_document_type', 50);
            $table->date('passport_issue_date');
            $table->date('passport_expiry_date');
            $table->string('visa_type', 100);
            $table->string('visa_validity', 100);
            $table->string('number_of_entries', 50);
            $table->integer('period_of_stay');
            $table->string('invitation', 255)->nullable();
            $table->datetime('visa_issue_date');
            $table->string('profile_photo', 255)->nullable();
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visa_applications');
    }
}