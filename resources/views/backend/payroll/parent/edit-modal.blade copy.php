
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
    $languages= array('Bangla','English','Urdu','Arabic','Hindi');
@endphp

<section class="print-hideen border-bottom">
    <div class="d-flex flex-row-reverse">
        <div class="mIconStyleChange"><a href="#" class="close btn-icon btn btn-danger" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class='bx bx-x'></i></span></a></div>
        <div class="mIconStyleChange"><a href="#" class="btn btn-icon btn-secondary parentProfilePrint" data-dismiss="modal" id="{{$parent->id}}"><i class='bx bx-printer'></i></a></div>
        <div class="mIconStyleChange"><a href="{{route('parent-profile-pdf-download', $parent->id)}}" class="btn btn-icon btn-primary"><i class='bx bxs-file-pdf'></i></a></div>
        {{-- <div class="mIconStyleChange"><a href="#" onclick="window.print();" class="btn btn-icon btn-light"><i class='bx bxs-virus'></i></a></div> --}}
    </div>
</section>
@include('backend.tab-file.modal-header-info')
<div class="content-body">
    <form class="form form-vertical m-1" action="{{route('parent.update', $parent->id)}}" method="POST" enctype="multipart/form-data">
        @csrf 
        @method('PUT')
        <section id="basic-vertical-layouts">
            <h5 class="p-1 bg-light">Father's Information: Personal Details</h5>
            <div class="row">
                <div class="col-md-4 col-12">
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" id="first-name-vertical" value="{{old('f_fname') ? old('f_fname') : $parent->f_fname}}" class="inputFieldHeight form-control @error('f_fname') error @enderror" name="f_fname" placeholder="First Name" required>
                        @error('f_fname')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="form-group">
                        <label>Middle Name</label>
                        <input type="text" id="email-id-vertical" value="{{old('f_mname') ? old('f_mname') : $parent->f_mname}}" class="inputFieldHeight form-control @error('f_mname') error @enderror" name="f_mname" placeholder="Middle Name">
                        @error('f_mname')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="form-group">
                        <label>Family Name</label>
                        <input type="text" id="contact-info-vertical" value="{{old('f_family_name') ? old('f_family_name') : $parent->f_family_name}}" class="inputFieldHeight form-control @error('f_family_name') error @enderror" name="f_family_name" placeholder="Family Name" required>
                        @error('f_family_name')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" id="contact-info-vertical" value="{{old('f_email_address') ? old('f_email_address') : $parent->f_email_address}}" class="inputFieldHeight form-control @error('f_email_address') error @enderror" name="f_email_address" placeholder="Email Address" required>
                        @error('f_email_address')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-3 col-12">
                    <div class="form-group">
                    <label>Date of Birth</label>
                    <input type="date" max="9999-12-31" name="f_dob" value="{{old('f_dob') ? old('f_dob') : $parent->f_dob}}" class="inputFieldHeight form-control @error('f_dob') error @enderror" placeholder="dd-mm-yyy" required>
                    @error('f_dob')
                    <span class="error">{{ $message }}</span>
                    @enderror
                    </div>
                </div>

                <div class="col-sm-3 col-12 commonSelect2Style">
                    <label>Nationality</label>
                    <select name="f_nationality" class="inputFieldHeight form-control common-select2 @error('f_nationality') error @enderror" id="">
                        {{-- <option value="">Select Country</option> --}}
                        @foreach ($countries as $country)
                        <option value="{{$country->name}}"
                            @if (old('f_nationality')) {{old('f_nationality') == $country->name ? 'selected':''}} 
                            @else {{$parent->f_nationality == $country->name ? 'selected' : ''}} 
                            @endif> {{$country->name}}</option>
                        @endforeach
                    </select>
                    @error('f_nationality')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                    <label>Emirates ID Number</label>
                    <input type="text" name="f_emirates_id_num" value="{{old('f_emirates_id_num') ? old('f_emirates_id_num') : $parent->f_emirates_id_num}}" class="inputFieldHeight form-control @error('f_emirates_id_num') error @enderror" placeholder="000-0000-0000000-0" required>
                    @error('f_emirates_id_num')
                    <span class="error">{{ $message }}</span>
                    @enderror    
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                    <label>Emirates ID Expiry Date</label>
                    <input type="date" max="9999-12-31" name="f_emirates_id_exp" value="{{old('f_emirates_id_exp') ? old('f_emirates_id_exp') : $parent->f_emirates_id_exp}}" class="inputFieldHeight form-control @error('f_emirates_id_exp') error @enderror" placeholder="dd/mm/yyyy" required>
                    @error('f_emirates_id_exp')
                    <span class="error">{{ $message }}</span>
                    @enderror
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        <label>First Language</label>
                        <select name="f_first_lang" class="inputFieldHeight form-control @error('f_first_lang') error @enderror" id="">
                            @foreach ($languages as $each_lang)
                                <option value="{{$each_lang}}" {{ old('f_first_lang') == $each_lang ? 'selected' : ($parent->f_first_lang==$each_lang ? 'selected' : '') }}> {{$each_lang}}</option>
                            @endforeach
                        </select>
                        @error('f_first_lang')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Second Language</label>
                        <select name="f_second_lang" class="inputFieldHeight form-control @error('f_second_lang') error @enderror" id="">
                            @foreach ($languages as $each_lang)
                                <option value="{{$each_lang}}" {{ old('f_second_lang') == $each_lang ? 'selected' : ($parent->f_second_lang==$each_lang ? 'selected' : '') }}> {{$each_lang}}</option>
                            @endforeach
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
                            <input type="radio" id="f-com-phone" name="f_mode_of_communication" class="custom-control-input" value="phone"
                            @if (old('f_mode_of_communication'))
                                {{old('f_mode_of_communication') == 'phone' ? 'checked':''}}
                            @else
                                {{$parent->f_mode_of_communication == 'phone' ? 'checked' : ''}}
                            @endif >
                            <label class="custom-control-label" for="f-com-phone">Phone</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="f-com-email" name="f_mode_of_communication" class="custom-control-input" value="email"
                            @if (old('f_mode_of_communication'))
                                {{old('f_mode_of_communication') == 'email' ? 'checked':''}}
                            @else
                                {{$parent->f_mode_of_communication == 'email' ? 'checked' : ''}}
                            @endif >
                            <label class="custom-control-label" for="f-com-email">Email</label>
                        </div>
                        @error('f_mode_of_communication')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div> 

                <div class="col-sm-3">
                    <div class="form-group d-flex">
                        <div>
                            <label>Emirates ID Upload</label>
                            <input type="file" name="f_emirates_id_upload" class="inputFieldHeight form-control @error('f_emirates_id_upload') error @enderror" id="edit_fatherEmirateImgChange">
                            @error('f_emirates_id_upload')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="profile-img pl-2">
                            <img src="{{ asset('storage/upload/emirate_id/'.$parent->f_emirates_id_upload)}}" alt="" width="70" height="70" id="edit_fatherEmirateImgPreview">
                        </div>
                    </div>
                </div>
                
            </div>
                <div class="row data d-flex justify-content-end">
                    @if(count($fathers) != 0)
                        @foreach($fathers as $others)
                            <div class="col-md-1 img" style="height: 60px; width: 60px;">
                                {{-- <a href=""   class="close delete-img"></a> --}}
                        {{-- <span data_target="{{ route('othersDelete', $others->id) }}" class="close delete-img" >&times;</span> --}}
                                <span class="btn btn-warning invoice-item-delete" id="" data_target="{{ route('fathersDelete',$others) }}"><i class="bx bx-trash"></i></span>
                            
                                    @if ($others->extension == 'pdf')
                                        <a href="{{ asset('storage/upload/student-parent/'.$others->filename)}}" target="_blank">
                                            
                                            <img src="{{ asset('assets/backend/app-assets/icon/pdf-download-icon-2.png')}}" alt="jugyjugyt" style="height: 100%; width: 100%;">
                                        </a>
                                    @else
                                        <a href="{{ asset('storage/upload/student-parent/'.$others->filename)}}" target="_blank">
                                            <img src="{{ asset('storage/upload/student-parent/'.$others->filename)}}" alt="" style="height: 100%; width: 100%;">
                                        </a>
                                    @endif     
                            </div>
                        @endforeach
                    @endif
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
                        <input type="text" id="passport-number" value="{{old('f_passport_num') ? old('f_passport_num') : $parent->f_passport_num}}" class="inputFieldHeight form-control @error('f_passport_num') error @enderror" name="f_passport_num" placeholder="Passport Number" required>
                        @error('f_passport_num')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-3 col-12 commonSelect2Style">
                    <label for="passport-country1">Passport Issuing Country</label>
                    <select id="passport-country1" class="inputFieldHeight form-control common-select2 @error('f_passport_country') error @enderror" name="f_passport_country">
                        {{-- <option value="">Select Country</option> --}}
                        @foreach ($countries as $country)
                        <option value="{{$country->name}}"
                            @if (old('f_passport_country')) {{old('f_passport_country') == $country->name ? 'selected':''}} 
                            @else {{$parent->f_passport_country == $country->name ? 'selected' : ''}} 
                            @endif> {{$country->name}}</option>
                        @endforeach
                    </select>
                    @error('f_passport_country')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label for="visa-number">Visa Number</label>
                        <input type="text" id="visa-number" value="{{old('f_visa_number') ? old('f_visa_number') : $parent->f_visa_number}}" class="inputFieldHeight form-control @error('f_visa_number') error @enderror" name="f_visa_number" placeholder="Visa Number" required>
                        @error('f_visa_number')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-3 col-12">
                    <div class="form-group">
                    <label for="visa-type">Visa Type</label>
                    <select id="visa-type" class="inputFieldHeight form-control @error('f_visa_type') error @enderror" name="f_visa_type">
                        <option value="Residence" {{old('f_visa_type') ? 'selected' : ($parent->f_visa_type == 'Residence' ? 'selected' : '') }}> Residence</option>
                        <option value="NonResidence" {{old('f_visa_type') ? 'selected' : ($parent->f_visa_type == 'NonResidence' ? 'selected' : '') }}> Non Residence</option>
                    </select>
                    @error('f_visa_type')
                    <span class="error">{{ $message }}</span>
                    @enderror
                    </div>
                </div>

                <div class="col-md-3 col-12 commonSelect2Style">
                    <label for="visa-issue-place">Visa Issue Place</label>
                    <select id="visa-issue-place" class="inputFieldHeight form-control common-select2 @error('f_visa_issue_place') error @enderror" name="f_visa_issue_place">
                        {{-- <option value="">Select Country</option> --}}
                        @foreach ($emirates as $emirate)
                        <option value="{{$emirate}}"
                        @if (old('f_visa_issue_place')) {{old('f_visa_issue_place') == $emirate ? 'selected':''}} 
                        @else {{$parent->f_visa_issue_place == $emirate ? 'selected' : ''}} 
                        @endif> {{$emirate}}</option>
                        @endforeach
                    </select>
                    @error('f_visa_issue_place')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label for="visa-expire-date">Visa Expiry Date</label>
                        <input type="date" max="9999-12-31" id="visa-expire-date" value="{{old('f_visa_exp') ? old('f_visa_exp') : $parent->f_visa_exp}}" class="inputFieldHeight form-control @error('f_visa_exp') error @enderror" name="f_visa_exp" placeholder="dd/mm/yyyy">
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
                        <select id="Qualification" class="inputFieldHeight form-control @error('f_qualification') error @enderror" name="f_qualification">
                            <option value="Primary" {{old('f_qualification') ? 'selected' : ($parent->f_qualification == 'Primary' ? 'selected' : '') }}> Primary</option>
                            <option value="Secondary" {{old('f_qualification') ? 'selected' : ($parent->f_qualification == 'Secondary' ? 'selected' : '') }}> Secondary</option>
                            <option value="Higher Secondary" {{old('f_qualification') ? 'selected' : ($parent->f_qualification == 'Higher Secondary' ? 'selected' : '') }}> Higher Secondary</option>
                            <option value="Graduate" {{old('f_qualification') ? 'selected' : ($parent->f_qualification == 'Graduate' ? 'selected' : '') }}> Graduate</option>
                            <option value="Postgraduate" {{old('f_qualification') ? 'selected' : ($parent->f_qualification == 'Postgraduate' ? 'selected' : '') }}> Postgraduate</option>
                        </select>
                        @error('f_qualification')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label for="year-of-passing">Year of passing</label>
                        <input type="number" id="f_year_of_passing" class="inputFieldHeight form-control @error('f_year_of_passing') error @enderror" name="f_year_of_passing" value="{{ old('f_year_of_passing') ? old('f_year_of_passing') :$parent->f_year_of_passing}}" placeholder="Year of passing" required>
                        @error('f_year_of_passing')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label for="institution">Institution Name</label>
                        <input type="text" id="institution" value="{{ old('f_institution') ? old('f_institution') :$parent->f_institution}} " class="inputFieldHeight form-control @error('f_institution') error @enderror" name="f_institution" placeholder="Institution Name" required>
                        @error('f_institution')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-3 col-12 commonSelect2Style">
                    <label for="qualification-country">Country of education</label>
                    <select id="qualification-country" class="inputFieldHeight form-control common-select2 @error('f_qualification_country') error @enderror" name="f_qualification_country">
                        {{-- <option value="">Select Country</option> --}}
                        @foreach ($countries as $country)
                        <option value="{{$country->name}}"
                        @if (old('f_qualification_country')) {{old('f_qualification_country') == $country->name ? 'selected':''}} 
                        @else {{$parent->f_qualification_country == $country->name ? 'selected' : ''}} 
                        @endif> {{$country->name}}</option>
                        @endforeach
                    </select>
                    @error('f_qualification_country')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label for="occupation">Occupation</label>
                        <input type="text"  value="{{ old('f_occupation') ? old('f_occupation') : $parent->f_occupation}}" class="inputFieldHeight form-control @error('f_occupation') error @enderror" name="f_occupation" required>
                        @error('f_occupation')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>                                            

                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label for="company-name">Company Name</label>
                        <input type="text" id="company-name" value="{{ old('f_company_name') ? old('f_company_name') :$parent->f_company_name}}" class="inputFieldHeight form-control @error('f_company_name') error @enderror" name="f_company_name" placeholder="Company Name" required>
                        @error('f_company_name')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label for="Company Contact Details">Company Contact Details</label>
                        <input type="number" id="Company Contact Details" value="{{ old('f_company_contact_details') ? old('f_company_contact_details') :$parent->f_company_contact_details}}" class="inputFieldHeight form-control @error('f_company_contact_details') error @enderror" name="f_company_contact_details" placeholder="Company Contact Details"  required>
                        @error('f_company_contact_details')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label for="monthly-income">Monthly Income</label>
                        <input type="number" id="monthly-income" value="{{ old('f_monthly_income') ? old('f_monthly_income') :$parent->f_monthly_income}}" class="inputFieldHeight form-control @error('f_monthly_income') error @enderror" name="f_monthly_income" placeholder="Monthly Income" required>
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
                        <textarea name="f_local_address"  id="local-address" class="form-control @error('f_local_address') error @enderror" cols="30" rows="3" required>
                        {{ old('f_local_address') ? old('f_local_address') :$parent->f_local_address}}
                        </textarea>
                        @error('f_local_address')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6 col-12">
                    <div class="form-group">
                        <label for="permanent-address">Permanent Address</label>
                        <textarea  id="permanent-address" class="form-control @error('f_permanent_address') error @enderror" name="f_permanent_address" cols="30" rows="3" required>
                            {{ old('f_permanent_address') ? old('f_permanent_address') :$parent->f_permanent_address}}
                        </textarea>
                        @error('f_permanent_address')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-4 col-12">
                    <div class="form-group">
                        <label for="local-telephone">Local telephone</label>
                        <input type="text" value="{{ old('f_telephone') ? old('f_telephone') : $parent->f_telephone}}" id="local-telephone" class="inputFieldHeight form-control @error('f_telephone') error @enderror" name="f_telephone" placeholder="Local Telephone" required>
                        @error('f_telephone')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4 col-12">
                    <div class="form-group">
                        <label for="permanent-telephone">Permanent telephone</label>
                        <input type="number" value="{{ old('f_permanent_telephone') ? old('f_permanent_telephone') : $parent->f_permanent_telephone}}" id="permanent-telephone" class="inputFieldHeight form-control @error('f_permanent_telephone') error @enderror" name="f_permanent_telephone" placeholder="Company Contact Details" required>
                        @error('f_permanent_telephone')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4 col-12">
                    <div class="form-group">
                        <label for="Emirates">Emirates</label>
                        <select id="Emirates" class="inputFieldHeight form-control @error('f_emirate_name') error @enderror" name="f_emirate_name" required>
                            @foreach ($emirates as $emirate)
                            <option value="{{$emirate}}"
                            @if (old('f_emirate_name')) {{old('f_emirate_name') == $emirate ? 'selected':''}} 
                            @else {{$parent->f_emirate_name == $emirate ? 'selected' : ''}} 
                            @endif> {{$emirate}}</option>
                            @endforeach                                                            
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
                        <input type="text" id="first-name-vertical" value="{{ old('m_fname') ? old('m_fname') : $parent->m_fname}}" class="inputFieldHeight form-control @error('m_fname') error @enderror" name="m_fname" placeholder="First Name" required>
                        @error('m_fname')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="form-group">
                        <label>Middle Name</label>
                        <input type="text" id="email-id-vertical" value="{{ old('m_mname') ? old('m_mname') :  $parent->m_mname}}" class="inputFieldHeight form-control @error('m_mname') error @enderror" name="m_mname" placeholder="Middle Name">
                        @error('m_mname')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="form-group">
                        <label>Family Name</label>
                        <input type="text" id="contact-info-vertical" value="{{ old('m_family_name') ? old('m_family_name') : $parent->m_family_name}}" class="inputFieldHeight form-control @error('m_family_name') error @enderror" name="m_family_name" placeholder="Family Name" required>
                        @error('m_family_name')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" id="contact-info-vertical" value="{{old('m_email_address') ? old('m_email_address') : $parent->m_email_address}}" class="inputFieldHeight form-control @error('m_email_address') error @enderror" name="m_email_address" placeholder="Email Address" required>
                        @error('m_email_address')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-3 col-12">
                    <div class="form-group">
                    <label>Date of Birth</label>
                    <input type="date" max="9999-12-31" name="m_dob" value="{{old('m_dob') ? old('m_dob') : $parent->m_dob}}" class="inputFieldHeight form-control @error('m_dob') error @enderror" placeholder="dd-mm-yyy" required>
                    @error('m_dob')
                    <span class="error">{{ $message }}</span>
                    @enderror
                    </div>
                </div>

                <div class="col-sm-3 col-12 commonSelect2Style">
                    <label>Nationality</label>
                    <select name="m_nationality" class="inputFieldHeight form-control common-select2 @error('m_nationality') error @enderror" id="">
                        {{-- <option value="">Select Country</option> --}}
                        @foreach ($countries as $country)
                        <option value="{{$country->name}}"
                            @if (old('m_nationality')) {{old('m_nationality') == $country->name ? 'selected':''}} 
                            @else {{$parent->m_nationality == $country->name ? 'selected' : ''}} 
                            @endif> {{$country->name}}</option>
                        @endforeach
                    </select>
                    @error('m_nationality')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                    <label>Emirates ID Number</label>
                    <input type="text" name="m_emirates_id_num" value="{{old('m_emirates_id_num') ? old('m_emirates_id_num') : $parent->m_emirates_id_num}}" class="inputFieldHeight form-control @error('m_emirates_id_num') error @enderror" placeholder="000-0000-0000000-0" required>
                    @error('m_emirates_id_num')
                    <span class="error">{{ $message }}</span>
                    @enderror    
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                    <label>Emirates ID Expiry Date</label>
                    <input type="date" max="9999-12-31" name="m_emirates_id_exp" value="{{old('m_emirates_id_exp') ? old('m_emirates_id_exp') : $parent->m_emirates_id_exp}}" class="inputFieldHeight form-control @error('m_emirates_id_exp') error @enderror" placeholder="dd/mm/yyyy" required>
                    @error('m_emirates_id_exp')
                    <span class="error">{{ $message }}</span>
                    @enderror
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        <label>First Language</label>
                        <select name="m_first_lang" class="inputFieldHeight form-control @error('m_first_lang') error @enderror" id="">
                            @foreach ($languages as $each_lang)
                                <option value="{{$each_lang}}" {{ old('m_first_lang') == $each_lang ? 'selected' : ($parent->m_first_lang==$each_lang ? 'selected' : '') }}> {{$each_lang}}</option>
                            @endforeach
                        </select>
                        @error('m_first_lang')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Second Language</label>
                        <select name="m_second_lang" class="inputFieldHeight form-control @error('m_second_lang') error @enderror" id="">
                            @foreach ($languages as $each_lang)
                                <option value="{{$each_lang}}" {{ old('m_second_lang') == $each_lang ? 'selected' : ($parent->m_second_lang==$each_lang ? 'selected' : '') }}> {{$each_lang}}</option>
                            @endforeach
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
                            <input type="radio" id="m-communication-phone" name="m_mode_of_communication" class="custom-control-input" value="phone"
                            @if (old('m_mode_of_communication'))
                                {{old('m_mode_of_communication') == 'phone' ? 'checked':''}}
                            @else
                                {{$parent->m_mode_of_communication == 'phone' ? 'checked' : ''}}
                            @endif >
                            <label class="custom-control-label" for="m-communication-phone">Phone</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="m-com-email" name="m_mode_of_communication" class="custom-control-input" value="email"
                            @if (old('m_mode_of_communication'))
                                {{old('m_mode_of_communication') == 'email' ? 'checked':''}}
                            @else
                                {{$parent->m_mode_of_communication == 'email' ? 'checked' : ''}}
                            @endif >
                            <label class="custom-control-label" for="m-com-email">Email</label>
                        </div>
                        @error('m_mode_of_communication')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div> 

                <div class="col-sm-3">
                    <div class="form-group d-flex">
                        <div>
                            <label>Emirates ID Upload</label>
                            <input type="file" name="m_emirates_id_upload" class="inputFieldHeight form-control @error('m_emirates_id_upload') error @enderror" id="edit_motherEmirateImgChange">
                            @error('m_emirates_id_upload')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="profile-img pl-2">
                            <img src="{{ asset('storage/upload/emirate_id/'.$parent->m_emirates_id_upload)}}" alt="" width="70" height="70" id="edit_motherEmirateImgPreview">
                        </div>
                    </div>
                </div>
                <div class="col-md-3 changeColStyle">
                    <label>Other Document</label>
                    <input type="file" class="form-control inputFieldHeight" name="mother_files[]" multiple >
                    @error('file')
                    <div class="btn btn-sm btn-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
                <div class="row data2 d-flex justify-content-end">
                    @if(count($mothers) != 0)
                        @foreach($mothers as $others)
                            <div class="col-md-1 img" style="height: 60px; width: 60px;">
                                {{-- <a href=""   class="close delete-img"></a> --}}
                        {{-- <span data_target="{{ route('othersDelete', $others->id) }}" class="close delete-img" >&times;</span> --}}
                                <span class="btn btn-warning invoice-item-delete2" id="" data_target="{{ route('mothersDelete',$others) }}"><i class="bx bx-trash"></i></span>
                            
                                    @if ($others->extension == 'pdf')
                                        <a href="{{ asset('storage/upload/student-parent/'.$others->filename)}}" target="_blank">
                                            
                                            <img src="{{ asset('assets/backend/app-assets/icon/pdf-download-icon-2.png')}}" alt="jugyjugyt" style="height: 100%; width: 100%;">
                                        </a>
                                    @else
                                        <a href="{{ asset('storage/upload/student-parent/'.$others->filename)}}" target="_blank">
                                            <img src="{{ asset('storage/upload/student-parent/'.$others->filename)}}" alt="" style="height: 100%; width: 100%;">
                                        </a>
                                    @endif     
                            </div>
                        @endforeach
                    @endif
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
                        <input type="text" id="passport-number" value="{{old('m_passport_num') ? old('m_passport_num') : $parent->m_passport_num}}" class="inputFieldHeight form-control @error('m_passport_num') error @enderror" name="m_passport_num" placeholder="Passport Number" required>
                        @error('m_passport_num')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-3 col-12 commonSelect2Style">
                    <label for="passport-country2">Passport Issuing Country</label>
                    <select id="passport-country2" class="inputFieldHeight form-control common-select2 @error('m_passport_country') error @enderror" name="m_passport_country">
                        {{-- <option value="">Select Country</option> --}}
                        @foreach ($countries as $country)
                        <option value="{{$country->name}}" 
                            @if (old('m_passport_country')) {{old('m_passport_country') == $country->name ? 'selected':''}} 
                            @else {{$parent->m_passport_country == $country->name ? 'selected' : ''}} 
                            @endif> {{$country->name}}</option>
                        @endforeach
                    </select>
                    @error('m_passport_country')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label for="visa-number">Visa Number</label>
                        <input type="text" id="visa-number" value="{{old('m_visa_number') ? old('m_visa_number') : $parent->m_visa_number}}" class="inputFieldHeight form-control @error('m_visa_number') error @enderror" name="m_visa_number" placeholder="Visa Number" required>
                        @error('m_visa_number')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-3 col-12">
                    <div class="form-group">
                    <label for="visa-type">Visa Type</label>
                    <select id="visa-type" class="inputFieldHeight form-control @error('m_visa_type') error @enderror" name="m_visa_type">
                        <option value="Residence" {{old('m_visa_type') ?'selected' : ($parent->m_visa_type == 'Residence' ? 'selected' : '') }}> Residence</option>
                        <option value="NonResidence" {{old('m_visa_type') ?'selected' : ($parent->m_visa_type == 'NonResidence' ? 'selected' : '') }}> Non Residence</option>
                    </select>
                    @error('m_visa_type')
                    <span class="error">{{ $message }}</span>
                    @enderror
                    </div>
                </div>

                <div class="col-md-3 col-12 commonSelect2Style">
                    <label for="visa-issue-place2">Visa Issue Place</label>
                    <select id="visa-issue-place2" class="inputFieldHeight form-control common-select2 @error('m_visa_issue_place') error @enderror" name="m_visa_issue_place">
                        {{-- <option value="">Select Country</option> --}}
                        @foreach ($emirates as $emirate)
                        <option value="{{$emirate}}" 
                        @if (old('m_visa_issue_place')) {{old('m_visa_issue_place') == $emirate ? 'selected':''}} 
                        @else {{$parent->m_visa_issue_place == $emirate ? 'selected' : ''}} 
                        @endif> {{$emirate}}</option>
                        @endforeach
                    </select>
                    @error('m_visa_issue_place')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label for="visa-expire-date">Visa Expiry Date</label>
                        <input type="date" max="9999-12-31" id="visa-expire-date" value="{{old('m_visa_exp') ? old('m_visa_exp') : $parent->m_visa_exp}}" class="inputFieldHeight form-control @error('m_visa_exp') error @enderror" name="m_visa_exp" placeholder="dd/mm/yyyy" required>
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
                        <select id="Qualification" class="inputFieldHeight form-control @error('m_qualification') error @enderror" name="m_qualification">
                            <option value="Primary" {{old('m_qualification') ?'selected' : ($parent->m_qualification == 'Primary' ? 'selected' : '') }}> Primary</option>
                            <option value="Secondary" {{old('m_qualification') ?'selected' :( $parent->m_qualification == 'Secondary' ? 'selected' : '') }}> Secondary</option>
                            <option value="Higher Secondary" {{old('m_qualification') ?'selected' : ($parent->m_qualification == 'Higher Secondary' ? 'selected' : '') }}> Higher Secondary</option>
                            <option value="Graduate" {{old('m_qualification') ?'selected' : ($parent->m_qualification == 'Graduate' ? 'selected' : '') }}> Graduate</option>
                            <option value="Postgraduate" {{old('m_qualification') ?'selected' : ($parent->m_qualification == 'Postgraduate' ? 'selected' : '') }}> Postgraduate</option>
                        </select>
                        @error('m_qualification')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label for="year-of-passing">Year of passing</label>
                        <input type="number" id="m_year_of_passing" class="inputFieldHeight form-control @error('m_year_of_passing') error @enderror" name="m_year_of_passing" value="{{old('m_year_of_passing') ? old('m_year_of_passing') : $parent->m_year_of_passing}}" placeholder="Year of passing" required>

                        @error('m_year_of_passing')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label for="institution">Institution Name</label>
                        <input type="text" id="institution" value="{{old('m_institution') ? old('m_institution') :$parent->m_institution}} " class="inputFieldHeight form-control @error('m_institution') error @enderror" name="m_institution" placeholder="Institution Name" required>
                        @error('m_institution')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-3 col-12 commonSelect2Style">
                    <label for="qualification-country2">Country of education</label>
                    <select id="qualification-country2" class="inputFieldHeight form-control common-select2 @error('m_qualification_country') error @enderror" name="m_qualification_country">
                        {{-- <option value="">Select Country</option> --}}
                        @foreach ($countries as $country)
                        <option value="{{$country->name}}" 
                        @if (old('m_qualification_country')) {{old('m_qualification_country') == $country->name ? 'selected':''}} 
                        @else {{$parent->m_qualification_country == $country->name ? 'selected' : ''}} 
                        @endif> {{$country->name}}</option>
                        @endforeach
                    </select>
                    @error('m_qualification_country')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label for="occupation">Occupation</label>
                        <input type="text"  value="{{old('m_occupation') ? old('m_occupation') : $parent->m_occupation}}" class="inputFieldHeight form-control @error('m_occupation') error @enderror" name="m_occupation" required>
                        @error('m_occupation')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>                                            

                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label for="company-name">Company Name</label>
                        <input type="text" id="company-name" value="{{old('m_company_name') ? old('m_company_name') : $parent->m_company_name}}" class="inputFieldHeight form-control @error('m_company_name') error @enderror" name="m_company_name" placeholder="Company Name" required>
                        @error('m_company_name')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label for="Company Contact Details">Company Contact Details</label>
                        <input type="number" id="Company Contact Details" value="{{old('m_company_contact_details') ? old('m_company_contact_details') :$parent->m_company_contact_details}}" class="inputFieldHeight form-control @error('m_company_contact_details') error @enderror" name="m_company_contact_details" placeholder="Company Contact Details" required>
                        @error('m_company_contact_details')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label for="monthly-income">Monthly Income</label>
                        <input type="number" id="monthly-income" value="{{old('m_monthly_income') ? old('m_monthly_income') :$parent->m_monthly_income}}" class="inputFieldHeight form-control @error('m_monthly_income') error @enderror" name="m_monthly_income" placeholder="Monthly Income">
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
                        <textarea name="m_local_address"  id="local-address" class="form-control @error('m_local_address') error @enderror" cols="30" rows="3" required>
                        {{old('m_local_address') ? old('m_local_address') :$parent->m_local_address}}
                        </textarea>
                        @error('m_local_address')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6 col-12">
                    <div class="form-group">
                        <label for="permanent-address">Permanent Address</label>
                        <textarea id="permanent-address" class="form-control @error('m_permanent_address') error @enderror" name="m_permanent_address" cols="30" rows="3" required>
                            {{old('m_permanent_address') ? old('m_permanent_address') : $parent->m_permanent_address}}
                        </textarea>
                        @error('m_permanent_address')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4 col-12">
                    <div class="form-group">
                        <label for="local-telephone">Local telephone</label>
                        <input type="text" value="{{old('m_telephone') ? old('m_telephone') : $parent->m_telephone}}" id="local-telephone" class="inputFieldHeight form-control @error('m_telephone') error @enderror" name="m_telephone" placeholder="Local Telephone" required>
                        @error('m_telephone')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                

                <div class="col-md-4 col-12">
                    <div class="form-group">
                        <label for="permanent-telephone">Permanent telephone</label>
                        <input type="number" value="{{old('m_permanent_telephone') ? old('m_permanent_telephone') : $parent->m_permanent_telephone}}" id="permanent-telephone" class="inputFieldHeight form-control @error('m_permanent_telephone') error @enderror" name="m_permanent_telephone" placeholder="Company Contact Details" required>
                        @error('m_permanent_telephone')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4 col-12">
                    <div class="form-group">
                        <label for="Emirates">Emirates</label>
                        <select id="Emirates" class="inputFieldHeight form-control @error('m_emirate_name') error @enderror" name="m_emirate_name">
                            @foreach ($emirates as $emirate)
                            <option value="{{$emirate}}"
                            @if (old('m_emirate_name')) {{old('m_emirate_name') == $emirate ? 'selected':''}}
                            @else {{$parent->m_emirate_name == $emirate ? 'selected' : ''}} 
                            @endif> {{$emirate}}</option>
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