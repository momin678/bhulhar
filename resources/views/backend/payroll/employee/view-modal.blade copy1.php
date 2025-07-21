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
        <div class="col-6">
            <h5  style="padding: 12px 10px;">Employee Profile</h5>
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
<div class="modal-body">
    <div class="card-body" style="padding: 0px" >
        <div class="content-body ">
            <form action="#" method="POST">
                <div class="cardStyleChange">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="row mx-0" >
                                    <div class="col-md-12 col-12 changeColStyle " >
                                        <h5 style="color: rgb(0, 0, 0);margin-top: 0.5rem; font-size:19px">Employee Credentials :</h5>
                                    </div>
                                    <div class="col-md-1" style="margin-top: 30px; padding:4px">
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
                                    <div class="col-md-11 pl-2">
                                        <br>
                                        <div class="row">
                                            <input type="hidden" class="form-control inputFieldHeight" name="eid" id="eid" value="{{$employee_info->emp_id}}"
                                            >
                                            <div class="col-sm-2 col-12 changeColStyle habib">
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
                                            <div class="col-sm-2 col-12 changeColStyle habib">
                                                <label for="mode">Frist Name <sup class="text-danger">*</sup></label>
                                                <input type="text" class="form-control inputFieldHeight" name="first_name" id="first_name"
                                                    onkeypress='return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || (event.charCode == 32) || (event.charCode == 46))'
                                                value="{{$employee_info->first_name}}" readonly >
                                            </div>
                                            <div class="col-sm-2 col-12 changeColStyle habib">
                                                <label for="mode">Middle Name <sup class="text-danger">*</sup></label>
                                                <input type="text" class="form-control inputFieldHeight" name="middle_name" id="middle_name"
                                                    onkeypress='return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || (event.charCode == 32) || (event.charCode == 46))  '
                                                    value="{{$employee_info->middle_name}}"
                                                    readonly >
                                            </div>
                                            <div class="col-sm-2 col-12 changeColStyle habib">
                                                <label for="mode"> Last Name <sup class="text-danger">*</sup></label>
                                                <input type="text" class="form-control inputFieldHeight" name="last_name" id="last_name"
                                                    onkeypress='return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || (event.charCode == 32) || (event.charCode == 46))'
                                                value="{{$employee_info->last_name}}" readonly >
                                            </div>
                                            <div class="col-sm-2 col-12 changeColStyle habib">
                                                <label for="mode">Father's Name <sup class="text-danger">*</sup></label>
                                                <input type="text" class="form-control inputFieldHeight" name="father_name" id="father_name"
                                                    onkeypress='return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || (event.charCode == 32) || (event.charCode == 46))' readonly
                                                    value="{{$employee_info->father_name}}"
                                                    >
                                            </div>
                                            <div class="col-sm-2 col-12 changeColStyle habib">
                                                <label for="mode">Mother's Name <sup class="text-danger">*</sup></label>
                                                <input type="text" class="form-control inputFieldHeight" name="mother_name" id="mother_name"
                                                    onkeypress='return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || (event.charCode == 32) || (event.charCode == 46))' readonly
                                                    value="{{$employee_info->mother_name}}"
                                                >
                                            </div>
                                            <div class="col-sm-2 col-12 changeColStyle habib">
                                                <label for="mode">First Language <sup class="text-danger">*</sup></label>
                                                {{-- <input type="text" class="form-control inputFieldHeight" name="nationality" id="nationality" readonly> --}}
                                                <select name="first_language" id="first_language" class="form-control common-select2" style="padding-right: 0px; padding-left: 0px;" readonly>
                                                    <option value="">Select Language</option>
                                                    @foreach ($languages as $each_lang)
                                                        <option value="{{$each_lang}}" {{ $employee_info->first_lang == $each_lang ? 'selected' : '' }}> {{$each_lang}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-2 col-12 changeColStyle habib">
                                                <label for="mode">Second Language <sup class="text-danger">*</sup></label>
                                                {{-- <input type="text" class="form-control inputFieldHeight" name="nationality" id="nationality" readonly> --}}
                                                <select name="second_language" id="second_language" class="form-control common-select2" style="padding-right: 0px; padding-left: 0px;" readonly>
                                                    <option value="">Select Language</option>
                                                    @foreach ($languages as $each_lang)
                                                        <option value="{{$each_lang}}" {{ $employee_info->second_lang == $each_lang ? 'selected' : '' }}> {{$each_lang}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-2 col-12 changeColStyle habib">
                                                <label for="mode" style="white-space: nowrap;">Date of Birth <sup class="text-danger">*</sup></label>
                                                <input type="text" style="padding-right: 0px; padding-left:0px" autocomplete="off" class="form-control inputFieldHeight datepicker" name="dob" id="dob" min="{{Carbon\Carbon::now()->subYears(100)->format('Y-m-d')}}"
                                                    max="{{Carbon\Carbon::now()->subYears(10)->format('Y-m-d')}}" value="{{date('d/m/Y',strtotime($employee_info->dob))}}" readonly
                                                >
                                            </div>

                                            <div class="col-sm-2 col-12 changeColStyle habib">
                                                <label for="mode">Nationality <sup class="text-danger">*</sup></label>
                                                {{-- <input type="text" class="form-control inputFieldHeight" name="nationality" id="nationality" readonly> --}}
                                                <select name="nationality" style="padding-right: 0px; padding-left:0px" id="nationality" class="form-control common-select2" style="width: 100% !important" readonly>
                                                    <option value="">Select Nationality</option>
                                                    @foreach ($nationality as $nationality)
                                                        <option value="{{$nationality->id}}" {{ ($employee_info->nationality == $nationality->id)?'selected':'' }}>{{$nationality->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="row ">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="row mx-0">
                                            <div class="col-sm-12 col-12 changeColStyle pt-1">
                                                <h5 style="color: rgb(0, 0, 0);font-size:19px">Employee Address :</h5>
                                            </div>
                                            <div class="col-sm-3 col-12 changeColStyle">
                                                <label for="mode">Present Address <sup class="text-danger">*</sup></label>
                                                <input type="text" class="form-control inputFieldHeight" name="present_address" id="present_address"
                                                    value="{{$employee_info->present_address}}" readonly
                                                >
                                            </div>
                                            <div class="col-sm-3 col-12 changeColStyle">
                                                <label for="mode">Present City <sup class="text-danger">*</sup></label>
                                                <input type="text" class="form-control inputFieldHeight" name="pr_city" value="{{$employee_info->pr_city}}" id="pr_city" readonly>
                                            </div>
                                            <div class="col-sm-3 col-12 changeColStyle">
                                                <label for="mode">Present Country <sup class="text-danger">*</sup></label>
                                                {{-- <input type="text" class="form-control inputFieldHeight" name="pr_country" value="{{$employee_info->pr_country}}" id="pr_country" readonly> --}}
                                                <select name="pr_country" id="pr_country" class="form-control common-select2" style="width: 100% !important" readonly>
                                                    <option value="">Select ...</option>
                                                    @foreach ($countries as $countrytCode1)
                                                        <option value="{{$countrytCode1->id}}" {{ ($employee_info->pr_country == $countrytCode1->id)?'selected':'' }} >{{$countrytCode1->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-3 col-12 changeColStyle">
                                                <label for="mode">Permanent Address <sup class="text-danger">*</sup></label>
                                                <input type="text" class="form-control inputFieldHeight" name="parmanent_address" id="parmanent_address"
                                                    value="{{$employee_info->parmanent_address}}" readonly
                                                    readonly>
                                            </div>
                                            <div class="col-sm-3 col-12 changeColStyle">
                                                <label for="mode">Permanent City <sup class="text-danger">*</sup></label>
                                                <input type="text" class="form-control inputFieldHeight" name="pa_city" value="{{$employee_info->pa_city}}" id="pr_city" readonly>
                                            </div>
                                            <div class="col-sm-3 col-12 changeColStyle">
                                                <label for="mode">Permanent Country <sup class="text-danger">*</sup></label>
                                                {{-- <input type="text" class="form-control inputFieldHeight" name="pa_country" value="{{$employee_info->pa_country}}" id="pr_country" readonly> --}}
                                                <select name="pr_country" id="pr_country" class="form-control common-select2" style="width: 100% !important" readonly>
                                                    <option value="">Select ...</option>
                                                    @foreach ($countries as $countrytCode1)
                                                        <option value="{{$countrytCode1->id}}" {{ ($employee_info->pa_country == $countrytCode1->id)?'selected':'' }} >{{$countrytCode1->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-2 col-12 changeColStyle">
                                                <label for="mode">Country code <sup class="text-danger">*</sup></label>
                                                <input type="text" class="form-control inputFieldHeight" value="+ {{$employee_info->code->dial}}" readonly>
                                                {{-- <select name="countrytCode" id="countrytCode" class="form-control common-select2" style="width: 100% !important" readonly>
                                                    <option value="">Select ...</option>
                                                    @foreach ($countrytCode as $countrytCode)
                                                        <option value="{{$countrytCode->id}}" {{ ($employee_info->country_code == $countrytCode->id)?'selected':'' }} >+{{$countrytCode->dial}}</option>
                                                    @endforeach
                                                </select> --}}
                                            </div>
                                            <div class="col-sm-2 col-12 changeColStyle">
                                                <label for="mode">Contact Number <sup class="text-danger">*</sup></label>
                                                <input type="text" class="form-control inputFieldHeight" name="contact_number" id="contact_number"
                                                    onkeypress='return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode == 45))'
                                                    value="{{$employee_info->contact_number}}"
                                                readonly>
                                            </div>

                                            <div class="col-sm-2 col-12 changeColStyle">
                                                <label for="mode">E-mail</label>
                                                <input type="email" class="form-control inputFieldHeight" style="font-size:12px" name="email" id="email"
                                                    value="{{$employee_info->email}}"
                                                    readonly>
                                            </div>
                                            <div class="row ml-2" >
                                                <div class="col-sm-4  changeColStyle mx-0 px-0 " >
                                                    <label for="mode"></label>
                                                    <select name="local_countrytCode" id="local_countrytCode" class="form-control common-select2" readonly>
                                                        <option value="">Select ...</option>
                                                        @foreach ($countrytCode as $countrytCode1)
                                                            <option value="{{$countrytCode1->id}}" {{ ($employee_info->local_country_code == $countrytCode1->id)?'selected':'' }}>+{{$countrytCode1->dial}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-sm-8  changeColStyle mx-0 px-0">
                                                    <label for="mode">Local Contact Number <sup class="text-danger">*</sup></label>
                                                    <input type="text" class="form-control inputFieldHeight" name="local_contact_number" id="local_contact_number"
                                                        onkeypress='return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode == 45))'
                                                        value="{{$employee_info->local_contact_number}}"
                                                    readonly>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 ml-4">
                                                <div class="form-group">
                                                    <label class="d-block">Prefered Mode Of Communication</label>
                                                    <div class="custom-control custom-radio my-50">
                                                        <input type="radio" id="validationRadiojq1" name="prefered_communication" class="custom-control-input" value="phone"
                                                        {{ $employee_info->prefered_com == 'phone' ? 'checked' : '' }}
                                                        >
                                                        <label class="custom-control-label" for="validationRadiojq1">Phone</label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="validationRadiojq2" name="prefered_communication" class="custom-control-input" value="email"
                                                        {{ $employee_info->prefered_com == 'email' ? 'checked' : ''}}
                                                        >
                                                        <label class="custom-control-label" for="validationRadiojq2">Email</label>
                                                    </div>
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
                                            <div class="col-sm-12 col-12 changeColStyle pt-1">
                                                <h5 style="color: rgb(0, 0, 0);font-size:19px">Emergency Contact Details :</h5>
                                            </div>
                                            <div class="col-sm-3 col-12 changeColStyle">
                                                <label for="mode">Name <sup class="text-danger">*</sup></label>
                                                <input type="text" class="form-control inputFieldHeight" name="em_present_address" id="em_present_address"
                                                    value="{{$employee_info->em_name}}"
                                                    readonly>
                                            </div>
                                            <div class="col-sm-2 col-12 changeColStyle">
                                                <label for="mode"> Address <sup class="text-danger">*</sup></label>
                                                <input type="text" class="form-control inputFieldHeight" name="em_parmanent_address" id="em_parmanent_address"
                                                    value="{{$employee_info->em_parmanent_address}}"
                                                    readonly>
                                            </div>
                                            <div class="col-sm-2 col-12 changeColStyle">
                                                <label for="mode">Country code <sup class="text-danger">*</sup></label>
                                                <input type="text" class="form-control inputFieldHeight" name="nationality" id="nationality" value="{{$employee_info->em_country_code}}" readonly>
                                                {{-- <select name="em_countrytCode" id="em_countrytCode" class="form-control common-select2" style="width: 100% !important" readonly>
                                                    <option value="">Select ...</option>
                                                    @foreach ($countrytCode2 as $countrytCode)
                                                        <option value="{{$countrytCode->id}}" {{ ($employee_info->em_country_code == $countrytCode->id)?'selected':'' }}>+{{$countrytCode->dial}}</option>
                                                    @endforeach
                                                </select> --}}
                                            </div>
                                            <div class="col-sm-2 col-12 changeColStyle">
                                                <label for="mode">Contact Number <sup class="text-danger">*</sup></label>
                                                <input type="text" class="form-control inputFieldHeight" name="em_contact_number" id="em_contact_number"
                                                    onkeypress='return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode == 45))'
                                                    value="{{$employee_info->em_contact_number}}"
                                                    readonly>
                                            </div>

                                            <div class="col-sm-3 col-12 changeColStyle">
                                                <label for="mode">E-mail</label>
                                                <input type="email" class="form-control inputFieldHeight" style="font-size:12px" name="em_email" id="em_email"
                                                    value="{{$employee_info->em_email}}"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="row mx-0">
                                            <div class="col-sm-12 col-12 changeColStyle pt-1">
                                                <h5 style="color: rgb(0, 0, 0);font-size:19px">Reference :</h5>
                                            </div>
                                            <div class="col-sm-3 col-12 changeColStyle">
                                                <label for="mode">Name <sup class="text-danger">*</sup></label>
                                                <input type="text" class="form-control inputFieldHeight" name="r_present_address" id="r_present_address"
                                                    value="{{$employee_info->r_name}}"
                                                readonly>
                                            </div>
                                            <div class="col-sm-2 col-12 changeColStyle">
                                                <label for="mode"> Address <sup class="text-danger">*</sup></label>
                                                <input type="text" class="form-control inputFieldHeight" name="r_parmanent_address" id="r_parmanent_address"
                                                    value="{{$employee_info->r_parmanent_address}}"
                                                readonly>
                                            </div>
                                            <div class="col-sm-2 col-12 changeColStyle">
                                                <label for="mode">Country code <sup class="text-danger">*</sup></label>
                                                {{-- <input type="text" class="form-control inputFieldHeight" name="nationality" id="nationality" readonly> --}}
                                                <select name="r_countrytCode" id="r_countrytCode" class="form-control common-select2" style="width: 100% !important" readonly>
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
                                                        readonly>
                                            </div>

                                            <div class="col-sm-3 col-12 changeColStyle">
                                                <label for="mode">E-mail</label>
                                                <input type="email" class="form-control inputFieldHeight" style="font-size:12px" name="r_email" id="r_email"
                                                    value="{{$employee_info->r_email}}"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="row mx-0">
                                            <div class="col-sm-12 col-12 changeColStyle pt-1">
                                                <h5 style="color: rgb(0, 0, 0);font-size:19px">Identification :</h5>
                                            </div>
                                            <div class="col-sm-2 col-12 changeColStyle">
                                                <label for="mode">EID / NID Number <sup class="text-danger">*</sup></label>
                                                <input type="text" class="form-control inputFieldHeight" name="emirates_id" id="emirates_id"
                                                    value="{{$employee_info->emirates_id}}" readonly
                                                >
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
                                                    value="{{$employee_info->passport_number}}" readonly
                                                >
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
                                                {{-- <input type="text" class="form-control inputFieldHeight" name="nationality" id="nationality" readonly> --}}
                                                <select name="pass_issue_country" id="pass_issue_country" class="form-control common-select2" style="width: 100% !important" readonly>
                                                    <option value="" >Select country</option>
                                                    @foreach ($countries as $country)
                                                        <option value="{{$country->id}}" {{ ($employee_info->pass_issue_country == $country->id)?'selected':'' }} >{{$country->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-2 col-12 changeColStyle">
                                                <label for="mode">Visa Number <sup class="text-danger">*</sup></label>
                                                <input type="text" class="form-control inputFieldHeight" name="visa_number" id="visa_number" value="{{$employee_info->visa_number}}" readonly>
                                            </div>
                                            <div class="col-sm-2 col-12 changeColStyle">
                                                <label for="mode" style="white-space: nowrap;">Visa Type <sup class="text-danger">*</sup></label>
                                                {{-- <input type="text" class="form-control inputFieldHeight" name="nationality" id="nationality" readonly> --}}
                                                <select name="visa_type" id="visa_type" class="form-control common-select2" style="width: 100% !important" readonly>
                                                    <option value="resident" {{$employee_info->visa_type == 'resident'?'selected':''}}>Resident</option>
                                                    <option value="none_resident" {{$employee_info->visa_type == 'none_resident'?'selected':''}}> None Resident</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-2 col-12 changeColStyle">
                                                <label for="mode" style="white-space: nowrap;">Visa issuance Country <sup class="text-danger">*</sup></label>
                                                {{-- <input type="text" class="form-control inputFieldHeight" name="nationality" id="nationality" readonly> --}}
                                                <select name="visa_issue_country" id="visa_issue_country" class="form-control common-select2" style="width: 100% !important" readonly>
                                                    <option value="" >Select country</option>
                                                    @foreach ($countries as $country)
                                                        <option value="{{$country->id}}" {{ ($employee_info->visa_issue_country == $country->id)?'selected':'' }}>{{$country->name}}</option>
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
                                            <div class="col-sm-12 col-12 changeColStyle pt-1">
                                                <h5 style="color: rgb(0, 0, 0);font-size:19px">Department :</h5>
                                            </div>
                                            <div class="col-sm-2 col-12 changeColStyle">
                                                <label for="mode">Company <sup class="text-danger">*</sup></label>
                                                {{-- <input type="text" class="form-control inputFieldHeight" name="department" id="department" readonly> --}}
                                                <select name="company" id="company" class="form-control common-select2" style="width: 100% !important" readonly>
                                                    <option value="">Select ...</option>
                                                    @foreach ($companies as $company)
                                                        <option value="{{$company->id}}" {{$company->id == $employee_info->company?'selected':''}}>{{$company->company_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-2 col-12 changeColStyle">
                                                <label for="mode">Division <sup class="text-danger">*</sup></label>
                                                {{-- <input type="text" class="form-control inputFieldHeight" name="department" id="department" readonly> --}}
                                                <select name="division" id="division" class="form-control common-select2" style="width: 100% !important" readonly>
                                                    <option value="">Select ...</option>
                                                    @foreach ($divisions as $division)
                                                        <option value="{{$division->id}}" {{$division->id == $employee_info->division?'selected':''}}>{{$division->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-2 col-12 changeColStyle">
                                                <label for="mode">Department <sup class="text-danger">*</sup></label>
                                                {{-- <input type="text" class="form-control inputFieldHeight" name="department" id="department" readonly> --}}
                                                <select name="department" id="department" class="form-control common-select2" style="width: 100% !important" readonly>
                                                    <option value="">Select ...</option>
                                                    @foreach ($department as $department)
                                                        <option value="{{$department->id}}" {{ ($employee_info->department == $department->id)?'selected':'' }} >{{$department->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-2 col-12 changeColStyle">
                                                <label for="mode">Designation <sup class="text-danger">*</sup></label>
                                                <input type="text" class="form-control inputFieldHeight" name="designation" id="designation"
                                                    value="{{$employee_info->designation}}" readonly
                                                >
                                            </div>
                                            <div class="col-sm-2 commonSelect2Style">
                                                <label>Roll <strong class="text-danger">*</strong></label>
                                                <select name="employee_role" class="inputFieldHeight form-control common-select2 @error('employee_role') error @enderror" readonly>
                                                    @foreach ($roles as $role)
                                                        <option value="{{$role->id}}" {{ old('employee_role') == $role ? 'selected' : '' }}> {{$role->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('employee_role')
                                                <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-sm-2 col-12 changeColStyle">
                                                <label for="mode">Joining Date <sup class="text-danger">*</sup></label>
                                                <input type="date" class="form-control inputFieldHeight" name="joining_date" id="joining_date"
                                                    value="{{date('d/m/Y',strtotime($employee_info->joining_date))}}" readonly
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
                                            <div class="col-sm-12 col-12 changeColStyle pt-1">
                                                <h5 style="color: rgb(0, 0, 0);font-size:19px">Academic And Profetional Qualification :</h5>
                                            </div>
                                            <div class="col-sm-2 col-12 changeColStyle">
                                                <label for="mode">QUALIFICATION <sup class="text-danger">*</sup></label>
                                                {{-- <input type="text" class="form-control inputFieldHeight" name="department" id="department" readonly> --}}
                                                <select name="qualification" id="qualification" class="form-control common-select2" style="width: 100% !important" readonly>
                                                    <option value=""> Select Qualification</option>
                                                    <option value="Primary" {{ ($employee_info->qualification == 'Primary')?'selected':'' }}>Primary</option>
                                                    <option value="Secondary" {{ ($employee_info->qualification == 'Secondary')?'selected':'' }}>Secondary</option>
                                                    <option value="Higher_Secondary" {{ ($employee_info->qualification == 'Higher_Secondary')?'selected':'' }}>Higher Secondary</option>
                                                    <option value="Graduated" {{ ($employee_info->qualification == 'Graduated')?'selected':'' }}>Graduated</option>
                                                    <option value="Postgraduated" {{ ($employee_info->qualification == 'Postgraduated')?'selected':'' }}>Postgraduated</option>
                                                </select>
                                            </div>

                                            <div class="col-sm-2 col-12 changeColStyle">
                                                <label for="mode">Passing Year <sup class="text-danger">*</sup></label>
                                                <input type="text" class="form-control inputFieldHeight" name="passing_year" id="passing_year" value="{{$employee_info->passing_year}}" readonly>
                                            </div>
                                            <div class="col-sm-2 col-12 changeColStyle">
                                                <label for="mode" style="white-space: nowrap;">Qualification Country <sup class="text-danger">*</sup></label>
                                                {{-- <input type="text" class="form-control inputFieldHeight" name="nationality" id="nationality" readonly> --}}
                                                <select name="qualification_country" id="qualification_country" class="form-control common-select2" style="width: 100% !important" readonly>
                                                    <option value="" >Select country</option>
                                                    @foreach ($countries as $country)
                                                        <option value="{{$country->id}}" {{$employee_info->qualification_country == $country->id?'selected':''}}>{{$country->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-2 col-12 changeColStyle">
                                                <label for="mode">Institute name <sup class="text-danger">*</sup></label>
                                                <input type="text" class="form-control inputFieldHeight" name="institution_name" id="institution_name" value="{{$employee_info->institution_name}}" readonly>
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
                                            <div class="col-md-6">
                                                <div class="row data">
                                                        @foreach($pro_quali as $others)
                                                            <div class="col-md-2 pt-1 img" >
                                                                {{-- <span class="btn btn-warning invoice-item-delete" id="" data_target="{{ route('employeeProDocumentDelete',$others) }}"><i class="bx bx-trash"></i></span> --}}
                                                                <a href="{{ asset('storage/upload/employee/post_quali/'.$others->image)}}" target="_blank">
                                                                    <img src="{{ asset('storage/upload/employee/post_quali/'.$others->image)}}" title="{{$others->name}}" style="height:50px; width:50px" class="img-fluid" alt="" >
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
                                            <div class="col-sm-12 col-12 changeColStyle pt-1">
                                                <h5 style="color: rgb(0, 0, 0);font-size:19px">Bank Details :</h5>
                                            </div>
                                            <div class="col-sm-2 col-12 changeColStyle">
                                                <label for="mode">Bank Name <sup class="text-danger">*</sup></label>
                                                <input type="text" class="form-control inputFieldHeight" name="bank_name" id="bank_name"
                                                    value="{{$employee_info->bank_name}}" readonly
                                                >
                                            </div>
                                            <div class="col-sm-2 col-12 changeColStyle">
                                                <label for="mode">Branch Name <sup class="text-danger">*</sup></label>
                                                <select name="branch_name" id="branch_name" class="form-control common-select2" style="width: 100% !important" readonly>
                                                    <option value="">Select Branch</option>
                                                    @foreach ($branchs as $branch)
                                                        <option value="{{$branch->id}}" {{ ($employee_info->branch_name == $branch->id)?'selected':'' }} >{{$branch->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-2 col-12 changeColStyle">
                                                <label for="mode">Account Number <sup class="text-danger">*</sup></label>
                                                <input type="text" class="form-control inputFieldHeight" name="account_number" id="account_number"
                                                    value="{{$employee_info->account_number}}" readonly
                                                >
                                            </div>
                                            <div class="col-sm-2 col-12 changeColStyle">
                                                <label for="mode">IBAN Number <sup class="text-danger">*</sup></label>
                                                <input type="text" class="form-control inputFieldHeight" name="ibal_number" id="ibal_number"
                                                    value="{{$employee_info->ibal_number}}" readonly
                                                >
                                            </div>
                                            <div class="col-sm-2 col-12 changeColStyle">
                                                <label for="mode">Routing Number <sup class="text-danger">*</sup></label>
                                                <input type="text" class="form-control inputFieldHeight" name="routing_number" id="routing_number"
                                                    value="{{$employee_info->routing_number}}" readonly
                                                >
                                            </div>
                                            <div class="col-sm-2 col-12 changeColStyle">
                                                <label for="mode">Swift Code <sup class="text-danger">*</sup></label>
                                                <input type="text" class="form-control inputFieldHeight" name="swift_code" id="swift_code"
                                                value="{{$employee_info->swift_code}}" readonly
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
                                            <div class="col-sm-12 col-12 changeColStyle pt-1">
                                                <h5 style="color: rgb(0, 0, 0);font-size:19px">Employment Grade :</h5>
                                            </div>
                                            <div class="col-sm-2 col-12 changeColStyle">
                                                <label for="mode">Visa expiry date <sup class="text-danger">*</sup></label>
                                                <input type="text" class="form-control inputFieldHeight" name="visa_expiry_date" id="visa_expiry_date"
                                                    min="{{Carbon\Carbon::now()->addMonth(1)->format('Y-m-d')}}" max="{{Carbon\Carbon::now()->addMonth(12)->format('Y-m-d')}}"
                                                    value="{{date('d/m/Y',strtotime($employee_info->visa_expiry_date))}}" readonly
                                                >
                                            </div>
                                            <div class="col-sm-2 col-12 changeColStyle">
                                                <label for="mode">Employee Wages Type <sup class="text-danger">*</sup></label>
                                                <select name="employee_wage_type" id="employee_wage_type" class="form-control common-select2" style="width: 100% !important" readonly>
                                                    <option value="">Select Wages Type</option>
                                                    @foreach ($salaryTypes as $salaryType)
                                                        <option value="{{$salaryType->id}}" {{ ($employee_info->employee_wage_type == $salaryType->id)?'selected':'' }} >{{$salaryType->salary_type}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-2 col-12 changeColStyle">
                                                <label for="mode">Employee Grade <sup class="text-danger">*</sup></label>
                                                <select name="grade" id="grade" class="form-control common-select2" style="width: 100% !important" readonly>
                                                    <option value="">Select Grade</option>
                                                    @foreach ($grades as $grade)
                                                        <option value="{{$grade->id}}" {{ ($employee_info->grade == $grade->id)?'selected':'' }} >{{$grade->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-2 col-12 changeColStyle">
                                                <label for="mode">Employment Location <sup class="text-danger">*</sup></label>
                                                {{-- <input type="text" class="form-control inputFieldHeight" name="nationality" id="nationality" readonly> --}}
                                                <select name="employment_location" id="employment_location" class="form-control common-select2" style="width: 100% !important" readonly readonly>
                                                    <option value="" >Select country</option>
                                                    @foreach ($countries as $country)
                                                        <option value="{{$country->id}}" {{ ($employee_info->employment_location == $country->id)?'selected':'' }}>{{$country->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-2 col-12 changeColStyle">
                                                <label for="mode">Currency <sup class="text-danger">*</sup></label>
                                                <input type="text" class="form-control inputFieldHeight" name="currency" value="{{$employee_info->currency}}" id="currency" readonly readonly>
                                            </div>
                                            <div class="col-sm-2 col-12 changeColStyle">
                                                <label for="mode">Payment Method <sup class="text-danger">*</sup></label>
                                                <select name="payment_method" id="payment_method" class="form-control common-select2" style="width: 100% !important" readonly>
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
                                            <div class="col-sm-12 col-12 changeColStyle pt-1">
                                                <h5 style="color: rgb(0, 0, 0);font-size:19px">Description :</h5>
                                            </div>
                                            <div class="col-sm-6 col-12 changeColStyle">
                                                <label for="mode">Description <sup class="text-danger">*</sup></label>
                                                <p>{!!$employee_info->description!!}</p>                                                         {{-- <input type="text"  readonly> --}}
                                            </div>
                                            <div class="col-sm-6 col-12 changeColStyle">
                                                <label for="mode">Sub Description <sup class="text-danger">*</sup></label>
                                                   <p>{!!$employee_info->sub_description!!}</p>                                             {{-- <input type="text"  readonly> --}}
                                            </div>
                                        </div>
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
