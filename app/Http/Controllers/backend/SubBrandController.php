<?php

namespace App\Http\Controllers\backend;

use App\Brand;
use App\Category;
use App\Http\Controllers\Controller;
use App\Product;
use App\ProductUnit;
use App\SubBrand;
use Illuminate\Http\Request;

class SubBrandController extends Controller
{
    public function subBrandAddModal(Request $request)
    {
        $brand= Brand::find($request->id);
        return view('backend.brand.addSubBrandModal', compact('brand'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        // dd($request->brand_id);
        $request->validate([
            'name' => 'required',
            'brand_id' => 'required'
        ]);
        $sub_brand=SubBrand::create([
            'name' => $request->name,
            'brand_id' => $request->brand_id,
            'sale_price' => $request->price
        ]);
        // dd($sub_brand);
        $brand=Brand::find($request->brand_id);
        $latest_barcode=Product::orderBy('id','DESC')->first();
        if($latest_barcode){
            $code=preg_replace('/^AHT-/', '', $latest_barcode->barcode);
            $newcode=$code+1;
            $barcode="AHT-".$newcode;
        }else{
            $barcode="AHT-1000";
        }
        $category_info = Category::find($brand->category_id);
        $product=Product::create([
            'name' => $category_info->name.' '.$brand->name.' '.$request->name,
            'category_id' => $brand->category_id,
            'sub_brand_id' => $sub_brand->id,
            'brand_id' => $brand->id,
            'barcode' => $barcode,
            'sale_price' =>  $sub_brand->sale_price,
        ]);

        if($product->category_id==4 || $product->category_id==10)
        {
            ProductUnit::create([
                // 'name' => $request->name,
                'product_id' => $product->id,
                'unit_id' => 1,
            ]);

            ProductUnit::create([
                // 'name' => $request->name,
                'product_id' => $product->id,
                'unit_id' => 2,
            ]);
        }
        else
        {
            ProductUnit::create([
                // 'name' => $request->name,
                'product_id' => $product->id,
                'unit_id' => 3,
            ]);
        }

        $notification= array(
            'message'       => 'Sub-Brand Added successfully!',
            'alert-type'    => 'success'
        );
        return back()->with($notification);
    }

    public function delete($id)
    {
        $subBrand = SubBrand::find($id);
       if( $subBrand->actionCheck())
       {
        // dd(1);
        $notification= array(
            'message'       => 'This Have Action on Invoice or Purchase or LPO or Quotation. Can not be deleted',
            'alert-type'    => 'error'
        );
        return back()->with($notification);
       }
       else
       {
        $subBrand->products->each->delete();
        $subBrand->delete();
        $notification= array(
            'message'       => 'Sub-Brand Deleted successfully!',
            'alert-type'    => 'success'
        );
        return back()->with($notification);
       }
    }
}
