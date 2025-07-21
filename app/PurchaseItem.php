<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    public function item()
    {
        // return 1;
        return $this->belongsTo(ItemList::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'cat_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function subBrand()
    {
        return $this->belongsTo(SubBrand::class, 'sub_brand_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function unitP()
    {
        return $this->belongsTo(Unit::class,'unit');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function purcahse(){
        return $this->hasOne(Purchase::class, 'id', 'purchase_id');
    }

}
