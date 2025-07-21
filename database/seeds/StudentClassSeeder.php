<?php

use App\Section;
use App\StudentClass;
use Illuminate\Database\Seeder;

class StudentClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // 
        $studentClass1 = StudentClass::updateOrCreate(['name' => 'Class One', 'number_of_seats' => 30]);
        Section::updateOrCreate([
            'student_class_id' => $studentClass1->id,
            'name' => 'A',
            'number_of_seats' => 30
        ]);

        Section::updateOrCreate([
            'student_class_id' => $studentClass1->id,
            'name' => 'B',
            'number_of_seats' => 30
        ]);

        $studentClass2 = StudentClass::updateOrCreate(['name' => 'Class Two', 'number_of_seats' => 30]);
        Section::updateOrCreate([
            'student_class_id' => $studentClass2->id,
            'name' => 'A',
            'number_of_seats' => 30
        ]);

        Section::updateOrCreate([
            'student_class_id' => $studentClass2->id,
            'name' => 'B',
            'number_of_seats' => 30
        ]);

        $studentClass3 = StudentClass::updateOrCreate(['name' => 'Class Three', 'number_of_seats' => 30]);
        Section::updateOrCreate([
            'student_class_id' => $studentClass3->id,
            'name' => 'A',
            'number_of_seats' => 30
        ]);

        Section::updateOrCreate([
            'student_class_id' => $studentClass3->id,
            'name' => 'B',
            'number_of_seats' => 30
        ]);
    }
}
