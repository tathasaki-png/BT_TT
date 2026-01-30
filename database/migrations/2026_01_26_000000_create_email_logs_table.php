<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Optional: Track email sending history for auditing/debugging
     */
    public function up(): void
    {
        Schema::create('email_logs', function (Blueprint $table) {
            $table->id();
            $table->string('mailable_class')->comment('e.g. App\Mail\OrderCompletedMail');
            $table->morphs('mailable'); // Polymorphic relation to model (Order, etc)
            $table->string('recipient_email');
            $table->string('subject');
            $table->text('body')->nullable();
            $table->enum('status', ['pending', 'sent', 'failed'])->default('pending');
            $table->text('error_message')->nullable();
            $table->integer('retry_count')->default(0);
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
            
            $table->index(['mailable_type', 'mailable_id']);
            $table->index('recipient_email');
            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_logs');
    }
};
