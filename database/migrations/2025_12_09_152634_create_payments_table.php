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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('borrowed_book_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('type', ['rent_fee', 'deposit', 'late_fee', 'refund'])->default('rent_fee');
            $table->decimal('amount', 8, 2);
            $table->enum('method', ['cash', 'card', 'online'])->default('cash');
            $table->enum('status', ['pending', 'completed', 'refunded', 'failed'])->default('completed');
            $table->string('transaction_id')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
