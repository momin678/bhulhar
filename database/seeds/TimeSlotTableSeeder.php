<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimeSlotTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('time_slots')->insert([
            'slot_no' => 1,
            'slot_time' => '8.00-9.45',
        ]);

        DB::table('time_slots')->insert([
            'slot_no' => 2,
            'slot_time' => '9.45-9.30',
        ]);

        DB::table('time_slots')->insert([
            'slot_no' => 3,
            'slot_time' => '9.30-10.15',
        ]);

        DB::table('time_slots')->insert([
            'slot_no' => 4,
            'slot_time' => '10.15-10.55',
        ]);

        DB::table('time_slots')->insert([
            'slot_no' => 5,
            'slot_time' => '11.15-11.55',
        ]);

        DB::table('time_slots')->insert([
            'slot_no' => 6,
            'slot_time' => '11.55-12.35',
        ]);

        DB::table('time_slots')->insert([
            'slot_no' => 7,
            'slot_time' => '12.35-1.15',
        ]);

        DB::table('time_slots')->insert([
            'slot_no' => 8,
            'slot_time' => '1.15-1.50',
        ]);

        DB::table('time_slots')->insert([
            'slot_no' => 9,
            'slot_time' => '1.50-2.35',
        ]);
    }
}
