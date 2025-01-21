<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class OutletManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('outlet_managers')->insert([
            'user_id' => 2,
            'outlet_id' => 1,
            'name' => 'Kumara Perera',
            'phone_no' => '+094710453447',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('outlet_managers')->insert([
            'user_id' => 3,
            'outlet_id' => 2,
            'name' => 'Sandeepa Amaraveera',
            'phone_no' => '+094710453447',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
