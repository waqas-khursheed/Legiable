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
        Schema::create('bill_p_d_f_s', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bill_id')->nullable();
            $table->foreign('bill_id')->references('id')->on('bills')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('congress')->nullable(); 
            $table->bigInteger('bill_number')->nullable();
            $table->string('type', 255)->nullable();
            $table->string('formatted_text_url', 255)->nullable();
            $table->string('pdf_url', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bill_p_d_f_s');
    }
};
