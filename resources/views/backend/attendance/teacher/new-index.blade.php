
@extends('layouts.backend.app')
@section('content')
@include('backend.tab-file.style')
@php
    use Carbon\Carbon;
    use App\HolidayRecode;

@endphp
<div class="app-content content print-hideen">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            @include('clientReport.teacherManagement._header', ['activeMenu' => 'teacher_attendance'])

            <div class="tab-content bg-white">
                @include('clientReport.teacherManagement.sub', ['activeMenu' => 'attendance'])

                <div id="employeeAttendance" class="tab-pane active">
                    @if(session('msg'))
                    <div class="col-md-12">
                        <div class="alert alert-warning ">
                            {!! session('msg') !!}
                        </div>
                    </div>
                    @endif
                    <div class="content-body">
                        <section id="basic-vertical-layouts">
                            <div class="row match-height">
                                <div class="col-md-12 col-12">
                                    <div class="cardStyleChange">

                                        <div class="card-body">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <form class="form form-vertical row" method="get" enctype="multipart/form-data">
                                                            <div class="col-md-8 col-12">
                                                                <label for="date">Date</label>
                                                                    <input type="text" id="new_date" class="inputFieldHeight form-control datepicker" name="new_date"  placeholder="dd/mm/yyyy"  value="" required autocomplete="off">
                                                                    @error('date')
                                                                    <span class="error">{{ $message }}</span>
                                                                    @enderror
                                                            </div>
                                                            <div class="col-12 col-md-4 d-flex ">
                                                                {{-- <button type="submit" class="btn btn-primary mr-1">Search</button> --}}
                                                                <button type="submit" class="btn btn-primary formButton mSearchingBotton mt-2 mb-1" title="Searching" >
                                                                    <div class="d-flex">
                                                                        <div class="formSaveIcon">
                                                                            <img src="{{asset('assets/backend/app-assets/icon/view-icon.png')}}" alt="" srcset="" width="20">
                                                                        </div>
                                                                        <div><span> View</span></div>
                                                                    </div>
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <form class="form form-vertical row" method="get" enctype="multipart/form-data">
                                                            <div class="col-md-9 col-12">
                                                                <label for="date">Month</label>
                                                                    <input type="month" id="date" class="inputFieldHeight form-control  @error('date') error @enderror"
                                                                    name="date" value="{{ isset($inputs) ? $inputs['date'] : old('date')}}"required>
                                                                    @error('date')
                                                                    <span class="error">{{ $message }}</span>
                                                                    @enderror
                                                            </div>
                                                            <div class="col-12 col-md-3 d-flex ">
                                                                {{-- <button type="submit" class="btn btn-primary mr-1">Search</button> --}}
                                                                <button type="submit" class="btn btn-primary formButton mPrint mt-2 mb-1" title="Searching" >
                                                                    <div class="d-flex">
                                                                        <div class="formSaveIcon">
                                                                            <img src="{{asset('assets/backend/app-assets/icon/view-icon.png')}}" alt="" srcset="" width="20">
                                                                        </div>
                                                                        <div><span> View</span></div>
                                                                    </div>
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="col-md-4 col-12  text-right col-right-padding"  style="padding-top: 20px;">
                                                            <button type="button" class="btn btn-primary btn_create formButton" title="Add" data-toggle="modal" data-target="#newEmployeeAttendance">
                                                                <div class="d-flex">
                                                                    <div class="formSaveIcon">
                                                                        <img src="{{asset('assets/backend/app-assets/icon/add-icon.png')}}" width="25">
                                                                    </div>
                                                                    <div><span>Take Attendance</span></div>
                                                                </div>
                                                            </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if (isset($attendances))
                                <div class="cardStyleChange m-2">
                                    <h4 class="">Teacher Attendance List</h4>
                                    <div class="table-responsive">
                                        <table class="table mb-0 table-sm table-hover">
                                            <thead  class="thead-light">
                                                <tr style="height: 50px;">
                                                    <th>Name</th>
                                                    <th>Date</th>
                                                    <th class="text-center">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($attendances as $attendance)
                                                <tr class="border-bottom trFontSize">
                                                    <td>{{ $attendance->employee->first_name}} {{$attendance->employee->middle_name}} {{$attendance->employee->last_name }}</td>
                                                    <td> {{date('d/m/Y',strtotime($attendance->date))}} </td>
                                                    <td class="text-center">
                                                        @if ($attendance->status==1)
                                                        <div class="badge badge-success mr-1">Present</div>
                                                        @else
                                                        <div class="badge badge-danger mr-1">Absent</div>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                        {{-- <div class="mt-1">
                                            {{$attendances->links()}}
                                        </div> --}}
                                    </div>
                                    <div class=" d-flex justify-content-end mt-1 ">
                                        <form class="form form-vertical row" action="{{route('new-teacher-attendance-edit')}}"  method="get" enctype="multipart/form-data">
                                            <div class="col-md-11 col-12">

                                                    <input type="hidden" id="new_date" class="inputFieldHeight form-control datepicker" name="new_date"  placeholder="dd/mm/yyyy"  value="{{date('d/m/Y',strtotime($date1))}}" required>
                                                    @error('date')
                                                    <span class="error">{{ $message }}</span>
                                                    @enderror
                                            </div>
                                            <div class="col-12 col-md-1 d-flex ">
                                                {{-- <button type="submit" class="btn btn-primary mr-1">Search</button> --}}
                                                <button type="submit" class="btn btn-primary formButton  mt-2 mb-1" title="Searching" >
                                                    <div class="d-flex">
                                                        <div class="formSaveIcon">
                                                            <img src="{{asset('assets/backend/app-assets/icon/view-icon.png')}}" alt="" srcset="" width="20">
                                                        </div>
                                                        <div><span> Edit</span></div>
                                                    </div>
                                                </button>
                                            </div>
                                        </form>
                                        {{-- <a href="{{route('new-teacher-attendance-edit', ['new_date'=>date('d/m/Y',strtotime($attendance->date))] )}}" class="btn btn-primary mr-1 mb-1">
                                            <div class="d-flex">
                                                <div class="formSaveIcon">
                                                    <img src="{{asset('assets/backend/app-assets/icon/edit-icon.png')}}" alt="" srcset="" width="20">
                                                </div>
                                                <div><span> Edit</span></div>
                                            </div>
                                        </a> --}}
                                    </div>
                                </div>
                            @endif
                        </section>
                        @if ($date)
                            <div class="daily-attendance-report">
                                <div class=" d-flex justify-content-end">
                                    <a href="{{route('teacher-attendance-print', ['date'=>$date])}}" style="margin-right: 10px" class="btn btn-primary  mb-1" target="blank">Print</a>
                                </div>
                                @php
                                    $datee=$date.'-01';
                                    $today = Carbon::createFromFormat('Y-m-d', $datee);
                                    $month = Carbon::createFromFormat('Y-m-d', $datee)->format('Y-m-d')
                                    ;

                                        $dates = [];
                                        $holyArray=null;

                                        $holydays=HolidayRecode::whereYear('date',date('Y', strtotime($month)))->whereMonth('date',date('m', strtotime($month)))->get();
                                        foreach($holydays as $holy)
                                        {
                                            $holyArray=$holyArray.date('d',strtotime($holy->date)).',';
                                        }
                                        $weekend=null;
                                        for ($i = 1; $i < $today->daysInMonth + 1; ++$i) {
                                            if (!in_array($i, [$holyArray])) {
                                                if(Carbon::createFromDate($today->year, $today->month, $i)->isSaturday() || Carbon::createFromDate($today->year, $today->month, $i)->isSunday())
                                                {
                                                    $holyArray=$holyArray.$i.',';

                                                }
                                            }
                                        }

                                            $array=explode(',', $holyArray);
                                            for ($i = 1; $i < $today->daysInMonth + 1; ++$i) {
                                                if (!in_array($i, $array)) {
                                                    $dates[] = \Carbon\Carbon::createFromDate($today->year, $today->month, $i);
                                                }
                                            }
                                            // dd( $dates, $array, $holyArray,$weekend);


                                @endphp
                                <style>
                                    td {
                                        white-space: nowrap;

                                    }
                                </style>
                                <table class="table table-sm table-responsive table-bordered">
                                    <tr >
                                        <td colspan="{{2+count($dates)/2}}" style="background-color: #A9D18E;"><h1 class="text-center" style="margin-bottom:0; vertical-align:middle;font-size:21px"> Teacher Daily Attendance Sheet</h1></td>
                                        <td colspan="{{2+count($dates)/2}}">
                                          <h1  style="margin-bottom:0; vertical-align:middle;font-size:20px;text-align:center">{{date('d-F-Y', strtotime($today->firstOfMonth()))}} From {{date('d-F-Y', strtotime($today->lastOfMonth()))}} </h1>
                                        </td>
                                    </tr>
                                    <tr style="height: 70px;">
                                        <td style="background:#F8CBAD;">Rank</td>
                                        <td style="min-width: 150px !important;background:#F8CBAD;" class="text-center">Name</td>
                                        @foreach ($dates as $item)
                                            <td class="separate-color">{{ date('D', strtotime($item)) }} <br> {{ date('d', strtotime($item)) }}</td>
                                        @endforeach
                                        {{-- <td>Present</td>
                                        <td>Absent</td>
                                        <td>Percentage</td> --}}
                                    </tr>
                                    @foreach ($employees as  $key => $employee)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$employee->first_name}} {{$employee->middle_name}} {{$employee->last_name}}</td>
                                            @foreach ($dates as $item)
                                                @if ($a = App\EmployeeAttendance::where('date', date('Y-m-d', strtotime($item)))->where('employee_id', $employee->id)->first())
                                                    @if ($a->status==1)
                                                        <td class="text-center bg-success">P</td>
                                                    @else
                                                        <td  class="text-center bg-danger">A</td>
                                                    @endif
                                                @else
                                                    <td style="background-color: #efefef"></td>
                                                @endif
                                            @endforeach
                                            {{-- <td> {{count(App\EmployeeAttendance::whereDay('date', date('m', strtotime($item)))->whereIn('employee_id', function ($query) {
                                                $query->select('id')
                                                    ->from('employees')
                                                    ->where('role', 5);
                                            })->where('status',1)->where('employee_id', $employee->id)->get())}}</td>

                                        </tr> --}}
                                    @endforeach
                                    <tr>
                                        <td colspan="2" class="text-center text-danger" >Attendance</td>
                                        @foreach ($dates as $item)
                                        @php
                                             $present=App\EmployeeAttendance::where('date', date('Y-m-d', strtotime($item)))
                                                                ->leftjoin('employees','employees.id','=','employee_attendances.employee_id')
                                                                ->where('employees.division',6)
                                                                ->where('employee_attendances.status',1)
                                                                ->select('employee_attendances.*')
                                                                ->get();
                                        @endphp
                                            <td class=" text-center" style="background-color: #C5E0B4">
                                                {{count( $present)}}
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="text-center text-danger">Attendance %</td>
                                        @foreach ($dates as $item)
                                            <td class="bg-light text-center">
                                                @php
                                                $f = 0;
                                                    $entries=App\EmployeeAttendance::where('date', date('Y-m-d', strtotime($item)))
                                                                ->leftjoin('employees','employees.id','=','employee_attendances.employee_id')
                                                                ->where('employees.division',6)
                                                                ->select('employee_attendances.*')
                                                                ->get();
                                                    $present=App\EmployeeAttendance::where('date', date('Y-m-d', strtotime($item)))
                                                                ->leftjoin('employees','employees.id','=','employee_attendances.employee_id')
                                                                ->where('employees.division',6)
                                                                ->where('employee_attendances.status',1)
                                                                ->select('employee_attendances.*')
                                                                ->get();

                                                    $t =$entries->count();
                                                    $p =$present->count();
                                                    if($t>0){
                                                        $f = $p/$t;
                                                    }
                                                @endphp
                                                @if ($t>0)
                                                    {{number_format(($f)*100,1)}} %
                                                @else
                                                    0%
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .table .thead-light th {
        color:#F2F4F4 ;
        background-color: #34465b;
        border-color: #DFE3E7;
    }
    tr:nth-child(even) {
        background-color: #c8d6e357;
    }
