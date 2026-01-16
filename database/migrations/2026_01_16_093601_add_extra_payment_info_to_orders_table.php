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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('vnp_bank_code')->nullable()->after('transaction_id');
            $table->string('vnp_card_type')->nullable()->after('vnp_bank_code');
            $table->string('vnp_transaction_no')->nullable()->after('vnp_card_type');
            $table->string('vnp_response_code')->nullable()->after('vnp_transaction_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['vnp_bank_code', 'vnp_card_type', 'vnp_transaction_no', 'vnp_response_code']);
        });
    }
};
