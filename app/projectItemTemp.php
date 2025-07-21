<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class projectItemTemp extends Model
{
    public function itemName()
    {
        return $this->belongsTo(Item::class,'item');
    }
}
