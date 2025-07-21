<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TollFeeInvoice extends Model
{
    public function customer(){
        return $this->belongsTo(PartyInfo::class, 'customer_id');
    }
    public function project(){
        return $this->belongsTo(ProjectDetail::class,'project_id');
    }
    public function rak_toll_count($id){
        $qty = TollFeeInvoiceItem::where('invoice_id', $id)->where('rak_toll','!=',null)->get();
        return count($qty);
    }
    public function fujairah_toll_count($id){
        $qty = TollFeeInvoiceItem::where('invoice_id', $id)->where('fujairah_toll','!=',null)->get();
        return count($qty);
    }
    public function sharjah_toll_count($id){
        $qty = TollFeeInvoiceItem::where('invoice_id', $id)->where('sharjah_toll','!=',null)->get();
        return count($qty);
    }
}
