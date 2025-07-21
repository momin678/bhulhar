<?php

namespace App\Http\Controllers\backend;

use App\Fifo;
use App\GoodsReceived;
use App\GoodsReceivedDetails;
use App\Http\Controllers\Controller;
use App\Notification;
use App\PayMode;
use App\PayTerm;
use App\Purchase;
use App\PurchaseDetail;
use App\PurchaseReturn;
use App\PurchaseReturn1;
use App\PurchaseReturnDetail;
use App\PurchaseReturnDetailsTemp;
use App\PurchaseReturnTemp;
use App\PurchseDetailTemp;
use App\Stock;
use App\StockTransection;
use App\VatRate;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PurchaseReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $product_purchases = Purchase::get();
     //   return([$purchase_info->partInfo,$purchase_items]);
        return view('backend.purchase-return.index', compact( 'product_purchases'));
      
    }
        public function purchadse_info_get(Request $request){
            $item = Purchase::find($request->id);
            $purchase_info = Purchase::find($request->id);
            $sub_invoice = Carbon::now()->format('Ymd');
            $return = PurchaseReturnTemp::whereDate('created_at', Carbon::today())->where('purchase_return_no', 'LIKE', "%{$sub_invoice}%")->orderBy('id','desc')->first();
    
            if ($return) {
                $invoice_no = $return->purchase_return_no + 1;
            } else {
                $invoice_no = Carbon::now()->format('Ymd') . '001';
            }
            $newReturn = new PurchaseReturnTemp();
            $newReturn->purchase_return_no = $invoice_no;
            $newReturn->save();
            // return $purchase_info;
            $purchase_items = PurchaseDetail::where('purchase_no', $item->purchase_no)->get();
          //  return($purchase_items->brandName);
            $payMode = PayMode::all();
            $payTerms = PayTerm::all();
            return Response()->json([
                'page' => view('backend.purchase-return.data', ['newReturn'=>$newReturn,'purchase_info'=>$purchase_info, 'items'=>$purchase_items, 'purchase_items'=> $purchase_items, 'payMode'=>$payMode, 'payTerms'=>$payTerms,'i' => 1])->render()
            ]);
        }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function preturn_item_temp(Request $request){
        // return $request->all();

        $temp_item_store =  PurchaseReturnDetailsTemp::where('purchase_return_no',$request->purchase_return_no)->where('item_id', $request->item_id)->first();
        $item_store =  PurchaseReturnDetail::where('item_id', $request->item_id)->get();
        //return($item_store);
      
        $qty_v = $item_store->sum('return_qty');
      
        if($temp_item_store){

            $qty_t = $temp_item_store->return_qty;
            
        }
        else{
            $qty_t = 0;
   
        }

    if( $request->quantity1 >= $request->quantity){
       if($temp_item_store){
       if($request->quantity1 >= $qty_t + $request->quantity){
        if($request->quantity1 >= $qty_v + $request->quantity +$qty_t){

            $vat_rate = VatRate::find($request->vat_rate)->value;
            $total = $request->purchase_rate * $request->quantity;
            $vat_amount = ($total * $vat_rate) / 100;
            $total_amount_with_amount = $total + $vat_amount;

            $temp_item_store->received_qty = $request->quantity1;
            $temp_item_store->return_qty = $temp_item_store->return_qty+$request->quantity;
           
            $temp_item_store->total =$temp_item_store->total + $total_amount_with_amount;
            $temp_item_store->save();
        }
        else
        {
        $d =$request->quantity1 - ($qty_v + $qty_t);
        $message = array('message' => 'Your input quantity more available than purchase  quantity ' .'('.$d.')'. '!!!', 'title' => 'error');
    
        return Response()->json($message);
        }
        }
        else
        {
        $d =$request->quantity1 - ($qty_v + $qty_t);
        $message = array('message' => 'Your input quantity more than available purchase  quantity ' .'('.$d.')'. '!!!', 'title' => 'error');
    
        return Response()->json($message);
        }
       
    
      }
        else{
            if($request->quantity1  >=  $qty_v + $request->quantity){
            $vat_rate = VatRate::find($request->vat_rate)->value;
            $total = $request->purchase_rate * $request->quantity;
            $vat_amount = ($total * $vat_rate) / 100;
            $total_amount_with_amount = $total + $vat_amount;
            $temp_item_store = new PurchaseReturnDetailsTemp();
            $temp_item_store->purchase_no = $request->purchase_no;
            $temp_item_store->purchase_return_no = $request->purchase_return_no;
            $temp_item_store->vat_rate = $vat_rate;
            $temp_item_store->item_id = $request->item_id;
            $temp_item_store->received_qty = $request->quantity1;
            $temp_item_store->return_qty = $request->quantity;
            $temp_item_store->purchase_rate = $request->purchase_rate;
            $temp_item_store->total = $total_amount_with_amount;
            $temp_item_store->save();
        }
        
        else
        {
        $d =$request->quantity1 -($qty_v + $qty_t);
        $message = array('message' => 'Your input quantity more than purchase  quantity ' .'('.$d.')'. '!!!', 'title' => 'error');
    
        return Response()->json($message);
        }
       }
       }
       else{
        $message = array('message' => 'Your input quantity more than purchase  quantity ' .'('.$request->quantity1.')'. '!!!', 'title' => 'error');

        return Response()->json($message);
       }
        
       $return_item = PurchaseReturnDetailsTemp::where('purchase_return_no',$temp_item_store->purchase_return_no)->get();
    
       return Response()->json([
         'page' => view('backend.purchase-return.return-item', ['return_item'=>$return_item,'i' => 1])->render()
     ]);
   
 
  
    }
    public function preturn_item_temp_delete(Request $request){
    
        $temp_item_store =  PurchaseReturnDetailsTemp::where('purchase_no',$request->purchase_no1)->where('item_id', $request->item_id1)->first();
        $temp_item_store->delete();
        $return_item = PurchaseReturnDetailsTemp::where('purchase_no',$request->purchase_no1)->get();
    
        return Response()->json([
          'page' => view('backend.purchase-return.return-item', ['return_item'=>$return_item,'i' => 1])->render()
      ]);
    
  
   
     }
     public function create()
     {
         $date=0;
         $from = null;
         $to = null;
         $Returns = PurchaseReturn::orderBy('id', 'desc')->with('items')->paginate(15);
 
      // return($Returns);
         return view('backend.purchase-return.show', compact( 'Returns','from', 'to','date'));
     }
 
     public function searchDailypr(Request $request)
     {
     //return($request);
         $date=$request->date;
         $from = null;
         $to = null;
 
         $Returns = PurchaseReturn::whereDate('date', $date)->paginate(15);
 
 
         return view('backend.purchase-return.show', compact( 'Returns','from', 'to','date'));
     }
 
 
     public function searchDailyRangepr(Request $request)
     {
        // dd($request->all());
         $date = null;
         $timefrom = strtotime($request->from);
         $searchDatefrom = date('m/d/Y',$timefrom);
         $timeto = strtotime($request->to);
         $searchDateto = date('m/d/Y',$timeto);
         $from=$request->from;
         $to=$request->to;
 
       //  return($request);
         // dd($request->all());
 

 
             // $purchases = $purchases->whereBetween('date', ['2022-08-20', '2022-08-26']);
             $Returns = PurchaseReturn::whereBetween('date', [$from, $to])->paginate(15);
         
 
         return view('backend.purchase-return.show', compact( 'Returns','from', 'to','date'));
     }
 
    public function ReturnPrint($id)
    {
        $invoice=PurchaseReturn::where('purchase_return_no',$id)->with('items')->first();
        $items=PurchaseReturnDetail::where('purchase_return_no',$invoice->purchase_return_no)->get();

         //return($invoice);
        return view('backend.pdf.Returnpurchase',compact('invoice','items'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
 
    public function store(Request $request)
    {
       $purchase=Purchase::where('purchase_no',$request->purchase_no)->first();
       $exit_po_no = PurchaseReturn::whereDate("created_at", "=", date("Y-m-d"))->max("purchase_return_no");
        $temp_po_no = '';
        if($exit_po_no){
            $arr = preg_split('/(?<=[0-9])(?=[a-z]+)/i',$exit_po_no);                                                               
            $temp_po_no = $arr[0] +1;
        }else{
            $temp_po_no = date("Ymd").'01';
        }

        $new_po_no = $temp_po_no.'PR';
        $purchases_return = new PurchaseReturn;
        $purchases_return->purchase_return_no = $new_po_no;

        $purchases_return->purchase_no = $request->purchase_no;
        $purchases_return->trn = $request->trn;
        $purchases_return->paymode = $request->pay_mode;
        $purchases_return->address = $request->address;

        
        $purchases_return->project_id = $request->project_id;
        $purchases_return->supplier_id = $request->suplyer;
        $purchases_return->challan_number = $request->contact_no;
        $purchases_return->date = $request->pay_date;
        $purchases_return->state = "PT Editor";
        $purchases_return->status = 1;
        $save = $purchases_return->save();

        $temp_item_stores =  PurchaseReturnDetailsTemp::where('purchase_return_no',$request->purchase_return_no)->get();
       foreach($temp_item_stores as $data){
                 $temp_item_store = new PurchaseReturnDetail();
                 $temp_item_store->purchase_return_no = $purchases_return->purchase_return_no;
                 $temp_item_store->purchase_no = $data->purchase_no;
                 $temp_item_store->vat_rate = $data->vat_rate;
                 $temp_item_store->item_id = $data->item_id;
                 $temp_item_store->received_qty = $data->received_qty;
                 $temp_item_store->return_qty = $data->return_qty;
                 $temp_item_store->purchase_rate = $data->purchase_rate;
                 $temp_item_store->total = $data->total;
                 $temp_item_store->save();

                 $stock=StockTransection::where('transection_id',$purchases_return->id)->where('tns_type_code','T')->where('item_id',$temp_item_store->item_id)->first();
                $latestStock=StockTransection::latest()->first();
                // dd($itemReturn->id);
                if(!$stock)
                {
                    $stock=new StockTransection();
                    $stock->transection_id=$purchases_return->id;
                    $stock->item_id=$temp_item_store->item_id;
                }
                $stock->quantity=$temp_item_store->return_qty;
                $stock->stock_effect = -1 ;
                $stock->tns_type_code="Q";
                $stock->tns_description="Purchase Return";
                $stock->save();
                $stock_update=Stock::where('item_id',$temp_item_store->item_id)->first();
                $stock_update->quantity=$stock_update->quantity-$stock->quantity;
                $stock_update->save();
                $fifo=Fifo::where('purchase_id',$purchase->id)->where('item_id',$temp_item_store->item_id)->first();
                $fifo->remaining=$fifo->remaining-$temp_item_store->return_qty;
                $fifo->purchase_return=$fifo->purchase_return+$temp_item_store->return_qty;
                $fifo->save();
                
                $data->delete();
       }
     

        
        $notification = array(
            'message'=> "Item Return Create Successful",
            'alert-type' => 'success'
        );
        return redirect(route('ReturnPrint',$purchases_return->purchase_return_no))->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $Returns = PurchaseReturn::orderBy('id', 'desc')->get();
        return view('backend.purchase-return.show', compact( 'Returns'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pt_info = PurchaseReturn::find($id);
        $pt_items = PurchaseReturnDetail::where('purchase_return_no', $pt_info->purchase_return_no)->get();
        $gr_items = GoodsReceivedDetails::where('goods_received_no', $pt_info->gr_no)->get();
        $return_lists = PurchaseReturn::where("status", 200)->get();
        return view('backend.purchase-return.edit', compact('pt_info', 'pt_items', 'return_lists', 'gr_items'));
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
            'purchase_return_no'=> 'required',
            'purchase_no'=> 'required',
            'goods_received_no'=> 'required',
            'purchase_return_no'=> 'required',
        ]);
        $temp_items = PurchaseReturnDetail::where('purchase_return_no', $request->purchase_return_no)->get();
        if($temp_items->isEmpty()){
            return back()->with('error', 'At lest One Item select');
        }
        $purchases_return = PurchaseReturn::find($id);
        $purchases_return->date = $request->date;
        $purchases_return->status = 1;
        $purchases_return->state = "PT Editor";
        $save = $purchases_return->save();
        if($save){
            $n = Notification::where("purchase_id", $request->purchase_return_no)->where("state", "PT Editor")->where("status", 99)->first();
            if($n){
                $n->status = 0;
            $n->save();
            }
        }
        $notification = array(
            'message'=> "Item Return Update Successful",
            'alert-type' => 'success'
        );
        return redirect('purchase-return')->with($notification);
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
    public function pt_details(PurchaseReturn $id){
        $pt_info = $id;
        $pt_items = PurchaseReturnDetail::where('purchase_return_no', $pt_info->purchase_return_no)->get();
        $return_lists = PurchaseReturn::orderBy('id', 'desc')->paginate(15);
        return view('backend.purchase-return.pt-details', compact('pt_info', 'pt_items', 'return_lists'));
    }
    public function pt_return(GoodsReceived $id){
        $gr_info = $id;
        $po_info = Purchase::where("purchase_no", $gr_info->po_no)->first();
        $gr_lists = GoodsReceived::where("po_no", $po_info->purchase_no)->get();
        // dd($gr_lists);
        $gr_items = GoodsReceivedDetails::where('goods_received_no', $gr_info->goods_received_no)->get();
        $return_lists = PurchaseReturn::orderBy('id', 'desc')->paginate(15);
        return view('backend.purchase-return.create', compact('gr_info', 'gr_items', 'return_lists'));
    }
    public function purchase_return_authorize(){
        $authrize_pt = PurchaseReturn::where('status', 0)->get();
        return view('backend.purchase-return.authorize-pt-list', compact('authrize_pt'));
    }
    public function pt_authorize_details(PurchaseReturn $id){
        $pt_info = $id;
        $pt_items = PurchaseReturnDetail::where('purchase_return_no', $pt_info->purchase_return_no)->get();
        $return_lists = PurchaseReturn::where("status", 200)->get();
        return view('backend.purchase-return.pt-authorize-details', compact('pt_info', 'pt_items', 'return_lists'));
    }
    public function authorize_pt_reviece(Request $request){
        $authorize_requisition_info = PurchaseReturn::where("purchase_return_no", $request->purchase_return_no)->first();
        $authorize_requisition_info->status = 99;
        $authorize_requisition_info->state = "PT Authorizer";
        $save = $authorize_requisition_info->save();
        if($save){
            $notification = new Notification;
            $notification->purchase_id = $request->purchase_return_no;
            $notification->comment = $request->comment;
            $notification->state = "PT Editor";
            $notification->status = 99;
            $notification->save();
        }
        $notification = array(
            'message' => 'Purchase Return Revise Successful!',
            'alert-type' => 'success'
        );
        return redirect('purchase-return-authorize')->with($notification);
    }
    public function purchase_return_revise(){
        $revise_pt = PurchaseReturn::where('status', 99)->get();
        return view('backend.purchase-return.revise-pt-list', compact('revise_pt'));
    }
    public function authorize_pt_rejected($id){
        $authorize_requisition_info = PurchaseReturn::find($id);
        $authorize_requisition_info->status = 100;
        $authorize_requisition_info->state = "PT Authorizer";
        $save = $authorize_requisition_info->save();
        if($save){
            $notification = new Notification;
            $notification->purchase_id = $authorize_requisition_info->purchase_return_no;
            $notification->comment = "PT Rejected from Authorizer";
            $notification->state = "PT Editor";
            $notification->status = 100;
            $notification->save();
        }
        $notification = array(
            'message' => 'Purchase Return Rejected Successful!',
            'alert-type' => 'success'
        );
        return redirect('purchase-return-authorize')->with($notification);
    }
    public function pt_rejected_list_authorize(){
        $pt_rejected_lists = PurchaseReturn::where('status', 100)->where("state", "PT Approval")->get();
        return view("backend.purchase-return.pt-reject-list", compact('pt_rejected_lists'));
    }
    public function pt_rejected_list_editor(){
        $pt_rejected_lists = PurchaseReturn::where('status', 100)->get();
        return view("backend.purchase-return.pt-reject-list", compact('pt_rejected_lists'));
    }
    public function authorize_pt_submit($id){        
        $authorize_requisition_info = PurchaseReturn::find($id);
        $authorize_requisition_info->status = 1;
        $authorize_requisition_info->save();
        $notification = array(
            'message' => 'Purchase Return Authorize Successful!',
            'alert-type' => 'success'
        );
        return redirect('purchase-return-authorize')->with($notification);
    }
    public function purchase_return_approval(){
        $approval_pt = PurchaseReturn::where('status', 1)->get();
        return view('backend.purchase-return.approval-pt-list', compact('approval_pt'));
    }
    public function pt_approval_details(PurchaseReturn $id){
        $pt_info = $id;
        $pt_items = PurchaseReturnDetail::where('purchase_return_no', $pt_info->purchase_return_no)->get();
        return view('backend.purchase-return.pt-approval-details', compact('pt_info', 'pt_items'));
    }
    public function approval_pt_reviece(Request $request){
        $authorize_pt_info = PurchaseReturn::where("purchase_return_no", $request->purchase_return_no)->first();
        $authorize_pt_info->status = 99;
        $authorize_pt_info->state = "PT Approval";
        $save = $authorize_pt_info->save();
        if($save){
            $data = [
                ['purchase_id'=>$request->purchase_return_no, 'comment'=> $request->comment, 'state'=>"PT Editor", 'status'=>99],
                ['purchase_id'=>$request->purchase_return_no, 'comment'=> $request->comment, 'state'=>"PT Authorize", 'status'=>99],
            ];
            Notification::insert($data);
        }
        $notification = array(
            'message' => 'Purchase Return Revise Successful!',
            'alert-type' => 'success'
        );
        return redirect('purchase-return-approval')->with($notification);
    }
    public function revise_pt_authorize_list(){
        $revise_pt = PurchaseReturn::where('status', 99)->where("state", "PT Approval")->get();
        return view('backend.purchase-return.revise-pt-authorise-list', compact('revise_pt'));

    }
    public function approval_pt_rejected(PurchaseReturn $id){
        $approval_pt_info = $id;
        $approval_pt_info->status = 100;
        $approval_pt_info->state = "PT Approval";
        $save = $approval_pt_info->save();
        if($save){
            $data = [
                ['purchase_id'=>$approval_pt_info->purchase_return_no, 'comment'=> "PT Rejected from Approver", 'state'=>"PT Editor", 'status'=>100],
                ['purchase_id'=>$approval_pt_info->purchase_return_no, 'comment'=> "PT Rejected from Approver", 'state'=>"PT Authorize", 'status'=>100],
            ];
            Notification::insert($data);
        }
        $notification = array(
            'message' => 'Purchase Return Rejected Successful!',
            'alert-type' => 'success'
        );
        return redirect('purchase-return-approval')->with($notification);
    }
    public function pt_approval_process(PurchaseReturn $id){
        $approval_pt_info = $id;
        $approval_pt_info->status = 200;
        $save = $approval_pt_info->save();
        $pt_items = PurchaseReturnDetail::where('purchase_return_no', $approval_pt_info->purchase_return_no)->get();
        if($save){
            foreach($pt_items as $key => $item){
                $stock_effect = new StockTransection;
                $stock_effect->transection_id = $approval_pt_info->id;
                $stock_effect->item_id = $item->item_id;
                $stock_effect->quantity = $item->return_qty;
                $stock_effect->date = $approval_pt_info->date;
                $stock_effect->stock_effect = -1;
                $stock_effect->tns_type_code = "Q";
                $stock_effect->tns_description = "Purchase Return";
                $stock_effect->save();
            }
        }
        $notification = array(
            'message' => 'Purchase Return Transfer Successful!',
            'alert-type' => 'success'
        );
        return redirect('purchase-return-approval')->with($notification);
    }
    public function pt_print(PurchaseReturn $id){
        // dd($id);
        $pt_info = $id;
        $pt_items = PurchaseReturnDetail::where('purchase_return_no', $pt_info->purchase_return_no)->get();
        $return_lists = PurchaseReturn::where("status", 200)->get();
        return view('backend.purchase-return.pt-print-pdf', compact('pt_info', 'pt_items', 'return_lists'));
    }
    public function pt_filter(Request $request){
        if($request->filter_value){
            $filter_value = $request->filter_value;
        }else{
            $filter_value = [];
        }
        $return_lists = PurchaseReturn::orderBy("id", "desc")->whereIn("status", $filter_value)->get();
        return view('backend.purchase-return.filter-value', compact('return_lists'));   
    }
}
