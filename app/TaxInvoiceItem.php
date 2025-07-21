<?php

namespace App;

use App\Models\AccountHead;
use Illuminate\Database\Eloquent\Model;

class TaxInvoiceItem extends Model
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
    // mominul
    public function items(){
        return $this->hasMany(TaxInvoiceItem::class,'invoice_id');
    }

    public function customer(){
        return $this->belongsTo(PartyInfo::class,'customer_id');
    }

    public function project(){
        return $this->belongsTo(ProjectDetail::class,'project_id');
    }

    public function head(){
        return $this->belongsTo(AccountHead::class,'head_id');
    }

    public function vehicle(){
        return $this->belongsTo(Truck::class,'truck_id');
    }
}
