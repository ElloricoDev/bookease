<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            LateFeeSettingSeeder::class,
            UserSeeder::class,
            BookSeeder::class,
            BorrowedBookSeeder::class,
            ReservationSeeder::class,
        ]);
    }
}
