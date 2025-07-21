@extends('layouts.backend.app-print')
@section('content')
<style>
    .mIconSryleChange{
        padding: 10px 5px !important;
    }
    @media print {
        .printPage{
            margin-top: -700px;
        }
        html, body {
            height:100%; 
            overflow: hidden;
        }
    }
</style>
<div class="content-body">
    <section class="invoice-view-wrapper">
        <div class="row">
            <div class="col-xl-12 col-md-12 col-12">
                <div class="cardStyleChange">
                    <div class="card-body">
                        <div class="text-white text-center">
                            <h5 class="bg-light ">Employee Early Leave</h5>
                        </div>
                        <hr>
                        <div class="row invoice-info">
                            <div class="table-responsive pl-1">
                                <table class="table table-borderless table-sm">
                                    <tbody>
                                        <tr>
                                            <td>Staff ID: </td>
                                            <td>{{$leave->employee->id}}</td>
                                        </tr>
                                        <tr>
                                            <td>Name:</td>
                                            <td>{{$leave->employee->fname}} {{$leave->employee->mname}}</td>
                                        </tr>
                                        <tr>
                                            <td>Depertment:</td>
                                            <td>Academic</td>
                                        </tr>
                                        <tr>
                                            <td>Designation:</td>
                                            <td>Teacher</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="table-responsive ml-2 mr-2">
                        <table class="table table-borderless table-sm mb-0">
                            <tbody>
                                <tr>
                                    <td>From Time</td>
                                    <td>To Time</td>
                                    <td>Time</td>
                                    <td>Reason</td>
                                </tr>
                                <tr>
                                    <td>{{date('h:i A', strtotime($leave->from_time))}}</td>
                                    <td>{{date('h:i A', strtotime($leave->to_time))}}</td>
                                    <td>{{$leave->days_leave}}</td>
                                    <td>{{$leave->leave_reason}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-body pt-0 mx-25">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-12 d-flex justify-content-between mt-75">
                                <div class="invoice-subtotal">
                                    <div class="invoice-calc d-flex justify-content-between mt-4">
                                        <span class="invoice-title border-top mr-2">Signature (Employee)</span>
                                    </div>
                                </div>
                                <div class="invoice-subtotal">
                                    <div class="invoice-calc d-flex justify-content-between mt-4">
                                        <span class="invoice-title border-top mr-2">Signature (School)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection