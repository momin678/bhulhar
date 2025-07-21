<?php

namespace App\Http\Controllers\backend;

use App\Boq;
use App\BoqItem;
use App\BoqItemTemp;
use App\BoqTemp;
use App\Branch;
use App\CostCenterType;
use App\Http\Controllers\Controller;
use App\Item;
use App\PartyInfo;
use App\PayMode;
use App\PayTerm;
use App\ProjectDetail;
use App\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BoqController extends Controller
{
    public function index()
    {
        $boqs = Boq::orderBy('id', 'DESC')->get();
        return view('backend.boq.index', compact('boqs'));
    }
    public function create()
    {
        $delete_invoice_temp = BoqTemp::whereDate('created_at', '<', Carbon::today())->delete();
        $delete_invoice_temp = BoqItemTemp::whereDate('created_at', '<', Carbon::today())->delete();
        $sub_invoice = Carbon::now()->format('Ymd');
        $latest_boq = BoqTemp::whereDate('created_at', Carbon::today())->where('number', 'LIKE', "%{$sub_invoice}%")->orderBy('id', 'desc')->first();
        if ($latest_boq) {
            $number = $latest_boq->number + 1;
        } else {
            $number = Carbon::now()->format('Ymd') . '001';
        }
        $boqTemp = new BoqTemp();
        $boqTemp->number = $number;
        $boqTemp->save();
        $customers = PartyInfo::get();
        // dd($invoicess);
        $projects = ProjectDetail::get();
        $items = Item::get();
        $gl_code = null;
        $unites = Unit::get();
        return view('backend.boq.create', compact('boqTemp', 'customers', 'projects', 'unites', 'items'));
    }

    public function tempBoq(Request $request)
    {
        // return $request->all();
        // return $request->all();
        if ($request->item == null) {
            return Response()->json(['error' => "Please, Select Item"]);
        } elseif ($request->rate == null) {
            return Response()->json(['error' => "Fill up rate"]);
        } else {
            $temp = new BoqItemTemp();
            $temp->boq_id = $request->boq_id;
            $temp->item = $request->item;
            $temp->rate = $request->rate;
            $temp->quantity = $request->volume;
            if($request->include_vat==0)
            {
                $temp->vat = $request->total*(5/100);
                $temp->taxable_amount = $request->total;
                $temp->amount = $request->total+$temp->vat;
            }
            else
            {
                $temp->vat = $request->total*(5/105);
                $temp->taxable_amount = $request->total-$temp->vat;
                $temp->amount =$request->total;;
            }

            $temp->save();
            $tempBoq = BoqTemp::where('id', $temp->boq_id)->first();
            if ($request->ajax()) {
                return Response()->json([
                    'page' => view('backend.boq.tempTable', ['tempBoq' => $tempBoq, 'i' => 1])->render(),
                ]);
            }
        }
    }


    public function tempItemDelete($item, Request $request)
    {
        $itm = BoqItemTemp::where('id', $item)->first();
        $boq_id = $itm->boq_id;
        $itm->delete();
        $tempBoq = BoqTemp::where('id', $boq_id)->first();
        if ($request->ajax()) {
            return Response()->json([
                'page' => view('backend.boq.tempTable', ['tempBoq' => $tempBoq, 'i' => 1])->render(),
            ]);
        }
    }

    public function store(Request $request)
    {
        $temp=BoqTemp::find($request->boq_id);
        $sub_invoice = Carbon::now()->format('Ymd');
        $latest_boq = Boq::whereDate('created_at', Carbon::today())->where('number', 'LIKE', "%{$sub_invoice}%")->orderBy('id', 'desc')->first();
        if ($latest_boq) {
            $number = $latest_boq->number + 1;
        } else {
            $number = Carbon::now()->format('Ymd') . '001';
        }
        $boq=new Boq();
        $boq->number = $number;
        $boq->project = $request->branch;
        $boq->customer = $request->customer_name;
        $boq->date = $request->date;
        $boq->taxable_amount = $temp->items->sum('taxable_amount');
        $boq->vat = $temp->items->sum('vat');
        $boq->total_cost = $temp->items->sum('amount');
        $boq->save();
        foreach($temp->items as $item)
        {
            $boq_item = new BoqItem();
            $boq_item->boq_id = $boq->id;
            $boq_item->item = $item->item;
            $boq_item->rate = $item->rate;
            $boq_item->quantity = $item->quantity;
            $boq_item->vat = $item->vat;
            $boq_item->taxable_amount =  $item->taxable_amount;
            $boq_item->amount = $item->amount;
            $boq_item->save();
        }
        return redirect()->route('boq.show', [$boq])->with('success', 'BOQ View');
    }


    public function show($id)
    {
        $boq=Boq::find($id);
        return view('backend.boq.show',compact('boq'));
    }
}
