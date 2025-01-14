<?php

namespace Database\Seeders;

use App\RequestType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('requests')->insert([
            'schedule_id' => 1,
            'gas_id' => 1,
            'type' => RequestType::Consumer->value,
            'token' => 'GAS-00534',
            'quantity' => 1,
            'expired_at' => date('Y-m-d', strtotime(now().' + 14 days')),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('requests')->insert([
            'schedule_id' => 1,
            'gas_id' => 1,
            'type' => RequestType::Business->value,
            'token' => 'GAS-00535',
            'quantity' => 25,
            'expired_at' => date('Y-m-d', strtotime(now().' + 14 days')),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('requests')->insert([
            'schedule_id' => 1,
            'gas_id' => 1,
            'type' => RequestType::Outlet->value,
            'token' => 'GAS-00545',
            'quantity' => 20,
            'expired_at' => date('Y-m-d', strtotime(now().' + 14 days')),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
