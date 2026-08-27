<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUniqueCodeToKhatiansTable extends Migration
{
    public function up()
    {
        Schema::table('khatians', function (Blueprint $table) {
            $table->string('unique_code')->nullable()->after('amount_in_words');
        });
    }

    public function down()
    {
        Schema::table('khatians', function (Blueprint $table) {
            $table->dropColumn('unique_code');
        });
    }
}
