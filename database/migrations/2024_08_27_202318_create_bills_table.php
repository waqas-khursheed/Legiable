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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('congress')->nullable(); 
            $table->string('type', 255)->nullable(); 
            $table->string('originChamber', 255)->nullable(); 
            $table->string('originChamberCode', 255)->nullable(); 
            $table->bigInteger('number')->nullable(); 
            $table->longText('url')->nullable(); 
            $table->longText('title')->nullable(); 
            $table->date('latestActionDate')->nullable(); 
            $table->time('latestActionTime')->nullable(); // Action time might be nullable
            $table->longText('latestActionText')->nullable(); 
            $table->date('updateDate')->nullable(); 
            $table->datetime('updateDateIncludingText')->nullable(); // Change to datetime
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
