<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TempReceiptVoucherDetail extends Model
{
    public function sale()
    {
        return $this->belongsTo(Sale::class,'sale_id');
    }

    public function invoice()
    {
        return $this->belongsTo(TaxInvoice::class,'sale_id');
    }

    public function sale_revenue(){
        return $this->belongsTo(SaleRevenue::class, 'sale_id');
    }
}
