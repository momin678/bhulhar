@php
    $emirates=array('Abu Dhabi','Ajman','Dubai','Fujairah','Ras Al Khaimah','Sharjah','Umm Al Quwain');
    $languages= array('Bangla','English','Urdu','Arabic','Hindi');
    $employee_roles= array('Principle','Teacher', 'Admin', 'Accounts Executive', 'Librarian','Driver','Clerk','Cleaner','Secretary','Accountant','Trainer');
@endphp
<div>
    <style>
        .btn {
            padding: 8px 7px;
        }
        .h5, h5 {
            margin-top: 25px;
            margin-top: -0.5rem;
            font-size: 14px;
            font-size: 1.6rem;
            padding-bottom: 5px;
        }
        input[type=text], select, textarea {
            height: 2.5rem;
            font-size:12px;
        }
        .form-control {
            height: calc(1.1em + 0.94rem + 3.7px);
        }
        input[type=file]{
            height: 2.5rem;
            font-size: 12px
        }
        input[type=date]{
            height: 2.5rem;
            font-size: 12px
        }
        input{
            height: 2.5rem;
            font-size: 12px
        }
        .habib{
            padding-right: 0px !important;
            padding-left: 2px !important;
        }
    </style>

    {{-- **************** Employees create modal start************************ --}}


        <div class="modal fade bd-example-modal-lg" id="employee-modal" style="width: 100%;" tabindex="-1" rrole="dialog" aria-labelledby="employee-modal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="padding-right: 0px !important">
                <div class="modal-content ">

                    <section class="print-hideen border-bottom" style="padding: 10px;">
                        <div class="row">
                            <div class="col-6">
                                <h5 style="font-family:Cambria;font-size: 2.3rem;"><b>Employee Profile</b> </h5>
                            </div>
                            <div class="col-6">
                                <div class="d-flex flex-row-reverse">

                                    <div class="mIconStyleChange"><a href="#" class="close btn-icon btn btn-danger mIconStyleChange212" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class='bx bx-x'></i></span></a></div>
                                    {{-- <div class="mIconStyleChange"><a href="#" onclick="window.print();" class="btn btn-icon btn-secondary"><i class='bx bx-printer'></i></a></div>
                                    <div class="mIconStyleChange"><a href="#" onclick="window.print();" class="btn btn-icon btn-primary"><i class='bx bxs-file-pdf'></i></a></div>
                                    <div class="mIconStyleChange"><a href="#" onclick="window.print();" class="btn btn-icon btn-light"><i class='bx bxs-virus'></i></a></div> --}}
                                </div>
                            </div>
                        </div>
                    </section>
                    <form action="{{route('employees.store')}}" method="POST" class="p-2" enctype="multipart/form-data" style="background: azure;">
                        @csrf
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
                                                    <img src="{{ asset('assets/backend/app-assets/icon/profile-pic.png')}}" alt="" width="50%" height="50%" id="motherEmirateImgPreview">
                                                </div>
                                                <div class="pl-1 mt-1">
                                                    <p style="line-height: 10%; font-size:10px">
                                                        ID: {{$eid}}
                                                    </p>
                                                    <p style="line-height: 10%; font-size:10px">
                                                        Status: Onrole
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="hidden" class="form-control inputFieldHeight" name="eid" id="eid" value="{{$eid}}">
                                                <label for="mode">Salutation <sup class="text-danger">*</sup></label>
                                                <select name="salutation"
                                                    class="inputFieldHeight form-control  @error('salutation') error @enderror"
                                                    id="" required>
                                                    <option value="">Select Salutation</option>
                                                    <option value="Mr" {{ old('salutation') == 'Mr' ? 'selected' : '' }}> Mr</option>
                                                    <option value="Mrs" {{ old('salutation') == 'Mrs' ? 'selected' : '' }}> Mrs</option>
                                                    <option value="Dr" {{ old('salutation') == 'Dr' ? 'selected' : '' }}>Dr </option>
                                                    <option value="Prof" {{ old('salutation') == 'Prof' ? 'selected' : '' }}>Prof </option>
                                                    <option value="Rev" {{ old('salutation') == 'Rev' ? 'selected' : '' }}>Rev </option>
                                                    <option value="Etc" {{ old('salutation') == 'Etc' ? 'selected' : '' }}> Etc</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="mode">Full Name <sup class="text-danger">*</sup></label>
                                                <input type="text" class="form-control inputFieldHeight" name="first_name" id="first_name" onkeypress='return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || (event.charCode == 32) || (event.charCode == 46))  'required >
                                            </div>
                                            <div class="col-md-3">
                                                <label for="mode">Photograph <sup class="text-danger">*</sup></label>
                                                <input type="file" class="form-control inputFieldHeight" name="employee_image" id="employee_image" value="{{old('m_emirates_id_upload')}}" class="inputFieldHeight form-control @error('m_emirates_id_upload') error @enderror" onchange="motherEmirateImgChange()" required>
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
                                                <input type="text" class="form-control inputFieldHeight" name="present_address" id="present_address" required>
                                            </div>
                                            <div class="col-md-3 col-12 changeColStyle">
                                                <label for="mode">Code <sup class="text-danger"> *</sup></label><br>
                                                <select name="countrytCode" id="countrytCode" class="form-control common-select2" required style="width:100%;">
                                                    <option value="">Select ...</option>
                                                    @foreach ($countrytCode as $countrytCode1)
                                                        <option value="{{$countrytCode1->id}}" >+{{$countrytCode1->phonecode}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4 col-12 changeColStyle">
                                                <label for="mode" style="margin-left: -5px">Contact Number <sup class="text-danger">*</sup></label>
                                                <input type="text" class="form-control inputFieldHeight" name="contact_number" id="contact_number" onkeypress='return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode == 45))' required>
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
                                                <input type="text" class="form-control inputFieldHeight" name="emirates_id" id="emirates_id" required>
                                            </div>
                                            <div class="col-md-4 col-12 changeColStyle">
                                                <label for="mode" style="white-space: nowrap;">Resident Type <sup class="text-danger">*</sup></label>
                                                {{-- <input type="text" class="form-control inputFieldHeight" name="nationality" id="nationality" required> --}}
                                                <select name="visa_type" id="visa_type" class="form-control common-select2" style="width: 100% !important" required>
                                                    <option value="Permanent" >Permanent</option>
                                                    <option value="Visit" > Visit</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 col-12 changeColStyle">
                                                <label for="mode">expiry Date <sup class="text-danger">*</sup></label>
                                                <input type="text" class="form-control inputFieldHeight datepicker" autocomplete="off" placeholder="DD/MM/YY" name="visa_expiry_date" style="font-size:12px" id="visa_expiry_date" min="{{Carbon\Carbon::now()->addMonth(1)->format('Y-m-d')}}" max="{{Carbon\Carbon::now()->addYear(12)->format('Y-m-d')}}" required>
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
                                                <select name="division" id="division" class="form-control common-select2 errorr-abcd" style="width: 100% !important" required>
                                                    <option value="">Select ...</option>
                                                    @foreach ($divisions as $division)
                                                        <option value="{{$division->id}}">{{$division->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2 col-12 changeColStyle">
                                                <label for="mode">DESIGNATION <sup class="text-danger">*</sup></label>
                                                {{-- <input type="text" class="form-control inputFieldHeight" name="department" id="department" required> --}}
                                                <select name="department" id="department" class="form-control common-select2" style="width: 100% !important" required>
                                                    <option value="">Select ...</option>
                                                    @foreach ($departments as $department)
                                                        <option value="{{$department->id}}">{{$department->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3 col-12 changeColStyle">
                                                <label for="mode">E-mail</label>
                                                <input type="email" style="font-size:12px" class="form-control inputFieldHeight ajax-error employee-email" data-ajax_error="email_error" data-s-button="employee-save-button" oninput="this.value = this.value.toLowerCase()" name="email" id="email" required>
                                                <span class="email_error"></span>

                                            </div>
                                            <div class="col-md-3 col-12 changeColStyle">
                                                <label for="mode">Joining Date <sup class="text-danger">*</sup></label>
                                                <input type="text" class="form-control inputFieldHeight datepicker" autocomplete="off" name="joining_date" style="font-size:12px" placeholder="DD/MM/YY" id="joining_date" required>
                                            </div>
                                            <div class="col-md-2 col-12 changeColStyle">
                                                <label for="mode" style="white-space: nowrap;">Job Status <sup class="text-danger">*</sup></label>
                                                {{-- <input type="text" class="form-control inputFieldHeight" name="nationality" id="nationality" required> --}}
                                                <select name="job_type" id="job_type" class="form-control common-select2" style="width: 100% !important" required>
                                                    <option value="full_time" >Full Time</option>
                                                    <option value="part_time" > Part time</option>
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
                                                            @foreach ($countrytCode as $countrytCode1)
                                                                <option value="{{$countrytCode1->id}}">+{{$countrytCode1->phonecode}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 col-12 changeColStyle">
                                                        <label for="mode">Contact Number <sup class="text-danger">*</sup></label>
                                                        <input type="text" class="form-control inputFieldHeight" name="em_contact_number" id="em_contact_number" onkeypress='return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode == 45))'required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-12 changeColStyle pt-1" >
                                                <h5 style="color: #000;margin-top: 0.5rem;;font-size:19px">Employment Grade :</h5>
                                                <label for="mode">Employee Grade <sup class="text-danger">*</sup></label>
                                                <select name="grade" id="grade" class="form-control common-select2" style="width: 100% !important" required>
                                                    <option value="">Select Grade</option>
                                                    @foreach ($grades as $grade)
                                                        <option value="{{$grade->id}}">{{$grade->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3 col-12 d-flex justify-content-end align-items-end ">
                                                <div class="form-group">
                                                    <button type="submit" class="btn mr-1 btn-primary formButton employee-save-button" title="Form Save">
                                                        <div class="d-flex">
                                                            <div class="formSaveIcon">
                                                                <img  src="{{asset('assets/backend/app-assets/icon/save-icon.png')}}" alt="" srcset="" class="img-fluid" width="20">
                                                            </div>
                                                            <div><span> Save</span></div>
                                                        </div>
                                                    </button>
                                                    <button type="reset" class="btn btn-light-secondary formButton" title="Form Reset">
                                                        <div class="d-flex">
                                                            <div class="formRefreshIcon">
                                                                <img  src="{{asset('assets/backend/app-assets/icon/refresh-icon.png')}}" alt="" srcset="" class="img-fluid" width="20">
                                                            </div>
                                                            <div><span> Reset</span></div>
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

    {{-- **************** Employees create modal end ************************ --}}

    {{-- **************** Employees edit modal ************************ --}}

    <div class="modal fade" style="width: 100%;" id="employee-modal-edit" tabindex="-1"
        role="dialog" aria-labelledby="employee-modal-edit" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="padding-right: 0px !important;">
            <div class="modal-content ">


            <div class="" id="edit-modal">


            </div>
        </div>
    </div>
    {{-- **************** Employees  edit  modal end ************************ --}}
</div>

@push('js')
<script>
    // 8888888888888888888888888888888888 AJAX email-valadition off   888888888888888888888888888888888888888888
$(document).on("change", ".errorr-abcd", function(e) {
      e.preventDefault();

      var value = $(this).val();
        var emailInput = $("#email");

        if (value == 3 || value == 4 || value == 5) {
            emailInput.prop("required", false);
            emailInput.removeClass("ajax-error");
            $(".employee-save-button").prop("disabled", false)
            $(".email_error").text("").css("color", "green").show();


        } else {
            if(emailInput.val()!='')

           {

            emailInput.prop("required", true);
            emailInput.addClass("ajax-error");
            reverse('email');
           }

        }



  });
// 8888888888888888888888888888888888 AJAX VALIDATION 888888888888888888888888888888888888888888
</script>

@endpush
