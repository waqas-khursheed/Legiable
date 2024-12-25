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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('full_name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('profile_image')->nullable();
            $table->string('phone_number')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('user_type', ['user', 'guest'])->default('user');
            $table->string('address')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('location')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('country_code')->nullable();
            $table->string('country_iso_code')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->longText('about')->nullable();
            $table->text('preferences')->nullable();
            $table->text('member_preferences')->nullable();

            $table->string('customer_id')->nullable();

            $table->rememberToken();
            $table->enum('is_profile_complete', ['0', '1'])->default('0');
            $table->enum('social_type', ['google', 'facebook', 'apple', 'phone'])->nullable();
            $table->enum('device_type', ['ios', 'android', 'web'])->nullable();
            $table->string('social_token')->nullable();
            $table->string('device_token')->nullable();
            $table->enum('is_social', ['0', '1'])->default('0');
            $table->enum('push_notification', ['0', '1'])->default('1');
            $table->enum('alert_notification', ['0', '1'])->default('1');
            $table->enum('is_forgot', ['0', '1'])->default('0');
            $table->enum('is_verified', ['0', '1'])->default('0');
            $table->enum('is_subscribed', ['0', '1'])->default('0');
            $table->integer('verified_code')->nullable();
            $table->enum('is_active', ['0', '1'])->default('1');
            $table->enum('is_blocked', ['0', '1'])->default('0');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
