<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupplierInvoiceTemp extends Model
{
    public function items(){
        return $this->hasMany(SupplierInvoiceItemTemp::class,'invoice_id');
    }

    public function supplier(){
        return $this->belongsTo(PartyInfo::class,'supplier_id');
    }

    public function project(){
        return $this->belongsTo(ProjectDetail::class,'project_id');
    }
}
