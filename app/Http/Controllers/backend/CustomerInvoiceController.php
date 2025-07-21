<?php

namespace App\Http\Controllers\backend;

use App\DebitCreditVoucher;
use App\Http\Controllers\Controller;
use App\Http\Controllers\TollFeeInvoice;
use App\InvoiceColumnCheck;
use App\Journal;
use App\JournalRecord;
use App\Models\AccountHead;
use App\Models\CostCenter;
use App\PartyInfo;
use App\PayMode;
use App\PayTerm;
use App\ProjectDetail;
use App\ReceiptVoucher;
use App\ReceiptVoucherDetail;
use App\TaxInvoice;
use App\TaxInvoiceItem;
use App\TaxInvoiceItemTemp;
use App\TaxInvoiceTemp;
use App\TempPRNO;
use App\Models\InvoiceNumber;
use App\TollAmountRecord;
use App\TollFeeInvoiceItemTemp;
use App\TollFeeInvoiceTemp as AppTollFeeInvoiceTemp;
use App\TollFeeInvoice as AppTollFeeInvoice;
use App\TollFees;
use App\Truck;
use App\TruckRecords;
use App\User;
use App\ReceiptSale;
use App\Receipt;
use App\VatRate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Session;
use DateTime;
use App\Cursher;
use App\Destination;
use App\Setup;
use App\DriverCommission;
class CustomerInvoiceController extends Controller
{

    public function customer_invoice(Request $request){
        if (Auth::user()->hasPermission('app.invoice.invoice_create'))
        {
        //  return $request;
        $records = Session::get('c_t_records');
        $new_datas = Session::get('truck_ids');
        $trucks= Truck::all();
        $customers= PartyInfo::where('pi_type', 'Customer')->get();
        $suppliers= PartyInfo::all();
        $projects= ProjectDetail::all();
        $cost_centers= CostCenter::all();
        $pay_modes= PayMode::whereNotIn('id', [6])->get();
        $toll_fees = TollFees::all();
        $terms = PayTerm::get();
        $crusher = Cursher::all();
        $destination = Destination::all();
        return view('backend.customer-invoice.customer-invoice', compact('customers', 'crusher', 'destination','suppliers', 'projects', 'cost_centers', 'pay_modes', 'trucks', 'toll_fees', 'records', 'new_datas', 'terms'));
       }
       elseif (Auth::user()->hasPermission('app.invoice.invoice_authorize'))
        {
            return redirect('business-operation/invoice-athurization-list');
       }
       elseif (Auth::user()->hasPermission('app.invoice.invoice_approval'))
       {
           return redirect('business-operation/invoice-approval-list');
      }
      else
      {
        return redirect('approved-invoice-list');

      }
    }
    public function customer_invoice_edit($id){

        //  return $request;
        $invoice= TaxInvoiceTemp::find($id);
        $trucks= Truck::all();
        $customers= PartyInfo::where('id',  $invoice->customer_id)->get();
        $suppliers= PartyInfo::all();
        $projects= ProjectDetail::all();
        $cost_centers= CostCenter::all();
        $pay_modes= PayMode::whereNotIn('id', [6])->get();
        $toll_fees = TollFees::all();
        $terms = PayTerm::get();
        $vats = VatRate::all();
        $crusher = Cursher::all();
        $destination = Destination::all();
        return view('backend.customer-invoice.customer-invoice-edit', compact('customers','vats', 'crusher', 'destination', 'invoice','suppliers', 'projects', 'cost_centers', 'pay_modes', 'trucks', 'toll_fees', 'terms'));

    }

    public function customer_invoice_process(Request $request){
        // return $request;
        $customer_id= $request->customer_id;
        $records=$request->records;
        $records= TruckRecords::whereIn('id',$records)->get();
        $customers= PartyInfo::where('pi_type','Customer')->get();
        $projects= ProjectDetail::all();
        $cost_centers= CostCenter::all();
        $pay_modes= PayMode::all();
        // return $projects;
        return view('backend.customer-invoice.invoice-process', compact('customers','records','customer_id','projects','cost_centers','pay_modes'));
    }

