<?php

namespace App\Http\Controllers\backend;

use App\CostCenterType;
use App\Country;
use App\Cursher;
use App\DebitCreditVoucher;
use App\Destination;
use App\Driver;
use App\DriverCommission;
use App\Http\Controllers\Controller;
use App\Imports\TruckServiceImport;
use App\InvoiceItem;
use App\Journal;
use App\JournalRecord;
use App\Material;
use App\Models\AccountHead;
use App\Models\CostCenter;
use App\Models\Payroll\Employee;
use App\PartyInfo;
use App\PayMode;
use App\ProjectDetail;
use App\SupplierInvoice;
use App\SupplierInvoiceItem;
use App\SupplierInvoiceItemTemp;
use App\SupplierInvoiceTemp;
use App\TaxInvoice;
use App\TaxInvoiceItem;
use App\TaxInvoiceItemTemp;
use App\TaxInvoiceTemp;
use App\TempTruckRecord;
use App\TollAmountRecord;
use App\TollFees;
use App\TollRate;
use App\Truck;
use App\TruckRecords;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Excel;
use App\Exports\TruckServiceExport;
use App\Setup;
class TruckController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries= DB::table('countries')->get();
        $parties= PartyInfo::where('pi_type','Supplier')->orWhere('pi_type','Third Party')->orWhere('pi_type','Owner')->get();
        $trucks= Truck::get();
        $drivers = Employee::where('division', 3)->get();
        return view('backend.truck.truck-entry',compact('countries','parties','trucks', 'drivers'));
    }

    public function test_1(Request $request){
        // $request->session()->forget('persons'); return 'Alhamdulillah';
        // return "Alhamdulillah";
        echo "<pre>";
        $data['name']='Mr X3';
        $data['email']='x@gmail.com3';
        $data['address']='Dhaka3';

        print_r($data);
        // Session::push('persons', $data);


        $items = Session::get('persons'); //step 1
        unset($items[4]);//step 2
        Session::put('persons', $items);  //step 3

        $sPerson=$request->session()->get('persons');
        print_r($sPerson);
        // foreach($s)
    }

    public function get_a_vehicle(Request $request){
        $truck= Truck::find($request->truck_id);
        return $truck;
    }

    public function get_a_record(Request $request){
        $record= TruckRecords::find($request->record_id);
        // $record= DB::table('truck_records')
        // ->join('party_infos', 'truck_records.truck_owner', '=', 'party_infos.id')
        // ->select('truck_records.*', 'party_infos.pi_name')
        // ->where('truck_records.id', $request->record_id)
        //     ->get();
        $customers = PartyInfo::where('pi_type', 'Customer')->get();
        $driver = Driver::all();
        $materials = Material::all();
        $crusher = Cursher::all();
        $destination = Destination::all();
        $trucks= Truck::all();
        return view('backend.truck.truck-entry-edit', compact('record','customers', 'materials', 'crusher', 'destination', 'trucks'));
    }

    public function update_vehicle(Request $request){
        // return $request;
        $request->validate(
            [
                'vehicle_number'        => 'required',
                // 'brand'                 => 'required',
                // 'model'                 => 'required',
                // 'origin'                => 'required',
                // 'engine_capacity'       => 'required',
                // 'number_of_tyres'       => 'required',
                // 'owner'                 => 'required',
            ],
            [
                'vehicle_number.required'   => 'Vehicle number is required',
                // 'brand.required'            => 'Brand is required',
                // 'model.required'            => 'Model is required',
                // 'origin.required'           => 'Origin  is required',
                // 'engine_capacity.required'  => 'Engine Capacity is required',
                // 'number_of_tyres.required'  => 'Number of tyres is required',
                // 'owner.required'            => 'Owner is required',

            ]
        );


        $truck= Truck::find($request->truck_id);
        $truck->vehicle_number      = $request->vehicle_number;
        $truck->brand               = $request->brand;
        $truck->model               = $request->model;
        $truck->origin              = $request->origin;
        $truck->engine_capacity     = $request->engine_capacity;
        $truck->no_of_tyres         = $request->number_of_tyres;
        $truck->owner               = $request->owner;
        $truck->driver_id               = $request->driver_id;
        $truck->save();

        $notification= array(
            'message'       => 'Truck updated successfully!',
            'alert-type'    => 'success'
        );

        return back()->with($notification);
    }


    public function truck_service(Request $request){
        // dd($request);
        $session_truck_service = $request->session()->get('items');
        $trucks= Truck::orderBy('id','desc')->get();
        $customers= PartyInfo::where('pi_type','Customer')->get();
        $suppliers= PartyInfo::where('pi_type','Supplier')->get();
        $records = TruckRecords::where('is_invoiced', 0);
        $records_two = $records->get();
        if($request->search){
            $records = $records->where('driver_name', 'like', '%'.$request->search.'%')
                                ->orWhere('material', 'like', "%{$request->search}%")
                                ->orWhere('destination', 'like', "%{$request->search}%")
                                ->orWhere('serial_no', 'like', "%{$request->search}%")
                                ->orWhere('crusher', 'like', "%{$request->search}%")
                                ->orWhereHas('Truck', function($q)use($request){
                                    $q->where('vehicle_number', 'like', "%{$request->search}%");
                                });
        }
        if($request->date){
            $records = $records->where('date', $request->date);
        }
        if($request->from && $request->to){
            $records = $records->whereBetween('date', [$request->from, $request->to]);
        }
        $records = $records->orderBy('id','desc')->paginate(15);
        $dirves = Employee::where('division',3)->get();
        $materials = Material::all();
        $crusher = Cursher::all();
        $destination = Destination::all();
        // dd($destination);
        $tolls = TollFees::all();
        TempTruckRecord::truncate();
        return view('backend.truck.weigh-bridge-index', compact('customers', 'trucks','suppliers','records', 'records_two', 'dirves', 'materials', 'destination', 'crusher', 'tolls', 'session_truck_service'));
    }

    public function add_to_session(Request $request){
        $data['party']      =$request->fld_customer;
        $data['driver_name']=$request->fld_driver_name;
        $data['date']       =$request->fld_date;
        $data['truck']      =$request->fld_truck;
        $data['vehicle_no'] =$request->vehicle_no;
        $data['material']   =$request->fld_material;
        $data['crusher']    =$request->fld_crusher;
        $data['dstn']       =$request->fld_dstn;
        $data['wight']      =$request->fld_wight;
        // $data['truck_owner']=$request->fld_truck_owner;
        $data['truck_owner_name']=$request->truck_owner_name;
        $data['rate']=$request->rate;
        $data['toll_name']=$request->toll_name;
        $data['toll_fee']=$request->toll_fee;
        $data['trasporter']=$request->trasporter;
        $data['tkt_number']=$request->tkt_number;
        $data['commision']=$request->commision;


        Session::push('items', $data);
        // return $data;
        $items = $request->session()->get('items');
        return view('backend.truck.session-service-list', compact('items'));
    }

    public function remove_item_from_session(Request $request){
        // $request->session()->forget('items'); return 'success';
        $items = Session::get('items'); //step 1
        unset($items[$request->data_id]);//step 2
        Session::put('items', $items);  //step 3
        return $request->session()->get('items');
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
        //return $request;
        // dd($request->all());
        $request->validate(
            [
                'vehicle_number'        => 'required',
                // 'brand'                 => 'required',
                // 'model'                 => 'required',
                // 'origin'                => 'required',
                // 'engine_capacity'       => 'required',
                // 'number_of_tyres'       => 'required',
                // 'owner'                 => 'required',
            ],
            [
                'vehicle_number.required'   => 'Vehicle number is required',
                // 'brand.required'            => 'Brand is required',
                // 'model.required'            => 'Model is required',
                // 'origin.required'           => 'Origin  is required',
                // 'engine_capacity.required'  => 'Engine Capacity is required',
                // 'number_of_tyres.required'  => 'Number of tyres is required',
                // 'owner.required'            => 'Owner is required',

            ]
        );

        $vehicle_number = Truck::where('vehicle_number', $request->vehicle_number)->first();
        if($vehicle_number){
            return 'error';
        }
        // if($request->owner == 1 ){
        //     $notification= array(
        //         'message'       => 'KNOOZ TRANSPORT LLC DRIVER NAME NEED!',
        //         'alert-type'    => 'error'
        //     );

        //         return(['message'=>'ASMAA TRANSPORT LLC DRIVER NAME NEED!','alert-type'=>'error']);
        // }
       // return $request;
        $truck= new Truck();
        $truck->vehicle_number      = $request->vehicle_number;
        $truck->brand               = $request->brand;
        $truck->model               = $request->model;
        $truck->origin              = $request->origin;
        $truck->engine_capacity     = $request->engine_capacity;
        $truck->no_of_tyres         = $request->number_of_tyres;
        $truck->owner               = $request->owner;
        $truck->driver_id           = $request->driver_id;
        $truck->save();
        if($request->come_form){
            return $truck;
        }else{
            return('success');
        }

    }


    public function check_truck_service_serial(Request $request){
        $nums= TruckRecords::where('serial_no', $request->serial_no)->count();
        return $nums;
    }

    public function delete_service($id){
        $service= TruckRecords::find($id);
        $service->delete();

        $notification= array(
            'message'       => 'Service Deleted!',
            'alert-type'    => 'success'
        );

        return back()->with($notification);
    }

    public function save_truck_service(Request $request){
        $records = $request->input('inputs');
       // return $records;
        // dd($records);
        $toll_setup = Setup::where('name', 'Toll Setup')->first();
        if ( $records) {
            foreach( $records as $record){
                // dd($record);
                if(isset($record['truck_id'])){                    
                    $max_serial_no = TruckRecords::max('serial_no');
                    if($max_serial_no){
                        $max_serial_no = $max_serial_no+1;
                    }else{
                        $max_serial_no = 10001;
                    }
                    $truck_details= Truck::find($record['truck_id']);
                    $old_date = explode('/', $record['date']);
                    $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
                    $new_date = date('Y-m-d', strtotime($new_data));
                    $new_date = \DateTime::createFromFormat("Y-m-d", $new_date);

                    if($toll_setup->value=='Automatic'){
                        $destination = Destination::where('name', $record['dstm'])->first();
                        $cruser = Cursher::where('name', $record['crusher'])->first();
                        $toll_fees = TollRate::where('cursher_id', $cruser->id)->where('destination_id', $destination->id)->where('type', 'Fixed')->get();
                        $toll_fee_change = TollRate::where('cursher_id', $cruser->id)->where('destination_id', $destination->id)->where('type', 'Changeable')->first();
                        $toll_fee_amount = $toll_fees->sum('amount');
                        if($toll_fee_change){
                            $toll_fee_amount += $toll_fee_change->amount*$record['wgt'];
                        }
                    }else{
                        $toll_fee_amount = $record['toll_fee'];
                    }

                    $t_record= new TruckRecords;
                    $t_record->truck_id= $record['truck_id'];
                    $t_record->customer_id= $record['party_id'];
                    $t_record->driver_name= $record['driver_name'];
                    $t_record->material= $record['material'];
                    $t_record->crusher= $record['crusher'];
                    $t_record->destination= $record['dstm'];
                    $t_record->serial_no= $max_serial_no;
                    $t_record->weight= $record['wgt'];
                    $t_record->date= $new_date;
                    $t_record->truck_owner= $truck_details->party->id;
                    $t_record->rate= $record['rate'];
                    $t_record->toll_fee_id= $record['toll_name'];
                    $t_record->toll_fee= $toll_fee_amount;
                    $t_record->trasporter= $truck_details->party->pi_name;
                    $t_record->tkt_number= $record['tkt_number'];
                    $t_record->commision= $record['commision'];
                    $t_record->amount= $record['wgt']*$record['rate'];
                    $t_record->save();

                    if($t_record->toll_fee>0){
                        if($t_record->toll_fee == 300 || $t_record->toll_fee == 550 || $t_record->toll_fee == 650){
                            $toll = new TollAmountRecord;
                            $toll->truck_record_id = $t_record->id;
                            $toll->toll_id = 1;
                            $toll->amount = $t_record->toll_fee;
                            $toll->save();
                        }elseif($t_record->toll_fee==420){
                            $toll = new TollAmountRecord;
                            $toll->truck_record_id = $t_record->id;
                            $toll->toll_id = 2;
                            $toll->amount = $t_record->toll_fee;
                            $toll->save();
                        }elseif($t_record->toll_fee==720 || $t_record->toll_fee==970 || $t_record->toll_fee==1070){
                            $toll = new TollAmountRecord;
                            $toll->truck_record_id = $t_record->id;
                            $toll->toll_id = 2;
                            $toll->amount = 420;
                            $toll->save();
                            $toll = new TollAmountRecord;
                            $toll->truck_record_id = $t_record->id;
                            $toll->toll_id = 1;
                            $toll->amount = $t_record->toll_fee-420;
                            $toll->save();
                        }else{
                            $toll = new TollAmountRecord;
                            $toll->truck_record_id = $t_record->id;
                            $toll->toll_id = 3;
                            $toll->amount = $t_record->toll_fee;
                            $toll->save();
                        }
                    }
                    // driver commission
                    if($t_record->commision>0 && $t_record->driver_name){
                        $commision = new DriverCommission;
                        $commision->driver_id = $t_record->driver_name;
                        $commision->truck_id = $t_record->truck_id;
                        $commision->truck_record_id = $t_record->id;
                        $commision->date = $t_record->date;
                        $commision->amount = $t_record->commision;
                        $commision->save();
                    }
                }
            }
        }

        $notification= array(
            'message'       => 'Truck records added!',
            'alert-type'    => 'success'
        );

        return back()->with($notification);
    }

    public function get_a_truck(Request $request){
        $truck= Truck::find($request->truck_id);
        return $truck->party;
    }

    public function update_record(Request $request){
         //return $request;

        // return $record['truck'];

        $t_record= TruckRecords::find($request->record_id);

        if($request->date){
            $old_date = explode('/', $request->date);
            $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
            $new_date = date('Y-m-d', strtotime($new_data));
            $new_date = \DateTime::createFromFormat("Y-m-d", $new_date);
        }

        $truck_details= Truck::find($request->truck_id);
        $t_record->customer_id  = $request->party_id;
        $t_record->date         = $new_date;
        $t_record->truck_id     = $request->truck_id;
        $t_record->material     = $request->material;
        $t_record->crusher      = $request->crusher;
        $t_record->destination  = $request->dstm;
        $t_record->driver_name  = $truck_details->driver_id;
        $t_record->weight       = $request->wgt;
        $t_record->destination  = $request->dstm;
        $t_record->toll_fee     = $request->toll_fee;
        $t_record->commision    = $request->commision;
        $t_record->tkt_number   = $request->tkt_number;
        $t_record->rate         = $request->rate;
        $t_record->truck_owner  = $truck_details->party->id;
        // dd($t_record);
        $t_record->save();
        if($t_record->commision>0 && $t_record->driver_name){
            $commision = DriverCommission::find($t_record->id);
            $commision->driver_id = $t_record->driver_name;
            $commision->truck_id = $t_record->truck_id;
            $commision->truck_record_id = $t_record->id;
            $commision->date = $t_record->date;
            $commision->amount = $t_record->commision;
            $commision->save();
        }

        $notification= array(
            'message'       => 'Truck records added!',
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
        //
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
        //
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
    // mominul
    public function excel_import(Request $request){
        $request->session()->put('token', $request->token);
        Excel::import(new TruckServiceImport, $request->excel_file);
        return redirect()->route('check-excel-import');
        // $records = TempTruckRecord::where('user_id', Auth::user()->id)->where('token', $request->token)->get();
        // $notification= array(
        //     'message'       => 'Excel upload successful!',
        //     'alert-type'    => 'success'
        // );
        // return view('backend.truck.check-excel-import', compact('records'));
        // return back()->with($notification);
    }
    public function vehicle_service_report(Request $request){
        $customers= PartyInfo::where('pi_type','Customer')->get();
        $sercices = [];
        if($request->customer_id){
            $sercices = TruckRecords::where('customer_id', $request->customer_id)->orderBy('id','desc')->get();
        }
        if($request->date){
            $old_date = explode('/', $request->date);
            $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
            $new_date = date('Y-m-d', strtotime($new_data));
            $new_date = \DateTime::createFromFormat("Y-m-d", $new_date);
            $sercices = TruckRecords::where('date', $new_date)->orderBy('id','desc')->get();
        }
        if($request->from && $request->to){
            $old_date = explode('/', $request->from);
            $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
            $new_date = date('Y-m-d', strtotime($new_data));
            $new_date = \DateTime::createFromFormat("Y-m-d", $new_date);
            $old_date2 = explode('/', $request->to);
            $new_data2 = $old_date2[0].'-'.$old_date2[1].'-'.$old_date2[2];
            $new_date2 = date('Y-m-d', strtotime($new_data2));
            $new_date2 = \DateTime::createFromFormat("Y-m-d", $new_date2);
            $sercices = TruckRecords::whereBetween('date', [$new_date, $new_date2])->orderBy('id','desc')->get();
        }
        return view('backend.truck.vehicle-service-report',compact('customers', 'sercices'));
    }
    public function truck_service_delete(Request $request){
        $records = $request->records;
        if($records == null){
            $notification= array(
                'message'       => 'At lest one service select!',
                'alert-type'    => 'warning'
            );
            return back()->with($notification);
        }
        TruckRecords::whereIn('id', $records)->delete();
        $notification= array(
            'message'       => 'Service Delete Success!',
            'alert-type'    => 'success'
        );
        return back()->with($notification);
    }
    public function check_excel_import(Request $request){
        $latest = PartyInfo::withTrashed()->orderBy('id','DESC')->first();
        if ($latest) {
            $pi_code = preg_replace('/^PI-/', '', $latest->pi_code);
            ++$pi_code;
        } else {
            $pi_code = 1;
        }
        if ($pi_code < 10) {
            $cc = "PI-000" . $pi_code;
        } elseif ($pi_code < 100) {
            $cc = "PI-00" . $pi_code;
        } elseif ($pi_code < 1000) {
            $cc = "PI-0" . $pi_code;
        } else {
            $cc = "PI-" . $pi_code;
        }
        $costTypes = CostCenterType::get();
        $trucks = Truck::all();
        $partys = PartyInfo::all();
        $max_sl = TruckRecords::max('serial_no');
        if($max_sl){
            $max_sl = $max_sl+1;
        }else{
            $max_sl = 10001;
        }

        $records = TempTruckRecord::where('user_id', Auth::user()->id)->where('token', $token = Session::get('token'))->get();
        $countries = Country::all();
        return view('backend.truck.check-excel-import', compact('records', 'trucks', 'partys', 'max_sl', 'cc', 'costTypes', 'countries'));
    }
    public function delete_excel_truck_entry(Request $request){
        $record = TempTruckRecord::find($request->id);
        $record->delete();
        return true;
    }
    public function filal_excel_import(Request $request){
        // dd($request);
        $temp_truck_ids = TempTruckRecord::where('user_id', Auth::user()->id)->where('token', $token = Session::get('token'))->get();
        if(count($temp_truck_ids)>0){
            foreach($temp_truck_ids as $key => $temp_truck_info){
                $check_exit_tkt_number = TruckRecords::where('tkt_number', $temp_truck_info->tkt_no)->first();
                if($check_exit_tkt_number){
                    $notification= array(
                        'message'       => $temp_truck_info->tkt_no.' already taken!',
                        'alert-type'    => 'warning'
                    );
                    return back()->with($notification);
                }
                $truck = Truck::where('vehicle_number',$temp_truck_info->truck_id)->first();
                $customer_info = PartyInfo::where('pi_name', $temp_truck_info->customer_id)->first();
                if($truck && $customer_info){
                    $max_serial_no = TruckRecords::max('serial_no');
                    $driver_info = Employee::where('full_name', $temp_truck_info->driver_name)->first();
                    if($max_serial_no){
                        $max_serial_no = $max_serial_no+1;
                    }else{
                        $max_serial_no = 10001;
                    }
                    $truck_record = new TruckRecords;
                    $truck_record->truck_id = $truck->id;
                    $truck_record->customer_id = $customer_info->id;
                    $truck_record->material = $temp_truck_info->material;
                    $truck_record->crusher = $temp_truck_info->crusher;
                    $truck_record->destination = $temp_truck_info->destination;
                    $truck_record->serial_no = $max_serial_no;
                    $truck_record->weight = $temp_truck_info->weight;
                    $truck_record->date = $temp_truck_info->date;
                    $truck_record->truck_owner = $truck->party->id;
                    $truck_record->toll_fee = $temp_truck_info->toll_fee;
                    $truck_record->driver_name = $driver_info?$driver_info->id:'';
                    $truck_record->rate = $temp_truck_info->rate;
                    $truck_record->amount = $temp_truck_info->rate*$temp_truck_info->weight;
                    $truck_record->commision = $temp_truck_info->commision;
                    // $truck_record->toll_fee_id = $toll_fee_id;
                    $truck_record->trasporter = $truck->party->pi_name;
                    $truck_record->tkt_number = $temp_truck_info->tkt_no;
                    $truck_record->save();

                    // toll fee calculate                    
                    if($truck_record->toll_fee>0){
                        if($truck_record->toll_fee == 300 || $truck_record->toll_fee == 550 || $truck_record->toll_fee == 650){
                            $toll = new TollAmountRecord;
                            $toll->truck_record_id = $truck_record->id;
                            $toll->toll_id = 1;
                            $toll->amount = $truck_record->toll_fee;
                            $toll->save();
                        }elseif($truck_record->toll_fee==420){
                            $toll = new TollAmountRecord;
                            $toll->truck_record_id = $truck_record->id;
                            $toll->toll_id = 2;
                            $toll->amount = $truck_record->toll_fee;
                            $toll->save();
                        }elseif($truck_record->toll_fee==720 || $truck_record->toll_fee==970 || $truck_record->toll_fee==1070){
                            $toll = new TollAmountRecord;
                            $toll->truck_record_id = $truck_record->id;
                            $toll->toll_id = 2;
                            $toll->amount = 420;
                            $toll->save();
                            $toll = new TollAmountRecord;
                            $toll->truck_record_id = $truck_record->id;
                            $toll->toll_id = 1;
                            $toll->amount = $truck_record->toll_fee-420;
                            $toll->save();
                        }else{
                            $toll = new TollAmountRecord;
                            $toll->truck_record_id = $truck_record->id;
                            $toll->toll_id = 3;
                            $toll->amount = $truck_record->toll_fee;
                            $toll->save();
                        }
                    }
                    // driver commission
                    if($truck_record->commision>0 && $truck_record->driver_name){
                        $commision = new DriverCommission;
                        $commision->driver_id = $truck_record->driver_name;
                        $commision->truck_id = $truck_record->truck_id;
                        $commision->truck_record_id = $truck_record->id;
                        $commision->date = $truck_record->date;
                        $commision->amount = $truck_record->commision;
                        $commision->save();
                    }
                    $temp_truck_info->delete();
                }

            }
        }
        $notification= array(
            'message'       => 'Service Save Success!',
            'alert-type'    => 'success'
        );
        return redirect()->route('vehicle-service')->with($notification);
    }
    public function add_new_truckPost(Request $request){
        $truck= new Truck();
        $truck->vehicle_number      = $request->vehicle_number;
        $truck->brand               = $request->brand;
        $truck->model               = $request->model;
        $truck->origin              = $request->origin;
        $truck->engine_capacity     = $request->engine_capacity;
        $truck->no_of_tyres         = $request->number_of_tyres;
        $truck->owner               = $request->owner;
        $truck->save();

        $temp_record = TempTruckRecord::find($request->id);
        $temp_record->truck_id = $truck->vehicle_number;
        $temp_record->save();
        return Response()->json(['truck' => $truck]);
    }
    public function check_vehicle_number(Request $request){
        $vehicle_number = Truck::where('vehicle_number', $request->vehicle_number)->first();
        return $vehicle_number;
    }
    public function check_tkt_number(Request $request){
        $tkt_no = null;
        $tkt_no = TempTruckRecord::where('tkt_no', $request->number)->first();
        if(!$tkt_no){
            $tkt_no = TruckRecords::where('tkt_number', $request->number)->first();
        }
        return $tkt_no;
    }
    public function check_tkt_number_duplicated(Request $request){
        $duplicates = DB::table('temp_truck_records')
                    ->select('tkt_no')
                    ->groupBy('tkt_no')
                    ->havingRaw('COUNT(*) > 1')
                    ->get();
            return count($duplicates);
        // return $records->duplicates('position');
    }
    public function excel_filter(Request $request){
        $records = TempTruckRecord::where('user_id', Auth::user()->id)->where('token', $token = Session::get('token'));
        if($request->date){
            $old_date = explode('/', $request->date);
            $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
            $new_date = date('Y-m-d', strtotime($new_data));
            $records = $records->where('date', $new_date);
        }
        if($request->truck_id){
            $records = $records->where('truck_id', $request->truck_id);
        }
        if($request->client_id){
            $records = $records->where('customer_id', $request->client_id);
        }
        if($request->input_value){
            $records = $records->where('tkt_no', 'like', '%'.$request->input_value.'%')
                        ->orWhere('material', 'like', '%'.$request->input_value.'%')
                        ->orWhere('crusher', 'like', '%'.$request->input_value.'%')
                        ->orWhere('destination', 'like', '%'.$request->input_value.'%');
        }
        $records = $records->get();
        $trucks = Truck::all();
        $partys = PartyInfo::all();
        $max_sl = TruckRecords::max('serial_no');
        if($max_sl){
            $max_sl = $max_sl+1;
        }else{
            $max_sl = 10001;
        }
        return view('backend.truck.excel-filter', compact('records', 'trucks', 'partys', 'max_sl'));
    }
    public function update_temp_excel_upload(Request $request){
        $temp_entry = TempTruckRecord::find($request->id);
        // dd($temp_entry);
        $field = $request->field_name;
        if($field == 'date'){
            $old_date = explode('/', $request->field_value);
            $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
            $value = date('Y-m-d', strtotime($new_data));
        }elseif($field == 'customer_id'){
            $party_info = PartyInfo::find($request->field_value);
            $value = $request->field_value;
        }else{
            $value = $request->field_value;
        }
        // if($field == 'driver_name'){
        //     $driver = Driver::where('name', $value)->first();
        //     if($driver){
        //         $driver->name = $value;
        //         $driver->save();
        //     }else{
        //         $driver = new Driver;
        //         $driver->name = $value;
        //         $driver->save();
        //     }
        //     $truck = Truck::where('vehicle_number', $temp_entry->truck_id)->first();
        //     $truck->driver_id = $driver->id;
        //     $truck->save();
        // }
        $temp_entry->$field = $value;
        $temp_entry->amount = $temp_entry->rate*$temp_entry->weight;
        $temp_entry->save();
    }
    public function vehicle_report(Request $request){
        $trucks = Truck::all();
        $services = [];
        $from = $request->from ? $request->from : date('d/m/Y');
        $to = $request->to ? $request->to : date('d/m/Y');
        $id = $request->truck_id ? $request->truck_id : 0;
        $truck_info = $trucks->where('id', $request->truck_id)->first();

        if ($request->truck_id) {
            $query = TruckRecords::where('truck_id', $request->truck_id);

            if ($request->from && $request->to) {
                $fromDate = Carbon::createFromFormat('d/m/Y', $request->from)->startOfDay();
                $toDate = Carbon::createFromFormat('d/m/Y', $request->to)->endOfDay();
                $query->whereBetween('date', [$fromDate, $toDate]);
            }

            $services = $query->orderBy('date', 'desc')->get();
        }
        return view('backend.truck.vehicle-report', compact('trucks', 'truck_info', 'services','from','to','id'));
    }
    public function truck_service_export(Request $request){
        $request_fiels = $request->truck_service_excel_field_name;
        if($request_fiels == null){
            $notification= array(
                'message'       => 'Atlest one column select!',
                'alert-type'    => 'error'
            );
            return back()->with($notification);
        }
        // dd($request_fiels);
        return Excel::download(new TruckServiceExport(['request_fiels'=>$request_fiels]), 'vehicle-service.xlsx');
    }
}
