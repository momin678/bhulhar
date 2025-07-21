@php
    use Carbon\CarbonPeriod;
@endphp
@extends('layouts.backend.app')
@push('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />

@endpush
@section('content')
@include('layouts.backend.partial.style')
<style>
    .accordion .pluseMinuseIcon.collapsed::before{
        content: "\f067";;
        cursor: pointer;
        border: 1px solid rgb(123, 123, 123);
    }
    .accordion .pluseMinuseIcon::before {
        font-family: 'FontAwesome';
        content: "\f068";
        cursor: pointer;
        border: 1px solid rgb(123, 123, 123);
    }
    .rowStyle{
        cursor: pointer;
        border-left: dotted;
        padding: 3px;
        margin-bottom: 2px;
    }
    .findMasterAcc{
        cursor: pointer;
    }
    .card {
    margin-bottom: 0px !important;
    box-shadow: -8px 12px 18px 0 rgb(25 42 70 / 13%);
    transition: all .3s ease-in-out, background 0s, color 0s, border-color 0s;
}
tr, td{
    text-align: center;
}
</style>
<div class="app-content content print-hideen">
    <div class="content-overlay"></div>
        <div class="content-wrapper">
        <div class="content-body">
            <div class="nav nav-tabs master-tab-section" id="nav-tab" role="tablist">
                <a href="{{route('time-tracking.index')}}" class="nav-item nav-link " role="tab" aria-controls="nav-contact" aria-selected="false">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/list-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
                    </div>
                    <div>Time Sheet</div>
                </a>
                <a href="{{route('time-tracking.create')}}" class="nav-item nav-link active" role="tab" aria-controls="nav-contact" aria-selected="false">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/time-track.png')}}" alt="" srcset="" class="img-fluid" width="50">
                    </div>
                    <div>Hours Count</div>
                </a>
                {{-- <a href="{{route('print-document')}}" class="nav-item nav-link " role="tab" aria-controls="nav-contact" aria-selected="false">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/add-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
                    </div>
                    <div>Print Document</div>
                </a> --}}
            </div>
            <br>
            <h4>Time Entry</h4>
            {{-- <form class="form form-vertical" action="{{route('pay-salary.create')}}" method="get" enctype="multipart/form-data">
                <div class="cardStyleChange">
                    <div class="card-body">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="class-name">Month</label>
                                        <select name="month" id="" class="inputFieldHeight form-control" required>
                                            <option value="">Select month</option> 
                                            @foreach(CarbonPeriod::create(now()->startOfMonth(), '1 month', now()->addMonths(11)->startOfMonth()) as $date)   
                                            <option value="{{ $date->format('F') }}" {{$date->format('F') == $month ? "selected":""}}>
                                                    {{ $date->format('F') }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('month')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="class-name">Year  </label>
                                            <select name="year" class="inputFieldHeight form-control" id="" required> 
                                                @for($i=date('Y')-2;date('Y')+2>$i;$i++)
                                                    <option value="{{$i}}" {{ $i == date('Y')?'selected':'' }}>{{$i}}</option>
                                                @endfor
                                            </select>
                                        @error('year')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-2 d-flex justify-content-end">
                                    <button type="submit" class="btn mt-2 mb-2 formButton mSearchingBotton" title="Search">
                                        <div class="d-flex">
                                            <div class="formSaveIcon">
                                                <img src="{{asset('assets/backend/app-assets/icon/searching-icon.png')}}" width="25">
                                            </div>
                                            <div><span>Search</span></div>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form> --}}
            <form class="form form-vertical" action="{{route('time-tracking.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <section id="basic-vertical-layouts">
                    <div class="row match-height">
                        <div class="col-md-12 col-12">
                            <div class="cardStyleChange">
                                <div class="card-body">
                                    <div class="form-body">
                                        {{-- <div class="row">
                                            <div class="col-md-4 col-12">
                                                <div class="form-group">
                                                    <label for="class-name">Month</label>
                                                    <select name="month" id="" class="inputFieldHeight form-control" required>
                                                        @foreach(CarbonPeriod::create(now()->startOfMonth(), '1 month', now()->addMonths(11)->startOfMonth()) as $date)
                                                            <option value="{{ $date->format('F') }}">
                                                                {{ $date->format('F') }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('month')
                                                        <span class="error">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="form-group">
                                                    <label for="class-name">Year  </label>
                                                        <select name="year" class="inputFieldHeight form-control" id="" required>
                                                            @for($i=date('Y')-2;date('Y')+2>$i;$i++)
                                                                <option value="{{$i}}" {{ $i == date('Y')?'selected':'' }}>{{$i}}</option>
                                                            @endfor
                                                           
                                                    </select>
                                                    @error('year')
                                                        <span class="error">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>--}}
                                        <div class="row">
                                            <div class="col-sm-2 form-check">
                                                <input class="form-check-input" type="checkbox" id="checkall">
                                                <label class="form-check-label" for="checkall">All Employee</label> 
                                            </div>
                                            <div class="col-sm-4 ">
                                                <label class="date-label" for="checkall">Date :</label> 
                                                <input class="date-input" name="date" type="date" id="">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="table-responsive">
                                                    <table class="table table-sm table-bordered">
                                                        <thead  class="thead-light">
                                                            <tr style="height: 50px;">
                                                                <th>Checked</th>
                                                                <th>Employee Name <input type="text" id="empSearch"></th>
                                                                <th>Designation</th>
                                                                <th>Entrty</th>
                                                                <th>Out</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="employees">
                                                            @php
                                                                $index=0;
                                                            @endphp
                                                                @foreach ($employees as $employee)                        
                                                                    <tr class="trFontSize border-bottom">
                                                                        <td>
                                                                            <input class="checkbox"  type="checkbox" value="{{$employee->id}}" name="employee_id[id][{{$index}}]"> 
                                                                        </td>
                                                                        <td>{{$employee->name}} </td>
                                                                        <td>{{$employee->designation}} </td>
                                                                        <td><input type="time" id="" name="employee_id[entry][{{$index}}]"  value="{{now()->format('H:i:s')}}" > </td>
                                                                        <td><input type="time" id="" name="employee_id[out][{{$index}}]"  value="{{now()->format('H:i:s')}}"> </td>
                                                                        <input class=""  type="hidden" name="employee_id[month][{{$index}}]" value="{{$employee->month}}">
                                                                        <input class=""  type="hidden" name="employee_id[year][{{$index++}}]" value="{{$employee->year}}">
                                                                    </tr>
                                                                @endforeach                                            
                                                        </tbody>
                                                        
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary mt-2 mb-2 formButton" title="Save">
                                                    <div class="d-flex">
                                                        <div class="formSaveIcon">
                                                            <img src="{{asset('assets/backend/app-assets/icon/save-icon.png')}}" width="25">
                                                        </div>
                                                        <div><span>Save</span></div>
                                                    </div>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                        
                    </div>
                </section>
            </form>
        </div>
    </div>
</div>
@endsection
@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
    {{-- <script src="{{ asset('assets/backend/app-assets/vendors/js/jquery/jquery.min.js') }}"></script> --}}
    <script>
        $(document).ready(function() {
            $('#category').change(function() {
                // alert(1);
                if ($(this).val() != '') {
                    var value = $(this).val();
                    var _token = $('input[name="_token"]').val();

                    $.ajax({
                        url: "{{ route('findMastedCode') }}",
                        method: "POST",
                        data: {
                            value: value,
                            _token: _token,
                        },
                        success: function(response) {
                            $("#mst_ac_code").val(response);
                        }

                    })
                }
            });
        });

    //end employee name select
    $(document).on("keyup", "#empSearch", function(e) {
                if ($(this).val() != '') {
                var emp = $(this).val();
                // alert(category);
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('employee-time-tracking') }}",
                    method: "GET",
                    data: {
                        emp: emp,
                        _token: _token,
                    },
                    success: function(response) {
                        // console.log(response);
                        $(".employees").empty().append(response.page);
                    }
                })
            }
    });
    </script>
    
    <script>
        var i, currentYear, startYear, endYear, newOption, dropdownYear;
           dropdownYear2 = document.getElementById("dropdownYear2");
           currentYear = (new Date()).getFullYear();
           startYear = currentYear - 4;
           endYear = currentYear + 3;
           for (i=startYear;i<=endYear;i++) {
           newOption = document.createElement("option");
           newOption.value = i;
           newOption.label = i;
               if (i == currentYear) {
                   newOption.selected = true;
               }
               dropdownYear2.appendChild(newOption);
           }
   </script>
   <script>
        $(document).on("click", ".paymentPayrollProcessModal", function(e) { 
                e.preventDefault();
                var id= $(this).attr('id');
                $.ajax({
                    url: "{{URL('payment-payroll-process-modal')}}",
                    type: "post",
                    cache: false,
                    data:{
                        _token:'{{ csrf_token() }}',
                        id:id,
                    },
                    success: function(response){				
                        document.getElementById("paymentPayrollProcessEdit").innerHTML = response;
                        $('#paymentPayrollProcessEditModal').modal('show');
                        $('.common-select2').select2();
                    }
                });
            });
        $(document).on("click", ".showPayrollProcesseModal", function(e) { 
            e.preventDefault();
            var id= $(this).attr('id');
            $.ajax({
                url: "{{URL('show-payment-payroll-modal')}}",
                type: "post",
                cache: false,
                data:{
                    _token:'{{ csrf_token() }}',
                    id:id,
                },
                success: function(response){				
                    document.getElementById("paymentPayrollProcessEdit").innerHTML = response;
                    $('#paymentPayrollProcessEditModal').modal('show');
                    $('.common-select2').select2();
                }
            });
        });
        $(document).on("click", ".printPayrollProcesseModal", function(e) { 
            e.preventDefault();
            var id= $(this).attr('id');
            $.ajax({
                url: "{{URL('new-payslip-print')}}",
                type: "post",
                cache: false,
                data:{
                    _token:'{{ csrf_token() }}',
                    id:id,
                },
                success: function(response){				
                    document.getElementById("paymentPayrollPrint").innerHTML = response;
                    $('#paymentPayrollProcessPrint').modal('show');
                    setTimeout(printFunction, 500);
                }
            });
        });
    </script>
