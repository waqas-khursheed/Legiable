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
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->text('content')->nullable();
            $table->enum('type', ['pp', 'tc']);
            $table->timestamps();
        });

        DB::table('contents')->insert([
            [
                'content' => 'Privacy Content',
                'type' => 'pp',
                'created_at' => '2023-08-31 13:32:33',
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'content' => 'Term & Condition',
                'type' => 'tc',
                'created_at' => '2023-08-31 13:32:33',
                'updated_at' => date("Y-m-d H:i:s")
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contents');
    }
};
