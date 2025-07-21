<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BoqTemp extends Model
{
    public function items()
    {
        return $this->hasMany(BoqItemTemp::class,'boq_id');
    }
}