    public function save_customer_invoice(Request $request){
        //dd($request->all());

        if(empty($request->item_ids)){
            $notification= array(
                'message'       => 'Add Minimum One Service !!!',
                'alert-type'    => 'warning'
            );
            return redirect()->back()->with($notification);
        }
        $request->validate([
            'invoice_no'=>'required',
            'date'=>'required',
        ]);
        // $latest_inv_no = TempPRNO::max('tax_invoice');
        // if ($latest_inv_no && $latest_inv_no>186) {
        //     $latest_inv_no = $latest_inv_no;
        //     $new_invocie_no = $latest_inv_no +1;
        //     if(strlen($latest_inv_no)==1){
        //         $invoice_no= "AT#000".($new_invocie_no);
        //     }elseif(strlen($latest_inv_no)==2){
        //         $invoice_no= "AT#00".($new_invocie_no);
        //     }elseif(strlen($latest_inv_no)==3){
        //         $invoice_no= "AT#0".($new_invocie_no);
        //     }else{
        //         $invoice_no= "AT#".($new_invocie_no);
        //     }
        // } else {
        //     $new_invocie_no = 187;
        //     $invoice_no = 'AT#0187';
        //     $latest_inv_no = new TempPRNO;
        //     $latest_inv_no->tax_invoice = $new_invocie_no;
        //     $latest_inv_no->save();
        // }
        // dd($invoice_no);
        $date = $request->date ? $request->date : date('d/m/Y');
        $old_date = explode('/', $date);
        $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
        $new_date = date('Y-m-d', strtotime($new_data));
        $new_date = \DateTime::createFromFormat("Y-m-d", $new_date);

        $tax_invoice                = new TaxInvoiceTemp();
        $tax_invoice->invoice_no    = $request->invoice_no;
        $tax_invoice->new_invoice_no= $request->invoice_no;
        $tax_invoice->customer_id   = $request->customer_id ;
        $tax_invoice->project_id    = $request->project ;
        $tax_invoice->date          = $new_date ;
        $tax_invoice->cost_center_id= 1;
        $tax_invoice->pay_mode      = $request->pay_mode ;
        $tax_invoice->amount        = $request->total_taxable_amount;
        $tax_invoice->discount_amount    = $request->total_discount_amount;
        $tax_invoice->vat_amount    = $request->total_vat_amount;
        $tax_invoice->total_toll_fee    = $request->total_toll_fee_amount;
        $tax_invoice->total_amount   = $request->total_amount_sum;

        $tax_invoice->paid_amount   = $request->payment_amount;
        $tax_invoice->invoice_type   = $request->invoice_type;
        $tax_invoice->type   = 'customer-invoice';


        $tax_invoice->due_amount    = $request->due_amount;
        // $tax_invoice->pay_terms    = $request->pay_terms;
        // $tax_invoice->due_date    = $request->due_date;
        $tax_invoice->lpo_number    = $request->lpo_number;
        // $tax_invoice->do_no    = $request->do_number;
        $tax_invoice->month         = $request->month?$request->month.'-01':null;
        $tax_invoice->pay_term      = $request->pay_term;

        $tax_invoice->status = 'Approve';

        $tax_invoice->created_by    = Auth::id();
        $tax_invoice->authorized_by=Auth::id();

        $tax_invoice_save = $tax_invoice->save();

        $check_column = new InvoiceColumnCheck();
        $check_column->tax_invoice_temp_id = $tax_invoice->id;
        $check_column->project_check = $request->project_check;
        $check_column->customer_name_check = $request->customer_name_check;
        $check_column->customer_address_check = $request->customer_address_check;
        $check_column->customer_phone_check = $request->customer_phone_check;
        $check_column->customer_trn_check = $request->customer_trn_check;
        $check_column->date_check = $request->date_check;
        $check_column->lpo_check = $request->lpo_check;
        $check_column->do_check = $request->do_check;
        $check_column->item_date_check = $request->item_date_check;
        $check_column->truck_check = $request->truck_check;
        $check_column->material_check = $request->material_check;
        $check_column->cursher_check = $request->cursher_check;
        $check_column->dstn_e_check = $request->dstn_e_check;
        $check_column->serial_check = $request->serial_check;
        $check_column->third_party_check = $request->third_party_check;
        $check_column->wgt_check = $request->wgt_check;
        $check_column->rate_check = $request->rate_check;
        $check_column->amount_check = $request->amount_check;
        $check_column->vat_rate_check = $request->vat_rate_check;
        $check_column->discount_check = $request->discount_check;
        $check_column->vat_amount_check = $request->vat_amount_check;
        $check_column->tatl_amount_check = $request->tatl_amount_check;
        $check_column->toll_check = $request->toll_check;
        $check_column->total_toll_check = $request->total_toll_check;
        $check_column->tkt_number = $request->tkt_number;
        $check_column->month = $request->month_check;
        $check_column->pay_term = $request->pay_term_check;
        $check_column->save();

        // if($tax_invoice_save){
        //     $row = new TempPRNO;
        //     $row->tax_invoice = $new_invocie_no;
        //     $row->save();
        // }
        $i=0;
        foreach($request->item_ids as $key => $id){
            $record_data= TruckRecords::find($request->item_ids[$key] );
            $date = $record_data->date;
            $inv_item                   = new TaxInvoiceItemTemp();
            $inv_item->invoice_id       = $tax_invoice->id;
            $inv_item->invoice_no       = $tax_invoice->invoice_no;
            $inv_item->item_id          = $record_data->id;
            $inv_item->truck_id         = $record_data->truck_id;
            $inv_item->customer_id      = $request->customer_id;
            $inv_item->description      = $record_data->destination;
            $inv_item->crusher          = $record_data->crusher;
            $inv_item->destination      = $record_data->destination;
            $inv_item->qty              = $request->weight[$key];
            $inv_item->rate             = $request->rate[$key];
            $inv_item->amount           = $request->amount[$key];
            $inv_item->vat_rate         = $request->vat_rate[$key];
            $inv_item->vat_amount       = $request->vat_amount[$key];
            $inv_item->discount         = $request->discount[$key];
            $inv_item->total_amount     = $request->total_amount[$key];
            $inv_item->toll_fee         = $request->toll_fee[$key];

            $inv_item->record_date      = $record_data->date;
            $inv_item->supplier_id      = $record_data->truck_owner;
            $inv_item->date             = $new_date;
            $inv_item->save();
            // update record as is_invoiced=1
            $record_data->is_invoiced   =1;
            $record_data->save();
            $i++;
        }


        if( $request->total_toll_fee_amount>0){
            $latest_inv_no = TempPRNO::max('tax_invoice');
            if ($latest_inv_no && $latest_inv_no>388) {
                $latest_inv_no = $latest_inv_no;
                $new_invocie_no = $latest_inv_no +1;
                if(strlen($latest_inv_no)==1){
                    $invoice_no= "AT#000".($new_invocie_no);
                }elseif(strlen($latest_inv_no)==2){
                    $invoice_no= "AT#00".($new_invocie_no);
                }elseif(strlen($latest_inv_no)==3){
                    $invoice_no= "AT#0".($new_invocie_no);
                }else{
                    $invoice_no= "AT#".($new_invocie_no);
                }
            } else {
                $new_invocie_no = 392;
                $invoice_no = 'AT#0392';
                $latest_inv_no = new TempPRNO;
                $latest_inv_no->tax_invoice = $new_invocie_no;
                $latest_inv_no->save();
            }
            $toll_fee_invoice = new AppTollFeeInvoiceTemp();
            $toll_fee_invoice->tax_invoice_id= $tax_invoice->id;
            $toll_fee_invoice->invoice_no    = $invoice_no;
            $toll_fee_invoice->new_invoice_no= $new_invocie_no;
            $toll_fee_invoice->customer_id   = $request->customer_id;
            $toll_fee_invoice->project_id    = $request->project;
            $toll_fee_invoice->date          = $new_date;
            $toll_fee_invoice->cost_center_id= $request->cost_center;
            $toll_fee_invoice->pay_mode      = $request->pay_mode;
            $toll_fee_invoice->amount        = $request->total_toll_fee_amount;
            $toll_fee_invoice->created_by    = Auth::id();
            $toll_fee_invoice_save = $toll_fee_invoice->save();
            if($toll_fee_invoice_save){
                $row = new TempPRNO;
                $row->tax_invoice = $new_invocie_no;
                $row->save();
            }
            foreach($request->item_ids as $key => $id){
                if($request->toll_fee[$key] > 0){
                    $record_data= TruckRecords::find($request->item_ids[$key] );
                    $inv_item                   = new TollFeeInvoiceItemTemp;
                    $inv_item->invoice_id       = $toll_fee_invoice->id;
                    $inv_item->invoice_no       = $toll_fee_invoice->invoice_no;
                    $inv_item->item_id          = $record_data->id;
                    $inv_item->truck_id         = $record_data->truck_id;
                    $inv_item->customer_id      = $request->customer_id;
                    $inv_item->date             = $record_data->date;
                    $inv_item->qty              = 1;
                    $inv_item->destination      = $record_data->destination;
                    $inv_item->source           = $record_data->crusher;
                    $inv_item->rate             = $request->toll_fee[$key];
                    $inv_item->amount           =$request->toll_fee[$key];
                    $inv_item->save();
                }
            }

        }

        $request->session()->forget('truck_ids');
        $notification= array(
            'message'       => 'Invoice generated successfully!',
            'alert-type'    => 'success'
        );
        return redirect('business-operation/customer-invoice')->with($notification);
    }
    public function update_customer_invoice(Request $request){

        // dd($request->all());
          $date = $request->date ? $request->date : date('d/m/Y');
          $old_date = explode('/', $date);
          $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
          $new_date = date('Y-m-d', strtotime($new_data));
          $new_date = \DateTime::createFromFormat("Y-m-d", $new_date);

          $tax_invoice                =  TaxInvoiceTemp::find($request->invoice_id);
        //  return $tax_invoice->new_invoice_no;
          $tax_invoice->invoice_no    = $tax_invoice->invoice_no;
          $tax_invoice->new_invoice_no= $tax_invoice->new_invoice_no;
          $tax_invoice->customer_id   = $tax_invoice->customer_id ;
          $tax_invoice->project_id    = $request->project ;
          $tax_invoice->date          = $new_date ;
          $tax_invoice->cost_center_id= 1;
          $tax_invoice->pay_mode      = $request->pay_mode ;
          $tax_invoice->amount        = $request->total_taxable_amount;
          $tax_invoice->discount_amount    = $request->total_discount_amount;
          $tax_invoice->vat_amount    = $request->total_vat_amount;
          $tax_invoice->total_toll_fee    = $request->total_toll_fee_amount;
          $tax_invoice->total_amount   = $request->total_amount_sum;

          $tax_invoice->paid_amount   = $request->payment_amount;
          $tax_invoice->invoice_type   = $request->invoice_type;

          $tax_invoice->due_amount    = $request->due_amount;
          $tax_invoice->pay_terms    = $request->pay_terms;
          $tax_invoice->due_date    = $request->due_date;
          $tax_invoice->lpo_number    = $request->lpo_number;
        //   $tax_invoice->do_no    = $request->do_number;

          $tax_invoice->status = 'Approve';

          $tax_invoice->created_by    = Auth::id();
          $tax_invoice->authorized_by=Auth::id();
          $tax_invoice->month         = $request->month?$request->month.'-01':null;
          $tax_invoice->pay_term      = $request->pay_term;

           $tax_invoice->save();

          $check_column =  InvoiceColumnCheck::where('tax_invoice_temp_id', $tax_invoice->id)->first();
          $check_column->tax_invoice_temp_id = $tax_invoice->id;
          $check_column->project_check = $request->project_check;
          $check_column->customer_name_check = $request->customer_name_check;
          $check_column->customer_address_check = $request->customer_address_check;
          $check_column->customer_phone_check = $request->customer_phone_check;
          $check_column->customer_trn_check = $request->customer_trn_check;
          $check_column->date_check = $request->date_check;
          $check_column->lpo_check = $request->lpo_check;
          $check_column->do_check = $request->do_check;
          $check_column->item_date_check = $request->item_date_check;
          $check_column->truck_check = $request->truck_check;
          $check_column->material_check = $request->material_check;
          $check_column->cursher_check = $request->cursher_check;
          $check_column->dstn_e_check = $request->dstn_e_check;
          $check_column->serial_check = $request->serial_check;
          $check_column->third_party_check = $request->third_party_check;
          $check_column->wgt_check = $request->wgt_check;
          $check_column->rate_check = $request->rate_check;
          $check_column->amount_check = $request->amount_check;
          $check_column->vat_rate_check = $request->vat_rate_check;
          $check_column->discount_check = $request->discount_check;
          $check_column->vat_amount_check = $request->vat_amount_check;
          $check_column->tatl_amount_check = $request->tatl_amount_check;
          $check_column->toll_check = $request->toll_check;
          $check_column->total_toll_check = $request->total_toll_check;
          $check_column->tkt_number = $request->tkt_number;
          $check_column->month = $request->month_check;
          $check_column->pay_term = $request->pay_term_check;
          $check_column->save();
        //  dd($tax_invoice->items);
          foreach($tax_invoice->items as $service_item){
            $exit_service = TruckRecords::find($service_item->item_id);
            $exit_service->is_invoiced = 0;
            $exit_service->save();
            $service_item->delete();
          }
          $i=0;
        //   dd($request->item_ids);
              foreach($request->item_ids as $key => $id){
                $date = $request->date;
                $old_date = explode('/', $date);
                $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
                $new_date = date('Y-m-d', strtotime($new_data));
                $new_date = DateTime::createFromFormat("Y-m-d", $new_date);
                  $record_data= TruckRecords::find($id);
                    // if()
                  $inv_item                   = new TaxInvoiceItemTemp();
                  $inv_item->invoice_id       = $tax_invoice->id;
                  $inv_item->invoice_no       = $tax_invoice->invoice_no;
                  $inv_item->item_id          = $record_data->id;
                  $inv_item->truck_id         = $record_data->truck_id;
                  $inv_item->customer_id      = $request->customer_id;
                  $inv_item->description      = $record_data->destination;
                  $inv_item->crusher          = $record_data->crusher;
                  $inv_item->destination      = $record_data->destination;
                  $inv_item->qty              = $request->weight[$key];
                  $inv_item->rate             =$request->rate[$key];
                  $inv_item->amount           = $request->amount[$key];
                  $inv_item->vat_rate         = $request->vat_rate[$key];
                  $inv_item->vat_amount       = $request->vat_amount[$key];
                  $inv_item->discount       = $request->discount[$key];
                  $inv_item->total_amount       = $request->total_amount[$key];
                  $inv_item->toll_fee       = $request->toll_fee[$key];

                  $inv_item->record_date      = $record_data->date;
                  $inv_item->supplier_id      = $record_data->truck_owner;
                  $inv_item->date             = $new_date;
                  $inv_item->save();
                  // update record as is_invoiced=1
                  $record_data->is_invoiced   =1;
                  $record_data->save();
                  $i++;
              }

            //   dd($tax_invoice->id);
          if( $request->total_toll_fee_amount>0){

              $toll_fee_invoice =  AppTollFeeInvoiceTemp::where('tax_invoice_id',$tax_invoice->id)->first();
            //    return $toll_fee_invoice->new_invocie_no;

              if($toll_fee_invoice){
                $toll_fee_invoice->tax_invoice_id= $tax_invoice->id;
                $toll_fee_invoice->invoice_no    = $toll_fee_invoice->invoice_no;
                $toll_fee_invoice->new_invoice_no= $toll_fee_invoice->new_invoice_no;
                $toll_fee_invoice->customer_id   = $request->customer_id;
                $toll_fee_invoice->project_id    = $request->project;
                $toll_fee_invoice->date          = $new_date;
                $toll_fee_invoice->cost_center_id= $request->cost_center;
                $toll_fee_invoice->pay_mode      = $request->pay_mode;
                $toll_fee_invoice->amount        = $request->total_toll_fee_amount;
                $toll_fee_invoice->created_by    = Auth::id();
                $toll_fee_invoice->save();
                $temp_tollfee_lists = TollFeeInvoiceItemTemp::where('invoice_id', $toll_fee_invoice->id)->get();
                foreach($temp_tollfee_lists as $temp_tollfee){
                  $temp_tollfee->delete();
                }
                  foreach($request->item_ids as $key => $id){

                    if($request->toll_fee[$key] > 0){
                        $record_data= TruckRecords::find($request->item_ids[$key] );

                        $inv_item                   = new TollFeeInvoiceItemTemp;
                        $inv_item->invoice_id       = $toll_fee_invoice->id;
                        $inv_item->invoice_no       = $toll_fee_invoice->invoice_no;
                        $inv_item->item_id          = $record_data->id;
                        $inv_item->truck_id         = $record_data->truck_id;
                        $inv_item->customer_id      = $request->customer_id;
                        $inv_item->date             = $record_data->date;
                        $inv_item->qty              = 1;
                        $inv_item->destination      = $record_data->destination;
                        $inv_item->source           = $record_data->crusher;
                        $inv_item->rate             = $request->toll_fee[$key];
                        $inv_item->amount           =$request->toll_fee[$key];
                        $inv_item->save();
                    }
                   }

                  }

              }

          $notification= array(
              'message'       => 'Invoice Update successfully!',
              'alert-type'    => 'success'
          );
          return redirect()->route('invoice-approval-list')->with($notification);
      }
    public function invoice_list(){
        $invoices= TaxInvoice::where('type' , 'customer-invoice')->all();
        return view('backend.customer-invoice.invoice-list', compact('invoices'));
    }

