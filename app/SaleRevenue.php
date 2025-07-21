<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaleRevenue extends Model
{
    public function party(){
        return $this->belongsTo(PartyInfo::class,'party_id');
    }

    public function items(){
        return $this->hasMany(SaleRevenueItem::class,'sale_id');
    }

    public function receipts(){
        return $this->hasMany(ReceiptSale::class,'sale_id');
    }
}
