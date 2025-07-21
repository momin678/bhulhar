<?php

namespace App\Http\Controllers\backend;

use App\Brand;
use App\Category;
use App\Http\Controllers\Controller;
use App\ItemCode;
use App\Product;
use App\ProductUnit;
use App\SubBrand;
use App\Unit;
use App\VehicleName;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $item_codes = ItemCode::all();
        $categories = Category::all();
        $brands = Brand::all();
        $vehicle_names = VehicleName::all();
        $vehicle_models = SubBrand::all();
        $units = Unit::all();
        return view('backend.item-code.index', compact('item_codes', 'vehicle_models','units', 'categories', 'brands', 'vehicle_names'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $exit_item_code = ItemCode::where('name', $request->name)->first();
        if($exit_item_code){
            $notification= array(
                'message'       => 'Item Code already exist successfully!',
                'alert-type'    => 'warning'
            );
            return back()->with($notification);
        }
        $request->validate([
            'name'=>'required',
            'category_id'=>'required',
            'brand_id'=>'required',
            'vehicle_name_id'=>'required',
            'vehicle_model_id'=>'required',
            'unit_id'=>'required',
        ]);
        $item_code = new ItemCode;
        $item_code->name = $request->name;
        $item_code->category_id = $request->category_id;
        $item_code->brand_id = $request->brand_id;
        $item_code->vehicle_name_id = $request->vehicle_name_id;
        $item_code->vehicle_model_id = $request->vehicle_model_id;
        $item_code->unit_id = $request->unit_id;
        $item_code->sale_price = $request->sale_price;
        $item_code->save();

        $category=Category::find($request->category_id);
        $brand=Brand::find($request->brand_id);
        $sub_brand=SubBrand::find($request->vehicle_model_id);
        $vehicle_name=VehicleName::find($request->vehicle_name_id);
        
        Product::create([
            'name' => $category->name.' '. $brand->name. ' '.$vehicle_name->name.' '.$sub_brand->name. ' '.$request->name,
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'vehicle_name_id' => $request->vehicle_name_id,
            'sub_brand_id' => $request->vehicle_model_id,
            'item_code_id' => $item_code->id,
            'barcode' => product_code(),
            'sale_price' =>  $request->sale_price,
            'unit_id' =>  $request->unit_id,
        ]);

        $notification= array(
            'message'       => 'Item Code successfully!',
            'alert-type'    => 'success'
        );
        return back()->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item_codes = ItemCode::all();
        $vehicle_models = SubBrand::all();
        $units = Unit::all();
        $categories = Category::all();
        $brands = Brand::all();
        $vehicle_names = VehicleName::all();
        $item_code = ItemCode::find($id);
        return view('backend.item-code.edit', compact('item_codes', 'vehicle_models','units', 'item_code', 'categories', 'brands', 'vehicle_names'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required',
            'unit_id'=>'required',
            'sub_brand_id'=>'required',
        ]);
        $item_code = ItemCode::find($id);
        $item_code->name = $request->name;
        $item_code->category_id = $request->category_id;
        $item_code->brand_id = $request->brand_id;
        $item_code->vehicle_name_id = $request->vehicle_name_id;
        $item_code->vehicle_model_id = $request->sub_brand_id;
        $item_code->unit_id = $request->unit_id;
        $item_code->sale_price = $request->sale_price;
        $item_code->save();

        $category=Category::find($request->category_id);
        $brand=Brand::find($request->brand_id);
        $sub_brand=SubBrand::find($request->sub_brand_id);
        $vehicle_name=VehicleName::find($request->vehicle_name_id);
        
        $product = Product::where('item_code_id', $id)->first();
        // dd($product);
        $product->name = $category->name.' '. $brand->name. ' '.$vehicle_name->name.' '.$sub_brand->name. ' '.$request->name;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->vehicle_name_id = $request->vehicle_name_id;
        $product->sub_brand_id = $request->sub_brand_id;
        $product->item_code_id = $item_code->id;
        $product->sale_price =  $request->sale_price;
        $product->save();

        $notification= array(
            'message'       => 'Item Code update successfully!',
            'alert-type'    => 'success'
        );
        return redirect('product/item-code')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function item_code_add(Request $request){
        $sub_brand_id = $request->id;
        $units = Unit::all();
        return view('backend.item-code.create', compact('sub_brand_id', 'units'));
    }
    public function vehicl_model_fetch(Request $request){
        $item_codes = DB::table('products')
                    ->where('products.category_id', $request->category_id)
                    ->where('products.brand_id', $request->brand_id)
                    ->where('products.vehicle_name_id', $request->vehicle_name_id)
                    ->where('products.sub_brand_id', $request->vehicl_model)
                    ->join('item_codes','item_codes.id','=','products.item_code_id')
                    ->select('item_codes.id', 'item_codes.name')
                    ->distinct()
                    ->get();
        if($item_codes->count()>0)
        {
            if ($request->ajax()) {
                return Response()->json([
                    'page' => view('backend.item-code.item-code', ['item_codes' => $item_codes])->render(),

                ]);
            }
        }
    }
    public function product_add(Request $request){
        $exit_item_code = ItemCode::where('name', $request->name)->first();
        if($exit_item_code){
            $notification= array(
                'message'       => 'Item Code already exist successfully!',
                'alert-type'    => 'warning'
            );
            return back()->with($notification);
        }
        $request->validate([
            'name'=>'required',
            'category_id'=>'required',
            'brand_id'=>'required',
            'vehicle_name_id'=>'required',
            'vehicle_model_id'=>'required',
            'unit_id'=>'required',
        ]);
        $item_code = new ItemCode;
        $item_code->name = $request->name;
        $item_code->category_id = $request->category_id;
        $item_code->brand_id = $request->brand_id;
        $item_code->vehicle_name_id = $request->vehicle_name_id;
        $item_code->vehicle_model_id = $request->vehicle_model_id;
        $item_code->unit_id = $request->unit_id;
        $item_code->sale_price = $request->sale_price;
        $item_code->save();

        $category=Category::find($request->category_id);
        $brand=Brand::find($request->brand_id);
        $sub_brand=SubBrand::find($request->vehicle_model_id);
        $vehicle_name=VehicleName::find($request->vehicle_name_id);
        
        $item = Product::create([
            'name' => $category->name.' '. $brand->name. ' '.$vehicle_name->name.' '.$sub_brand->name. ' '.$request->name,
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'vehicle_name_id' => $request->vehicle_name_id,
            'sub_brand_id' => $request->vehicle_model_id,
            'item_code_id' => $item_code->id,
            'barcode' => product_code(),
            'sale_price' =>  $request->sale_price,
            'unit_id' =>  $request->unit_id,
        ]);
        return $item_code;
    }
}
