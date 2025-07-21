@php
    $emirates=array('Abu Dhabi','Ajman','Dubai','Fujairah','Ras Al Khaimah','Sharjah','Umm Al Quwain');
    $languages= array('Bangla','English','Urdu','Arabic','Hindi');
    $employee_roles= array('Principle','Teacher', 'Admin', 'Accounts Executive', 'Librarian','Driver','Clerk','Cleaner','Secretary','Accountant','Trainer');
@endphp
<section class="print-hideen border-bottom">
    <div class="d-flex flex-row-reverse">
        <div class="mIconStyleChange"><a href="#" class="close btn-icon btn btn-danger" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class='bx bx-x'></i></span></a></div>
        <div class="mIconStyleChange"><a href="#" class="btn btn-icon btn-success employeeEditProfile" data-dismiss="modal" id="{{$employee->id}}"><i class="bx bx-edit"></i></a></div>
        <div class="mIconStyleChange"><a href="#" class="btn btn-icon btn-secondary employeeProfilePrint" data-dismiss="modal" id="{{$employee->id}}"><i class='bx bx-printer'></i></a></div>
        <div class="mIconStyleChange"><a href="{{route('employee-profile-pdf-download',$employee->id)}}" class="btn btn-icon btn-primary"><i class='bx bxs-file-pdf'></i></a></div>
        {{-- <div class="mIconStyleChange"><a href="#"  onclick="window.print();" class="btn btn-icon btn-light"><i class='bx bxs-virus'></i></a></div> --}}
    </div>
