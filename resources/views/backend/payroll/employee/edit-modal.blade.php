
<!-- summernote css/js -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

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
            <h5 style="font-family:Cambria;font-size: 2rem;"><b>Edit Employee Profile</b> </h5>
        </div>
        <div class="col-6">
            <div class="d-flex flex-row-reverse">

                <div class="mIconStyleChange"><a href="#" class="close btn-icon btn btn-danger mIconStyleChange212" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class='bx bx-x'></i></span></a></div>
                @if ( Auth::user()->hasPermission('approver'))

                @if ($employee_info->status != 1)<div class="mIconStyleChange">
                <span id="fappprove-rejection-button">
                    <a href="{{ route('employees-approve',$employee_info->id) }}" class="btn btn-sm btn-primary mr-2 fhide-button-1"
                    >Approve</a>
                </span>
                </div>
            @endif
            @endif


                {{-- <div class="mIconStyleChange"><a href="#" onclick="window.print();" class="btn btn-icon btn-secondary"><i class='bx bx-printer'></i></a></div>
                <div class="mIconStyleChange"><a href="#" onclick="window.print();" class="btn btn-icon btn-primary"><i class='bx bxs-file-pdf'></i></a></div>
                <div class="mIconStyleChange"><a href="#" onclick="window.print();" class="btn btn-icon btn-light"><i class='bx bxs-virus'></i></a></div> --}}
            </div>
        </div>
    </div>
</section>

