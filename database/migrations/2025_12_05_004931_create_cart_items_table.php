<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();

            // Foreign keys to users and books tables
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Cascades delete on user
            $table->foreignId('book_id')->constrained()->onDelete('cascade'); // Cascades delete on book

            // Additional fields related to the cart item
            $table->integer('days')->default(1); // Default to 1 day, customizable
            $table->decimal('fee', 8, 2)->default(0); // Fee for renting/borrowing
            $table->decimal('deposit', 8, 2)->default(0); // Refundable deposit

            // Status of the cart item
            $table->string('status')->default('in-cart'); // Track status (in-cart, rented, etc.)

            // Timestamps for created and updated times
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
