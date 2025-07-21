<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReceiptVoucherDetailTemp extends Model
{
    public function tax_invoice(){
        return $this->belongsTo(TaxInvoice::class, 'invoice_id');
    }
}
