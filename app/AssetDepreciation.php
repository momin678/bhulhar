<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetDepreciation extends Model
{
    public function assetName()
    {
        return $this->belongsTo(Asset::class,'asset_id');
    }
}