</style>
<div class="modal fade bd-example-modal-lg" id="newEmployeeAttendance" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <section class="print-hideen border-bottom">
            <div class="d-flex flex-row-reverse">
                <div class="mIconStyleChange"><a href="#" class="close btn-icon btn btn-danger" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class='bx bx-x'></i></span></a></div>
                {{-- <div class="mIconStyleChange"><a href="#" class="btn btn-icon btn-success"><i class="bx bx-edit"></i></a></div>
                <div class="mIconStyleChange"><a href="#"  onclick="window.print();" class="btn btn-icon btn-secondary"><i class='bx bx-printer'></i></a></div>
                <div class="mIconStyleChange"><a href="#"  onclick="window.print();" class="btn btn-icon btn-primary"><i class='bx bxs-file-pdf'></i></a></div>
                <div class="mIconStyleChange"><a href="#"  onclick="window.print();" class="btn btn-icon btn-light"><i class='bx bxs-virus'></i></a></div> --}}
            </div>
        </section>
        @include('backend.tab-file.modal-header-info')
        <section id="basic-vertical-layouts">
            <div class="row match-height">
                <div class="col-md-12 col-12">
                    <div class="cardStyleChange">
                        <div class="card-body">
                            <form class="form form-vertical" action="{{route('employee-attendance.store')}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" id="check_new_date" class="form-control datepicker @error('date') error @enderror" placeholder="dd/mm/yyyy" name="date" value="{{ date('d/m/Y')}}" required>
                                                <small class="text-danger" id="holiday_message"></small>
                                                @error('date')
                                                <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <p class="text-right">
                                                <button type="button" class="btn btn-success present-all ">Present All</button>
                                                <button type="button" class="btn btn-success absent-all">Absent All</button>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table class="table mb-0 table-sm table-hover">
                                                    <thead  class="thead-light">
                                                        <tr class="text-center" style="height: 40px;">
                                                            <th>Name</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($employees as $employee)
                                                        <tr class="text-center trFontSize">
                                                            <td>{{ $employee->first_name.' '.$employee->middle_name.' '.$employee->last_name }}</td>
                                                            <td>
                                                                <ul class="list-unstyled mb-0">
                                                                    <li class="d-inline-block">
                                                                        <fieldset>
                                                                            <div class="radio">
                                                                                <input type="radio" class="present-status" name="status[{{$employee->id}}]" id="present-{{$employee->id}}" checked value="1" >
                                                                                <label for="present-{{$employee->id}}">Present</label>
                                                                            </div>
                                                                        </fieldset>
                                                                    </li>
                                                                    <li class="d-inline-block">
                                                                        <fieldset>
                                                                            <div class="radio">
                                                                                <input type="radio" class="absent-status" name="status[{{$employee->id}}]" id="absent-{{$employee->id}}" value="0">
                                                                                <label for="absent-{{$employee->id}}">Absent</label>
                                                                            </div>
                                                                        </fieldset>
                                                                    </li>
                                                                </ul>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div><br>
                                            <div class="row">
                                                <div class="col-12 d-flex justify-content-end">
                                                    <button type="submit" class="btn btn-primary mr-1">Save Attendance</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @include('backend.tab-file.modal-footer-info')
      </div>
    </div>
