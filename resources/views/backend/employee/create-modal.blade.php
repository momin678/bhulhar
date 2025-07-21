@php
    $emirates=array('Abu Dhabi','Ajman','Dubai','Fujairah','Ras Al Khaimah','Sharjah','Umm Al Quwain');
    $languages= array('Bangla','English','Urdu','Arabic','Hindi');
    $employee_roles= array('Principle','Teacher', 'Admin', 'Accounts Executive', 'Librarian','Driver','Clerk','Cleaner','Secretary','Accountant','Trainer');
@endphp
<div class="content-body">
    <form class="form form-vertical" action="{{route('employee.store')}}" method="POST" enctype="multipart/form-data">
        @csrf 
        <section id="basic-vertical-layouts">
            <div class="row match-height">
                <div class="col-md-12 col-12">
                    <div class="cardStyleChange">
                        <div class="card-body">
                            <div class="form-body">
                                <h4 class="card-title">Employee Profile: Personal Details</h4>
                                <div class="row">
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label>First Name <strong class="text-danger">*</strong></label>
                                            <input type="text" id="first-name-vertical" class="inputFieldHeight form-control @error('first_fname') error @enderror" name="first_fname" value="{{ old('first_fname')}}" placeholder="First Name" required>
                                            @error('first_fname')
                                            <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label>Middle Name <strong class="text-danger">*</strong></label>
                                            <input type="text" id="f-middle-name" class="inputFieldHeight form-control @error('middle_mname') error @enderror" name="middle_mname" value="{{ old('middle_mname')}}" placeholder="Middle Name" required>
                                            @error('middle_mname')
                                            <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label>Family Name <strong class="text-danger">*</strong></label>
                                            <input type="text" id="contact-info-vertical" class="inputFieldHeight form-control @error('family_name') error @enderror" name="family_name" value="{{ old('family_name')}}" placeholder="Family Name" required>
                                            @error('family_name')
                                            <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                        <label>Date of Birth <strong class="text-danger">*</strong></label>
                                        <input type="date" max="9999-12-31" name="date_of_birth" class="inputFieldHeight form-control @error('date_of_birth') error @enderror" value="{{old('date_of_birth')}}" placeholder="dd-mm-yyy" required>
                                        @error('date_of_birth')
                                        <span class="error">{{ $message }}</span>
                                        @enderror
                                        </div>
                                    </div>
                
                                    <div class="col-sm-4 commonSelect2Style">
                                        <label>Nationality <strong class="text-danger">*</strong></label>
                                        <select name="nationality" class="inputFieldHeight form-control common-select2 @error('nationality') error @enderror" required>
                                            <option value="">Select Country</option>
                                            @foreach ($countries as $country)
                                                <option value="{{$country->name}}" {{ old('nationality') == $country->name ? 'selected' : '' }}> {{$country->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('nationality')
                                        <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                        <label>Email Address <strong class="text-danger">*</strong></label>
                                        <input type="email" name="email" class="inputFieldHeight form-control @error('email') error @enderror" value="{{ old('email')}}" placeholder="Email" required>
                                        @error('email')
                                        <span class="error">{{ $message }}</span>
                                        @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                        <label>Emirates ID Number <strong class="text-danger">*</strong></label>
                                        <input type="text" name="emirates_id_number" class="inputFieldHeight form-control @error('emirates_id_number') error @enderror" value="{{ old('emirates_id_number')}}" placeholder="000-0000-0000000-0" required>
                                        @error('emirates_id_number')
                                        <span class="error">{{ $message }}</span>
                                        @enderror    
                                        </div>
                                    </div>
                
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                        <label>Emirates ID Expiry Date <strong class="text-danger">*</strong></label>
                                        <input type="date" max="9999-12-31" name="emirates_id_expire" class="inputFieldHeight form-control @error('emirates_id_expire') error @enderror" value="{{ old('emirates_id_expire')}}" placeholder="dd/mm/yyyy" required>
                                        @error('emirates_id_expire')
                                        <span class="error">{{ $message }}</span>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>First Language <strong class="text-danger">*</strong></label>
                                            <select name="first_language" class="inputFieldHeight form-control @error('first_language') error @enderror" required>
                                                @foreach ($languages as $each_lang)
                                                    <option value="{{$each_lang}}" {{ old('first_language') == $each_lang ? 'selected' : '' }}> {{$each_lang}}</option>
                                                @endforeach
                                            </select>
                                            @error('first_language')
                                            <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Second Language <strong class="text-danger">*</strong></label>
                                            <select name="second_language" class="inputFieldHeight form-control @error('second_language') error @enderror" required>
                                                @foreach ($languages as $each_lang)
                                                    <option value="{{$each_lang}}" {{ old('second_language') == $each_lang ? 'selected' : '' }}> {{$each_lang}}</option>
                                                @endforeach
                                            </select>
                                            @error('second_language')
                                            <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-4 commonSelect2Style">
                                        <label>Employee Designation <strong class="text-danger">*</strong></label>
                                        <select name="employee_role" class="inputFieldHeight form-control common-select2 @error('employee_role') error @enderror" required>
                                            @foreach ($employee_roles as $role)
                                                <option value="{{$role}}" {{ old('employee_role') == $role ? 'selected' : '' }}> {{$role}}</option>
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
                                                <input type="radio" id="validationRadiojq1" name="mode_of_communication" class="custom-control-input" value="phone"
                                                {{ old('mode_of_communication') == 'phone' ? 'checked' : '' }}
                                                >
                                                <label class="custom-control-label" for="validationRadiojq1">Phone</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="validationRadiojq2" name="mode_of_communication" class="custom-control-input" value="email"
                                                {{ old('mode_of_communication') == 'email' ? 'checked' : ''}}
                                                >
                                                <label class="custom-control-label" for="validationRadiojq2">Email</label>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                        <label>Photo <small class="text-danger">Support only jpg, jpeg, png</small> <strong class="text-danger">*</strong></label>
                                        <input type="file" name="photo" id="photo" class="inputFieldHeight form-control @error('photo') error @enderror img-type" required>
                                        @error('photo')
                                        <span class="error">{{ $message }}</span>
                                        @enderror
                                        </div>
                                    </div>
                
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                        <label>Emirates ID Upload <small class="text-danger">Support only jpg, jpeg, png</small> <strong class="text-danger">*</strong></label>
                                        <input type="file" name="emirates_id_upload" class="inputFieldHeight form-control @error('emirates_id_upload') error @enderror img-type" required id="emirates_id_upload">
                                        @error('emirates_id_upload')
                                        <span class="error">{{ $message }}</span>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                        <label>Equivalence Upload</label>
                                        <input type="file" name="equivalence" class="inputFieldHeight form-control @error('equivalence') error @enderror">
                                        @error('equivalence')
                                        <span class="error">{{ $message }}</span>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                        <label>Certificate Upload</label>
                                        <input type="file" name="certificate" class="inputFieldHeight form-control @error('certificate') error @enderror">
                                        @error('certificate')
                                        <span class="error">{{ $message }}</span>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                        <label>MOE Approvals Upload</label>
                                        <input type="file" name="moe_approval" class="inputFieldHeight form-control @error('moe_approval') error @enderror">
                                        @error('moe_approval')
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
                                <h4>Passport & Visa Information</h4>
                                <div class="row">
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="passport-number">Passport Number <strong class="text-danger">*</strong></label>
                                            <input type="text" id="passport-number" class="inputFieldHeight form-control @error('passport_number') error @enderror" name="passport_number" value="{{old('passport_number')}}" placeholder="Passport Number" required>
                                            @error('passport_number')
                                            <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-12 commonSelect2Style">
                                        <label for="passport-country">Passport Issue Country <strong class="text-danger">*</strong></label>
                                        <select id="passport-country" class="inputFieldHeight form-control common-select2 @error('passport_country') error @enderror" name="passport_country" required>
                                            <option value="">Select Country</option>
                                            @foreach ($countries as $country)
                                                <option value="{{$country->name}}" {{ old('passport_country')== $country->name ? 'selected' : '' }}> {{$country->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('passport_country')
                                        <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="visa-number">Visa Number <strong class="text-danger">*</strong></label>
                                            <input type="text" id="visa-number" class="inputFieldHeight form-control @error('visa_number') error @enderror" name="visa_number" value="{{ old('visa_number')}}" placeholder="Visa Number" required>
                                            @error('visa_number')
                                            <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                        <label for="visa-type">Visa Type</label>
                                        <select id="visa-type" class="inputFieldHeight form-control @error('visa_type') error @enderror" name="visa_type">
                                            <option value="Residence" {{ old('visa_type') == 'Residence' ? 'selected' : ''}}> Residence</option>
                                            <option value="NonResidence" {{ old('visa_type') == 'NonResidence' ? 'selected' : '' }}> Non Residence</option>
                                        </select>
                                        @error('visa_type')
                                        <span class="error">{{ $message }}</span>
                                        @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-12 commonSelect2Style">
                                        <label for="visa-issue-place">Visa Issue Place</label>
                                        <select id="visa-issue-place" class="inputFieldHeight form-control common-select2 @error('visa_type') error @enderror" name="visa_issue_place">
                                            <option value="">Select Place</option>
                                            @foreach ($emirates as $emirate)
                                            <option value="{{$emirate}}" {{ old('visa_issue_place') == $emirate ? 'selected' : ''}}> {{$emirate}}</option>
                                            @endforeach
                                        </select>
                                        @error('visa_issue_place')
                                        <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="visa-expire-date">Visa Expiry Date</label>
                                            <input type="date" max="9999-12-31" id="visa-expire-date" class="inputFieldHeight form-control @error('visa_expire') error @enderror" name="visa_expire" value="{{ old('visa_expire')}}" placeholder="dd/mm/yyyy">
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
                                            <select id="Qualification" class="inputFieldHeight form-control @error('qualification') error @enderror" name="qualification">
                                                <option value="Primary" {{old('qualification') == 'Primary' ? 'selected' : ''}}> Primary</option>
                                                <option value="Secondary" {{ old('qualification') == 'Secondary' ? 'selected' : ''}}> Secondary</option>
                                                <option value="Higher Secondary" {{ old('qualification') == 'Higher Secondary' ? 'selected' : '' }}> Higher Secondary</option>
                                                <option value="Graduate" {{ old('qualification') == 'Graduate' ? 'selected' : ''}}> Graduate</option>
                                                <option value="Postgraduate" {{ old('qualification') == 'Postgraduate' ? 'selected' : ''}}> Postgraduate</option>
                                            </select>
                                            @error('qualification')
                                            <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="year-of-passing">Year of passing</label>
                                            <input type="number" id=year_of_passing" class="inputFieldHeight form-control @error('year_of_passing') error @enderror" name="year_of_passing" value="{{old('year_of_passing')}}" placeholder="Year of Passing">
                                            @error('year_of_passing')
                                            <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="institution">Institution Name</label>
                                            <input type="text" id="institution" class="inputFieldHeight form-control @error('institution') error @enderror" name="institution" value="{{ old('institution')}}" placeholder="Institution Name">
                                            @error('institution')
                                            <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12 commonSelect2Style">
                                        <label for="qualification-country">Qualification Country</label>
                                        <select id="qualification-country" class="inputFieldHeight form-control common-select2 @error('qualification_country') error @enderror" name="qualification_country">
                                            <option value="">Select Country</option>
                                            @foreach ($countries as $country)
                                                <option value="{{$country->name}}" {{ old('qualification_country') == $country->name ? 'selected' : '' }}> {{$country->name}}</option>
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
                                            <input type="text" id="local-telephone" class="inputFieldHeight form-control @error('telephone') error @enderror" name="telephone" value="{{  old('telephone')}}" placeholder="Local Telephone">
                                            @error('telephone')
                                            <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="permanent-telephone">Permanent telephone</label>
                                            <input type="number" id="permanent-telephone" class="inputFieldHeight form-control @error('permanent_telephone') error @enderror" name="permanent_telephone" value="{{ old('permanent_telephone')}}" placeholder="Company Contact Details">
                                            @error('permanent_telephone')
                                            <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="Emirates">Emirates</label>
                                            <select id="Emirates" class="inputFieldHeight form-control @error('emirate_name') error @enderror" name="emirate_name">
                                                @foreach ($emirates as $emirate)
                                                <option value="{{$emirate}}" {{ old('emirate_name') == $emirate ? 'selected' : ''}}> {{$emirate}}</option>
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
                                            <textarea name="local_address" id="local-address" class="form-control @error('local_address') error @enderror" cols="30" rows="3">{{ old('local_address')}} </textarea>
                                            @error('local_address')
                                            <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="permanent-address">Permanent Address</label>
                                            <textarea name="permanent_address" id="permanent-address" class="form-control @error('permanent_address') error @enderror" cols="30" rows="3"> {{ old('permanent_address')}}</textarea>
                                            @error('permanent_address')
                                            <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn mr-1 btn-primary formButton" data-repeater-delete="" title="Add" data-repeater-create="">
                                            <div class="d-flex">
                                                <div class="formSaveIcon">
                                                    <img src="{{asset("assets/backend/app-assets/icon/save-icon.png")}}" alt="" srcset="" width="25">
                                                </div>
                                                <div><span>Save</span></div>
                                            </div>
                                        </button>
                                        <button type="reset" class="btn btn-light-secondary formButton" title="Form Reset">
                                            <div class="d-flex">
                                                <div class="formRefreshIcon">
                                                    <img src="{{asset("assets/backend/app-assets/icon/refresh-icon.png")}}" alt="" srcset="" class="img-fluid" width="25">
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
        </section>
        <!-- Basic Vertical form layout section end -->



    </form>
</div>