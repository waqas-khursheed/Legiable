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
        Schema::create('national_debts', function (Blueprint $table) {
            $table->id();
            $table->string('amount')->nullable();
            $table->date('record_date')->nullable();
            $table->timestamps();
        });

        DB::table('national_debts')->insert([
            [
                'amount' => '35327646622839.45',
                'record_date' => '2024-09-19', // Set a unique email
                'created_at' => '2024-01-10 13:32:33',
                'updated_at' => now(),
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('national_debts');
    }
};
