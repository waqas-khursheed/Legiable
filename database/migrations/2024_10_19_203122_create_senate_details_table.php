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
        Schema::create('senate_details', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable();
            $table->longText('additional_information')->nullable();
            $table->text('image')->nullable();
            $table->timestamps();
        });

        DB::table('senate_details')->insert([
            [
                'title' => 'senate Title',
                'created_at' => '2024-03-10 13:32:33',
                'updated_at' => now(),
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('senate_details');
    }
};
