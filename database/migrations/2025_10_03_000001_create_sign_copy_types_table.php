<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSignCopyTypesTable extends Migration
{
    public function up()
    {
        Schema::create('sign_copy_types', function (Blueprint $table) {
            $table->id();
            $table->string('name_bn');  // Bangla name
            $table->string('name_en');  // English name (for internal use)
            $table->string('code');     // For form value (e.g., '60tk', '60tk_old')
            $table->decimal('cost', 8, 2);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Insert default types
        DB::table('sign_copy_types')->insert([
            [
                'name_bn' => '১৩ ডিজিট/নিবন্ধন/ধরন নং দিয়ে',
                'name_en' => '13 Digit/Registration/Type No',
                'code' => '60tk',
                'cost' => 60.00,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name_bn' => '১০/১২/১৭ ডিজিটি দিয়ে',
                'name_en' => '10/12/17 Digit',
                'code' => '60tk_old',
                'cost' => 60.00,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('sign_copy_types');
    }
}
