<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('borrowed_books', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('book_id')->constrained()->onDelete('cascade');

            $table->integer('days');
            $table->decimal('fee', 8, 2);
            $table->decimal('deposit', 8, 2);

            $table->date('borrowed_at')->nullable();
            $table->date('due_date')->nullable();
            $table->date('returned_at')->nullable();

            $table->decimal('late_fee', 8, 2)->default(0);

            $table->string('payment_type')->default('cash');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('borrowed_books');
    }
};
