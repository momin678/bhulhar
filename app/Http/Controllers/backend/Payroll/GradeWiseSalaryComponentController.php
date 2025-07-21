<?php

namespace App\Http\Controllers\backend\Payroll;

use App\Http\Controllers\Controller;
use App\Mapping;
use App\Models\Payroll\ComponentType;
use App\Models\Payroll\Grade;
use App\Models\Payroll\GradeWiseSalaryComponent;
use App\Models\Payroll\GradeWiseSalaryComponentHistory;
use App\Models\Payroll\SalaryComponent;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;

class GradeWiseSalaryComponentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //Gate::authorize('salary_procedure');
        $grade_wise_components = GradeWiseSalaryComponent::orderBy('id', 'desc')->get();
        $components = SalaryComponent::orderBy('id', 'desc')->get();
        $grades = Grade::get();
        // $accoutHeads = AccountHead::all();
        // dd($facitities);
        return view('backend.payroll.grade_wise_salary_components.index', compact('components','grade_wise_components', 'grades'));
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
        dd($request);
        $request->validate([
            'head' => 'required',
        ]);
        GradeWiseSalaryComponent::create([
            'name' => $request->head,
            'grade_id' => $request->grade_id,
            'salary_component_id' => $request->salary_component_id,
            'value' => $request->value==null? 0:$request->value,
        ]);
        $notification= array(
            'message'       => 'Added successfully!',
            'alert-type'    => 'success'
        );
        return redirect('grade-wise-salary-components')->with($notification);
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

        // $componemts_info = GradeWiseSalaryComponent::find($id);
        $grade = Grade::find($id);
        // dd($grade);
        $components = SalaryComponent::orderBy('id', 'desc')->get();
        $component_types = ComponentType::orderBy('id', 'desc')->get();
        return Response()->json([
            'page' => view('backend.payroll.grade_wise_salary_components.edit-modal', ['components' => $components,
                                                                     'component_types' => $component_types,
                                                                     'grade' => $grade])->render(),

        ]);
        // return view('backend.payroll.grade_wise_salary_components.edit', compact('components','component_types','grade'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        // dd($request->all());

        $old_date = explode('/', $request->date);

        $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
        $new_date = date('Y-m-d', strtotime($new_data));
        $new_date = \DateTime::createFromFormat("Y-m-d", $new_date);

        $grade = Grade::find($id);

        if (!$grade) {
            $notification= array(
                'message'       => 'There have no grade',
                'alert-type'    => 'danger'
            );
            return redirect('grade-wise-salary-components')->with($notification);
        }

        GradeWiseSalaryComponent::where('grade_id',$grade->id)->delete();

        // $date = GradeWiseSalaryComponentHistory::where('grade_id',$item->grade)->whereMonth('date','<=',$month)->whereYear('date','>=',$year)->whereMonth('date','<=',$month)->whereYear('date','<=',$year)->orderBy('date', 'desc')->first();
        GradeWiseSalaryComponentHistory::where('grade_id',$grade->id)->whereMonth('date',$new_date)->whereYear('date',$new_date)->delete();
        // dd($history);

        if (isset($request->records['head'])) {
            foreach ($request->records['head'] as $key => $value) {

                GradeWiseSalaryComponent::create([
                    'type_id' => $request->records['type'][$key],
                    'grade_id' => $request->grade_id,
                    'date' => $new_date,
                    'salary_component_id' => $request->records['head'][$key],
                    'value' => $request->records['amount'][$key]==null?0:$request->records['amount'][$key],
                ]);

                GradeWiseSalaryComponentHistory::create([
                    'type_id' => $request->records['type'][$key],
                    'grade_id' => $request->grade_id,
                    'date' => $new_date,
                    'salary_component_id' => $request->records['head'][$key],
                    'value' => $request->records['amount'][$key]==null?0:$request->records['amount'][$key],
                ]);
            }
            $notification= array(
                'message'       => 'Update successfully!',
                'alert-type'    => 'success'
            );
        }else{
            $notification= array(
                'message'       => 'Please check atleast one Item!',
                'alert-type'    => 'warning'
            );
        }




        return redirect('grade-wise-salary-components')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $salaryStructure = GradeWiseSalaryComponent::find($id);
        $salaryStructure->delete();
        $notification = array(
            'message'       => 'Deleted successfully!',
            'alert-type'    => 'success'
        );
        return redirect('grade-wise-salary-components')->with($notification);
    }
}