    public function invoice_print($id){
        $invoice= TaxInvoice::find($id);
        $value = "values";
        $terms = PayTerm::get();
        $invoice_items= DB::table('tax_invoice_items')
        ->select('crusher', 'destination','rate','vat_rate', 'toll_fee', DB::raw('sum(qty) as total_qty'), DB::raw('sum(vat_amount) as total_vat_amount'), DB::raw('count(qty) as total_trip'), DB::raw('sum(toll_fee) as total_toll_fee'))
        ->groupBy('crusher','destination','rate','vat_rate', 'toll_fee')
        ->where('invoice_id', $id)
        ->get();
        // dd($invoice_items);
        return view('backend.customer-invoice.invoice', compact('invoice', 'value', 'terms', 'invoice_items'));
    }

    public function invoice_sum_print($id){
        $invoice= TaxInvoice::find($id);
        $invoice_items= DB::table('tax_invoice_items')
        ->select('crusher', 'destination','rate','vat_rate', 'toll_fee', DB::raw('sum(qty) as total_qty'), DB::raw('sum(vat_amount) as total_vat_amount'), DB::raw('count(qty) as total_trip'), DB::raw('sum(toll_fee) as total_toll_fee'))
        ->groupBy('crusher','destination','rate','vat_rate', 'toll_fee')
        ->where('invoice_id', $id)
        ->get();
        // return $invoice_items;
        $terms = PayTerm::get();
        return view('backend.customer-invoice.invoice-sum-print', compact('invoice_items','invoice', 'terms'));
    }

    public function invoice_sumview($id){
        $invoice= TaxInvoice::find($id);
        $invoice_items= DB::table('tax_invoice_items')
        ->select('crusher', 'destination','rate','vat_rate', 'toll_fee',DB::raw('sum(qty) as total_qty'), DB::raw('sum(vat_amount) as total_vat_amount'), DB::raw('count(qty) as total_trip'), DB::raw('sum(toll_fee) as total_toll_fee'))
        ->groupBy('crusher','destination','rate', 'toll_fee', 'vat_rate')
        ->where('invoice_id', $id)
        ->get();
        // dd($invoice_items);
        // return $invoice_items;
        $terms = PayTerm::get();
        return view('backend.customer-invoice.invoice-sumview', compact('invoice','invoice_items', 'terms'));
    }

    public function invoice_view($id){
        Gate::authorize('app.invoice.invoice_view');
        $invoice= TaxInvoice::find($id);
        $terms = PayTerm::get();
        return view('backend.customer-invoice.invoice-view', compact('invoice', 'terms'));
    }

    public function temp_invoice_view($id){
        Gate::authorize('app.invoice.invoice_view');
        $invoice= TaxInvoiceTemp::find($id);
        // dd($invoice);
        $terms = PayTerm::get();
        return view('backend.customer-invoice.pre-invoice-view', compact('invoice', 'terms'));
    }

    public function decline_invoice($id)
    {
        // dd($id);
        $pre_inv=TaxInvoiceTemp::find($id);
        $status = '';
        if($pre_inv->status=="Authorize")
       {
        Gate::authorize('app.invoice.invoice_authorize');
        $pre_inv->status="Decline";
        $pre_inv->declined_by=Auth::id();
        $pre_inv->save();
        $status = 'Authorize';
       }

       elseif($pre_inv->status=="Approve")
       {
        Gate::authorize('app.invoice.invoice_approval');
        // dd(2);
        $pre_inv->status="Decline";
        $pre_inv->declined_by=Auth::id();
        $pre_inv->save();
        $status = 'Approve';
       }

       $notification= array(
        'message'       => 'Invoice Declined successfully!',
        'alert-type'    => 'success',
        'status'        => $status
    );
    return back()->with($notification);
    }

