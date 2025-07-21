<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubBrand extends Model
{
    protected $guarded=[];

    public function products()
    {
        return $this->hasMany(Product::class, 'sub_brand_id');
    }

    public function actionCheck()
    {
        if($this->hasMany(PurchaseItem::class,'sub_brand_id')->count()>0 )
        {
           return true;
        }
        return false;
    }
}
