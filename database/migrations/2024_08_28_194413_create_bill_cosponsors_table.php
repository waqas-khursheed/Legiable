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
        Schema::create('bill_cosponsors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bill_id')->nullable();
            $table->foreign('bill_id')->references('id')->on('bills')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('congress')->nullable(); 
            $table->bigInteger('bill_number')->nullable();
            $table->string('bioguideId', 255)->nullable();
            $table->bigInteger('district')->nullable();
            $table->string('firstName', 255)->nullable();
            $table->string('fullName', 255)->nullable();
            $table->boolean('isOriginalCosponsor')->default(false);
            $table->string('lastName', 255)->nullable();
            $table->string('party', 255)->nullable();
            $table->date('sponsorshipDate')->nullable();
            $table->string('state', 255)->nullable();
            $table->longText('url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bill_cosponsors');
    }
};
