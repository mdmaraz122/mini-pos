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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('username', 20)->unique();
            $table->string('first_name', 50);
            $table->string('middle_name')->nullable();
            $table->string('last_name', 50);
            $table->string('email', 200)->unique();
            $table->string('phone', 200)->unique();
            $table->string('password', 800);
            $table->string('dob')->nullable();
            $table->string('gender')->nullable();
            $table->string('image')->nullable();
            $table->string('otp')->nullable();
            $table->string('token', 1500)->nullable();
            $table->enum('2fa_status', ['Enabled', 'Disabled'])->default('Disabled');
            $table->enum('status', ['Active', 'Inactive', 'Unverified', 'Locked'])->default('Unverified');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
