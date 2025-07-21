@extends('layouts.backend.app')
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
    <style>
        .card {
                margin-bottom: 0.10rem !important;
            }

        .row {
            padding-bottom: 5px;
        }
    </style>
@endpush
@section('title', 'employees')
@section('content')
@include('layouts.backend.partial.style')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="tab-content cardStyleChange">
                <section id="widgets-Statistics" class="mr-1 ml-1">
                    <div class="row">
                        <div class="col-md-6 mt-2 mb-2">
                            <h4>Employee Information</h4>
                        </div>
                    </div>
                    <div class="row" style="padding-left: 10px; padding-right: 10px">
                        <div class="col-12">
                            <form action="{{route('employees.update', $employee_info->id)}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="cardStyleChange">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="row px-1">
                                                    <div class="col-sm-2 col-12 changeColStyle">
                                                        <label for="mode">Employee ID <sup class="text-danger">*</sup></label>
                                                        <input type="text" class="form-control inputFieldHeight" name="eid" id="eid" value="{{$employee_info->id}}" readonly required
                                                        >
                                                    </div>
                                                    <div class="col-sm-2 col-12 changeColStyle">
                                                        <label for="mode">Name <sup class="text-danger">*</sup></label>
                                                        <input type="text" class="form-control inputFieldHeight" name="name" id="name" 
                                                            onkeypress='return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || (event.charCode == 32) || (event.charCode == 46))' 
                                                        value="{{$employee_info->name}}" required >
                                                    </div>
                                                    <div class="col-sm-2 col-12 changeColStyle">
                                                        <label for="mode">Fathers Name <sup class="text-danger">*</sup></label>
                                                        <input type="text" class="form-control inputFieldHeight" name="father_name" id="father_name"
                                                            onkeypress='return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || (event.charCode == 32) || (event.charCode == 46))' required
                                                            value="{{$employee_info->father_name}}"
                                                            >
                                                    </div>
                                                    <div class="col-sm-2 col-12 changeColStyle">
                                                        <label for="mode">Mothers Name <sup class="text-danger">*</sup></label>
                                                        <input type="text" class="form-control inputFieldHeight" name="mother_name" id="mother_name"
                                                            onkeypress='return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || (event.charCode == 32) || (event.charCode == 46))' required
                                                            value="{{$employee_info->mother_name}}"
                                                        >
                                                    </div>
                                                    <div class="col-sm-2 col-12 changeColStyle">
                                                        <label for="mode">Date of Birth <sup class="text-danger">*</sup></label>
                                                        <input type="date" class="form-control inputFieldHeight" name="dob" id="dob" min="{{Carbon\Carbon::now()->subYears(100)->format('Y-m-d')}}" 
                                                            max="{{Carbon\Carbon::now()->subYears(10)->format('Y-m-d')}}" value="{{$employee_info->dob}}" required
                                                        >
                                                    </div>
                                                    
                                                    <div class="col-sm-2 col-12 changeColStyle">
                                                        <label for="mode">Nationality <sup class="text-danger">*</sup></label>
                                                        {{-- <input type="text" class="form-control inputFieldHeight" name="nationality" id="nationality" required> --}}
                                                        <select name="nationality" id="nationality" class="form-control common-select2" style="width: 100% !important" required>
                                                            <option value="">Select Nationality</option>
                                                            @foreach ($nationality as $nationality)
                                                                <option value="{{$nationality->id}}" {{ ($employee_info->nationality == $nationality->id)?'selected':'' }}>{{$nationality->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-2 col-12 changeColStyle">
                                                        <label for="mode">Employee Image <sup class="text-danger">*</sup></label>
                                                        <input type="file" class="form-control inputFieldHeight" name="employee_image" id="employee_image" >
                                                        <input type="hidden" value="{{ $employee_info->employee_image }}" name="old_employee_image">
                                                    </div>
                                                    <div class="col-sm-1 col-12 changeColStyle">
                                                        @if($employee_info->employee_image != null)
                                                            <br>
                                                            <div>
                                                                <a href="{{ asset('storage/upload/employee/'.$employee_info->employee_image)}}"  target="_blank">
                                                                    <img src="{{ asset('storage/upload/employee/'. $employee_info->employee_image) }}" style="width: 60px">
                                                                </a>
                                                                </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row ">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="row px-1">
                                                    <div class="col-sm-2 col-12 changeColStyle">
                                                        <label for="mode">Present Address <sup class="text-danger">*</sup></label>
                                                        <input type="text" class="form-control inputFieldHeight" name="present_address" id="present_address"
                                                            value="{{$employee_info->present_address}}" required
                                                        >
                                                    </div>
                                                    <div class="col-sm-2 col-12 changeColStyle">
                                                        <label for="mode">Parmanent Address <sup class="text-danger">*</sup></label>
                                                        <input type="text" class="form-control inputFieldHeight" name="parmanent_address" id="parmanent_address"
                                                            value="{{$employee_info->parmanent_address}}" required
                                                        >
                                                    </div>
                                                    <div class="col-sm-2 col-12 changeColStyle">
                                                        <label for="mode">Country code <sup class="text-danger">*</sup></label>
                                                        {{-- <input type="text" class="form-control inputFieldHeight" name="nationality" id="nationality" required> --}}
                                                        <select name="countrytCode" id="countrytCode" class="form-control common-select2" style="width: 100% !important" required>
                                                            <option value="">Select ...</option>
                                                            @foreach ($countrytCode as $countrytCode)
                                                                <option value="{{$countrytCode->id}}" {{ ($employee_info->country_code == $countrytCode->id)?'selected':'' }} >{{$countrytCode->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-2 col-12 changeColStyle">
                                                        <label for="mode">Contact Number <sup class="text-danger">*</sup></label>
                                                        <input type="text" class="form-control inputFieldHeight" name="contact_number" id="contact_number" 
                                                            onkeypress='return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode == 45))'
                                                            value="{{$employee_info->contact_number}}"
                                                        required>
                                                    </div>
                                                    
                                                    <div class="col-sm-2 col-12 changeColStyle">
                                                        <label for="mode">E-mail</label>
                                                        <input type="email" class="form-control inputFieldHeight" name="email" id="email" 
                                                            value="{{$employee_info->email}}"
                                                        >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row ">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="row px-1">
                                                    <div class="col-sm-2 col-12 changeColStyle">
                                                        <label for="mode">EID / NID Number <sup class="text-danger">*</sup></label>
                                                        <input type="text" class="form-control inputFieldHeight" name="emirates_id" id="emirates_id"
                                                            value="{{$employee_info->emirates_id}}" required
                                                        >
                                                    </div>
                                                    <div class="col-sm-2 col-12 changeColStyle">
                                                        <label for="mode">EID/NID Image <sup class="text-danger">*</sup></label>
                                                        <input type="file" class="form-control inputFieldHeight" name="emirates_image" id="emirates_image">
                                                        <input type="hidden" value="{{ $employee_info->emirates_image }}" name="old_emirates_image">
                                                    </div>
                                                    <div class="col-sm-1 col-12 changeColStyle">
                                                        @if($employee_info->emirates_image != null)
                                                            <br>
                                                            <div>
                                                                <a href="{{ asset('storage/upload/employee/'.$employee_info->emirates_image)}}"  target="_blank">
                                                                    <img src="{{ asset('storage/upload/employee/'. $employee_info->emirates_image) }}" style="width: 60px">
                                                                </a>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="col-sm-2 col-12 changeColStyle">
                                                        <label for="mode">Passport Number <sup class="text-danger">*</sup></label>
                                                        <input type="text" class="form-control inputFieldHeight" name="passport_number" id="passport_number"
                                                            value="{{$employee_info->passport_number}}" required
                                                        >
                                                    </div>
                                                    <div class="col-sm-2 col-12 changeColStyle">
                                                        <label for="mode">Passport Image <sup class="text-danger">*</sup></label>
                                                        <input type="file" class="form-control inputFieldHeight" name="passport_image" id="passport_image" >
                                                        <input type="hidden" value="{{ $employee_info->passport_image }}" name="old_passport_image">
                                                    </div>
                                                    <div class="col-sm-1 col-12 changeColStyle">
                                                        @if($employee_info->passport_image != null)
                                                            <br>
                                                            <div>
                                                                <a href="{{ asset('storage/upload/employee/'.$employee_info->passport_image)}}"  target="_blank">
                                                                    <img src="{{ asset('storage/upload/employee/'. $employee_info->passport_image) }}" style="width: 60px">
                                                                </a>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="col-sm-2 col-12 changeColStyle">
                                                        <label for="mode">Pass Issue Country <sup class="text-danger">*</sup></label>
                                                        {{-- <input type="text" class="form-control inputFieldHeight" name="nationality" id="nationality" required> --}}
                                                        <select name="pass_issue_country" id="pass_issue_country" class="form-control common-select2" style="width: 100% !important" required>
                                                            <option value="" >Select country</option>
                                                            @foreach ($countries as $country)
                                                                <option value="{{$country->id}}" {{ ($employee_info->pass_issue_country == $country->id)?'selected':'' }} >{{$country->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row ">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="row px-1">
                                                    <div class="col-sm-2 col-12 changeColStyle">
                                                        <label for="mode">Department <sup class="text-danger">*</sup></label>
                                                        {{-- <input type="text" class="form-control inputFieldHeight" name="department" id="department" required> --}}
                                                        <select name="department" id="department" class="form-control common-select2" style="width: 100% !important" required>
                                                            <option value="">Select ...</option>
                                                            @foreach ($department as $department)
                                                                <option value="{{$department->id}}" {{ ($employee_info->department == $department->id)?'selected':'' }} >{{$department->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-2 col-12 changeColStyle">
                                                        <label for="mode">Designation <sup class="text-danger">*</sup></label>
                                                        <input type="text" class="form-control inputFieldHeight" name="designation" id="designation" 
                                                            value="{{$employee_info->designation}}" required
                                                        >
                                                    </div>
                                                    <div class="col-sm-2 col-12 changeColStyle">
                                                        <label for="mode">Joining Date <sup class="text-danger">*</sup></label>
                                                        <input type="date" class="form-control inputFieldHeight" name="joining_date" id="joining_date" 
                                                            value="{{$employee_info->joining_date}}" required
                                                        >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row ">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="row px-1">
                                                    <div class="col-sm-2 col-12 changeColStyle">
                                                        <label for="mode">QUALIFICATION <sup class="text-danger">*</sup></label>
                                                        {{-- <input type="text" class="form-control inputFieldHeight" name="department" id="department" required> --}}
                                                        <select name="qualification" id="qualification" class="form-control common-select2" style="width: 100% !important" required>
                                                            <option value=""> Select Qualification</option>
                                                            <option value="Primary" {{ ($employee_info->qualification == 'Primary')?'selected':'' }}>Primary</option>
                                                            <option value="Secondary" {{ ($employee_info->qualification == 'Secondary')?'selected':'' }}>Secondary</option>
                                                            <option value="Higher_Secondary" {{ ($employee_info->qualification == 'Higher_Secondary')?'selected':'' }}>Higher Secondary</option>
                                                            <option value="Graduated" {{ ($employee_info->qualification == 'Graduated')?'selected':'' }}>Graduated</option>
                                                            <option value="Postgraduated" {{ ($employee_info->qualification == 'Postgraduated')?'selected':'' }}>Postgraduated</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-2 col-12 changeColStyle">
                                                        <label for="mode">Scan Copy <sup class="text-danger">*</sup></label>
                                                        <input type="file" class="form-control inputFieldHeight" name="quali_image" id="quali_image" >
                                                        <input type="hidden" value="{{ $employee_info->quali_image }}" name="old_quali_image">
                                                        
                                                    </div>
                                                    <div class="col-sm-1 col-12 changeColStyle">
                                                        @if($employee_info->quali_image != null)
                                                            <br>
                                                            <div>
                                                                <a href="{{ asset('storage/upload/employee/'.$employee_info->quali_image)}}"  target="_blank">
                                                                    <img src="{{ asset('storage/upload/employee/'. $employee_info->quali_image) }}" style="width: 60px">
                                                                </a>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row ">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="row px-1">
                                                    <div class="col-sm-2 col-12 changeColStyle">
                                                        <label for="mode">Bank Name <sup class="text-danger">*</sup></label>
                                                        <input type="text" class="form-control inputFieldHeight" name="bank_name" id="bank_name"
                                                            value="{{$employee_info->bank_name}}" required
                                                        >
                                                    </div>
                                                    <div class="col-sm-2 col-12 changeColStyle">
                                                        <label for="mode">Branch Name <sup class="text-danger">*</sup></label>
                                                        <select name="branch_name" id="branch_name" class="form-control common-select2" style="width: 100% !important" required>
                                                            <option value="">Select Branch</option>
                                                            @foreach ($branchs as $branch)
                                                                <option value="{{$branch->id}}" {{ ($employee_info->branch_name == $branch->id)?'selected':'' }} >{{$branch->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-2 col-12 changeColStyle">
                                                        <label for="mode">Account Number <sup class="text-danger">*</sup></label>
                                                        <input type="text" class="form-control inputFieldHeight" name="account_number" id="account_number"
                                                            value="{{$employee_info->account_number}}" required
                                                        >
                                                    </div>
                                                    <div class="col-sm-2 col-12 changeColStyle">
                                                        <label for="mode">IBAL Number <sup class="text-danger">*</sup></label>
                                                        <input type="text" class="form-control inputFieldHeight" name="ibal_number" id="ibal_number"
                                                            value="{{$employee_info->ibal_number}}" required
                                                        >
                                                    </div>
                                                    <div class="col-sm-2 col-12 changeColStyle">
                                                        <label for="mode">Routing Number <sup class="text-danger">*</sup></label>
                                                        <input type="text" class="form-control inputFieldHeight" name="routing_number" id="routing_number"
                                                            value="{{$employee_info->routing_number}}" required
                                                        >
                                                    </div>
                                                    <div class="col-sm-2 col-12 changeColStyle">
                                                        <label for="mode">Swift Code <sup class="text-danger">*</sup></label>
                                                        <input type="text" class="form-control inputFieldHeight" name="swift_code" id="swift_code"
                                                           value="{{$employee_info->swift_code}}" required
                                                        >
                                                    </div>
                                                    {{-- <div class="col-sm-2 col-12 changeColStyle">
                                                        <label for="mode">Scan Copy <sup class="text-danger">*</sup></label>
                                                        <input type="file" class="form-control inputFieldHeight" name="quali_image" id="quali_image" >
                                                    </div> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row ">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="row px-1">
                                                    <div class="col-sm-2 col-12 changeColStyle">
                                                        <label for="mode">Visa expiry date <sup class="text-danger">*</sup></label>
                                                        <input type="date" class="form-control inputFieldHeight" name="visa_expiry_date" id="visa_expiry_date"
                                                            min="{{Carbon\Carbon::now()->addMonth(1)->format('Y-m-d')}}" max="{{Carbon\Carbon::now()->addMonth(12)->format('Y-m-d')}}"
                                                            value="{{$employee_info->visa_expiry_date}}" required
                                                         >
                                                    </div>
                                                    <div class="col-sm-2 col-12 changeColStyle">
                                                        <label for="mode">Employee Wages Type <sup class="text-danger">*</sup></label>
                                                        <select name="employee_wage_type" id="employee_wage_type" class="form-control common-select2" style="width: 100% !important" required>
                                                            <option value="">Select Wages Type</option>
                                                            @foreach ($salaryTypes as $salaryType)
                                                                <option value="{{$salaryType->id}}" {{ ($employee_info->employee_wage_type == $salaryType->id)?'selected':'' }} >{{$salaryType->salary_type}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-2 col-12 changeColStyle">
                                                        <label for="mode">Employee Grade <sup class="text-danger">*</sup></label>
                                                        <select name="grade" id="grade" class="form-control common-select2" style="width: 100% !important" required>
                                                            <option value="">Select Grade</option>
                                                            @foreach ($grades as $grade)
                                                                <option value="{{$grade->id}}" {{ ($employee_info->grade == $grade->id)?'selected':'' }} >{{$grade->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-2 col-12 changeColStyle">
                                                        <label for="mode">Payment Method <sup class="text-danger">*</sup></label>
                                                        <select name="payment_method" id="payment_method" class="form-control common-select2" style="width: 100% !important" required>
                                                            <option value="">Select Payment Method</option>
                                                            <option value="bank" {{ ($employee_info->payment_method == 'bank')?'selected':'' }}>Bank</option>
                                                            <option value="cash" {{ ($employee_info->payment_method == 'cash')?'selected':'' }}>Cash</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-12 d-flex justify-content-end changeColStyle mb-1 mt-1">
                                        <button type="submit" class="btn mr-1 btn-primary formButton" title="Form Save">
                                            <div class="d-flex">
                                                <div class="formSaveIcon">
                                                    <img  src="{{asset('assets/backend/app-assets/icon/save-icon.png')}}" alt="" srcset="" class="img-fluid" width="25">
                                                </div>
                                                <div><span> Save</span></div>
                                            </div>
                                        </button>
                                        <button type="reset" class="btn btn-light-secondary formButton" title="Form Reset">
                                            <div class="d-flex">
                                                <div class="formRefreshIcon">
                                                    <img  src="{{asset('assets/backend/app-assets/icon/refresh-icon.png')}}" alt="" srcset="" class="img-fluid" width="25">
                                                </div>
                                                <div><span> Reset</span></div>
                                            </div>
                                        </button>

                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </section>
                <section class="m-1">
                    <div class="cardStyleChange">
                        <table class="table mb-0 table-sm table-hover">
                            <thead class="thead-light">
                                <tr style="height: 50px;">
                                    <th>Name</th>
                                    <th>Contact Number</th>
                                    <th>Department</th>
                                    <th>Designation</th>
                                    <th>Salary Types</th>
                                    <th class="text-right pr-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $item)
                                    <tr  class="data-row">
                                        <td>{{$item->name}}</td>
                                        <td>{{$item->code->name.$item->contact_number}}</td>
                                        <td>{{$item->dpt->name}}</td>
                                        <td>{{$item->designation}}</td>
                                        <td>{{$item->items->salary_type}}</td>
                                        <td style="padding-bottom: 11px; padding-top: 0px" class="text-right pr-2">
                                            <a href="{{route('employees.edit', $item->id)}}" class="btn" style="height: 30px; width: 30px;" title="Eidt">
                                                <img src="{{ asset('assets/backend/app-assets/icon/edit-icon.png')}}" style=" height: 30px; width: 30px;">
                                            </a>
                                            
                                            <a href="" class="btn" style="height: 30px; width: 30px;" title="Delete">
                                                <form action="{{ route('employees.destroy', $item->id) }}" method="POST" class="flot-right">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn" onclick="return confirm('Delete Confirm?')" style="padding-top: 0px; padding-left:0px;">
                                                        <img src="{{ asset('assets/backend/app-assets/icon/delete-icon.png')}}" style="height: 32px; width: 32px; margin-left: -12px;">
                                                    </button>
                                                </form>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection

@push('js')
<script>
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN':'{{ csrf_token() }}'
        }
    });
    function refreshPage(){

        window.location.reload();
    }

</script>
@endpush