<div class="modal-body" style="background: azure;">
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
                                    <div class="col-md-3">
                                        <div class="profile-img pl-1 pt-1">
                                            @if ($employee_info->employee_image)
                                                <img src="{{ asset('storage/upload/employee/'.$employee_info->employee_image)}}" alt="" width="50" height="50" id="edit_motherEmirateImgPreview">
                                            @else
                                                <img src="assets/backend/app-assets/icon/profile-pic.png" alt="" width="70" height="70" id="edit_motherEmirateImgPreview">
                                            @endif
                                        </div>
                                        <div class="pl-1 mt-1">
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
                                            id="" required>
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
                                        <input type="text" class="form-control inputFieldHeight" name="first_name" id="first_name" onkeypress='return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || (event.charCode == 32) || (event.charCode == 46))' value="{{$employee_info->first_name}}" required >
                                    </div>
                                    <div class="col-md-3">
                                        <label for="mode">Photograph <sup class="text-danger">*</sup></label>
                                        <input type="file" class="form-control inputFieldHeight" name="employee_image" id="edit_motherEmirateImgChange" >
                                        <input type="hidden" value="{{ $employee_info->employee_image }}" name="old_employee_image">
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
                                    <div class="col-md-5 col-12 changeColStyle">
                                        <label for="mode">Present Address <sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control inputFieldHeight" name="present_address" id="present_address" value="{{$employee_info->present_address}}" required>
                                    </div>
                                    <div class="col-md-3 col-12 changeColStyle">
                                        <label for="mode">Country code <sup class="text-danger">*</sup></label><br>
                                        {{-- <input type="text" class="form-control inputFieldHeight" name="nationality" id="nationality" required> --}}
                                        <select name="countrytCode" id="countrytCode" class="form-control common-select2" style="width: 100% !important" required>
                                            <option value="">Select ...</option>
                                            @foreach ($countrytCode as $countrytCode)
                                                <option value="{{$countrytCode->id}}" {{ ($employee_info->country_code == $countrytCode->id)?'selected':'' }} >+{{$countrytCode->phonecode}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 col-12 changeColStyle">
                                        <label for="mode">Contact Number <sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control inputFieldHeight" name="contact_number" id="contact_number" onkeypress='return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode == 45))'value="{{$employee_info->contact_number}}"required>
                                    </div>
                                    {{-- <div class="col-md-3 col-12 changeColStyle">
                                    <label for="mode">E-mail</label>
                                        <input type="email" style="font-size:12px" class="form-control inputFieldHeight" oninput="this.value = this.value.toLowerCase()" name="email" id="email" value="{{$employee_info->email}}">
                                    </div> --}}
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
                                        <input type="text" class="form-control inputFieldHeight" name="emirates_id" id="emirates_id" value="{{$employee_info->emirates_id}}" required>
                                    </div>
                                    <div class="col-md-4 col-12 changeColStyle">
                                        <label for="mode">Expiry Date <sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control inputFieldHeight datepicker" autocomplete="off" name="visa_expiry_date" id="visa_expiry_date" min="{{Carbon\Carbon::now()->addMonth(1)->format('Y-m-d')}}" max="{{Carbon\Carbon::now()->addYear(12)->format('Y-m-d')}}" value="{{date('d/m/Y',strtotime($employee_info->visa_expiry_date))}}" require>
                                    </div>
                                    <div class="col-md-4 col-12 changeColStyle">
                                        <label for="mode" style="white-space: nowrap;">Resident Type <sup class="text-danger">*</sup></label>
                                        {{-- <input type="text" class="form-control inputFieldHeight" name="nationality" id="nationality" required> --}}
                                        <select name="visa_type" id="visa_type" class="form-control common-select2" style="width: 100% !important" required>
                                            <option value="Permanent" {{$employee_info->visa_type == 'Permanent'?'selected':''}}>Permanent</option>
                                            <option value="Visit" {{$employee_info->visa_type == 'Visit'?'selected':''}}> Visit</option>
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
                                    <div class="col-md-12 col-12 changeColStyle pt-1" >
                                        <h5 style="color: #000;margin-top: 0.5rem;;font-size:19px">Department :</h5>
                                    </div>
                                    <div class="col-md-2 col-12 changeColStyle">
                                        <label for="mode">Department <sup class="text-danger">*</sup></label>
                                        {{-- <input type="text" class="form-control inputFieldHeight" name="department" id="department" required> --}}
                                        <select name="division" id="division" class="form-control common-select2 errorr-abcd1fgfg" style="width: 100% !important" required>
                                            <option value="">Select ...</option>
                                            @foreach ($divisions as $division)
                                                <option value="{{$division->id}}" {{$division->id == $employee_info->division?'selected':''}}>{{$division->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 col-12 changeColStyle">
                                        <label for="mode">DESIGNATION <sup class="text-danger">*</sup></label>
                                        {{-- <input type="text" class="form-control inputFieldHeight" name="department" id="department" required> --}}
                                        <select name="department" id="department" class="form-control common-select2" style="width: 100% !important" required>
                                            <option value="">Select ...</option>
                                            @foreach ($department as $department)
                                                <option value="{{$department->id}}" {{ ($employee_info->department == $department->id)?'selected':'' }} >{{$department->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 col-12 changeColStyle">
                                        <label for="mode">E-mail</label>
                                            <input type="email" style="font-size:12px" class="form-control inputFieldHeight  ajax-error employee-email1" data-ajax_error="email_error"
                                            data-s-button="error-disable" oninput="this.value = this.value.toLowerCase()" name="email" id="email1ffff" value="{{$employee_info->email}}">
                                            <span class="email_error"></span>
                                        </div>
                                    <div class="col-md-3 col-12 changeColStyle">
                                        <label for="mode">Joining Date <sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control inputFieldHeight datepicker" autocomplete="off" name="joining_date" id="joining_date" value="{{date('d/m/Y',strtotime($employee_info->joining_date))}}" required>
                                    </div>
                                    <div class="col-md-2 col-12 changeColStyle">
                                        <label for="mode" style="white-space: nowrap;">Job Status <sup class="text-danger">*</sup></label>
                                        {{-- <input type="text" class="form-control inputFieldHeight" name="nationality" id="nationality" required> --}}
                                        <select name="job_type" id="job_type" class="form-control common-select2" style="width: 100% !important" required>
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
                                                {{-- <input type="text" class="form-control inputFieldHeight" name="nationality" id="nationality" required> --}}
                                                <select name="em_countrytCode" id="em_countrytCode" class="form-control common-select2" style="width: 100% !important" required>
                                                    <option value="">Select ...</option>
                                                    @foreach ($countrytCode2 as $countrytCode)
                                                        <option value="{{$countrytCode->id}}" {{ ($employee_info->em_country_code == $countrytCode->id)?'selected':'' }}>+{{$countrytCode->phonecode}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3 col-12 changeColStyle">
                                                <label for="mode">Contact Number <sup class="text-danger">*</sup></label>
                                                <input type="text" class="form-control inputFieldHeight" name="em_contact_number" id="em_contact_number" onkeypress='return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode == 45))' value="{{$employee_info->em_contact_number}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12 changeColStyle pt-1" >
                                        <h5 style="color: #000;margin-top: 0.5rem;;font-size:19px">Employment Grade :</h5>
                                        <label for="mode">Employee Grade<sup class="text-danger">*</sup></label>
                                        <select name="grade" id="grade" class="form-control common-select2" style="width: 100% !important" required>
                                            <option value="">Select Grade</option>
                                            @foreach ($grades as $grade)
                                                <option value="{{$grade->id}}" {{ ($employee_info->grade == $grade->id)?'selected':'' }} >{{$grade->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 col-12 d-flex justify-content-end align-items-end">
                                        <div class="form-group">
                                            <button type="submit" class="btn mr-1 btn-primary formButton error-disable" title="Form Save">
                                                <div class="d-flex">
                                                    <div class="formSaveIcon">
                                                        <img  src="{{asset('assets/backend/app-assets/icon/save-icon.png')}}" alt="" srcset="" class="img-fluid" width="20">
                                                    </div>
                                                    <div><span> UPDATE</span></div>
                                                </div>
                                            </button>
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
