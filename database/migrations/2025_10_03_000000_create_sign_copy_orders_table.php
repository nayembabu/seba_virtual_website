<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSignCopyOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('sign_copy_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('type');
            $table->string('nid_number');
            $table->string('name');
            $table->decimal('cost', 8, 2);
            $table->string('file_path')->nullable();
            $table->boolean('receipt')->default(false);
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sign_copy_orders');
    }
}