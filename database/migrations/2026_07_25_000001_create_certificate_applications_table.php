<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('certificate_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('certificate_no')->unique();
            $table->string('office_type')->default('ইউনিয়ন পরিষদ');
            $table->string('union_no')->nullable();
            $table->string('union_name')->nullable();
            $table->string('upazila')->nullable();
            $table->string('cert_type');
            $table->string('language')->default('bn');
            $table->date('issue_date');
            $table->string('applicant_name');
            $table->string('nid_no');
            $table->string('income_amount')->nullable();
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('spouse_name')->nullable();
            $table->string('present_village')->nullable();
            $table->string('present_post')->nullable();
            $table->string('present_upazila')->nullable();
            $table->string('present_district')->nullable();
            $table->text('members')->nullable();
            $table->string('prepared_by')->nullable();
            $table->text('prepared_seal_en')->nullable();
            $table->string('authority_title')->nullable();
            $table->string('authority_name')->nullable();
            $table->text('authority_seal_en')->nullable();
            $table->decimal('fee', 10, 2)->default(150);
            $table->string('status')->default('approved');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('certificate_applications');
    }
};
