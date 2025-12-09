<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LateFeeSetting;

class LateFeeSettingSeeder extends Seeder
{
    public function run(): void
    {
        LateFeeSetting::firstOrCreate(
            ['is_active' => true],
            [
                'daily_rate' => 1.00,
                'grace_period_days' => 0,
                'max_late_fee' => null,
            ]
        );
    }
}
