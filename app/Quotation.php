<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    public function partyName()
    {
        return $this->belongsTo(PartyInfo::class,'party_info');
    }
}
