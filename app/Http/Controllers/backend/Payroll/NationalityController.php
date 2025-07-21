<?php

namespace App\Http\Controllers\backend\Payroll;

use App\Http\Controllers\Controller;
use App\Mapping;
use App\Models\Payroll\SalaryType;
use App\Models\AccountHead;
use App\Models\Payroll\Nationality;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;

class NationalityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        //Gate::authorize('app.mapping.index');
        $nationalities = Nationality::orderBy('id', 'desc')->get();
        // $accoutHeads = AccountHead::all();
        // dd($facitities);
        return view('backend.payroll.nationality.index', compact('nationalities'));
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
            'name' => 'required',
        ]);
        Nationality::create([
            'name' => $request->name
        ]);
        $notification= array(
            'message'       => 'Nationality Added successfully!',
            'alert-type'    => 'success'
        );
        return redirect('nationality')->with($notification);
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
        
        $nationality_info = Nationality::find($id);
        $nationalities = Nationality::orderBy('id', 'desc')->get();
        return Response()->json([
            'page' => view('backend.payroll.nationality.edit-modal', ['nationality_info' => $nationality_info,
                                                                            'nationalities' => $nationalities])->render(),

        ]);
        // return view('backend.payroll.nationality.edit', compact('nationality_info', 'nationalities'));
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
            'name' => 'required',
        ]);
        Nationality::find($id)->update([
            'name' => $request->name,
        ]);
        $notification= array(
            'message'       => 'Nationality Update successfully!',
            'alert-type'    => 'success'
        );
        return redirect('nationality')->with($notification);
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
