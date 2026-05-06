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
        Schema::create('intruder_alerts', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address')->nullable();
            $table->string('username_attempted')->nullable();
            $table->string('photo_path')->nullable();
            $table->string('location')->nullable();
            $table->string('city')->nullable();
            $table->string('browser')->nullable();
            $table->timestamp('attempt_time');
            $table->boolean('is_resolved')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intruder_alerts');
    }
};
