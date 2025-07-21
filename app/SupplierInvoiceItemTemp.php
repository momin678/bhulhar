<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupplierInvoiceItemTemp extends Model
{
    public function invoice(){
        return $this->belongsTo(SupplierInvoiceTemp::class);
    }

    public function truck(){
        return $this->belongsTo(Truck::class,'truck_id');
    }
}
