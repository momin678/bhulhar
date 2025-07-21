<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded=[];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function subBrand()
    {
        return $this->belongsTo(SubBrand::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
    public function stock()
    {
        return $this->hasOne(Stock::class,'product_id');
    }
        public function purchaseItems()
    {
        return $this->hasMany(PurchaseItem::class);
    }
    public function velicleExpense()
    {
        return $this->hasMany(VehicleExpenseDetail::class , 'ac_id');
    }

    public function openingBalance($date)
    {
        $purchase=$this->hasMany(PurchaseItem::class,'product_id')->where('date','<',$date)->sum('amount');
        $allocation=$this->hasMany(VehicleExpenseDetail::class,'ac_id')->where('date','<',$date)->sum('quantity');
        return $purchase-$allocation;
    }

    public function purchase($date,$date1)
    {
        return $this->hasMany(PurchaseItem::class,'product_id')->where('date','>=',$date)->where('date','<=',$date1)->sum('amount');
    }
    public function allocation($date,$date1)
    {
        return $this->hasMany(VehicleExpenseDetail::class,'ac_id')->where('date','>=',$date)->where('date','<=',$date1)->sum('quantity');

    }
}
