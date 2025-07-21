<?php

namespace App\Http\Controllers;

use App\Item;
use App\PartyInfo;
use App\ProjecetItem;
use App\Project;
use App\ProjectDetail;
use App\projectItemTemp;
use App\ProjectTemp;
use App\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::get();
        return view('backend.final-project.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $delete_invoice_temp = ProjectTemp::whereDate('created_at', '<', Carbon::today())->delete();
        $delete_invoice_temp = projectItemTemp::whereDate('created_at', '<', Carbon::today())->delete();
        $sub_invoice = Carbon::now()->format('Ymd');
        $latest_pro = ProjectTemp::whereDate('created_at', Carbon::today())->where('number', 'LIKE', "%{$sub_invoice}%")->orderBy('id', 'desc')->first();
        if ($latest_pro) {
            $number = $latest_pro->number + 1;
        } else {
            $number = Carbon::now()->format('Ymd') . '001';
        }
        $proTemp = new ProjectTemp();
        $proTemp->number = $number;
        $proTemp->save();
      
        $customers = PartyInfo::get();
        // dd($invoicess);
        $branch = ProjectDetail::get();
        $items = Item::get();
        $gl_code = null;
        $unites = Unit::get();
        return view('backend.final-project.create', compact('proTemp', 'customers', 'branch', 'unites', 'items'));
    }
    public function item_pro(Request $request)
    {
        // return $request->all();
        // return $request->all();
        if ($request->item == null) {
            return Response()->json(['error' => "Please, Select Item"]);
        } elseif ($request->rate == null) {
            return Response()->json(['error' => "Fill up rate"]);
        } else {
            $temp = new projectItemTemp();
            $temp->pro_id = $request->pro_id;
            $temp->item = $request->item;
            $temp->rate = $request->rate;
            $temp->quantity = $request->volume;
         
           
            if($request->include_vat==0)
            {
                $temp->vat = $request->total*(5/100);
                $temp->taxable_amount = $request->total;
                $temp->amount = $request->total+$temp->vat;
            }
            else
            {
                $temp->vat = $request->total*(5/105);
                $temp->taxable_amount = $request->total-$temp->vat;
                $temp->amount =$request->total;;
            }

            $temp->save();
            $temppro = ProjectTemp::where('id', $temp->pro_id)->first();
            if ($request->ajax()) {
                return Response()->json([
                    'page' => view('backend.final-project.tempTable', ['temppro' => $temppro, 'i' => 1])->render(),
                ]);
            }
        }
    }
    public function tempItemDelete($item, Request $request)
    {
        $itm = projectItemTemp::where('id', $item)->first();
        $pro_id = $itm->pro_id;
        $itm->delete();
        $temppro = ProjectTemp::where('id', $pro_id)->first();
        if ($request->ajax()) {
            return Response()->json([
                'page' => view('backend.final-project.tempTable', ['temppro' => $temppro, 'i' => 1])->render(),
            ]);
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $temp=ProjectTemp::find($request->pro_id);
        $sub_invoice = Carbon::now()->format('Ymd');
        $latest_boq = Project::whereDate('created_at', Carbon::today())->where('number', 'LIKE', "%{$sub_invoice}%")->orderBy('id', 'desc')->first();
        if ($latest_boq) {
            $number = $latest_boq->number + 1;
        } else {
            $number = Carbon::now()->format('Ymd') . '001';
        }
        $project=new Project();
        $project->number = $number;
        $project->branch = $request->branch;
        $project->customer = $request->customer_name;
        $project->date = $request->date;
        $project->taxable_amount = $temp->items->sum('taxable_amount');
        $project->vat = $temp->items->sum('vat');
        $project->total_cost = $temp->items->sum('amount');
        $project->save();
        foreach($temp->items as $item)
        {
            $pro_item = new ProjecetItem();
            $pro_item->pro_id = $project->id;
            $pro_item->item = $item->item;
            $pro_item->rate = $item->rate;
            $pro_item->quantity = $item->quantity;
            $pro_item->vat = $item->vat;
            $pro_item->taxable_amount =  $item->taxable_amount;
            $pro_item->amount = $item->amount;
            $pro_item->save();
        }
        return redirect()->route('projects.show', [$project->id])->with('success', 'Project View');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
           $project = Project::where('id' , $id)->first();
          //return($project->name->proj_name);
        return view('backend.final-project.show',compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        //
    }
}
