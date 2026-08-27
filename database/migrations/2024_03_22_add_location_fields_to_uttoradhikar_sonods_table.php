<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('uttoradhikar_sonods', function (Blueprint $table) {
            $table->string('word_no')->nullable();
            $table->string('village_name')->nullable();
            $table->string('post_office')->nullable();
            $table->string('thana')->nullable();
            $table->string('upozila')->nullable();
            $table->string('zila')->nullable();
        });
    }

    public function down()
    {
        Schema::table('uttoradhikar_sonods', function (Blueprint $table) {
            $table->dropColumn([
                'word_no',
                'village_name',
                'post_office',
                'thana',
                'upozila',
                'zila'
            ]);
        });
    }
};
