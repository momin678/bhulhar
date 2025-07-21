@php
    $emirates=array('Abu Dhabi','Ajman','Dubai','Fujairah','Ras Al Khaimah','Sharjah','Umm Al Quwain');
    $languages= array('Bangla','English','Urdu','Arabic','Hindi');
    $employee_roles= array('Principle','Teacher', 'Admin', 'Accounts Executive', 'Librarian','Driver','Clerk','Cleaner','Secretary','Accountant','Trainer');
@endphp
<style>
    input[type=text], select, textarea {
    height: 2.5rem;
    font-size: 12px !important;
}
</style>
<section class="print-hideen border-bottom" style="padding: 10px;">
    <div class="row">
        <div class="col-6 pt-2 pl-2">
            <h5 style="font-family:Cambria;font-size: 2.3rem;"><b>View Employee Profile</b> </h5>
        </div>
        <div class="col-6">
            <div class="d-flex flex-row-reverse">

                <div class="mIconStyleChange"><a href="#" class="close btn-icon btn btn-danger mIconStyleChange212" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class='bx bx-x'></i></span></a></div>
                @if ($employee_info->status != 1)<div class="mIconStyleChange">
                <span id="fappprove-rejection-button">
                    <a href="{{ route('employees-approve',$employee_info->id) }}" class="btn btn-sm btn-primary mr-2 fhide-button-1"
                    >Approve</a>
                </span>
                </div>
            @endif
            <div class="mIconStyleChange">
            <span id="fappprove-rejection-button">
                <a data-id="{{ route('employees.edit',$employee_info->id) }}" class="btn btn-sm btn-success mr-2 employee_approve fhide-button-1 employee-edit"
                >Edit</a>
            </span>
            </div>

                {{-- <div class="mIconStyleChange"><a href="#" onclick="window.print();" class="btn btn-icon btn-secondary"><i class='bx bx-printer'></i></a></div>
                <div class="mIconStyleChange"><a href="#" onclick="window.print();" class="btn btn-icon btn-primary"><i class='bx bxs-file-pdf'></i></a></div>
                <div class="mIconStyleChange"><a href="#" onclick="window.print();" class="btn btn-icon btn-light"><i class='bx bxs-virus'></i></a></div> --}}
            </div>
        </div>
    </div>
