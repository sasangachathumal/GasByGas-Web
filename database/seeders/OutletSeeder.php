<?php

namespace Database\Seeders;

use App\StatusType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class OutletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('outlets')->insert([
            'email' => 'outlet1@gasbygas.com',
            'name' => 'ABC Mart',
            'address' => 'Gopaninuwala, Hikkaduwa.',
            'phone_no' => '+094710453447',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('outlets')->insert([
            'email' => 'outlet2@gasbygas.com',
            'name' => 'SDF Gas Mart',
            'address' => 'Pinkanda, Dodanduwa.',
            'phone_no' => '+094710873447',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
