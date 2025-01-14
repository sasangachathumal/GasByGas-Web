<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admins')->insert([
            'user_id' => 1,
            'email' => 'admin@softui.com',
            'name' => 'Admin',
            'phone_no' => '+094710453447',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
