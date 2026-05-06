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
        Schema::table('admins', function (Blueprint $table) {
            $table->string('role')->default('ADMIN')->after('password'); // ADMIN, MANAGER
        });

        Schema::table('booking_passengers', function (Blueprint $table) {
            $table->string('seat_class')->default('ECONOMY')->after('full_name'); // EXECUTIVE, BUSINESS, ECONOMY
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn('role');
        });

        Schema::table('booking_passengers', function (Blueprint $table) {
            $table->dropColumn('seat_class');
        });
    }
};
