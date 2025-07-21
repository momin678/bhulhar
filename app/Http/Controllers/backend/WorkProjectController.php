<?php

namespace App\Http\Controllers\backend;

use App\PartyInfo;
use App\WorkProject;
use App\JobProject;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class WorkProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $pInfos = PartyInfo::where('pi_type', 'Customer')->get();
        
        $projects = JobProject::orderBy('id','DESC')->where('is_invoice', 0)->where('type', 'project');
        if($search){
            $projects = $projects->where('project_name', 'like', '%' . $search . '%');
        }
        $projects = $projects->paginate(20);
        return view('backend.work-project.index',compact('projects', 'pInfos'));
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
        
        //    dd($advance_task_total_amount);
        $project_data['project_name'] = $request->project_name;
        $project_data['budget'] = $request->total_amount;
        $project_data['total_budget'] = $request->total_amount;
        $project_data['discount'] = 0.00;
        $project_data['due_amount'] = $request->total_amount;
        $project_data['project_code'] = $cc;
        $project_data['invoice_type'] = 'amount_base';
        $project_data['paid_amount'] = 0.00;
        $project_data['paid_amount_percentage'] = 0.00;
        $project_data['site_delivery'] = $request->site_delivery;
        $project_data['project_description'] = $request->project_description;
        $project_data['type'] = 'project';
        $project_data['customer_id'] = $request->party_id;
        $project_data['consultant_name'] = $request->consultant_name;
        $project_data['lpo_projects_id'] = 0;

        $voucher_file_name = '';
        $ext = '';
        if($request->hasFile('voucher_scan')){
            $voucher_scan = $request->file('voucher_scan');
            $name = $voucher_scan->getClientOriginalName();
            $name = pathinfo($name, PATHINFO_FILENAME);
            $ext = $voucher_scan->getClientOriginalExtension();
            $voucher_file_name = $name.time(). '.'. $ext;
            $voucher_scan->storeAs('public/upload/documents',$voucher_file_name);
        }
        $project_data['voucher_file'] = $voucher_file_name;
        $project_data['extension'] = $ext;
        $project = JobProject::create($project_data);
        return back()->with([
            'alert-type' => 'success',
            'message' => "Project has been created successfully",
        ]);
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
        $project = JobProject::find($id);
        $project->project_name = $request->project_name;
        $project->budget = $request->total_amount;
        $project->total_budget = $request->total_amount;
        $project->discount = 0.00;
        $project->due_amount = $request->total_amount;
        $project->invoice_type = 'amount_base';
        $project->paid_amount = 0.00;
        $project->paid_amount_percentage = 0.00;
        $project->site_delivery = $request->site_delivery;
        $project->project_description = $request->project_description;
        $project->type = 'project';
        $project->customer_id = $request->party_id;
        $project->consultant_name = $request->consultant_name;
        $project->lpo_projects_id = 0;

        $voucher_file_name = '';
        $ext = '';
        if($request->hasFile('voucher_scan')){
            $voucher_scan = $request->file('voucher_scan');
            $name = $voucher_scan->getClientOriginalName();
            $name = pathinfo($name, PATHINFO_FILENAME);
            $ext = $voucher_scan->getClientOriginalExtension();
            $voucher_file_name = $name.time(). '.'. $ext;
            $voucher_scan->storeAs('public/upload/documents',$voucher_file_name);
        }
        $project->voucher_file= $voucher_file_name;
        $project->extension= $ext;
        $project->save();
        return back()->with([
            'alert-type' => 'success',
            'message' => "Project has been Update successfully",
        ]);
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
    public function work_project_edit(Request $request){
        $project = JobProject::find($request->project_id);
        $pInfos = PartyInfo::where('pi_type', 'Customer')->get();
        return view('backend.work-project.edit',compact('project', 'pInfos'));
    }
}