    public function authorize_invoice( $type = null ,$id)
    {
        $pre_inv=TaxInvoiceTemp::find($id);

        if($pre_inv->status=="Authorize")
       {
        Gate::authorize('app.invoice.invoice_authorize');
        $pre_inv->status="Approve";
        $pre_inv->authorized_by=Auth::id();
        $pre_inv->save();
        $notification= array(
            'message'       => 'Invoice Authorized successfully!',
            'alert-type'    => 'success'
        );
        return redirect('business-operation/invoice-athurization-list')->with($notification);
       }
       else
       {
        Gate::authorize('app.invoice.invoice_approval');
        // $latest_inv_no = TaxInvoice::latest()->first();
        // if ($latest_inv_no) {
        //     $new_invoice_no = $latest_inv_no->new_invoice_no + 1;
        //     if(strlen($latest_inv_no->new_invoice_no)==1){
        //         $invoice_no= "BT#000".($latest_inv_no->new_invoice_no+1);
        //     }elseif(strlen($latest_inv_no->new_invoice_no)==2){
        //         $invoice_no= "BT#00".($latest_inv_no->new_invoice_no+1);
        //     }elseif(strlen($latest_inv_no->new_invoice_no)==3){
        //         $invoice_no= "BT#0".($latest_inv_no->new_invoice_no+1);
        //     }else{
        //         $invoice_no= "BT#".($latest_inv_no->invoice_no+1);
        //     }
        // } else {
        //     $new_invoice_no = 389;
        //     $invoice_no = 'BT#0389';
        // }
        // dd($pre_inv->items);
        $tax_invoice                = new TaxInvoice;
        $tax_invoice->invoice_no    = $pre_inv->invoice_no;
        $tax_invoice->new_invoice_no= $pre_inv->new_invoice_no;
        $tax_invoice->customer_id   = $pre_inv->customer_id ;
        $tax_invoice->project_id    = $pre_inv->project_id;
        $tax_invoice->date          = $pre_inv->date;
        $tax_invoice->pay_mode      = $pre_inv->pay_mode;
        $tax_invoice->cost_center_id= $pre_inv->cost_center_id;
        $tax_invoice->amount        = $pre_inv->amount;
        $tax_invoice->discount_amount    = $pre_inv->discount_amount;
        $tax_invoice->vat_amount    = $pre_inv->vat_amount;
        $tax_invoice->total_toll_fee    = $pre_inv->total_toll_fee;
        $tax_invoice->total_amount   = $pre_inv->total_amount;
        $tax_invoice->paid_amount   = $pre_inv->paid_amount;
        $tax_invoice->due_amount    = $pre_inv->due_amount;
        $tax_invoice->created_by    = $pre_inv->created_by;
        $tax_invoice->authorized_by = $pre_inv->authorized_by;
        $tax_invoice->toll_fee_amount = $pre_inv->toll_fee_amount;
        $tax_invoice->pay_terms = $pre_inv->pay_terms;
        $tax_invoice->due_date = $pre_inv->due_date;
        $tax_invoice->invoice_type   = $pre_inv->invoice_type;
        $tax_invoice->type   = $pre_inv->type;
        $tax_invoice->sale_no   = $pre_inv->sale_no;


        $tax_invoice->lpo_number = $pre_inv->lpo_number;
        $tax_invoice->do_no = $pre_inv->do_no;
        $tax_invoice->pay_term = $pre_inv->pay_term;
        $tax_invoice->month = $pre_inv->month;

        $tax_invoice->approved_by   = Auth::id();
        $tax_invoice->save();

        $check_column =  InvoiceColumnCheck::where('tax_invoice_temp_id',$pre_inv->id)->first();
        if($check_column){
            $check_column->tax_invoice_id = $tax_invoice->id;
            $check_column->save();
        }

        $v_rate=0;
        foreach($pre_inv->items as $record){
            $inv_item                   = new TaxInvoiceItem();
            $inv_item->head_id          = $record->head_id;
            $inv_item->invoice_id       = $tax_invoice->id;
            $inv_item->invoice_no       = $tax_invoice->invoice_no;
            $inv_item->item_id          = $record->item_id;
            $inv_item->truck_id         = $record->truck_id;
            $inv_item->customer_id      = $record->customer_id;
            $inv_item->description      = $record->description;
            $inv_item->crusher          = $record->crusher;
            $inv_item->destination      = $record->destination;
            $inv_item->qty              = $record->qty;
            $inv_item->rate             = $record->rate;
            $inv_item->record_date      = $record->record_date;
            $inv_item->supplier_id      = $record->supplier_id;
            $inv_item->amount           = $record->amount;
            $inv_item->vat_rate         = $record->vat_rate;
            $inv_item->vat_amount       = $record->vat_amount;
            $inv_item->discount         = $record->discount;
            $inv_item->total_amount     = $record->total_amount;
            $inv_item->toll_fee         = $record->toll_fee;
            $inv_item->date             = $record->date;
            $inv_item->save();
            $v_rate=$inv_item->vat_rate;
            $toll_amount_record = TollAmountRecord::where('truck_record_id', $inv_item->item_id)->first();
            if($toll_amount_record){
                $toll_amount_record->is_invoice = 1;
                $toll_amount_record->save();
            }
            $truck_record = TruckRecords::find($inv_item->item_id);
            // driver commission
            // if($truck_record->commision>0 && $truck_record->driver_name){
            //     $commision = new DriverCommission;
            //     $commision->driver_id = $truck_record->driver_name;
            //     $commision->truck_id = $truck_record->truck_id;
            //     $commision->truck_record_id = $truck_record->id;
            //     $commision->date = $truck_record->date;
            //     $commision->amount = $truck_record->commision;
            //     $commision->save();
            // }
        }
        // Journal Entry
        $sub_invoice = Carbon::now()->format('Ymd');

        $latest_journal_no = Journal::withTrashed()->whereDate('created_at', Carbon::today())->where('journal_no', 'LIKE', "%{$sub_invoice}%")->orderBy('id','DESC')->first();

        if ($latest_journal_no) {
            $journal_no = substr($latest_journal_no->journal_no,0,-1);
            $journal_code = $journal_no + 1;
            $journal_no = $journal_code . "J";
        } else {
            $journal_no = Carbon::now()->format('Ymd') . '001' . "J";
        }
        $journal= new Journal();
        $journal->transection_type  = "Customer Invoice";
        $journal->transaction_type  = "Invoice";
        $journal->without_gst       = $tax_invoice->amount;
        $journal->gst_subtotal      = $tax_invoice->vat_amount;
        $journal->project_id        = $tax_invoice->project_id;
        $journal->journal_no        = $journal_no;
        $journal->date              = $tax_invoice->date;
        $journal->pay_mode          = $tax_invoice->pay_mode;
        $journal->invoice_no        = $tax_invoice->invoice_no;
        $journal->cost_center_id    = $tax_invoice->cost_center_id;
        $journal->party_info_id     = $tax_invoice->customer_id;
        $journal->account_head_id   = 123;
        $journal->amount            = $tax_invoice->amount+$tax_invoice->vat_amount+$tax_invoice->total_toll_fee;
        $journal->tax_rate          = $v_rate;
        $journal->vat_amount        = $tax_invoice->vat_amount;
        $journal->total_amount      = $tax_invoice->amount+$tax_invoice->vat_amount+$tax_invoice->total_toll_fee;
        $journal->narration         = 'Transport service provided by '. $tax_invoice->pay_mode ;
        $journal->created_by        = Auth::id();
        $journal->voucher_type      = 'default';
        $journal->authorized        = 1;
        $journal->approved          = 1;
        $journal->authorized_by     = Auth::id();
        $journal->approved_by       = Auth::id();
        $journal->save();

        // Main Entry
        $acc_head= AccountHead::find(7); // servcie revenue account
        $jl_record= new JournalRecord();
        $jl_record->journal_id          = $journal->id;
        $jl_record->project_details_id  = $journal->project_id ;
        $jl_record->cost_center_id      = $journal->cost_center_id;
        $jl_record->party_info_id       = $journal->party_info_id;
        $jl_record->journal_no          = $journal->journal_no;
        $jl_record->account_head_id     = $acc_head->id;
        $jl_record->master_account_id   = $acc_head->master_account_id;
        $jl_record->account_head        = $acc_head->fld_ac_head;
        $jl_record->amount              = $tax_invoice->amount;
        $jl_record->total_amount        = $tax_invoice->amount;
        $jl_record->is_main_head        = 1;
        $jl_record->transaction_type    = 'CR';
        $jl_record->journal_date        = $journal->date;
        $jl_record->account_type_id     = $acc_head->account_type_id;
        $jl_record->gst_amount          = $journal->total_amount;
        $jl_record->gst_subtotal        = $journal->vat_amount;
        $jl_record->vat_rate_id         = 1;
        $jl_record->invoice_no          = 'n/a';
        $jl_record->save();

        // vat entry to journal
        if($journal->vat_amount>0){
            $vat_ac_head= AccountHead::find(18); // vat receivable
            $jl_record= new JournalRecord();
            $jl_record->journal_id          = $journal->id;
            $jl_record->project_details_id  = $journal->project_id;
            $jl_record->cost_center_id      =  $journal->cost_center_id;
            $jl_record->party_info_id       =  $journal->party_info_id;
            $jl_record->journal_no          = $journal->journal_no;
            $jl_record->account_head_id     = $vat_ac_head->id;
            $jl_record->master_account_id   = $vat_ac_head->master_account_id;
            $jl_record->account_head        = $vat_ac_head->fld_ac_head;
            $jl_record->amount              = $tax_invoice->vat_amount;
            $jl_record->total_amount        = $tax_invoice->vat_amount;
            $jl_record->transaction_type    = 'CR';
            $jl_record->journal_date        = $journal->date;
            $jl_record->account_type_id     = $vat_ac_head->account_type_id;
            $jl_record->gst_amount          = $journal->total_amount;
            $jl_record->gst_subtotal        = $journal->vat_amount;
            $jl_record->vat_rate_id         = 1;
            $jl_record->invoice_no          = 'n/a';
            $jl_record->save();
        }
        if( $tax_invoice->total_toll_fee>0){
            $toll_ac_head= AccountHead::find(30); // toll fee
            $jl_record= new JournalRecord();
            $jl_record->journal_id          = $journal->id;
            $jl_record->project_details_id  = $journal->project_id;
            $jl_record->cost_center_id      =  $journal->cost_center_id;
            $jl_record->party_info_id       =  $journal->party_info_id;
            $jl_record->journal_no          = $journal->journal_no;
            $jl_record->account_head_id     = $toll_ac_head->id;
            $jl_record->master_account_id   = $toll_ac_head->master_account_id;
            $jl_record->account_head        = $toll_ac_head->fld_ac_head;
            $jl_record->amount              = $tax_invoice->total_toll_fee;
            $jl_record->total_amount        = $tax_invoice->total_toll_fee;
            $jl_record->transaction_type    = 'CR';
            $jl_record->journal_date        = $journal->date;
            $jl_record->account_type_id     = $toll_ac_head->account_type_id;
            $jl_record->gst_amount          = $journal->total_amount;
            $jl_record->gst_subtotal        = $tax_invoice->total_toll_fee;
            $jl_record->vat_rate_id         = 1;
            $jl_record->invoice_no          = 'n/a';
            $jl_record->save();
        }
        if($tax_invoice->discount_amount>0){
            $discount_head = AccountHead::find(29); // discount account head
            $jl_record = new JournalRecord();
            $jl_record->journal_id          = $journal->id;
            $jl_record->project_details_id  = $journal->project_id;
            $jl_record->cost_center_id      = $journal->cost_center_id;
            $jl_record->party_info_id       = $journal->party_info_id;
            $jl_record->journal_no          = $journal->journal_no;
            $jl_record->account_head_id     = $discount_head->id;
            $jl_record->master_account_id   = $discount_head->master_account_id;
            $jl_record->account_head        = $discount_head->fld_ac_head;
            $jl_record->amount              =  $tax_invoice->discount_amount;
            $jl_record->invoice_no          = 'N/A';
            $jl_record->total_amount        =  $tax_invoice->discount_amount;
            $jl_record->vat_rate_id         = 0;
            $jl_record->transaction_type    = 'DR';
            $jl_record->journal_date        = $journal->date;
            $jl_record->account_type_id     = $discount_head->account_type_id;
            $jl_record->is_main_head        = 0;
            $jl_record->save();
        }
        if($tax_invoice->due_amount>0){
            $acc_head= AccountHead::find(3); // Accounts Receivable
            $jl_record= new JournalRecord();
            $jl_record->journal_id          = $journal->id;
            $jl_record->project_details_id  = $journal->project_id;
            $jl_record->cost_center_id      = $journal->cost_center_id;
            $jl_record->party_info_id       = $journal->party_info_id;
            $jl_record->journal_no          = $journal->journal_no;
            $jl_record->account_head_id     = $acc_head->id;
            $jl_record->master_account_id   = $acc_head->master_account_id;
            $jl_record->account_head        = $acc_head->fld_ac_head;
            $jl_record->amount              = $tax_invoice->due_amount;
            $jl_record->total_amount        = $tax_invoice->due_amount;
            $jl_record->transaction_type    = 'DR';
            $jl_record->journal_date        =  $journal->date;
            $jl_record->account_type_id     = $acc_head->account_type_id;
            $jl_record->gst_amount          = 0;
            $jl_record->gst_subtotal        = 0;
            $jl_record->vat_rate_id         = 1;
            $jl_record->invoice_no          = 'n/a';
            $jl_record->save();
        }

        //Debit Voucher Or Credit Voucher
        $voucher_type="DR";
        if(  $journal->pay_mode != 'Credit'){
            $voucher_type = 'CR';
        }elseif( $journal->pay_mode   == 'Credit'){
            $voucher_type            = 'JOURNAL';
        }

        $journal->voucher_type          = $voucher_type;
        $journal->save();

        // Opposit entry of journal
        if( $journal->pay_mode !='Credit' && $tax_invoice->paid_amount>0){
            // create receipt voucher
            $sub_invoice = 'RV' . Carbon::now()->format('y');
            $let_purch_exp = InvoiceNumber::where('receipt_invoice_number', 'LIKE', "%{$sub_invoice}%")->first();

            if ($let_purch_exp) {
                $receipt_no = substr($let_purch_exp->receipt_invoice_number,2);
                $receipt_no = $receipt_no + 1;
                $receipt_no = "RV".$receipt_no;
            } else {
                $receipt_no = "RV".Carbon::now()->format('Y') . '0001';
            }
            $payment = new Receipt();
            $payment->date =$tax_invoice->date;
            $payment->pay_mode =  $tax_invoice->pay_mode;
            $payment->receipt_no = $receipt_no;
            $payment->head_id = 0;
            $payment->total_amount = $tax_invoice->paid_amount;
            $payment->vat = 0;
            $payment->party_id =  $tax_invoice->customer_id;
            $payment->narration = 'Receive Voucher By '. $tax_invoice->pay_mode;
            $payment->status = 'Realised';
            $payment->paid_amount = $tax_invoice->paid_amount;
            $payment->due_amount = 0;
            $payment->name = null;
            $payment->voucher_file = null;
            $payment->extension= null;
            $payment->save();

            $purc_exp_itm = new ReceiptSale();
            $purc_exp_itm->sale_id = $tax_invoice->id;
            $purc_exp_itm->payment_id = $payment->id;
            $purc_exp_itm->Total_amount = $tax_invoice->paid_amount;
            $purc_exp_itm->vat = 0;
            $purc_exp_itm->amount = $tax_invoice->paid_amount;
            $purc_exp_itm->party_id = $tax_invoice->customer_id;
            $purc_exp_itm->save();
            $let_purch_exp = InvoiceNumber::first();
            $let_purch_exp->receipt_invoice_number = $payment->receipt_no;
            $let_purch_exp->save();

            if($payment->pay_mode=='Cash'){
                $ac_head_dr= AccountHead::find(1); // Cash Operating Account
            }else{
                $ac_head_dr= AccountHead::find(2); // Bank Account
            }

            $jl_record= new JournalRecord();
            $jl_record->journal_id          = $journal->id;
            $jl_record->project_details_id  = $journal->project_id;
            $jl_record->cost_center_id      = $journal->cost_center_id;
            $jl_record->party_info_id       = $journal->party_info_id;
            $jl_record->journal_no          = $journal->journal_no;
            $jl_record->account_head_id     = $ac_head_dr->id;
            $jl_record->master_account_id   = $ac_head_dr->master_account_id;
            $jl_record->account_head        = $ac_head_dr->fld_ac_head;
            $jl_record->amount              = $tax_invoice->paid_amount;
            $jl_record->total_amount        = $tax_invoice->paid_amount;
            $jl_record->transaction_type    = 'DR';
            $jl_record->journal_date        = $journal->date;
            $jl_record->account_type_id     = $ac_head_dr->account_type_id;
            $jl_record->gst_amount          = $journal->total_amount;
            $jl_record->gst_subtotal        = $journal->vat_amount;
            $jl_record->vat_rate_id         = 1;
            $jl_record->invoice_no          = 'n/a';
            $jl_record->save();
        }

        $pre_inv->items->each->delete();
        $pre_inv->delete();
        $notification= array(
            'message'       => 'Invoice Approved successfully!',
            'alert-type'    => 'success'
        );

        if($type == 'sale-invoice'){
            return redirect('accounting/sale/revenues')->with($notification);

        }else{
            return redirect('business-operation/approved-invoice-list')->with($notification);

        }
       }
    }

