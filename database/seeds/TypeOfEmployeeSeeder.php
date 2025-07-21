<?php

use App\TypeOfEmployee;
use Illuminate\Database\Seeder;

class TypeOfEmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TypeOfEmployee::updateOrCreate(['name' => 'Teacher']);
        TypeOfEmployee::updateOrCreate(['name' => 'Admin']);
        TypeOfEmployee::updateOrCreate(['name' => 'Accounts Executive']);
        TypeOfEmployee::updateOrCreate(['name' => 'Librarian']);
        TypeOfEmployee::updateOrCreate(['name' => 'Others']);
    }
}
