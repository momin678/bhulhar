<?php

use App\GradingRange;
use Illuminate\Database\Seeder;

class GradingRangeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GradingRange::updateOrCreate([
            'grade'=>'A+',
            'range_to'=>80,
            'range_from'=>100,
            'gpa'=> 5,
            'gpa_from'=>5,
            'remark'=>'Excellent'
        ]);
        GradingRange::updateOrCreate([
            'grade'=>'A',
            'range_to'=>70,
            'range_from'=>79,
            'gpa'=> 4,
            'gpa_from'=>4.99,
            'remark'=>'Very Good'
        ]);
        GradingRange::updateOrCreate([
            'grade'=>'A-',
            'range_to'=>60,
            'range_from'=>69,
            'gpa'=> 3.5,
            'gpa_from'=>3.99,
            'remark'=>'Good'
        ]);
        GradingRange::updateOrCreate([
            'grade'=>'B',
            'range_to'=>50,
            'range_from'=>59,
            'gpa'=> 3,
            'gpa_from'=>3.49,
            'remark'=>'Fair'
        ]);
        GradingRange::updateOrCreate([
            'grade'=>'C',
            'range_to'=>40,
            'range_from'=>49,
            'gpa'=> 2,
            'gpa_from'=>2.99,
            'remark'=>'Not Satifactory'
        ]);
        GradingRange::updateOrCreate([
            'grade'=>'D',
            'range_to'=>33,
            'range_from'=>39,
            'gpa'=> 1,
            'gpa_from'=>1.99,
            'remark'=>'To Be Improved'
        ]);
        GradingRange::updateOrCreate([
            'grade'=>'F',
            'range_to'=>00,
            'range_from'=>32,
            'gpa'=> 0,
            'gpa_from'=>0.99,
            'remark'=>'Work Hard'
        ]);
    }
}
