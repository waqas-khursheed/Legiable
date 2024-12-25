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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('bioguideId')->unique();
            $table->string('partyName')->nullable();
            $table->year('birthYear')->nullable();
            $table->boolean('currentMember')->default(false);
            $table->text('depiction_attribution')->nullable();
            $table->string('depiction_imageUrl')->nullable();
            $table->string('directOrderName')->nullable();
            $table->string('firstName')->nullable();
            $table->string('honorificName')->nullable();
            $table->string('invertedOrderName')->nullable();
            $table->string('lastName')->nullable();
            $table->text('officialWebsiteUrl')->nullable();
            $table->string('state')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
