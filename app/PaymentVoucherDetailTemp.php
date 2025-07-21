<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentVoucherDetailTemp extends Model
{
    public function supplier_invoice(){
        return $this->belongsTo(SupplierInvoice::class, 'invoice_id');
    }
}
