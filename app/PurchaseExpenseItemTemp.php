<?php

namespace App;

use App\Models\AccountHead;
use App\Models\CostCenter;
use Illuminate\Database\Eloquent\Model;

class PurchaseExpenseItemTemp extends Model
{
    public function head()
    {
        return $this->belongsTo(AccountHead::class,'head_id');
    }

    public function purchase()
    {
        return $this->belongsTo(PurchaseExpense::class,'purchase_expense_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class,'unit_id');
    }

    public function task()
    {
        return $this->belongsTo(JobProjectTask::class,'task_id');
    }
    public function costCenter()
    {
        return $this->belongsTo(Truck::class,'cost_center');
    }
}
