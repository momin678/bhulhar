@extends('layouts.backend.app')
@push('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
@endpush
@section('title', 'salary-types')
@section('content')
@include('layouts.backend.partial.style')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="tab-content card cardStyleChange">
                <section id="widgets-Statistics" class="mr-1 ml-1">
                    <div class="row">
                        <div class="col-md-6 mt-2 mb-2">
                            <h4>Employee Bank Information</h4>
                        </div>
                    </div>
                    <div class="row" style="padding-left: 10px; padding-right: 10px">
                        <div class="col-12">
                            <form action="{{route('employee-banks.store')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="cardStyleChange">
                                    <div class="row">
                                        <div class="col-sm-2 col-12 changeColStyle">
                                            <label for="mode">Employee <sup class="text-danger">*</sup></label>
                                            {{-- <input type="text" class="form-control inputFieldHeight" name="nationality" id="nationality" required> --}}
                                            <select name="employee_id" id="employee_id" class="form-control common-select2" style="width: 100% !important" required>
                                                <option value=""></option>
                                                @foreach ($employees as $employee)
                                                    <option value="{{$employee->id}}">{{$employee->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-2 col-12 changeColStyle">
                                            <label for="mode">Account Title <sup class="text-danger">*</sup></label>
                                            <input type="text" class="form-control inputFieldHeight" name="account_title" id="account_title" required>
                                        </div>
                                        <div class="col-sm-2 col-12 changeColStyle">
                                            <label for="mode">Account Number <sup class="text-danger">*</sup></label>
                                            <input type="text" class="form-control inputFieldHeight" name="account_number" id="account_number" required>
                                        </div>
                                        <div class="col-sm-2 col-12 changeColStyle">
                                            <label for="mode">Bank Name <sup class="text-danger">*</sup></label>
                                            <input type="text" class="form-control inputFieldHeight" name="bank_name" id="bank_name" required>
                                        </div>
                                        <div class="col-sm-2 col-12 changeColStyle">
                                            <label for="mode">Branch Name <sup class="text-danger">*</sup></label>
                                            {{-- <input type="text" class="form-control inputFieldHeight" name="branch_name" id="branch_name" required> --}}
                                            <select name="branch_name" id="branch_name" class="form-control common-select2" style="width: 100% !important" required>
                                                <option value=""></option>
                                                @foreach ($bankBranch as $bankBranch)
                                                    <option value="{{$bankBranch->id}}">{{$bankBranch->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-2 col-12 changeColStyle">
                                            <label for="mode">Routing Number <sup class="text-danger">*</sup></label>
                                            <input type="text" class="form-control inputFieldHeight" name="routing_number" id="routing_number" readonly required>
                                        </div>
                                        <div class="col-12 col-md-12 d-flex justify-content-end changeColStyle mb-1 mt-1">
                                            <button type="submit" class="btn mr-1 btn-primary formButton" title="Form Save">
                                                <div class="d-flex">
                                                    <div class="formSaveIcon">
                                                        <img  src="{{asset('assets/backend/app-assets/icon/save-icon.png')}}" alt="" srcset="" class="img-fluid" width="25">
                                                    </div>
                                                    <div><span> Save</span></div>
                                                </div>
                                            </button>
                                            <button type="reset" class="btn btn-light-secondary formButton" title="Form Reset">
                                                <div class="d-flex">
                                                    <div class="formRefreshIcon">
                                                        <img  src="{{asset('assets/backend/app-assets/icon/refresh-icon.png')}}" alt="" srcset="" class="img-fluid" width="25">
                                                    </div>
                                                    <div><span> Reset</span></div>
                                                </div>
                                            </button>

                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
                <section class="m-1">
                    <div class="cardStyleChange">
                        <table class="table mb-0 table-sm table-hover">
                            <thead class="thead-light">
                                <tr style="height: 50px;">
                                    <th>Name</th>
                                    <th>Bank Name</th>
                                    <th>Branch Name</th>
                                    <th>Account Number</th>
                                    <th>Routing Number</th>
                                    <th class="text-right pr-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employeeBanks as $item)
                                    <tr  class="data-row">
                                        <td>{{$item->employee->name}}</td>
                                        <td>{{$item->bank_name}}</td>
                                        <td>{{$item->branch->name}}</td>
                                        <td>{{$item->account_number}}</td>
                                        <td>{{$item->routing_number}}</td>
                                        <td style="padding-bottom: 11px; padding-top: 0px" class="text-right pr-2">
                                            <a href="{{route('employee-banks.edit', $item->id)}}" class="btn" style="height: 30px; width: 30px;" title="Eidt">
                                                <img src="{{ asset('assets/backend/app-assets/icon/edit-icon.png')}}" style=" height: 30px; width: 30px;">
                                            </a>
                                            
                                            <a href="" class="btn" style="height: 30px; width: 30px;" title="Delete">
                                                <form action="{{ route('employee-banks.destroy', $item->id) }}" method="POST" class="flot-right">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn" onclick="return confirm('Confirm?')" style="padding-top: 0px; padding-left:0px;">
                                                        <img src="{{ asset('assets/backend/app-assets/icon/delete-icon.png')}}" style="height: 32px; width: 32px; margin-left: -12px;">
                                                    </button>
                                                </form>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection

@push('js')
<script>
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN':'{{ csrf_token() }}'
        }
    });
    $(document).ready(function() {
            $(document).on("change", "#employee_id", function(e) {
                if ($(this).val() != '') {
                var emp = $(this).val();
                // alert(category);
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('employee-name') }}",
                    method: "GET",
                    data: {
                        emp: emp,
                        _token: _token,
                    },
                    success: function(response) {
                        console.log(response);
                        $("#account_title").val(response.page.name);
                    }
                })
            }
            });

            $(document).on("change", "#branch_name", function(e) {
                if ($(this).val() != '') {
                var id = $(this).val();
                // alert(category);
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('routing-number') }}",
                    method: "GET",
                    data: {
                        id: id,
                        _token: _token,
                    },
                    success: function(response) {
                        // console.log(response);
                        $("#routing_number").val(response.page.routing_number);
                    }
                })
            }
            });
        });
</script>
@endpush