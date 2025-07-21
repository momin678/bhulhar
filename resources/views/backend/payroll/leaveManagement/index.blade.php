@extends('layouts.backend.app')
@push('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
<style>
    .form-control {
        text-align: center;
    }
    .lable {
        text-align: center;
    }
</style>
<style>
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
<style>
    .card {
            margin-bottom: 0.10rem !important;
        }

    .row {
        padding-bottom: 5px;
    }
</style>
@endpush
@section('title', 'employee-salary')
@section('content')
@include('layouts.backend.partial.style')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="tab-content  cardStyleChange">
                <section id="widgets-Statistics" class="mr-1 ml-1">
                    <div class="row">
                        <div class="col-md-6 mt-2 mb-2">
                            <h4>Leave List</h4>
                        </div>
                    </div>
                    <div class="row" style="padding-left: 10px; padding-right: 10px">
                        <div class="col-12">
                            <form action="{{route('leave-management.store')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="cardStyleChange">
                                    <div class="row ">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="row px-1">
                                                    {{-- <div class="col-md-12 mt-2">
                                                        <h4>Employee Salary Details</h4>
                                                    </div> --}}
                                                    <div class="col-sm-6 col-12 changeColStyle emp_id-select">
                                                        <label for="mode">Employee ID <sup class="text-danger">*</sup></label>
                                                        <input type="text" class="form-control inputFieldHeight" name="" id="emp_name" value="" required>
                                                        {{-- <select name="employee_id" id="employee_id" class="form-control common-select2" style="width: 100% !important" required>
                                                            <option value=""></option>
                                                            @foreach ($employees as $employee)
                                                                <option value="{{$employee->id}}">{{$employee->id}}</option>
                                                            @endforeach
                                                        </select> --}}
                                                    </div>
                                                    <div class="col-sm-6 col-12 changeColStyle emp-select">
                                                        <label for="mode">Employee name <sup class="text-danger">*</sup></label>
                                                        <select name="employee_id" id="employee_id" class="form-control common-select2" style="width: 100% !important" required>
                                                            <option value=""></option>
                                                            @foreach ($employees as $employee)
                                                                <option value="{{$employee->id}}">{{$employee->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row leaveInformation">
                                        {{-- <div class="col-12">
                                            <div class="card">
                                                <div class="row px-1">
                                                    <div class="col-sm-3 col-12 changeColStyle">
                                                        <label for="mode">Basic <sup class="text-danger">*</sup></label>
                                                        <input type="text" class="form-control inputFieldHeight each-item" name="basic" id="basic" required>
                                                    </div>
                                                    <div class="col-sm-3 col-12 changeColStyle">
                                                        <label for="mode">House Rent </label>
                                                        <input type="text" class="form-control inputFieldHeight each-item" name="house_rent" id="{{ $salaryStructure['1']['id'] }}" value="{{ ($salaryStructure['1']['type'] == 'flat')?$salaryStructure['1']['value']:0 }}" {{ ($salaryStructure['1']['type'] == 'none')?'':'readonly' }} required>
                                                    </div>
                                                    <div class="col-sm-3 col-12 changeColStyle">
                                                        <label for="mode">Transportation </label>
                                                        <input type="text" class="form-control inputFieldHeight each-item" name="transportation" id="{{ $salaryStructure['2']['id'] }}" value="{{ ($salaryStructure['2']['type'] == 'flat')?$salaryStructure['2']['value']:0 }}" {{ ($salaryStructure['2']['type'] == 'none')?'':'readonly' }} required>
                                                    </div>
                                                    <div class="col-sm-3 col-12 changeColStyle">
                                                        <label for="mode">Bonus </label>
                                                        <input type="text" class="form-control inputFieldHeight each-item" name="bonus" id="{{ $salaryStructure['3']['id'] }}" value="{{ ($salaryStructure['3']['type'] == 'flat')?$salaryStructure['3']['value']:0 }}" {{ ($salaryStructure['3']['type'] == 'none')?'':'readonly' }} required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}
                                    </div>
                                    <div class="row takeInformation">
                                        {{-- <div class="col-12">
                                            <div class="card">
                                                <div class="row px-1">
                                                    <div class="col-sm-2 col-12 changeColStyle">
                                                        <label for="mode">Medical Expenses </label>
                                                        <input type="text" class="form-control inputFieldHeight each-item" name="medical_expenses" id="{{ $salaryStructure['7']['id'] }}" value="{{ ($salaryStructure['7']['type'] == 'flat')?$salaryStructure['7']['value']:0 }}" {{ ($salaryStructure['7']['type'] == 'none')?'':'readonly' }} required>
                                                    </div>
                                                    <div class="col-sm-2 col-12 changeColStyle">
                                                        <label for="mode">Telephone Bill </label>
                                                        <input type="text" class="form-control inputFieldHeight each-item" name="telephone_bill" id="{{ $salaryStructure['4']['id'] }}" value="{{ ($salaryStructure['4']['type'] == 'flat')?$salaryStructure['4']['value']:0 }}" {{ ($salaryStructure['4']['type'] == 'none')?'':'readonly' }} required>
                                                    </div>
                                                    <div class="col-sm-2 col-12 changeColStyle">
                                                        <label for="mode">TA </label>
                                                        <input type="text" class="form-control inputFieldHeight each-item" name="ta" id="{{ $salaryStructure['5']['id'] }}" value="{{ ($salaryStructure['5']['type'] == 'flat')?$salaryStructure['5']['value']:0 }}" {{ ($salaryStructure['5']['type'] == 'none')?'':'readonly' }} required>
                                                    </div>
                                                    <div class="col-sm-2 col-12 changeColStyle">
                                                        <label for="mode">DA </label>
                                                        <input type="text" class="form-control inputFieldHeight each-item" name="da" id="{{ $salaryStructure['6']['id'] }}" value="{{ ($salaryStructure['6']['type'] == 'flat')?$salaryStructure['6']['value']:0 }}" {{ ($salaryStructure['6']['type'] == 'none')?'':'readonly' }} required>
                                                    </div>
                                                    <div class="col-sm-2 col-12 changeColStyle">
                                                        <label for="mode">Vacation Bonus </label>
                                                        <input type="text" class="form-control inputFieldHeight each-item" name="vacation_bonus" id="{{ $salaryStructure['8']['id'] }}" value="{{ ($salaryStructure['8']['type'] == 'flat')?$salaryStructure['8']['value']:0 }}" {{ ($salaryStructure['8']['type'] == 'none')?'':'readonly' }} required>
                                                    </div>
                                                    <div class="col-sm-2 col-12 changeColStyle">
                                                        <label for="mode">Others</label>
                                                        <input type="text" class="form-control inputFieldHeight each-item" name="others" id="{{ $salaryStructure['12']['id'] }}" value="{{ ($salaryStructure['12']['type'] == 'flat')?$salaryStructure['12']['value']:0 }}" {{ ($salaryStructure['12']['type'] == 'none')?'':'readonly' }}>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}
                                    </div>
                                    <div class="row newLeave" >
                                        {{-- <div class="col-12">
                                            <div class="card">
                                                <div class="row px-1">
                                                    <div class="col-sm-2 col-12 changeColStyle">
                                                        <label for="mode">Providant Fund </label>
                                                        <input type="text" class="form-control inputFieldHeight sub-item" name="providant_fund" id="{{ $salaryStructure['10']['id'] }}" value="{{ ($salaryStructure['10']['type'] == 'flat')?$salaryStructure['10']['value']:0 }}" {{ ($salaryStructure['10']['type'] == 'none')?'':'readonly' }} required>
                                                    </div>
                                                    <div class="col-sm-2 col-12 changeColStyle">
                                                        <label for="mode">Gratuity </label>
                                                        <input type="text" class="form-control inputFieldHeight sub-item" name="gratuity" id="{{ $salaryStructure['11']['id'] }}" value="{{ ($salaryStructure['11']['type'] == 'flat')?$salaryStructure['11']['value']:0 }}" {{ ($salaryStructure['11']['type'] == 'none')?'':'readonly' }} required>
                                                    </div>
                                                    <div class="col-sm-2 col-12 changeColStyle">
                                                        <label for="mode">Tax Deduction </label>
                                                        <input type="text" class="form-control inputFieldHeight sub-item" name="tax_reduction" id="{{ $salaryStructure['9']['id'] }}" value="{{ ($salaryStructure['9']['type'] == 'flat')?$salaryStructure['9']['value']:0 }}" {{ ($salaryStructure['9']['type'] == 'none')?'':'readonly' }} required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
                <section class="m-1">
                    <div class="cardStyleChange table-responsive">
                        <table class="table mb-0 table-sm table-hover">
                            <thead class="thead-light">
                                <tr style="height: 50px;">
                                    <th>ID</th>
                                    <th>EMPLOYEE NAME</th>
                                    <th>FROM DATE</th>
                                    <th>TO DATE</th>
                                    <th>DAYS LEAVE</th>
                                    <th>LEAVE REASON</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($leave_info as $item)
                                    <tr  class="data-row">
                                        <td>{{$item->id}}</td>
                                        <td>{{$item->emp->name}}</td>
                                        <td>{{$item->from_date}}</td>
                                        <td>{{$item->to_date}}</td>
                                        <td>{{$item->days_leave}}</td>
                                        <td>{{$item->leave_reason}}</td>
                                        <td class="float-right">
                                            <div class="btn-group">
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding-top: 2px; padding-bottom: 2px; font-size: 12px; padding-left: 10px;">
                                                        Actions
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item employeeLeaveEdit" id="{{$item->id}}" href="#">Edit</a>
                                                        <a class="dropdown-item leaveView" href="#"  id="{{$item->id}}">View</a>
                                                        <a href="#" id="{{$item->id}}" class="dropdown-item employeeLeavePrint">Print</a>
                                                    </div>
                                                </div>
                                            </div>
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
    {{-- Edit modal  --}}
    <div class="modal fade bd-example-modal-lg" id="employeeLeaveditModal" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div id="employeeLeaveEditModalShow">
              
            </div>
          </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg" id="leaveViewModal" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div id="leaveViewDetails">
              
            </div>
          </div>
        </div>
    </div>
@endsection

@push('js')
<script>
    // for sum when it load
       
    //finish sum

    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN':'{{ csrf_token() }}'
        }
    });

    //employee name select
    $(document).on("change", "#employee_id", function(e) {

                if ($(this).val() != '') {
                var emp = $(this).val();
                // alert(category);
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('leave-info') }}",
                    method: "GET",
                    data: {
                        emp: emp,
                        _token: _token,
                    },
                    success: function(response) {
                        console.log(response);
                            $("#emp_name").val(response.page.id);
                            $(".leaveInformation").empty().append(response.entitled);
                            $(".takeInformation").empty().append(response.takeInformation);
                            $(".newLeave").empty().append(response.newLeave);
                    }
                })
            }
    });

    //view modal po-up
    $(document).on("click", ".leaveView", function(e) { 
            e.preventDefault();
            var id= $(this).attr('id');
            $.ajax({
                url: "{{URL('employee-view-leave-modal')}}",
                type: "post",
                cache: false,
                data:{
                    _token:'{{ csrf_token() }}',
                    id:id,
                },
                success: function(response){				
                    document.getElementById("leaveViewDetails").innerHTML = response;
                    $('#leaveViewModal').modal('show')
                }
            });
    });

    //Delete Documents
    $(document).on("click", '.invoice-item-delete', function(event) {
        event.preventDefault();
        // alert(1);
        var that = $(this);
        var urls = that.attr("data_target");
        var _token = $('input[name="_token"]').val();
        // alert(urls);
        $.ajax({
            url: urls,
            method: "GET",
            _token: _token,

            success: function(response) {
                // alert("hukka");
                console.log(response);
                $(".data").empty().append(response.page);

            },
            error: function() {
                //   alert('no');
            }
        });
    });

    //  edit pop-up 
    $(document).on("click", ".employeeLeaveEdit", function(e) { 
        e.preventDefault();
        var id= $(this).attr('id');
		$.ajax({
			url: "{{URL('employee-leave-edit-modal')}}",
			type: "post",
			cache: false,
			data:{
				_token:'{{ csrf_token() }}',
                id:id,
			},
			success: function(response){				
                document.getElementById("employeeLeaveEditModalShow").innerHTML = response;
                $('#employeeLeaveditModal').modal('show')
			}
		});
	});

    //end employee name select
    $(document).on("keyup", "#emp_name", function(e) {

                if ($(this).val() != '') {
                var emp = $(this).val();
                // alert(category);
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('leave-info') }}",
                    method: "GET",
                    data: {
                        emp: emp,
                        _token: _token,
                    },
                    success: function(response) {
                        console.log(response);
                            $("div.emp-select select").val(response.page.id).change();
                            $(".leaveInformation").empty().append(response.entitled);
                            $(".takeInformation").empty().append(response.takeInformation);
                            $(".newLeave").empty().append(response.newLeave);
                    }
                })
            }
    });



//employee name select
$(document).on("onchange", "#to_date", function(e) {
    // alert(1);
    var date1 = $(this).val("from_date");
    var date2 = $(this).val("to_date");
    console.log(date1);
    alert(date2);
    // To calculate the time difference of two dates
    var Difference_In_Time = date2.getTime() - date1.getTime();
    alert(1);
    // To calculate the no. of days between two dates
    var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);
    alert(Difference_In_Days);
    $("#days").val(Difference_In_Days);
});
    

</script>
@endpush