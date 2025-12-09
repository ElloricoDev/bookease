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
        Schema::table('borrowed_books', function (Blueprint $table) {
            $table->enum('borrow_status', ['pending', 'approved', 'borrowed', 'returned', 'overdue'])->default('borrowed')->after('payment_type');
            $table->enum('return_condition', ['good', 'fair', 'damaged', 'lost'])->nullable()->after('borrow_status');
            $table->text('return_notes')->nullable()->after('return_condition');
            $table->boolean('deposit_refunded')->default(false)->after('return_notes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('borrowed_books', function (Blueprint $table) {
            $table->dropColumn(['borrow_status', 'return_condition', 'return_notes', 'deposit_refunded']);
        });
    }
};
