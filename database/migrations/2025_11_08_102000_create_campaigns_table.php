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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('creator_id')->constrained('users')->onDelete('cascade')->index('idx_creator');
            $table->string('title');
            $table->text('description');
            $table->enum('category', ['Technology', 'Social Impact', 'Research', 'Art & Design', 'Environment', 'Health'])->index('idx_category');
            $table->decimal('goal_amount', 10, 2);
            $table->decimal('current_amount', 10, 2)->default(0.00);
            $table->dateTime('deadline')->index('idx_deadline');
            $table->enum('status', ['draft', 'pending', 'approved', 'active', 'completed', 'rejected', 'canceled'])->default('draft')->index('idx_status');
            $table->string('image', 500)->nullable();
            $table->boolean('featured')->default(false)->index('idx_featured');
            $table->integer('views')->default(0);
            $table->text('rejection_reason')->nullable();
            $table->foreignUuid('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->dateTime('approved_at')->nullable();
            $table->foreignUuid('rejected_by')->nullable()->constrained('users')->onDelete('set null');
            $table->dateTime('rejected_at')->nullable();
            $table->timestamps();
            $table->dateTime('completed_at')->nullable();

            $table->index('created_at', 'idx_created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
