<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobProjectStoreRequest;
use App\Http\Requests\PartyInfoStoreRequest;
use App\Invoice;
use App\JobDocumentUpload;
use App\JobProject;
use App\JobProjectInvoice;
use App\JobProjectInvoiceTask;
use App\JobProjectTask;
use App\Journal;
use App\JournalRecord;
use App\LpoPorjectTask;
use App\Models\AccountHead;
use App\PartyInfo;
use App\LpoProject;
use App\Models\InvoiceNumber;
use App\Receipt;
use App\VatRate;
use App\PayMode;
use App\ReceiptSale;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class JobProjectController extends Controller
{

    private function payment_no()
    {
        $sub_invoice = 'RV'.Carbon::now()->format('y');
        $let_purch_exp = InvoiceNumber::where('receipt_invoice_number', 'LIKE', "%{$sub_invoice}%")->first();
        if ($let_purch_exp) {
            $receipt_no =preg_replace('/^'.$sub_invoice.'/', '', $let_purch_exp->receipt_invoice_number);
            $receipt_no++;
            if($receipt_no<10)
            {
                $receipt_no=$sub_invoice.'000'.$receipt_no;
            }
            elseif($receipt_no<100)
            {
                $receipt_no=$sub_invoice.'00'.$receipt_no;
            }
            elseif($receipt_no<1000)
            {
                $receipt_no=$sub_invoice.'0'.$receipt_no;
            }
            else
            {
                $receipt_no=$sub_invoice.$receipt_no;

            }
        } else {
            $receipt_no = $sub_invoice . '0001';
        }
        return $receipt_no;
    }

    private function invoice_no()
    {
        $sub_invoice = 'INV'.Carbon::now()->format('y');
        $invoice = InvoiceNumber::where('invoice_no', 'LIKE', "%{$sub_invoice}%")->first();
        if ($invoice) {
            $number = preg_replace('/^'.$sub_invoice.'/', '', $invoice->invoice_no);
            $number++;
            if($number<10)
            {
                $invoice_no=$sub_invoice.'000'.$number;
            }
            elseif($number<100)
            {
                $invoice_no=$sub_invoice.'00'.$number;
            }
            elseif($number<1000)
            {
                $invoice_no=$sub_invoice.'0'.$number;
            }
            else
            {
                $invoice_no=$sub_invoice.$number;

            }
        } else {
            $invoice_no  = $sub_invoice . '0001';
        }
        return $invoice_no;
    }
    private function journal_no()
    {
        $sub_invoice = Carbon::now()->format('Ymd');
        // return $sub_invoice;
        $latest_journal_no = Journal::withTrashed()->whereDate('created_at', Carbon::today())->where('journal_no', 'LIKE', "%{$sub_invoice}%")->latest('id')->first();
        // return $latest_journal_no;
        if ($latest_journal_no) {
            $journal_no = substr($latest_journal_no->journal_no, 0, -1);
            $journal_code = $journal_no + 1;
            $journal_no = $journal_code . "J";
        } else {
            $journal_no = Carbon::now()->format('Ymd') . '001' . "J";
        }

        return $journal_no;
    }
    public function index(Request $request)
    {
        if ($request->has('search')) {
            $query = $request->search;
            $projects = JobProject::where('project_name', 'like', '%' . $query . '%')
                ->orWhere('project_code', 'like', '%' . $query . '%')
                ->latest()->paginate(20);
            $active_btn = 'all';
        } elseif ($request->invoice_item == 'invoice') {
            $projects = JobProject::where('is_invoice', '>', 0)->latest()->paginate(20);
            $active_btn = 'invoice-item';
        } else {
            $projects = JobProject::where('is_invoice', 0)->latest()->paginate(20);
            $active_btn = 'uninvoice-item';
        }

        return view('backend.job-project.index', compact('projects', 'active_btn'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function workStationCreate(LpoProject $lpo_project)
    {
        $paymodes = PayMode::whereIn('id', [1, 3, 4])->get();
        $customers = PartyInfo::where('pi_type', 'Customer')->get();
        $vats = VatRate::orderBy('value', 'desc')->get();
        return view('backend.job-project.create', compact('lpo_project', 'customers', 'vats', 'paymodes'));
    }

    public function ajaxCreate()
    {
        $lpo_projects = LpoProject::latest()->get();
        $customers = PartyInfo::all();
        $vats = VatRate::orderBy('value')->get();
        return view('backend.job-project.ajax-create', compact('customers', 'vats', 'lpo_projects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JobProjectStoreRequest $request)
    {
        // dd($request->all());

        //    ****************************** unique number generator **********************
        $sub_invoice = 'WO'.Carbon::now()->format('y');
        $tem_project_code = JobProject::where('project_code', 'LIKE', "%{$sub_invoice}%")->orderBy('id','DESC')->first();
        if ($tem_project_code) {
            $cc =  preg_replace('/^'.$sub_invoice.'/', '', $tem_project_code->project_code) + 1;
            if($cc<10)
            {
                $cc=$sub_invoice.'000'.$cc;
            }
            elseif($cc<100)
            {
                $cc=$sub_invoice.'00'.$cc;
            }
            elseif($cc<1000)
            {
                $cc=$sub_invoice.'0'.$cc;
            }
            else
            {
                $cc=$sub_invoice.$cc;

            }
        } else {
            $cc = $sub_invoice . '0001';
        }



        //    ****************************** unique number generator ***************
        //    ****************************** date conversion************************
        if ($request->start_date) {
            $date_array = explode('/', $request->start_date);
            $date_string = implode('-', $date_array);
            $date_time = date('Y-m-d', strtotime($date_string));
            $date = \DateTime::createFromFormat('Y-m-d', $date_time);
        } else {
            $date = NULL;
        }
        if ($request->end_date) {
            $end_date_array = explode('/', $request->end_date);
            $end_date_string = implode('-', $end_date_array);
            $end_date_time = date('Y-m-d', strtotime($end_date_string));
            $end_date = \DateTime::createFromFormat('Y-m-d', $end_date_time);
        } else {
            $end_date = NULL;
        }

        // dd($project_data);



        //    ****************************** date conversion ************************
        //    dd($request->all());
        $advance_task_total_amount = 0;
        if (isset($request->invoice_tasks)) {
            foreach ($request->invoice_tasks as $index => $inv_task) {
                $advance_task_total_amount += $request->amount[$index];
            }
        }
        //    dd($advance_task_total_amount);
        $lpo_project = LpoProject::find($request->lpo_projects_id);
        $project_data = $request->only('project_name', 'project_description', 'customer_id', 'lpo_projects_id', 'advance_amount', 'payment_mode', 'project_term', 'paid_amount_percentage','attention');
        //    dd($request->all());
        $project_data['budget'] = $request->total;
        $project_data['total_budget'] = $request->total_amount;
        $project_data['discount'] = $request->discount;
        $project_data['due_amount'] = $request->total_amount - $request->advance_amount;
        $project_data['start_date'] = $date ? $date : null;
        $project_data['end_date'] = $end_date;
        $project_data['project_code'] = $cc;
        $project_data['invoice_type'] = $lpo_project->invoice_type;
        $project_data['paid_amount'] = $request->advance_amount ? $request->advance_amount : 0;
        $project_data['paid_amount_percentage'] = $request->advance_amount_persentage ? $request->advance_amount_persentage : 0;
        $project_data['site_delivery'] = $request->site_delivery;
        $project_data['lpo_no'] = $request->lpo_no;
        $project_data['do_no'] = $request->do_no;

        $voucher_file_name = '';
        $ext = '';
        // dd($request->all());
        if($request->hasFile('voucher_file')){
            $voucher_scan = $request->file('voucher_file');
            $name = $voucher_scan->getClientOriginalName();
            $name = pathinfo($name, PATHINFO_FILENAME);
            $ext = $voucher_scan->getClientOriginalExtension();
            $voucher_file_name = $name.time(). '.'. $ext;
            $voucher_scan->storeAs('public/upload/documents',$voucher_file_name);
        }
        $project_data['voucher_file'] = $voucher_file_name;
        $project_data['extension'] = $ext;

        if ($request->payment_mode == 'Cheque') {

            $deposit_date = explode('/', $request->deposit_date);
            $end_deposit_date = implode('-', $deposit_date);
            $new_deposit_date = date('Y-m-d', strtotime($end_deposit_date));
            $change_date = \DateTime::createFromFormat('Y-m-d', $new_deposit_date);

            $project_data['issuing_bank'] = $request->issuing_bank;
            $project_data['bank_branch'] = $request->bank_branch;
            $project_data['cheque_no'] =  $request->cheque_no;
            $project_data['deposit_date'] = $change_date;
        }
        // dd($project_data);
        $project = JobProject::create($project_data);

        if (!$date) {
            $date = Date('Y-m-d');
        }

        // $task_based_task[]=0;
        $task_index = 0;
        // dd($request->task_name);
        $advance_amount = $request->advance_amount;
        foreach ($request->task_name as $index => $task) {
            // dd($request->task_name,$request->task_id);
            $task_data = [
                'job_project_id' => $project->id,
                'task_name' => $request->task_name[$index],
                'description' => $request->description[$index],
                'amount' => $request->amount[$index],
                'due_amount' => $request->amount[$index],
                'unit' => $request->unit[$index],
                'rate' => $request->rate[$index],
                'qty' => $request->qty[$index],
                'discount' => $request->task_discount[$index] ? $request->task_discount[$index] : 0,
            ];

            $task = LpoPorjectTask::find($request->task_id[$index]);
            if ($lpo_project->invoice_type == 'amount_base') {
                JobProjectTask::create($task_data);
            } elseif ($advance_amount <= 0) {
                JobProjectTask::create($task_data);
            } else {
                // $check=$request->invoice_tasks[$index];
                if (isset($request->invoice_tasks[$index])) {

                    if ($task->amount > $advance_amount) {
                        $advance_amount = 0;
                    } else {
                        $task_data = [
                            'is_invoice' => 1
                        ];

                        $advance_amount = $advance_amount - $task->amount;
                    }
                    $tata = JobProjectTask::create($task_data);
                    $task_based_task[$task_index++] = $tata->id;
                } else {
                    $task_data = [
                        'job_project_id' => $project->id,
                        'task_name' => $task->task_name,
                        'description' => $task->description,
                        'amount' => $task->amount,
                        'due_amount' => $task->amount,
                        'unit' => $task->unit,
                        'rate' => $task->rate,
                        'qty' => $task->qty,
                        'discount' => $task->discount,
                    ];
                    JobProjectTask::create($task_data);
                }
                // dd($tata);
            }
        }

        if ($lpo_project->invoice_type == null) {
            if ($request->advance_amount > 0 && isset($request->invoice_tasks)) {
                $project->invoice_type = 'task_base';
                $project->save();
            } elseif ($request->advance_amount > 0) {
                $project->invoice_type = 'amount_base';
                $project->save();
            }
        }

        if ($project->paid_amount > 0) {
            //  dd($project->discount);
            $invoice = JobProjectInvoice::create([
                'job_project_id' => $project->id,
                'customer_id' => $request->customer_id,
                'invoice_from' => 'Project',
                'budget' => $project->paid_amount,
                'total_budget' => $project->paid_amount + $request->vat_amount,
                'discount' => $project->discount ? $project->discount : 0,
                'total_due_amount_percentage' => $request->advance_amount_persentage ? $request->advance_amount_persentage : 0,
                'invoice_no' => $this->invoice_no(),
                'date' => date('Y/m/d'),
                'pay_mode' => $request->payment_mode,
                'paid_amount' => $project->paid_amount + $request->vat_amount,
                'due_amount' => 0,
                'approved_by' => auth()->id(),
                'vat' => $request->vat_amount,
                'advanced' => true

            ]);




            if (isset($task_based_task)) {
                foreach ($task_based_task as $tsk) {
                    $job_task = JobProjectTask::find($tsk);

                    JobProjectInvoiceTask::create([
                        'invoice_id' => $invoice->id,
                        'task_id' => $job_task->id,
                        'task_name' => $job_task->task_name,
                        'description' => $job_task->description,
                        'amount' => $job_task->amount,
                        'due_amount' =>  $job_task->due_amount,
                        'invoice_amount' => $job_task->invoice_amount,
                        'advance_amount'  => $job_task->advance_amount,
                        'unit' => $task->unit,
                        'rate' => $task->rate,
                        'qty' => $task->qty,
                        'discount' => $task->discount,
                    ]);
                }
            }
        }

        // dd($request->all());
        if ($project->discount + $project->advance_amount > 0) {

            if ($project->advance_amount > 0) {
                $payment_no = $this->payment_no();
                $payment = new Receipt();
                $payment->date =  $invoice->date;
                $payment->pay_mode =   $invoice->pay_mode;
                $payment->receipt_no = $payment_no;
                $payment->head_id = 0;
                $payment->total_amount =  $project->advance_amount + $request->vat_amount;
                $payment->vat = 0;
                $payment->party_id =  $invoice->customer_id;
                $payment->narration =  'Advance invoice-' . $invoice->invoice_no;
                $payment->paid_amount = $payment->total_amount;
                $payment->due_amount = 0;
                if ($request->payment_mode == 'Cheque') {
                    $payment->issuing_bank = $request->issuing_bank;
                    $payment->branch = $request->bank_branch;
                    $payment->cheque_no = $request->cheque_no;
                    $payment->deposit_date = $change_date;
                    $payment->status = 'Pending';
                } else {
                    $payment->status = 'Realised';
                }
                $payment->save();

                $purc_exp_itm = new ReceiptSale();
                $purc_exp_itm->sale_id = $invoice->id;
                $purc_exp_itm->payment_id = $payment->id;
                $purc_exp_itm->Total_amount = $payment->total_amount;
                $purc_exp_itm->vat = 0;
                $purc_exp_itm->amount = $payment->total_amount;
                $purc_exp_itm->party_id = $payment->party_id;
                $purc_exp_itm->save();
            }

            $journal_no = $this->journal_no();
            $journal = new Journal();
            $journal->project_id        = 1;
            $journal->job_project_id        = $project->id;
            $journal->transection_type = ' Journal Entry';
            $journal->transaction_type = 'Increase';
            $journal->journal_no        = $journal_no;
            $journal->date              = $date;
            $journal->pay_mode          = 'Credit';
            $journal->cost_center_id    = 0;
            $journal->party_info_id     = $project->customer_id;
            $journal->account_head_id   = 123;
            $journal->voucher_type   = 'DEBIT';
            $journal->amount            = $project->discount + $project->advance_amount + $request->vat_amount;
            $journal->tax_rate          = 0;
            $journal->vat_amount        = 0;
            $journal->total_amount      = $project->discount + $project->advance_amount + $request->vat_amount;
            $journal->gst_subtotal = 0;
            $journal->narration         =  'Project Invoice';
            $journal->approved_by = Auth::id();
            $journal->authorized_by         = Auth::id();
            $journal->created_by = Auth::id();
            $journal->save();

            $ac_head = AccountHead::find(3);
            $jl_record = new JournalRecord();
            $jl_record->journal_id     = $journal->id;
            $jl_record->project_details_id  = $journal->project_id;
            $jl_record->cost_center_id      = $journal->cost_center_id;
            $jl_record->party_info_id       =  $journal->party_info_id;
            $jl_record->journal_no          =  $journal->journal_no;
            $jl_record->account_head_id     = $ac_head->id;
            $jl_record->master_account_id   = $ac_head->master_account_id;
            $jl_record->account_head        = $ac_head->fld_ac_head;
            $jl_record->amount              =  $journal->amount;
            $jl_record->total_amount        =  $journal->amount;
            $jl_record->vat_rate_id         = 0;
            $jl_record->invoice_no        = 0;
            $jl_record->transaction_type    = 'DR';
            $jl_record->journal_date        =  $journal->date;
            $jl_record->is_main_head        = 1;
            $jl_record->account_type_id = $ac_head->account_type_id;
            $jl_record->save();

            $ac_head = AccountHead::find(7);
            $jl_record = new JournalRecord();
            $jl_record->journal_id     = $journal->id;
            $jl_record->project_details_id  = $journal->project_id;
            $jl_record->cost_center_id      = $journal->cost_center_id;
            $jl_record->party_info_id       =  $journal->party_info_id;
            $jl_record->journal_no          =  $journal->journal_no;
            $jl_record->account_head_id     = $ac_head->id;
            $jl_record->master_account_id   = $ac_head->master_account_id;
            $jl_record->account_head        = $ac_head->fld_ac_head;
            $jl_record->amount              = $project->discount + $project->advance_amount;
            $jl_record->total_amount        = $project->discount + $project->advance_amount;
            $jl_record->vat_rate_id         = 0;
            $jl_record->invoice_no        = 0;
            $jl_record->transaction_type    = 'CR';
            $jl_record->journal_date        =  $journal->date;
            $jl_record->is_main_head        = 1;
            $jl_record->account_type_id = $ac_head->account_type_id;
            $jl_record->save();
            if ($request->vat_amount > 0) {
                $ac_head = AccountHead::find(17);
                $jl_record = new JournalRecord();
                $jl_record->journal_id     = $journal->id;
                $jl_record->project_details_id  = $journal->project_id;
                $jl_record->cost_center_id      = $journal->cost_center_id;
                $jl_record->party_info_id       =  $journal->party_info_id;
                $jl_record->journal_no          =  $journal->journal_no;
                $jl_record->account_head_id     = $ac_head->id;
                $jl_record->master_account_id   = $ac_head->master_account_id;
                $jl_record->account_head        = $ac_head->fld_ac_head;
                $jl_record->amount              = $request->vat_amount;
                $jl_record->total_amount        = $request->vat_amount;
                $jl_record->vat_rate_id         = 0;
                $jl_record->invoice_no        = 0;
                $jl_record->transaction_type    = 'CR';
                $jl_record->journal_date        =  $journal->date;
                $jl_record->is_main_head        = 1;
                $jl_record->account_type_id = $ac_head->account_type_id;
                $jl_record->save();
            }


            $check_amount = $project->discount + ($request->payment_mode != 'Cheque' ? $project->advance_amount + $request->vat_amount : 0);
            if ($check_amount > 0) {
                $journal_no = $this->journal_no();
                $journal = new Journal();
                $journal->project_id        = 1;
                $journal->job_project_id        = $project->id;
                $journal->transection_type = ' Journal Entry';
                $journal->transaction_type = 'Increase';
                $journal->journal_no        = $journal_no;
                $journal->date              = $date;
                $journal->pay_mode          = $request->payment_mode;
                $journal->cost_center_id    = 0;
                $journal->party_info_id     = $project->customer_id;
                $journal->account_head_id   = 123;
                $journal->voucher_type   = 'DEBIT';
                $journal->amount            =  $project->discount + ($request->payment_mode != 'Cheque' ? $project->advance_amount + $request->vat_amount : 0);
                $journal->tax_rate          = 0;
                $journal->vat_amount        = 0;
                $journal->total_amount      =  $journal->amount;
                $journal->gst_subtotal = 0;
                $journal->narration         =  'Project Invoice';
                $journal->approved_by = Auth::id();
                $journal->authorized_by         = Auth::id();
                $journal->created_by = Auth::id();
                $journal->save();
                if ($project->advance_amount > 0 && $request->payment_mode != 'Cheque') {
                    $head = $request->payment_mode == 'Cash' ? 1 : 2;

                    $ac_head = AccountHead::find($head);
                    $jl_record = new JournalRecord();
                    $jl_record->journal_id     = $journal->id;
                    $jl_record->project_details_id  = $journal->project_id;
                    $jl_record->cost_center_id      = $journal->cost_center_id;
                    $jl_record->party_info_id       =  $journal->party_info_id;
                    $jl_record->journal_no          =  $journal->journal_no;
                    $jl_record->account_head_id     = $ac_head->id;
                    $jl_record->master_account_id   = $ac_head->master_account_id;
                    $jl_record->account_head        = $ac_head->fld_ac_head;
                    $jl_record->amount              = $project->advance_amount + $request->vat_amount;
                    $jl_record->total_amount        = $project->advance_amount + $request->vat_amount;
                    $jl_record->vat_rate_id         = 0;
                    $jl_record->invoice_no        = 0;
                    $jl_record->transaction_type    = 'DR';
                    $jl_record->journal_date        =  $journal->date;
                    $jl_record->is_main_head        = 1;
                    $jl_record->account_type_id = $ac_head->account_type_id;
                    $jl_record->save();
                }

                if ($project->discount > 0) {
                    $ac_head = AccountHead::find(29);
                    $jl_record = new JournalRecord();
                    $jl_record->journal_id     = $journal->id;
                    $jl_record->project_details_id  = $journal->project_id;
                    $jl_record->cost_center_id      = $journal->cost_center_id;
                    $jl_record->party_info_id       =  $journal->party_info_id;
                    $jl_record->journal_no          =  $journal->journal_no;
                    $jl_record->account_head_id     = $ac_head->id;
                    $jl_record->master_account_id   = $ac_head->master_account_id;
                    $jl_record->account_head        = $ac_head->fld_ac_head;
                    $jl_record->amount              = $project->discount;
                    $jl_record->total_amount        = $project->discount;
                    $jl_record->vat_rate_id         = 0;
                    $jl_record->invoice_no        = 0;
                    $jl_record->transaction_type    = 'DR';
                    $jl_record->journal_date        =  $journal->date;
                    $jl_record->is_main_head        = 1;
                    $jl_record->account_type_id = $ac_head->account_type_id;
                    $jl_record->save();
                }


                $ac_head = AccountHead::find(3);
                $jl_record = new JournalRecord();
                $jl_record->journal_id     = $journal->id;
                $jl_record->project_details_id  = $journal->project_id;
                $jl_record->cost_center_id      = $journal->cost_center_id;
                $jl_record->party_info_id       =  $journal->party_info_id;
                $jl_record->journal_no          =  $journal->journal_no;
                $jl_record->account_head_id     = $ac_head->id;
                $jl_record->master_account_id   = $ac_head->master_account_id;
                $jl_record->account_head        = $ac_head->fld_ac_head;
                $jl_record->amount              = $journal->amount;
                $jl_record->total_amount        = $journal->amount;
                $jl_record->vat_rate_id         = 0;
                $jl_record->invoice_no        = 0;
                $jl_record->transaction_type    = 'CR';
                $jl_record->journal_date        =  $journal->date;
                $jl_record->is_main_head        = 1;
                $jl_record->account_type_id = $ac_head->account_type_id;
                $jl_record->save();
            }
        }

        //uninvoiced journal
        $journal_no = $this->journal_no();
        $journal = new Journal();
        $journal->project_id        = 1;
        $journal->job_project_id        = $project->id;
        $journal->transection_type = 'UnInvoiced Journal Entry';
        $journal->transaction_type = 'Increase';
        $journal->journal_no        = $journal_no;
        $journal->date              = $date;
        $journal->pay_mode          = 'Uninvoiced';
        $journal->cost_center_id    = 0;
        $journal->party_info_id     = $project->customer_id;
        $journal->account_head_id   = 123;
        $journal->voucher_type   = 'DEBIT';
        $journal->amount            = $project->due_amount;
        $journal->tax_rate          = 0;
        $journal->vat_amount        = 0;
        $journal->total_amount      = $project->due_amount;
        $journal->gst_subtotal = 0;
        $journal->narration         =  'Project Invoice';
        $journal->approved_by = Auth::id();
        $journal->authorized_by         = Auth::id();
        $journal->created_by = Auth::id();
        $journal->save();



        //journal record uninvoiced asset entry
        $ac_head = AccountHead::find(19);
        $jl_record = new JournalRecord();
        $jl_record->journal_id     = $journal->id;
        $jl_record->project_details_id  = $journal->project_id;
        $jl_record->cost_center_id      = $journal->cost_center_id;
        $jl_record->party_info_id       =  $journal->party_info_id;
        $jl_record->journal_no          =  $journal->journal_no;
        $jl_record->account_head_id     = $ac_head->id;
        $jl_record->master_account_id   = $ac_head->master_account_id;
        $jl_record->account_head        = $ac_head->fld_ac_head;
        $jl_record->amount              = $journal->total_amount;
        $jl_record->total_amount        = $journal->total_amount;
        $jl_record->vat_rate_id         = 0;
        $jl_record->invoice_no        = 0;
        $jl_record->transaction_type    = 'DR';
        $jl_record->journal_date        =  $journal->date;
        $jl_record->is_main_head        = 1;
        $jl_record->account_type_id = $ac_head->account_type_id;
        $jl_record->save();
        //end journal record Receivable entry

        //journal record uninvoiced Revenue entry
        $ac_head = AccountHead::find(20);
        $jl_record = new JournalRecord();
        $jl_record->journal_id     = $journal->id;
        $jl_record->project_details_id  = $journal->project_id;
        $jl_record->cost_center_id      = $journal->cost_center_id;
        $jl_record->party_info_id       =  $journal->party_info_id;
        $jl_record->journal_no          =  $journal->journal_no;
        $jl_record->account_head_id     = $ac_head->id;
        $jl_record->master_account_id   = $ac_head->master_account_id;
        $jl_record->account_head        = $ac_head->fld_ac_head;
        $jl_record->amount              = $journal->total_amount;
        $jl_record->total_amount        = $journal->total_amount;
        $jl_record->vat_rate_id         = 0;
        $jl_record->invoice_no        = 0;
        $jl_record->transaction_type    = 'CR';
        $jl_record->journal_date        =  $journal->date;
        $jl_record->is_main_head        = 1;
        $jl_record->account_type_id = $ac_head->account_type_id;
        $jl_record->save();
        //end journal record Revenue entry
        LpoProject::find($request->lpo_projects_id)->update(['has_work_order' => 1]);
        return redirect()->route('projects.index')->with([
            'alert-type' => 'success',
            'message' => "Project has been created successfully",
        ]);
    }


    public function addCustomer(PartyInfoStoreRequest $request)
    {
        $latest = PartyInfo::withTrashed()->orderBy('id', 'DESC')->first();

        if ($latest) {
            $pi_code = preg_replace('/^PI-/', '', $latest->pi_code);
            ++$pi_code;
        } else {
            $pi_code = 1;
        }
        if ($pi_code < 10) {
            $c_code = "PI-000" . $pi_code;
        } elseif ($pi_code < 100) {
            $c_code = "PI-00" . $pi_code;
        } elseif ($pi_code < 1000) {
            $c_code = "PI-0" . $pi_code;
        } else {
            $c_code = "PI-" . $pi_code;
        }
        $data = $request->all();
        $data['pi_code'] = $c_code;

        return PartyInfo::create($data);
    }

    public function show(JobProject $project)
    {
        return view('backend.job-project.view', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\JobProject  $jobProject
     * @return \Illuminate\Http\Response
     */
    public function edit(JobProject $project)
    {
        $customers = PartyInfo::all();
        $vats = VatRate::orderBy('value')->get();
        return view('backend.job-project.edit', compact('project', 'customers', 'vats'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\JobProject  $jobProject
     * @return \Illuminate\Http\Response
     */
    public function update(JobProjectStoreRequest $request, JobProject $project)
    {
        $voucher_file_name = $project->voucher_file;
        $ext = $project->extension;
        if($request->hasFile('voucher_file')){
            if(Storage::exists('public/upload/documents/'. $project->voucher_file)){
                Storage::delete('public/upload/documents/'. $project->voucher_file);

            }
            $voucher_scan = $request->file('voucher_file');
            $name = $voucher_scan->getClientOriginalName();
            $name = pathinfo($name, PATHINFO_FILENAME);
            $ext = $voucher_scan->getClientOriginalExtension();
            $voucher_file_name = $name.time(). '.' . $ext;
            $voucher_scan->storeAs('public/upload/documents', $voucher_file_name);

        }
        $project_data['voucher_file'] = $voucher_file_name;
        $project_data['extension'] = $ext;
        $project_data = $request->only('project_name', 'project_description', 'customer_id', 'advance_payment');
        $project_data['budget'] = $request->sum_budget;
        $project_data['vat'] = $request->total_vat;
        $project_data['total_budget'] = $request->sum_total_budget;
        $project_data['due_amount'] = $request->sum_total_budget - $request->advance_payment;
        $project_data['paid_amount'] = $request->advance_payment;

        $date_array = explode('/', $request->start_date);
        $date_string = implode('-', $date_array);
        $date_time = date('Y-m-d', strtotime($date_string));
        $date = \DateTime::createFromFormat('Y-m-d', $date_time);
        $project_data['start_date'] = $date;

        $end_date_array = explode('/', $request->end_date);
        $end_date_string = implode('-', $end_date_array);
        $end_date_time = date('Y-m-d', strtotime($end_date_string));
        $end_date = \DateTime::createFromFormat('Y-m-d', $end_date_time);
        $project_data['end_date'] = $end_date;

        $budget_diff = $project_data['budget'] - $project->budget;


        $project->update($project_data);

        $project_tasks = $request->task_name;
        $task_description = $request->description;
        $task_budget = $request->budget;
        $task_vat = $request->vat;
        $task_total_budget = $request->total_budget;

        foreach ($project->tasks as $task) {
            $task->delete();
        }

        for ($i = 0; $i < count($project_tasks); $i++) {
            $task_data = [
                'job_project_id' => $project->id,
                'task_name' => $project_tasks[$i],
                'description' => $task_description[$i],
                'budget' => $task_budget[$i],
                'vat_id' => $task_vat[$i],
                'total_budget' => $task_total_budget[$i],
            ];

            JobProjectTask::create($task_data);
        }


        if ($budget_diff != 0) {
            //uninvoiced journal
            $journal_no = $this->journal_no();
            $journal = new Journal();
            $journal->project_id        = 1;
            $journal->job_project_id        = $project->id;
            $journal->transection_type = 'UnInvoiced Journal Edit';
            $journal->transaction_type = 'Increase';
            $journal->journal_no        = $journal_no;
            $journal->date              = $date;
            $journal->pay_mode          = 'Uninvoiced';
            $journal->cost_center_id    = 0;
            $journal->party_info_id     = $project->customer_id;
            $journal->account_head_id   = 123;
            $journal->voucher_type   = 'DEBIT';
            $journal->amount            = $budget_diff < 0 ? ($budget_diff * (-1)) : $budget_diff;
            $journal->tax_rate          = 0;
            $journal->vat_amount        = 0;
            $journal->total_amount      =  $journal->amount;
            $journal->gst_subtotal = 0;
            $journal->narration         =  'Project Invoice';
            $journal->approved_by = Auth::id();
            $journal->authorized_by         = Auth::id();
            $journal->created_by = Auth::id();
            $journal->save();



            //journal record uninvoiced asset entry
            $ac_head = AccountHead::find(19);
            $jl_record = new JournalRecord();
            $jl_record->journal_id     = $journal->id;
            $jl_record->project_details_id  = $journal->project_id;
            $jl_record->cost_center_id      = $journal->cost_center_id;
            $jl_record->party_info_id       =  $journal->party_info_id;
            $jl_record->journal_no          =  $journal->journal_no;
            $jl_record->account_head_id     = $ac_head->id;
            $jl_record->master_account_id   = $ac_head->master_account_id;
            $jl_record->account_head        = $ac_head->fld_ac_head;
            $jl_record->amount              = $journal->total_amount;
            $jl_record->total_amount        = $journal->total_amount;
            $jl_record->vat_rate_id         = 0;
            $jl_record->invoice_no        = 0;
            $jl_record->transaction_type    = $budget_diff < 0 ? 'CR' : 'DR';
            $jl_record->journal_date        =  $journal->date;
            $jl_record->is_main_head        = 1;
            $jl_record->account_type_id = $ac_head->account_type_id;
            $jl_record->save();
            //end journal record Receivable entry

            //journal record uninvoiced Revenue entry
            $ac_head = AccountHead::find(20);
            $jl_record = new JournalRecord();
            $jl_record->journal_id     = $journal->id;
            $jl_record->project_details_id  = $journal->project_id;
            $jl_record->cost_center_id      = $journal->cost_center_id;
            $jl_record->party_info_id       =  $journal->party_info_id;
            $jl_record->journal_no          =  $journal->journal_no;
            $jl_record->account_head_id     = $ac_head->id;
            $jl_record->master_account_id   = $ac_head->master_account_id;
            $jl_record->account_head        = $ac_head->fld_ac_head;
            $jl_record->amount              = $journal->total_amount;
            $jl_record->total_amount        = $journal->total_amount;
            $jl_record->vat_rate_id         = 0;
            $jl_record->invoice_no        = 0;
            $jl_record->transaction_type    =  $budget_diff < 0 ? 'DR' : 'CR';
            $jl_record->journal_date        =  $journal->date;
            $jl_record->is_main_head        = 1;
            $jl_record->account_type_id = $ac_head->account_type_id;
            $jl_record->save();
            //end journal record Revenue entry

        }

        return redirect()->route('projects.index')->with([
            'alert-type' => 'success',
            'message' => "Project has been updated successfully",
        ]);
    }


    public function projectDetails(JobProject $job_project)
    {
        $due = $job_project->tasks->sum('budget') - $job_project->payments->sum('payment_amount');
        return ['payment' => $job_project->payments, 'party' => $job_project->party, 'total_budget' => $job_project->tasks->sum('budget'), 'due' => $due];
    }



    public function projectInvoiceCreate(JobProject $job_project)
    {
        $job_project->update([
            'is_invoice' => 1,
            'due_amount' => $job_project->total_budget,
        ]);


        $journal_no = $this->journal_no();
        $journal = new Journal();
        $journal->project_id        = 1;
        $journal->job_project_id        = $job_project->id;
        $journal->transection_type = 'Job Entry';
        $journal->transaction_type = 'Increase';
        $journal->journal_no        = $journal_no;
        $journal->date              = $job_project->start_date;
        $journal->pay_mode          = 'Credit';
        $journal->cost_center_id    = 0;
        $journal->party_info_id     = $job_project->customer_id;
        $journal->account_head_id   = 123;
        $journal->voucher_type   = 'CREDIT';
        $journal->amount            = $job_project->total_budget;
        $journal->tax_rate          = 0;
        $journal->vat_amount        = $job_project->vat;
        $journal->total_amount      = $job_project->budget;
        $journal->gst_subtotal = 0;
        $journal->narration         =  'Project Invoice';
        $journal->approved_by = Auth::id();
        $journal->authorized_by         = Auth::id();
        $journal->created_by = Auth::id();
        $journal->save();


        //journal record Receivable entry
        $ac_head = AccountHead::find(3);
        $jl_record = new JournalRecord();
        $jl_record->journal_id     = $journal->id;
        $jl_record->project_details_id  = $journal->project_id;
        $jl_record->cost_center_id      = $journal->cost_center_id;
        $jl_record->party_info_id       =  $journal->party_info_id;
        $jl_record->journal_no          =  $journal->journal_no;
        $jl_record->account_head_id     = $ac_head->id;
        $jl_record->master_account_id   = $ac_head->master_account_id;
        $jl_record->account_head        = $ac_head->fld_ac_head;
        $jl_record->amount              = $journal->amount;
        $jl_record->total_amount        = $journal->amount;
        $jl_record->vat_rate_id         = 0;
        $jl_record->invoice_no        = 0;
        $jl_record->transaction_type    = 'DR';
        $jl_record->journal_date        =  $journal->date;
        $jl_record->is_main_head        = 1;
        $jl_record->account_type_id = $ac_head->account_type_id;
        $jl_record->save();
        //end journal record Receivable entry

        //journal record Revenue entry
        $ac_head = AccountHead::find(7);
        $jl_record = new JournalRecord();
        $jl_record->journal_id     = $journal->id;
        $jl_record->project_details_id  = $journal->project_id;
        $jl_record->cost_center_id      = $journal->cost_center_id;
        $jl_record->party_info_id       =  $journal->party_info_id;
        $jl_record->journal_no          =  $journal->journal_no;
        $jl_record->account_head_id     = $ac_head->id;
        $jl_record->master_account_id   = $ac_head->master_account_id;
        $jl_record->account_head        = $ac_head->fld_ac_head;
        $jl_record->amount              = $journal->total_amount;
        $jl_record->total_amount        = $journal->total_amount;
        $jl_record->vat_rate_id         = 0;
        $jl_record->invoice_no        = 0;
        $jl_record->transaction_type    = 'CR';
        $jl_record->journal_date        =  $journal->date;
        $jl_record->is_main_head        = 1;
        $jl_record->account_type_id = $ac_head->account_type_id;
        $jl_record->save();
        //end journal record Revenue entry

        //journal record vat entry
        $ac_head = AccountHead::find(17);
        $jl_record = new JournalRecord();
        $jl_record->journal_id     = $journal->id;
        $jl_record->project_details_id  = $journal->project_id;
        $jl_record->cost_center_id      = $journal->cost_center_id;
        $jl_record->party_info_id       =  $journal->party_info_id;
        $jl_record->journal_no          =  $journal->journal_no;
        $jl_record->account_head_id     = $ac_head->id;
        $jl_record->master_account_id   = $ac_head->master_account_id;
        $jl_record->account_head        = $ac_head->fld_ac_head;
        $jl_record->amount              = $journal->vat_amount;
        $jl_record->total_amount        = $journal->vat_amount;
        $jl_record->vat_rate_id         = 0;
        $jl_record->invoice_no        = 0;
        $jl_record->transaction_type    = 'CR';
        $jl_record->journal_date        =  $journal->date;
        $jl_record->is_main_head        = 1;
        $jl_record->account_type_id = $ac_head->account_type_id;
        $jl_record->save();
        //end journal record vat entry



        return redirect()->route('project.invoice.index')->with(['alert-type' => 'success', 'message' => 'Invoice has been created uccessfully ']);
    }

    public function projectInvoice()
    {
        $invoices = JobProject::where('is_invoice', 1)->latest()->paginate(20);
        return view('backend.job-project.invoices', compact('invoices'));
    }


    public function getVat()
    {
        return VatRate::orderBy('value', 'desc')->get();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\JobProject  $jobProject
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobProject $jobProject)
    {
        //
    }


    public function tracking($id)
    {
        $customers = PartyInfo::all();
        $project = JobProject::find($id);
        $vats = VatRate::orderBy('value')->get();
        return view('backend.job-project.track', compact('project', 'customers', 'vats'));
    }


    public function traking_store(Request $request)
    {
        $projectId = $request->project_id;
        $completed = $request->completed;

        $averageCompletion = array_sum($completed) / count($completed);

        $project = JobProject::find($projectId);
        $project->avarage_complete = $averageCompletion;
        $project->save();

        $taskIds = $request->task_id;
        $taskNames = $request->task_name;

        foreach ($taskIds as $index => $taskId) {
            $task = JobProjectTask::find($taskId);
            //  return( $task);
            $task->completed = $completed[$index];

            $task->save();
        }

        return redirect()->route('projects.index')->with([
            'alert-type' => 'success',
            'message' => "Project has been updated successfully",
        ]);
    }


    public function job_document_view(Request $request)
    {
        $project = JobProject::find($request->project_id);
        $documents = JobDocumentUpload::where('job_project_id', $request->project_id)->get();
        return view('backend.job-project.job-document-view', compact('project', 'documents'));
    }
    public function job_document_update(Request $request)
    {
        // return $request;
        if ($request->file('files')) {
            foreach ($request->file('files') as $file) {
                $name = $file->getClientOriginalName();
                $name = pathinfo($name, PATHINFO_FILENAME);
                $ext = $file->getClientOriginalExtension();
                $project_doc_name = $name . time() . '.' . $ext;
                $file->storeAs('public/upload/documents', $project_doc_name);
                JobDocumentUpload::create([
                    'job_project_id'  => $request->project_id,
                    'display_name'          => $name,
                    'filename'              => $project_doc_name,
                    'extension'             => $ext,
                ]);
            }
        }

        $notification = array(
            'message'       => 'Document saved successfully!',
            'alert-type'    => 'success'
        );

        return back()->with($notification);
    }
    public function delete_job_document(Request $request)
    {
        $record = JobDocumentUpload::find($request->id);
        $record->delete();
        return true;
    }

    public function find_project_task(Request $request)
    {
        // return $request->all();
        $tasks = JobProjectTask::where('job_project_id', $request->project)->get();
        return view('backend.job-project.find-job-task', compact('tasks'));
    }




    public function projectReport(Request $request)
    {
        $customers = PartyInfo::whereHas('projects')->get();
        $projects = JobProject::orderBy('project_name')->get();
        $project_id = $request->project_id;

        if($project_id){
            $project = JobProject::find($project_id);
            $customer = PartyInfo::with(['projects' => function ($e) use($project_id){
                $e->where('id',$project_id)->first();
            }])->find($project->customer_id);

            $projects = JobProject::where('customer_id',$project->customer_id)->get();

        }else{
            $customer = PartyInfo::with(['projects' => function ($e) {
                $e->latest()->take(5)->get();
            }])->find($request->customer_id);
            $projects = JobProject::where('customer_id',$request->customer_id)->get();

        }


        return view('backend.job-project.report', compact('customer', 'customers','projects','project_id'));
    }

    public function customerProject($id){
        $customer = PartyInfo::find($id);
        return $customer->projects;
    }


    public function roiReport(Request $request)
    {
        $projects = JobProject::whereHas('invoicess')->latest()->get();
        // dd($projects);
        if ($projects->count() <= 0) {
            return back()->with(['alert-type' => 'warning', 'message' => 'Work order Invoice not Found']);
        }

        if ($request->project_id) {
            $project = JobProject::with('tasks')->find($request->project_id);
            $this_proj = JobProject::find($request->project_id);
        } else {
            $project = JobProject::with('tasks')->find($projects[0]->id);
            $this_proj = JobProject::find($projects[0]->id);
        }
        $invoice_id = $project->invoicess->pluck('id')->all();
        // dd($project);
        $receiveds = Receipt::whereHas('items', function ($q) use ($invoice_id) {
            $q->whereIn('sale_id', $invoice_id);
        })->get();

        $receivables = $this_proj->invoicess()
            ->where(function ($query) {
                $query->where('due_amount', '>', 0)
                    ->orWhereHas('tempReceipt');
            })
            ->get();

        // $paybles = $project->purchase_expense->where('due_amount', '>', 0);

        $paybles = $this_proj->purchase_expense()
        ->where(function ($query) {
            $query->where('due_amount', '>', 0)
                ->orWhereHas('tempPayment');
        })
        ->get();

        // dd($paybles);

        return view('backend.job-project.roi-report', compact('project', 'projects', 'paybles', 'receiveds', 'receivables'));
    }


    public function roiReportChart($id)
    {
        $project = JobProject::find($id);
        $data = [
            'labels' => [],
            'value' => [
                'label_1' => 'Expense',
                'label_2' => 'Return',
                'data_1' => [],
                'data_2' => [],
            ],
        ];

        foreach ($project->tasks as $task) {
            $data['labels'][$task->id] = $task->task_name;
            $data['value']['data_1'][$task->id] = $task->expenses->sum('total_amount');
            $data['value']['data_2'][$task->id] = $task->amount;
        }
        return response()->json($data);
    }



    public function job_project_print($id)
    {
        $project=JobProject::find($id);
        return view('backend.job-project.print',compact('project'));
    }
}
