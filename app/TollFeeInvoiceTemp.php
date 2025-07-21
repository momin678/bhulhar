<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TollFeeInvoiceTemp extends Model
{
    public function customer(){
        return $this->belongsTo(PartyInfo::class, 'customer_id');
    }
    public function project(){
        return $this->belongsTo(ProjectDetail::class,'project_id');
    }
    public function items(){
        return $this->hasMany(TollFeeInvoiceItemTemp::class, 'invoice_id');
    }
}
