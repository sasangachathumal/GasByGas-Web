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
        DB::table('gases')->insert([
            'weight' => '12.5KG',
            'price' => '4500',
            'image' => './test.jpeg',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
