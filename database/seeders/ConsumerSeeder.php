<?php

namespace Database\Seeders;

use App\ConsumerType;
use App\StatusType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ConsumerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('consumers')->insert([
            'request_id' => 1,
            'nic' => '928374591V',
            'email' => 'consumer1@gmail.com',
            'phone_no' => '+094710453447',
            'type' => ConsumerType::Customer->value,
            'business_no' => null,
            'status' => StatusType::Approved->value,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('consumers')->insert([
            'request_id' => 2,
            'nic' => null,
            'email' => 'consumer1@gmail.com',
            'phone_no' => '+094710453447',
            'type' => ConsumerType::Customer->value,
            'business_no' => 'RTS-44552299C',
            'status' => StatusType::Approved->value,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
