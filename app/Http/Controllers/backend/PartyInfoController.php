<?php

namespace App\Http\Controllers\backend;

use App\CostCenterType;
use App\Http\Controllers\Controller;
use App\PartyInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PartyInfoController extends Controller
{

    public function partyInfoDetails(Request $request)
    {
        $latest = PartyInfo::withTrashed()->orderBy('id','DESC')->first();

        if ($latest) {
            $pi_code=preg_replace('/^PI-/', '', $latest->pi_code );
            ++$pi_code;
        } else {
            $pi_code = 1;
        }
        if($pi_code<10)
        {
            $cc="PI-000".$pi_code;
        }
        elseif($pi_code<100)
        {
            $cc="PI-00".$pi_code;
        }
        elseif($pi_code<1000)
        {
            $cc="PI-0".$pi_code;
        }
        else
        {
            $cc="PI-".$pi_code;
        }
        $costTypes=CostCenterType::get();
        $partyInfos = PartyInfo::where('pi_type','!=', "Draft")->orderBy('id','DESC');
        if($request->search_value){
            $partyInfos = $partyInfos->where('pi_code', 'like', "%{$request->search_value}%")
            ->orWhere('pi_name', 'like', "%{$request->search_value}%")
            ->orWhere('trn_no', 'like', "%{$request->search_value}%");
        }
        $partyInfos = $partyInfos->paginate(25);
        return view('backend.partyInfo.partyCenterDetails', compact('partyInfos','costTypes','cc'));
    }

    public function partyInfoPost(Request $request)
    {
        // dd($request);
        $request->validate([
            'pi_name' => 'required',
            'pi_type'        => 'required',

            ],
            [
                'pi_name.required' => 'Cost Center is required',
                'pi_type.required' => 'Type is required',
            ]
        );

            $latest = PartyInfo::withTrashed()->orderBy('id','DESC')->first();

            if ($latest) {
                $pi_code=preg_replace('/^PI-/', '', $latest->pi_code );
                ++$pi_code;
            } else {
                $pi_code = 1;
            }
            if($pi_code<10)
            {
                $c_code="PI-000".$pi_code;
            }
            elseif($pi_code<100)
            {
                $c_code="PI-00".$pi_code;
            }
            elseif($pi_code<1000)
            {
                $c_code="PI-0".$pi_code;
            }
            else
            {
                $c_code="PI-".$pi_code;
            }

            $draftCost = new PartyInfo();
            if($request->document1){
                $ext= $request->document1->getClientOriginalExtension();
                $document_one= 'a'.time().$request->pi_name.'.'.$ext;
                $document_one_path = $request->file('document1')->storeAs( 'public/upload/service-provider', $document_one);
                $draftCost->document1= $document_one;
                $draftCost->extension1= $ext;
            }
            $draftCost->pi_code = $c_code;
            $draftCost->pi_name = $request->pi_name;
            $draftCost->pi_type = $request->pi_type;
            $draftCost->trn_no = $request->trn_no;
            $draftCost->address = $request->address;
            $draftCost->con_person = $request->con_person;
            $draftCost->con_no = $request->con_no;
            $draftCost->phone_no = $request->phone_no;
            $draftCost->email = $request->email;
            $sv = $draftCost->save();

            // dd($draftCost->id);

            if($request->file('files')){
                foreach($request->file('files') as $file){
                    $name= $file->getClientOriginalName();
                    $name = pathinfo($name, PATHINFO_FILENAME);
                    $ext= $file->getClientOriginalExtension();
                    $studentImageName= $name.time().'.'.$ext;

                    $file->storeAs( 'public/upload/service-provider', $studentImageName);

                    PartyDocument::create([
                        'name'              => $name,
                        'filename'          => $studentImageName,
                        'party_id'          => $draftCost->id,
                        'extension'         => $ext
                    ]);
                // $ext= $request->document2->getClientOriginalExtension();
                // $document_two= 'b'.time().$request->pi_name.'.'.$ext;
                // $emirates_id_upload = $request->file('document2')->storeAs( 'public/upload/service-provider', $document_two);
                // $draftCost->document2= $document_two;
                // $draftCost->extension2= $ext;
                }
            }

            $notification= array(
                'message'       => 'Added Successfully!',
                'alert-type'    => 'success'
            );
        return redirect()->back()->with($notification);
    }
    public function partyInfoEdit(Request $request, $pInfo)
    {
        $partyInfo=PartyInfo::find($pInfo);
        if(!$partyInfo)
        {
            return back()->with('error', "Not Found");

        }
        $costTypes=CostCenterType::get();


        $costTypes=CostCenterType::get();
        $partyInfos = PartyInfo::where('pi_type','!=', "Draft")->orderBy('id','DESC');
        if($request->search_value){
            $partyInfos = $partyInfos->where('pi_code', 'like', "%{$request->search_value}%")
            ->orWhere('pi_name', 'like', "%{$request->search_value}%")
            ->orWhere('trn_no', 'like', "%{$request->search_value}%");
        }
        $partyInfos = $partyInfos->paginate(25);
        return view('backend.partyInfo.partyCenterDetails', compact('partyInfos', 'partyInfo','costTypes'));
    }

    public function partyInfoUpdate(Request $request, $costCenter)
    {

        // dd(2);
        $request->validate([
            'pi_name' => 'required',
            'pi_type'        => 'required',

            ],
            [
                'pi_name.required' => 'Cost Center is required',
                'pi_type.required' => 'Type is required',
            ]
        );

    $partyInfo=PartyInfo::find($costCenter);
        if(!$partyInfo)
        {
            $notification= array(
                'message'       => 'Not Found!',
                'alert-type'    => 'error'
            );
            return back()->with($notification);
        }
        if($request->document1){
            $ext= $request->document1->getClientOriginalExtension();
            $document_one= time().$request->pi_name.'.'.$ext;
            $document_one_path = $request->file('document1')->storeAs( 'public/upload/service-provider', $document_one);
            $partyInfo->document1= $document_one;
            $partyInfo->extension1= $ext;
        }
        $partyInfo->pi_name = $request->pi_name;
        $partyInfo->pi_type = $request->pi_type;
        $partyInfo->trn_no = $request->trn_no;
        $partyInfo->address = $request->address;
        $partyInfo->con_person = $request->con_person;
        $partyInfo->con_no = $request->con_no;
        $partyInfo->phone_no = $request->phone_no;
        $partyInfo->email = $request->email;
        $partyInfo->save();

        if($request->file('files')){
            foreach($request->file('files') as $file){
                $name= $file->getClientOriginalName();
                $name = pathinfo($name, PATHINFO_FILENAME);
                $ext= $file->getClientOriginalExtension();
                $studentImageName= $name.time().'.'.$ext;

                $file->storeAs( 'public/upload/service-provider', $studentImageName);

                PartyDocument::create([
                    'name'              => $name,
                    'filename'          => $studentImageName,
                    'party_id'          => $partyInfo->id,
                    'extension'         => $ext
                ]);
            // $ext= $request->document2->getClientOriginalExtension();
            // $document_two= 'b'.time().$request->pi_name.'.'.$ext;
            // $emirates_id_upload = $request->file('document2')->storeAs( 'public/upload/service-provider', $document_two);
            // $draftCost->document2= $document_two;
            // $draftCost->extension2= $ext;
            }
        }
        $notification= array(
            'message'       => 'Updated Successfully!',
            'alert-type'    => 'success'
        );
        return redirect()->route('partyInfoDetails')->with($notification);
        // return back()->with('success', 'Updated Successfully');
    }
    public function party_center_preview(Request $request){
        $pInfo=PartyInfo::find($request->id);
        if(!$pInfo)
        {
            return back()->with('error', "Not Found");
        }
        return view('backend.partyInfo.party-center-view', compact('pInfo'));
    }
    public function partyInfoDelete($pInfo)
    {
        // dd($pInfo);
        $partyInfo=PartyInfo::find($pInfo);
        if(!$partyInfo)
        {
            return back()->with('error', "Not Found");

        }


        if($partyInfo->pi_code == 'PI-0001')
        {
            return back()->with('error','This party can not be delete');
        }
        $tablesToCheck = [
            'journals' => 'party_info_id',
            'trucks' => 'owner',
            'purchase_expenses' => 'client_id',
            'purchase_expense_temps' => 'client_id',
            'truck_records' => 'customer_id',
            'tax_invoices' => 'customer_id',
            'tax_invoice_temps' => 'customer_id',
        ];

        foreach ($tablesToCheck as $table => $column) {
            $referenceExists = DB::table($table)
                ->where($column, $pInfo)
                ->exists();

            if ($referenceExists) {
                return back()->with('error','This party can not be delete');
            }
        }
        $partyInfo->forceDelete();
        $notification= array(
            'message'       => 'Deleted Successfully!',
            'alert-type'    => 'success'
        );
        return back()->with($notification);
        // return redirect()->route('partyInfoDetails')->with('success', "Deleted Successfully");
    }
}
