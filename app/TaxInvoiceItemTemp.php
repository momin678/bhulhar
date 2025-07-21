<?php

namespace App;

use App\Models\AccountHead;
use Illuminate\Database\Eloquent\Model;

class TaxInvoiceItemTemp extends Model
{
    public function invoice(){
        return $this->belongsTo(TaxInvoice::class);
    }

    public function truck(){
        return $this->belongsTo(Truck::class,'truck_id');
    }

    public function record(){
        return $this->belongsTo(TruckRecords::class,'item_id');
    }

    public function supplier(){
        return $this->belongsTo(PartyInfo::class,'supplier_id');
    }

    public function head(){
        return $this->belongsTo(AccountHead::class,'head_id');
    }

    public function vehicle(){
        return $this->belongsTo(Truck::class,'truck_id');
    }




}
