<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\LpoBill;
use App\LpoBillDetail;
use App\PartyInfo;
use App\VatRate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Svg\Tag\Rect;
use Illuminate\Support\Facades\Storage;


class LpoBillController extends Controller
{
    private function dateFormat($date)
    {
        $old_date = explode('/', $date);

        $new_data = $old_date[0] . '-' . $old_date[1] . '-' . $old_date[2];
        $new_date = date('Y-m-d', strtotime($new_data));
        $new_date = \DateTime::createFromFormat("Y-m-d", $new_date);
        return $new_date->format('Y-m-d');
    }
    private function lpo_bill_no()
    {
        $sub_invoice = 'LPO'.Carbon::now()->format('y');
        // return $sub_invoice;
        $let_purch_exp = LpoBill::where('lpo_bill_no', 'LIKE', "%{$sub_invoice}%")->orderBy('id','DESC')->first();
        if ($let_purch_exp) {
            $purch_no = preg_replace('/^'.$sub_invoice.'/', '', $let_purch_exp->lpo_bill_no);
            $purch_code = $purch_no + 1;
            if($purch_code<10)
            {
                $purch_no=$sub_invoice.'000'.$purch_code;
            }
            elseif($purch_code<100)
            {
                $purch_no=$sub_invoice.'00'.$purch_code;
            }
            elseif($purch_code<1000)
            {
                $purch_no=$sub_invoice.'0'.$purch_code;
            }
            else
            {
                $purch_no=$sub_invoice.$purch_code;

            }
        } else {
            $purch_no = $sub_invoice . '0001';
        }
        return $purch_no;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenses = LpoBill::orderBy('id', 'desc')->paginate(40);
        $i = 0;
        $parties = PartyInfo::where('pi_type','Supplier')->get();
        return view('backend.lpo-bill.index', compact('expenses', 'i', 'parties'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pInfos = PartyInfo::where('pi_type','Supplier')->get();
        $parties = PartyInfo::where('pi_type','Supplier')->get();
        $vats = VatRate::all();
        return view('backend.lpo-bill.create', compact( 'parties', 'pInfos', 'vats'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // return $request->all();
        $request->validate(
            [
                'date'              =>  'required',
                'party_info'        => 'required',
            ],
            [
                'date.required'         => 'Date is required',
                'party_info.required'   => 'Party Info is required',
            ]
        );
        //Update date formate
        $update_date_format = $this->dateFormat($request->date);
        //purchase expense entry

        $voucher_file_name = '';
        $ext = '';
        if($request->hasFile('voucher_file')){
            $voucher_scan = $request->file('voucher_file');
            $name = $voucher_scan->getClientOriginalName();
            $name = pathinfo($name, PATHINFO_FILENAME);
            $ext = $voucher_scan->getClientOriginalExtension();
            $voucher_file_name = $name.time(). '.' . $ext;
            $voucher_scan->storeAs('public/upload/documents', $voucher_file_name);
        }
        $lpo_bill_no = $this->lpo_bill_no();
        $lpo_bill = new LpoBill();
        $lpo_bill->date = $update_date_format;
        $lpo_bill->lpo_bill_no = $lpo_bill_no;
        $lpo_bill->total_amount = $request->total_amount;
        $lpo_bill->vat = $request->total_vat;
        $lpo_bill->amount = $request->taxable_amount;
        $lpo_bill->party_id =  $request->party_info;
        $lpo_bill->narration = $request->narration;
        $lpo_bill->checked_by = $request->checked_by;
        $lpo_bill->prepared_by = $request->prepared_by;
        $lpo_bill->approved_by = $request->approved_by;
        $lpo_bill->attention = $request->attention;

        $lpo_bill->gst_subtotal = 0;
        $lpo_bill->created_by = Auth::id();
        $lpo_bill->voucher_file = $voucher_file_name;
        $lpo_bill->extension = $ext;
        $lpo_bill->save();
        //end purchase expense entry

        //records entry
        $multi_head = $request->input('group-a');
        foreach ($multi_head as $each_head) {
            //purchase record
            $plo_bill_detail = new LpoBillDetail;
            $plo_bill_detail->item_description = $each_head['multi_acc_head'];
            $plo_bill_detail->amount = $each_head['amount'];
            $plo_bill_detail->vat = $each_head['vat_amount'];
            $plo_bill_detail->qty = $each_head['quantity'];
            $plo_bill_detail->rate = $each_head['rate'];

            $plo_bill_detail->total_amount = $each_head['sub_gross_amount'];
            $plo_bill_detail->party_id = $request->party_info;
            $plo_bill_detail->lpo_bill_id = $lpo_bill->id;
            $plo_bill_detail->gst_subtotal = 0;
            $plo_bill_detail->save();
            //end purchase record
        }
        $purchase_exp = $lpo_bill;
        $items=LpoBillDetail::where('lpo_bill_id',$lpo_bill->id)->get();

        $new=0;
        return view('backend.lpo-bill.view', compact('purchase_exp','new','items'));
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
        $lpo_bill = LpoBill::find($id);
        $items=LpoBillDetail::where('lpo_bill_id',$lpo_bill->id)->get();
        $pInfos = PartyInfo::where('pi_type','Supplier')->get();
        $vats = VatRate::all();
        return view('backend.lpo-bill.edit', compact('lpo_bill','items', 'pInfos', 'vats'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // dd($request->all());
        // return $request->all();
        $request->validate(
            [
                'date'              =>  'required',
                'party_info'        => 'required',
            ],
            [
                'date.required'         => 'Date is required',
                'party_info.required'   => 'Party Info is required',
            ]
        );
        //Update date formate
        $update_date_format = $this->dateFormat($request->date);
        //purchase expense entry




        $lpo_bill_no = $this->lpo_bill_no();
        $lpo_bill =  LpoBill::find($request->lpo_bill_id);
        $lpo_bill->date = $update_date_format;
        $lpo_bill->total_amount = $request->total_amount;
        $lpo_bill->vat = $request->total_vat;
        $lpo_bill->amount = $request->taxable_amount;
        $lpo_bill->party_id =  $request->party_info;
        $lpo_bill->narration = $request->narration;
        $lpo_bill->checked_by = $request->checked_by;
        $lpo_bill->prepared_by = $request->prepared_by;
        $lpo_bill->approved_by = $request->approved_by;
        $lpo_bill->gst_subtotal = 0;
        $voucher_file_name = $lpo_bill->voucher_file;
        $ext = $lpo_bill->extension;
        if($request->hasFile('voucher_file')){
            if(Storage::exists('public/upload/documents/'. $lpo_bill->voucher_file)){
                Storage::delete('public/upload/documents/'. $lpo_bill->voucher_file);

            }
            $voucher_scan = $request->file('voucher_file');
            $name = $voucher_scan->getClientOriginalName();
            $name = pathinfo($name, PATHINFO_FILENAME);
            $ext = $voucher_scan->getClientOriginalExtension();
            $voucher_file_name = $name.time(). '.' . $ext;
            $voucher_scan->storeAs('public/upload/documents', $voucher_file_name);

        }
        $lpo_bill->voucher_file = $voucher_file_name;
        $lpo_bill->extension = $ext;
        $lpo_bill->save();
        //end purchase expense entry
        LpoBillDetail::where('lpo_bill_id', $lpo_bill->id)->delete();
        //records entry
        $multi_head = $request->input('group-a');
        foreach ($multi_head as $each_head) {
            //purchase record
            $plo_bill_detail = new LpoBillDetail;
            $plo_bill_detail->item_description = $each_head['multi_acc_head'];
            $plo_bill_detail->amount = $each_head['amount'];
            $plo_bill_detail->qty = $each_head['quantity'];
            $plo_bill_detail->rate = $each_head['rate'];
            $plo_bill_detail->vat = $each_head['vat_amount'];
            $plo_bill_detail->total_amount = $each_head['sub_gross_amount'];
            $plo_bill_detail->party_id = $request->party_info;
            $plo_bill_detail->lpo_bill_id = $lpo_bill->id;
            $plo_bill_detail->gst_subtotal = 0;
            $plo_bill_detail->save();
            //end purchase record
        }
        $notification = array(
            'message'       => 'Update Successfully!',
            'alert-type'    => 'success'
        );
        return redirect()->route('lpo-bill-create')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $purch=LpoBill::find($id);
        LpoBillDetail::where('lpo_bill_id', $purch->id)->delete();
        $purch->delete();
        $notification = array(
            'message'       => 'Deleted Successfully!',
            'alert-type'    => 'success'
        );
        return redirect()->back()->with($notification);
    }
    public function view(Request $request){
        $purchase_exp = LpoBill::find($request->id);
        $items=LpoBillDetail::where('lpo_bill_id',$purchase_exp->id)->get();
        $new=0;
        return view('backend.lpo-bill.view', compact('purchase_exp','new','items'));
    }
    public function search_lpo_bill(Request $request){
        // dd($request);
        $expenses = LpoBill::orderBy('id', 'asc');
        if($request->value){
            $expenses = $expenses->where('lpo_bill_no', 'like', '%'.$request->value.'%');
        }
        if ($request->party != '') {
            $expenses = $expenses->where('party_id', $request->party);
        }
        if ($request->date != '') {
            $date = $this->dateFormat($request->date);
            $expenses = $expenses->where('date', $date);
        }
        $expenses = $expenses->get();
        return view('backend.lpo-bill.search-lpo-bill', compact('expenses'));
    }

      public function print($id)
    {
        $lpo=LpoBill::find($id);
        $items=LpoBillDetail::where('lpo_bill_id',$lpo->id)->get();

        return view('backend.lpo-bill.print',compact('lpo','items'));
    }
}
