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
            'user_id' => 2,
            'email' => 'outlet@softui.com',
            'name' => 'Outlet',
            'address' => 'Gopaninuwala, Hikkaduwa.',
            'phone_no' => '+094710453447',
            'status' => StatusType::Pending->value,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
