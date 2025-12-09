<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // Full Name
            $table->string('name');

            // Contact Number

            // Email (unique)
            $table->string('email')->unique();

            // Password (hashed)
            $table->string('password');

            // Role column for role-based login
            $table->string('role')->default('user');  // user / admin

            // Laravel timestamps
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
