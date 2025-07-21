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
                        <div class="content-body">
                            <form action="{{route('employees.store')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="cardStyleChange">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card">
                                                    <div class="row px-1">
                                                        <div class="col-sm-2 col-12 changeColStyle">
                                                            <label for="mode">Employee ID <sup class="text-danger">*</sup></label>
                                                            <input type="text" class="form-control inputFieldHeight" name="eid" id="eid" value="{{$eid?$eid->id + 1:1}}" readonly required
                                                            >
                                                        </div>
                                                        <div class="col-sm-2 col-12 changeColStyle">
                                                            <label for="mode">Name <sup class="text-danger">*</sup></label>
                                                            <input type="text" class="form-control inputFieldHeight" name="name" id="name" 
                                                                onkeypress='return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || (event.charCode == 32) || (event.charCode == 46))  ' 
                                                            required >
                                                        </div>
                                                        <div class="col-sm-2 col-12 changeColStyle">
                                                            <label for="mode">Fathers Name <sup class="text-danger">*</sup></label>
                                                            <input type="text" class="form-control inputFieldHeight" name="father_name" id="father_name"
                                                                onkeypress='return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || (event.charCode == 32) || (event.charCode == 46))' required
                                                            >
                                                        </div>
                                                        <div class="col-sm-2 col-12 changeColStyle">
                                                            <label for="mode">Mothers Name <sup class="text-danger">*</sup></label>
                                                            <input type="text" class="form-control inputFieldHeight" name="mother_name" id="mother_name"
                                                                onkeypress='return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || (event.charCode == 32) || (event.charCode == 46))' required
                                                            >
                                                        </div>
                                                        <div class="col-sm-2 col-12 changeColStyle">
                                                            <label for="mode">Date of Birth <sup class="text-danger">*</sup></label>
                                                            <input type="date" class="form-control inputFieldHeight" name="dob" id="dob" min="{{Carbon\Carbon::now()->subYears(100)->format('Y-m-d')}}" max="{{Carbon\Carbon::now()->subYears(10)->format('Y-m-d')}}" required>
                                                        </div>
                                                        
                                                        <div class="col-sm-2 col-12 changeColStyle">
                                                            <label for="mode">Nationality <sup class="text-danger">*</sup></label>
                                                            {{-- <input type="text" class="form-control inputFieldHeight" name="nationality" id="nationality" required> --}}
                                                            <select name="nationality" id="nationality" class="form-control common-select2" style="width: 100% !important" required>
                                                                <option value="">Select Nationality</option>
                                                                @foreach ($nationality as $nationality)
                                                                    <option value="{{$nationality->id}}">{{$nationality->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-2 col-12 changeColStyle">
                                                            <label for="mode">Employee Image <sup class="text-danger">*</sup></label>
                                                            <input type="file" class="form-control inputFieldHeight" name="employee_image" id="employee_image" required>
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
                                                            <input type="text" class="form-control inputFieldHeight" name="present_address" id="present_address" required>
                                                        </div>
                                                        <div class="col-sm-2 col-12 changeColStyle">
                                                            <label for="mode">Parmanent Address <sup class="text-danger">*</sup></label>
                                                            <input type="text" class="form-control inputFieldHeight" name="parmanent_address" id="parmanent_address" required>
                                                        </div>
                                                        <div class="col-sm-2 col-12 changeColStyle">
                                                            <label for="mode">Country code <sup class="text-danger">*</sup></label>
                                                            {{-- <input type="text" class="form-control inputFieldHeight" name="nationality" id="nationality" required> --}}
                                                            <select name="countrytCode" id="countrytCode" class="form-control common-select2" style="width: 100% !important" required>
                                                                <option value="">Select ...</option>
                                                                @foreach ($countrytCode as $countrytCode)
                                                                    <option value="{{$countrytCode->id}}">{{$countrytCode->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-2 col-12 changeColStyle">
                                                            <label for="mode">Contact Number <sup class="text-danger">*</sup></label>
                                                            <input type="text" class="form-control inputFieldHeight" name="contact_number" id="contact_number" 
                                                                onkeypress='return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode == 45))'
                                                            required>
                                                        </div>
                                                        
                                                        <div class="col-sm-2 col-12 changeColStyle">
                                                            <label for="mode">E-mail</label>
                                                            <input type="email" class="form-control inputFieldHeight" name="email" id="email" required>
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
                                                            <input type="text" class="form-control inputFieldHeight" name="emirates_id" id="emirates_id" required>
                                                        </div>
                                                        <div class="col-sm-2 col-12 changeColStyle">
                                                            <label for="mode">EID/NID Image <sup class="text-danger">*</sup></label>
                                                            <input type="file" class="form-control inputFieldHeight" name="emirates_image" id="emirates_image" required>
                                                        </div>
                                                        <div class="col-sm-2 col-12 changeColStyle">
                                                            <label for="mode">Passport Number <sup class="text-danger">*</sup></label>
                                                            <input type="text" class="form-control inputFieldHeight" name="passport_number" id="passport_number" required>
                                                        </div>
                                                        <div class="col-sm-2 col-12 changeColStyle">
                                                            <label for="mode">Passport Image <sup class="text-danger">*</sup></label>
                                                            <input type="file" class="form-control inputFieldHeight" name="passport_image" id="passport_image" required>
                                                        </div>
                                                        <div class="col-sm-3 col-12 changeColStyle">
                                                            <label for="mode">Passport Issue Country <sup class="text-danger">*</sup></label>
                                                            {{-- <input type="text" class="form-control inputFieldHeight" name="nationality" id="nationality" required> --}}
                                                            <select name="pass_issue_country" id="pass_issue_country" class="form-control common-select2" style="width: 100% !important" required>
                                                                <option value="" >Select country</option>
                                                                @foreach ($countries as $country)
                                                                    <option value="{{$country->id}}">{{$country->name}}</option>
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
                                                                    <option value="{{$department->id}}">{{$department->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-2 col-12 changeColStyle">
                                                            <label for="mode">Designation <sup class="text-danger">*</sup></label>
                                                            <input type="text" class="form-control inputFieldHeight" name="designation" id="designation" required>
                                                        </div>
                                                        <div class="col-sm-2 col-12 changeColStyle">
                                                            <label for="mode">Joining Date <sup class="text-danger">*</sup></label>
                                                            <input type="date" class="form-control inputFieldHeight" name="joining_date" id="joining_date" required>
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
                                                                <option value="Primary">Primary</option>
                                                                <option value="Secondary">Secondary</option>
                                                                <option value="Higher_Secondary">Higher Secondary</option>
                                                                <option value="Graduated">Graduated</option>
                                                                <option value="Poatgraduated">Poatgraduated</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-2 col-12 changeColStyle">
                                                            <label for="mode">Scan Copy <sup class="text-danger">*</sup></label>
                                                            <input type="file" class="form-control inputFieldHeight" name="quali_image" id="quali_image" required>
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
                                                            <input type="text" class="form-control inputFieldHeight" name="bank_name" id="bank_name" required>
                                                        </div>
                                                        <div class="col-sm-2 col-12 changeColStyle">
                                                            <label for="mode">Branch Name <sup class="text-danger">*</sup></label>
                                                            <select name="branch_name" id="branch_name" class="form-control common-select2" style="width: 100% !important" required>
                                                                <option value="">Select Branch</option>
                                                                @foreach ($branchs as $branch)
                                                                    <option value="{{$branch->id}}">{{$branch->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-2 col-12 changeColStyle">
                                                            <label for="mode">Account Number <sup class="text-danger">*</sup></label>
                                                            <input type="text" class="form-control inputFieldHeight" name="account_number" id="account_number" required>
                                                        </div>
                                                        <div class="col-sm-2 col-12 changeColStyle">
                                                            <label for="mode">IBAL Number <sup class="text-danger">*</sup></label>
                                                            <input type="text" class="form-control inputFieldHeight" name="ibal_number" id="ibal_number" required>
                                                        </div>
                                                        <div class="col-sm-2 col-12 changeColStyle">
                                                            <label for="mode">Routing Number <sup class="text-danger">*</sup></label>
                                                            <input type="text" class="form-control inputFieldHeight" name="routing_number" id="routing_number" required>
                                                        </div>
                                                        <div class="col-sm-2 col-12 changeColStyle">
                                                            <label for="mode">Swift Code <sup class="text-danger">*</sup></label>
                                                            <input type="text" class="form-control inputFieldHeight" name="swift_code" id="swift_code" required>
                                                        </div>
                                                        {{-- <div class="col-sm-2 col-12 changeColStyle">
                                                            <label for="mode">Scan Copy <sup class="text-danger">*</sup></label>
                                                            <input type="file" class="form-control inputFieldHeight" name="quali_image" id="quali_image" required>
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
                                                            <input type="date" class="form-control inputFieldHeight" name="visa_expiry_date" id="visa_expiry_date" min="{{Carbon\Carbon::now()->addMonth(1)->format('Y-m-d')}}" max="{{Carbon\Carbon::now()->addMonth(12)->format('Y-m-d')}}" required>
                                                        </div>
                                                        <div class="col-sm-2 col-12 changeColStyle">
                                                            <label for="mode">Employee Wages Type <sup class="text-danger">*</sup></label>
                                                            <select name="employee_wage_type" id="employee_wage_type" class="form-control common-select2" style="width: 100% !important" required>
                                                                <option value="">Select Wages Type</option>
                                                                @foreach ($salaryTypes as $salaryType)
                                                                    <option value="{{$salaryType->id}}">{{$salaryType->salary_type}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-2 col-12 changeColStyle">
                                                            <label for="mode">Employee Grade <sup class="text-danger">*</sup></label>
                                                            <select name="grade" id="grade" class="form-control common-select2" style="width: 100% !important" required>
                                                                <option value="">Select Grade</option>
                                                                @foreach ($grades as $grade)
                                                                    <option value="{{$grade->id}}">{{$grade->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-2 col-12 changeColStyle">
                                                            <label for="mode">Payment Method <sup class="text-danger">*</sup></label>
                                                            <select name="payment_method" id="payment_method" class="form-control common-select2" style="width: 100% !important" required>
                                                                <option value="">Select Payment Method</option>
                                                                <option value="bank">Bank</option>
                                                                <option value="cash">Cash</option>
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
                                    <th>Salary type</th>
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

    $(document).on("keyup", "#present_address", function(e) {
                var value = $(this).val();
                $("#parmanent_address").val(value);
            });
     // A/C CODE get
    $("#fld_ac_name").change(function (e) { 
        e.preventDefault();
        var account_head_id = $('#fld_ac_name option:selected').val();
        $.ajax({
            type:"post",
            url: "{{URL::to('account-head')}}",
            data:{
                "account_head_id":account_head_id
            },
            success:function(data){
                $('#fld_ac_code').empty();
                document.getElementById("fld_ac_code").value = data;              
            }
        });
    });
    // ACCOUNT HEAD get
    $("#fld_ac_code").change(function (e) { 
        e.preventDefault();
        var fld_ac_code = $('#fld_ac_code').val();
        $.ajax({
            type:"post",
            url: "{{URL::to('account-code')}}",
            data:{
                "fld_ac_code":fld_ac_code
            },
            success:function(data){
                $('#fld_ac_name').empty();
                var optionHtml = '<option value=""> Select Section </option>';
                data.forEach(function(element, index) {
                    var isSelected = '';
                    if(fld_ac_code == element.fld_ac_code){
                        isSelected = 'selected';
                    }
                    optionHtml += "<option value='"+element.id +"' "+isSelected+">"+ element.fld_ac_head+"</option>";
                });
                $('#fld_ac_name').html(optionHtml);
            }
        })
    });
</script>
@endpush