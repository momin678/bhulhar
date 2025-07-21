
@extends('layouts.backend.app-pdf')
@section('content')
<style>
    table {
       /* border-collapse: collapse; */
       width: 100%;
   }

   td{
       font-size:12px;
   }

</style>
<section id="basic-vertical-layouts" class="mt-4">
    <div class="row match-height">
        <div class="col-md-12 col-12">
            <div class="cardStyleChange">
                <div class="row mb-2">
                    <table>
                        <tr>
                            <td>
                                <h4 class="border-bottom" style="border-bottom: 1px solid black;">Father's Information: Personal Details</h4>
                                <div class="col-md-6">
                                    <div> <span><b>Father's Name:</b> {{ $parent->f_fname.' '.$parent->f_mname.' '.$parent->f_family_name}}</span></div>
                                    <div> <span><b>Date of Birth: </b>{{ $parent->f_dob}}</span> </div>
                                    <div> <span><b>Nationality: </b> {{$parent->f_nationality}}</span> </div>
                                    <div> <span><b>Emirates ID Number: </b> {{ $parent->f_emirates_id_num}}</span> </div>
                                    <div> <span><b>Emirates ID Expiry Date: </b>{{ $parent->f_emirates_id_exp}}</span> </div>
                                    <div> <span><b>First Language: </b>{{ $parent->f_first_lang}}</span> </div>
                                    <div> <span><b>Second Language: </b>{{ $parent->f_second_lang}}</span> </div>
                                    <div> <span><b>Prefered Mode Of Communication: </b>{{ $parent->f_mode_of_communication}}</span> </div>
                                </div>

                            </td>
                            <td>
                                <h4 class="border-bottom" style="border-bottom: 1px solid black;">Passport & Visa Information</h4>
                                <div class="col-md-6">
                                    <div> <span><b>Passport Number: </b>{{ $parent->f_passport_num}}</span></div>
                                    <div> <span><b>Passport Issuing Country: </b>{{ $parent->f_passport_country}}</span></div>
                                    <div> <span><b>Visa Number: </b>{{ $parent->f_visa_number}}</span></div>
                                    <div> <span><b>Visa Type: </b>{{ $parent->f_visa_type}}</span></div>
                                    <div> <span><b>Visa Issue Place: </b>{{ $parent->f_visa_issue_place}}</span></div>
                                    <div> <span><b>Visa Expire Date: </b>{{ $parent->f_visa_exp}}</span></div>
                                    <div> <span><b>Visa Type: </b>{{ $parent->f_visa_type}}</span></div>
                                </div>

                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h4 class="border-bottom" style="border-bottom: 1px solid black;">Education & Profession</h4>
                                <div class="col-md-6">
                                    <div><span><b>Qualification: </b></span>{{ $parent->f_qualification}}</div>
                                    <div><span><b>Year of passing: </b></span>{{ $parent->f_year_of_passing}}</div>
                                    <div><span><b>Institution Name: </b></span>{{ $parent->f_institution}}</div>
                                    <div><span><b>Country of education: </b></span>{{ $parent->f_qualification_country}}</div>
                                    <div><span><b>Occupation: </b></span>{{ $parent->f_occupation}}</div>
                                    <div><span><b>Company Name: </b></span>{{ $parent->f_company_name}}</div>
                                    <div><span><b>Company Contact Details: </b></span>{{ $parent->f_company_contact_details}}</div>
                                    <div><span><b>Monthly Income: </b></span>{{ $parent->f_monthly_income}}</div>
                                </div>

                            </td>
                            <td>
                                <h4 class="border-bottom" style="border-bottom: 1px solid black;">Address Details</h4>
                                <div class="col-md-6">
                                    <div><span><b>Local Address: </b></span>{{ $parent->f_local_address}}</div>
                                    <div><span><b>Permanent Address: </b></span>{{ $parent->f_permanent_address}}</div>
                                    <div><span><b>Local telephone: </b></span>{{ $parent->f_telephone}}</div>
                                    <div><span><b>Permanent telephone: </b></span>{{ $parent->f_permanent_telephone}}</div>
                                    <div><span><b>Emirates: </b></span>{{ $parent->f_emirate_name}}</div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h4 class="border-bottom" style="border-bottom: 1px solid black;">Mother's Information: Personal Details</h4>
                                <div class="col-md-6">
                                    <div> <span><b>Mother's Name:</b> {{ $parent->m_fname.' '.$parent->m_mname.' '.$parent->m_family_name}}</span></div>
                                    <div> <span><b>Date of Birth: </b>{{ $parent->m_dob}}</span> </div>
                                    <div> <span><b>Nationality: </b> {{$parent->m_nationality}}</span> </div>
                                    <div> <span><b>Emirates ID Number: </b> {{ $parent->m_emirates_id_num}}</span> </div>
                                    <div> <span><b>Emirates ID Expiry Date: </b>{{ $parent->m_emirates_id_exp}}</span> </div>
                                    <div> <span><b>First Language: </b>{{ $parent->m_first_lang}}</span> </div>
                                    <div> <span><b>Second Language: </b>{{ $parent->m_second_lang}}</span> </div>
                                    <div> <span><b>Prefered Mode Of Communication: </b>{{ $parent->m_mode_of_communication}}</span> </div>
                                </div>
                            </td>
                            <td>
                                <h4 class="border-bottom" style="border-bottom: 1px solid black;">Passport & Visa Information</h4>
                                <div class="col-md-6">
                                    <div> <span><b>Passport Number: </b>{{ $parent->m_passport_num}}</span></div>
                                    <div> <span><b>Passport Issuing Country: </b>{{ $parent->m_passport_country}}</span></div>
                                    <div> <span><b>Visa Number: </b>{{ $parent->m_visa_number}}</span></div>
                                    <div> <span><b>Visa Type: </b>{{ $parent->m_visa_type}}</span></div>
                                    <div> <span><b>Visa Issue Place: </b>{{ $parent->m_visa_issue_place}}</span></div>
                                    <div> <span><b>Visa Expire Date: </b>{{ $parent->m_visa_exp}}</span></div>
                                    <div> <span><b>Visa Type: </b>{{ $parent->m_visa_type}}</span></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h4 class="border-bottom" style="border-bottom: 1px solid black;">Education & Profession</h4>
                                <div class="col-md-6">
                                    <div><span><b>Qualification: </b></span>{{ $parent->m_qualification}}</div>
                                    <div><span><b>Year of passing: </b></span>{{ $parent->m_year_om_passing}}</div>
                                    <div><span><b>Institution Name: </b></span>{{ $parent->m_institution}}</div>
                                    <div><span><b>Country of education: </b></span>{{ $parent->m_qualification_country}}</div>
                                    <div><span><b>Occupation: </b></span>{{ $parent->m_occupation}}</div>
                                    <div><span><b>Company Name: </b></span>{{ $parent->m_company_name}}</div>
                                    <div><span><b>Company Contact Details: </b></span>{{ $parent->m_company_contact_details}}</div>
                                    <div><span><b>Monthly Income: </b></span>{{ $parent->m_monthly_income}}</div>
                                </div>
                            </td>
                            <td>
                                <h4 class="border-bottom" style="border-bottom: 1px solid black;">Address Details</h4>
                                <div class="col-md-6">
                                    <div><span><b>Local Address: </b></span>{{ $parent->m_local_address}}</div>
                                    <div><span><b>Permanent Address: </b></span>{{ $parent->m_permanent_address}}</div>
                                    <div><span><b>Local telephone: </b></span>{{ $parent->m_telephone}}</div>
                                    <div><span><b>Permanent telephone: </b></span>{{ $parent->m_permanent_telephone}}</div>
                                    <div><span><b>Emirates: </b></span>{{ $parent->m_emirate_name}}</div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
