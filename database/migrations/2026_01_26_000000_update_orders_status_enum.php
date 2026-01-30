<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add new statuses to enum: awaiting, pending, shipping, delivered, completed, cancelled
        DB::statement("ALTER TABLE `orders` MODIFY `status` ENUM('awaiting','pending','shipping','delivered','completed','cancelled') NOT NULL DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original smaller enum
        DB::statement("ALTER TABLE `orders` MODIFY `status` ENUM('pending','completed','cancelled') NOT NULL DEFAULT 'pending'");
    }
};
