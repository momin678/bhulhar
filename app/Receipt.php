<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    public function party()
    {
        return $this->belongsTo(PartyInfo::class,'party_id');
    }
    public function items()
    {
        return $this->hasMany(ReceiptSale::class,'payment_id');
    }

    public function job_project()
    {
        return $this->belongsTo(JobProject::class,'job_project_id');
    }
}
