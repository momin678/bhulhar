@extends('layouts.backend.app')
@push('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
<style>
    .card {
            margin-bottom: 0.10rem !important;
        }

    .row {
        padding-bottom: 5px;
    }
</style>
@endpush
@section('title', 'salary-types')
@section('content')
@include('layouts.backend.partial.style')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="tab-content cardStyleChange">
                <section id="widgets-Statistics" class="mr-1 ml-1">
                    <div class="row">
                        <div class="col-md-6 mt-2 mb-2">
                            <h4>Yearly Performance review</h4>
                        </div>
                    </div>
                    <div class="row" style="padding-left: 10px; padding-right: 10px">
                        <div class="col-12">
                            <form action="{{route('performance-management.store')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="cardStyleChange">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="row px-1">
                                                    <div class="col-sm-4 col-12 changeColStyle">
                                                        <label for="mode">Employee <sup class="text-danger">*</sup></label>
                                                        {{-- <input type="text" class="form-control inputFieldHeight" name="nationality" id="nationality" required> --}}
                                                        <select name="employee_id" id="employee_id" class="form-control common-select2" style="width: 100% !important" required>
                                                            <option value="">Select Employee</option>
                                                            @foreach ($employees as $employee)
                                                                <option value="{{$employee->id}}">{{$employee->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-4 col-12 changeColStyle">
                                                        <label for="mode">Discussion <sup class="text-danger">*</sup></label>
                                                        <input type="text" class="form-control inputFieldHeight" name="discussion" id="discussion" required>
                                                    </div>
                                                    <div class="col-sm-4 col-12 changeColStyle ">
                                                        <label for="mode">Performance result <sup class="text-danger">*</sup></label>
                                                        <input type="number" class="form-control inputFieldHeight" name="performance_result" id="performance_result" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="row px-1">
                                                    <div class="col-sm-4 col-12 changeColStyle">
                                                        <label for="mode">Employee Contribution <sup class="text-danger">*</sup> </label>
                                                        <input type="number" class="form-control inputFieldHeight each-item" name="employee_contribution" id="employee_contribution" readonly required>
                                                    </div>
                                                    <div class="col-sm-4 col-12 changeColStyle">
                                                        <label for="mode">Company Contribution <sup class="text-danger">*</sup> </label>
                                                        <input type="number" class="form-control inputFieldHeight each-item" name="company_contribution" id="company_contribution" required>
                                                    </div>
                                                    <div class="col-sm-4 col-12 changeColStyle">
                                                        <label for="mode">Country inflation rate <sup class="text-danger">*</sup> </label>
                                                        <input type="number" class="form-control inputFieldHeight each-item" name="country_inflation_rate" id="country_inflation_rate" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="row px-1">
                                                    <div class="col-sm-4 col-12 changeColStyle">
                                                        <label for="mode">Proposed compensation <sup class="text-danger">*</sup> </label>
                                                        <input type="text" class="form-control inputFieldHeight" name="proposed_compensation" id="proposed_compensation" readonly required>
                                                    </div>
                                                    <div class="col-md-3 col-12 changeColStyle">
                                                        <label>Document</label>
                                                        <input type="file" class="form-control inputFieldHeight" name="files" multiple required>
                                                        @error('file')
                                                        <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                                    <th>Discussion</th>
                                    <th>PERFORMANCE RESULT</th>
                                    <th>Company contributin</th>
                                    <th>Country inflation rate</th>
                                    <th>Proposed compensation</th>
                                    <th class="text-right pr-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($performance as $item)
                                    <tr  class="data-row">
                                        <td>{{$item->emp->name}}</td>
                                        <td>{{$item->performance_result}}</td>
                                        <td>{{$item->company_contribution}}</td>
                                        <td>{{$item->country_inflation_rate}}</td>
                                        <td>{{$item->proposed_compensation}}</td>
                                        <td style="padding-bottom: 11px; padding-top: 0px" class="text-right pr-2">
                                            <a href="{{route('performance-management.edit', $item->id)}}" class="btn" style="height: 30px; width: 30px;" title="Eidt">
                                                <img src="{{ asset('assets/backend/app-assets/icon/edit-icon.png')}}" style=" height: 30px; width: 30px;">
                                            </a>
                                            
                                            <a href="" class="btn" style="height: 30px; width: 30px;" title="Delete">
                                                <form action="{{ route('performance-management.destroy', $item->id) }}" method="POST" class="flot-right">
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

            $(document).on("keyup", "#performance_result", function(e) {
               
                    var id = $(this).val();
                    $("#employee_contribution").val(id);
            });

            $(document).on("keyup", ".each-item", function(e) {
                var sum = 0;
                var avg = 0;
                $('.each-item').each(function() {
                // parseInt($(this).attr('max'));
                    if(this.value != '')
                    {

                        sum += parseFloat(this.value);
                        avg = sum/3;
                    }
                });
                $("#proposed_compensation").val(avg);
            });
        });
</script>
@endpush