    public function invoice_athurization_list(Request $request){
        Gate::authorize('app.invoice.invoice_authorize');
        $users = User::all();
        $invoices= TaxInvoiceTemp::where('status',"Authorize")->where('type',"customer-invoice")->orderBy('created_at', 'DESC');
        if($request->user_id){
            $invoices = $invoices->where('created_by', $request->user_id)
                        ->where('authorized_by', $request->user_id)
                        ->where('approved_by', $request->user_id)
                        ->where('declined_by', $request->user_id);
        }
        $invoices = $invoices->get();
        return view('backend.customer-invoice.tax-invoice', compact('invoices', 'users'));

    }
    public function invoice_approval_list(Request $request){
        Gate::authorize('app.invoice.invoice_approval');
        $users = User::all();
        $invoices= TaxInvoiceTemp::orderBy('id', 'desc')->where('type',"customer-invoice")->where('status',"Approve");
        if($request->user_id){
            $invoices = $invoices->where('created_by', $request->user_id)
                        ->where('authorized_by', $request->user_id)
                        ->where('approved_by', $request->user_id)
                        ->where('declined_by', $request->user_id);
        }
        $invoices = $invoices->get();
        return view('backend.customer-invoice.tax-invoice', compact('invoices', 'users'));
    }

    public function declined_invoice_list(Request $request){
        Gate::authorize('app.invoice.invoice_view');
        $users = User::all();
        $invoices= TaxInvoiceTemp::orderBy('id', 'desc')->where('type',"customer-invoice")->where('status',"Decline");
        if($request->user_id){
            $invoices = $invoices->where('created_by', $request->user_id)
                        ->where('authorized_by', $request->user_id)
                        ->where('approved_by', $request->user_id)
                        ->where('declined_by', $request->user_id);
        }
        $invoices = $invoices->get();
        return view('backend.customer-invoice.tax-invoice', compact('invoices', 'users'));
    }

    public function approved_invoice_list(Request $request){

        Gate::authorize('app.invoice.invoice_view');
        $users = User::all();
        $invoices = TaxInvoice::query();

        $invoices->when($request->date, function ($query, $date) {
            $formattedDate = Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
            $query->where('date', $formattedDate);
        });

        $invoices->when($request->from && $request->to, function ($query) use ($request) {
            $from = Carbon::createFromFormat('d/m/Y', $request->from)->format('Y-m-d');
            $to = Carbon::createFromFormat('d/m/Y', $request->to)->format('Y-m-d');
            $query->whereBetween('date', [$from, $to]);
        });

        $invoices->when($request->user_id, function ($query, $userId) {
            $query->where('created_by', $userId)
                  ->where('authorized_by', $userId)
                  ->where('approved_by', $userId);
        });

        $invoices = $invoices->orderBy('id', 'desc')->where('type',"customer-invoice")->get();
        return view('backend.customer-invoice.invoice-list', compact('invoices', 'users'));
    }
    // work by mominul

