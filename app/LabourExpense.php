<?php

namespace App;

use App\backend\LabourExpenseDetail;
use Illuminate\Database\Eloquent\Model;

class LabourExpense extends Model
{
    public function labour_items(){
        return $this->hasMany(LabourExpenseDetail::class, 'labour_expenses_id');
    }
}
