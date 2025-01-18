<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            UserSeeder::class,
            AdminSeeder::class,
            OutletSeeder::class,
            GasSeeder::class,
            ScheduleSeeder::class,
            RequestSeeder::class,
            ConsumerSeeder::class,
        ]);
    }
}
