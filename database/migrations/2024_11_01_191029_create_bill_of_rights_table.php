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
        Schema::create('bill_of_rights', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable();
            $table->longText('personal_detail')->nullable();
            $table->longText('additional_information')->nullable();
            $table->timestamps();
        });

        DB::table('bill_of_rights')->insert([
            [
                'title' => 'The Bill Of Rights',
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
        Schema::dropIfExists('bill_of_rights');
    }
};
