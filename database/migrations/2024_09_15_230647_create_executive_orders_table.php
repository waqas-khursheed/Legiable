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
        Schema::create('executive_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('executive_leader_id')->nullable();
            $table->longText('title')->nullable(); 
            $table->text('type')->nullable(); 
            $table->string('document_number', 255)->nullable(); 
            $table->longText('html_url')->nullable(); 
            $table->longText('pdf_url')->nullable()->nullable(); 
            $table->longText('public_inspection_pdf_url')->nullable()->nullable(); 
            $table->date('publication_date')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('executive_orders');
    }
};
