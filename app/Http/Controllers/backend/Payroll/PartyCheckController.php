<?php

namespace App\Http\Controllers\backend\Payroll;

use App\Http\Controllers\Controller;
use App\Mapping;
use App\Models\Payroll\SalaryType;
use App\Models\AccountHead;
use App\Models\Payroll\Department;
use App\Models\Payroll\Division;
use App\Models\Payroll\Employee;
use App\Models\Payroll\Nationality;
use App\PartyInfo;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;

class PartyCheckController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //Gate::authorize('app.mapping.index');
        $items = Employee::orderBy('id', 'desc')->get();

        foreach ( $items as $key => $temp) {
            $party = PartyInfo::where('emp_id', $temp->id)->first();
            if(!$party){
                //party create
                $latest = PartyInfo::withTrashed()->orderBy('id', 'DESC')->first();

                if ($latest) {
                    $pi_code = preg_replace('/^PI-/', '', $latest->pi_code);
                    ++$pi_code;
                } else {
                    $pi_code = 1;
                }
                if ($pi_code < 10) {
                    $cc = "PI-000" . $pi_code;
                } elseif ($pi_code < 100) {
                    $cc = "PI-00" . $pi_code;
                } elseif ($pi_code < 1000) {
                    $cc = "PI-0" . $pi_code;
                } else {
                    $cc = "PI-" . $pi_code;
                }

                $draftCost = new PartyInfo();
                $draftCost->pi_code = $cc;
                $draftCost->emp_id = $temp->id;
                $draftCost->pi_name = $temp->salutation . ' ' . $temp->first_name . ' ' . $temp->middle_name . ' ' . $temp->last_name;
                $draftCost->pi_type = 'Employee';
                $draftCost->address = $temp->parmanent_address . ' ' . $temp->pa_city . ' ' . $temp->pa_country;
                $draftCost->con_person = $temp->em_name;
                $draftCost->con_no = $temp->em_country_code . $temp->em_contact_number;
                $draftCost->phone_no = $temp->country_code . $temp->ontact_number;
                $draftCost->email = $temp->email;
                $draftCost->save();

                // dd($draftCost);
            }
        }

        // $accoutHeads = AccountHead::all();
        // dd($facitities);
        // return view('backend.payroll.department.index', compact('items', 'divisions'));
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
        Department::create([
            'division_id' => $request->division_id,
            'name' => $request->name
        ]);
        $notification= array(
            'message'       => 'Designation Added successfully!',
            'alert-type'    => 'success'
        );
        return redirect('hr/payroll/department')->with($notification);
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

        $info = Department::find($id);
        $items = Department::orderBy('id', 'desc')->get();
        $divisions = Division::orderBy('id', 'desc')->get();
        return Response()->json([
            'page' => view('backend.payroll.department.edit-modal', ['info' => $info,
                                                                     'items' => $items,
                                                                     'divisions' => $divisions])->render(),

        ]);
        // return view('backend.payroll.department.edit', compact('info', 'items'));
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
        // dd(1);
        $request->validate([
            'name' => 'required',
        ]);
        Department::find($id)->update([
            'division_id' => $request->division_id,
            'name' => $request->name,
        ]);
        $notification= array(
            'message'       => 'Designation Updated Successfully!',
            'alert-type'    => 'success'
        );
        return redirect('hr/payroll/department')->with($notification);
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
}
