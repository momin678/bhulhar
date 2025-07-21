<?php

namespace App\Http\Controllers\backend\Payroll;

use App\Http\Controllers\Controller;
use App\Mapping;
use App\Models\Payroll\SalaryType;
use App\Models\AccountHead;
use App\Models\Payroll\Grade;
use App\Models\Payroll\GradeWiseLiveList;
use App\Models\Payroll\Nationality;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;

class GradeWiseLeaveListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        //Gate::authorize('app.mapping.index');
        $liveList = GradeWiseLiveList::orderBy('id', 'desc')->get();
        $grades = Grade::get();
        // $accoutHeads = AccountHead::all();
        // dd($facitities);
        return view('backend.payroll.grade_wise_leave_list.index', compact('liveList', 'grades'));
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
        // dd($request);
        $request->validate([
            'grade_id' => 'required',
        ]);
        GradeWiseLiveList::create([
            'grade_id' => $request->grade_id,
            'casual_leave' => $request->casual_leave,
            'sick_leave' => $request->sick_leave,
            'anual_leave' => $request->anual_leave,
            'without_pay_leave' => $request->without_pay_leave,
        ]);
        $notification= array(
            'message'       => 'Added successfully!',
            'alert-type'    => 'success'
        );
        return redirect('grade-wise-leave-list')->with($notification);
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
        
        $leave_info = GradeWiseLiveList::find($id);
        $liveList = GradeWiseLiveList::orderBy('id', 'desc')->get();
        $grades = Grade::get();
        return Response()->json([
            'page' => view('backend.payroll.grade_wise_leave_list.edit-modal', ['leave_info' => $leave_info,
                                                                            'liveList' => $liveList,
                                                                            'grades' => $grades,])->render(),

        ]);
        // return view('backend.payroll.grade_wise_leave_list.edit', compact('leave_info', 'liveList', 'grades'));
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
        $request->validate([
            'grade_id' => 'required',
        ]);
        GradeWiseLiveList::find($id)->update([
            'grade_id' => $request->grade_id,
            'casual_leave' => $request->casual_leave,
            'sick_leave' => $request->sick_leave,
            'anual_leave' => $request->anual_leave,
            'without_pay_leave' => $request->without_pay_leave,
        ]);
        $notification= array(
            'message'       => 'Updated successfully!',
            'alert-type'    => 'success'
        );
        return redirect('grade-wise-leave-list')->with($notification);
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
    public function base()
    {
        
        //Gate::authorize('app.mapping.index');
        // $accoutHeads = AccountHead::all();
        // dd($facitities);
        return view('backend.payroll.nationality.base');
    }
}
