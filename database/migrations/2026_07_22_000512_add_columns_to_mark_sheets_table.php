<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('mark_sheets', function (Blueprint $table) {
            if (!Schema::hasColumn('mark_sheets', 'date_of_birth')) {
                $table->date('date_of_birth')->nullable()->after('mother_name');
            }
            if (!Schema::hasColumn('mark_sheets', 'registration_no')) {
                $table->string('registration_no', 50)->nullable()->after('roll_no');
            }
            if (!Schema::hasColumn('mark_sheets', 'student_type')) {
                $table->string('student_type', 20)->default('REGULAR')->after('group_name');
            }
        });
    }

    public function down()
    {
        Schema::table('mark_sheets', function (Blueprint $table) {
            $columns = ['date_of_birth', 'registration_no', 'student_type'];
            foreach ($columns as $col) {
                if (Schema::hasColumn('mark_sheets', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};