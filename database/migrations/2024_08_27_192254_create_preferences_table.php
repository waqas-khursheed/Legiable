<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('preferences', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        DB::table('preferences')->insert([
            [
                'name' => 'Environment',
                'created_at' => '2024-08-10 13:32:33',
                'updated_at' => now(),
            ],
            [
                'name' => 'Gun Control',
                'created_at' => '2024-08-10 13:32:33',
                'updated_at' => now(),
            ],
            [
                'name' => 'Police Perform',
                'created_at' => '2024-08-10 13:32:33',
                'updated_at' => now(),
            ],
            [
                'name' => 'Intense',
                'created_at' => '2024-08-10 13:32:33',
                'updated_at' => now(),
            ],
            [
                'name' => 'Employment',
                'created_at' => '2024-08-10 13:32:33',
                'updated_at' => now(),
            ],
            [
                'name' => 'Law',
                'created_at' => '2024-08-10 13:32:33',
                'updated_at' => now(),
            ],
            [
                'name' => 'Political',
                'created_at' => '2024-08-10 13:32:33',
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preferences');
    }
};
