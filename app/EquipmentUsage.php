<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EquipmentUsage extends Model
{
    protected $guarded = [];

    public function item(){
        return $this->belongsTo(Item::class);
    }
}
