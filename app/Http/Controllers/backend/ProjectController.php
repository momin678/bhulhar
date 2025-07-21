<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\ProfitCenter;
use App\ProjectDetail;
use App\ProjectDetailsType;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function projectDetails()
    {
        $latest = ProjectDetail::withTrashed()->latest()->first();

        if ($latest) {
            $pn_code=preg_replace('/^PN-/', '', $latest->proj_no);
            ++$pn_code;
        } else {
            $pn_code = 1;
        }
        if($pn_code<10)
        {
            $p_code="PN-00".$pn_code;
        }
        elseif($pn_code<100)
        {
            $p_code="PN-0".$pn_code;
        }
        else
        {
            $p_code="PN-".$pn_code;
        }
        // dd(1);
        $profit_centers=ProfitCenter::get();
        $projectTypes=ProjectDetailsType::get();
        $projDetails=ProjectDetail::where('proj_type','!=',"Draft")->latest()->paginate(25);
        return view('backend.project.projectDetails',compact('projDetails','projectTypes','profit_centers','p_code'));
    }

    public function projectDetailsPost(Request $request)
    {
        $request->validate([
            // 'proj_no' => 'required',
            'proj_name'        => 'required',
            'proj_type'        => 'required',
            'cont_no'         =>  'required',
            'cons_agent'         =>  'required',
            'address'         =>  'required',
            'owner_name'         =>  'required',
            'ord_date'         =>  'required',
            'hnd_over_date' => 'required',
            'profit_pc_code' => 'required'
        ],
        [
            'proj_name.required' => 'Project Name is required',
            'proj_type.required' => 'Project Type is required',
            'cont_no.required' => 'Phone Number is required',
            'cons_agent.required' => 'Consulting Agent is required',
            'address.required' => 'Site Location is required',
            'owner_name.required' => 'Owner Name is required',
            'ord_date.required' => 'Order Date is required',
            'hnd_over_date.required' => 'Handover Date is required',
            'profit_pc_code.required' => 'Select Profit Center',
        ]
    );

            $latest = ProjectDetail::withTrashed()->latest()->first();
            $profDraft = new ProjectDetail();
            if ($latest) {
                $pn_code=preg_replace('/^PN-/', '', $latest->proj_no);
                ++$pn_code;
            } else {
                $pn_code = 1;
            }
            if($pn_code<10)
            {
                $profDraft->proj_no="PN-00".$pn_code;
            }
            elseif($pn_code<100)
            {
                $profDraft->proj_no="PN-0".$pn_code;
            }
            else
            {
                $profDraft->proj_no="PN-".$pn_code;
            }
        $old_date = explode('/', $request->ord_date);
        $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
        $new_date = date('Y-m-d', strtotime($new_data));
        $new_date = \DateTime::createFromFormat("Y-m-d", $new_date);

        $old_date2 = explode('/', $request->hnd_over_date);
        $new_data2 = $old_date2[0].'-'.$old_date2[1].'-'.$old_date2[2];
        $new_date2 = date('Y-m-d', strtotime($new_data2));
        $new_date2 = \DateTime::createFromFormat("Y-m-d", $new_date2);

        $profDraft->proj_name=$request->proj_name;
        $profDraft->proj_type=$request->proj_type;
        $profDraft->cons_agent=$request->cons_agent;
        $profDraft->address=$request->address;
        $profDraft->owner_name=$request->owner_name;
        $profDraft->cont_no=$request->cont_no;
        $profDraft->ord_date=$new_date;
        $profDraft->hnd_over_date=$new_date2;
        $profDraft->pc_code=$request->profit_pc_code;
        $save=$profDraft->save();
        return redirect()->route('projectDetails')->with('success','Added Successfully');
    }

    public function projectEdit($proj)
    {
        $proj=ProjectDetail::find($proj);
        if(!$proj)
        {
            return back()->with('error', "Not Found");
        }
        $profit_centers=ProfitCenter::get();
        $projectTypes=ProjectDetailsType::get();
        $projDetails=ProjectDetail::where('proj_type','!=',"Draft")->latest()->paginate(25);

        return view('backend.project.projectDetailsEdit',compact('projDetails','proj','projectTypes','profit_centers'));
    }

    public function projectDetailsUpdate($proj, Request $request)
    {
        $request->validate([
            'proj_name'        => 'required',
            'proj_type'        => 'required',
            'cont_no'         =>  'required',
            'cons_agent'         =>  'required',
            'address'         =>  'required',
            'owner_name'         =>  'required',
            'ord_date'         =>  'required',
            'hnd_over_date' => 'required',
            'profit_pc_code' => 'required'
        ],
        [
            'proj_name.required' => 'Project Name is required',
            'proj_type.required' => 'Project Type is required',
            'cont_no.required' => 'Phone Number is required',
            'cons_agent.required' => 'Consulting Agent is required',
            'address.required' => 'Site Location is required',
            'owner_name.required' => 'Owner Name is required',
            'ord_date.required' => 'Order Date is required',
            'hnd_over_date.required' => 'Handover Date is required',
            'profit_pc_code.required' => 'Select Profit Center',
        ]
    );

        $proj=ProjectDetail::find($proj);
        if(!$proj)
        {
            return back()->with('error', "Not Found");
        }
        
        $old_date = explode('/', $request->ord_date);
        $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
        $new_date = date('Y-m-d', strtotime($new_data));
        $new_date = \DateTime::createFromFormat("Y-m-d", $new_date);
        
        $old_date2 = explode('/', $request->hnd_over_date);
        $new_data2 = $old_date2[0].'-'.$old_date2[1].'-'.$old_date2[2];
        $new_date2 = date('Y-m-d', strtotime($new_data2));
        $new_date2 = \DateTime::createFromFormat("Y-m-d", $new_date2);

        $proj->proj_name=$request->proj_name;

        $proj->proj_type=$request->proj_type;

        $proj->cons_agent=$request->cons_agent;

        $proj->address=$request->address;

        $proj->owner_name=$request->owner_name;

        $proj->cont_no=$request->cont_no;

        $proj->ord_date=$new_date;

        $proj->hnd_over_date=$new_date2;
        $proj->pc_code=$request->profit_pc_code;

        $proj->save();
        return back()->with('success','Updated Successfully');

    }


    public function projectDelete($proj)
    {
        $proj=ProjectDetail::find($proj);
        if(!$proj)
        {
            return back()->with('error', "Not Found");
        }
        $proj->forceDelete();
        return redirect()->route('projectDetails')->with('success', "Deleted Successfully");
    }
    public function projectForm(Request $request)
    {
        $latest = ProjectDetail::withTrashed()->latest()->first();

        if ($latest) {
            $pn_code=preg_replace('/^PN-/', '', $latest->proj_no);
            ++$pn_code;
        } else {
            $pn_code = 1;
        }
        if($pn_code<10)
        {
            $p_code="PN-00".$pn_code;
        }
        elseif($pn_code<100)
        {
            $p_code="PN-0".$pn_code;
        }
        else
        {
            $p_code="PN-".$pn_code;
        }
        $projectTypes=ProjectDetailsType::get();
        $profit_centers=ProfitCenter::get();
        if ($request->ajax()) {
            return Response()->json(['page' => view('backend.ajax.form.projectForm', ['p_code' => $p_code,'projectTypes' => $projectTypes, 'profit_centers'=>$profit_centers])->render()]);
        }
    }
    // mominul
    public function projectView(Request $request)
    {
        $proj=ProjectDetail::find($request->id);
        if(!$proj)
        {
            return back()->with('error', "Not Found");
        }

        return view('backend.project.projectDetailsView',compact('proj'));
    }
    public function project_list_print(Request $request){
        $projDetails = ProjectDetail::where('proj_type', '!=', "Draft")->latest()->get();
        return view('backend/pdf/projDetailsPdf', compact('projDetails'));
    }
}