<script type='text/javascript'>
    $(document).ready(function(){
      // Check or Uncheck All checkboxes
      $("#checkall").change(function(){
        var checked = $(this).is(':checked');
        if(checked){
          $(".checkbox").each(function(){
            $(this).prop("checked",true);
          });
        }else{
          $(".checkbox").each(function(){
            $(this).prop("checked",false);
          });
        }
      });    
     // Changing state of CheckAll checkbox 
     $(".checkbox").click(function(){    
       if($(".checkbox").length == $(".checkbox:checked").length) {
         $("#checkall").prop("checked", true);
       } else {
         $("#checkall").prop("checked", false);
       }
   
     });
   });
</script>
@endpush

<style>
    #customers {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }
    #customers td, #customers th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #customers tr:nth-child(even){background-color: #f2f2f2;}

    #customers tr:hover {background-color: #ddd;}
    #customers th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #04AA6D;
        color: white;
        text-transform: uppercase;

    }
    .graph-7{background: url(../img/graphs/graph-7.jpg) no-repeat;}
    .graph-image img{display: none;}
    @media screen {
    div.divFooter {
        display: none;
    }
    }
    @media print {
        div.divFooter {
            position: fixed;
            bottom: 0;
        }
    }
    th{
        text-transform: uppercase;
    }
</style>
<style>
   .print-layout{
       display: none;
   }
   @media print{
       .print-layout{
           display: block;
           /* overflow: hidden; */
       }
       html, body{
        overflow: hidden;
       }
   }
</style>

