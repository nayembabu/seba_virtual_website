<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create("mark_sheets", function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("user_id");
            $table->string("student_name");
            $table->string("father_name");
            $table->string("mother_name");
            $table->string("roll_no");
            $table->string("registration_no");
            $table->string("exam_name");
            $table->string("board");
            $table->string("year", 10);
            $table->string("group_name")->nullable();
            $table->string("institute_name");
            $table->string("gpa", 10);
            $table->string("grade", 10);
            $table->string("result", 20);
            $table->json("subjects");
            $table->text("details")->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists("mark_sheets");
    }
};