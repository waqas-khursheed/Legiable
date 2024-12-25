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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string("company_name")->nullable();
            $table->longText("about_app")->nullable();
            $table->date("election_date")->nullable();
            $table->timestamps();
        });

        DB::table('settings')->insert([
            [
                'company_name' => 'Legible',
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
        Schema::dropIfExists('settings');
    }
};