</section>
<div class="modal-body"  style="background: azure;">
    <div class="card-body" style="padding: 0px" >
        <div class="content-body ">
            <form action="{{route('employees.update', $employee_info->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="cardStyleChange">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="row mx-0" >
                                    <div class="col-md-12 col-12 changeColStyle " >
                                        <h5 style="color: #000;margin-top: 0.5rem;;font-size:19px">Employee Credentials :</h5>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="profile-img pl-1 pt-1">
                                            @if ($employee_info->employee_image)
                                                <img src="{{ asset('storage/upload/employee/'.$employee_info->employee_image)}}" alt="" width="50" height="50" id="edit_motherEmirateImgPreview">
                                            @else
                                                <img src="assets/backend/app-assets/icon/profile-pic.png" alt="" width="70" height="70" id="edit_motherEmirateImgPreview">
                                            @endif
                                        </div>
                                        <div class="pl-0 mt-1">
                                            <p style="line-height: 10%; font-size:10px">
                                                ID: {{$employee_info->emp_id}}
                                            </p>
                                            <p style="line-height: 10%; font-size:10px">Status:Onrole</p>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="hidden" class="form-control inputFieldHeight" name="eid" id="eid" value="{{$employee_info->emp_id}}">
                                        <label for="mode">Salutation <sup class="text-danger">*</sup></label>
                                        <select name="salutation"
                                            class="inputFieldHeight form-control common-select2 @error('salutation') error @enderror"
                                            id="" readonly>
                                            <option value="">Select salutation</option>
                                            <option value="Mr" {{ $employee_info->salutation == 'Mr' ? 'selected' : '' }}> Mr</option>
                                            <option value="Mrs" {{ $employee_info->salutation == 'Mrs' ? 'selected' : '' }}> Mrs</option>
                                            <option value="Dr" {{$employee_info->salutation == 'Dr' ? 'selected' : '' }}>Dr </option>
                                            <option value="Prof" {{ $employee_info->salutation == 'Prof' ? 'selected' : '' }}>Prof </option>
                                            <option value="Rev" {{ $employee_info->salutation == 'Rev' ? 'selected' : '' }}>Rev </option>
                                            <option value="Etc" {{ $employee_info->salutation == 'Etc' ? 'selected' : '' }}> Etc</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="mode">Full Name <sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control inputFieldHeight" name="first_name" id="first_name" onkeypress='return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || (event.charCode == 32) || (event.charCode == 46))' value="{{$employee_info->first_name}}" readonly >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="row mx-0" >
                                    <div class="col-md-12 col-12 changeColStyle " >
                                        <h5 style="color: #000;margin-top: 0.5rem;;font-size:19px">Employee Address :</h5>
                                    </div>
                                    <div class="col-md-4 col-12 changeColStyle">
                                        <label for="mode">Present Address <sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control inputFieldHeight" name="present_address" id="present_address" value="{{$employee_info->present_address}}" readonly>
                                    </div>
                                    <div class="col-md-2 col-12 changeColStyle">
                                        <label for="mode">Country code <sup class="text-danger">*</sup></label>
                                        {{-- <input type="text" class="form-control inputFieldHeight" name="nationality" id="nationality" readonly> --}}
                                        <select name="countrytCode" id="countrytCode" class="form-control common-select2" style="width: 100% !important" readonly>
                                            <option value="">Select ...</option>
                                            @foreach ($countrytCode as $countrytCode)
                                                <option value="{{$countrytCode->id}}" {{ ($employee_info->country_code == $countrytCode->id)?'selected':'' }} >+{{$countrytCode->phonecode}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 col-12 changeColStyle">
                                        <label for="mode">Contact Number <sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control inputFieldHeight" name="contact_number" id="contact_number" onkeypress='return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode == 45))'value="{{$employee_info->contact_number}}"readonly>
                                    </div>
                                    <div class="col-md-3 col-12 changeColStyle">
                                        <label for="mode">E-mail</label>
                                        <input type="email" style="font-size:12px" class="form-control inputFieldHeight" oninput="this.value = this.value.toLowerCase()" name="email" id="email" value="{{$employee_info->email}}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row ">
                        <div class="col-12">
                            <div class="card">
                                <div class="row mx-0">
                                    <div class="col-md-12 col-12 changeColStyle pt-1" >
                                        <h5 style="color: #000;margin-top: 0.5rem;;font-size:19px">Identification :</h5>
                                    </div>
                                    <div class="col-md-4 col-12 changeColStyle">
                                        <label for="mode">EID / NID Number <sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control inputFieldHeight" name="emirates_id" id="emirates_id"
                                            value="{{$employee_info->emirates_id}}" readonly
                                        >
                                    </div>
                                    <div class="col-md-4 col-12 changeColStyle">
                                        <label for="mode" style="white-space: nowrap;">Resident Type <sup class="text-danger">*</sup></label>
                                        {{-- <input type="text" class="form-control inputFieldHeight" name="nationality" id="nationality" readonly> --}}
                                        <select name="visa_type" id="visa_type" class="form-control common-select2" style="width: 100% !important" readonly>
                                            <option value="Permanent" {{$employee_info->visa_type == 'Permanent'?'selected':''}}>Permanent</option>
                                            <option value="Visit" {{$employee_info->visa_type == 'Visit'?'selected':''}}> Visit</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 col-12 changeColStyle">
                                        <label for="mode">Expiry Date <sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control inputFieldHeight datepicker" autocomplete="off" name="visa_expiry_date" id="visa_expiry_date" min="{{Carbon\Carbon::now()->addMonth(1)->format('Y-m-d')}}" max="{{Carbon\Carbon::now()->addYear(12)->format('Y-m-d')}}" value="{{date('d/m/Y',strtotime($employee_info->visa_expiry_date))}}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row ">
                        <div class="col-12">
                            <div class="card">
                                <div class="row mx-0">
                                    <div class="col-md-12 col-12 changeColStyle pt-1" >
                                        <h5 style="color: #000;margin-top: 0.5rem;;font-size:19px">Department :</h5>
                                    </div>
                                    <div class="col-md-3 col-12 changeColStyle">
                                        <label for="mode">Department <sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control inputFieldHeight" value="{{$employee_info->div->name}}" readonly>
                                        {{-- <select name="division" id="division" class="form-control common-select2" style="width: 100% !important" readonly>
                                            <option value="">Select ...</option>
                                            @foreach ($divisions as $division)
                                                <option value="{{$division->id}}" {{$division->id == $employee_info->division?'selected':''}}>{{$division->name}}</option>
                                            @endforeach
                                        </select> --}}
                                    </div>
                                    <div class="col-md-3 col-12 changeColStyle">
                                        <label for="mode">DESIGNATION <sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control inputFieldHeight" value="{{$employee_info->dpt?$employee_info->dpt->name:''}}" readonly>
                                        {{-- <select name="department" id="department" class="form-control common-select2" style="width: 100% !important" readonly>
                                            <option value="">Select ...</option>
                                            @foreach ($department as $department)
                                                <option value="{{$department->id}}" {{ ($employee_info->department == $department->id)?'selected':'' }} >{{$department->name}}</option>
                                            @endforeach
                                        </select> --}}
                                    </div>
                                    <div class="col-md-3 col-12 changeColStyle">
                                        <label for="mode">Joining Date <sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control inputFieldHeight datepicker" autocomplete="off" name="joining_date" id="joining_date" value="{{date('d/m/Y',strtotime($employee_info->joining_date))}}" readonly>
                                    </div>
                                    <div class="col-md-3 col-12 changeColStyle">
                                        <label for="mode" style="white-space: nowrap;">Job Status <sup class="text-danger">*</sup></label>
                                        {{-- <input type="text" class="form-control inputFieldHeight" name="nationality" id="nationality" readonly> --}}
                                        <select name="job_type" id="job_type" class="form-control common-select2" style="width: 100% !important" readonly>
                                            <option value="full_time" {{$employee_info->job_type == "full_time"?'selected':''}}>Full Time</option>
                                            <option value="part_time" {{$employee_info->job_type == "part_time"?'selected':''}}> Part time</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row ">
                        <div class="col-12">
                            <div class="card">
                                <div class="row mx-0">
                                    <div class="col-md-6 col-12 changeColStyle pt-1" >
                                        <h5 style="color: #000;margin-top: 0.5rem;;font-size:19px">Emergency Contact Details :</h5>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="mode">Country code <sup class="text-danger">*</sup></label>
                                                {{-- <input type="text" class="form-control inputFieldHeight" name="nationality" id="nationality" readonly> --}}
                                                <select name="em_countrytCode" id="em_countrytCode" class="form-control common-select2" style="width: 100% !important" readonly>
                                                    <option value="">Select ...</option>
                                                    @foreach ($countrytCode2 as $countrytCode)
                                                        <option value="{{$countrytCode->id}}" {{ ($employee_info->em_country_code == $countrytCode->id)?'selected':'' }}>+{{$countrytCode->phonecode}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3 col-12 changeColStyle">
                                                <label for="mode">Contact Number <sup class="text-danger">*</sup></label>
                                                <input type="text" class="form-control inputFieldHeight" name="em_contact_number" id="em_contact_number" onkeypress='return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode == 45))' value="{{$employee_info->em_contact_number}}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12 changeColStyle pt-1" >
                                        <h5 style="color: #000;margin-top: 0.5rem;;font-size:19px">Employment Grade :</h5>
                                        <label for="mode">Employee Grade<sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control inputFieldHeight text-center" value="{{$employee_info->gradeNeed->name}}" readonly>
                                        {{-- <select name="grade" id="grade" class="form-control common-select2" style="width: 100% !important" readonly>
                                            <option value="">Select Grade</option>
                                            @foreach ($grades as $grade)
                                                <option value="{{$grade->id}}" {{ ($employee_info->grade == $grade->id)?'selected':'' }} >{{$grade->name}}</option>
                                            @endforeach
                                        </select> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
