<?php

namespace App\Http\Controllers\backend\Payroll;

use App\Branch;
use App\GroupCompanies;
// use App\Country;
use App\Http\Controllers\Controller;
use App\Models\Payroll\BankBranch;
use App\Models\Payroll\Country;
use App\Models\Payroll\CountryCode;
use App\Models\Payroll\Department;
use App\Models\Payroll\Division;
use App\Models\Payroll\SalaryType;
use App\Models\Payroll\Employee;
use App\Models\Payroll\EmployeeTemp;
use App\Models\Payroll\Grade;
use App\Models\Payroll\Nationality;
use App\Models\Payroll\PorfessionalDocument;
use App\PartyInfo;
use App\Role;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Ui\Presets\React;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

       //Gate::authorize('basic_info');
        $employees = EmployeeTemp::orderBy('id', 'desc');
        $date = Carbon::now()->subYears(10);
        $id = EmployeeTemp::latest()->first();
        $countrytCode = Country::get();
        $countrytCode2 = Country::get();
        $countrytCode3 = Country::get();
        $departments = Department::get();
        $nationalitys = Nationality::get();
        $countries = Country::get();
        $grades = Grade::get();
        $branchs = BankBranch::get();
        $companies = GroupCompanies::get();
        $divisions = Division::get();
        $roles = Role::get();

        $eid_latest = EmployeeTemp::whereYear('created_at', date('Y'))->orderBy('id', 'desc')->first();
        if ($eid_latest) {
            $eid = $eid_latest->emp_id + 1;
        } else {

            $eid_latest = EmployeeTemp::orderBy('id', 'desc')->first();
            if ($eid_latest) {
                $eid = $eid_latest->emp_id + 1;
                $eid = substr($eid, 2, -4);
                $numb = $eid > 99 ? $eid : ($eid > 9 ? '0' . $eid : '00' . $eid);
                $eid = date('Y') . $numb;

                // dd($eid);
            } else {

                $eid = Carbon::now()->format('Y') . '001';
            }
        }

        if($request->search){
            $employees = $employees->where(function ($query) use ($request) {
                if ($request->search) {
                    $searchTerms = explode(' ', $request->search);
                    foreach ($searchTerms as $term) {
                        $term = trim($term); // Remove leading/trailing spaces from each term
                        if (!empty($term)) { // Skip empty terms
                            $query->orWhere(function ($subquery) use ($term) {
                                $subquery->Where('first_name', 'like', '%' . $term . '%');
                                        //  ->orWhere('middle_name', 'like', '%' . $term . '%')
                                        //  ->orWhere('last_name', 'like', '%' . $term . '%');
                            });
                            $query->orWhere('emp_id', 'like', '%' . $term . '%')
                                ->orWhere('contact_number', 'like', '%' . $term . '%')
                                ->orWhere('local_contact_number', 'like', '%' . $term . '%');
                        }
                    }
                }
            });
        }
        $employees = $employees->paginate(15)->withQueryString();
        // dd($EmployeeTemps);
        // $accoutHeads = AccountHead::all();
        $salaryTypes = SalaryType::all();
        return view('backend.payroll.employee.index', compact(
                                                                'employees',
                                                                'salaryTypes',
                                                                'nationalitys',
                                                                'date',
                                                                'eid',
                                                                'countrytCode',
                                                                'departments',
                                                                'grades',
                                                                'countries',
                                                                'branchs',
                                                                'countrytCode2',
                                                                'countrytCode3',
                                                                'companies',
                                                                'divisions',
                                                                'roles'
                                                            ));
    }
    public function teacher(Request $request)
    {

        //Gate::authorize('profile_and_documentation');
        $employees = EmployeeTemp::where('role', 5)->orderBy('id', 'desc')->paginate(15);
        $date = Carbon::now()->subYears(10);
        $id = EmployeeTemp::latest()->first();
        $countrytCode = Country::get();
        $countrytCode2 = Country::get();
        $countrytCode3 = Country::get();
        $departments = Department::get();
        $department = Department::get();
        $nationalitys = Nationality::get();
        $countries = Country::get();
        $grades = Grade::get();
        $branchs = BankBranch::get();
        $companies = GroupCompanies::get();
        $divisions = Division::get();
        $roles = Role::get();

        $eid_latest = EmployeeTemp::whereYear('created_at', date('Y'))->orderBy('id', 'desc')->first();
        if ($eid_latest) {
            $eid = $eid_latest->emp_id + 1;
        } else {

            $eid_latest = EmployeeTemp::orderBy('id', 'desc')->first();
            if ($eid_latest) {
                $eid = $eid_latest->emp_id + 1;
                $eid = substr($eid, 2, -4);
                $numb = $eid > 99 ? $eid : ($eid > 9 ? '0' . $eid : '00' . $eid);
                $eid = date('Y') . $numb;

                // dd($eid);
            } else {

                $eid = Carbon::now()->format('Y') . '001';
            }
        }
        if($request->search){
            $employees = EmployeeTemp::orWhere('first_name', 'like', '%' . $request->search. '%')
            ->orWhere('last_name', 'like', '%' . $request->search . '%')
            ->orWhere('contact_number', 'like', '%' . $request->search . '%')->orWhere('designation', 'like', '%' . $request->search . '%')
            ->orWhere('emp_id', 'like', '%' . $request->search . '%')->where('role', 5)->get();
            $salaryTypes = SalaryType::all();
            return view('backend.teacher-employee.search-index', compact(
                'employees',
                'salaryTypes',
                'nationalitys',
                'date',
                'eid',
                'countrytCode',
                'departments',
                'department',
                'grades',
                'countries',
                'branchs',
                'countrytCode2',
                'countrytCode3',
                'companies',
                'divisions',
                'roles'
            ));
        }
        // dd($EmployeeTemps);
        // $accoutHeads = AccountHead::all();
        $salaryTypes = SalaryType::all();
        return view('backend.teacher-employee.index', compact(
            'employees',
            'salaryTypes',
            'nationalitys',
            'date',
            'eid',
            'countrytCode',
            'departments',
            'department',
            'grades',
            'countries',
            'branchs',
            'countrytCode2',
            'countrytCode3',
            'companies',
            'divisions',
            'roles'
        ));
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
        // dd($request->all());
        $request->validate([
            'first_name' => 'required',
            // 'contact_number' => 'required',
            // 'email' => 'required',
            // 'father_name' => 'required',
            // 'mother_name' => 'required',
            // 'present_address' => 'required',
            // 'parmanent_address' => 'required',
            // 'dob' => 'required',
            // 'nid_number' => 'required',
            // 'nationality' => 'required',
            // 'department' => 'required',
            // 'designation' => 'required',
            // 'joining_date' => 'required',
            // 'emirates_id' => 'required',
            // 'passport_number' => 'required',
            // 'visa_expiry_date' => 'required',
            // 'employee_wage_type' => 'required',
        ]);

        // $post_quali=$request->input('group_a');
        // dd($request->group_a);
        if ($request->group_a) {
            if ($request->group_a['1']['post_name']) {
                foreach ($request->group_a as $key => $value) {
                    if ($request->group_a[$key]['post_quali_image']) {
                        $name = $request->group_a[$key]['post_quali_image']->getClientOriginalName();
                        $name = pathinfo($name, PATHINFO_FILENAME);
                        $ext = $request->group_a[$key]['post_quali_image']->getClientOriginalExtension();
                        $employee_image = $request->eid . $request->name . $request->group_a[$key]['post_name'] . time() . '.' . $ext;

                        $request->group_a[$key]['post_quali_image']->storeAs('public/upload/employee/post_quali', $employee_image);
                    }
                    PorfessionalDocument::create([
                        'employee_id' => $request->eid,
                        'image' => $employee_image,
                        'name' => $request->group_a[$key]['post_name'],
                    ]);
                }
            }
        }

        // dd($request->all());

        if ($request->file('employee_image')) {
            $name = $request->file('employee_image')->getClientOriginalName();
            $name = pathinfo($name, PATHINFO_FILENAME);
            $ext = $request->file('employee_image')->getClientOriginalExtension();
            $employee_image = 'employee_image' . time() . '.' . $ext;

            $request->file('employee_image')->storeAs('public/upload/employee', $employee_image);
        }

        if ($request->file('emirates_image')) {
            $name = $request->file('emirates_image')->getClientOriginalName();
            $name = pathinfo($name, PATHINFO_FILENAME);
            $ext = $request->file('emirates_image')->getClientOriginalExtension();
            $emirates_image = 'emirates_image' . time() . '.' . $ext;

            $request->file('emirates_image')->storeAs('public/upload/employee', $emirates_image);
        }

        if ($request->file('passport_image')) {
            $name = $request->file('passport_image')->getClientOriginalName();
            $name = pathinfo($name, PATHINFO_FILENAME);
            $ext = $request->file('passport_image')->getClientOriginalExtension();
            $passport_image = 'passport_image' . time() . '.' . $ext;

            $request->file('passport_image')->storeAs('public/upload/employee', $passport_image);
        }

        if ($request->file('quali_image')) {
            $name = $request->file('quali_image')->getClientOriginalName();
            $name = pathinfo($name, PATHINFO_FILENAME);
            $ext = $request->file('quali_image')->getClientOriginalExtension();
            $quali_image = 'quali_image' . time() . '.' . $ext;

            $request->file('quali_image')->storeAs('public/upload/employee', $quali_image);
        }

        //dob
        // $old_date = explode('/', $request->dob);

        // $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
        // $new_date = date('Y-m-d', strtotime($new_data));
        // $dob = \DateTime::createFromFormat("Y-m-d", $new_date);

        //joining_date
        $old_date = explode('/', $request->joining_date);

        $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
        $new_date = date('Y-m-d', strtotime($new_data));
        $joining_date = \DateTime::createFromFormat("Y-m-d", $new_date);

        //$request->visa_expiry_date

        $old_date = explode('/', $request->visa_expiry_date);

        $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
        $new_date = date('Y-m-d', strtotime($new_data));
        $visa_expiry_date = \DateTime::createFromFormat("Y-m-d", $new_date);

        EmployeeTemp::create([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'full_name' => $request->salutation.' '.$request->first_name,
            'first_lang' => $request->first_language,
            'second_lang' => $request->second_language,
            'salutation' => $request->salutation,
            'emp_id' => $request->eid,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'dob' => $request->dob,
            'nationality' => $request->nationality,
            'employee_image' => $employee_image,
            'job_type' => $request->job_type,

            'present_address' => $request->present_address,
            'pr_city' => $request->pr_city,
            'pr_country' => $request->pr_country,
            'parmanent_address' => $request->parmanent_address,
            'pa_city' => $request->pa_city,
            'pa_country' => $request->pa_country,
            'country_code' => $request->countrytCode,
            'contact_number' => $request->contact_number,
            'local_country_code' => $request->local_countrytCode,
            'local_contact_number' => $request->local_contact_number,
            'prefered_com' => $request->prefered_communication,
            'email' => $request->email,

            'em_name' => $request->em_name,
            'em_parmanent_address' => $request->em_parmanent_address,
            'em_country_code' => $request->em_countrytCode,
            'em_contact_number' => $request->em_contact_number,
            'em_email' => $request->em_email,

            'r_name' => $request->r_name,
            'r_parmanent_address' => $request->r_parmanent_address,
            'r_country_code' => $request->r_countrytCode,
            'r_contact_number' => $request->r_contact_number,
            'r_email' => $request->r_email,

            'emirates_id' => $request->emirates_id,
            // 'emirates_image' => $emirates_image,
            'passport_number' => $request->passport_number,
            // 'passport_image' => $passport_image,
            'visa_number' => $request->visa_number,
            'visa_type' => $request->visa_type,
            'pass_issue_country' => $request->pass_issue_country,
            'visa_issue_country' => $request->visa_issue_country,

            'company' => $request->company,
            'division' => $request->division,
            'department' => $request->department,
            'designation' => $request->designation,
            'joining_date' => $joining_date,
            'role' => $request->division==6?5:null,

            'qualification' => $request->qualification,
            'passing_year' => $request->passing_year,
            'institution_name' => $request->institution_name,
            'qualification_country' => $request->qualification_country,
            // 'quali_image' => $quali_image,

            'bank_name' => $request->bank_name,
            'branch_name' => $request->branch_name,
            'account_number' => $request->account_number,
            'ibal_number' => $request->ibal_number,
            'routing_number' => $request->routing_number,
            'swift_code' => $request->swift_code,

            'status' => 0,

            'visa_expiry_date' => $visa_expiry_date,
            'employee_wage_type' => $request->employee_wage_type,
            'employment_location' => $request->employment_location,
            'currency' => $request->currency,
            'payment_method' => $request->payment_method,
            'grade' => $request->grade,

            'description' => $request->description,
            'sub_description' => $request->sub_description,
        ]);


        $notification = array(
            'message'       => 'Employee Added successfully!',
            'alert-type'    => 'success'
        );
        return redirect('hr/payroll/employees')->with($notification);
    }

    public function teacher_store(Request $request)
    {
         // dd($request->all());
         $request->validate([
            'first_name' => 'required',
            // 'contact_number' => 'required',
            'email' => 'required|unique:employee_temps,email',
            // 'father_name' => 'required',
            // 'mother_name' => 'required',
            // 'present_address' => 'required',
            // 'parmanent_address' => 'required',
            // 'dob' => 'required',
            // 'nid_number' => 'required',
            // 'nationality' => 'required',
            // 'department' => 'required',
            // 'designation' => 'required',
            // 'joining_date' => 'required',
            // 'emirates_id' => 'required',
            // 'passport_number' => 'required',
            // 'visa_expiry_date' => 'required',
            // 'employee_wage_type' => 'required',
        ]);

        // $post_quali=$request->input('group_a');
        // dd($request->group_a);
        if ($request->group_a) {
            if ($request->group_a['1']['post_name']) {
                foreach ($request->group_a as $key => $value) {
                    if ($request->group_a[$key]['post_quali_image']) {
                        $name = $request->group_a[$key]['post_quali_image']->getClientOriginalName();
                        $name = pathinfo($name, PATHINFO_FILENAME);
                        $ext = $request->group_a[$key]['post_quali_image']->getClientOriginalExtension();
                        $employee_image = $request->eid . $request->name . $request->group_a[$key]['post_name'] . time() . '.' . $ext;

                        $request->group_a[$key]['post_quali_image']->storeAs('public/upload/employee/post_quali', $employee_image);
                    }
                    PorfessionalDocument::create([
                        'employee_id' => $request->eid,
                        'image' => $employee_image,
                        'name' => $request->group_a[$key]['post_name'],
                    ]);
                }
            }
        }

        // dd($request->all());

        if ($request->file('employee_image')) {
            $name = $request->file('employee_image')->getClientOriginalName();
            $name = pathinfo($name, PATHINFO_FILENAME);
            $ext = $request->file('employee_image')->getClientOriginalExtension();
            $employee_image = 'employee_image' . time() . '.' . $ext;

            $request->file('employee_image')->storeAs('public/upload/employee', $employee_image);
        }

        if ($request->file('emirates_image')) {
            $name = $request->file('emirates_image')->getClientOriginalName();
            $name = pathinfo($name, PATHINFO_FILENAME);
            $ext = $request->file('emirates_image')->getClientOriginalExtension();
            $emirates_image = 'emirates_image' . time() . '.' . $ext;

            $request->file('emirates_image')->storeAs('public/upload/employee', $emirates_image);
        }

        if ($request->file('passport_image')) {
            $name = $request->file('passport_image')->getClientOriginalName();
            $name = pathinfo($name, PATHINFO_FILENAME);
            $ext = $request->file('passport_image')->getClientOriginalExtension();
            $passport_image = 'passport_image' . time() . '.' . $ext;

            $request->file('passport_image')->storeAs('public/upload/employee', $passport_image);
        }

        if ($request->file('quali_image')) {
            $name = $request->file('quali_image')->getClientOriginalName();
            $name = pathinfo($name, PATHINFO_FILENAME);
            $ext = $request->file('quali_image')->getClientOriginalExtension();
            $quali_image = 'quali_image' . time() . '.' . $ext;

            $request->file('quali_image')->storeAs('public/upload/employee', $quali_image);
        }

        //dob
        // $old_date = explode('/', $request->dob);

        // $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
        // $new_date = date('Y-m-d', strtotime($new_data));
        // $dob = \DateTime::createFromFormat("Y-m-d", $new_date);

        //joining_date
        $old_date = explode('/', $request->joining_date);

        $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
        $new_date = date('Y-m-d', strtotime($new_data));
        $joining_date = \DateTime::createFromFormat("Y-m-d", $new_date);

        //$request->visa_expiry_date

        $old_date = explode('/', $request->visa_expiry_date);

        $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
        $new_date = date('Y-m-d', strtotime($new_data));
        $visa_expiry_date = \DateTime::createFromFormat("Y-m-d", $new_date);


        EmployeeTemp::create([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'full_name' => $request->salutation.' '.$request->first_name,
            'first_lang' => $request->first_language,
            'second_lang' => $request->second_language,
            'salutation' => $request->salutation,
            'emp_id' => $request->eid,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'dob' => $request->dob,
            'nationality' => $request->nationality,
            'employee_image' => $employee_image,
            'job_type' => $request->job_type,

            'present_address' => $request->present_address,
            'pr_city' => $request->pr_city,
            'pr_country' => $request->pr_country,
            'parmanent_address' => $request->parmanent_address,
            'pa_city' => $request->pa_city,
            'pa_country' => $request->pa_country,
            'country_code' => $request->countrytCode,
            'contact_number' => $request->contact_number,
            'local_country_code' => $request->local_countrytCode,
            'local_contact_number' => $request->local_contact_number,
            'prefered_com' => $request->prefered_communication,
            'email' => $request->email,

            'em_name' => $request->em_name,
            'em_parmanent_address' => $request->em_parmanent_address,
            'em_country_code' => $request->em_countrytCode,
            'em_contact_number' => $request->em_contact_number,
            'em_email' => $request->em_email,

            'r_name' => $request->r_name,
            'r_parmanent_address' => $request->r_parmanent_address,
            'r_country_code' => $request->r_countrytCode,
            'r_contact_number' => $request->r_contact_number,
            'r_email' => $request->r_email,

            'emirates_id' => $request->emirates_id,
            // 'emirates_image' => $emirates_image,
            'passport_number' => $request->passport_number,
            // 'passport_image' => $passport_image,
            'visa_number' => $request->visa_number,
            'visa_type' => $request->visa_type,
            'pass_issue_country' => $request->pass_issue_country,
            'visa_issue_country' => $request->visa_issue_country,

            'company' => $request->company,
            'division' => 6,
            'department' => $request->department,
            'designation' => $request->designation,
            'joining_date' => $joining_date,
            'role' => 5,

            'qualification' => $request->qualification,
            'passing_year' => $request->passing_year,
            'institution_name' => $request->institution_name,
            'qualification_country' => $request->qualification_country,
            // 'quali_image' => $quali_image,

            'bank_name' => $request->bank_name,
            'branch_name' => $request->branch_name,
            'account_number' => $request->account_number,
            'ibal_number' => $request->ibal_number,
            'routing_number' => $request->routing_number,
            'swift_code' => $request->swift_code,

            'status' => 0,

            'visa_expiry_date' => $visa_expiry_date,
            'employee_wage_type' => $request->employee_wage_type,
            'employment_location' => $request->employment_location,
            'currency' => $request->currency,
            'payment_method' => $request->payment_method,
            'grade' => $request->grade,

            'description' => $request->description,
            'sub_description' => $request->sub_description,
        ]);


        $notification = array(
            'message'       => 'Added successfully!',
            'alert-type'    => 'success'
        );
        return redirect()->back()->with($notification);
    }


    // $table->string('bank_name');
    // $table->unsignedBigInteger('branch_name');
    // $table->string('account_number');
    // $table->string('ibal_number');
    // $table->string('routing_number');
    // $table->string('swift_code');

    // $table->string('visa_expiry_date');
    // $table->string('payment_method');
    // $table->unsignedBigInteger('employee_wage_type');
    // $table->unsignedBigInteger('grade');

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee_info = EmployeeTemp::find($id);
        $salaryTypes = SalaryType::all();
        $countrytCode = Country::get();
        $countrytCode2 = Country::get();
        $countrytCode3 = Country::get();
        $department = Department::get();
        $nationality = Nationality::get();
        $grades = Grade::get();
        $countries = Country::get();
        $branchs = BankBranch::get();
        $companies = GroupCompanies::get();
        $divisions = Division::get();
        $roles = Role::get();

        $pro_quali = PorfessionalDocument::where('employee_id', $employee_info->emp_id)->get();


        return Response()->json([
            'page' => view('backend.payroll.employee.view-modal', [
                'employee_info' => $employee_info,
                'salaryTypes' => $salaryTypes,
                'countrytCode' => $countrytCode,
                'department' => $department,
                'nationality' => $nationality,
                'grades' => $grades,
                'countries' => $countries,
                'branchs' => $branchs,
                'countrytCode2' => $countrytCode2,
                'countrytCode3' => $countrytCode3,
                'pro_quali' => $pro_quali,
                'companies' => $companies,
                'divisions' => $divisions,
                'roles' => $roles
            ])->render(),

        ]);
    }
    public function teacher_show($id)
    {
        $employee_info = EmployeeTemp::find($id);
        $salaryTypes = SalaryType::all();
        $countrytCode = Country::get();
        $countrytCode2 = Country::get();
        $countrytCode3 = Country::get();
        $department = Department::get();
        $nationality = Nationality::get();
        $grades = Grade::get();
        $countries = Country::get();
        $branchs = BankBranch::get();
        $companies = GroupCompanies::get();
        $divisions = Division::get();
        $roles = Role::get();

        $pro_quali = PorfessionalDocument::where('employee_id', $employee_info->emp_id)->get();


        return Response()->json([
            'page' => view('backend..teacher-employee.view-modal', [
                'employee_info' => $employee_info,
                'salaryTypes' => $salaryTypes,
                'countrytCode' => $countrytCode,
                'department' => $department,
                'nationality' => $nationality,
                'grades' => $grades,
                'countries' => $countries,
                'branchs' => $branchs,
                'countrytCode2' => $countrytCode2,
                'countrytCode3' => $countrytCode3,
                'pro_quali' => $pro_quali,
                'companies' => $companies,
                'divisions' => $divisions,
                'roles' => $roles
            ])->render(),

        ]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee_info = EmployeeTemp::find($id);
        $salaryTypes = SalaryType::all();
        $countrytCode = Country::get();
        $countrytCode2 = Country::get();
        $countrytCode3 = Country::get();
        $department = Department::get();
        $nationality = Nationality::get();
        $grades = Grade::get();
        $countries = Country::get();
        $branchs = BankBranch::get();
        $companies = GroupCompanies::get();
        $divisions = Division::get();
        $roles = Role::get();
        $pro_quali = PorfessionalDocument::where('employee_id', $employee_info->emp_id)->get();
        // $accoutHeads = AccountHead::all();
        // return view('backend.payroll.employee.edit-modal', compact( 'employee_info','salaryTypes',
        //     'countrytCode','department','nationality','grades', 'countries','branchs'));

        // dd($employee_info->emp_id);

        return Response()->json([
            'page' => view('backend.payroll.employee.edit-modal', [
                'employee_info' => $employee_info,
                'salaryTypes' => $salaryTypes,
                'countrytCode' => $countrytCode,
                'department' => $department,
                'nationality' => $nationality,
                'grades' => $grades,
                'countries' => $countries,
                'branchs' => $branchs,
                'countrytCode2' => $countrytCode2,
                'countrytCode3' => $countrytCode3,
                'pro_quali' => $pro_quali,
                'companies' => $companies,
                'divisions' => $divisions,
                'roles' => $roles,

            ])->render(),

        ]);
    }
    public function teacher_edit($id)
    {

        $employee_info = EmployeeTemp::find($id);
        $salaryTypes = SalaryType::all();
        $countrytCode = Country::get();
        $countrytCode2 = Country::get();
        $countrytCode3 = Country::get();
        $department = Department::get();
        $nationality = Nationality::get();
        $grades = Grade::get();
        $countries = Country::get();
        $branchs = BankBranch::get();
        $companies = GroupCompanies::get();
        $divisions = Division::get();
        $roles = Role::get();
        $pro_quali = PorfessionalDocument::where('employee_id', $employee_info->emp_id)->get();
        // $accoutHeads = AccountHead::all();
        // return view('backend.payroll.employee.edit-modal', compact( 'employee_info','salaryTypes',
        //     'countrytCode','department','nationality','grades', 'countries','branchs'));

        // dd($employee_info->emp_id);

        return Response()->json([
            'page' => view('backend.teacher-employee.edit-modal', [
                'employee_info' => $employee_info,
                'salaryTypes' => $salaryTypes,
                'countrytCode' => $countrytCode,
                'department' => $department,
                'nationality' => $nationality,
                'grades' => $grades,
                'countries' => $countries,
                'branchs' => $branchs,
                'countrytCode2' => $countrytCode2,
                'countrytCode3' => $countrytCode3,
                'pro_quali' => $pro_quali,
                'companies' => $companies,
                'divisions' => $divisions,
                'roles' => $roles,

            ])->render(),

        ]);
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
        // dd($request->company);

        // dd($request->group_a['1']['post_name']);
        $request->validate([
            'first_name' => 'required',
            // 'contact_number' => 'required',
            // 'email' => 'required',
            // 'father_name' => 'required',
            // 'mother_name' => 'required',
            // 'present_address' => 'required',
            // 'parmanent_address' => 'required',
            // 'dob' => 'required',
            // 'nid_number' => 'required',
            // 'nationality' => 'required',
            // 'department' => 'required',
            // 'designation' => 'required',
            // 'joining_date' => 'required',
            // 'emirates_id' => 'required',
            // 'passport_number' => 'required',
            // 'visa_expiry_date' => 'required',
            // 'employee_wage_type' => 'required',
        ]);
        if ($request->group_a) {
            if ($request->group_a['1']['post_name']) {
                foreach ($request->group_a as $key => $value) {
                    if ($request->group_a[$key]['post_quali_image']) {
                        $name = $request->group_a[$key]['post_quali_image']->getClientOriginalName();
                        $name = pathinfo($name, PATHINFO_FILENAME);
                        $ext = $request->group_a[$key]['post_quali_image']->getClientOriginalExtension();
                        $employee_image = $request->eid . $request->name . $request->group_a[$key]['post_name'] . time() . '.' . $ext;

                        $request->group_a[$key]['post_quali_image']->storeAs('public/upload/employee/post_quali', $employee_image);
                    }
                    PorfessionalDocument::create([
                        'employee_id' => $request->eid,
                        'image' => $employee_image,
                        'name' => $request->group_a[$key]['post_name'],
                    ]);
                }
            }
        }


        if ($request->file('employee_image')) {

            $path = public_path('storage/upload/employee/') . $request->old_employee_image;
            if (file_exists($path)) {
                unlink($path);
            }

            $name = $request->file('employee_image')->getClientOriginalName();
            $name = pathinfo($name, PATHINFO_FILENAME);
            $ext = $request->file('employee_image')->getClientOriginalExtension();
            $employee_image = 'employee_image' . time() . '.' . $ext;

            $request->file('employee_image')->storeAs('public/upload/employee', $employee_image);
        } else {
            $employee_image = $request->old_employee_image;
        }

        if ($request->file('emirates_image')) {

            $path = public_path('storage/upload/employee/') . $request->old_emirates_image;
            if (file_exists($path)) {
                unlink($path);
            }

            $name = $request->file('emirates_image')->getClientOriginalName();
            $name = pathinfo($name, PATHINFO_FILENAME);
            $ext = $request->file('emirates_image')->getClientOriginalExtension();
            $emirates_image = 'emirates_image' . time() . '.' . $ext;

            $request->file('emirates_image')->storeAs('public/upload/employee', $emirates_image);
        } else {
            $emirates_image = $request->old_emirates_image;
        }

        if ($request->file('passport_image')) {

            $path = public_path('storage/upload/employee/') . $request->old_passport_image;
            if (file_exists($path)) {
                unlink($path);
            }

            $name = $request->file('passport_image')->getClientOriginalName();
            $name = pathinfo($name, PATHINFO_FILENAME);
            $ext = $request->file('passport_image')->getClientOriginalExtension();
            $passport_image = 'passport_image' . time() . '.' . $ext;

            $request->file('passport_image')->storeAs('public/upload/employee', $passport_image);
        } else {
            $passport_image = $request->old_passport_image;
        }

        if ($request->file('quali_image')) {

            $path = public_path('storage/upload/employee/') . $request->old_quali_image;
            if (file_exists($path)) {
                unlink($path);
            }

            $name = $request->file('quali_image')->getClientOriginalName();
            $name = pathinfo($name, PATHINFO_FILENAME);
            $ext = $request->file('quali_image')->getClientOriginalExtension();
            $quali_image = 'quali_image' . time() . '.' . $ext;

            $request->file('quali_image')->storeAs('public/upload/employee', $quali_image);
        } else {
            $quali_image = $request->old_quali_image;
        }

        //dob
        // $old_date = explode('/', $request->dob);

        // $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
        // $new_date = date('Y-m-d', strtotime($new_data));
        // $dob = \DateTime::createFromFormat("Y-m-d", $new_date);

        //joining_date
        $old_date = explode('/', $request->joining_date);

        $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
        $new_date = date('Y-m-d', strtotime($new_data));
        $joining_date = \DateTime::createFromFormat("Y-m-d", $new_date);

        //$request->visa_expiry_date

        $old_date = explode('/', $request->visa_expiry_date);

        $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
        $new_date = date('Y-m-d', strtotime($new_data));
        $visa_expiry_date = \DateTime::createFromFormat("Y-m-d", $new_date);

        EmployeeTemp::find($id)->update([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'full_name' => $request->salutation.' '.$request->first_name,
            'first_lang' => $request->first_language,
            'second_lang' => $request->second_language,
            'salutation' => $request->salutation,
            'emp_id' => $request->eid,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            // 'dob' => $dob,
            'nationality' => $request->nationality,
            'employee_image' => $employee_image,

            'present_address' => $request->present_address,
            'pr_city' => $request->pr_city,
            'pr_country' => $request->pr_country,
            'parmanent_address' => $request->parmanent_address,
            'pa_city' => $request->pa_city,
            'pa_country' => $request->pa_country,
            'country_code' => $request->countrytCode,
            'contact_number' => $request->contact_number,
            'local_country_code' => $request->local_countrytCode,
            'local_contact_number' => $request->local_contact_number,
            'prefered_com' => $request->prefered_communication,
            'email' => $request->email,

            'em_name' => $request->em_name,
            'em_parmanent_address' => $request->em_parmanent_address,
            'em_country_code' => $request->em_countrytCode,
            'em_contact_number' => $request->em_contact_number,
            'em_email' => $request->em_email,

            'r_name' => $request->r_name,
            'r_parmanent_address' => $request->r_parmanent_address,
            'r_country_code' => $request->r_countrytCode,
            'r_contact_number' => $request->r_contact_number,
            'r_email' => $request->r_email,

            'emirates_id' => $request->emirates_id,
            // 'emirates_image' => $emirates_image,
            'passport_number' => $request->passport_number,
            // 'passport_image' => $passport_image,
            'visa_number' => $request->visa_number,
            'visa_type' => $request->visa_type,
            'pass_issue_country' => $request->pass_issue_country,
            'visa_issue_country' => $request->visa_issue_country,

            'company' => $request->company,
            'division' => $request->division,
            'department' => $request->department,
            'designation' => $request->designation,
            'joining_date' => $joining_date,
            'role' => $request->division==6?5:null,

            'qualification' => $request->qualification,
            'job_type' => $request->job_type,
            // 'quali_image' => $quali_image,

            'bank_name' => $request->bank_name,
            'branch_name' => $request->branch_name,
            'account_number' => $request->account_number,
            'ibal_number' => $request->ibal_number,
            'routing_number' => $request->routing_number,
            'swift_code' => $request->swift_code,

            'status' => 2,

            'visa_expiry_date' => $visa_expiry_date,
            'employee_wage_type' => $request->employee_wage_type,
            'employment_location' => $request->employment_location,
            'currency' => $request->currency,
            'payment_method' => $request->payment_method,
            'grade' => $request->grade,

            'description' => $request->description,
            'sub_description' => $request->sub_description,
        ]);
        $notification = array(
            'message'       => 'Employee Update successfully!',
            'alert-type'    => 'success'
        );
        return redirect('hr/payroll/employees')->with($notification);
    }
    public function teacher_update(Request $request, $id)
    {

       // dd($request->company);

        // dd($request->group_a['1']['post_name']);
        $request->validate([
            'first_name' => 'required',
            // 'contact_number' => 'required',
            // 'email' => 'required',
            // 'father_name' => 'required',
            // 'mother_name' => 'required',
            // 'present_address' => 'required',
            // 'parmanent_address' => 'required',
            // 'dob' => 'required',
            // 'nid_number' => 'required',
            // 'nationality' => 'required',
            // 'department' => 'required',
            // 'designation' => 'required',
            // 'joining_date' => 'required',
            // 'emirates_id' => 'required',
            // 'passport_number' => 'required',
            // 'visa_expiry_date' => 'required',
            // 'employee_wage_type' => 'required',
        ]);
        if ($request->group_a) {
            if ($request->group_a['1']['post_name']) {
                foreach ($request->group_a as $key => $value) {
                    if ($request->group_a[$key]['post_quali_image']) {
                        $name = $request->group_a[$key]['post_quali_image']->getClientOriginalName();
                        $name = pathinfo($name, PATHINFO_FILENAME);
                        $ext = $request->group_a[$key]['post_quali_image']->getClientOriginalExtension();
                        $employee_image = $request->eid . $request->name . $request->group_a[$key]['post_name'] . time() . '.' . $ext;

                        $request->group_a[$key]['post_quali_image']->storeAs('public/upload/employee/post_quali', $employee_image);
                    }
                    PorfessionalDocument::create([
                        'employee_id' => $request->eid,
                        'image' => $employee_image,
                        'name' => $request->group_a[$key]['post_name'],
                    ]);
                }
            }
        }


        if ($request->file('employee_image')) {

            $path = public_path('storage/upload/employee/') . $request->old_employee_image;
            if (file_exists($path)) {
                unlink($path);
            }

            $name = $request->file('employee_image')->getClientOriginalName();
            $name = pathinfo($name, PATHINFO_FILENAME);
            $ext = $request->file('employee_image')->getClientOriginalExtension();
            $employee_image = 'employee_image' . time() . '.' . $ext;

            $request->file('employee_image')->storeAs('public/upload/employee', $employee_image);
        } else {
            $employee_image = $request->old_employee_image;
        }

        if ($request->file('emirates_image')) {

            $path = public_path('storage/upload/employee/') . $request->old_emirates_image;
            if (file_exists($path)) {
                unlink($path);
            }

            $name = $request->file('emirates_image')->getClientOriginalName();
            $name = pathinfo($name, PATHINFO_FILENAME);
            $ext = $request->file('emirates_image')->getClientOriginalExtension();
            $emirates_image = 'emirates_image' . time() . '.' . $ext;

            $request->file('emirates_image')->storeAs('public/upload/employee', $emirates_image);
        } else {
            $emirates_image = $request->old_emirates_image;
        }

        if ($request->file('passport_image')) {

            $path = public_path('storage/upload/employee/') . $request->old_passport_image;
            if (file_exists($path)) {
                unlink($path);
            }

            $name = $request->file('passport_image')->getClientOriginalName();
            $name = pathinfo($name, PATHINFO_FILENAME);
            $ext = $request->file('passport_image')->getClientOriginalExtension();
            $passport_image = 'passport_image' . time() . '.' . $ext;

            $request->file('passport_image')->storeAs('public/upload/employee', $passport_image);
        } else {
            $passport_image = $request->old_passport_image;
        }

        if ($request->file('quali_image')) {

            $path = public_path('storage/upload/employee/') . $request->old_quali_image;
            if (file_exists($path)) {
                unlink($path);
            }

            $name = $request->file('quali_image')->getClientOriginalName();
            $name = pathinfo($name, PATHINFO_FILENAME);
            $ext = $request->file('quali_image')->getClientOriginalExtension();
            $quali_image = 'quali_image' . time() . '.' . $ext;

            $request->file('quali_image')->storeAs('public/upload/employee', $quali_image);
        } else {
            $quali_image = $request->old_quali_image;
        }

        //dob
        // $old_date = explode('/', $request->dob);

        // $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
        // $new_date = date('Y-m-d', strtotime($new_data));
        // $dob = \DateTime::createFromFormat("Y-m-d", $new_date);

        //joining_date
        $old_date = explode('/', $request->joining_date);

        $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
        $new_date = date('Y-m-d', strtotime($new_data));
        $joining_date = \DateTime::createFromFormat("Y-m-d", $new_date);

        //$request->visa_expiry_date

        $old_date = explode('/', $request->visa_expiry_date);

        $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
        $new_date = date('Y-m-d', strtotime($new_data));
        $visa_expiry_date = \DateTime::createFromFormat("Y-m-d", $new_date);

        EmployeeTemp::find($id)->update([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'full_name' => $request->salutation.' '.$request->first_name,
            'first_lang' => $request->first_language,
            'second_lang' => $request->second_language,
            'salutation' => $request->salutation,
            'emp_id' => $request->eid,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            // 'dob' => $dob,
            'nationality' => $request->nationality,
            'employee_image' => $employee_image,

            'present_address' => $request->present_address,
            'pr_city' => $request->pr_city,
            'pr_country' => $request->pr_country,
            'parmanent_address' => $request->parmanent_address,
            'pa_city' => $request->pa_city,
            'pa_country' => $request->pa_country,
            'country_code' => $request->countrytCode,
            'contact_number' => $request->contact_number,
            'local_country_code' => $request->local_countrytCode,
            'local_contact_number' => $request->local_contact_number,
            'prefered_com' => $request->prefered_communication,
            'email' => $request->email,

            'em_name' => $request->em_name,
            'em_parmanent_address' => $request->em_parmanent_address,
            'em_country_code' => $request->em_countrytCode,
            'em_contact_number' => $request->em_contact_number,
            'em_email' => $request->em_email,

            'r_name' => $request->r_name,
            'r_parmanent_address' => $request->r_parmanent_address,
            'r_country_code' => $request->r_countrytCode,
            'r_contact_number' => $request->r_contact_number,
            'r_email' => $request->r_email,

            'emirates_id' => $request->emirates_id,
            // 'emirates_image' => $emirates_image,
            'passport_number' => $request->passport_number,
            // 'passport_image' => $passport_image,
            'visa_number' => $request->visa_number,
            'visa_type' => $request->visa_type,
            'pass_issue_country' => $request->pass_issue_country,
            'visa_issue_country' => $request->visa_issue_country,

            'company' => $request->company,
            'division' => 6,
            'department' => $request->department,
            'designation' => $request->designation,
            'joining_date' => $joining_date,
            'role' => 5,

            'qualification' => $request->qualification,
            'job_type' => $request->job_type,
            // 'quali_image' => $quali_image,

            'bank_name' => $request->bank_name,
            'branch_name' => $request->branch_name,
            'account_number' => $request->account_number,
            'ibal_number' => $request->ibal_number,
            'routing_number' => $request->routing_number,
            'swift_code' => $request->swift_code,

            'status' => 2,

            'visa_expiry_date' => $visa_expiry_date,
            'employee_wage_type' => $request->employee_wage_type,
            'employment_location' => $request->employment_location,
            'currency' => $request->currency,
            'payment_method' => $request->payment_method,
            'grade' => $request->grade,

            'description' => $request->description,
            'sub_description' => $request->sub_description,
        ]);
        $notification = array(
            'message'       => 'Employee Update successfully!',
            'alert-type'    => 'success'
        );
        return redirect()->back()->with($notification);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::find($id);
        $path = public_path('storage/upload/employee/') . $employee->employee_image;
        if (file_exists($path)) {
            unlink($path);
        }

        $path = public_path('storage/upload/employee/') . $employee->emirates_image;
        if (file_exists($path)) {
            unlink($path);
        }

        $path = public_path('storage/upload/employee/') . $employee->passport_image;
        if (file_exists($path)) {
            unlink($path);
        }

        $path = public_path('storage/upload/employee/') . $employee->quali_image;
        if (file_exists($path)) {
            unlink($path);
        }

        $employee->delete();
        $notification = array(
            'message'       => 'Mapping Deleted successfully!',
            'alert-type'    => 'success'
        );
        return redirect('teacher-profile')->with($notification);
    }


    public function employeeProDocumentDelete(Request $request)
    {
        $employeeDocument = PorfessionalDocument::find($request->id);
        $path = public_path('storage/upload/employee/post_quali/') . $employeeDocument->image;
        if (file_exists($path)) {
            unlink($path);
        }
        $employee_id = $employeeDocument->employee_id;
        $employeeDocument->delete();
        $others = PorfessionalDocument::where('employee_id', $employee_id)->get();
        // $notification = array(
        //     'message'       => 'Employee Salary Deleted successfully!',
        //     'alert-type'    => 'success'
        // );
        return Response()->json([
            'page' => view('backend.payroll.employee.ajaxImage', ['others' => $others, 'i' => 1])->render(),

        ]);
    }

    public function employeePriview(Request $request)
    {
        $employee = Employee::find($request->id);
        $salaryTypes = SalaryType::all();
        $countrytCode = Country::get();
        $countrytCode2 = Country::get();
        $countrytCode3 = Country::get();
        $department = Department::get();
        $nationality = Nationality::get();
        $grades = Grade::get();
        $countries = Country::get();
        $branchs = BankBranch::get();
        $pro_quali = PorfessionalDocument::where('employee_id', $employee->emp_id)->get();
        // $notification = array(
        //     'message'       => 'Employee Salary Deleted successfully!',
        //     'alert-type'    => 'success'
        // );
        return Response()->json([
            'page' => view('backend.payroll.employee.view-modal', [
                'employee_info' => $employee,
                'salaryTypes' => $salaryTypes,
                'countrytCode' => $countrytCode,
                'department' => $department,
                'nationality' => $nationality,
                'grades' => $grades,
                'countries' => $countries,
                'branchs' => $branchs,
                'countrytCode2' => $countrytCode2,
                'countrytCode3' => $countrytCode3,
                'pro_quali' => $pro_quali
            ])->render()
        ]);
    }

    public function employeeInfo(Request $request)
    {
        $emp_info = Employee::where('emp_id', 'like', '%' . $request->id . '%')->orWhere('name', 'like', '%' . $request->id . '%')->get();
        
        if ($emp_info->count() > 0) {
            if ($request->ajax()) {
                return Response()->json([
                    'page' => view('backend.payroll.employee.ajaxEmpList', ['empList' => $emp_info, 'i' => 1])->render(),

                ]);
            }
        }
    }

    public function findCurrency(Request $request)
    {
        $currency = Country::find($request->id);
        return Response()->json([
            'currency' => $currency->currency,

        ]);
    }

    public function approve(Request $request, $id)
    {

        // dd($id);
        // $request->validate([
        //     'name' => 'required'
        // ]);
        //Gate::authorize('approver');

        EmployeeTemp::find($id)->update([
            'status' => 1,
            'approved_by' => Auth::id()

        ]);
        $temp = EmployeeTemp::find($id);

        $check = Employee::where('emp_id',  $temp->emp_id)->get();

        if (count($check) == 0) {
            $employee_value=Employee::create([
                'first_name' => $temp->first_name,
                'middle_name' => $temp->middle_name,
                'last_name' => $temp->last_name,
                'full_name' => $temp->full_name,
                'first_lang' => $temp->first_lang,
                'second_lang' => $temp->second_lang,
                'salutation' => $temp->salutation,
                'emp_id' => $temp->emp_id,
                'father_name' => $temp->father_name,
                'mother_name' => $temp->mother_name,
                'dob' => $temp->dob,
                'nationality' => $temp->nationality,
                'employee_image' => $temp->employee_image,

                'job_type' => $request->job_type,

                'present_address' => $temp->present_address,
                'pr_city' => $temp->pr_city,
                'pr_country' => $temp->pr_country,
                'parmanent_address' => $temp->parmanent_address,
                'pa_city' => $temp->pa_city,
                'pa_country' => $temp->pa_country,
                'country_code' => $temp->country_code,
                'contact_number' => $temp->contact_number,
                'local_country_code' => $temp->local_country_code,
                'local_contact_number' => $temp->local_contact_number,
                'prefered_com' => $temp->prefered_com,
                'email' => $temp->email,

                'em_name' => $temp->em_name,
                'em_parmanent_address' => $temp->em_parmanent_address,
                'em_country_code' => $temp->em_country_code,
                'em_contact_number' => $temp->em_contact_number,
                'em_email' => $temp->em_email,

                'r_name' => $temp->r_name,
                'r_parmanent_address' => $temp->r_parmanent_address,
                'r_country_code' => $temp->r_country_code,
                'r_contact_number' => $temp->r_contact_number,
                'r_email' => $temp->r_email,

                'emirates_id' => $temp->emirates_id,
                'emirates_image' => $temp->emirates_image,
                'passport_number' => $temp->passport_number,
                'passport_image' => $temp->passport_image,
                'visa_number' => $temp->visa_number,
                'visa_type' => $temp->visa_type,
                'pass_issue_country' => $temp->pass_issue_country,
                'visa_issue_country' => $temp->visa_issue_country,

                'company' => $temp->company,
                'division' => $temp->division,
                'department' => $temp->department,
                'designation' => $temp->designation,
                'joining_date' => $temp->joining_date,
                'role' => $temp->role,

                'qualification' => $temp->qualification,
                'passing_year' => $temp->passing_year,
                'institution_name' => $temp->institution_name,
                'qualification_country' => $temp->qualification_country,
                'quali_image' => $temp->quali_image,

                'bank_name' => $temp->bank_name,
                'branch_name' => $temp->branch_name,
                'account_number' => $temp->account_number,
                'ibal_number' => $temp->ibal_number,
                'routing_number' => $temp->routing_number,
                'swift_code' => $temp->swift_code,

                'visa_expiry_date' => $temp->visa_expiry_date,
                'employee_wage_type' => $temp->employee_wage_type,
                'employment_location' => $temp->employment_location,
                'currency' => $temp->currency,
                'payment_method' => $temp->payment_method,
                'grade' => $temp->grade,

                'status' => 1,

                'description' => $temp->description,
                'sub_description' => $temp->sub_description,
            ]);

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
            $draftCost->emp_id = $employee_value->id;
            $draftCost->pi_name = $employee_value->salutation . ' ' . $employee_value->first_name . ' ' . $employee_value->middle_name . ' ' . $employee_value->last_name;
            $draftCost->pi_type = 'Employee';
            $draftCost->address = $employee_value->parmanent_address . ' ' . $employee_value->pa_city . ' ' . $employee_value->pa_country;
            $draftCost->con_person = $employee_value->em_name;
            $draftCost->con_no = $employee_value->em_country_code . $employee_value->em_contact_number;
            $draftCost->phone_no = $employee_value->country_code . $employee_value->ontact_number;
            $draftCost->email = $employee_value->email;
            $draftCost->save();
        } else {
            $employee_value=Employee::where('emp_id', $temp->emp_id)->first();
            $employee_value->update([
                'first_name' => $temp->first_name,
                'last_name' => $temp->last_name,
                'full_name' => $temp->full_name,
                'emp_id' => $temp->emp_id,
                'father_name' => $temp->father_name,
                'mother_name' => $temp->mother_name,
                'dob' => $temp->dob,
                'nationality' => $temp->nationality,
                'employee_image' => $temp->employee_image,
                'salutation' => $temp->salutation,
                'job_type' => $request->job_type,

                'present_address' => $temp->present_address,
                'pr_city' => $temp->pr_city,
                'pr_country' => $temp->pr_country,
                'parmanent_address' => $temp->parmanent_address,
                'pa_city' => $temp->pa_city,
                'pa_country' => $temp->pa_country,
                'country_code' => $temp->country_code,
                'contact_number' => $temp->contact_number,
                'email' => $temp->email,

                'em_name' => $temp->em_name,
                'em_parmanent_address' => $temp->em_parmanent_address,
                'em_country_code' => $temp->em_country_code,
                'em_contact_number' => $temp->em_contact_number,
                'em_email' => $temp->em_email,

                'r_name' => $temp->r_name,
                'r_parmanent_address' => $temp->r_parmanent_address,
                'r_country_code' => $temp->r_country_code,
                'r_contact_number' => $temp->r_contact_number,
                'r_email' => $temp->r_email,

                'emirates_id' => $temp->emirates_id,
                'emirates_image' => $temp->emirates_image,
                'passport_number' => $temp->passport_number,
                'passport_image' => $temp->passport_image,
                'pass_issue_country' => $temp->pass_issue_country,

                'company' => $temp->company,
                'division' => $temp->division,
                'department' => $temp->department,
                'designation' => $temp->designation,
                'joining_date' => $temp->joining_date,

                'qualification' => $temp->qualification,
                'quali_image' => $temp->quali_image,

                'bank_name' => $temp->bank_name,
                'branch_name' => $temp->branch_name,
                'account_number' => $temp->account_number,
                'ibal_number' => $temp->ibal_number,
                'routing_number' => $temp->routing_number,
                'swift_code' => $temp->swift_code,

                'visa_expiry_date' => $temp->visa_expiry_date,
                'employee_wage_type' => $temp->employee_wage_type,
                'employment_location' => $temp->employment_location,
                'currency' => $temp->currency,
                'payment_method' => $temp->payment_method,
                'grade' => $temp->grade,

                'status' => 1,

                'description' => $temp->description,
                'sub_description' => $temp->sub_description,
            ]);

            //party info update
            $party_id = PartyInfo::where('emp_id', $employee_value->id)->first();
            if ($party_id) {
                $draftCost = PartyInfo::find($party_id->id);
            } else {
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
                $draftCost->emp_id = $employee_value->id;
            }
            $draftCost->pi_name = $employee_value->salutation . ' ' . $employee_value->first_name . ' ' . $employee_value->middle_name . ' ' . $employee_value->last_name;
            $draftCost->pi_type = 'Employee';
            $draftCost->address = $employee_value->parmanent_address . ' ' . $employee_value->pa_city . ' ' . $employee_value->pa_country;
            $draftCost->con_person = $employee_value->em_name;
            $draftCost->con_no = $employee_value->em_country_code . $employee_value->em_contact_number;
            $draftCost->phone_no = $employee_value->country_code . $employee_value->ontact_number;
            $draftCost->email = $employee_value->email;
            $draftCost->save();
        }

        if ($employee_value->division !== 3 && $employee_value->division !== 4 && $employee_value->division !== 5 && $employee_value->division!==2){
            $user = User::where('employee_id',  $employee_value->id)->first();
            if($user){
                 $user->name = $temp->first_name;
                 $user->email = $temp->email;
                 $user->password = Hash::make(123456789);
                 $user->role_id = $temp->division;
                 $user->employee_id = $employee_value->id;
                 $user->save();
            }
            else{
             User::create([
                 'name' => $temp->first_name,
                 'email' => $temp->email,
                 'password' => Hash::make(123456789),
                 'role_id' => $temp->division,
                 'employee_id' => $employee_value->id ,
             ]);
            }
           }

        $notification = array(
            'message'       => 'Approved successfully!',
            'alert-type'    => 'success'
        );
        return redirect('hr/payroll/employees')->with($notification);
    }
    public function teacher_approve(Request $request, $id)
    {

        // $request->validate([
        //     'name' => 'required'
        // ]);
        //Gate::authorize('approver');

        EmployeeTemp::find($id)->update([
            'status' => 1,
            'approved_by' => Auth::id()

        ]);
        $temp = EmployeeTemp::find($id);
        // dd($temp);

        $check = Employee::where('emp_id',  $temp->emp_id)->get();

        if (count($check) == 0) {
         $employee_value =   Employee::create([
                'first_name' => $temp->first_name,
                'middle_name' => $temp->middle_name,
                'last_name' => $temp->last_name,
                'first_lang' => $temp->first_lang,
                'second_lang' => $temp->second_lang,
                'salutation' => $temp->salutation,
                'emp_id' => $temp->emp_id,
                'father_name' => $temp->father_name,
                'mother_name' => $temp->mother_name,
                'dob' => $temp->dob,
                'nationality' => $temp->nationality,
                'employee_image' => $temp->employee_image,

                'present_address' => $temp->present_address,
                'pr_city' => $temp->pr_city,
                'pr_country' => $temp->pr_country,
                'parmanent_address' => $temp->parmanent_address,
                'pa_city' => $temp->pa_city,
                'pa_country' => $temp->pa_country,
                'country_code' => $temp->country_code,
                'contact_number' => $temp->contact_number,
                'local_country_code' => $temp->local_country_code,
                'local_contact_number' => $temp->local_contact_number,
                'prefered_com' => $temp->prefered_com,
                'email' => $temp->email,

                'em_name' => $temp->em_name,
                'em_parmanent_address' => $temp->em_parmanent_address,
                'em_country_code' => $temp->em_country_code,
                'em_contact_number' => $temp->em_contact_number,
                'em_email' => $temp->em_email,

                'r_name' => $temp->r_name,
                'r_parmanent_address' => $temp->r_parmanent_address,
                'r_country_code' => $temp->r_country_code,
                'r_contact_number' => $temp->r_contact_number,
                'r_email' => $temp->r_email,

                'emirates_id' => $temp->emirates_id,
                'emirates_image' => $temp->emirates_image,
                'passport_number' => $temp->passport_number,
                'passport_image' => $temp->passport_image,
                'visa_number' => $temp->visa_number,
                'visa_type' => $temp->visa_type,
                'pass_issue_country' => $temp->pass_issue_country,
                'visa_issue_country' => $temp->visa_issue_country,

                'company' => $temp->company,
                'division' => $temp->division,
                'department' => $temp->department,
                'designation' => $temp->designation,
                'joining_date' => $temp->joining_date,
                'role' => $temp->role,

                'qualification' => $temp->qualification,
                'passing_year' => $temp->passing_year,
                'institution_name' => $temp->institution_name,
                'qualification_country' => $temp->qualification_country,
                'quali_image' => $temp->quali_image,

                'bank_name' => $temp->bank_name,
                'branch_name' => $temp->branch_name,
                'account_number' => $temp->account_number,
                'ibal_number' => $temp->ibal_number,
                'routing_number' => $temp->routing_number,
                'swift_code' => $temp->swift_code,

                'visa_expiry_date' => $temp->visa_expiry_date,
                'employee_wage_type' => $temp->employee_wage_type,
                'employment_location' => $temp->employment_location,
                'currency' => $temp->currency,
                'payment_method' => $temp->payment_method,
                'grade' => $temp->grade,

                'status' => 1,

                'description' => $temp->description,
                'sub_description' => $temp->sub_description,
            ]);

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
        } else {


            $employee_value =  Employee::where('emp_id', $temp->emp_id)->first();
               if($employee_value){
                $employee_value->update([
                    'first_name' => $temp->first_name,
                    'last_name' => $temp->last_name,
                    'emp_id' => $temp->emp_id,
                    'father_name' => $temp->father_name,
                    'mother_name' => $temp->mother_name,
                    'dob' => $temp->dob,
                    'nationality' => $temp->nationality,
                    'employee_image' => $temp->employee_image,

                    'present_address' => $temp->present_address,
                    'pr_city' => $temp->pr_city,
                    'pr_country' => $temp->pr_country,
                    'parmanent_address' => $temp->parmanent_address,
                    'pa_city' => $temp->pa_city,
                    'pa_country' => $temp->pa_country,
                    'country_code' => $temp->country_code,
                    'contact_number' => $temp->contact_number,
                    'email' => $temp->email,

                    'em_name' => $temp->em_name,
                    'em_parmanent_address' => $temp->em_parmanent_address,
                    'em_country_code' => $temp->em_country_code,
                    'em_contact_number' => $temp->em_contact_number,
                    'em_email' => $temp->em_email,

                    'r_name' => $temp->r_name,
                    'r_parmanent_address' => $temp->r_parmanent_address,
                    'r_country_code' => $temp->r_country_code,
                    'r_contact_number' => $temp->r_contact_number,
                    'r_email' => $temp->r_email,

                    'emirates_id' => $temp->emirates_id,
                    'emirates_image' => $temp->emirates_image,
                    'passport_number' => $temp->passport_number,
                    'passport_image' => $temp->passport_image,
                    'pass_issue_country' => $temp->pass_issue_country,

                    'company' => $temp->company,
                    'division' => $temp->division,
                    'department' => $temp->department,
                    'designation' => $temp->designation,
                    'joining_date' => $temp->joining_date,

                    'qualification' => $temp->qualification,
                    'quali_image' => $temp->quali_image,

                    'bank_name' => $temp->bank_name,
                    'branch_name' => $temp->branch_name,
                    'account_number' => $temp->account_number,
                    'ibal_number' => $temp->ibal_number,
                    'routing_number' => $temp->routing_number,
                    'swift_code' => $temp->swift_code,

                    'visa_expiry_date' => $temp->visa_expiry_date,
                    'employee_wage_type' => $temp->employee_wage_type,
                    'employment_location' => $temp->employment_location,
                    'currency' => $temp->currency,
                    'payment_method' => $temp->payment_method,
                    'grade' => $temp->grade,

                    'status' => 1,

                    'description' => $temp->description,
                    'sub_description' => $temp->sub_description,
                ]);
               }

            //party info update
            $party_id = PartyInfo::where('emp_id', $temp->id)->first();
            if ($party_id) {
                $draftCost = PartyInfo::find($party_id->id);
            } else {
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
            }
            $draftCost->pi_name = $temp->salutation . ' ' . $temp->first_name . ' ' . $temp->middle_name . ' ' . $temp->last_name;
            $draftCost->pi_type = 'Employee';
            $draftCost->address = $temp->parmanent_address . ' ' . $temp->pa_city . ' ' . $temp->pa_country;
            $draftCost->con_person = $temp->em_name;
            $draftCost->con_no = $temp->em_country_code . $temp->em_contact_number;
            $draftCost->phone_no = $temp->country_code . $temp->ontact_number;
            $draftCost->email = $temp->email;
            $draftCost->save();
        }
       //return($employee_value->id);
       if ($employee_value) {
       $user = User::where('employee_id',  $employee_value->id)->first();
       if($user){
            $user->name = $temp->first_name;
            $user->email = $temp->email;
            $user->password = Hash::make(123456789);
            $user->role_id = $temp->division;
            $user->employee_id = $employee_value->id;
            $user->save();
       }
       else{
        User::create([
            'name' => $temp->first_name,
            'email' => $temp->email,
            'password' => Hash::make(123456789),
            'role_id' => $temp->division,
            'employee_id' => $employee_value->id ,
        ]);
       }

    } else {

        $notification = array(
            'message'       => 'Employee not approved !',
            'alert-type'    => 'error'
        );
        return redirect()->back()->with($notification);
      }



        $notification = array(
            'message'       => 'Approved successfully!',
            'alert-type'    => 'success'
        );
        return redirect()->back()->with($notification);
    }
    // public function editApprove(Request $request, $id) {

    //     // dd(Auth::id());
    //     // $request->validate([
    //     //     'name' => 'required'
    //     // ]);

    //     EmployeeTemp::find($id)->update([
    //         'status' => 1,
    //         'approve_by' => Auth::id()
    //     ]);
    //     $temp = EmployeeTemp::find($id);
    //     // dd($temp);




    //     $notification= array(
    //         'message'       => 'Approved successfully!',
    //         'alert-type'    => 'success'
    //     );
    //     return redirect('employees')->with($notification);
    // }


}
