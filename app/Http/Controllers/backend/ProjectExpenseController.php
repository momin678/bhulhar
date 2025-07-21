<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\JobProject;
use App\JobProjectExpense;
use App\Unit;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectExpenseController extends Controller
{
    public function index(){
        $units = Unit::all();
        $project_expenses = JobProject::whereHas('expenses',function($q){
            $q->latest();
        })->latest()->paginate(20);

        return view('backend.job-project-expense.index',compact('project_expenses','units'));
    }
    public function create(){
        $projects = JobProject::latest()->get();
        $units = Unit::all();
        return view('backend.job-project-expense.create',compact('projects','units'));
    }

    public function store(Request $request){

        $data = $request->only('job_project_id','date','item','qty','unit','price');
        $rule = [
            'job_project_id' => 'required',
            'date' => 'required',
            'item' => 'required',
            'qty' => 'required',
            'unit' => 'required',
            'price' => 'required',
        ];

        $validator = Validator::make($data,$rule);

        if($validator->fails()){
            $notification = array(
                'message'=>"Missing some input field",
                'alert-type'=>'error'
            );
            return redirect()->route('porject.expense.index')->with($notification);
        }


        $date_array = explode('/',$request->date);
        $date_string = implode('-',$date_array);
        $date_time = date('Y-m-d',strtotime($date_string));
        $date = \DateTime::createFromFormat('Y-m-d',$date_time);

        for($i=0;$i<count($request->item);$i++){

            JobProjectExpense::create([
                'item' => $request->item[$i],
                'date' => $date,
                'qty' => $request->qty[$i],
                'unit_id' => $request->unit[$i],
                'price' => $request->price[$i],
                'job_project_id' => $request->job_project_id,
            ]);
        }

        return back()->with(['alert-type' => 'success','message' => 'Successfully Created Expenses']);
    }

    public function show(JobProject $job_project){
        return view('backend.job-project-expense.view',compact('job_project'));
    }

    public function edit(JobProject $job_project){
        $units = Unit::all();
        return view('backend.job-project-expense.edit',compact('job_project','units'));
    }

    public function update(Request $request,JobProject $job_project){
        $request->validate([
            'job_project_id' => 'required',
            'item' => 'required',
            'qty' => 'required',
            'unit' => 'required|max:200',
            'price' => 'required',
            'date' => 'required',
        ]);

        // dd($request->all());

        $date_array = explode('/',$request->date);
        $date_string = implode('-',$date_array);
        $date_time = date('Y-m-d',strtotime($date_string));
        $date = \DateTime::createFromFormat('Y-m-d',$date_time);

        foreach($job_project->expenses as $expense){
            $expense->delete();
        }

        for($i=0;$i<count($request->item);$i++){

            JobProjectExpense::create([
                'item' => $request->item[$i],
                'date' => $date,
                'qty' => $request->qty[$i],
                'unit_id' => $request->unit[$i],
                'price' => $request->price[$i],
                'job_project_id' => $request->job_project_id,
            ]);
        }

        return back()->with(['alert-type' => 'success','message' => 'Successfully Updated Expenses']);

    }

    public function getUnits(){
        return Unit::all();
    }
}
