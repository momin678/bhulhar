<?php

namespace App\Http\Controllers\backend;

use App\Brand;
use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStoreRequest;
use App\Models\AccountHead;
use App\Models\MasterAccount;
use App\Product;
use App\ProductUnit;
use App\SubBrand;
use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $categories=Category::get();
        $brands= Brand::get();
        $product = new Product();
        $products=Product::orderBy('category_id','ASC')->get();
        $units = Unit::get();
        return view('backend.product.index', compact('categories', 'brands', 'products', 'product', 'units'));
    }

    public function store(Request $request)
    {

        $data =  $request->all();

        $latest_barcode= Product::latest()->first();

        if($latest_barcode)
        {
            $code=preg_replace('/^KT-/', '', $latest_barcode->barcode);
            $newcode=$code+1;
            $barcode="KT-".$newcode;
        }
        else
        {
            $barcode="KT-1000";
        }

        $data['barcode'] = $barcode;

        $product = Product::create($data);
        $acc=MasterAccount::whereIn('id',[3])->first();
        $accHeadL = AccountHead::where('ma_code', $acc->mst_ac_code)->orderBy('id','DESC')->first();
        $accHead = new AccountHead();
        if ($accHeadL) {
            $accHead->ac_code = $accHeadL->ac_code + 1;
        } else {
            $accHead->ac_code = 100;
        }

        $accHead->ma_code = $acc->mst_ac_code;
        $accHead->fld_ac_head = $product->name;
        $accHead->item_id = $product->id;
        $accHead->fld_ac_code = $acc->mst_ac_code . "-" . $accHead->ac_code;
        $accHead->fld_ms_ac_head = $acc->mst_ac_head;
        $accHead->fld_definition = $acc->mst_definition;
        $accHead->account_type_id= $acc->account_type_id;
        $accHead->master_account_id= $acc->id;
        $accHead->save();
        $notification= array(
            'message'       => 'Product Added successfully!',
            'alert-type'    => 'success'
        );

        return back()->with($notification);
    }

    public function edit(Product $product){
        $categories=Category::get();
        $brands=Brand::get();
        $products=Product::orderBy('category_id','ASC')->get();
        $sub_brands = SubBrand::get();
        $units = Unit::get();
        return view('backend.product.index',
        compact(
            'categories',
            'brands',
            'products',
            'product',
            'sub_brands',
            'units'
        ));
    }

    public function update(ProductStoreRequest $request,Product $product){
        $data = $request->all();
        $product->update($data);

        $notification= array(
            'message'       => 'Product Updated successfully!',
            'alert-type'    => 'success'
        );
        return redirect('service-inventory/product')->with($notification);
    }

    public function subBrand_fatch(Request $request)
    {
        $brand=Brand::find($request->brand);
        if($brand->subBrands->count()>0)
        {
            if ($request->ajax()) {
                return Response()->json([
                    'page' => view('backend.product.subBrand', ['brand' => $brand, 'i' => 1])->render(),

                ]);
            }
        }
    }

    public function brand_fatch(Request $request)
    {
        $cat=Category::find($request->category);
        if($cat->brands->count()>0)
        {
            if ($request->ajax()) {
                return Response()->json([
                    'page' => view('backend.product.brand', ['cat' => $cat, 'i' => 1])->render(),

                ]);
            }
        }
    }

    public function itemFatch(Request $request)
    {
        $products=Product::where('id',$request->item)->first();

            if ($request->ajax()) {
                return Response()->json([
                    'page' => view('backend.stock.product', ['products' => $products, 'i' => 1])->render(),
                    'url' => view('backend.stock.itemPrintUrl', ['products' => $products, 'i' => 1])->render(),
                ]);
            }
    }

    public function categoryProduct(Request $request)
    {
        $category=Category::where('id',$request->category)->first();

            if ($request->ajax()) {
                return Response()->json([
                    'page' => view('backend.stock.categoryProduct', ['category' => $category, 'i' => 1])->render(),
                    'url' => view('backend.stock.catPrintUrl', ['category' => $category, 'i' => 1])->render(),
                ]);
            }


    }


    public function delete($id)
    {
        $product = Product::find($id);
        $product->units->each->delete();
        $product->delete();
        $notification= array(
            'message'       => 'Product Deleted successfully!',
            'alert-type'    => 'success'
        );
        return back()->with($notification);
    }



    public function unit_fatch(Request $request)
    {
        $subBrand=SubBrand::find($request->brand);
        $brand=Brand::find($subBrand->brand_id);
        $category=Category::find($brand->category_id);
        if($category->name=="OIL" || $category->id==4 || $category->id==10)
        {
            $page = view('backend.product.unit')->render();
        }
        else
        {
            $page = view('backend.product.unit2')->render();
        }
        if($brand->subBrands->count()>0)
        {
            if ($request->ajax()) {
                return Response()->json([
                    'page' => $page,
                    'price' => $subBrand->sale_price

                ]);
            }
        }
    }


    public function amount(Request $request)
    {
        $subBrand=SubBrand::find($request->sub_brand);
        $brand=Brand::find($subBrand->brand_id);
        $category=Category::find($brand->category_id);
        if($request->unit=="1")
        {
            $price=$subBrand->sale_price/3.78541;
        }
        else
        {
            $price=$subBrand->sale_price;
        }
       return number_format($price,2);
    }
    public function get_product_info(Request $request){
        $product = Product::find($request->product_id);
        $category = Category::find($product->category_id);
        $brand = null;
        if($product->brand_id){
            $brand = Brand::find($product->brand_id);
        }
        $unit = Unit::find($product->unit_id);
        return [$product, $category, $brand, $unit];
    }
}

