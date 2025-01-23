<?php

namespace Database\Seeders;

use App\RequestStatusType;
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
            'consumer_id' => 1,
            'type' => RequestType::Customer->value,
            'status' => RequestStatusType::Pending->value,
            'token' => 'GAS-00534',
            'quantity' => 1,
            'expired_at' => date('Y-m-d', strtotime(now().' + 14 days')),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('requests')->insert([
            'schedule_id' => 1,
            'gas_id' => 1,
            'consumer_id' => 2,
            'type' => RequestType::Business->value,
            'status' => RequestStatusType::Pending->value,
            'token' => 'GAS-00535',
            'quantity' => 24,
            'expired_at' => date('Y-m-d', strtotime(now().' + 14 days')),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
