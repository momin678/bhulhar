<?php

namespace App\Http\Controllers\backend\Payroll;

use App\DebitCreditVoucher;
use App\DriverCommission;
use App\Http\Controllers\Controller;
use App\Journal;
use App\JournalRecord;
use App\Mapping;
use App\Models\AccountHead;
use App\Models\Payroll\EmployeeSalary;
use App\Models\Payroll\Employee;
use App\Models\Payroll\SalaryStructure;
use App\Models\Payroll\ComponentType;
use App\Models\Payroll\DeductionEntry;
use App\Models\Payroll\DeductionProcess;
use App\Models\Payroll\ExtraSalaryComponentHistory;
use App\Models\Payroll\GradeWiseSalaryComponentHistory;
use App\Models\Payroll\PaySalary;
use App\Models\Payroll\SalaryApprovalDocument;
use App\Models\Payroll\SalaryComponent;
use App\Models\Payroll\SalaryProcess;
use App\Models\Payroll\SalaryType;
use App\PartyInfo;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SalaryprocessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $employees = SalaryProcess::where('status', 1)->distinct()->select('employee_id')->orderBy('created_at', 'desc')->get();
        $employees = SalaryProcess::whereIn('id', function($query) {
                        $query->selectRaw('MAX(id)')
                            ->from('salary_processes')
                            ->where('status', 1)
                            ->groupBy('employee_id','month');
                    })->get();
                    // dd($employees);
        $wages_type = SalaryType::all();
        $salaryStructure = SalaryStructure::all()->toArray();
        return view('backend.payroll.salary_process.index', compact('employees', 'salaryStructure','wages_type'));
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
        $date = Carbon::now();
        $monthName = $request->month;
        $year = $request->year;

        $check=SalaryProcess::where('month', $monthName)->where('year', $year)->where('status', 0)->get();
        if(count($check) == 0)
        {
            $employees = EmployeeSalary::orderBy('id', 'desc')->get();

            foreach ($employees as $item){
                    SalaryProcess::create([
                        'employee_id' => $request->employee_id,
                        'basic' => $request->basic,
                        'house_rent' => $request->house_rent,
                        'transportation' => $request->transportation,
                        'bonus' => $request->bonus,
                        'telephone_bill' => $request->telephone_bill,
                        'ta' => $request->ta,
                        'da' => $request->da,
                        'medical_expenses' => $request->medical_expenses,
                        'vacation_bonus' => $request->vacation_bonus,
                        'tax_reduction' => $request->tax_reduction,
                        'providant_fund' => $request->providant_fund,
                        'gratuity' => $request->gratuity,
                        'others' => $request->others,
                        'total' => $request->total
                    ]);
            }

            $notification= array(
                'message'       => 'Salary Sheet Create successfully!',
                'alert-type'    => 'success'
            );

        }else{
            $notification= array(
                'message'       => 'This months salary sheet already created!',
                'alert-type'    => 'success'
            );
        };


        return redirect('pay-salary')->with($notification);
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

        $components = SalaryComponent::orderBy('id', 'desc')->get();
        $deductions = DeductionEntry::where('employee_id', $id)->where('due','!=', 0)->orderBy('id', 'desc')->get();
        $component_types = ComponentType::orderBy('id', 'desc')->get();
        $employee = Employee::find($id);
        $salaryStructure = SalaryStructure::all()->toArray();
        return Response()->json([
            'page' => view('backend.payroll.salary_process.edit-modal', ['components' => $components,
                                                                     'component_types' => $component_types,
                                                                     'employee' => $employee,
                                                                     'deductions' => $deductions])->render(),

        ]);
        // return view('backend.payroll.salary_process.edit', compact('components', 'component_types', 'employee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $process =  SalaryProcess::where('employee_id',$id)->where('status',1)->first();
        // dd($process);
        $grade_id = $process->grade_id;
        $month = $process->month;
        $year = $process->year;
        if (isset($request->records['head'])) {
            SalaryProcess::where('employee_id',$id)->where('status',1)->delete();
            foreach ($request->records['head'] as $key => $value) {
                SalaryProcess::create([
                    'employee_id' => $id,
                    'grade_id' => $grade_id,
                    'salary_component_id' => $request->records['head'][$key],
                    'month' => $month,
                    'year' => $year,
                    'amount' => $request->records['amount'][$key],
                ]);
            }
            $notification= array(
                'message'       => 'Update successfully!',
                'alert-type'    => 'success'
            );
        }else{
            $notification= array(
                'message'       => 'Please Select Atleast One Item!',
                'alert-type'    => 'warning'
            );
        }
        if (isset($request->deduct['head'])) {
                            DeductionProcess::where('employee_id',$id)->where('status',1)->delete();

            foreach ($request->deduct['head'] as $key => $value) {

                DeductionProcess::create([
                        'employee_id' => $id,
                        'deduction_component_id' => $request->deduct['head'][$key],
                        'month' => $month,
                        'year' => $year,
                        'amount' => $request->deduct['amount'][$key],
                    ]);
            }
        }



        return redirect('salary-process')->with($notification);
    }

    public function crearteSalary(Request $request)
    {
        $date = Carbon::now();
        $monthName = $request->month;
        $year = $request->year;

        $check=SalaryProcess::where('month', $monthName)->where('year', $year)->get();
        $monthNumber = date_parse($request->month);
        $month = $monthNumber['month'];
        if(count($check) == 0) {
            $doubleCheck = SalaryProcess::where('status', 1)->get();
            // if(count($doubleCheck) == 0){
                $employees = Employee::get();
                foreach ($employees as $item){
                    $date = GradeWiseSalaryComponentHistory::where('grade_id',$item->grade)->whereMonth('date','<=',$month)->whereYear('date',$year)->orderBy('id','DESC')->first();
                    if(!$date){
                        $date = GradeWiseSalaryComponentHistory::where('grade_id',$item->grade)->whereYear('date','<',$year)->orderBy('id','DESC')->first();
                    }
                   if($date) {
                        $gradeWises = GradeWiseSalaryComponentHistory::where('grade_id',$item->grade)->where('date',$date->date)->get();
                        foreach($gradeWises as $salary){
                            SalaryProcess::create([
                                'employee_id' => $item->id,
                                'grade_id' => $item->grade,
                                'salary_component_id' => $salary->salary_component_id,
                                'amount' => $salary->value,
                                'month' =>$monthName,
                                'year' => $year,
                            ]);
                        }
                        $date = ExtraSalaryComponentHistory::where('employee_id',$item->id)->whereMonth('date','<=',$month)->whereYear('date',$year)->orderBy('id','DESC')->first();
                        if(!$date){
                            $date = ExtraSalaryComponentHistory::where('employee_id',$item->id)->whereYear('date','<',$year)->orderBy('id','DESC')->first();
                        }
                    
                        if ($date != null) {
                            $extra = ExtraSalaryComponentHistory::where('employee_id',$item->id)->where('date',$date->date)->get();
                            foreach($extra as $salary){
                                SalaryProcess::create([
                                    'employee_id' => $item->id,
                                    'grade_id' => $item->grade,
                                    'salary_component_id' => $salary->salary_component_id,
                                    'amount' => $salary->value,
                                    'month' =>$monthName,
                                    'year' => $year,
                                ]);
                            }
                        }
                        // commission component add for truck driver
                        $commission_amount_list = DriverCommission::where('driver_id',$item->id)->where('is_paid',0)->whereMonth('date', $month)->get();
                        // dd($commission_amount_list);
                        if($commission_amount_list->sum('amount')>0){
                            SalaryProcess::create([
                                'employee_id' => $item->id,
                                'grade_id' => $item->grade,
                                'salary_component_id' => 2,
                                'amount' => $commission_amount_list->sum('amount'),
                                'month' =>$monthName,
                                'year' => $year,
                            ]);
                            DriverCommission::where('driver_id',$item->id)->where('is_paid',0)->whereMonth('date', $month)->update(['is_paid' => 1]);
                        }
                   }

                }

                $notification= array(
                    'message'       => 'Create succesfully',
                    'alert-type'    => 'success'
                );
            // }else{
            //     $month = SalaryProcess::where('status', 1)->first();
            //     $notification= array(
            //         'message'       => $month->month.' month salary processing!',
            //         'alert-type'    => 'warning'
            //     );
            // }

        }else{
            $notification= array(
                'message'       => 'This months salary sheet already created!',
                'alert-type'    => 'error'
            );
        };


        return redirect('salary-process')->with($notification);

    }

    public function confirm(Request $request) {

        $check=SalaryProcess::where('status', 1)->get();
        if(count($check) != 0 && $request->records) {
            // dd($request->records);
            $employees = SalaryProcess::where('status', 1)->whereIn('id', $request->records)->select('employee_id', 'month', 'year')->distinct()->get();
            // dd($employees);
            foreach ($employees as $item){
                // dd($item->employee_id);
                $total = SalaryProcess::where('employee_id', $item->employee_id)->where('status', 1)->where('month', $item->month)->where('year', $item->year)->sum('amount');
                $deduct = DeductionProcess::where('employee_id', $item->employee_id)->where('status', 1)->sum('amount');
                $info =  SalaryProcess::where('employee_id', $item->employee_id)->where('status', 1)->where('month', $item->month)->where('year', $item->year)->first();
                SalaryProcess::where('employee_id', $item->employee_id)->where('status', 1)->where('month', $item->month)->where('year', $item->year)->update([
                        'status' => 0,
                    ]);
                $deduction = DeductionProcess::where('employee_id', $item->employee_id)->where('status', 1)->get();
                foreach ($deduction as $value) {
                    $data = DeductionEntry::find($value->deduction_component_id);
                    $data->due = $data->due - $value->amount;
                    $data->save();
                }
                DeductionProcess::where('employee_id', $item->employee_id)->where('status', 1)->update([
                    'status' => 0,
                ]);
                PaySalary::create([
                    'employee_id' => $item->employee_id,
                    'grade_id' => $info->grade_id,
                    'month' =>$info->month,
                    'year' => $info->year,
                    'payable' => $total-$deduct,
                    'paid' => 0,
                    'due' => $total - $deduct,
                ]);
                $sub_invoice = Carbon::now()->format('Ymd');
                $latest_journal_no = Journal::withTrashed()->whereDate('created_at', Carbon::today())->where('journal_no', 'LIKE', "%{$sub_invoice}%")->orderBy('id','DESC')->first();
                if ($latest_journal_no){
                    $journal_no = substr($latest_journal_no->journal_no,0,-1);
                    $journal_code = $journal_no + 1;
                    $journal_no = $journal_code . "J";
                }else {
                    $journal_no = Carbon::now()->format('Ymd') . '001' . "J";
                }
                $journal_main= AccountHead::find(5);
                $party=PartyInfo::where('emp_id',$item->employee_id)->first();
                if(!$party){
                    $party = PartyInfo::find(56);
                }
                // journal entry
                if($party){
                    $journal= new Journal();
                    $journal->transection_type = "Expense";
                    $journal->transaction_type = "Expense";
                    $journal->without_gst       = 0;
                    $journal->gst_subtotal      = 0;
                    $journal->project_id        = 1;
                    $journal->journal_no        = $journal_no;
                    $journal->date              = Carbon::now()->toDateString();
                    $journal->invoice_no        = 'N/A';
                    $journal->source            = 'Application Fee';
                    $journal->pay_mode            = "Cash";
                    $journal->cost_center_id    = 0;
                    $journal->profit_center_id    = 1;
                    $journal->party_info_id     = $party->id;
                    $journal->account_head_id   = $journal_main->id;
                    $journal->amount            = $total;
                    $journal->tax_rate          = 0;
                    $journal->vat_amount        = 0;
                    $journal->voucher_type      = "DR";
                    $journal->total_amount      = $total;
                    $journal->narration         = "Salary Process";
                    $journal->authorized      = 1;
                    $journal->approved      = 1;

                    $journal->approved_by         = Auth::id();
                    $journal->created_by         = Auth::id();
                    $journal->authorized_by         = Auth::id();
                    $journal->save();

                    $journal_main= AccountHead::find(5); // Payable Account
                    $jl_record= new JournalRecord();
                    $jl_record->journal_id     = $journal->id;
                    $jl_record->project_details_id  = 0;
                    $jl_record->cost_center_id    = 0;
                    $jl_record->profit_center_id    = 1;
                    $jl_record->party_info_id       = $party->id;
                    $jl_record->journal_no          = $journal_no;
                    $jl_record->account_head_id     = $journal_main->id;
                    $jl_record->master_account_id   = $journal_main->master_account_id;
                    $jl_record->account_head        = $journal_main->fld_ac_head;
                    $jl_record->amount              =  $total;
                    $jl_record->total_amount              = $total;
                    $jl_record->is_main_head              = 1;
                    $jl_record->transaction_type    = 'CR';
                    $jl_record->account_type_id        = 0;
                    $jl_record->journal_date        = Carbon::now()->toDateString();
                    $jl_record->gst_amount          =  0;
                    $jl_record->gst_subtotal          =  0;
                    $jl_record->vat_rate_id          =  0;
                    $jl_record->invoice_no          = 'n/a';
                    $jl_record->save();


                    $journal_main= AccountHead::find(24); // Salary Account
                    $jl_record= new JournalRecord();
                    $jl_record->journal_id     = $journal->id;
                    $jl_record->project_details_id  = 0;
                    $jl_record->cost_center_id    = 0;
                    $jl_record->profit_center_id    = 1;
                    $jl_record->party_info_id       = $party->id;
                    $jl_record->journal_no          = $journal_no;
                    $jl_record->account_head_id     = $journal_main->id;
                    $jl_record->master_account_id   = $journal_main->master_account_id;
                    $jl_record->account_head        = $journal_main->fld_ac_head;
                    $jl_record->amount              =  $total;
                    $jl_record->total_amount        = $total;
                    $jl_record->is_main_head        = 1;
                    $jl_record->transaction_type    = 'DR';
                    $jl_record->account_type_id     = 0;
                    $jl_record->journal_date        = Carbon::now()->toDateString();

                    $jl_record->gst_amount          =  0;
                    $jl_record->gst_subtotal        =  0;
                    $jl_record->vat_rate_id         =  0;
                    $jl_record->invoice_no          =  'n/a';
                    $jl_record->save();

                    // deduction journal entry
                    if($deduct>0){
                        $sub_invoice = Carbon::now()->format('Ymd');
                        $latest_journal_no = Journal::withTrashed()->whereDate('created_at', Carbon::today())->where('journal_no', 'LIKE', "%{$sub_invoice}%")->orderBy('id','DESC')->first();
                        if ($latest_journal_no) {
                            $journal_no = substr($latest_journal_no->journal_no,0,-1);
                            $journal_code = $journal_no + 1;
                            $journal_no = $journal_code . "J";
                        } else {
                            $journal_no = Carbon::now()->format('Ymd') . '001' . "J";
                        }

                        $journal_main= AccountHead::find(3); // Receivable Account

                        $party=PartyInfo::where('emp_id',$item->employee_id)->first();

                        $journal= new Journal();
                        $journal->transection_type = "Expense";
                        $journal->transaction_type = "Expense";
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
                        $journal->amount            = $deduct;
                        $journal->tax_rate          = 0;
                        $journal->vat_amount        = 0;
                        $journal->voucher_type      = "CR";
                        $journal->total_amount      = $deduct;
                        $journal->narration         = "Salary  deduction";
                        $journal->authorized        = 1;
                        $journal->approved          = 1;

                        $journal->approved_by         = Auth::id();
                        $journal->created_by         = Auth::id();
                        $journal->authorized_by         = Auth::id();
                        $journal->save();

                        $jl_record= new JournalRecord();
                        $jl_record->journal_id     = $journal->id;
                        $jl_record->project_details_id  = 0;
                        $jl_record->cost_center_id    = 0;
                        $jl_record->profit_center_id    = 1;
                        $jl_record->party_info_id       = $party->id;
                        $jl_record->journal_no          = $journal_no;
                        $jl_record->account_head_id     = $journal_main->id;
                        $jl_record->master_account_id   = $journal_main->master_account_id;
                        $jl_record->account_head        = $journal_main->fld_ac_head;
                        $jl_record->amount              =  $deduct;
                        $jl_record->total_amount              = $deduct;
                        $jl_record->is_main_head              = 1;
                        $jl_record->transaction_type    = 'CR';
                        $jl_record->account_type_id        = 0;
                        $jl_record->journal_date        = Carbon::now()->toDateString();
                        $jl_record->gst_amount          =  0;
                        $jl_record->gst_subtotal          =  0;
                        $jl_record->vat_rate_id          =  0;
                        $jl_record->invoice_no          =  'n/a';
                        $jl_record->save();

                        $journal_main= AccountHead::find(5); // Payable Account
                        $jl_record= new JournalRecord();
                        $jl_record->journal_id     = $journal->id;
                        $jl_record->project_details_id  = 0;
                        $jl_record->cost_center_id      = 0;
                        $jl_record->profit_center_id    = 1;
                        $jl_record->party_info_id       = $party->id;
                        $jl_record->journal_no          = $journal_no;
                        $jl_record->account_head_id     = $journal_main->id;
                        $jl_record->master_account_id   = $journal_main->master_account_id;
                        $jl_record->account_head        = $journal_main->fld_ac_head;
                        $jl_record->amount              =  $deduct;
                        $jl_record->total_amount        = $deduct;
                        $jl_record->is_main_head        = 1;
                        $jl_record->transaction_type    = 'DR';
                        $jl_record->account_type_id     = 0;
                        $jl_record->journal_date        = Carbon::now()->toDateString();
                        $jl_record->gst_amount          =  0;
                        $jl_record->gst_subtotal        =  0;
                        $jl_record->vat_rate_id         =  0;
                        $jl_record->invoice_no          =  'n/a';
                        $jl_record->save();

                        $dr_cr_voucher= new DebitCreditVoucher();
                        $dr_cr_voucher->journal_id      = $journal->id;
                        $dr_cr_voucher->project_id      = $journal->project_id;
                        $dr_cr_voucher->cost_center_id  = 0;
                        // $dr_cr_voucher->profit_center_id    = 1;
                        $dr_cr_voucher->party_info_id   = $journal->party_info_id;
                        $dr_cr_voucher->account_head_id = 19;
                        $dr_cr_voucher->pay_mode        = "Payable";
                        $dr_cr_voucher->amount          =  $journal->total_amount;
                        $dr_cr_voucher->narration       =  $journal->narration;
                        $dr_cr_voucher->type            = "DR";
                        $dr_cr_voucher->date            =   $journal->date;
                        $dr_cr_voucher->save();
                    }
                }

            }

            $notification= array(
                'message'       => 'Salary Sheet Create successfully!',
                'alert-type'    => 'success'
            );

        }else{
            $notification= array(
                'message'       => 'There have nothing to confirm!',
                'alert-type'    => 'warning'
            );
        };


        return back()->with($notification);
    }
}
