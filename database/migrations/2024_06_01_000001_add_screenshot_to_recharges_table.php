<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddScreenshotToRechargesTable extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('recharges', 'screenshot')) {
            Schema::table('recharges', function (Blueprint $table) {
                $table->string('screenshot')->nullable()->after('txid');
                $table->string('sender_number')->nullable()->after('screenshot');
            });
        }
    }

    public function down()
    {
        Schema::table('recharges', function (Blueprint $table) {
            $table->dropColumn(['screenshot', 'sender_number']);
        });
    }
}