</section>
@include('backend.tab-file.modal-header-info')
<div class="content-body">
    <form class="form form-vertical">
        <section id="basic-vertical-layouts">
            <div class="row match-height">
                <div class="col-md-12 col-12">
                    <div class="cardStyleChange">
                        <div class="d-flex justify-content-end pr-1">
                            <div class="profile-img" style="height: 120px; width:120px;">
                                <img src="{{ asset('storage/upload/employee-photo/'.$employee->photo)}}" alt="" style="height: 100%; width:100%;" >
                            </div>
                            <div class="imirates-img" style="height: 120px; width:120px;">
                            <a href="{{ asset('storage/upload/emirate_id/'.$employee->emirates_id_upload)}}" target="_blank">
                                <img src="{{ asset('storage/upload/emirate_id/'.$employee->emirates_id_upload)}}" alt="" style="height: 100%; width:100%;">
                            </a>
                            </div>
                        </div>

                        <div class="card-body">
                                <div class="form-body">
                                    <h4 class="">Employee Profile: Personal Details</h4>
                                    <div class="row">
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label>First Name</label>
                                                <input readonly type="text" id="first-name-vertical" class="inputFieldHeight form-control @error('first_fname') error @enderror" name="first_fname" value="{{ isset($employee) ? $employee->fname : old('first_fname')}}" placeholder="First Name" required rea>
                                                @error('first_fname')
                                                <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label>Middle Name</label>
                                                <input readonly type="text" id="f-middle-name" class="inputFieldHeight form-control @error('middle_mname') error @enderror" name="middle_mname" value="{{ isset($employee) ? $employee->mname : old('middle_mname')}}" placeholder="Middle Name" required>
                                                @error('middle_mname')
                                                <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label>Family Name</label>
                                                <input readonly type="text" id="contact-info-vertical" class="inputFieldHeight form-control @error('family_name') error @enderror" name="family_name" value="{{ isset($employee) ? $employee->family_name : old('family_name')}}" placeholder="Family Name" required>
                                                @error('family_name')
                                                <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                            <label>Date of Birth</label>
                                            <input readonly type="date" name="date_of_birth" class="inputFieldHeight form-control @error('date_of_birth') error @enderror" value="{{ isset($employee) ? $employee->dob : old('date_of_birth')}}" placeholder="dd-mm-yyy" required>
                                            @error('date_of_birth')
                                            <span class="error">{{ $message }}</span>
                                            @enderror
                                            </div>
                                        </div>
                    
                                        <div class="col-sm-4 commonSelect2Style">
                                            <label>Nationality</label>
                                            <select disabled name="nationality" class="inputFieldHeight form-control common-select2 @error('nationality') error @enderror" required>
                                                <option value="">Select Country</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{$country->name}}" {{ isset($employee) && $employee->nationality==$country->name ? 'selected' : (old('nationality') == $country->name ? 'selected' : '') }}> {{$country->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('nationality')
                                            <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                            <label>Email Address</label>
                                            <input readonly type="email" name="email" class="inputFieldHeight form-control @error('email') error @enderror" value="{{ isset($employee) ? $employee->email : old('email')}}" placeholder="Email" required>
                                            @error('email')
                                            <span class="error">{{ $message }}</span>
                                            @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                            <label>Emirates ID Number</label>
                                            <input readonly type="text" name="emirates_id_number" class="inputFieldHeight form-control @error('emirates_id_number') error @enderror" value="{{ isset($employee) ? $employee->emirates_id_num : old('emirates_id_number')}}" placeholder="000-0000-0000000-0" required>
                                            @error('emirates_id_number')
                                            <span class="error">{{ $message }}</span>
                                            @enderror    
                                            </div>
                                        </div>
                    
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                            <label>Emirates ID Expiry Date</label>
                                            <input readonly type="date" name="emirates_id_expire" class="inputFieldHeight form-control @error('emirates_id_expire') error @enderror" value="{{ isset($employee) ? $employee->emirates_id_exp : old('emirates_id_expire')}}" placeholder="dd/mm/yyyy" required>
                                            @error('emirates_id_expire')
                                            <span class="error">{{ $message }}</span>
                                            @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>First Language</label>
                                                <select disabled name="first_language" class="inputFieldHeight form-control @error('first_language') error @enderror" required>
                                                    @foreach ($languages as $each_lang)
                                                        <option value="{{$each_lang}}" {{ isset($employee) && $employee->first_lang==$each_lang ? 'selected' : (old('first_language') == $each_lang ? 'selected' : '') }}> {{$each_lang}}</option>
                                                    @endforeach
                                                </select>
                                                @error('first_language')
                                                <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                    
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Second Language</label>
                                                <select disabled name="second_language" class="inputFieldHeight form-control @error('second_language') error @enderror" required>
                                                    @foreach ($languages as $each_lang)
                                                        <option value="{{$each_lang}}" {{ isset($employee) && $employee->second_lang==$each_lang ? 'selected' : (old('second_language') == $each_lang ? 'selected' : '') }}> {{$each_lang}}</option>
                                                    @endforeach
                                                </select>
                                                @error('second_language')
                                                <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-4 commonSelect2Style">
                                            <label>Employee Designation</label>
                                            <select disabled name="employee_role" class="inputFieldHeight form-control common-select2 @error('employee_role') error @enderror" required>
                                                @foreach ($employee_roles as $role)
                                                    <option value="{{$role}}" {{ isset($employee) && $employee->employee_role==$role ? 'selected' : (old('employee_role') == $role ? 'selected' : '') }}> {{$role}}</option>
                                                @endforeach
                                            </select>
                                            @error('employee_role')
                                            <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="d-block">Prefered Mode Of Communication</label>
                                                <div class="custom-control custom-radio my-50">
                                                    <input readonly type="radio" id="validationRadiojq1" name="mode_of_communication" class="custom-control-input" value="phone"
                                                    {{ isset($employee) && $employee->mode_of_communication == 'phone' ? 'checked' : ( old('mode_of_communication') == 'phone' ? 'checked' : '') }}
                                                    >
                                                    <label class="custom-control-label" for="validationRadiojq1">Phone</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input readonly type="radio" id="validationRadiojq2" name="mode_of_communication" class="custom-control-input" value="email"
                                                    {{ isset($employee) && $employee->mode_of_communication == 'email' ? 'checked' : ( old('mode_of_communication') == 'email' ? 'checked' : '')}}
                                                    >
                                                    <label class="custom-control-label" for="validationRadiojq2">Email</label>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4 mt-2">
                                            <label for=""><strong>Contact Document</strong></label>
                                            <div class="img" style="height: 120px; width: 120px;">
                                                @if ($employee->equivalence2 == 'pdf')
                                                    <a href="{{ asset('storage/upload/certification/'.$employee->equivalence)}}" target="_blank">
                                                        <img src="{{ asset('assets/backend/app-assets/icon/pdf-download-icon-2.png')}}" alt="" style="height: 100%; width: 100%;">
                                                    </a>
                                                @else
                                                    @if ($employee->equivalence)
                                                        <a href="{{ asset('storage/upload/certification/'.$employee->equivalence)}}" target="_blank">
                                                            <img src="{{ asset('storage/upload/certification/'.$employee->equivalence)}}" alt="" style="height: 100%; width: 100%;">
                                                        </a>
                                                    @endif
                                                @endif
                                            </div>
                                            <p>{{$employee->equivalence_name}}</p>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label for=""><strong>Certificate Document</strong></label>
                                            <div class="img" style="height: 120px; width: 120px;">
                                                @if ($employee->certificate2 == 'pdf')
                                                    <a href="{{ asset('storage/upload/certification/'.$employee->certificate)}}" target="_blank">
                                                        <img src="{{ asset('assets/backend/app-assets/icon/pdf-download-icon-2.png')}}" alt="" style="height: 100%; width: 100%;">
                                                    </a>
                                                @else
                                                    @if ($employee->certificate)
                                                        <a href="{{ asset('storage/upload/certification/'.$employee->certificate)}}" target="_blank">
                                                            <img src="{{ asset('storage/upload/certification/'.$employee->certificate)}}" alt="" style="height: 100%; width: 100%;">
                                                        </a>
                                                    @endif
                                                @endif
                                            </div>
                                            <p>{{$employee->certificate_name}}</p>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label for=""><strong>MOE Approval Document</strong></label>
                                            <div class="img" style="height: 120px; width: 120px;">
                                                @if ($employee->moe_approval2 == 'pdf')
                                                    <a href="{{ asset('storage/upload/certification/'.$employee->moe_approval)}}" target="_blank">
                                                        <img src="{{ asset('assets/backend/app-assets/icon/pdf-download-icon-2.png')}}" alt="" style="height: 100%; width: 100%;">
                                                    </a>
                                                @else
                                                    @if ($employee->moe_approval)
                                                        <a href="{{ asset('storage/upload/certification/'.$employee->moe_approval)}}" target="_blank">
                                                            <img src="{{ asset('storage/upload/certification/'.$employee->moe_approval)}}" alt="" style="height: 100%; width: 100%;">
                                                        </a>
                                                    @endif
                                                @endif
                                            </div>
                                            <p>{{$employee->moe_approval_name}}</p>
                                        </div> 
                                    </div>
                                </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </section>
        <!-- Basic Vertical form layout section end -->

        <!-- Basic Vertical form layout section start -->
        <section id="basic-vertical-layouts">
            <div class="row match-height">
                <div class="col-md-12 col-12">
                    <div class="cardStyleChange">
                        <div class="card-body">
                            <div class="form-body">
                                <h4>Passport & Visa Information</h4>
                                <div class="row">
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="passport-number">Passport Number</label>
                                            <input readonly type="text" id="passport-number" class="inputFieldHeight form-control @error('passport_number') error @enderror" name="passport_number" value="{{ isset($employee) ? $employee->passport_num : old('passport_number')}}" placeholder="Passport Number" required>
                                            @error('passport_number')
                                            <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="passport-country">Passport Issue Country</label>
                                            <select disabled id="passport-country" class="inputFieldHeight form-control common-select2 @error('passport_country') error @enderror" name="passport_country" required>
                                                <option value="">Select Country</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{$country->name}}" {{ isset($employee) && $employee->passport_country==$country->name ? 'selected' : (old('passport_country')== $country->name ? 'selected' : '') }}> {{$country->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('passport_country')
                                            <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="visa-number">Visa Number</label>
                                            <input readonly type="text" id="visa-number" class="inputFieldHeight form-control @error('visa_number') error @enderror" name="visa_number" value="{{ isset($employee) ? $employee->visa_number : old('visa_number')}}" placeholder="Visa Number" required>
                                            @error('visa_number')
                                            <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                        <label for="visa-type">Visa Type</label>
                                        <select disabled id="visa-type" class="inputFieldHeight form-control @error('visa_type') error @enderror" name="visa_type">
                                            <option value="Residence" {{ isset($employee) && $employee->visa_type == 'Residence' ? 'selected' : (old('visa_type') == 'Residence' ? 'selected' : '')}}> Residence</option>
                                            <option value="NonResidence" {{ isset($employee) && $employee->visa_type == 'NonResidence' ? 'selected' : (old('visa_type') == 'NonResidence' ? 'selected' : '')}}> Non Residence</option>
                                        </select>
                                        @error('visa_type')
                                        <span class="error">{{ $message }}</span>
                                        @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="visa-issue-place">Visa Issue Place</label>
                                            <select disabled id="visa-issue-place" class="inputFieldHeight form-control common-select2 @error('visa_type') error @enderror" name="visa_issue_place">
                                                <option value="">Select Place</option>
                                                @foreach ($emirates as $emirate)
                                                <option value="{{$emirate}}" {{ isset($employee) && $employee->visa_issue_place == $emirate ? 'selected' : (old('visa_issue_place') == $emirate ? 'selected' : '')}}> {{$emirate}}</option>
                                                @endforeach
                                            </select>
                                            @error('visa_issue_place')
                                            <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="visa-expire-date">Visa Expiry Date</label>
                                            <input readonly type="date" id="visa-expire-date" class="inputFieldHeight form-control @error('visa_expire') error @enderror" name="visa_expire" value="{{ isset($employee) ? $employee->visa_exp : old('visa_expire')}}" placeholder="dd/mm/yyyy">
                                            @error('visa_expire')
                                            <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </section>
        <!-- Basic Vertical form layout section end -->

        <!-- Basic Vertical form layout section start -->
        <section id="basic-vertical-layouts">
            <div class="row match-height">
                <div class="col-md-12 col-12">
                    <div class="cardStyleChange">
                        <div class="card-body">
                            <div class="form-body">
                                <h4>Education & Profession</h4>
                                <div class="row">
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="Qualification">Qualification</label>
                                            <select disabled id="Qualification" class="inputFieldHeight form-control @error('qualification') error @enderror" name="qualification">
                                                <option value="Primary" {{ isset($employee) && $employee->qualification == 'Primary' ? 'selected' : (old('qualification') == 'Primary' ? 'selected' : '')}}> Primary</option>
                                                <option value="Secondary" {{ isset($employee) && $employee->qualification == 'Secondary' ? 'selected' : (old('qualification') == 'Secondary' ? 'selected' : '')}}> Secondary</option>
                                                <option value="Higher Secondary" {{ isset($employee) && $employee->qualification == 'Higher Secondary' ? 'selected' : (old('qualification') == 'Higher Secondary' ? 'selected' : '')}}> Higher Secondary</option>
                                                <option value="Graduate" {{ isset($employee) && $employee->qualification == 'Graduate' ? 'selected' : (old('qualification') == 'Graduate' ? 'selected' : '')}}> Graduate</option>
                                                <option value="Postgraduate" {{ isset($employee) && $employee->qualification == 'Postgraduate' ? 'selected' : (old('qualification') == 'Postgraduate' ? 'selected' : '')}}> Postgraduate</option>
                                            </select>
                                            @error('qualification')
                                            <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="year-of-passing">Year of passing</label>
                                            <input readonly type="number" id=year_of_passing" class="inputFieldHeight form-control @error('year_of_passing') error @enderror" name="year_of_passing" value="{{ isset($employee) ? $employee->year_of_passing : old('year_of_passing')}}" placeholder="Year of Passing">
                                            @error('year_of_passing')
                                            <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="institution">Institution Name</label>
                                            <input readonly type="text" id="institution" class="inputFieldHeight form-control @error('institution') error @enderror" name="institution" value="{{ isset($employee) ? $employee->institution : old('institution')}}" placeholder="Institution Name">
                                            @error('institution')
                                            <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="qualification-country">Qualification Country</label>
                                            <select disabled id="qualification-country" class="inputFieldHeight form-control common-select2 @error('qualification_country') error @enderror" name="qualification_country">
                                                <option value="">Select Country</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{$country->name}}" {{ isset($employee) && $employee->qualification_country==$country->name ? 'selected' : (old('qualification_country') == $country->name ? 'selected' : '') }}> {{$country->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('qualification_country')
                                            <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </section>
        <!-- Basic Vertical form layout section end -->

        <!-- Basic Vertical form layout section start -->
        <section id="basic-vertical-layouts">
            <div class="row match-height">
                <div class="col-md-12 col-12">
                    <div class="cardStyleChange">
                        <div class="card-body">
                            <div class="form-body">
                                <h4>Address Details</h4>
                                <div class="row">
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="local-telephone">Local telephone</label>
                                            <input readonly type="text" id="local-telephone" class="inputFieldHeight form-control @error('telephone') error @enderror" name="telephone" value="{{ isset($employee) ? $employee->local_telephone : old('telephone')}}" placeholder="Local Telephone">
                                            @error('telephone')
                                            <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="permanent-telephone">Permanent telephone</label>
                                            <input readonly type="number" id="permanent-telephone" class="inputFieldHeight form-control @error('permanent_telephone') error @enderror" name="permanent_telephone" value="{{ isset($employee) ? $employee->permanent_telephone : old('permanent_telephone')}}" placeholder="Company Contact Details">
                                            @error('permanent_telephone')
                                            <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="Emirates">Emirates</label>
                                            <select disabled id="Emirates" class="inputFieldHeight form-control @error('emirate_name') error @enderror" name="emirate_name">
                                                @foreach ($emirates as $emirate)
                                                <option value="{{$emirate}}" {{ isset($employee) && $employee->emirate_name == $emirate ? 'selected' : (old('emirate_name') == $emirate ? 'selected' : '')}}> {{$emirate}}</option>
                                                @endforeach
                                            </select>
                                            @error('emirate_name')
                                            <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="local-address">Local Address</label>
                                            <textarea readonly name="local_address" id="local-address" class=" form-control @error('local_address') error @enderror" cols="30" rows="3">{{ isset($employee) ? $employee->local_address : old('local_address')}} </textarea>
                                            @error('local_address')
                                            <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="permanent-address">Permanent Address</label>
                                            <textarea readonly name="permanent_address" id="permanent-address" class=" form-control @error('permanent_address') error @enderror" cols="30" rows="3"> {{ isset($employee) ? $employee->permanent_address : old('permanent_address')}}</textarea>
                                            @error('permanent_address')
                                            <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </section>
    </form>
</div>
@include('backend.tab-file.modal-footer-info')