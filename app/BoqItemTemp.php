<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BoqItemTemp extends Model
{
    protected $guarded=[];

    public function itemName()
    {
        return $this->belongsTo(Item::class,'item');
    }
}