</div>
@endsection
@push('js')
<script>
    $(document).ready(function() {

        var date = $('#check_new_date').val();
        // alert(date);
        var _token = '{{csrf_token()}}';
        $.ajax({
            url:  '{{route("search-holiday-recode")}}',
            type: 'post',
            data: {
                date: date,
                _token: _token,
            },
            success:function(response){
                if(response){
                    $("#holiday_message").html(response.reason);
                    $("#check_new_date").val("");
                }else{
                    $("#holiday_message").html("");
                }
            }
        });
       // Page Script
       $('#st-class').change(function(){
           var class_id= $(this).val();
           var csrf_token= '{{ csrf_token()}}';
           $.ajax({
           url:  '{{route("get_sections")}}',
           dataType: 'json',
           type: 'post',
           data: {class_id: class_id, _token: csrf_token },
           success:function(response){

               var optionHtml= '<option> Select Section </option>';

               response.forEach(function(element, index) {
                   console.log(element);
                   optionHtml += "<option value='"+element.id +"'> "+ element.name+"</option>";
                });
                $('#st-section').html(optionHtml);
                console.log(optionHtml);
           }
           });
       });


       $('.present-all').click(function (event) {
               $('.present-status').prop('checked', true);
       });

       $('.absent-all').click(function (event) {
               $('.absent-status').prop('checked', true);
       });

    });

    $(document).on('change', '#check_new_date', function(e){
        var date = $(this).val();
        var _token = '{{csrf_token()}}';
        $.ajax({
            url:  '{{route("search-holiday-recode")}}',
            type: 'post',
            data: {
                date: date,
                _token: _token,
            },
            success:function(response){
                if(response){
                    $("#holiday_message").html(response.reason);
                    $("#check_new_date").val("");
                }else{
                    $("#holiday_message").html("");
                }
            }
        });
    })
</script>
@endpush
