<?php

namespace App\Http\Controllers\backend;

use App\Brand;
use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\BrandStoreRequest;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $brands=Brand::get();
        $brand = new Brand();

        return view('backend.brand.index',compact('brands','brand'));
    }

    public function store(Request $request)
    {

        Brand::create($request->validate([
            'name' => 'required|unique:brands,name',
        ]));

        $notification= array(
            'message'       => 'Brand Added successfully!',
            'alert-type'    => 'success'
        );
        return back()->with($notification);
    }

    public function edit(Brand $brand)
    {
        $brands= Brand::get();
        return view('backend.brand.index',compact('brands','brand'));
    }


    public function update(Request $request,Brand $brand)
    {
        $request->validate([
            'name' => 'required|unique:brands,name,' .$brand->id,
        ]);
        $brand = Brand::find($brand->id);
        $brand->name = $request->name;
        $brand->save();
        $notification= array(
            'message'       => 'Brand updated successfully',
            'alert-type'    => 'success'
        );
        return redirect('service-inventory/brand')->with($notification);
    }


    public function destroy($id)
    {


        $brand = Brand::find($id);
        if( $brand->actionCheck())
        {
         $notification= array(
             'message'       => 'This Have Action on Invoice or Purchase or LPO or Quotation. Can not be deleted',
             'alert-type'    => 'error'
         );
         return back()->with($notification);
        }
        else
        {
            $brand->delete();
            $notification= array(
                'message'       => 'Brand Deleted successfully!',
                'alert-type'    => 'success'
            );
            return back()->with($notification);
        }
    }

    public function delete($id)
    {
        $brand = Brand::find($id);
        if( $brand->actionCheck())
        {
         $notification= array(
             'message'       => 'This Have Action on Invoice or Purchase or LPO or Quotation. Can not be deleted',
             'alert-type'    => 'error'
         );
         return back()->with($notification);
        }
        else
        {
            $brand->subBrands->each->delete();
        $brand->products->each->delete();
        $brand->delete();
        $notification= array(
            'message'       => 'Brand Deleted successfully!',
            'alert-type'    => 'success'
        );
        return back()->with($notification);
        }
    }


    public function brandEditModal(Request $request)
    {
        $brand= Brand::find($request->id);
        return view('backend.brand.brandEditModal', compact('brand'));
    }

    public function brandAddModal(Request $request)
    {
        $category= Category::find($request->id);
        return view('backend.brand.addBrandModal', compact('category'));
    }
}
