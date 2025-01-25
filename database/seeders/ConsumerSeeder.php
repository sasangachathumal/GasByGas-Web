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
            'user_id' => 4,
            'nic' => '928374591V',
            'phone_no' => '+094710453447',
            'type' => ConsumerType::Customer->value,
            'business_no' => null,
            'status' => StatusType::Approved->value,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('consumers')->insert([
            'user_id' => 5,
            'nic' => '098765434567',
            'phone_no' => '+094710093447',
            'type' => ConsumerType::Business->value,
            'business_no' => 'RTS-44552299C',
            'status' => StatusType::Pending->value,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('consumers')->insert([
            'user_id' => 6,
            'nic' => '925674591V',
            'phone_no' => '+094090453447',
            'type' => ConsumerType::Customer->value,
            'business_no' => null,
            'status' => StatusType::Approved->value,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
