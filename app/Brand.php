<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = [ 'name','category_id'];

    public function subBrands()
    {
        return $this->hasMany(SubBrand::class, 'brand_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'brand_id');
    }

    public function actionCheck()
    {
        if($this->hasMany(PurchaseItem::class,'brand_id')->count()>0 )
        {
           return true;
        }
        return false;
    }
}
