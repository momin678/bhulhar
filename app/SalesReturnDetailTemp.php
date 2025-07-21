<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesReturnDetailTemp extends Model
{
    protected $table = "sales_return_details_temp";
    public function itemName(){
        return $this->belongsTo(ItemList::class, "item_id","item_id");
    }
}
