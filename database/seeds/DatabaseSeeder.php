<?php

use Illuminate\Database\Seeder;
use App\Setting;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(PermissionSeeder::class);
        // $this->call(RoleSeeder::class);
        // $this->call(UserSeeder::class);
        // $this->call(StudentClassSeeder::class);
        // $this->call(CountryTableSeeder::class);
        // $this->call(TypeOfEmployeeSeeder::class);
        // $this->call(TimeSlotTableSeeder::class);
        // $this->call(SettingsTableSeeder::class);
        $this->call(GradingRangeTableSeeder::class);
        // Setting::updateOrCreate([
        //     'config_name' => 'school_name',
        //     'config_value' => 'Bangladesh English Private School',
        // ]);

        // Setting::updateOrCreate([
        //     'config_name' => 'school_address',
        //     'config_value' => 'Ras Al Khaimah, UAE',
        // ]);

        // Setting::updateOrCreate([
        //     'config_name' => 'school_tele',
        //     'config_value' => '01914000000',
        // ]);

        // Setting::updateOrCreate([
        //     'config_name' => 'school_email',
        //     'config_value' => 'beps@email.com',
        // ]);
    }
}
