<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('uttoradhikar_sonods', function (Blueprint $table) {
            $table->string('union_name')->nullable();
            $table->string('union_address')->nullable();
        });
    }

    public function down()
    {
        Schema::table('uttoradhikar_sonods', function (Blueprint $table) {
            $table->dropColumn(['union_name', 'union_address']);
        });
    }
};
