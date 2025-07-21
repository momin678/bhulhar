<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\PartyInfo;
use App\Quotation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class QuotationController extends Controller
{
    public function index()
    {
        $quotations=Quotation::orderBy('id','DESC')->get();
        $i=0;
        return view('backend.quotation.index',compact('quotations','i'));
    }

    public function create()
    {
        $parties=PartyInfo::get();
        return view('backend.quotation.create',compact('parties'));
    }

    public function store(Request $request)
    {
        $sub_invoice = Carbon::now()->format('Ymd');
        $latest_boq = Quotation::whereDate('created_at', Carbon::today())->where('number', 'LIKE', "%{$sub_invoice}%")->orderBy('id', 'desc')->first();
        if ($latest_boq) {
            $number = $latest_boq->number + 1;
        } else {
            $number = Carbon::now()->format('Ymd') . '001';
        }
        $quote=new Quotation();
        $quote->number=$number;
        $quote->to=$request->to;
        $quote->party_info=$request->party;
        $quote->subject=$request->subject;
        $quote->body=$request->body;
        $quote->date=$request->date;
        $quote->save();

       return view('backend.quotation.view',compact('quote'));

    }

    public function show($id)
    {
        $quote=Quotation::find($id);
        return view('backend.quotation.view',compact('quote'));
    }
}
