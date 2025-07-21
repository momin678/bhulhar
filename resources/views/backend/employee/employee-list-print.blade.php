@extends('layouts.backend.app')

@section('content')
@include('backend.tab-file.style')
<style>
    .print-hidden-show{
            display: none;
        }
        @media print{
            .print-hidden-show{
                display: block;
            }
            .print:last-child {
                page-break-after: auto;
            }
            html, body {
                height: 99%;    
            }
        }
        .print:last-child {
            page-break-after: auto;
        }
</style>
@php
    $employee_roles= array('Principle','Teacher', 'Admin', 'Accounts Executive', 'Librarian','Driver','Clerk','Cleaner','Secretary','Accountant','Trainer');
@endphp
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <div class="card print-hideen">
                    <div class="card-body">
                        <form action="">
                            <div class="row">
                                <div class="col-md-5">
                                    <select name="employee_role" class="form-control common-select2">
                                        <option value="">Select Designation</option>
                                        @foreach ($employee_roles as $role)
                                            <option value="{{$role}}" {{$employee_role == $role ? 'selected' : '' }}> {{$role}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-5">
                                    
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-secondary">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Bordered table start -->
                <div class="row" id="table-bordered">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex">
                                <div class="print-hidden-show">
                                    @include('backend.tab-file.modal-header-info')
                                </div>
                                <h4 class="card-title flex-grow-1">Employee List</h4>
                                <a href="#" onclick="window.print();" class="btn btn_create mPrint formButton print-hideen" title="List Print">
                                    <div class="d-flex">
                                        <div class="formSaveIcon">
                                            <img src="{{asset('assets/backend/app-assets/icon/print-icon.png')}}" width="25">
                                        </div>
                                        <div><span>List Print</span></div>
                                    </div>
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table mb-0 table-sm table-hover">
                                        <thead  class="thead-light">
                                            <tr style="height: 50px;">
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Nationality</th>
                                                <th>Emirates Num</th>
                                                <th>Designation</th>
                                                <th class="text-right pr-2">Address</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($employees as $key => $employee)
                                            <tr class="trFontSize">
                                                <td>{{ ($key+1)}}</td>
                                                <td>{{ $employee->fname. ' '.$employee->mname. ' '.$employee->family_name  }} </td>
                                                <td>{{ $employee->nationality }} </td>
                                                <td>{{ $employee->emirates_id_num }} </td>
                                                <td>{{ $employee->employee_role }} </td>
                                                <td class="text-right">{{ $employee->local_address }} </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>                            
                            </div>
                            <div class="print-hidden-show">
                                @include('backend.tab-file.modal-footer-info')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
