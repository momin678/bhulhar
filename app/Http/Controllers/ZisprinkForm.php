<?php

namespace App\Http\Controllers;

use App\Zisprink;
use Illuminate\Http\Request;

class ZisprinkForm extends Controller
{
    // zisprink form table data save 
    public function form()
    {
        $data = Zisprink::get();
        $d = Zisprink::latest()->first();
        if($d){
          $sl_no   = $d->sl_no+1;
        }
        else{
         $sl_no =01;
        }
        return view('backend.zisprink.zisprink',compact('data','sl_no'));


    }
    public function form_edit($id)
    {
        $data = Zisprink::find($id);
        return view('backend.zisprink.zisprinkedit',compact('data'));


    }
    public function form_delete($id)
    {
        $data = Zisprink::find($id);
        $data->delete();
        $notification = array(
            'message'       => 'form data delete successfully!',
            'alert-type'    => 'success'
        );
        return redirect()->back()->with($notification);

    }
    public function s_save(Request $request){
       // return($request);
       $d = Zisprink::latest()->first();
       if($d){
         $sl_no   = $d->sl_no+1;
       }
       else{
        $sl_no =01;
       }
       $imag = $request->file('monthly_maitenance_charge1');
       if ($imag !== null) {
        
               $imagename = time() . '.' . $imag->getClientOriginalName();
               $directory = 'all-file/';
               $imag->move($directory, $imagename);
               $imageurl = $directory . $imagename;
        
       }
       else{
           $imageurl = 0;
       }
        $data = new Zisprink();
        $data->sl_no =$sl_no;
        $data->company_name =$request->company_name;
        $data->address =$request->address;
        $data->on_broading_date =$request->on_broading_date;
        $data->delevery_due_date =$request->delevery_due_date;
        $data->d_status =$request->d_status;
        $data->delevery_date =$request->delevery_date;
        $data->implementation_date =$request->implementation_date;
        $data->sub_amount_receivable =$request->sub_amount_receivable;
        $data->monthly_maitenance_charge =$request->monthly_maitenance_charge;
        $data->module =$request->module;
        $data->whatapp =$request->whatapp;
        $data->email =$request->email;
        $data->yearly_renewal =$request->yearly_renewal;
        $data->subscription_amount =$request->subscription_amount;
        $data->monthly_maitenance_charge1 =$imageurl;
        $data->business_details =$request->business_details;
        $data->contact_person =$request->contact_person;
        $data->mobile =$request->mobile;
        $data->status =$request->status;
        $data->save();
        $notification = array(
            'message'       => 'form data save successfully!',
            'alert-type'    => 'success'
        );
        return redirect()->back()->with($notification);
    }
    public function s_update(Request $request){
        // return($request);
         $data =  Zisprink::find($request->id);
         $imag = $request->file('monthly_maitenance_charge1');
         if ($imag !== null) {
          
                 $imagename = time() . '.' . $imag->getClientOriginalName();
                 $directory = 'all-file/';
                 $imag->move($directory, $imagename);
                 $imageurl = $directory . $imagename;
          
         }
         else{
             $imageurl = $data->monthly_maitenance_charge1;
         }
         $data->sl_no =$request->sl_no;
         $data->company_name =$request->company_name;
         $data->address =$request->address;
         $data->on_broading_date =$request->on_broading_date;
         $data->delevery_due_date =$request->delevery_due_date;
         $data->d_status =$request->d_status;
         $data->delevery_date =$request->delevery_date;
         $data->implementation_date =$request->implementation_date;
         $data->sub_amount_receivable =$request->sub_amount_receivable;
         $data->monthly_maitenance_charge =$request->monthly_maitenance_charge;
         $data->module =$request->module;
         $data->whatapp =$request->whatapp;
         $data->email =$request->email;
         $data->yearly_renewal =$request->yearly_renewal;
         $data->subscription_amount =$request->subscription_amount;
         $data->monthly_maitenance_charge1 =$imageurl;
         $data->business_details =$request->business_details;
         $data->contact_person =$request->contact_person;
         $data->mobile =$request->mobile;
         $data->status =$request->status;
         $data->save();
         $notification = array(
            'message'       => 'form data update successfully!',
            'alert-type'    => 'success'
        );
        return redirect('form')->with($notification);
     }

}
