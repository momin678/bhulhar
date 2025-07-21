<?php

use App\Setting;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::updateOrCreate([
            'config_name' => 'school_name',
            'config_value' => 'Bangladesh English Private School',
        ]);

        Setting::updateOrCreate([
            'config_name' => 'school_address',
            'config_value' => 'Ras Al Khaimah, UAE',
        ]);

        Setting::updateOrCreate([
            'config_name' => 'school_tele',
            'config_value' => '01914000000',
        ]);

        Setting::updateOrCreate([
            'config_name' => 'school_email',
            'config_value' => 'beps@email.com',
        ]);
    }
}
