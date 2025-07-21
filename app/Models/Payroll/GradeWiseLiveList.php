<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Model;

class GradeWiseLiveList extends Model
{
    public function grades()
    {
        return $this->belongsTo(Grade::class, 'grade_id');
    }
    protected $guarded = [];
}
