<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('late_fee_settings', function (Blueprint $table) {
            $table->id();
            $table->decimal('daily_rate', 8, 2)->default(1.00);
            $table->integer('grace_period_days')->default(0);
            $table->decimal('max_late_fee', 8, 2)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Insert default settings
        DB::table('late_fee_settings')->insert([
            'daily_rate' => 1.00,
            'grace_period_days' => 0,
            'max_late_fee' => null,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('late_fee_settings');
    }
};
