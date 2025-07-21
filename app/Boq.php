<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Boq extends Model
{
    public function items()
    {
        return $this->hasMany(BoqItem::class);
    }

    public function customerInfo()
    {
        return $this->belongsTo(PartyInfo::class,'customer');
    }

    public function branch()
    {
        return $this->belongsTo(ProjectDetail::class,'project');
    }
}
