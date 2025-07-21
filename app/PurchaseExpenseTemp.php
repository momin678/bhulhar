<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseExpenseTemp extends Model
{
    public function party()
    {
        return $this->belongsTo(PartyInfo::class,'party_id');
    }

    public function items()
    {
        return $this->hasMany(PurchaseExpenseItemTemp::class,'purchase_expense_id');

    }

    public function job_project()
    {
        return $this->belongsTo(JobProject::class,'job_project_id');
    }

    public function documents(){
        return $this->hasMany(DocumentTemp::class,'purchase_id');
    }

    public function client(){
        return $this->belongsTo(PartyInfo::class,'client_id');
    }
}
