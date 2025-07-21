<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public function items()
    {
        return $this->hasMany(ProjecetItem::class, 'pro_id');
    }

    public function customerInfo()
    {
        return $this->belongsTo(PartyInfo::class,'customer');
    }

    public function name()
    {
        return $this->belongsTo(ProjectDetail::class,'branch');
    }
}
