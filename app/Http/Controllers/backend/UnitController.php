<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Unit;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;


class UnitController extends Controller
{

    public function index(){
        $units = Unit::all();
        return view('backend.unit.index',compact('units'));
    }

    public function create(){
        return view('backend.unit.create');
    }
    public function store(Request $request){
        $validator =Validator::make($request->all(), [
            'name' => ['required','unique:units']
        ]);


        if($validator->fails()){
            $message = "Unavalid Unit, plz try again";
            $alert_type = 'error';
        }else {
            Unit::create($request->only('name'));
            $message = "Unit Added successfully!";
            $alert_type = 'success';
        }
        $notification= array(
            'message'       => $message,
            'alert-type'    => $alert_type,
        );
        return back()->with($notification);
    }
    public function edit(Unit $unit){
        return view('backend.unit.edit',compact('unit'));
    }

    public function update(Request $request, Unit $unit){

        $unit->update($request->validate([
            'name' => 'required|unique:units,name,' . $unit->id,
        ]));
        $notification= array(
            'message'       => "Unit Added successfully!",
            'alert-type'    => 'success',
        );
        return back()->with($notification);
    }

    public function destroy(Unit $unit){
        if($unit->hasProduct()->count() >0){
            $message = "Assecs denied ! ". $unit->name ." can't be delete";
            $alert_type = "error";
        }else{
            $message = "The unit has been deleted successfully";
            $alert_type = "success";
            $unit->delete();
        }
        $notification= array(
            'message'       => $message,
            'alert-type'    => $alert_type,
        );
        return back()->with($notification);
    }
}
