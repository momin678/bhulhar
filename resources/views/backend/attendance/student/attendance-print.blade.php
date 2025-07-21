@extends('layouts.print_app')
@section('content')
<style>


    .td-class-0 {
            border-top: 1px solid #000000;
            border-bottom: 1px solid #000000;
            border-left: 1px solid #000000;
            border-right: 1px solid #000000;
            font-size: 12px;
            text-align: left;
            vertical-align: middle !important;
            width: 10%;



        }

        .td-class-1 {
            border-top: 1px solid #000000;
            border-bottom: 1px solid #000000;
            border-left: 1px solid #000000;
            border-right: 1px solid #000000;
            font-size: 16px;
            text-align: center;
            vertical-align: middle !important;



        }
       .td-class-1-1 {
        background-color:#A5A5A5;
        }
        .td-class-1-2 {
            background-color:#C5E0B4;
        }
        .td-class-2 {
            border-top: 1px solid #000000;
            border-bottom: 1px solid #000000;
            border-left: 1px solid #000000;
            border-right: 1px solid #000000;


        }
      .td-class-7-3 {
            vertical-align: middle;background-color:#C5E0B4;
        }
        .td-class-3 {
            border-top: 1px solid #000000;
            border-bottom: 1px solid #000000;
            border-left: 1px solid #000000;
            border-right: 1px solid #000000;


        }

        .td-class-4 {
            border-top: 1px solid #000000;
            border-bottom: 1px solid #000000;
            border-left: 1px solid #000000;


        }

        .td-class-5 {
            border-top: 1px solid #000000;
            border-bottom: 1px solid #000000;
            border-left: 1px solid #000000;
            border-right: 2px solid #000000;


        }

        .td-class-6 {
            border-top: 1px solid #000000;
            border-left: 1px solid #000000;
            border-right: 1px solid #000000;


        }

        .td-class-7 {
            border-bottom: 1px solid #000000;
            border-left: 1px solid #000000;
            border-right: 1px solid #000000;
            text-align: center
        }

        .td-class-8 {
            border-top: 1px solid #000000;
            border-bottom: 1px solid #000000;


        }

        .td-class-9 {
            text-align: left;
            vertical-align: middle;
            background-color: #f8cbad;
            font-size: 8px;


        }
        .mp {
            margin-left: -26px;
        }
        .td-class-7-1 {
            vertical-align: middle;background-color:#DBDBDB;
        }
        .td-class-7-2 {
            text-align:left;vertical-align:middle;
        }
        .td-class-9-1 {
            background-color:#F8CBAD;
        }
        .division-class {
            text-align: center;vertical-align:middle;
        }

    @media print{
        body {
            -webkit-print-color-adjust: exact !important;
        }

        .td-class-1-1 {
        background-color:#A5A5A5;
        }
        .td-class-1-2 {
            background-color:#C5E0B4;
        }
        tr td{
            font-size: 8px !important;
            padding: 0 !important;
            border: 1px solid black !important;
            color: black;
            background-color: inherit !important;

           background-clip: content-box;
        }

        .td-class-0 {
            border-top: 1px solid #000000;
            border-bottom: 1px solid #000000;
            border-left: 1px solid #000000;
            border-right: 1px solid #000000;
            font-size: 12px;
            text-align: left;
            vertical-align: middle !important;
            width: 10%;



        }

        .td-class-1 {
            border-top: 1px solid #000000;
            border-bottom: 1px solid #000000;
            border-left: 1px solid #000000;
            border-right: 1px solid #000000;
            font-size: 16px;
            text-align: center;
            vertical-align: middle !important;



        }

        .td-class-2 {
            border-top: 1px solid #000000;
            border-bottom: 1px solid #000000;
            border-left: 1px solid #000000;
            border-right: 1px solid #000000;


        }

        .td-class-3 {
            border-top: 1px solid #000000;
            border-bottom: 1px solid #000000;
            border-left: 1px solid #000000;
            border-right: 1px solid #000000;


        }

        .td-class-4 {
            border-top: 1px solid #000000;
            border-bottom: 1px solid #000000;
            border-left: 1px solid #000000;


        }

        .td-class-5 {
            border-top: 1px solid #000000;
            border-bottom: 1px solid #000000;
            border-left: 1px solid #000000;
            border-right: 2px solid #000000;


        }

        .td-class-6 {
            border-top: 1px solid #000000;
            border-left: 1px solid #000000;
            border-right: 1px solid #000000;


        }

        .td-class-7 {
            border-bottom: 1px solid #000000;
            border-left: 1px solid #000000;
            border-right: 1px solid #000000;
            text-align: center
        }

        .td-class-8 {
            border-top: 1px solid #000000;
            border-bottom: 1px solid #000000;


        }

        .td-class-9 {
            text-align: left;
            vertical-align: middle;
            background-color: #f8cbad;
            font-size: 8px;


        }
        .mp {
            margin-left: 0px;
        }
        @page {
            size: A4 landscape;
            width: 276mm;
        }
        .head-color {
            background-color:#A9D18E;height:35px;text-align:center;
        }


    }
    .head-color {
            background-color:#A9D18E;height:35px;text-align:center;
        }

