<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Invoice;
use App\InvoiceItem;
use App\InvoiceItemTemps;
use App\InvoiceTemp;
use App\Item;
use App\PartyInfo;
use App\ProjectDetail;
use App\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices=Invoice::orderBy('id','DESC')->get();
        return view('backend.invoice.index',compact('invoices'));
    }

    public function create()
    {

        $delete_invoice_temp = InvoiceTemp::whereDate('created_at', '<', Carbon::today())->delete();
        $delete_invoice_temp = InvoiceTemp::whereDate('created_at', '<', Carbon::today())->delete();
        $sub_invoice = Carbon::now()->format('Ymd');
        $latest_inv = InvoiceTemp::whereDate('created_at', Carbon::today())->where('number', 'LIKE', "%{$sub_invoice}%")->orderBy('id', 'desc')->first();
        if ($latest_inv) {
            $number = $latest_inv->number + 1;
        } else {
            $number = Carbon::now()->format('Ymd') . '001';
        }
        $invoice_temp = new InvoiceTemp();
        $invoice_temp->number = $number;
        $invoice_temp->save();
        $customers = PartyInfo::get();
        // dd($invoicess);
        $projects = ProjectDetail::get();
        $items = Item::get();
        $gl_code = null;
        $unites = Unit::get();
        return view('backend.invoice.create', compact('invoice_temp', 'customers', 'projects', 'unites', 'items'));
    }



    public function tempInvoice(Request $request)
    {
        // return $request->all();
        // return $request->all();
        if ($request->item == null) {
            return Response()->json(['error' => "Please, Select Item"]);
        } elseif ($request->total==null) {
            return Response()->json(['error' => "Fill up Total"]);
        } else {
            $temp = new InvoiceItemTemps();
            $temp->invoice_id = $request->invoice_id;
            $temp->description = $request->item;

            if($request->include_vat==0)
            {
                $temp->vat = $request->total*(5/100);
                $temp->taxable_amount = $request->total;
                $temp->total_amount = $request->total+$temp->vat;
            }
            else
            {
                $temp->vat = $request->total*(5/105);
                $temp->taxable_amount = $request->total-$temp->vat;
                $temp->total_amount =$request->total;;
            }

            $temp->save();
            $tempInvoice = InvoiceTemp::where('id', $temp->invoice_id)->first();
            if ($request->ajax()) {
                return Response()->json([
                    'page' => view('backend.invoice.tempTable', ['tempInvoice' => $tempInvoice, 'i' => 1])->render(),
                ]);
            }
        }
    }





    public function store(Request $request)
    {
        $temp=InvoiceTemp::find($request->invoice_id);
        $sub_invoice = Carbon::now()->format('Ymd');
        $latest_invoice = Invoice::whereDate('created_at', Carbon::today())->where('number', 'LIKE', "%{$sub_invoice}%")->orderBy('id', 'desc')->first();
        if ($latest_invoice) {
            $number = $latest_invoice->number + 1;
        } else {
            $number = Carbon::now()->format('Ymd') . '001';
        }
        $bill_count=Invoice::where('project',$request->branch)->count();
        // dd($bill_count);
        $invoice=new Invoice();
        $invoice->number = $number;
        $invoice->bill_number = $bill_count==0?1:$bill_count+1;
        $invoice->project = $request->branch;
        $invoice->customer = $request->customer_name;
        $invoice->date = $request->date;
        $invoice->taxable_amount = $temp->items->sum('taxable_amount');
        $invoice->vat = $temp->items->sum('vat');
        $invoice->total_cost = $temp->items->sum('total_amount');
        $invoice->save();
        foreach($temp->items as $item)
        {
            $invoice_item = new InvoiceItem();
            $invoice_item->invoice_id = $invoice->id;
            $invoice_item->description = $item->description;
            $invoice_item->vat = $item->vat;
            $invoice_item->taxable_amount = $item->taxable_amount;
            $invoice_item->total_amount = $item->total_amount;
            $invoice_item->save();
        }
        return redirect()->route('invoice.show', [$invoice])->with('success', 'Invoice View');
    }

    public function show($id)
    {
        $invoice=Invoice::find($id);
        return view('backend.invoice.show',compact('invoice'));
    }
}
