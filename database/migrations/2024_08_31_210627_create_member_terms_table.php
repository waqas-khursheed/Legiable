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
        Schema::create('member_terms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id')->nullable();
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade')->onUpdate('cascade');            $table->string('bioguideId')->nullable(); // Foreign key to members table
            $table->string('chamber')->nullable();
            $table->bigInteger('congress')->nullable();
            $table->bigInteger('district')->nullable();
            $table->year('startYear')->nullable();
            $table->year('endYear')->nullable();
            $table->string('memberType')->nullable();
            $table->string('stateCode')->nullable();
            $table->string('stateName')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_terms');
    }
};
