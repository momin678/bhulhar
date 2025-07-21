<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseReturnDetailsTemp extends Model
{
    protected $table = "purchase_return_details_temp";
    public function itemName(){
        return $this->belongsTo(ItemList::class, "item_id");
    }
}
