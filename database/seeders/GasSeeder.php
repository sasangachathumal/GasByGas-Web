<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class GasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('gas')->insert([
            'weight' => '2.3KG',
            'price' => '2000',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('gas')->insert([
            'weight' => '5KG',
            'price' => '3600',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('gas')->insert([
            'weight' => '12.5KG',
            'price' => '4500',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
