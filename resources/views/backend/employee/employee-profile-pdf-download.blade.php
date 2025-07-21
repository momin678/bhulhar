@extends('layouts.backend.app-pdf')
@section('content')
<style>
     table {
        /* border-collapse: collapse; */
        width: 100%;
    }

    td{
        font-size:14px;
    }
    th, td {
        text-align: left;
        width: 50%;
    }

</style>
<section id="widgets-Statistics">
    <div class="row invoice-info">
        <div class="col-xl-12 col-12">
            <div class="invoice-print-area p-2">
                <div class="mb-5 mx-25">
                    <div class="d-flex">
                        <!-- <div class="flex-grow-1 align-self-center">
                            <h3 class="text-white text-name" style="background: rgba(128, 128, 128, 0.644); padding: 5px !important;width:50%">Employee Profile:</h3>
                        </div>
                        <div class="flex-shrink-0"  style="text-align: right;">
                            <img src="{{ asset('storage/upload/employee-photo/'.$employee->photo)}}" alt="logo"
                            height="100" width="100">
                        </div> -->
                        <div class="col-sm-12 mt-1 d-flex justify-content-start">
                            <table>
                                <tr>
                                    <th><h3 class="text-white text-name" style="background: rgba(128, 128, 128, 0.644); padding: 5px !important;width:50%">Employee Profile:</h3></th>
                                    <th style="text-align:right;"><img src="{{ asset('storage/upload/employee-photo/'.$employee->photo)}}" alt="logo" height="100" width="100"></th>
                                </tr>
                            </table>
                            <table>
                                <tr>
                                    <th> <span style="border-bottom: 1px solid black;margin-right: 5px; padding-right: 210px;">Personal Details</span></th>
                                    <th style="border-bottom: 1px solid black;">Educational Data</th>
                                </tr>
                                <tr>
                                    <td>
                                        <span><strong>Name: </strong>{{$employee->fname}} {{$employee->mname}} {{$employee->family_name}}</span><br>
                                        <span><strong>Date Of Birth: </strong>{{$employee->dob}}</span><br>
                                        <span><strong>Nationality: </strong>{{$employee->nationality }}</span><br>
                                        <span><strong>Email Address: </strong>{{$employee->email }}</span><br>
                                        <span><strong>Emirates Number: </strong>{{$employee->emirates_id_num }}</span><br>
                                        <span><strong>Expiry: </strong>{{$employee->emirates_id_exp }}</span><br>
                                        <span><strong>Designation: </strong>{{$employee->employee_role }}</span>
                                    </td>
                                    <td>
                                        <span><strong>Qualification: </strong>{{$employee->qualification }}</span><br>
                                        <span><strong>Year of Passing: </strong>{{$employee->year_of_passing }}</span><br>
                                        <span><strong>Institution Name: </strong>{{$employee->institution }}</span><br>
                                        <span><strong>Qualification Country: </strong>{{$employee->qualification_country }}</span><br>
                                        <span><strong>First Language: </strong>{{$employee->first_lang }}</span><br>
                                        <span><strong>Second Language: </strong>{{$employee->second_lang }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th> <span style="border-bottom: 1px solid black; margin-right: 5px; padding-right: 210px;">Address</span></th>
                                    <th style="border-bottom: 1px solid black;">Passport & Visa</th>
                                </tr>
                                <tr>
                                    <td>
                                        <span><strong>Local Address: </strong>{{$employee->local_address}}</span><br>
                                        <span><strong>Permanent Address: </strong>{{ $employee->permanent_address}}</span><br>
                                        <span><strong>Local Number: </strong>{{ $employee->local_telephone}}</span><br>
                                        <span><strong>Permanent Numer: </strong>{{ $employee->permanent_telephone}}</span><br>
                                        <span><strong>Emerates: {{ $employee->emirate_name}}</span>
                                    </td>
                                    <td>
                                        <span><strong>Passport Number: </strong>{{ $employee->passport_num}}</span> <br>
                                        <span><strong>Country: </strong>{{ $employee->passport_country}}</span><br>
                                        <span><strong>Visa Number: </strong>{{ $employee->visa_number}}</span><br>
                                        <span><strong>Type: </strong>{{ $employee->visa_type}}</span><br>
                                        <span><strong>Issue Place: </strong>{{ $employee->visa_issue_place}}</span><br>
                                        <span><strong>Expire: </strong>{{ $employee->visa_exp}}</span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection