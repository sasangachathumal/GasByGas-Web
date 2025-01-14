<?php

namespace Database\Seeders;

use App\StatusType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('schedules')->insert([
            'outlet_id' => 1,
            'status' => StatusType::Pending->value,
            'approved_by' => null,
            'approved_date' => null,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
