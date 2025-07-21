<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LpoProject extends Model
{
    protected $guarded=[];

    public function tasks(){
        return $this->hasMany(LpoPorjectTask::class);
    }

    public function party(){
        return $this->belongsTo(PartyInfo::class,'customer_id');
    }
}