    public function draft_invoice_list(Request $request){
        $invoices= TaxInvoiceTemp::where('status',"Draft")->where('type',"customer-invoice")->orderby('id', 'desc')->get();
        return view('backend.customer-invoice.draft-invoice-list', compact('invoices'));
    }
    public function draft_invoice_preview($id){
        Gate::authorize('app.invoice.invoice_view');
        $invoice= TaxInvoiceTemp::find($id);
        $terms = PayTerm::get();
        return view('backend.customer-invoice.draft-invoice-preview', compact('invoice', 'terms'));
    }
    public function draft_invoice_submit($id){
        Gate::authorize('app.invoice.invoice_view');
        $invoice = TaxInvoiceTemp::find($id);
        $invoice->status = 'Authorize';
        $invoice->save();
        $notification= array(
            'message'       => 'Invoice Submit successfully!',
            'alert-type'    => 'success'
        );
        return redirect('business-operation/draft-invoice-list')->with($notification);
    }
    public function search_customer_invoice(Request $request){

        $customers= PartyInfo::where('pi_type','Customer')->get();
        $invoices  = [];
        $temp_invoices  = [];
        // if($request->customer_id){
        //     $invoices = TaxInvoice::where('customer_id', $request->customer_id)->get();
        //     $temp_invoices= TaxInvoiceTemp::where('customer_id', $request->customer_id)->get();
        // }
        // if($request->date){
        //     $invoices = TaxInvoice::where('date', $request->date)->get();
        //     $temp_invoices= TaxInvoiceTemp::where('date', $request->date)->get();
        // }
        // if($request->from && $request->to){
        //     $invoices = TaxInvoice::whereBetween('date', [$request->from, $request->to])->get();
        //     $temp_invoices= TaxInvoiceTemp::where('customer_id', [$request->from, $request->to])->get();
        // }
        $invoices = AppTollFeeInvoice::all();
        $invoices_temp = AppTollFeeInvoiceTemp::all();
        return view('backend.customer-invoice.search-customer-invoice', compact('customers', 'invoices', 'invoices_temp'));
    }

    public function delete_invoice($id){
        $invoice= TaxInvoiceTemp::find($id);
        foreach($invoice->items as $inv_item){
            $record= TruckRecords::find($inv_item->item_id);
            $record->is_invoiced=0;
            $record->save();
        }

        $invoice->items->each->delete();
        $invoice->delete();
        $notification= array(
            'message'       => 'Invoice Deleted!',
            'alert-type'    => 'success'
        );

        return back()->with($notification);
    }
    // mominul
    public function draft_invoice_print($id){
        $invoice= TaxInvoiceTemp::find($id);
        // return $invoice->column_show;
        $terms = PayTerm::get();
        $invoice_items= DB::table('tax_invoice_item_temps')
        ->select('crusher', 'destination','rate','vat_rate', 'toll_fee', DB::raw('sum(qty) as total_qty'), DB::raw('sum(vat_amount) as total_vat_amount'), DB::raw('count(qty) as total_trip'), DB::raw('sum(toll_fee) as total_toll_fee'))
        ->groupBy('crusher','destination','rate','vat_rate', 'toll_fee')
        ->where('invoice_id', $id)
        ->get();
        // dd($invoice_items);
        return view('backend.customer-invoice.invoice', compact('invoice', 'terms', 'invoice_items'));
    }
    public function draft_invoice_edit($id){
        $invoice= TaxInvoiceTemp::find($id);
        $records=TaxInvoiceItemTemp::where('invoice_id', $invoice->id)->get();
        $customers= PartyInfo::where('pi_type','Customer')->get();
        $projects= ProjectDetail::all();
        $cost_centers= CostCenter::all();
        $pay_modes= PayMode::all();
        $terms = PayTerm::get();
        return view('backend.customer-invoice.draft-invoice-edit', compact('invoice','customers','records','projects','cost_centers','pay_modes', 'terms'));
    }
    public function draft_save_customer_invoice(Request $request, $id){
        $tax_invoice                = TaxInvoiceTemp::find($id);
        $tax_invoice->customer_id   = $request->customer_id;
        $tax_invoice->project_id    = $request->project;
        $tax_invoice->date          = $request->date;
        $tax_invoice->cost_center_id= $request->cost_center;
        $tax_invoice->pay_mode      = $request->pay_mode;
        $tax_invoice->amount        = $request->total_amount;
        $tax_invoice->vat_amount    = $request->total_vat;
        $tax_invoice->paid_amount   = $request->payment_amount;
        $tax_invoice->due_amount    = $request->due_amount;
        $tax_invoice->pay_terms     = $request->pay_terms;
        $tax_invoice->due_date      = $request->due_date;
        $tax_invoice->lpo_number    = $request->lpo_number;
        $tax_invoice->month         = $request->month?$request->month.'-01':null;
        $tax_invoice->pay_term      = $request->pay_term;
        $tax_invoice->created_by    = Auth::id();
        $tax_invoice->save();
        $i=0;
        $total_amount= 0;
        $total_vat=0;
        $vat_desc='';
        foreach($request->record_id as $record){
            // return $record_data;
            $rate= $request->rate[$i];
            $amount = round(($request->t_weight[$i]*$rate), 2);
            $v_amount= round(($amount * $request->v_rate / 100), 2);
            $total_amount= $total_amount+ $amount;
            $vat_desc.='=='.$v_amount;

            $inv_item                   = TaxInvoiceItemTemp::find($record);
            $inv_item->customer_id      = $request->customer_id;
            $inv_item->rate             = $rate;
            $inv_item->amount           = $amount;
            $inv_item->vat_rate         = $request->v_rate;
            $inv_item->vat_amount       = $v_amount;
            $inv_item->date             = $request->date;
            $inv_item->save();
            $i++;
        }
        $total_vat                  = round($total_amount*$request->v_rate / 100, 2);
        $tax_invoice->amount        = $total_amount;
        $tax_invoice->vat_amount    = $total_vat;
        $tax_invoice->paid_amount   = $request->payment_amount;
        $tax_invoice->due_amount    = $total_amount+ $total_vat - $request->payment_amount;
        $tax_invoice->save();
        $notification= array(
            'message'       => 'Invoice Update successfully!',
            'alert-type'    => 'success'
        );
        return back()->with($notification);
    }
    public function decline_invoice_edit(Request $request,$id){
        $request->session()->forget('truck_ids');
        $invoice= TaxInvoiceTemp::find($id);
        $temp_records = TaxInvoiceItemTemp::where('invoice_id', $invoice->id)->get();
        $records=DB::table('tax_invoice_item_temps')->where('invoice_id', $invoice->id)->select('crusher', 'destination')->groupBy('crusher','destination')->get();
        foreach($records as $record){
            $new_datas = DB::table('tax_invoice_item_temps')->where('invoice_id', $invoice->id)->where('crusher', $record->crusher)->where('destination', $record->destination)->get();
            if($new_datas){
                $session_data = [];
                foreach($new_datas as $new_data){
                    array_push($session_data, $new_data->item_id);
                }
                Session::push('truck_ids', $session_data);
            }
        }
        // dd(Session::get('truck_ids'));
        $invoice_items= DB::table('tax_invoice_item_temps')
        ->select('crusher', 'destination','rate','vat_rate', 'toll_fee', DB::raw('sum(qty) as total_qty'), DB::raw('sum(vat_amount) as total_vat_amount'), DB::raw('count(qty) as total_trip'), DB::raw('sum(toll_fee) as total_toll_fee'),DB::raw('sum(qty) as total_weight'))
        ->groupBy('crusher','destination','rate','vat_rate', 'toll_fee')
        ->where('invoice_id', $id)
        ->get();
        $customers= PartyInfo::where('pi_type','Customer')->get();
        $projects= ProjectDetail::all();
        $cost_centers= CostCenter::all();
        $pay_modes= PayMode::all();
        return view('backend.customer-invoice.decline-invoice-edit', compact('invoice','customers','records','projects','cost_centers','pay_modes', 'invoice_items', 'temp_records'));
    }
    public function decline_customer_invoice_update(Request $request, $id){
        $tax_invoice                = TaxInvoiceTemp::find($id);
        $tax_invoice->customer_id   = $request->customer_id;
        $tax_invoice->project_id    = $request->project;
        $tax_invoice->date          = $request->date;
        $tax_invoice->cost_center_id= $request->cost_center;
        $tax_invoice->pay_mode      = $request->pay_mode;
        $tax_invoice->amount        = $request->total_amount;
        $tax_invoice->vat_amount    = $request->total_vat;
        $tax_invoice->paid_amount   = $request->payment_amount;
        $tax_invoice->due_amount    = $request->due_amount;
        $tax_invoice->month         = $request->month?$request->month.'-01':null;
        $tax_invoice->pay_term      = $request->pay_term;
        $tax_invoice->created_by    = Auth::id();
        $tax_invoice->status        = 'Authorize';
        $tax_invoice->save();
        TaxInvoiceItemTemp::where('invoice_id',$tax_invoice->id)->delete();
        $i=0;
        $total_amount= 0;
        $total_vat=0;
        $vat_desc='';
        $new_datas = Session::get('truck_ids');
        $toll_fee_amount= 0;
        $toll_fees = $request->toll_fee;
        $rates = $request->rate;
        foreach($new_datas as $key => $datas){
            $rate= $rates[$key];
            foreach($datas as $id){
                $record_data= TruckRecords::find($id);
                $amount= round(($record_data->weight*$rate), 2);
                $v_amount= round(($amount * $request->v_rate / 100), 2);
                $total_amount= $total_amount+ $amount;
                $toll_fee_amount += $record_data->toll_fee;
                $desc= $record_data->crusher.' To '.$record_data->destination.'('.$record_data->material.') '.$record_data->serial_no;
                $vat_desc.='=='.$v_amount;

                $inv_item                   = new TaxInvoiceItemTemp();
                $inv_item->invoice_id       = $tax_invoice->id;
                $inv_item->invoice_no       = $tax_invoice->invoice_no;
                $inv_item->item_id          = $record_data->id;
                $inv_item->truck_id         = $record_data->truck_id;
                $inv_item->customer_id      = $request->customer_id;
                $inv_item->description      = $desc;
                $inv_item->crusher          = $record_data->crusher;
                $inv_item->destination      = $record_data->destination;
                $inv_item->qty              = $record_data->weight;
                $inv_item->rate             = $rate;
                $inv_item->amount           = $amount;
                $inv_item->vat_rate         = $request->v_rate;
                $inv_item->vat_amount       = $v_amount;
                $inv_item->toll_fee         = $record_data->toll_fee;
                $inv_item->record_date      = $record_data->date;
                $inv_item->supplier_id      = $record_data->truck_owner;
                $inv_item->date             = $request->date;
                $inv_item->save();
                $record_data->is_invoiced   =1;
                $record_data->save();
                $i++;
            }
        }
        $total_vat                  = round($total_amount*$request->v_rate / 100, 2);
        $tax_invoice->amount        = $total_amount+$toll_fee_amount;
        $tax_invoice->vat_amount    = $total_vat;
        $tax_invoice->paid_amount   = $request->payment_amount;
        $tax_invoice->due_amount    = $total_amount+ $total_vat+$toll_fee_amount - $request->payment_amount;
        $tax_invoice->save();
        $notification= array(
            'message'       => 'Invoice Updated!',
            'alert-type'    => 'success'
        );
        $request->session()->forget('truck_ids');
        // dd($tax_invoice);
        if($tax_invoice->status =='Authorize'){
            return redirect('business-operation/invoice-athurization-list')->with($notification);
        }elseif($tax_invoice->status =='Approval'){
            return redirect('business-operation/invoice-approval-list')->with($notification);
        }else{
            return redirect('declined-invoice-list')->with($notification);
        }
    }

