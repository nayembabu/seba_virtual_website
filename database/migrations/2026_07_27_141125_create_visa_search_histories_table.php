<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisaSearchHistoriesTable extends Migration
{
    public function up()
    {
        Schema::create('visa_search_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('passport_no');
            $table->string('visa_no')->nullable();
            $table->string('applicant_name')->nullable();
            $table->string('country')->nullable();
            $table->decimal('charged_amount', 10, 2)->default(100);
            $table->text('api_response')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down()
    {
        Schema::dropIfExists('visa_search_histories');
    }
}