</style>
@php
    use Carbon\Carbon;
@endphp

    <div class="daily-attendance-report mp">

        <table class="table table-sm table-bordered">
            <tr>
                <td class="head-color" colspan=22 ><b> STUDENTS ATTENDANCE LIST
                    ({{ date('M,Y', strtotime($today->firstOfMonth())) }})</b></td>
                <td class="division-class" colspan="9"><b> Grade:{{ App\StudentClass::find($class_id)->name }} Division:{{ App\Section::find($section_id)->name }} </b></td>


            </tr>
            <tr>
                <td class="td-class-1 td-class-9 " ><b>  SI NO</b></td>
                <td class="td-class-1 td-class-9 "><b> STUDENT NAME </b></td>
                <td class="td-class-1 td-class-9 "><b>FATHER NAME </b></td>
                <td class="td-class-1 td-class-9 "><b>STUDENT ID
                    </b></td> <td class="td-class-1 td-class-9 "><b>MOBILE NUMBER
                    </b></td>
                <td class="td-class-1 td-class-9 "><b>{{ date('Y', strtotime($date)) }} GRADE</b></td>


               @foreach ($dates as $key => $item)
               @php
                    $background = '';
                    if ($key <= 5) {
                        $background = '#DEEBF7';
                    } elseif ($key <= 10) {
                        $background = '#B4C7E7';
                    } elseif ($key <= 15) {
                        $background = '#6AA4D8';
                    } else {
                        $background = '#2E75B6';
                    }
                @endphp
                <td class="td-class-4" style="background:{{ $background }}; padding:5px !important"><b> {{ date('D', strtotime($item)) }} </b></td>
                @endforeach
                <td  class="td-class-1 td-class-9  td-class-9-1"><b> TOTAL ABSENT </b></td>
                <td  class="td-class-1 td-class-9  td-class-9-1"><b> TOTAL PRESENT </b></td>
                <td class="td-class-1 td-class-9 "><b>PERCENTAGE</b></td>
            </tr>

            <tr>
                <td class="td-class-6"><b><br></b></td>
                <td class="td-class-6"><b><br></b></td>
                <td class="td-class-6"><b><br></b></td>
                <td class="td-class-6"><b><br></b></td>
                <td class="td-class-6"><b><br></b></td>
                <td class="td-class-6"><b><br></b></td>
                @foreach ($dates as $key => $item)
                <td class="td-class-1"><b> {{ date('d', strtotime($item)) }}</b></td>
                @endforeach
                <td class="td-class-7"><b>  <br></b></td>
                <td class="td-class-7"><b>  </b></td>
                <td class="td-class-7-2"> <br></td>
            </tr>


          @foreach ($students as $key => $student)

            <tr>
                <td class="td-class-0"><b>{{ $key + 1 }} </b></td>
                <td class="td-class-0"><b> {{ $student->fname }}</b></td>
                <td class="td-class-0"> {{ $student->parent_profile->f_full_name }}</td>
                <td class="td-class-0">{{ $student->student_number }}</td>
                <td class="td-class-0"> {{ $student->permanent_telephone }}</td>
                <td class="td-class-0"><b> {{ $student->student_class_id?$student->className->name:'' }}@if(!empty($student->sectionName->name)){{ $student->sectionName->name}} @endif</b></td>

                    @foreach ($dates as $item)
                    @if ($a = App\StudentAttendance::where('date', date('Y-m-d', strtotime($item)))->where('student_id', $student->id)
                    ->where('student_class_id', $class_id)->where('section_id', $section_id)->first())
                        @if ($student->status== 2)
                       <td class="td-class-1 bg-primary" ><b>TC </b></td>
                        @elseif ($a->status == 1)
                        <td class="td-class-1 bg-success"><b> <span class="td-class-p ">P</span></b></td>
                        @elseif ($a->status == 2) <td class="text-center bg-warning">L</td>
                        @elseif ($a->status == 0)
                        <td class="td-class-1 bg-danger" ><b>A </b></td>

                        @elseif ($a->status == 4)
                        <td class="td-class-1 bg-info" ><b>SP </b></td>
                        @endif
                    @else
                        <td class="bg-light"></td>
                    @endif
                @endforeach
                <td class="td-class-7 td-class-7-1" >
                <b> {{$abs = App\StudentAttendance::whereYear('date', date('Y', strtotime($date)))->whereMonth('date', date('m', strtotime($date)))->where('status', 0)
                    ->where('student_id', $student->id)->where('student_class_id', $class_id)->where('section_id', $section_id)->count()}}
                   </b></td>
                <td class="td-class-7 td-class-7-3"><b>
                     {{$present = App\StudentAttendance::whereYear('date', date('Y', strtotime($date)))
                     ->whereMonth('date', date('m', strtotime($date)))
                     ->whereIn('status', [1, 2])
                     ->where('student_id', $student->id)
                     ->where('student_class_id', $class_id)
                     ->where('section_id', $section_id)
                     ->count()
                 }}</b></td>
                <td class="td-class-1 td-class-7-1 text-align:right" >@if($present > 0){{ number_format(($present / ($abs+$present)) * 100, 1) }}% @else 0% @endif </td>
            </tr>
            @endforeach
            <tr>
                <td class="td-class-4" colspan="6" style="text-align: left;vartical-align:middle; color:red"><b> TOTAL PRESENT </b></td>
                @foreach ($dates as $key => $item)

                <td class="td-class-1" style="vertical-align: middle;background-color:#A5A5A5;" >
                <b>{{$presentl = App\StudentAttendance::where('date', date('Y-m-d', strtotime($item)))->whereIn('status', [1, 2])->where('student_class_id', $class_id)->where('section_id', $section_id)->count() }}</b></td>
                @endforeach
                <td class="td-class-1  td-class-1-1"><b><br> </b></td>
                <td class="td-class-1  td-class-1-1"><b><br> </b></td>
                <td class="td-class-1  td-class-1-1"><b><br> </b></td>

            </tr>
            <tr>
                <td class="td-class-4"  colspan="6"style="text-align: left;vartical-align:middle; color:red"><b> TOTAL ABSENT</b></td>

                @foreach ($dates as $key => $item)

                <td class="td-class-1" style="text-align:center;background-color:#C5E0B4;" ><b>{{$presentd = App\StudentAttendance::where('date', date('Y-m-d', strtotime($item)))->where('status', 0)
                        ->where('student_class_id', $class_id)->where('section_id', $section_id)->count() }} </b></td>
                @endforeach
                <td class="td-class-1  td-class-1-2" ><b><br></b></td>
                <td class="td-class-1  td-class-1-2"><b><br></b></td>
                <td class="td-class-1  td-class-1-2"><b><br></b></td>

            </tr>
            <tr>
                <td class="td-class-4" colspan="6"style="text-align: left;vartical-align:middle; color:red;height:21px;"><b>TOTAL</b></td>
                @foreach ($dates as $key => $item)
                <td class="td-class-1  td-class-1-1"><b>{{$students->count()}}</b></td>
                 @endforeach
               <td class="td-class-1  td-class-1-1" ><b></b></td>
               <td class="td-class-1  td-class-1-1" ><b> </b></td>
               <td class="td-class-1  td-class-1-1" ><b></b></td>

            </tr>
        </table>
    </div>
@endsection
<div class="print-section-header" style="position: fixed; bottom: 0;">
    @include('layouts.backend.partial.modal-footer-info')
</div>
