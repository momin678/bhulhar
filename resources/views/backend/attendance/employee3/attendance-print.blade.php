@extends('layouts.print_app')
@section('content')
<style>
    tr td{
        font-size: 10 px !important;
        padding: 0 !important;
        border: 1px solid black !important;
        color: black;
    }
    .separate-color:nth-child(1),
    .separate-color:nth-child(2){
        background: yellow !important;
    }
    .separate-color:nth-child(3),
    .separate-color:nth-child(8),
    .separate-color:nth-child(13),
    .separate-color:nth-child(18),
    .separate-color:nth-child(23),
    .separate-color:nth-child(28),
    .separate-color:nth-child(33){
        background: #f1d30d;
    }
    .separate-color:nth-child(4),
    .separate-color:nth-child(9),
    .separate-color:nth-child(14),
    .separate-color:nth-child(19),
    .separate-color:nth-child(24),
    .separate-color:nth-child(29){
        background: #0df17bad;
    }
    .separate-color:nth-child(5),
    .separate-color:nth-child(10),
    .separate-color:nth-child(15),
    .separate-color:nth-child(20),
    .separate-color:nth-child(25),
    .separate-color:nth-child(30){
        background: #f1640d7b;
    }
    .separate-color:nth-child(6),
    .separate-color:nth-child(11),
    .separate-color:nth-child(16),
    .separate-color:nth-child(21),
    .separate-color:nth-child(26),
    .separate-color:nth-child(31){
        background: #370df153;
    }
    .separate-color:nth-child(7),
    .separate-color:nth-child(12),
    .separate-color:nth-child(17),
    .separate-color:nth-child(22),
    .separate-color:nth-child(27),
    .separate-color:nth-child(32){
        background: #f10d3b2d;
    }
    .bg-light{
        background-color: #6e72752e !important;
    }
    .yellow-color{
        background: #ffff00 !important;
    }
    .black-color{
        height: 20px;
        background-color: #151414 !important;
    }
    @media print{
        tr td{
            font-size: 10 px !important;
            padding: 0 !important;
            border: 1px solid black !important;
            color: black;
        }
        .separate-color:nth-child(1),
        .separate-color:nth-child(2){
            background: yellow !important;
            -webkit-print-color-adjust: exact;
        }
        .separate-color:nth-child(3),
        .separate-color:nth-child(8),
        .separate-color:nth-child(13),
        .separate-color:nth-child(18),
        .separate-color:nth-child(23),
        .separate-color:nth-child(28),
        .separate-color:nth-child(33){
            background: #f1d30d !important;
            -webkit-print-color-adjust: exact;
        }
        .separate-color:nth-child(4),
        .separate-color:nth-child(9),
        .separate-color:nth-child(14),
        .separate-color:nth-child(19),
        .separate-color:nth-child(24),
        .separate-color:nth-child(29){
            background: #0df17bad !important;
            -webkit-print-color-adjust: exact;
        }
        .separate-color:nth-child(5),
        .separate-color:nth-child(10),
        .separate-color:nth-child(15),
        .separate-color:nth-child(20),
        .separate-color:nth-child(25),
        .separate-color:nth-child(30){
            background: #f1640d7b !important;
            -webkit-print-color-adjust: exact;
        }
        .separate-color:nth-child(6),
        .separate-color:nth-child(11),
        .separate-color:nth-child(16),
        .separate-color:nth-child(21),
        .separate-color:nth-child(26),
        .separate-color:nth-child(31){
            background: #370df153 !important;
            -webkit-print-color-adjust: exact;
        }
        .separate-color:nth-child(7),
        .separate-color:nth-child(12),
        .separate-color:nth-child(17),
        .separate-color:nth-child(22),
        .separate-color:nth-child(27),
        .separate-color:nth-child(32){
            background: #f10d3b2d !important;
            -webkit-print-color-adjust: exact;
        }
        .bg-light{
            background-color: #6e72752e !important;
            -webkit-print-color-adjust: exact;
        }
        .yellow-color{
            background-color: #ffff00 !important;
            -webkit-print-color-adjust: exact;
        }
        .black-color:nth-child(1){
            background: #1e1d1d !important;
            -webkit-print-color-adjust: exact;
        }
        .date_period:nth-child(1){
            background:#f1640d7b !important;
            -webkit-print-color-adjust: exact;
        }
        @page {
            size: A4 landscape;
            width: 276mm;
        }
    }
</style>
@php
    use Carbon\Carbon;
@endphp

<div class="daily-attendance-report">
    @php
        // $today = Carbon::now()->startOfMonth();
        $today = Carbon::createFromFormat('Y-m', $date);
        $dates = [];
        for($i=1; $i < $today->daysInMonth + 1; ++$i) {
            $dates[] = \Carbon\Carbon::createFromDate($today->year, $today->month, $i);
        }
    @endphp
    <table class="table table-sm table-bordered">
        <tr class="yellow-color">
            <td colspan="{{2+count($dates)}}" class="yellow-color">
                <h1 class="text-center yellow-color" style="margin-bottom:0;">Daily Attendance Sheet</h1>
            </td>
        </tr>
        <tr>
            <td colspan="{{2+count($dates)}}" class="black-color"></td>
        </tr>
        <tr style="height: 50px; background:#f1640d7b" class="text-center">
            <td colspan="{{2+count($dates)}}" class="date_period">
                <p class="text-center">Start Date Period
                    <br> {{date('d-F-Y', strtotime($today->firstOfMonth()))}} From {{date('d-F-Y', strtotime($today->lastOfMonth()))}}
                </p>
            </td>
        </tr>
        <tr class="black-color">
            <td colspan="{{2+count($dates)}}" class="black-color"></td>
        </tr>
        <tr style="height: 70px;">
            <td class="separate-color">Rank</td>
            <td class="text-center separate-color">Name</td>
            @foreach ($dates as $item)
                <td class="separate-color">Day {{ date('d', strtotime($item)) }}</td>
            @endforeach
        </tr>
        @foreach ($employees as  $key => $employee)
            <tr>
                <td class="text-center">{{$key+1}}</td>
                <td>{{$employee->salutation}} {{$employee->first_name}}</td>
                @foreach ($dates as $item)
                    @if ($a = App\EmployeeAttendance::where('date', date('Y-m-d', strtotime($item)))->where('employee_id', $employee->id)->first())
                        @if ($a->status==1)
                            <td class="text-center">&#10003;</td>
                        @else
                            <td></td>
                        @endif
                    @else
                        <td class="bg-light"></td>
                    @endif
                @endforeach
            </tr>
        @endforeach
        <tr>
            <td colspan="2" class="text-center separate-color">Attendace</td>
            @foreach ($dates as $item)
                <td class="bg-light text-center">
                    {{count(App\EmployeeAttendance::where('date', date('Y-m-d', strtotime($item)))->where('status',1)->get())}}
                </td>
            @endforeach
        </tr>
        <tr>
            <td colspan="2" class="text-center separate-color">Attendace %</td>
            @foreach ($dates as $item)
                <td class="bg-light text-center">
                    @php
                        $f = 0;
                        $a = App\EmployeeAttendance::where('date', date('Y-m-d', strtotime($item)))->where('status',1)->get();
                        if(count($a)>0){
                            $f = count($a)/count($employees);
                        }
                    @endphp
                    @if (count($a)>0)
                    {{number_format(($f)*100,1)}}
                    @else
                        0
                    @endif
                </td>
            @endforeach
        </tr>
    </table>
</div>
@endsection