    public function temp_invoice_sum_print($id){
        $invoice= TaxInvoiceTemp::find($id);
        $invoice_items= DB::table('tax_invoice_item_temps')
        ->select('crusher', 'destination','rate','vat_rate', 'toll_fee', DB::raw('sum(qty) as total_qty'), DB::raw('sum(vat_amount) as total_vat_amount'), DB::raw('count(qty) as total_trip'), DB::raw('sum(toll_fee) as total_toll_fee'))
        ->groupBy('crusher','destination','rate','vat_rate', 'toll_fee')
        ->where('invoice_id', $id)
        ->get();
        // return $invoice_items;
        $terms = PayTerm::get();
        return view('backend.customer-invoice.invoice-sum-print', compact('invoice_items','invoice', 'terms'));
    }

    public function temp_invoice_sumview($id){
        $invoice= TaxInvoiceTemp::find($id);
        $invoice_items= DB::table('tax_invoice_item_temps')
        ->select('crusher', 'destination','rate','vat_rate', 'toll_fee', DB::raw('sum(qty) as total_qty'), DB::raw('sum(vat_amount) as total_vat_amount'), DB::raw('count(qty) as total_trip'), DB::raw('sum(toll_fee) as total_toll_fee'))
        ->groupBy('crusher','destination','rate','vat_rate', 'toll_fee')
        ->where('invoice_id', $id)
        ->get();
        $terms = PayTerm::get();
        return view('backend.customer-invoice.invoice-sumview', compact('invoice','invoice_items', 'terms'));
    }
    public function multiple_draft_invoice(Request $request){
        Gate::authorize('app.invoice.invoice_view');
        $records = $request->records;
        if($records == null){
            $notification= array(
                'message'       => 'Please at least one invoice select!',
                'alert-type'    => 'error'
            );
            return redirect('business-operation/draft-invoice-list')->with($notification);
        };
        foreach($records as $key => $recode){
            $invoice = TaxInvoiceTemp::find($recode);
            $invoice->status = 'Authorize';
            $invoice->save();
        }

        $notification= array(
            'message'       => 'Invoice Submit successfully!',
            'alert-type'    => 'success'
        );
        return redirect('business-operation/draft-invoice-list')->with($notification);
    }
    public function multiple_authorize_invoice(Request $request){
        Gate::authorize('app.invoice.invoice_authorize');
        $records = $request->records;
        if($records == null){
            $notification= array(
                'message'       => 'Please at least one invoice select!',
                'alert-type'    => 'error'
            );
            return redirect('business-operation/invoice-athurization-list')->with($notification);
        };
        foreach($records as $key => $recode){
            $pre_inv=TaxInvoiceTemp::find($recode);
            $pre_inv->status="Approve";
            $pre_inv->authorized_by=Auth::id();
            $pre_inv->save();
        }
        $notification= array(
            'message'       => 'Invoice Authorized successfully!',
            'alert-type'    => 'success'
        );
        return redirect('business-operation/invoice-athurization-list')->with($notification);
    }
    public function multiple_approval_invoice(Request $request){
        Gate::authorize('app.invoice.invoice_approval');
        $records = $request->records;
        if($records == null){
            $notification= array(
                'message'       => 'Please at least one invoice select!',
                'alert-type'    => 'error'
            );
            return redirect('business-operation/invoice-approval-list')->with($notification);
        };
        foreach($records as $key => $recode){
            $this->authorize_invoice('customer-invoice',$recode);
        }
        $notification= array(
            'message'       => 'Invoice Approved successfully!',
            'alert-type'    => 'success'
        );

        return redirect('business-operation/invoice-approval-list')->with($notification);
    }
    public function truck_service_process(Request $request){
        $customer_id= $request->customer_id;
        $date_from= $request->date_from;
        $date_to= $request->date_to;
        $truck_ids = $request->records;
        $records = DB::table('truck_records')
        ->whereIn('truck_records.id', $request->records)
        ->join('trucks', 'trucks.id', '=', 'truck_records.truck_id')
        ->select(
            'truck_records.crusher',
            'truck_records.destination',
            'truck_records.material',
            'truck_records.serial_no',
            'truck_records.tkt_number',
            'truck_records.trasporter',
            'truck_records.date',
            'truck_records.weight',
            'truck_records.rate',
            'truck_records.amount',
            'truck_records.id',
            'trucks.vehicle_number as trucks',
            'toll_fee',

        )->groupBy(
            'truck_records.crusher',
            'truck_records.destination',
            'truck_records.material',
            'truck_records.serial_no',
            'truck_records.tkt_number',
            'truck_records.trasporter',
            'truck_records.date',
            'truck_records.weight',
            'truck_records.rate',
            'truck_records.id',
            'trucks.vehicle_number',
            'truck_records.toll_fee',
            'truck_records.amount',
        );
        if($customer_id){
            $records = $records->where('customer_id', $customer_id);
        }
        if($request->from !='' && $request->to !=''){
            $records = $records->whereBetween('date',[$request->from,$request->to]);
        }
        $records = $records->get();
        //return $records;
        $vats = VatRate::all();
        $toll_setup = Setup::where('name', 'Toll Setup')->first();
        return view('backend.customer-invoice.truck-service-add-summarry', compact('records','customer_id', 'date_to', 'date_from', 'truck_ids','vats', 'toll_setup'));
    }
    public function truck_service_add(Request $request){
        $customer_id= $request->customer_id;
        $date_from= null;
        $date_to= null;
        $records = TruckRecords::where('customer_id', $request->customer_id)
        ->when(!empty($request->item_id), function($query) use ($request) {
            return $query->whereNotIn('id', $request->item_id);
        })
        ->orderBy('id', 'desc')
        ->where('is_invoiced', 0);
        if($request->date_from !='' && $request->date_to !=''){
            // return $request->all();
            $old_date = explode('/', $request->date_from);
            $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
            $new_date = date('Y-m-d', strtotime($new_data));
            // $new_date = \DateTime::createFromFormat("Y-m-d", $new_date);

            $old_date2 = explode('/', $request->date_to);
            $new_data2 = $old_date2[0].'-'.$old_date2[1].'-'.$old_date2[2];
            $new_date2 = date('Y-m-d', strtotime($new_data2));
            // $new_date2 = \DateTime::createFromFormat("Y-m-d", $new_date2);

            $records = $records->whereBetween('date',[$new_date,$new_date2]);
            $date_from= $new_date;
            $date_to= $new_date2;
        }
        if($request->crusher){
            $records = $records->where('crusher', $request->crusher);
        }
        if($request->destination ){
            $records = $records->where('destination', $request->destination);
        }
        $records = $records->get();
        return view('backend.customer-invoice.truck-service-add', compact('records', 'date_from', 'date_to'));
    }
    public function remove_truck_id_session(Request $request){
        $request->session()->forget('truck_ids');
        $request->session()->forget('c_t_records');
        $customer = PartyInfo::where('id', $request->customer_id)->first();
        return $customer;
    }
    public function customer_invoice_reports(Request $request){
        $date = '';
        $to = '';
        $from = '';
        $customer = '';
        $customers = PartyInfo::where('pi_type', 'customer')->get();
        $tax_invoices = TaxInvoice::orderBy('id', 'asc');
        $temp_tax_invoices = TaxInvoiceItem::orderBy('id', 'asc');
        if($request->date){
            $old_date = explode('/', $request->date);
            $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
            $new_date = date('Y-m-d', strtotime($new_data));

            $date = $new_date;
            $tax_invoices = $tax_invoices->where('date', $new_date);
            $temp_tax_invoices = $temp_tax_invoices->where('date', $new_date);
        }if($request->from && $request->to){
            $old_date = explode('/', $request->from);
            $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
            $new_date = date('Y-m-d', strtotime($new_data));
            // $new_date = \DateTime::createFromFormat("Y-m-d", $new_date);
            $old_date2 = explode('/', $request->to);
            $new_data2 = $old_date2[0].'-'.$old_date2[1].'-'.$old_date2[2];
            $new_date2 = date('Y-m-d', strtotime($new_data2));
            // $new_date2 = \DateTime::createFromFormat("Y-m-d", $new_date2);

            $from = $new_date;
            $to = $new_date2;
            $tax_invoices = $tax_invoices->whereBetween('date', [$new_date, $new_date2]);
            $temp_tax_invoices = $temp_tax_invoices->whereBetween('date', [$new_date, $new_date2]);
        }if($request->customer_id){
            $customer = PartyInfo::find($request->customer_id);
            $tax_invoices = $tax_invoices->where('customer_id', $request->customer_id);
            $temp_tax_invoices = $temp_tax_invoices->where('customer_id', $request->customer_id);
        }
        if($request->date || ($request->from && $request->to) || $request->customer_id){
            $tax_invoices = $tax_invoices->get();
            $temp_tax_invoices = $temp_tax_invoices->get();
            return view('backend.report.customer-invoice-report', compact('customers', 'tax_invoices', 'date', 'to', 'from', 'customer', 'temp_tax_invoices'));
        }else{
            $tax_invoices = $tax_invoices->where('date', date('Y-m-d'))->get();
            $temp_tax_invoices = $temp_tax_invoices->where('date', date('Y-m-d'))->get();
        }
        return view('backend.report.customer-invoice-report', compact('customers', 'tax_invoices', 'date', 'to', 'from', 'customer', 'temp_tax_invoices'));
    }
    public function third_party_report(Request $request){
        $date = '';
        $to = '';
        $from = '';
        $customer = '';
        $customers = PartyInfo::where('pi_type', 'Third Party')->get();
        $tax_invoices = TaxInvoice::orderBy('id', 'asc');
        if($request->date){
            $old_date = explode('/', $request->date);
            $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
            $new_date = date('Y-m-d', strtotime($new_data));

            $date = $new_date;
            $tax_invoices = $tax_invoices->where('date', $new_date);
        }if($request->from && $request->to){
            $old_date = explode('/', $request->from);
            $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
            $new_date = date('Y-m-d', strtotime($new_data));
            // $new_date = \DateTime::createFromFormat("Y-m-d", $new_date);
            $old_date2 = explode('/', $request->to);
            $new_data2 = $old_date2[0].'-'.$old_date2[1].'-'.$old_date2[2];
            $new_date2 = date('Y-m-d', strtotime($new_data2));
            // $new_date2 = \DateTime::createFromFormat("Y-m-d", $new_date2);
            $from = $new_date;
            $to = $new_date2;
            $tax_invoices = $tax_invoices->whereBetween('date', [$new_date, $new_date2]);
        }if($request->customer_id){
            $customer = PartyInfo::find($request->customer_id);
            $tax_invoices = $tax_invoices->where('customer_id', $request->customer_id);
        }
        // dd($from);
        if($request->date || ($request->from && $request->to) || $request->customer_id){
            $tax_invoices = $tax_invoices->get();
            return view('backend.report.third-party-report', compact('customers', 'tax_invoices', 'date', 'to', 'from', 'customer'));
        }else{
            $tax_invoices = $tax_invoices->where('date', date('Y-m-d'))->get();
        }
        return view('backend.report.third-party-report', compact('customers', 'tax_invoices', 'date', 'to', 'from', 'customer'));
    }
    // public function cusher_destination_report(Request $request){
    //     $date = '';
    //     $to = '';
    //     $from = '';
    //     $customers = PartyInfo::where('pi_type', 'customer')->get();
    //     $crusher = Cursher::all();
    //     $destination = Destination::all();
    //     $customer = '';
    //     $invoice_items= DB::table('tax_invoice_items')
    //     ->select('crusher', 'destination','rate','vat_rate', 'toll_fee', 'record_date',DB::raw('sum(qty) as total_qty'), DB::raw('sum(vat_amount) as total_vat_amount'), DB::raw('count(qty) as total_trip'), DB::raw('sum(toll_fee) as total_toll_fee'))
    //     ->groupBy('crusher','destination','rate', 'toll_fee', 'vat_rate', 'record_date');
    //     if($request->date){
    //         $old_date = explode('/', $request->date);
    //         $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
    //         $new_date = date('Y-m-d', strtotime($new_data));

