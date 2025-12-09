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
            $table->integer('renewal_count')->default(0)->after('deposit_refunded');
            $table->integer('max_renewals')->default(2)->after('renewal_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('borrowed_books', function (Blueprint $table) {
            $table->dropColumn(['renewal_count', 'max_renewals']);
        });
    }
};
