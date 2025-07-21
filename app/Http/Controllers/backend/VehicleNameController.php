<?php

namespace App\Http\Controllers\backend;

use App\Brand;
use App\Http\Controllers\Controller;
use App\VehicleName;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VehicleNameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehicle_names = VehicleName::all();
        $brands = Brand::all();
        return view('backend.vehicle-name.index', compact('vehicle_names', 'brands'));
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
        $request->validate([
            'name' => 'required',
        ]);
        $vehicle_name = new VehicleName;
        $vehicle_name->name = $request->name;
        $vehicle_name->brand_id = $request->brand_id;
        $vehicle_name->save();
        
        $notification= array(
            'message'       => 'Vehicle Name Added successfully!',
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
        $vehicle_name = VehicleName::find($id);
        $vehicle_names = VehicleName::all();
        $brands = Brand::all();
        return view('backend.vehicle-name.edit', compact('vehicle_names', 'vehicle_name', 'brands'));
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
            'name' => 'required',
        ]);
        $vehicle_name = VehicleName::find($id);

        $vehicle_name->name = $request->name;
        $vehicle_name->brand_id = $request->brand_id;
        $vehicle_name->save();
        $notification= array(
            'message'       => 'Vehicle Name updated successfully!',
            'alert-type'    => 'success'
        );
        return redirect('product/vehicle-name')->with($notification);
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
    public function vehicle_name_fetch(Request $request){
        $vehicle_names = DB::table('products')
                    ->where('products.category_id', $request->category_id)
                    ->where('products.brand_id', $request->brand)
                    ->join('vehicle_names','vehicle_names.id','=','products.vehicle_name_id')
                    ->select('vehicle_names.id', 'vehicle_names.name')
                    ->distinct()
                    ->get();
        if($vehicle_names->count()>0)
        {
            if ($request->ajax()) {
                return Response()->json([
                    'page' => view('backend.vehicle-name.vehicle-name', ['vehicle_names' => $vehicle_names, 'i' => 1])->render(),
                ]);
            }
        }
    }
}
