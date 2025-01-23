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
            'email' => 'admin@gasbygas.com',
            'password' => Hash::make('secret'),
            'type' => UserType::Admin->value,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'email' => 'kumara@gasbygas.com',
            'password' => Hash::make('secret'),
            'type' => UserType::Outlet_Manager->value,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'email' => 'sandeepa@gasbygas.com',
            'password' => Hash::make('secret'),
            'type' => UserType::Outlet_Manager->value,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'email' => 'aravinda@gasbygas.com',
            'password' => Hash::make('secret'),
            'type' => UserType::Consumer->value,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'email' => 'business@gasbygas.com',
            'password' => Hash::make('secret'),
            'type' => UserType::Consumer->value,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
