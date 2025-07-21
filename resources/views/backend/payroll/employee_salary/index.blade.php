@extends('layouts.backend.app')
@push('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
<style>
    .card {
            margin-bottom: 0.60rem !important;
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
                            <h4>Employee Salary Structure</h4>
                        </div>
                    </div>
                    <div class="row" style="padding-left: 10px; padding-right: 10px">
                        <div class="col-12">
                            <form action="{{route('employee-salary.store')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="cardStyleChange">
                                    <div class="row ">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="row px-1">
                                                    {{-- <div class="col-md-12 mt-2">
                                                        <h4>Employee Salary Details</h4>
                                                    </div> --}}
                                                    <div class="col-sm-4 col-12 changeColStyle emp_id-select">
                                                        <label for="mode">Employee ID <sup class="text-danger">*</sup></label>
                                                        <input type="text" class="form-control inputFieldHeight" name="" id="emp_name" value="" required>
                                                        {{-- <select name="employee_id" id="employee_id" class="form-control common-select2" style="width: 100% !important" required>
                                                            <option value=""></option>
                                                            @foreach ($employees as $employee)
                                                                <option value="{{$employee->id}}">{{$employee->id}}</option>
                                                            @endforeach
                                                        </select> --}}
                                                    </div>
                                                    <div class="col-sm-4 col-12 changeColStyle emp-select">
                                                        <label for="mode">Employee name <sup class="text-danger">*</sup></label>
                                                        <select name="employee_id" id="employee_id" class="form-control common-select2" style="width: 100% !important" required>
                                                            <option value=""></option>
                                                            @foreach ($employees as $employee)
                                                                <option value="{{$employee->id}}">{{ $employee->fisrt_name.' '.$employee->last_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-3 col-12 changeColStyle">
                                                        <label for="mode">Wages Type</label>
                                                        <input type="text" class="form-control inputFieldHeight" name="wages_type" id="wages_type" value="" readonly required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row ">
                                        <div class="col-12">
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
                                        </div>
                                    </div>
                                    <div class="row ">
                                        <div class="col-12">
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
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
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
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="row px-1">
                                                    <div class="col-sm-4 col-12 changeColStyle">
                                                        <label for="mode">Total</label>
                                                        <input type="text" class="form-control inputFieldHeight"  name="total" id="total" readonly>
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
                                        </div>
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
                                    <th>Name</th>
                                    <th>Besic</th>
                                    <th>House Rent</th>
                                    <th>Transportation</th>
                                    <th>Bonus</th>
                                    <th>Telephone Bill</th>
                                    <th>TA</th>
                                    <th>DA</th>
                                    <th>Medical Expenses</th>
                                    <th>Vacation Bonus</th>
                                    <th>Tax Reduction</th>
                                    <th>Providant Fund</th>
                                    <th>Gratuity</th>
                                    <th>Others</th>
                                    <th>Total</th>
                                    <th class="text-right pr-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employeeSalarys as $item)
                                    <tr  class="data-row">
                                        <td>{{$item->items->name}}</td>
                                        <td>{{$item->basic}}</td>
                                        <td>{{$item->house_rent}}</td>
                                        <td>{{$item->transportation}}</td>
                                        <td>{{$item->bonus}}</td>
                                        <td>{{$item->telephone_bill}}</td>
                                        <td>{{$item->ta}}</td>
                                        <td>{{$item->da}}</td>
                                        <td>{{$item->medical_expenses}}</td>
                                        <td>{{$item->vacation_bonus}}</td>
                                        <td>{{$item->tax_reduction}}</td>
                                        <td>{{$item->providant_fund}}</td>
                                        <td>{{$item->gratuity}}</td>
                                        <td>{{$item->others}}</td>
                                        <td>{{$item->total}}</td>
                                        <td style="padding-bottom: 11px; padding-top: 0px" class="text-right pr-2">
                                            <a href="{{route('employee-salary.edit', $item->id)}}" class="btn" style="height: 30px; width: 30px;" title="Eidt">
                                                <img src="{{ asset('assets/backend/app-assets/icon/edit-icon.png')}}" style=" height: 30px; width: 30px;">
                                            </a>
                                            
                                            <a href="" class="btn" style="height: 30px; width: 30px;" title="Delete">
                                                <form action="{{ route('employee-salary.destroy', $item->id) }}" method="POST" class="flot-right">
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
    // for sum when it load
       
    //finish sum

    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN':'{{ csrf_token() }}'
        }
    });

  sum();

    $(document).on("keyup", ".each-item", function(e) {
        sum();

    });

    $(document).on("keyup", ".sub-item", function(e) {
        sum();

    });
    //employee name select
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
                        if(response.check_unique == 'yes') {
                            toastr.warning("This emplyee slaray structure already created","Warning");
                            $("div.emp-select select").val('').change();
                            $("#emp_name").val('');
                            $("#wages_type").val('');
                        } else {
                            $("#emp_name").val(response.page.id);
                            $("#wages_type").val(response.wages);
                        }
                    }
                })
            }
    });

    //end employee name select

    $(document).on("keyup", "#emp_name", function(e) {
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
                        // console.log(response);
                        if(response.check_unique == 'yes'){
                            toastr.warning("This emplyee slaray structure already created","Warning");
                            $("#emp_name").val('').change();
                            $("div.emp-select select").val('').change();
                            $("#wages_type").val('');
                        }else{
                            $("div.emp-select select").val(response.page.id).change();
                            $("#wages_type").val(response.wages);
                        }
                    }
                })
            }
    });

    $('#basic').keyup(function() {
                if ($(this).val() != '') {
                    var value = $(this).val();
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "{{ route('percentCount') }}",
                        method: "POST",
                        data: {
                            value: value,
                            _token: _token,
                        },
                        success: function(response) {
                            // alart($(this).val());
                            // alert(response.infos.id);
                            for (var i=0; i<response.infos.length; i++) {
                                    var values = (response.value / 100) * response.infos[i]['value'];
                                    // var idd = '#'.response.infos[i]['head'];
                                    // alert(values);
                                    // alert("#"+ response.infos[i]['head']+"");
                                    $("#"+ response.infos[i]['id']+"").val(values);
                                }
                            sum();
                        }
                    })
                }
            });

        function sum(){
                var sum = 0;
                $('.each-item').each(function() {
                // parseInt($(this).attr('max'));
                if(this.value != '')
                {

                    sum += parseFloat(this.value);
                }
                });
                $('.sub-item').each(function() {
                // parseInt($(this).attr('max'));
                if(this.value != '')
                {
                    sum -= parseFloat(this.value);
                }
                });
                // alert(sum);
                $("#total").val(sum);
        }
</script>
@endpush