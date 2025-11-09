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
        Schema::create('donations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            // Foreign Keys
            $table->foreignUuid('campaign_id')->constrained('campaigns')->onDelete('cascade')->index('idx_campaign');
            $table->foreignUuid('donor_id')->constrained('users')->onDelete('cascade')->index('idx_donor');
            
            // Financial Details
            $table->decimal('amount', 10, 2); // Gross donation amount
            $table->decimal('processor_fee', 10, 2)->default(0.00);
            $table->decimal('net_amount', 10, 2); // Net amount received by the campaign
            $table->decimal('refunded_amount', 10, 2)->default(0.00);
            
            // Transaction Details
            $table->string('transaction_id')->unique()->index('idx_transaction');
            $table->enum('payment_method', ['credit_card', 'paypal', 'bank_transfer']);
            $table->string('payment_processor', 50)->nullable();
            $table->enum('payment_status', ['pending', 'completed', 'failed', 'refunded'])->default('pending')->index('idx_payment_status');
            
            // Donor Preferences
            $table->boolean('anonymous')->default(false);
            $table->text('message')->nullable();
            $table->dateTime('refunded_at')->nullable();
            $table->timestamps();
            
            $table->index('created_at', 'idx_created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
