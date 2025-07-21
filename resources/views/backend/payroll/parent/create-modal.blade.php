<style>    
    .profile-img:hover img{
        -ms-transform: scale(1.5); /* IE 9 */
        -webkit-transform: scale(1.5); /* Safari 3-8 */
        transform: scale(6);
        cursor: pointer;
    }
    .profile-img img{
        transition: transform 1s;
        z-index: 1001;

    }
    .profile-img:hover{
        z-index: 100;
    }
    .commonSelect2Style span{
        width: 100% !important;
    }
    .select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b{
        display: none;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow b{
        display: none;
    }
</style>
@php
    $emirates=array('Abu Dhabi','Ajman','Dubai','Fujairah','Ras Al Khaimah','Sharjah','Umm Al Quwain');
@endphp
<section class="print-hideen border-bottom">
    <div class="d-flex flex-row-reverse">
        <div class="mIconStyleChange"><a href="#" class="close btn-icon btn btn-danger" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class='bx bx-x'></i></span></a></div>
        {{-- <div class="mIconStyleChange"><a href="#" class="btn btn-icon btn-success"><i class="bx bx-edit"></i></a></div>
        <div class="mIconStyleChange"><a href="#"  onclick="window.print();" class="btn btn-icon btn-secondary"><i class='bx bx-printer'></i></a></div>
        <div class="mIconStyleChange"><a href="#"  onclick="window.print();" class="btn btn-icon btn-primary"><i class='bx bxs-file-pdf'></i></a></div>
        <div class="mIconStyleChange"><a href="#"  onclick="window.print();" class="btn btn-icon btn-light"><i class='bx bxs-virus'></i></a></div> --}}
      </div>
</section>
@include('backend.tab-file.modal-header-info')
<div class="content-body">
    <form class="form form-vertical m-1" action="{{route('parent.store')}}" method="POST" enctype="multipart/form-data">
        @csrf 

        <!-- Basic Vertical form layout section start -->
        <section id="basic-vertical-layouts">
            <h5 class="p-1 bg-light">Father's Information: Personal Details</h5>
            <div class="row">
                <div class="col-md-4 col-12">
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" id="first-name-vertical" class="inputFieldHeight form-control @error('f_fname') error @enderror" name="f_fname" value="{{ old('f_fname')}}" placeholder="First Name" required>
                        @error('f_fname')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="form-group">
                        <label>Middle Name</label>
                        <input type="text" id="f-middle-name" class="inputFieldHeight form-control @error('f_mname') error @enderror" name="f_mname" value="{{ old('f_mname')}}" placeholder="Middle Name" >
                        @error('f_mname')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="form-group">
                        <label>Family Name</label>
                        <input type="text" id="contact-info-vertical" class="inputFieldHeight form-control @error('f_family_name') error @enderror" name="f_family_name" value="{{ old('f_family_name')}}" placeholder="Family Name" required>
                        @error('f_family_name')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" id="contact-info-vertical" class="inputFieldHeight form-control @error('f_email_address') error @enderror" name="f_email_address" value="{{ old('f_email_address')}}" placeholder="Email Address" required>
                        @error('f_email_address')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-3 col-12">
                    <div class="form-group">
                    <label>Date of Birth</label>
                    <input type="date" max="9999-12-31" name="f_dob" class="inputFieldHeight form-control @error('f_dob') error @enderror" value="{{ old('f_dob')}}" placeholder="dd-mm-yyy" required>
                    @error('f_dob')
                    <span class="error">{{ $message }}</span>
                    @enderror
                    </div>
                </div>

                <div class="col-sm-3 col-12 commonSelect2Style">
                    <label>Nationality</label>
                    <select name="f_nationality" class="inputFieldHeight form-control common-select2 @error('f_nationality') error @enderror" id="" required>
                        <option value="">Select Country</option>
                        @foreach ($countries as $country)
                        <option value="{{$country->name}}" {{ (old("f_nationality") == $country->name ? "selected":"") }}> {{$country->name}}</option>
                        @endforeach
                    </select>
                    @error('f_nationality')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                    <label>Emirates ID Number</label>
                    <input type="text" name="f_emirates_id_num" class="inputFieldHeight form-control @error('f_emirates_id_num') error @enderror" value="{{ old('f_emirates_id_num')}}" placeholder="000-0000-0000000-0" required>
                    @error('f_emirates_id_num')
                    <span class="error">{{ $message }}</span>
                    @enderror    
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                    <label>Emirates ID Expiry Date</label>
                    <input type="date" max="9999-12-31" name="f_emirates_id_exp" class="inputFieldHeight form-control @error('f_emirates_id_exp') error @enderror" value="{{ old('f_emirates_id_exp')}}" placeholder="dd/mm/yyyy" required>
                    @error('f_emirates_id_exp')
                    <span class="error">{{ $message }}</span>
                    @enderror
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        <label>First Language</label>
                        <select name="f_first_lang" class="inputFieldHeight form-control @error('f_first_lang') error @enderror" id="" required>
                            <option value="Bangla" {{ (old("f_first_lang") == 'Bangla' ? "selected":"") }}> Bangla</option>
                            <option value="English" {{ (old("f_first_lang") == 'English' ? "selected":"") }}> English</option>
                            <option value="Urdu" {{ (old("f_first_lang") == 'Urdu' ? "selected":"") }}> Urdu</option>
                            <option value="Arabic" {{ (old("f_first_lang") == 'Arabic' ? "selected":"") }}> Arabic</option>
                            <option value="Hindi" {{ (old("f_first_lang") == 'Hindi' ? "selected":"") }}> Hindi</option>
                        </select>
                        @error('f_first_lang')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Second Language</label>
                        <select name="f_second_lang" class="inputFieldHeight form-control @error('f_second_lang') error @enderror" id="" required>
                            <option value="Bangla" {{ (old("f_second_lang") == 'Bangla' ? "selected":"") }}> Bangla</option>
                            <option value="English" {{ (old("f_second_lang") == 'English' ? "selected":"") }}> English</option>
                            <option value="Urdu" {{ (old("f_second_lang") == 'Urdu' ? "selected":"") }}> Urdu</option>
                            <option value="Arabic" {{ (old("f_second_lang") == 'Arabic' ? "selected":"") }}> Arabic</option>
                            <option value="Hindi" {{ (old("f_second_lang") == 'Hindi' ? "selected":"") }}> Hindi</option>
                        </select>
                        @error('f_second_lang')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div> 
                
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="d-block">Prefered Mode Of Communication</label>
                        <div class="custom-control custom-radio my-50">
                            <input type="radio" id="validationRadiojq1d" name="f_mode_of_communication" class="custom-control-input" value="phone"
                            {{ old('f_mode_of_communication') == 'phone' ? 'checked' : ''}}
                            >
                            <label class="custom-control-label" for="validationRadiojq1d">Phone</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="validationRadiojq2d" name="f_mode_of_communication" class="custom-control-input" value="email"
                            {{ old('f_mode_of_communication') == 'email' ? 'checked' : ''}}
                            >
                            <label class="custom-control-label" for="validationRadiojq2d">Email</label>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group d-flex">
                        <div>
                            <label>Emirates ID Upload</label>
                            <input type="file" name="f_emirates_id_upload" class="inputFieldHeight form-control @error('f_emirates_id_upload') error @enderror" onchange="fatherEmirateImgChange()" required>
                            @error('f_emirates_id_upload')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="profile-img pl-2">
                            <img src="" alt="" width="70" height="70" id="fatherEmirateImgPreview">
                        </div>
                    </div>
                </div>
                <div class="col-md-3 changeColStyle">
                    <label>Others</label>
                    <input type="file" class="form-control inputFieldHeight" name="father_files[]" multiple >
                    @error('file')
                    <div class="btn btn-sm btn-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </section>
        <!-- Basic Vertical form layout section end -->

        <!-- Basic Vertical form layout section start -->
        <section id="basic-vertical-layouts">
            <h5 class="p-1 bg-light">Passport & Visa Information</h5>
            <div class="row">
                
                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label for="passport-number">Passport Number</label>
                        <input type="text" id="passport-number" class="inputFieldHeight form-control @error('f_passport_num') error @enderror" name="f_passport_num" value="{{ old('f_passport_num')}}" placeholder="Passport Number" required>
                        @error('f_passport_num')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-3 col-12 commonSelect2Style">
                    <label for="passport-country1">Passport Issuing Country</label>
                    <select id="passport-country1" class="inputFieldHeight form-control common-select2 @error('f_passport_country') error @enderror" name="f_passport_country" required>
                        <option value="">Select Country</option>
                        @foreach ($countries as $country)
                        <option value="{{$country->name}}" {{ old('f_passport_country') == $country->name ? 'selected' : '' }} > {{$country->name}}</option>
                        @endforeach
                    </select>
                    @error('f_passport_country')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label for="visa-number">Visa Number</label>
                        <input type="text" id="visa-number" class="inputFieldHeight form-control @error('f_visa_number') error @enderror" name="f_visa_number" value="{{ old('f_visa_number')}}" placeholder="Visa Number" required>
                        @error('f_visa_number')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-3 col-12">
                    <div class="form-group">
                    <label for="visa-type">Visa Type</label>
                    <select id="visa-type" class="inputFieldHeight form-control @error('f_visa_type') error @enderror" name="f_visa_type">
                        <option value="Residence"> Residence</option>
                        <option value="NonResidence"> Non Residence</option>
                    </select>
                    @error('f_visa_type')
                    <span class="error">{{ $message }}</span>
                    @enderror
                    </div>
                </div>

                <div class="col-md-3 col-12 commonSelect2Style">
                    <label for="visa-issue-place12">Visa Issue Place</label>
                    <select id="visa-issue-place12" class="inputFieldHeight form-control common-select2 @error('f_visa_issue_place') error @enderror" name="f_visa_issue_place" required>
                        <option value="">Select Place</option>
                        @foreach ($emirates as $emirate)
                        <option value="{{$emirate}}" {{ old('f_visa_issue_place') == $emirate ? 'selected' : '' }} > {{$emirate}}</option>
                        @endforeach
                    </select>
                    @error('f_visa_issue_place')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label for="visa-expire-date">Visa Expiry Date</label>
                        <input type="date" max="9999-12-31" id="visa-expire-date" class="inputFieldHeight form-control @error('f_visa_exp') error @enderror" name="f_visa_exp" value="{{ old('f_visa_exp')}}" placeholder="dd/mm/yyyy" required>
                        @error('f_visa_exp')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

            </div>
        </section>
        <!-- Basic Vertical form layout section end -->

        <!-- Basic Vertical form layout section start -->
        <section id="basic-vertical-layouts">
            <h5 class="p-1 bg-light">Education & Profession</h5>
            <div class="row">
                
                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label for="Qualification">Qualification</label>
                        <select id="Qualification" class="inputFieldHeight form-control @error('f_qualification') error @enderror" name="f_qualification" required>
                            <option value="Primary" {{old('f_qualification' == 'Primary' ? 'selected': '')}}> Primary</option>
                            <option value="Secondary" {{old('f_qualification' == 'Secondary' ? 'selected': '')}}> Secondary</option>
                            <option value="Higher Secondary" {{old('f_qualification' == 'Higher Secondary' ? 'selected': '')}}> Higher Secondary</option>
                            <option value="Graduate" {{old('f_qualification' == 'Graduate' ? 'selected': '')}}> Graduate</option>
                            <option value="Postgraduate" {{old('f_qualification' == 'Postgraduate' ? 'selected': '')}}> Postgraduate</option>
                        </select>
                        @error('f_qualification')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label for="year-of-passing">Year of passing</label>
                        <input type="number" id="f_year_of_passing" class="inputFieldHeight form-control @error('f_year_of_passing') error @enderror" name="f_year_of_passing" value="{{ old('f_year_of_passing')}}" placeholder="Year of passing" required>
                        @error('f_year_of_passing')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label for="institution">Institution Name</label>
                        <input type="text" id="institution" class="inputFieldHeight form-control @error('f_institution') error @enderror" name="f_institution" value="{{ old('f_institution')}}" placeholder="Institution Name" required>
                        @error('f_institution')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-3 col-12 commonSelect2Style">
                    <label for="qualification-country">Country of education</label>
                    <select id="qualification-country" class="inputFieldHeight form-control common-select2 @error('f_qualification_country') error @enderror" name="f_qualification_country" required>
                        <option value="">Select Country</option>
                        @foreach ($countries as $country)
                        <option value="{{$country->name}}" {{ old('f_qualification_country') == $country->name ? 'selected' : '' }}> {{$country->name}}</option>
                        @endforeach
                    </select>
                    @error('f_qualification_country')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label for="occupation">Occupation</label>
                        <input type="text" name="f_occupation" class="inputFieldHeight form-control @error('f_occupation') error @enderror " value="{{ old('f_occupation')}}" required placeholder="Occupation">
                        @error('f_occupation')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>                                            

                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label for="company-name">Company Name</label>
                        <input type="text" id="company-name" class="inputFieldHeight form-control @error('f_company_name') error @enderror" name="f_company_name" value="{{ old('f_company_name')}}" placeholder="Company Name" required>
                        @error('f_company_name')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label for="Company Contact Details">Company Contact Details</label>
                        <input type="number" id="Company Contact Details" class="inputFieldHeight form-control @error('f_company_contact_details') error @enderror" name="f_company_contact_details" value="{{ old('f_company_contact_details')}}" placeholder="Company Contact Details" required>
                        @error('f_company_contact_details')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label for="monthly-income">Monthly Income</label>
                        <input type="number" id="monthly-income" class="inputFieldHeight form-control @error('f_monthly_income') error @enderror" name="f_monthly_income" value="{{ old('f_monthly_income')}}" placeholder="Monthly Income" required>
                        @error('f_monthly_income')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

            </div>
        </section>
        <!-- Basic Vertical form layout section end -->

        <!-- Basic Vertical form layout section start -->
        <section id="basic-vertical-layouts">
            <h5 class="p-1 bg-light">Address Details</h5>
            <div class="row">
                
                <div class="col-md-6 col-12">
                    <div class="form-group">
                        <label for="local-address">Local Address</label>
                        <textarea name="f_local_address" id="local-address" class="form-control @error('f_local_address') error @enderror" cols="30" rows="3" required>{{ old('f_local_address')}} </textarea>
                        @error('f_local_address')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6 col-12">
                    <div class="form-group">
                        <label for="permanent-address">Permanent Address</label>
                        <textarea name="f_permanent_address" id="permanent-address" class="form-control @error('f_permanent_address') error @enderror" cols="30" rows="3" required> {{ old('f_permanent_address')}}</textarea>
                        @error('f_permanent_address')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4 col-12">
                    <div class="form-group">
                        <label for="local-telephone">Local telephone</label>
                        <input type="text" id="local-telephone" class="inputFieldHeight form-control @error('f_telephone') error @enderror" name="f_telephone" value="{{ old('f_telephone')}}" placeholder="Local Telephone" required>
                        @error('f_telephone')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-4 col-12">
                    <div class="form-group">
                        <label for="permanent-telephone">Permanent telephone</label>
                        <input type="text" id="permanent-telephone" class="inputFieldHeight form-control @error('f_permanent_telephone') error @enderror" name="f_permanent_telephone" value="{{ old('f_permanent_telephone')}}"  placeholder="Permanent telephone" required>
                        @error('f_permanent_telephone')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4 col-12">
                    <div class="form-group">
                        <label for="Emirates">Emirates</label>
                        <select id="Emirates" class="inputFieldHeight form-control @error('f_emirate_name') error @enderror" name="f_emirate_name" required>
                            <option value="Ras Al Khaimah" {{ old('f_emirate_name') == 'Ras Al Khaimah' ? 'selected' : '' }}>Ras Al Khaimah</option> 
                            <option value="Umm Al Quwain" {{ old('f_emirate_name') == 'Umm Al Quwain' ? 'selected' : '' }}>Umm Al Quwain</option>
                            <option value="Abu Dhabi" {{ old('f_emirate_name') == 'Abu Dhabi' ? 'selected' : '' }}>Abu Dhabi</option>
                            <option value="Dubai" {{ old('f_emirate_name') == 'Dubai' ? 'selected' : '' }}>Dubai</option>
                            <option value="Sharjah" {{ old('f_emirate_name') == 'Sharjah' ? 'selected' : '' }}>Sharjah</option>
                            <option value="Ajman" {{ old('f_emirate_name') == 'Ajman' ? 'selected' : '' }}>Ajman</option>
                            <option value="Fujairah" {{ old('f_emirate_name') == 'Fujairah' ? 'selected' : '' }}>Fujairah</option>
                        </select>
                        @error('f_emirate_name')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>


            </div>
        </section>
        <!-- Basic Vertical form layout section end -->

        <!-- Basic Vertical form layout section start -->
        <section id="basic-vertical-layouts">
            <h5 class="p-1 bg-light">Mother's Information: Personal Details</h5>
            <div class="row">
                <div class="col-md-4 col-12">
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" id="first-name-vertical" class="inputFieldHeight form-control @error('m_fname') error @enderror" name="m_fname" value="{{ old('m_fname')}}" placeholder="First Name" required>
                        @error('m_fname')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="form-group">
                        <label>Middle Name</label>
                        <input type="text" id="m-middle-name" class="inputFieldHeight form-control @error('m_mname') error @enderror" name="m_mname" value="{{ old('m_mname')}}" placeholder="Middle Name">
                        @error('m_mname')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="form-group">
                        <label>Family Name</label>
                        <input type="text" id="contact-info-vertical" class="inputFieldHeight form-control @error('m_family_name') error @enderror" name="m_family_name" value="{{ old('m_family_name')}}" placeholder="Family Name" required>
                        @error('m_family_name')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" id="contact-info-vertical" class="inputFieldHeight form-control @error('m_email_address') error @enderror" name="m_email_address" value="{{ old('m_email_address')}}" placeholder="Email Address" required>
                        @error('m_email_address')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-3 col-12">
                    <div class="form-group">
                    <label>Date of Birth</label>
                    <input type="date" max="9999-12-31" name="m_dob" class="inputFieldHeight form-control @error('m_dob') error @enderror" value="{{ old('m_dob')}}" placeholder="dd-mm-yyy" required>
                    @error('m_dob')
                    <span class="error">{{ $message }}</span>
                    @enderror
                    </div>
                </div>

                <div class="col-sm-3 col-12 commonSelect2Style">
                    <label>Nationality</label>
                    <select name="m_nationality" class="inputFieldHeight form-control common-select2 @error('m_nationality') error @enderror" id="" required>
                        <option value="">Select Country</option>
                        @foreach ($countries as $country)
                        <option value="{{$country->name}}" {{ old('m_nationality') == $country->name ? 'selected' : '' }} > {{$country->name}}</option>
                        @endforeach
                    </select>
                    @error('m_nationality')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                    <label>Emirates ID Number</label>
                    <input type="text" name="m_emirates_id_num" class="inputFieldHeight form-control @error('m_emirates_id_num') error @enderror" value="{{ old('m_emirates_id_num')}}" placeholder="000-0000-0000000-0" required>
                    @error('m_emirates_id_num')
                    <span class="error">{{ $message }}</span>
                    @enderror    
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                    <label>Emirates ID Expiry Date</label>
                    <input type="date" max="9999-12-31" name="m_emirates_id_exp" class="inputFieldHeight form-control @error('m_emirates_id_exp') error @enderror" value="{{ old('m_emirates_id_exp')}}" placeholder="dd/mm/yyyy" required>
                    @error('m_emirates_id_exp')
                    <span class="error">{{ $message }}</span>
                    @enderror
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        <label>First Language</label>
                        <select name="m_first_lang" class="inputFieldHeight form-control @error('m_first_lang') error @enderror" id="" required>
                            <option value="Bangla" {{old('m_first_lang' == 'Bangla' ? 'selected': '')}}> Bangla</option>
                            <option value="English" {{old('m_first_lang' == 'English' ? 'selected': '')}}> English</option>
                            <option value="Urdu" {{old('m_first_lang' == 'Urdu' ? 'selected': '')}}> Urdu</option>
                            <option value="Arabic" {{old('m_first_lang' == 'Arabic' ? 'selected': '')}}> Arabic</option>
                            <option value="Hindi" {{old('m_first_lang' == 'Hindi' ? 'selected': '')}}> Hindi</option>
                        </select>
                        @error('m_first_lang')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Second Language</label>
                        <select name="m_second_lang" class="inputFieldHeight form-control @error('m_second_lang') error @enderror" id="" required>
                            <option value="Bangla" {{old('m_second_lang' == 'Bangla' ? 'selected': '')}}> Bangla</option>
                            <option value="English" {{old('m_second_lang' == 'Bangla' ? 'selected': '')}}> English</option>
                            <option value="Urdu" {{old('m_second_lang' == 'Bangla' ? 'selected': '')}}> Urdu</option>
                            <option value="Arabic" {{old('m_second_lang' == 'Bangla' ? 'selected': '')}}> Arabic</option>
                            <option value="Hindi" {{old('m_second_lang' == 'Bangla' ? 'selected': '')}}> Hindi</option>
                        </select>
                        @error('m_second_lang')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div> 
                
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="d-block">Prefered Mode Of Communication</label>
                        <div class="custom-control custom-radio my-50">
                            <input type="radio" id="validationRadiojq11" name="m_mode_of_communication" class="custom-control-input" value="phone"
                            {{ old('f_mode_of_communication') == 'phone' ? 'checked' : ''}}
                            >
                            <label class="custom-control-label" for="validationRadiojq11">Phone</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="validationRadiojq21" name="m_mode_of_communication" class="custom-control-input" value="email"
                            {{ old('f_mode_of_communication') == 'email' ? 'checked' : ''}}
                            >
                            <label class="custom-control-label" for="validationRadiojq21">Email</label>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group d-flex">
                        <div>
                            <label>Emirates ID Upload</label>
                            <input type="file" name="m_emirates_id_upload" value="{{old('m_emirates_id_upload')}}" class="inputFieldHeight form-control @error('m_emirates_id_upload') error @enderror" onchange="motherEmirateImgChange()" required>
                            @error('m_emirates_id_upload')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="profile-img pl-2">
                            <img src="" alt="" width="70" height="70" id="motherEmirateImgPreview">
                        </div>
                    </div>
                </div>
                <div class="col-md-3 changeColStyle">
                    <label>Others</label>
                    <input type="file" class="form-control inputFieldHeight" name="mother_files[]" multiple >
                    @error('file')
                    <div class="btn btn-sm btn-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </section>
        <!-- Basic Vertical form layout section end -->

        <!-- Basic Vertical form layout section start -->
        <section id="basic-vertical-layouts">
            <h5 class="p-1 bg-light">Passport & Visa Information</h5>
            <div class="row">
                
                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label for="passport-number">Passport Number</label>
                        <input type="text" id="passport-number" class="inputFieldHeight form-control @error('m_passport_num') error @enderror" name="m_passport_num" value="{{ old('m_passport_num')}}" placeholder="Passport Number" required>
                        @error('m_passport_num')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-3 col-12 commonSelect2Style">
                    <label for="passport-country2">Passport Issuing Country</label>
                        <select id="passport-country2" class="inputFieldHeight form-control common-select2 @error('m_passport_country') error @enderror" name="m_passport_country" required>
                            <option value="">Select Country</option>
                            @foreach ($countries as $country)
                            <option value="{{$country->name}}" {{ (old("m_passport_country") == $country->name ? "selected":"") }}> {{$country->name}}</option>
                            @endforeach
                        </select>
                        @error('m_passport_country')
                        <span class="error">{{ $message }}</span>
                        @enderror
                </div>

                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label for="visa-number">Visa Number</label>
                        <input type="text" id="visa-number" class="inputFieldHeight form-control @error('m_visa_number') error @enderror" name="m_visa_number" value="{{ old('m_visa_number')}}" placeholder="Visa Number" required>
                        @error('m_visa_number')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-3 col-12">
                    <div class="form-group">
                    <label for="visa-type">Visa Type</label>
                    <select id="visa-type" class="inputFieldHeight form-control @error('m_visa_type') error @enderror" name="m_visa_type" required>
                        <option value="Residence" {{old('m_visa_type' == 'Residence' ? 'selected': '')}}> Residence</option>
                        <option value="NonResidence" {{old('m_visa_type' == 'NonResidence' ? 'selected': '')}}> Non Residence</option>
                    </select>
                    @error('m_visa_type')
                    <span class="error">{{ $message }}</span>
                    @enderror
                    </div>
                </div>

                <div class="col-md-3 col-12 commonSelect2Style">
                    <label for="visa-issue-place">Visa Issue Place</label>
                    <select id="visa-issue-place" class="inputFieldHeight form-control common-select2 @error('m_visa_issue_place') error @enderror" name="m_visa_issue_place" required>
                        <option value="">Select Place</option>
                        @foreach ($emirates as $emirate)
                        <option value="{{$emirate}}" {{ old('m_visa_issue_place') == $emirate ? 'selected' : '' }} > {{$emirate}}</option>
                        @endforeach
                    </select>
                    @error('m_visa_issue_place')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label for="visa-expire-date">Visa Expiry Date</label>
                        <input type="date" max="9999-12-31" id="visa-expire-date" class="inputFieldHeight form-control @error('m_visa_exp') error @enderror" name="m_visa_exp" value="{{ old('m_visa_exp')}}" placeholder="dd/mm/yyyy" required>
                        @error('m_visa_exp')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

            </div>
        </section>
        <!-- Basic Vertical form layout section end -->

        <!-- Basic Vertical form layout section start -->
        <section id="basic-vertical-layouts">
            <h5 class="p-1 bg-light">Education & Profession</h5>
            <div class="row">
                
                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label for="Qualification">Qualification</label>
                        <select id="Qualification" class="inputFieldHeight form-control @error('m_qualification') error @enderror" name="m_qualification" required>
                            <option value="Primary" {{old('m_qualification' == 'Primary' ? 'selected':'')}}> Primary</option>
                            <option value="Secondary" {{old('m_qualification' == 'Secondary' ? 'selected':'')}}> Secondary</option>
                            <option value="Higher Secondary" {{old('m_qualification' == 'Higher Secondary' ? 'selected':'')}}> Higher Secondary</option>
                            <option value="Graduate" {{old('m_qualification' == 'Graduate' ? 'selected':'')}}> Graduate</option>
                            <option value="Postgraduate" {{old('m_qualification' == 'Postgraduate' ? 'selected':'')}}> Postgraduate</option>
                        </select>
                        @error('m_qualification')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label for="year-of-passing">Year of passing</label>
                        <input type="number" id="m_year_of_passing" class="inputFieldHeight form-control @error('m_year_of_passing') error @enderror" name="m_year_of_passing" value="{{ old('m_year_of_passing')}}" placeholder="Year of passing" required>
                        @error('m_year_of_passing')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label for="institution">Institution Name</label>
                        <input type="text" id="institution" class="inputFieldHeight form-control @error('m_institution') error @enderror" name="m_institution" value="{{ old('m_institution')}}" placeholder="Institution Name" required>
                        @error('m_institution')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-3 col-12 commonSelect2Style">
                    <label for="qualification-country2">Country of education</label>
                    <select id="qualification-country2" class="inputFieldHeight form-control common-select2 @error('m_qualification_country') error @enderror" name="m_qualification_country" required>
                        <option value="">Select Country</option>
                        @foreach ($countries as $country)
                        <option value="{{$country->name}}" {{ (old("m_qualification_country") == $country->name ? "selected":"") }}> {{$country->name}}</option>
                        @endforeach
                    </select>
                    @error('m_qualification_country')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label for="occupation">Occupation</label>
                        <input type="text" id="occupation" class="inputFieldHeight form-control @error('m_occupation') error @enderror" name="m_occupation" value="{{ old('m_occupation')}}" required placeholder="Occupation">
                        @error('m_occupation')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>                                            

                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label for="company-name">Company Name</label>
                        <input type="text" id="company-name" class="inputFieldHeight form-control @error('m_company_name') error @enderror" name="m_company_name" value="{{ old('m_company_name')}}" placeholder="Company Name" required>
                        @error('m_company_name')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label for="Company Contact Details">Company Contact Details</label>
                        <input type="number" id="Company Contact Details" class="inputFieldHeight form-control @error('m_company_contact_details') error @enderror" name="m_company_contact_details" value="{{ old('m_company_contact_details')}}" placeholder="Company Contact Details" required>
                        @error('m_company_contact_details')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label for="monthly-income">Monthly Income</label>
                        <input type="number" id="monthly-income" class="inputFieldHeight form-control @error('m_monthly_income') error @enderror" name="m_monthly_income" value="{{ old('m_monthly_income')}}" placeholder="Monthly Income" required>
                        @error('m_monthly_income')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

            </div>
        </section>
        <!-- Basic Vertical form layout section end -->

        <!-- Basic Vertical form layout section start -->
        <section id="basic-vertical-layouts">
            <h5 class="p-1 bg-light">Address Details</h5>
            <div class="row">
                
                <div class="col-md-6 col-12">
                    <div class="form-group">
                        <label for="local-address">Local Address</label>
                        <textarea name="m_local_address" id="local-address" class="form-control @error('m_local_address') error @enderror" cols="30" rows="3" required> {{ old('m_local_address')}} </textarea>
                        @error('m_local_address')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6 col-12">
                    <div class="form-group">
                        <label for="permanent-address">Permanent Address</label>
                        <textarea name="m_permanent_address" id="permanent-address" class="form-control @error('m_permanent_address') error @enderror" cols="30" rows="3" required> {{ old('m_permanent_address')}}</textarea>
                        @error('m_permanent_address')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4 col-12">
                    <div class="form-group">
                        <label for="local-telephone">Local telephone</label>
                        <input type="text" id="local-telephone" class="inputFieldHeight form-control @error('m_telephone') error @enderror" name="m_telephone" value="{{ old('m_telephone')}}" placeholder="Local Telephone" required>
                        @error('m_telephone')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-4 col-12">
                    <div class="form-group">
                        <label for="permanent-telephone">Permanent telephone</label>
                        <input type="text" id="permanent-telephone" class="inputFieldHeight form-control @error('m_permanent_telephone') error @enderror" name="m_permanent_telephone" value="{{ old('m_permanent_telephone')}}"  placeholder="Permanent telephone" required>
                        @error('m_permanent_telephone')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4 col-12">
                    <div class="form-group">
                        <label for="Emirates">Emirates</label>
                        <select id="Emirates" class="inputFieldHeight form-control @error('m_emirate_name') error @enderror" name="m_emirate_name" required>
                            @foreach ($emirates as $emirate)
                            <option value="{{$emirate}}" {{ old('m_emirate_name') == $emirate ? 'selected' : '' }} > {{$emirate}}</option>
                            @endforeach
                        </select>
                        @error('m_emirate_name')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

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
        </section>
    </form>
</div>
@include('backend.tab-file.modal-footer-info')
