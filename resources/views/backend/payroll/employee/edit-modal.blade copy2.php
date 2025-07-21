
<!-- summernote css/js -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

<div class="modal-header" style="height: 50px">
    <div class="row">
        <div class="col-md-4">
            <h5 class="modal-title" id="">EMPLOYEE EDIT</h5>
        </div>
        <div class="col-md-8 text-right">
            <button type="botton" style="margin-top: -12px;" class="btn btn-sm " data-dismiss="modal">
                <span aria-hidden="true" class="icon-style">&times;</span></button>
        </div>
    </div>
</div>

<div class="modal-body">
    <div class="card-body" >
        <div class="content-body p-1">
            <form action="{{route('employees.update', $employee_info->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="cardStyleChange">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="row mx-0" >
                                    <div class="col-md-12 col-12 changeColStyle " style="background: #afafaf; ">
                                        <h5 style="color: white;margin-top: 0.5rem;">Employee Credentials :</h5>
                                    </div>
                                    <div class="col-md-1" >
                                        @if ($employee_info->employee_image)
                                            <div class="profile-img pl-1 mr-1 pt-1">
                                                <img src="{{ asset('storage/upload/employee/'.$employee_info->employee_image)}}" alt="" width="50" height="50" id="edit_motherEmirateImgPreview">
                                            </div>
                                        @else
                                            <div class="profile-img pl-1 mr-1 pt-1">
                                                <img src="assets/backend/app-assets/icon/profile-pic.png" alt="" width="50" height="50" id="edit_motherEmirateImgPreview">
                                            </div>
                                        @endif
                                        <div class="pl-1 mt-1">
                                            <p style="line-height: 10%; font-size:10px">
                                                ID: {{$eid}}
                                            </p>
                                            <p style="line-height: 10%; font-size:10px">
                                                Status: Onrole
                                            </p>
                                        </div>
                                    </div>  
                                    <div class="col-md-11">
                                        <br>
                                        <div class="row">
                                            <input type="hidden" class="form-control inputFieldHeight" name="eid" id="eid" value="{{$employee_info->emp_id}}"  
                                            >
                                            <div class="col-sm-2 col-12 changeColStyle habib">
                                                <label for="mode">Frist Name <sup class="text-danger">*</sup></label>
                                                <input type="text" class="form-control inputFieldHeight" name="first_name" id="first_name" 
                                                    onkeypress='return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || (event.charCode == 32) || (event.charCode == 46))' 
                                                value="{{$employee_info->first_name}}" required >
                                            </div>
                                            <div class="col-sm-2 col-12 changeColStyle habib">
                                                <label for="mode"> Last Name <sup class="text-danger">*</sup></label>
                                                <input type="text" class="form-control inputFieldHeight" name="last_name" id="last_name" 
                                                    onkeypress='return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || (event.charCode == 32) || (event.charCode == 46))' 
                                                value="{{$employee_info->last_name}}" required >
                                            </div>
                                            <div class="col-sm-2 col-12 changeColStyle habib">
                                                <label for="mode">Fathers Name <sup class="text-danger">*</sup></label>
                                                <input type="text" class="form-control inputFieldHeight" name="father_name" id="father_name"
                                                    onkeypress='return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || (event.charCode == 32) || (event.charCode == 46))' required
                                                    value="{{$employee_info->father_name}}"
                                                    >
                                            </div>
                                            <div class="col-sm-2 col-12 changeColStyle habib">
                                                <label for="mode">Mothers Name <sup class="text-danger">*</sup></label>
                                                <input type="text" class="form-control inputFieldHeight" name="mother_name" id="mother_name"
                                                    onkeypress='return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || (event.charCode == 32) || (event.charCode == 46))' required
                                                    value="{{$employee_info->mother_name}}"
                                                >
                                            </div>
                                            <div class="col-sm-2 col-12 changeColStyle habib">
                                                <label for="mode">Date of Birth <sup class="text-danger">*</sup></label>
                                                <input type="date" class="form-control inputFieldHeight" name="dob" id="dob" min="{{Carbon\Carbon::now()->subYears(100)->format('Y-m-d')}}" 
                                                    max="{{Carbon\Carbon::now()->subYears(10)->format('Y-m-d')}}" value="{{$employee_info->dob}}" required
                                                >
                                            </div>
                                            
                                            <div class="col-sm-2 col-12 changeColStyle habib">
                                                <label for="mode">Nationality <sup class="text-danger">*</sup></label>
                                                {{-- <input type="text" class="form-control inputFieldHeight" name="nationality" id="nationality" required> --}}
                                                <select name="nationality" id="nationality" class="form-control common-select2" style="width: 100% !important" required>
                                                    <option value="">Select Nationality</option>
                                                    @foreach ($nationality as $nationality)
                                                        <option value="{{$nationality->id}}" {{ ($employee_info->nationality == $nationality->id)?'selected':'' }}>{{$nationality->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-2 col-12 changeColStyle habib">
                                                <label for="mode">Employee Image <sup class="text-danger">*</sup></label>
                                                <input type="file" class="form-control inputFieldHeight" name="employee_image" id="edit_motherEmirateImgChange" >
                                                <input type="hidden" value="{{ $employee_info->employee_image }}" name="old_employee_image">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <div class="col-12 col-md-12">
                    <div class="row ">
                        <div class="col-12">
                            <div class="card">
                                <div class="row mx-0">
                                    <div class="col-sm-12 col-12 changeColStyle pt-1" style="background: #afafaf">
                                        <h5 style="color: white">Employee Address :</h5>
                                    </div>
                                    <div class="col-sm-3 col-12 changeColStyle">
                                        <label for="mode">Present Address <sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control inputFieldHeight" name="present_address" id="present_address"
                                            value="{{$employee_info->present_address}}" required
                                        >
                                    </div>
                                    <div class="col-sm-3 col-12 changeColStyle">
                                        <label for="mode">Present City <sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control inputFieldHeight" name="pr_city" value="{{$employee_info->pr_city}}" id="pr_city" required>
                                    </div>
                                    <div class="col-sm-3 col-12 changeColStyle">
                                        <label for="mode">Present Country <sup class="text-danger">*</sup></label>
                                        {{-- <input type="text" class="form-control inputFieldHeight" name="pr_country" value="{{$employee_info->pr_country}}" id="pr_country" required> --}}
                                        <select name="pr_country" id="pr_country" class="form-control common-select2" style="width: 100% !important" required>
                                            <option value="">Select ...</option>
                                            @foreach ($countries as $countrytCode1)
                                                <option value="{{$countrytCode1->id}}" {{ ($employee_info->pr_country == $countrytCode1->id)?'selected':'' }} >{{$countrytCode1->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-3 col-12 changeColStyle">
                                        <label for="mode">Permanent Address <sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control inputFieldHeight" name="parmanent_address" id="parmanent_address"
                                            value="{{$employee_info->parmanent_address}}" required
                                        >
                                    </div>
                                    <div class="col-sm-3 col-12 changeColStyle">
                                        <label for="mode">Permanent City <sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control inputFieldHeight" name="pa_city" value="{{$employee_info->pa_city}}" id="pr_city" required>
                                    </div>
                                    <div class="col-sm-3 col-12 changeColStyle">
                                        <label for="mode">Permanent Country <sup class="text-danger">*</sup></label>
                                        {{-- <input type="text" class="form-control inputFieldHeight" name="pa_country" value="{{$employee_info->pa_country}}" id="pr_country" required> --}}
                                        <select name="pa_country" id="pa_country" class="form-control common-select2" style="width: 100% !important" required>
                                            <option value="">Select ...</option>
                                            @foreach ($countries as $countrytCode1)
                                                <option value="{{$countrytCode1->id}}" {{ ($employee_info->pa_country == $countrytCode1->id)?'selected':'' }} >{{$countrytCode1->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-3 col-12 changeColStyle">
                                        <label for="mode">Country code <sup class="text-danger">*</sup></label>
                                        {{-- <input type="text" class="form-control inputFieldHeight" name="nationality" id="nationality" required> --}}
                                        <select name="countrytCode" id="countrytCode" class="form-control common-select2" style="width: 100% !important" required>
                                            <option value="">Select ...</option>
                                            @foreach ($countrytCode as $countrytCode)
                                                <option value="{{$countrytCode->id}}" {{ ($employee_info->country_code == $countrytCode->id)?'selected':'' }} >+{{$countrytCode->dial}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-3 col-12 changeColStyle">
                                        <label for="mode">Contact Number <sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control inputFieldHeight" name="contact_number" id="contact_number" 
                                            onkeypress='return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode == 45))'
                                            value="{{$employee_info->contact_number}}"
                                        required>
                                    </div>
                                    
                                    <div class="col-sm-3 col-12 changeColStyle">
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
                                <div class="row mx-0">
                                    <div class="col-sm-12 col-12 changeColStyle pt-1" style="background: #afafaf">
                                        <h5 style="color: white">Emergency Contact Details :</h5>
                                    </div>
                                    <div class="col-sm-3 col-12 changeColStyle">
                                        <label for="mode">Name <sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control inputFieldHeight" name="em_name" id="em_name" 
                                            value="{{$employee_info->em_name}}"
                                        >
                                    </div>
                                    <div class="col-sm-2 col-12 changeColStyle">
                                        <label for="mode"> Address <sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control inputFieldHeight" name="em_parmanent_address" id="em_parmanent_address" 
                                            value="{{$employee_info->em_parmanent_address}}"
                                        >
                                    </div>
                                    <div class="col-sm-2 col-12 changeColStyle">
                                        <label for="mode">Country code <sup class="text-danger">*</sup></label>
                                        {{-- <input type="text" class="form-control inputFieldHeight" name="nationality" id="nationality" required> --}}
                                        <select name="em_countrytCode" id="em_countrytCode" class="form-control common-select2" style="width: 100% !important" required>
                                            <option value="">Select ...</option>
                                            @foreach ($countrytCode2 as $countrytCode)
                                                <option value="{{$countrytCode->id}}" {{ ($employee_info->em_country_code == $countrytCode->id)?'selected':'' }}>+{{$countrytCode->dial}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-2 col-12 changeColStyle">
                                        <label for="mode">Contact Number <sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control inputFieldHeight" name="em_contact_number" id="em_contact_number" 
                                            onkeypress='return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode == 45))'
                                            value="{{$employee_info->em_contact_number}}"
                                        >
                                    </div>
                                    
                                    <div class="col-sm-3 col-12 changeColStyle">
                                        <label for="mode">E-mail</label>
                                        <input type="email" class="form-control inputFieldHeight" name="em_email" id="em_email" 
                                            value="{{$employee_info->em_email}}"
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row ">
                        <div class="col-12">
                            <div class="card">
                                <div class="row mx-0">
                                    <div class="col-sm-12 col-12 changeColStyle pt-1" style="background: #afafaf">
                                        <h5 style="color: white">Reference :</h5>
                                    </div>
                                    <div class="col-sm-3 col-12 changeColStyle">
                                        <label for="mode">Name <sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control inputFieldHeight" name="r_name" id="r_name" 
                                            value="{{$employee_info->r_name}}"
                                        >
                                    </div>
                                    <div class="col-sm-2 col-12 changeColStyle">
                                        <label for="mode"> Address <sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control inputFieldHeight" name="r_parmanent_address" id="r_parmanent_address" 
                                            value="{{$employee_info->r_parmanent_address}}"
                                        >
                                    </div>
                                    <div class="col-sm-2 col-12 changeColStyle">
                                        <label for="mode">Country code <sup class="text-danger">*</sup></label>
                                        {{-- <input type="text" class="form-control inputFieldHeight" name="nationality" id="nationality" required> --}}
                                        <select name="r_countrytCode" id="r_countrytCode" class="form-control common-select2" style="width: 100% !important" required>
                                            <option value="">Select ...</option>
                                            @foreach ($countrytCode3 as $countrytCode)
                                                <option value="{{$countrytCode->id}}" {{ ($employee_info->r_country_code == $countrytCode->id)?'selected':'' }}>+{{$countrytCode->dial}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-2 col-12 changeColStyle">
                                        <label for="mode">Contact Number <sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control inputFieldHeight" name="r_contact_number" id="r_contact_number" 
                                            onkeypress='return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode == 45))'
                                                value="{{$employee_info->r_contact_number}}"
                                            >
                                    </div>
                                    
                                    <div class="col-sm-3 col-12 changeColStyle">
                                        <label for="mode">E-mail</label>
                                        <input type="email" class="form-control inputFieldHeight" name="r_email" id="r_email" 
                                            value="{{$employee_info->r_email}}"
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row ">
                        <div class="col-12">
                            <div class="card">
                                <div class="row mx-0">
                                    <div class="col-sm-12 col-12 changeColStyle pt-1" style="background: #afafaf">
                                        <h5 style="color: white">Identification :</h5>
                                    </div>
                                    <div class="col-sm-2 col-12 changeColStyle">
                                        <label for="mode">EID / NID Number <sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control inputFieldHeight" name="emirates_id" id="emirates_id"
                                            value="{{$employee_info->emirates_id}}" required
                                        >
                                    </div>
                                    <div class="col-sm-2 col-12 changeColStyle">
                                        <label for="mode">EID/NID Image <sup class="text-danger">*</sup></label>
                                        <input type="file" class="form-control inputFieldHeight" name="emirates_image" id="edit_fatherEmirateImgChange">
                                        <input type="hidden" value="{{ $employee_info->emirates_image }}" name="old_emirates_image">
                                    </div>
                                    <div class="col-sm-1 col-12 changeColStyle">
                                        @if ($employee_info->emirates_image)
                                            <div class="profile-img pl-1 mr-1 pt-1">
                                                <img src="{{ asset('storage/upload/employee/'.$employee_info->emirates_image)}}" alt="" width="50" height="50" id="edit_fatherEmirateImgPreview">
                                            </div>
                                        @else
                                            <div class="profile-img pl-1 mr-1 pt-1">
                                                <img src="assets/backend/app-assets/icon/profile-pic.png" alt="" width="50" height="50" id="edit_fatherEmirateImgPreview">
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
                                        <input type="file" class="form-control inputFieldHeight" name="passport_image" id="edit_passportImg" >
                                        <input type="hidden" value="{{ $employee_info->passport_image }}" name="old_passport_image">
                                    </div>
                                    <div class="col-sm-1 col-12 changeColStyle">
                                        @if ($employee_info->passport_image)
                                            <div class="profile-img pl-1 mr-1 pt-1">
                                                <img src="{{ asset('storage/upload/employee/'.$employee_info->passport_image)}}" alt="" width="50" height="50" id="edit_passportImgPreview">
                                            </div>
                                        @else
                                            <div class="profile-img pl-1 mr-1 pt-1">
                                                <img src="assets/backend/app-assets/icon/profile-pic.png" alt="" width="50" height="50" id="edit_passportImgPreview">
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-sm-2 col-12 changeColStyle">
                                        <label for="mode">Pass issuance Country <sup class="text-danger">*</sup></label>
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
                                <div class="row mx-0">
                                    <div class="col-sm-12 col-12 changeColStyle pt-1" style="background: #afafaf">
                                        <h5 style="color: white">Department :</h5>
                                    </div>
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
                                <div class="row mx-0">
                                    <div class="col-sm-12 col-12 changeColStyle pt-1" style="background: #afafaf">
                                        <h5 style="color: white">Academic And Profetional Qualification :</h5>
                                    </div>
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
                                        <label for="mode">Certificate Copy <sup class="text-danger">*</sup></label>
                                        <input type="file" class="form-control inputFieldHeight" name="quali_image" id="edit_quali_image" >
                                        <input type="hidden" value="{{ $employee_info->quali_image }}" name="old_quali_image">
                                        
                                    </div>
                                    <div class="col-sm-1 col-12 changeColStyle">
                                        @if ($employee_info->quali_image)
                                            <div class="profile-img pl-1 mr-1 pt-1">
                                                <img src="{{ asset('storage/upload/employee/'.$employee_info->quali_image)}}" alt="" width="50" height="50" id="edit_qualiImgPreview">
                                            </div>
                                        @else
                                            <div class="profile-img pl-1 mr-1 pt-1">
                                                <img src="assets/backend/app-assets/icon/profile-pic.png" alt="" width="50" height="50" id="edit_qualiImgPreview">
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-1">
                                        <div class="form-group">
                                            <div class="col p-0">
                                                <button type="button" class="btn btn-primary btn_create formButton add-line" data-repeater-delete title="Add" data-repeater-create>
                                                    <div class="d-flex">
                                                        <div class="formSaveIcon">
                                                            <img  src="{{asset('assets/backend/app-assets/icon/add-icon.png')}}" alt="" srcset=""  width="25">
                                                        </div>
                                                        <div><span>Add</span></div>
                                                    </div>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="repeater-default" id="form-repeat-container">
                                            <div class="from-body">
                                                <div class="row start">
                                                        
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row data">
                                                @foreach($pro_quali as $others)
                                                    <div class="col-md-2 img" >
                                                        <span class="btn btn-warning invoice-item-delete" id="" data_target="{{ route('employeeProDocumentDelete',$others) }}"><i class="bx bx-trash"></i></span>
                                                        <a href="{{ asset('storage/upload/employee/post_quali/'.$others->image)}}" target="_blank">
                                                            <img src="{{ asset('storage/upload/employee/post_quali/'.$others->image)}}" title="{{$others->name}}" style="height:50px;width:50px" class="img-fluid" alt="" >
                                                        </a>  
                                                    </div>
                                                @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row ">
                        <div class="col-12">
                            <div class="card">
                                <div class="row mx-0">
                                    <div class="col-sm-12 col-12 changeColStyle pt-1" style="background: #afafaf">
                                        <h5 style="color: white">Bank Details :</h5>
                                    </div>
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
                                        <label for="mode">IBAN Number <sup class="text-danger">*</sup></label>
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
                                <div class="row mx-0">
                                    <div class="col-sm-12 col-12 changeColStyle pt-1" style="background: #afafaf">
                                        <h5 style="color: white">Employment Grade :</h5>
                                    </div>
                                    <div class="col-sm-2 col-12 changeColStyle">
                                        <label for="mode">Visa expiry date <sup class="text-danger">*</sup></label>
                                        <input type="date" class="form-control inputFieldHeight" name="visa_expiry_date" id="visa_expiry_date"
                                            min="{{Carbon\Carbon::now()->addMonth(1)->format('Y-m-d')}}" max="{{Carbon\Carbon::now()->addYear(12)->format('Y-m-d')}}"
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
                                        <label for="mode">Employee Grade<sup class="text-danger">*</sup></label>
                                        <select name="grade" id="grade" class="form-control common-select2" style="width: 100% !important" required>
                                            <option value="">Select Grade</option>
                                            @foreach ($grades as $grade)
                                                <option value="{{$grade->id}}" {{ ($employee_info->grade == $grade->id)?'selected':'' }} >{{$grade->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-3 col-12 changeColStyle">
                                        <label for="mode">Employment Location <sup class="text-danger">*</sup></label>
                                        {{-- <input type="text" class="form-control inputFieldHeight" name="nationality" id="nationality" required> --}}
                                        <select name="employment_location" id="employment_location" class="form-control common-select2" style="width: 100% !important" required>
                                            <option value="" >Select country</option>
                                            @foreach ($countries as $country)
                                                <option value="{{$country->id}}" {{ ($employee_info->employment_location == $country->id)?'selected':'' }}>{{$country->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-2 col-12 changeColStyle">
                                        <label for="mode">Currency <sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control inputFieldHeight" name="currency" value="{{$employee_info->currency}}" id="currency" readonly required>
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
                    <div class="row ">
                        <div class="col-12">
                            <div class="card">
                                <div class="row mx-0">
                                    <div class="col-sm-12 col-12 changeColStyle pt-1" style="background: #afafaf">
                                        <h5 style="color: white">Description :</h5>
                                    </div>
                                    <div class="col-sm-6 col-12 changeColStyle">
                                        <label for="mode">Description <sup class="text-danger">*</sup></label>
                                        <textarea  class="form-control summernote" id="" name="description" rows="4" cols="50">
                                            {!! $employee_info->description !!}
                                        </textarea>
                                    </div>
                                    <div class="col-sm-6 col-12 changeColStyle">
                                        <label for="mode">Sub Description <sup class="text-danger">*</sup></label>
                                        <textarea  class="form-control summernote" id="" name="sub_description" rows="4" cols="50">
                                            {!! $employee_info->sub_description!!}
                                        </textarea>  
                                    </div>
                                    {{-- <div class="col-sm-2 col-12 changeColStyle">
                                        <label for="mode">Scan Copy <sup class="text-danger">*</sup></label>
                                        <input type="file" class="form-control inputFieldHeight" name="quali_image" id="quali_image" required>
                                    </div> --}}
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
                                <div><span> UPDATE</span></div>
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
</div>
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#summernote').summernote({
                    height: 100
                });

                $('#summernote2').summernote({
                    height: 100
                });
            });
                // $('#summernote').summernote({
                //     height: 200
                // });
        </script>