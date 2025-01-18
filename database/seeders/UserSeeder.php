<?php

namespace Database\Seeders;

use App\UserType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'email' => 'admin@softui.com',
            'password' => Hash::make('secret'),
            'type' => UserType::Admin->value,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'email' => 'outlet@softui.com',
            'password' => Hash::make('secret'),
            'type' => UserType::Outlet->value,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
