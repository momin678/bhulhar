
@php
    $emirates=array('Abu Dhabi','Ajman','Dubai','Fujairah','Ras Al Khaimah','Sharjah','Umm Al Quwain');
@endphp
<section class="print-hideen border-bottom">
    <div class="d-flex flex-row-reverse">
        <div class="mIconStyleChange"><a href="#" class="close btn-icon btn btn-danger" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class='bx bx-x'></i></span></a></div>
        <div class="mIconStyleChange"><a href="#" class="btn btn-icon btn-success parentProfileEdit" id="{{$parent->id}}" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class='bx bx-edit'></i></span></a></div>
        <div class="mIconStyleChange"><a href="#" class="btn btn-icon btn-secondary parentProfilePrint" id="{{$parent->id}}" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class='bx bx-printer'></i></span></a></div>
        <div class="mIconStyleChange"><a href="{{route('parent-profile-pdf-download', $parent->id)}}" class="btn btn-icon btn-primary"><i class='bx bxs-file-pdf'></i></a></div>
        {{-- <div class="mIconStyleChange"><a href="#"  onclick="window.print();" class="btn btn-icon btn-light"><i class='bx bxs-virus'></i></a></div> --}}
      </div>
</section>
@include('backend.tab-file.modal-header-info')
<form action="" class="form form-vertical m-1">
    <section id="basic-vertical-layouts">
        <h5 class="p-1 bg-light">Father's Information: Personal Details</h5>
        <div class="row">
            <div class="col-sm-12 col-12">
                <h6 style="">Father's Name</h6>
            </div>
            <div class="col-md-4 col-12">
                <div class="form-group">
                    <input type="text" id="first-name-vertical" value="{{ $parent->f_fname}}" readonly class="inputFieldHeight form-control @error('f_fname') error @enderror" name="f_fname" placeholder="First Name">
                </div>
            </div>
            <div class="col-md-4 col-12">
                <div class="form-group">
                    <input type="text" id="email-id-vertical" value="{{ $parent->f_mname}}" readonly class="inputFieldHeight form-control @error('f_mname') error @enderror" name="f_mname" placeholder="Middle Name">
                </div>
            </div>
            <div class="col-md-4 col-12">
                <div class="form-group">
                    {{-- <label>Family Name</label> --}}
                    <input type="text" id="contact-info-vertical" value="{{ $parent->f_family_name}}" readonly class="inputFieldHeight form-control @error('f_family_name') error @enderror" name="f_family_name" placeholder="Family Name">
                </div>
            </div>

            <div class="col-md-3 col-12">
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="text" id="contact-info-vertical" value="{{ $parent->f_email_address}}" readonly class="inputFieldHeight form-control @error('f_family_name') error @enderror" name="f_family_name" placeholder="Family Name">
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                <label>Date of Birth</label>
                <input type="date" name="f_dob" value="{{ $parent->f_dob}}" readonly class="inputFieldHeight form-control @error('f_dob') error @enderror" placeholder="dd-mm-yyy">
                </div>
            </div>

            <div class="col-sm-3">
                <div class="form-group">
                <label>Nationality</label>
                <input type="text" name="f_nationality" value="{{ $parent->f_nationality}}" readonly class="inputFieldHeight form-control @error('f_nationality') error @enderror" placeholder="dd-mm-yyy">
                </div>
            </div>

            <div class="col-sm-3">
                <div class="form-group">
                <label>Emirates ID Number</label>
                <input type="text" name="f_emirates_id_num" value="{{ $parent->f_emirates_id_num}}" readonly class="inputFieldHeight form-control @error('f_emirates_id_num') error @enderror" placeholder="000-0000-0000000-0"> 
                </div>
            </div>

            <div class="col-sm-3">
                <div class="form-group">
                <label>Emirates ID Expiry Date</label>
                <input type="date" name="f_emirates_id_exp" value="{{ $parent->f_emirates_id_exp}}" readonly class="inputFieldHeight form-control @error('f_emirates_id_exp') error @enderror" placeholder="dd/mm/yyyy">
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label>First Language</label>
                    <input type="text" name="f_first_lang" value="{{ $parent->f_first_lang}}" readonly class="inputFieldHeight form-control @error('f_first_lang') error @enderror"> 
                </div>
            </div>

            <div class="col-sm-3">
                <div class="form-group">
                    <label>Second Language</label>
                    <input type="text" name="f_second_lang" value="{{ $parent->f_second_lang}}" readonly class="inputFieldHeight form-control @error('f_second_lang') error @enderror"> 
                </div>
            </div> 
            
            <div class="col-sm-3">
                <div class="form-group">
                    <label class="d-block">Prefered Mode Of Communication</label>
                    <div class="custom-control custom-radio my-50">
                        <input type="radio" id="f-com-phone" name="f_mode_of_communication" class="custom-control-input" value="phone"
                        {{$parent->f_mode_of_communication == 'phone' ? 'checked' : ''}}>
                        <label class="custom-control-label" for="f-com-phone">Phone</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="f-com-email" name="f_mode_of_communication" class="custom-control-input" value="email"
                        {{$parent->f_mode_of_communication == 'email' ? 'checked' : ''}}>
                        <label class="custom-control-label" for="f-com-email">Email</label>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <div><label>Emirates ID</label></div>
                    <div class="profile-img">
                        <img src="{{ asset('storage/upload/emirate_id/'.$parent->f_emirates_id_upload)}}" alt="" width="70" height="70" id="edit_fatherEmirateImgPreview">
                    </div>
                </div>
            </div>
            <div class="col-sm-9">
                <label>Others Document</label>
                    <div class="row">
                        @foreach($fathers as $others)
                            <div class="col-md-2">
                                    @if ($others->extension == 'pdf')
                                        <a href="{{ asset('storage/upload/student-parent/'.$others->filename)}}"  target="_blank">
                                            
                                            <img src="{{ asset('assets/backend/app-assets/icon/pdf-download-icon-2.png')}}" style="height:70px" class="w-100"  alt="" title="{{$others->name}}">
                                        </a>
                                    @else
                                        <a href="{{ asset('storage/upload/student-parent/'.$others->filename)}}" target="_blank">
                                            <img src="{{ asset('storage/upload/student-parent/'.$others->filename)}}" style="height:70px" class="w-100"  title="{{$others->name}}" alt="" >
                                        </a>
                                    @endif     
                            </div>
                        @endforeach
                    </div>
            </div>
        </div>
    </section>
    <section id="basic-vertical-layouts">
        <h5 class="p-1 bg-light">Passport & Visa Information</h5>
        <div class="row">
            <div class="col-md-3 col-12">
                <div class="form-group">
                    <label for="passport-number">Passport Number</label>
                    <input type="text" id="passport-number" value="{{ $parent->f_passport_num}}" readonly class="inputFieldHeight form-control @error('f_passport_num') error @enderror" name="f_passport_num" placeholder="Passport Number">
                </div>
            </div>

            <div class="col-md-3 col-12">
                <div class="form-group">
                    <label for="passport-country">Passport Issuing Country</label>
                    <input type="text" id="passport-number" value="{{ $parent->f_passport_country}}" readonly class="inputFieldHeight form-control @error('f_passport_country') error @enderror" name="f_passport_country" placeholder="Passport Number">
                </div>
            </div>

            <div class="col-md-3 col-12">
                <div class="form-group">
                    <label for="visa-number">Visa Number</label>
                    <input type="text" id="visa-number" value="{{ $parent->f_visa_number}}" readonly class="inputFieldHeight form-control @error('f_visa_number') error @enderror" name="f_visa_number" placeholder="Visa Number">
                </div>
            </div>

            <div class="col-md-3 col-12">
                <div class="form-group">
                <label for="visa-type">Visa Type</label>
                <input type="text" id="visa-number" value="{{ $parent->f_visa_type}}" readonly class="inputFieldHeight form-control @error('f_visa_type') error @enderror" name="f_visa_type" placeholder="Visa Number">
                </div>
            </div>

            <div class="col-md-3 col-12">
                <div class="form-group">
                    <label for="visa-issue-place">VISA ISSUE PLACE</label>
                    <input type="text" id="visa-number" value="{{ $parent->f_visa_issue_place}}" readonly class="inputFieldHeight form-control @error('f_visa_issue_place') error @enderror" name="f_visa_issue_place" placeholder="Visa Number">
                </div>
            </div>

            <div class="col-md-3 col-12">
                <div class="form-group">
                    <label for="visa-expire-date">Visa Expire Date</label>
                    <input type="date" id="visa-expire-date" value="{{ $parent->f_visa_exp}}" readonly class="inputFieldHeight form-control @error('f_visa_exp') error @enderror" name="f_visa_exp" placeholder="dd/mm/yyyy">
                </div>
            </div>

        </div>
    </section>
    <section id="basic-vertical-layouts">
        <h5 class="p-1 bg-light">Education & Profession</h5>
        <div class="row">
            
            <div class="col-md-3 col-12">
                <div class="form-group">
                    <label for="Qualification">Qualification</label>
                    <input type="text" class="inputFieldHeight form-control" value="{{ $parent->f_qualification}}" readonly>
                </div>
            </div>

            <div class="col-md-3 col-12">
                <div class="form-group">
                    <label for="year-of-passing">Year of passing</label>
                    <input type="text" class="inputFieldHeight form-control" value="{{ $parent->f_year_of_passing}}" readonly>
                </div>
            </div>

            <div class="col-md-3 col-12">
                <div class="form-group">
                    <label for="institution">Institution Name</label>
                    <input type="text" id="institution" value="{{$parent->f_institution}} " readonly class="inputFieldHeight form-control @error('f_institution') error @enderror" name="f_institution" placeholder="Institution Name">
                </div>
            </div>
            
            <div class="col-md-3 col-12">
                <div class="form-group">
                    <label for="qualification-country">Country of education</label>
                    <input type="text" class="inputFieldHeight form-control" value="{{ $parent->f_qualification_country}}" readonly>
                </div>
            </div>

            <div class="col-md-3 col-12">
                <div class="form-group">
                    <label for="occupation">Occupation</label>
                    <input type="text" class="inputFieldHeight form-control" value="{{ $parent->f_occupation}}" readonly>
                </div>
            </div>                                            

            <div class="col-md-3 col-12">
                <div class="form-group">
                    <label for="company-name">Company Name</label>
                    <input type="text" id="company-name" value="{{$parent->f_company_name}}" readonly class="inputFieldHeight form-control @error('f_company_name') error @enderror" name="f_company_name" placeholder="Company Name">
                </div>
            </div>

            <div class="col-md-3 col-12">
                <div class="form-group">
                    <label for="Company Contact Details">Company Contact Details</label>
                    <input type="number" id="Company Contact Details" value="{{$parent->f_company_contact_details}}" readonly class="inputFieldHeight form-control @error('f_company_contact_details') error @enderror" name="f_company_contact_details" placeholder="Company Contact Details">
                </div>
            </div>

            <div class="col-md-3 col-12">
                <div class="form-group">
                    <label for="monthly-income">Monthly Income</label>
                    <input type="number" id="monthly-income" value="{{$parent->f_monthly_income}}" readonly class="inputFieldHeight form-control @error('f_monthly_income') error @enderror" name="f_monthly_income" placeholder="Monthly Income">
                </div>
            </div>

        </div>
    </section>
    <section id="basic-vertical-layouts">
        <h5 class="p-1 bg-light">Address Details</h5>
        <div class="row">
            <div class="col-md-6 col-12">
                <div class="form-group">
                    <label for="local-address">Local Address</label>
                    <textarea name="f_local_address"  id="local-address" readonly class="form-control @error('f_local_address') error @enderror" cols="30" rows="3">
                    {{$parent->f_local_address}}
                    </textarea>
                </div>
            </div>

            <div class="col-md-6 col-12">
                <div class="form-group">
                    <label for="permanent-address">Permanent Address</label>
                    <textarea  id="permanent-address" readonly class="form-control @error('f_permanent_address') error @enderror" name="f_permanent_address" cols="30" rows="3">
                        {{ $parent->f_permanent_address}}
                    </textarea>
                </div>
            </div>
            
            <div class="col-md-4 col-12">
                <div class="form-group">
                    <label for="local-telephone">Local telephone</label>
                    <input type="text" value="{{ $parent->f_telephone}}" id="local-telephone" readonly class="inputFieldHeight form-control @error('f_telephone') error @enderror" name="f_telephone" placeholder="Local Telephone">
                </div>
            </div>

            <div class="col-md-4 col-12">
                <div class="form-group">
                    <label for="permanent-telephone">Permanent telephone</label>
                    <input type="number" value="{{ $parent->f_permanent_telephone}}" id="permanent-telephone" readonly class="inputFieldHeight form-control @error('f_permanent_telephone') error @enderror" name="f_permanent_telephone" placeholder="Company Contact Details">
                </div>
            </div>

            <div class="col-md-4 col-12">
                <div class="form-group">
                    <label for="Emirates">Emirates</label>
                    <input type="text" class="inputFieldHeight form-control" value="{{ $parent->f_emirate_name}}" readonly>
                </div>
            </div>

        </div>
    </section>
    <section id="basic-vertical-layouts">
        <h5 class="p-1 bg-light">Mother's Information: Personal Details</h5>
        <div class="row">
            <div class="col-sm-12 col-12">
                <label>Mother's Name</label>
            </div>
            <div class="col-md-4 col-12">
                <div class="form-group">
                    <input type="text" id="first-name-vertical" value="{{ $parent->m_fname}}" readonly class="inputFieldHeight form-control @error('m_fname') error @enderror" name="m_fname" placeholder="First Name">
                </div>
            </div>
            <div class="col-md-4 col-12">
                <div class="form-group">
                    <input type="text" id="email-id-vertical" value="{{ $parent->m_mname}}" readonly class="inputFieldHeight form-control @error('m_mname') error @enderror" name="m_mname" placeholder="Middle Name">
                </div>
            </div>
            <div class="col-md-4 col-12">
                <div class="form-group">
                    <input type="text" id="contact-info-vertical" value="{{ $parent->m_family_name}}" readonly class="inputFieldHeight form-control @error('m_family_name') error @enderror" name="m_family_name" placeholder="Family Name">
                </div>
            </div>


            <div class="col-md-3 col-12">
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" id="contact-info-vertical" value="{{$parent->m_email_address}}" class="inputFieldHeight form-control @error('f_email_address') error @enderror" name="m_email_address" placeholder="Email Address" readonly>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                <label>Date of Birth</label>
                <input type="date" name="m_dob" value="{{ $parent->m_dob}}" readonly class="inputFieldHeight form-control @error('m_dob') error @enderror" placeholder="dd-mm-yyy">
                </div>
            </div>

            <div class="col-sm-3">
                <div class="form-group">
                <label>Nationality</label>
                <input type="text" id="first-name-vertical" value="{{ $parent->m_nationality}}" readonly class="inputFieldHeight form-control @error('m_nationality') error @enderror" name="m_nationality" placeholder="First Name">
                </div>
            </div>

            <div class="col-sm-3">
                <div class="form-group">
                <label>Emirates ID Number</label>
                <input type="text" name="m_emirates_id_num" value="{{ $parent->m_emirates_id_num}}" readonly class="inputFieldHeight form-control @error('m_emirates_id_num') error @enderror" placeholder="000-0000-0000000-0"> 
                </div>
            </div>

            <div class="col-sm-3">
                <div class="form-group">
                <label>Emirates ID Expiry Date</label>
                <input type="date" name="m_emirates_id_exp" value="{{ $parent->m_emirates_id_exp}}" readonly class="inputFieldHeight form-control @error('m_emirates_id_exp') error @enderror" placeholder="dd/mm/yyyy">
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label>First Language</label>
                    <input type="text" name="m_emirates_id_exp" value="{{ $parent->m_first_lang}}" readonly class="inputFieldHeight form-control @error('m_emirates_id_exp') error @enderror" placeholder="dd/mm/yyyy">
                </div>
            </div>

            <div class="col-sm-3">
                <div class="form-group">
                    <label>Second Language</label>
                    <input type="text" name="m_second_lang" value="{{ $parent->m_second_lang}}" readonly class="inputFieldHeight form-control @error('m_second_lang') error @enderror" placeholder="dd/mm/yyyy">
                </div>
            </div> 
            
            <div class="col-sm-3">
                <div class="form-group">
                    <label class="d-block">Prefered Mode Of Communication</label>
                    <div class="custom-control custom-radio my-50">
                        <input type="radio" {{$parent->m_mode_of_communication == 'phone' ? 'checked' : ''}} id="m-communication-phone" name="m_mode_of_communication" class="custom-control-input" value="phone">
                        <label class="custom-control-label" for="m-communication-phone">Phone</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" {{$parent->m_mode_of_communication == 'phone' ? 'checked' : ''}} id="m-com-email" name="m_mode_of_communication" class="custom-control-input" value="email">
                        <label class="custom-control-label" for="m-com-email">Email</label>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <div><label>Emirates ID</label></div>
                    <div class="profile-img">
                        <img src="{{ asset('storage/upload/emirate_id/'.$parent->m_emirates_id_upload)}}" alt="" width="70" height="70" id="edit_fatherEmirateImgPreview">
                    </div>
                </div>
            </div>
            <div class="col-sm-9">
                <label>Others Document</label>
                    <div class="row">
                        @foreach($mothers as $others)
                            <div class="col-md-2">
                                    @if ($others->extension == 'pdf')
                                        <a href="{{ asset('storage/upload/student-parent/'.$others->filename)}}"  target="_blank">
                                            
                                            <img src="{{ asset('assets/backend/app-assets/icon/pdf-download-icon-2.png')}}" style="height:70px" class="w-100"  alt="" title="{{$others->name}}">
                                        </a>
                                    @else
                                        <a href="{{ asset('storage/upload/student-parent/'.$others->filename)}}" target="_blank">
                                            <img src="{{ asset('storage/upload/student-parent/'.$others->filename)}}" style="height:70px" class="w-100"  title="{{$others->name}}" alt="" >
                                        </a>
                                    @endif     
                            </div>
                        @endforeach
                    </div>
            </div>
        </div>
    </section>
    <section id="basic-vertical-layouts">
        <h5 class="p-1 bg-light">Passport & Visa Information</h5>
        <div class="row">
            
            <div class="col-md-3 col-12">
                <div class="form-group">
                    <label for="passport-number">Passport Number</label>
                    <input type="text" id="passport-number" value="{{ $parent->m_passport_num}}" readonly class="inputFieldHeight form-control @error('m_passport_num') error @enderror" name="m_passport_num" placeholder="Passport Number">
                </div>
            </div>

            <div class="col-md-3 col-12">
                <div class="form-group">
                    <label for="passport-country">Passport Issuing Country</label>
                    <input type="text" id="passport-number" value="{{ $parent->m_passport_country}}" readonly class="inputFieldHeight form-control @error('m_passport_country') error @enderror" name="m_passport_country" placeholder="Passport Number">
                </div>
            </div>

            <div class="col-md-3 col-12">
                <div class="form-group">
                    <label for="visa-number">Visa Number</label>
                    <input type="text" id="visa-number" value="{{ $parent->m_visa_number}}" readonly class="inputFieldHeight form-control @error('m_visa_number') error @enderror" name="m_visa_number" placeholder="Visa Number">
                </div>
            </div>

            <div class="col-md-3 col-12">
                <div class="form-group">
                <label for="visa-type">Visa Type</label>
                <input type="text" id="visa-number" value="{{ $parent->m_visa_type}}" readonly class="inputFieldHeight form-control @error('m_visa_type') error @enderror" name="m_visa_type" placeholder="Visa Number">
                </div>
            </div>

            <div class="col-md-3 col-12">
                <div class="form-group">
                    <label for="visa-issue-place">VISA ISSUE PLACE</label>
                    <input type="text" id="visa-number" value="{{ $parent->m_visa_issue_place}}" readonly class="inputFieldHeight form-control @error('m_visa_issue_place') error @enderror" name="m_visa_issue_place" placeholder="Visa Number">
                </div>
            </div>

            <div class="col-md-3 col-12">
                <div class="form-group">
                    <label for="visa-expire-date">Visa Expire Date</label>
                    <input type="date" id="visa-expire-date" value="{{ $parent->m_visa_exp}}" readonly class="inputFieldHeight form-control @error('m_visa_exp') error @enderror" name="m_visa_exp" placeholder="dd/mm/yyyy">
                </div>
            </div>

        </div>
    </section>
    <section id="basic-vertical-layouts">
        <h5 class="p-1 bg-light">Education & Profession</h5>
        <div class="row">
            
            <div class="col-md-3 col-12">
                <div class="form-group">
                    <label for="Qualification">Qualification</label>
                    <input type="text" class="inputFieldHeight form-control" value="{{ $parent->m_qualification}}" readonly>
                </div>
            </div>

            <div class="col-md-3 col-12">
                <div class="form-group">
                    <label for="year-of-passing">Year of passing</label>
                    <input type="text" class="inputFieldHeight form-control" value="{{ $parent->m_year_of_passing}}" readonly>
                </div>
            </div>

            <div class="col-md-3 col-12">
                <div class="form-group">
                    <label for="institution">Institution Name</label>
                    <input type="text" id="institution" value="{{$parent->m_institution}} " readonly class="inputFieldHeight form-control @error('m_institution') error @enderror" name="m_institution" placeholder="Institution Name">
                </div>
            </div>
            
            <div class="col-md-3 col-12">
                <div class="form-group">
                    <label for="qualification-country">Country of education</label>
                    <input type="text" class="inputFieldHeight form-control" value="{{ $parent->m_qualification_country}}" readonly>
                </div>
            </div>

            <div class="col-md-3 col-12">
                <div class="form-group">
                    <label for="occupation">Occupation</label>
                    <input type="text" class="inputFieldHeight form-control" value="{{ $parent->m_occupation}}" readonly>
                </div>
            </div>                                            

            <div class="col-md-3 col-12">
                <div class="form-group">
                    <label for="company-name">Company Name</label>
                    <input type="text" id="company-name" value="{{$parent->m_company_name}}" readonly class="inputFieldHeight form-control @error('m_company_name') error @enderror" name="m_company_name" placeholder="Company Name">
                </div>
            </div>

            <div class="col-md-3 col-12">
                <div class="form-group">
                    <label for="Company Contact Details">Company Contact Details</label>
                    <input type="number" id="Company Contact Details" value="{{$parent->m_company_contact_details}}" readonly class="inputFieldHeight form-control @error('m_company_contact_details') error @enderror" name="m_company_contact_details" placeholder="Company Contact Details">
                </div>
            </div>

            <div class="col-md-3 col-12">
                <div class="form-group">
                    <label for="monthly-income">Monthly Income</label>
                    <input type="number" id="monthly-income" value="{{$parent->m_monthly_income}}" readonly class="inputFieldHeight form-control @error('m_monthly_income') error @enderror" name="m_monthly_income" placeholder="Monthly Income">
                </div>
            </div>

        </div>
    </section>
    <section id="basic-vertical-layouts">
        <h5 class="p-1 bg-light">Address Details</h5>
        <div class="row">
            
            <div class="col-md-6 col-12">
                <div class="form-group">
                    <label for="local-address">Local Address</label>
                    <textarea name="m_local_address"  id="local-address" readonly class="form-control @error('m_local_address') error @enderror" cols="30" rows="3">
                    {{$parent->m_local_address}}
                    </textarea>
                </div>
            </div>

            <div class="col-md-6 col-12">
                <div class="form-group">
                    <label for="permanent-address">Permanent Address</label>
                    <textarea id="permanent-address" readonly class="form-control @error('m_permanent_address') error @enderror" name="m_permanent_address" cols="30" rows="3">
                        {{ $parent->m_permanent_address}}
                    </textarea>
                </div>
            </div>

            <div class="col-md-4 col-12">
                <div class="form-group">
                    <label for="local-telephone">Local telephone</label>
                    <input type="text" value="{{ $parent->m_telephone}}" id="local-telephone" readonly class="inputFieldHeight form-control @error('m_telephone') error @enderror" name="m_telephone" placeholder="Local Telephone">
                </div>
            </div>
            

            <div class="col-md-4 col-12">
                <div class="form-group">
                    <label for="permanent-telephone">Permanent telephone</label>
                    <input type="number" value="{{ $parent->m_permanent_telephone}}" id="permanent-telephone" readonly class="inputFieldHeight form-control @error('m_permanent_telephone') error @enderror" name="m_permanent_telephone" placeholder="Company Contact Details">
                </div>
            </div>

            <div class="col-md-4 col-12">
                <div class="form-group">
                    <label for="Emirates">Emirates</label>
                    <input type="number" value="{{ $parent->m_emirate_name}}" id="permanent-telephone" readonly class="inputFieldHeight form-control @error('m_emirate_name') error @enderror" name="m_emirate_name" placeholder="Company Contact Details">
                </div>
            </div>
        </div>
    </section>
</form>
@include('backend.tab-file.modal-footer-info')