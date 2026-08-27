<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('visa_applications', function (Blueprint $table) {
            // Check if updated_at doesn't exist and add it
            if (!Schema::hasColumn('visa_applications', 'updated_at')) {
                $table->timestamp('updated_at')->nullable();
            }
            
            // Check if created_at exists and modify it to be nullable
            if (Schema::hasColumn('visa_applications', 'created_at')) {
                $table->timestamp('created_at')->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('visa_applications', function (Blueprint $table) {
            // Remove updated_at if we need to roll back
            if (Schema::hasColumn('visa_applications', 'updated_at')) {
                $table->dropColumn('updated_at');
            }
            
            // Revert created_at to not nullable with default value
            if (Schema::hasColumn('visa_applications', 'created_at')) {
                $table->timestamp('created_at')->nullable(false)->default(DB::raw('CURRENT_TIMESTAMP'))->change();
            }
        });
    }
}