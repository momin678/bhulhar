<?php

namespace App\Imports;

use App\ProductImport as AppProductImport;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ProductImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        // dd($collection);
        foreach($collection as $item){
            if($item[0] && $item[0]!='CATEGORY'){
                $product = new AppProductImport;
                $product->category = $item[0];
                $product->vehicle_brand = $item[1];
                $product->vehicle_name = $item[2];
                $product->vehicle_model = $item[3];
                $product->item_code = $item[4];
                $product->save();
            }
        }
    }
}
