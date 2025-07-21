<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseReturn1 extends Model
{
    protected $table = "purchase_returns1";
    
    public function item()
    {
        return $this->belongsTo(ItemList::class);
    }
}
