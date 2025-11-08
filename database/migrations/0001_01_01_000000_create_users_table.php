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
            $table->uuid('id')->primary();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('firstname', 35);
            $table->string('lastname', 35);
            $table->timestamp('email_verified_at')->nullable();
            $table->enum('role', ['student', 'donor', 'admin'])->default('student'); // 👈 added
            $table->rememberToken();
            $table->timestamps();
            $table->string('avatar', 500)->nullable();
            
            // Fields specific to the 'student' role
            $table->string('student_id', 50)->nullable()->index();
            $table->string('department', 255)->nullable();
            
            // Status and Activity Fields
            $table->boolean('verified')->default(false)->index(); // Should default to false for new signups
            $table->dateTime('last_login')->nullable();
            $table->boolean('is_active')->default(true);
            
            // Fields for password reset logic
            $table->string('reset_password_token', 255)->nullable();
            $table->dateTime('reset_password_expires')->nullable();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
