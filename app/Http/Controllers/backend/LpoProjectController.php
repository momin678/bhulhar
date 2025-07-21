<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobProjectStoreRequest;
use App\LpoPorjectTask;
use App\LpoProject;
use App\PartyInfo;
use App\VatRate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LpoProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $projects = LpoProject::orderBy('id','DESC')->paginate(20);
        $active_btn = false;
        $quotation = $request->quotation;
        $search = $request->search;

        if($search){
            $projects = LpoProject::where('project_name', 'like', '%' . $search . '%')
            ->orWhere('project_code', 'like', '%'. $search . '%')
            ->latest()->paginate(20);
        }
        elseif($quotation == 'new'){
            $projects = LpoProject::where('has_work_order',null)->latest()->paginate(20);
            $active_btn = 'new';
        }elseif($quotation == 'old'){
            $projects = LpoProject::where('has_work_order',1)->latest()->paginate(20);
            $active_btn = 'old';
        }
        return view('backend.lpo-project.index',compact('projects','active_btn','search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $project = new LpoProject();

        $sub_invoice = 'QTO'.Carbon::now()->format('Ymd');
        $tem_project_code = LpoProject::where('project_code', 'LIKE', "%{$sub_invoice}%")->orderBy('id','DESC')->first();
        if ($tem_project_code) {
            $cc= preg_replace('/^'.$sub_invoice.'/', '', $tem_project_code->project_code);
            $cc++;
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


        $customers = PartyInfo::where('pi_type','Customer')->get();
        $vats = VatRate::orderBy('value','desc')->get();
        return view('backend.lpo-project.create',compact('customers','project','vats','cc'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JobProjectStoreRequest $request)
    {
        //return($request);
        // dd($request->all());
        $project_data = $request->only('project_name','project_description','customer_id','project_term','attention');

         $sub_invoice = 'QTO'.Carbon::now()->format('y');

        $tem_project_code = LpoProject::where('project_code', 'LIKE', "%{$sub_invoice}%")->orderBy('id','DESC')->first();
        if ($tem_project_code) {
            $cc= preg_replace('/^'.$sub_invoice.'/', '', $tem_project_code->project_code) + 1;

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
            $cc = 'QTO'.Carbon::now()->format('y') . '0001';
        }
        if($request->start_date){
            $date_array = explode('/',$request->start_date);
            $date_string = implode('-',$date_array);
            $date_time = date('Y-m-d',strtotime($date_string));
            $date = \DateTime::createFromFormat('Y-m-d',$date_time);
            $project_data['start_date'] = $date;
        }
        if($request->start_date){
            $end_date_array = explode('/',$request->end_date);
            $end_date_string = implode('-',$end_date_array);
            $end_date_time = date('Y-m-d',strtotime($end_date_string));
            $end_date = \DateTime::createFromFormat('Y-m-d',$end_date_time);
            $project_data['end_date'] = $end_date;
        }
        $voucher_file_name = '';
        $ext = '';
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


        $project_data['budget'] = $request->total;
        $project_data['total_budget'] = $request->total_amount;
        $project_data['discount'] = $request->discount;
        $project_data['project_code'] = $cc;
        $project_data['site_delivery'] = $request->site_delivery;
        $project = LpoProject::create($project_data);

        $project_tasks = $request->task_name;
        $task_description = $request->description;
        $amount = $request->amount;
        $rate = $request->rate;
        $unit = $request->unit;
        $qty = $request->qty;
        $invoice_tasks = $request->invoice_tasks;


        if($project_data['discount'] > 0){
            $task_amount = 0;
            if($request->invoice_tasks){
                foreach($invoice_tasks as $key => $task){
                    $task_amount += $request->amount[$key];
                }
                $per_amount = ($request->discount * 100) / $task_amount;

                foreach($invoice_tasks as $key => $task){
                    $task_discount = ($per_amount * $request->amount[$key]) /100;
                    $amount[$key] = $request->amount[$key] - $task_discount;
                }
                if(count($invoice_tasks) > 0){
                    $project->update(['invoice_type' => 'task_base']);
                }
            }else{
                $project->update(['invoice_type' => 'amount_base']);
            }

        }

        for($i=0;$i<count($project_tasks);$i++){

            $task_data = [
                'lpo_project_id' => $project->id,
                'task_name' => $project_tasks[$i],
                'description' => $task_description[$i],
                'amount' => $amount[$i],
                'unit' => $unit[$i],
                'rate' => $rate[$i],
                'qty' => $qty[$i],
                'discount' => $request->amount[$i] - $amount[$i],
            ];
            LpoPorjectTask::create($task_data);
        }

        return redirect()->route('lpo-projects.index')->with([
            'alert-type' => 'success',
            'message' =>"Project has been created successfully",
        ]);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Lpoproject  $lpoproject
     * @return \Illuminate\Http\Response
     */
    public function show(LpoProject $lpo_project)
    {
        return view('backend.lpo-project.view',compact('lpo_project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Lpoproject  $lpoproject
     * @return \Illuminate\Http\Response
     */
    public function edit(LpoProject $lpo_project)
    {
        $customers = PartyInfo::where('pi_type','Customer')->get();
        // dd($lpo_project->tasks);
        return view('backend.lpo-project.edit',compact('lpo_project','customers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Lpoproject  $lpoproject
     * @return \Illuminate\Http\Response
     */
    public function update(JobProjectStoreRequest $request, LpoProject $lpo_project)
    {
        //return($request);
        $project_data = $request->only('project_name','project_description','customer_id','project_term','attention');

        if($request->start_date){
            $date_array = explode('/',$request->start_date);
            $date_string = implode('-',$date_array);
            $date_time = date('Y-m-d',strtotime($date_string));
            $date = \DateTime::createFromFormat('Y-m-d',$date_time);
            $project_data['start_date'] = $date;
        }else{
            $project_data['start_date'] = Null;
        }
        if($request->start_date){
            $end_date_array = explode('/',$request->end_date);
            $end_date_string = implode('-',$end_date_array);
            $end_date_time = date('Y-m-d',strtotime($end_date_string));
            $end_date = \DateTime::createFromFormat('Y-m-d',$end_date_time);
            $project_data['end_date'] = $end_date;
        }else{
            $project_data['end_date'] = Null;
        }

        $project_data['budget'] = $request->total;
        $project_data['total_budget'] = $request->total_amount;
        $project_data['discount'] = $request->discount;
        $project_data['site_delivery'] = $request->site_delivery;

        $voucher_file_name = $lpo_project->voucher_file;
        $ext = $lpo_project->extension;
        if($request->hasFile('voucher_file')){
            if(Storage::exists('public/upload/documents/'. $lpo_project->voucher_file)){
                Storage::delete('public/upload/documents/'. $lpo_project->voucher_file);

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
        // dd($project_data);
        $lpo_project->update($project_data);

        $project_tasks = $request->task_name;
        $task_description = $request->description;
        $amount = $request->amount;
        $rate = $request->rate;
        $unit = $request->unit;
        $qty = $request->qty;
        $invoice_tasks = $request->invoice_tasks;

        $lpo_project->tasks->each->delete();

        if($project_data['discount'] > 0){
            $task_amount = 0;
            if($request->invoice_tasks){
                foreach($invoice_tasks as $key => $task){
                    $task_amount += $request->amount[$key];
                }
                $per_amount = ($request->discount * 100) / $task_amount;

                foreach($invoice_tasks as $key => $task){
                    $task_discount = ($per_amount * $request->amount[$key]) /100;
                    $amount[$key] = $request->amount[$key] - $task_discount;
                }
                if(count($invoice_tasks) > 0){
                    $lpo_project->update(['invoice_type' => 'task_base']);
                }
            }else{
                $lpo_project->update(['invoice_type' => 'amount_base']);
            }

        }else{
            $lpo_project->update(['invoice_type' => Null]);
        }
        for($i=0;$i<count($project_tasks);$i++){
            $task_data = [
                'lpo_project_id' => $lpo_project->id,
                'task_name' => $project_tasks[$i],
                'description' => $task_description[$i],
                'amount' => $amount[$i],
                'unit' => $unit[$i],
                'rate' => $rate[$i],
                'qty' => $qty[$i],
                'discount' => $request->amount[$i] - $amount[$i],
            ];
            LpoPorjectTask::create($task_data);
        }

        return redirect()->route('lpo-projects.index')->with([
            'alert-type' => 'success',
            'message' =>"Project has been updated successfully",
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lpoproject  $lpoproject
     * @return \Illuminate\Http\Response
     */

    public function getLpoProject($id){
        return LpoProject::with(['party','tasks' =>function($q){
            $q->with('vat');
        }])->find($id);
    }

    public function destroy(Lpoproject $lpoproject)
    {
        //
    }

    public function lpo_print($id)
    {
        $lpo_project=LpoProject::find($id);
        return view('backend.lpo-project.print',compact('lpo_project'));
    }
}
