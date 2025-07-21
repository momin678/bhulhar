<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'name', 'unit_id',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
