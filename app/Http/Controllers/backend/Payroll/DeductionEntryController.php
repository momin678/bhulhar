<?php

namespace App\Http\Controllers\backend\Payroll;

use App\DebitCreditVoucher;
use App\Http\Controllers\Controller;
use App\Journal;
use App\JournalRecord;
use App\Models\AccountHead;
use App\Models\Payroll\DeductionEntry;
use App\Models\Payroll\DeductionProcess;
use App\Models\Payroll\Division;
use App\Models\Payroll\Employee;
use App\PartyInfo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeductionEntryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        //Gate::authorize('app.mapping.index');
        $items = DeductionEntry::orderBy('id', 'desc')->get();
        $employees = Employee::orderBy('id', 'desc')->get();
        $divisions = Division::orderBy('id', 'desc')->get();
        // $accoutHeads = AccountHead::all();
        // dd($facitities);
        return view('backend.payroll.deduction_entry.index', compact('items','employees','divisions'));
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
    public function store(Request $request) {


        if ($request->file('file')) {

            $name= $request->file('file')->getClientOriginalName();
            $name = pathinfo($name, PATHINFO_FILENAME);
            $ext= $request->file('file')->getClientOriginalExtension();
            $file_name= $request->description.time().'.'.$ext;
            
            $request->file('file')->storeAs( 'public/upload/deduction-document', $file_name);
        }else{
            $file_name = '';
        }

        $old_date = explode('/', $request->date);

        $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
        $new_date = date('Y-m-d', strtotime($new_data));
        $new_date = \DateTime::createFromFormat("Y-m-d", $new_date);

        // dd($request->all());
        $request->validate([
            // 'name' => 'required',
        ]);
        DeductionEntry::create([
            'employee_id' => $request->employee_id,
            'description' => $request->description,
            'amount' => $request->amount,
            'due' => $request->amount,
            'date' => $new_date,
            'document' => $file_name,
        ]);
        
        
        // *****************************************


        $sub_invoice = Carbon::now()->format('Ymd');
        $latest_journal_no = Journal::withTrashed()->whereDate('created_at', Carbon::today())->where('journal_no', 'LIKE', "%{$sub_invoice}%")->orderBy('id','DESC')->first();
        if ($latest_journal_no) {
            $journal_no = substr($latest_journal_no->journal_no,0,-1);
            $journal_code = $journal_no + 1;
            $journal_no = $journal_code . "J";
        } else {
            $journal_no = Carbon::now()->format('Ymd') . '001' . "J";
        }
    
        $journal_main= AccountHead::find(1); // Cash Account
        
        $party=PartyInfo::where('emp_id',$request->employee_id)->first();

        $journal= new Journal();
        $journal->transection_type  = "Deduction";
        $journal->transaction_type  = "Deduction";
        $journal->without_gst       = 0;
        $journal->gst_subtotal      = 0;
        $journal->project_id        = 1;
        $journal->journal_no        = $journal_no;
        $journal->date              = Carbon::now()->toDateString();
        $journal->invoice_no        = 'N/A';
        $journal->source            = 'Application Fee';
        $journal->pay_mode          = "Cash";
        $journal->cost_center_id    = 0;
        $journal->profit_center_id  = 1;
        $journal->party_info_id     = $party->id;
        $journal->account_head_id   = $journal_main->id;
        $journal->amount            = $request->amount;
        $journal->tax_rate          = 0;
        $journal->vat_amount        = 0;
        $journal->voucher_type      = "DR";
        $journal->total_amount      = $request->amount;
        $journal->narration         = "Deduction for-". $request->description;
        $journal->authorized        = 1;
        $journal->approved          = 1;

        $journal->approved_by       = Auth::id();
        $journal->created_by        = Auth::id();
        $journal->authorized_by     = Auth::id();
        $journal->save();

        $jl_record= new JournalRecord();
        $jl_record->journal_id          = $journal->id;
        $jl_record->project_details_id  = 0;
        $jl_record->cost_center_id      = 0;
        $jl_record->profit_center_id    = 1;
        $jl_record->party_info_id       = $party->id;
        $jl_record->journal_no          = $journal_no;
        $jl_record->account_head_id     = $journal_main->id;
        $jl_record->master_account_id   = $journal_main->master_account_id;
        $jl_record->account_head        = $journal_main->fld_ac_head;
        $jl_record->amount              = $request->amount;
        $jl_record->total_amount        = $request->amount;
        $jl_record->is_main_head        = 1;
        $jl_record->transaction_type    = 'CR';
        $jl_record->account_type_id     = 0;
        $jl_record->journal_date        = Carbon::now()->toDateString();
        $jl_record->gst_amount          = 0;
        $jl_record->gst_subtotal        = 0;
        $jl_record->vat_rate_id         = 0;
        $jl_record->invoice_no          = 'n/a';
        $jl_record->save();


        $journal_main= AccountHead::find(3); // Receivable Account

        $jl_record= new JournalRecord();
        $jl_record->journal_id          = $journal->id;
        $jl_record->project_details_id  = 0;
        $jl_record->cost_center_id      = 0;
        $jl_record->profit_center_id    = 1;
        $jl_record->party_info_id       = $party->id;
        $jl_record->journal_no          = $journal_no;
        $jl_record->account_head_id     = $journal_main->id;
        $jl_record->master_account_id   = $journal_main->master_account_id;
        $jl_record->account_head        = $journal_main->fld_ac_head;
        $jl_record->amount              = $request->amount;
        $jl_record->total_amount        =$request->amount;
        $jl_record->is_main_head        = 1;
        $jl_record->transaction_type    = 'DR';
        $jl_record->account_type_id     = 0;
        $jl_record->journal_date        = Carbon::now()->toDateString();
        $jl_record->gst_amount          = 0;
        $jl_record->gst_subtotal        = 0;
        $jl_record->vat_rate_id         = 0;
        $jl_record->invoice_no          = 'n/a';
        $jl_record->save();



        $dr_cr_voucher= new DebitCreditVoucher();
        $dr_cr_voucher->journal_id      = $journal->id;
        $dr_cr_voucher->project_id      = $journal->project_id;
        $dr_cr_voucher->cost_center_id  = 0;
        // $dr_cr_voucher->profit_center_id = 1;
        $dr_cr_voucher->party_info_id   = $journal->party_info_id;
        $dr_cr_voucher->account_head_id = 67;
        $dr_cr_voucher->pay_mode        = "Cash";
        $dr_cr_voucher->amount          =  $journal->total_amount;
        $dr_cr_voucher->narration       =  $journal->narration;
        $dr_cr_voucher->type            = "DR";
        $dr_cr_voucher->date            =   $journal->date;
        $dr_cr_voucher->save();

        //////////////////////////////////////////
        $notification= array(
            'message'       => 'Added successfully!',
            'alert-type'    => 'success'
        );
        return redirect('hr/payroll/deduction-entry')->with($notification);
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
        
        $info = DeductionEntry::find($id);
        $employees = Employee::get();
        $divisions = Division::orderBy('id', 'desc')->get();
        $url="route('deduction-entry/update',".$info->id.")";
        // action="http://zsm-system.test/deduction-entry"
        // dd($employees);
        return Response()->json([
            'info' => $info,
            'employees' => $employees,
            'divisions' => $divisions,
            'url'=>$url

        ]);
        // return view('backend.payroll.department.edit', compact('info', 'items'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $request->validate([
            // 'name' => 'required',
        ]);

       $check = DeductionProcess::where('deduction_component_id', $id)->first();
       
       if(!$check){
        
            $old_date = explode('/', $request->date);

            $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
            $new_date = date('Y-m-d', strtotime($new_data));
            $new_date = \DateTime::createFromFormat("Y-m-d", $new_date);
            $main_ded= DeductionEntry::find($id);
            $file_name = $main_ded->document;
            if ($request->file('file')) {
                if($main_ded->document!='')
                {
                    $path = public_path('storage/upload/deduction-document/').$main_ded->document;
                    if (file_exists($path)) {
                        unlink($path);
                    }
                }

                $name= $request->file('file')->getClientOriginalName();
                $name = pathinfo($name, PATHINFO_FILENAME);
                $ext= $request->file('file')->getClientOriginalExtension();
                $file_name= $request->description.time().'.'.$ext;
                $request->file('file')->storeAs( 'public/upload/deduction-document', $file_name);



                
            } 

            DeductionEntry::find($id)->update([
                'employee_id' => $request->employee_id,
                'description' => $request->description,
                'amount' => $request->amount,
                'due' => $request->amount,
                'date' => $new_date,
                'document' => $file_name,
            ]);
            $notification= array(
                'message'       => 'Update successfully!',
                'alert-type'    => 'success'
            );
       }else{
        $notification= array(
            'message'       => 'This Item already used So Edit not possible!',
            'alert-type'    => 'warning'
        );
       }

    //    dd('what is that');

        return redirect('deduction-entry')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     $salaryTypes = SalaryType::find($id);
    //     $salaryTypes->delete();
    //     $notification = array(
    //         'message'       => 'Salary type Deleted successfully!',
    //         'alert-type'    => 'success'
    //     );
    //     return redirect('salary-types')->with($notification);
    // }
}
