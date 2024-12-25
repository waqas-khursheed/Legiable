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
        Schema::create('budget_functions', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable(); 
            $table->string('type')->nullable();           
            $table->string('name')->nullable();         
            $table->decimal('amount', 20, 2)->nullable(); 
            $table->year('year')->nullable();  
            $table->timestamps();
            $table->unique(['code', 'year']); // Unique constraint on code and year
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budget_functions');
    }
};
