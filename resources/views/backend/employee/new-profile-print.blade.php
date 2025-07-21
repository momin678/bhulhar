@extends('layouts.backend.app-print')
@section('content')
   
<style>
    @media print{
        .printPage{
            margin-top: -700px;
        }
        html, body {
            height:100%; 
            overflow: hidden;
        }
    }
</style>
@php
    $emirates=array('Abu Dhabi','Ajman','Dubai','Fujairah','Ras Al Khaimah','Sharjah','Umm Al Quwain');
    $languages= array('Bangla','English','Urdu','Arabic','Hindi');
    $employee_roles= array('Principle','Teacher', 'Admin', 'Accounts Executive', 'Librarian','Driver','Clerk','Cleaner','Secretary','Accountant','Trainer');
@endphp
<section id="widgets-Statistics">
    <div class="row">
        <!-- invoice view page -->
        <div class="col-xl-12 col-12">
            <div class="invoice-print-area p-2">
                <div class="mb-5 mx-25">
                    <div class="d-flex">
                        <div class="flex-grow-1 align-self-center">
                            <h3>Employee Profile:</h3>
                        </div>
                        <div class="flex-shrink-0">
                            <img src="{{ asset('storage/upload/employee-photo/'.$employee->photo)}}" alt="logo"
                            height="100" width="100">
                        </div>
                        </div>
                    <div class="row invoice-info">
                        <div class="col-sm-6 col-12">
                            <h5 class="mt-1 invoice-from border-bottom">Personal Details</h5>
                            <div class="profile_print">
                                <span>Name: {{$employee->fname}} {{$employee->mname}} {{$employee->family_name}}</span>
                            </div>
                            <div class="profile_print">
                                <span>Date Of Birth: {{$employee->dob}}</span>
                            </div>
                            <div class="profile_print">
                                <span>Nationality: {{$employee->nationality }}</span>
                            </div>
                            <div class="profile_print">
                                <span>Email Address: {{$employee->email }}</span>
                            </div>
                            <div class="profile_print">
                                <span>Emirates Number: {{$employee->emirates_id_num }}</span>
                            </div>
                            <div class="profile_print">
                                <span>Expiry: {{$employee->emirates_id_exp }}</span>
                            </div>
                            <div class="profile_print">
                                <span>Designation: {{$employee->employee_role }}</span>
                            </div>
                            
                            <h5 class="mt-1 invoice-to border-bottom">Address</h5>
                            <div class="profile_print">
                                <span>Local Address: {{$employee->local_address}}</span>
                            </div>
                            <div class="profile_print">
                                <span>Permanent Address: {{ $employee->permanent_address}}</span>
                            </div>
                            <div class="profile_print">
                                <span>Local Number: {{ $employee->local_telephone}}</span>
                            </div>
                            <div class="profile_print">
                                <span>Permanent Numer: {{ $employee->permanent_telephone}}</span>
                            </div>
                            <div class="profile_print">
                                <span>Emerates: {{ $employee->emirate_name}}</span>
                            </div>
                        </div>
                        <div class="col-sm-6 col-12 mt-1">                                            
                            <h5 class="mt-1 border-bottom">Educational Data</h5>
                            <div class="profile_print">
                                <span>Qualification: {{$employee->qualification }}</span>
                            </div>
                            <div class="profile_print">
                                <span>Year of Passing: {{$employee->year_of_passing }}</span>
                            </div>
                            <div class="profile_print">
                                <span>Institution Name: {{$employee->institution }}</span>
                            </div>
                            <div class="profile_print">
                                <span>Qualification Country: {{$employee->qualification_country }}</span>
                            </div>
                            <div class="profile_print">
                                <span>First Language: {{$employee->first_lang }}</span> 
                            </div>
                            <div class="profile_print">
                                <span>Second Language: {{$employee->second_lang }}</span>
                            </div>

                            <h5 class="mt-1 invoice-to border-bottom">Passport & Visa</h5>
                            <div class="profile_print">
                                <span>Passport Number: {{ $employee->passport_num}}</span> 
                            </div>
                            <div class="profile_print">
                                <span>Country: {{ $employee->passport_country}}</span>
                            </div>
                            <div class="profile_print">
                                <span>Visa Number: {{ $employee->visa_number}}</span> 
                            </div>
                            <div class="profile_print">
                                <span>Type: {{ $employee->visa_type}}</span>
                            </div>
                            <div class="profile_print">
                                <span>Issue Place: {{ $employee->visa_issue_place}}</span>
                            </div>
                            <div class="profile_print">
                                <span>Expire: {{ $employee->visa_exp}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection