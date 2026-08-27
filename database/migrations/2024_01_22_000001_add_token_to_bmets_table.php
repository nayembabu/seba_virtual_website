<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTokenToBmetsTable extends Migration
{
    public function up()
    {
        Schema::table('bmets', function (Blueprint $table) {
            $table->string('token')->unique()->after('id')->nullable();
        });
    }

    public function down()
    {
        Schema::table('bmets', function (Blueprint $table) {
            $table->dropColumn('token');
        });
    }
}
