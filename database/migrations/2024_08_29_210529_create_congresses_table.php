<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('congresses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->nullable();
            $table->string('startYear', 255)->nullable();
            $table->string('endYear', 255)->nullable();
            $table->string('number', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('congresses');
    }
};