    //         $date = $new_date;
    //         $invoice_items = $invoice_items->where('record_date', $new_date);
    //     }
    //     if($request->from && $request->to){
    //         $old_date = explode('/', $request->from);
    //         $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
    //         $new_date = date('Y-m-d', strtotime($new_data));
    //         // $new_date = \DateTime::createFromFormat("Y-m-d", $new_date);
    //         $old_date2 = explode('/', $request->to);
    //         $new_data2 = $old_date2[0].'-'.$old_date2[1].'-'.$old_date2[2];
    //         $new_date2 = date('Y-m-d', strtotime($new_data2));
    //         // $new_date2 = \DateTime::createFromFormat("Y-m-d", $new_date2);
    //         $from = $new_date;
    //         $to = $new_date2;
    //         $invoice_items = $invoice_items->whereBetween('record_date', [$new_date, $new_date2]);
    //     }
    //     if($request->customer_id){
    //         $customer = PartyInfo::find($request->customer_id);
    //         $invoice_items = $invoice_items->where('customer_id', $request->customer_id);
    //     }
    //     if($request->crusher_name){
    //         $invoice_items = $invoice_items->where('crusher', $request->crusher_name);
    //     }
    //     if($request->destination_name){
    //         $invoice_items = $invoice_items->where('destination', $request->destination_name);
    //     }
    //     $invoice_items = $invoice_items->get();
    //     // dd($invoice_items);
    //     return view('backend.report.cusher-destination-report', compact('invoice_items', 'date', 'to', 'from', 'customers', 'customer', 'crusher', 'destination'));
    // }
    public function cusher_destination_report(Request $request){
        $date = '';
        $to = '';
        $from = '';
        $customers = PartyInfo::where('pi_type', 'customer')->get();
        $crusher = Cursher::all();
        $destination = Destination::all();
        $customer = '';
        $invoice_items= TruckRecords::where('is_invoiced', 1)->orderBy('id', 'desc');
        if($request->date){
            $old_date = explode('/', $request->date);
            $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
            $new_date = date('Y-m-d', strtotime($new_data));

            $date = $new_date;
            $invoice_items = $invoice_items->where('record_date', $new_date);
        }
        if($request->from && $request->to){
            $old_date = explode('/', $request->from);
            $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
            $new_date = date('Y-m-d', strtotime($new_data));
            // $new_date = \DateTime::createFromFormat("Y-m-d", $new_date);
            $old_date2 = explode('/', $request->to);
            $new_data2 = $old_date2[0].'-'.$old_date2[1].'-'.$old_date2[2];
            $new_date2 = date('Y-m-d', strtotime($new_data2));
            // $new_date2 = \DateTime::createFromFormat("Y-m-d", $new_date2);
            $from = $new_date;
            $to = $new_date2;
            $invoice_items = $invoice_items->whereBetween('record_date', [$new_date, $new_date2]);
        }
        if($request->customer_id){
            $customer = PartyInfo::find($request->customer_id);
            $invoice_items = $invoice_items->where('customer_id', $request->customer_id);
        }
        // dd($request->crusher_name);
        if($request->crusher_name){
            $invoice_items = $invoice_items->where('crusher', $request->crusher_name);
        }
        if($request->destination_name){
            $invoice_items = $invoice_items->where('destination', $request->destination_name);
        }
        if($request->date || ($request->from && $request->to) || $request->customer_id || $request->crusher_name || $request->destination_name){
            $invoice_items = $invoice_items->get();
        }else{
            $invoice_items = $invoice_items->where('date', date('Y-m-d'))->get();
        }

        // dd($invoice_items);
        return view('backend.report.cusher-destination-report', compact('invoice_items', 'date', 'to', 'from', 'customers', 'customer', 'crusher', 'destination'));
    }
    public function check_invoice_no(Request $request){
        $temp_invoice = TaxInvoiceTemp::where('invoice_no', $request->invoice_no)->first();
        $invoice = TaxInvoice::where('invoice_no', $request->invoice_no)->first();

        return  $invoice? 'Invoice Number Already Exist':($temp_invoice? ($temp_invoice->status=='Draft'?'Invoice Number Already Exist and Waiting in Draft!':($temp_invoice->status=='Authorize'?'Invoice Number Already Exist and Waiting for Authorization!':'Invoice Number Already Exist and Waiting for Approval')):false);
      
    }
}
