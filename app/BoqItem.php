<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BoqItem extends Model
{
    public function itemName()
    {
        return $this->belongsTo(Item::class,'item');
    }
}
