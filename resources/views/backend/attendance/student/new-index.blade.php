@extends('layouts.backend.app')
@section('content')
    @include('backend.tab-file.style')
    <style>
        tr td {
            font-size: 12 px !important;
            padding: 2px !important;
            border: 1px solid black !important;
            color: black;
        }

        .separate-color:nth-child(3),
        .separate-color:nth-child(8),
        .separate-color:nth-child(13),
        .separate-color:nth-child(18),
        .separate-color:nth-child(23),
        .separate-color:nth-child(28) {
            background: #F9F3CC;
        }

        .separate-color:nth-child(4),
        .separate-color:nth-child(9),
        .separate-color:nth-child(14),
        .separate-color:nth-child(19),
        .separate-color:nth-child(24),
        .separate-color:nth-child(29) {
            background: #D2E0FB;
        }

        .separate-color:nth-child(5),
        .separate-color:nth-child(10),
        .separate-color:nth-child(15),
        .separate-color:nth-child(20),
        .separate-color:nth-child(25),
        .separate-color:nth-child(30) {
            background: #D7E5CA;
        }

        .separate-color:nth-child(6),
        .separate-color:nth-child(11),
        .separate-color:nth-child(16),
        .separate-color:nth-child(21),
        .separate-color:nth-child(26),
        .separate-color:nth-child(31) {
            background: #370df153;
        }

        .separate-color:nth-child(7),
        .separate-color:nth-child(12),
        .separate-color:nth-child(17),
        .separate-color:nth-child(22),
        .separate-color:nth-child(27),
        .separate-color:nth-child(32) {
            background: #f10d3b2d;
        }

        .bg-light {
            background: #6e72752e !important;
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
            border-right: 1px solid #000000
        }

        .td-class-3 {
            border-top: 1px solid #000000;
            border-bottom: 1px solid #000000;
            border-left: 1px solid #000000;
            border-right: 1px solid #000000
        }

        .td-class-4 {
            border-top: 1px solid #000000;
            border-bottom: 1px solid #000000;
            border-left: 1px solid #000000
        }

        .td-class-5 {
            border-top: 1px solid #000000;
            border-bottom: 1px solid #000000;
            border-left: 1px solid #000000;
            border-right: 2px solid #000000
        }

        .td-class-6 {
            border-top: 1px solid #000000;
            border-left: 1px solid #000000;
            border-right: 1px solid #000000
        }

        .td-class-7 {
            border-bottom: 1px solid #000000;
            border-left: 1px solid #000000;
            border-right: 1px solid #000000;
            text-align: center
        }

        .td-class-8 {
            border-top: 1px solid #000000;
            border-bottom: 1px solid #000000
        }

        .td-class-9 {
            text-align: left;
            vertical-align: middle;
            background: #f8cbad;
            font-size: 14px
        }
    </style>
    @php
        use Carbon\Carbon;

    @endphp
    <div class="app-content content print-hideen">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                @include('clientReport.studentParentManagement._header', [
                    'activeMenu' => 'student_attendance',
                ])
                <div class="tab-content bg-white">
                    <div id="studentProfileList" class="tab-pane active p-2">
                        <div class="content-body">
                            @include('clientReport.studentParentManagement._attendance_submenu', [
                                'activeMenu' => 'student_attendance',
                            ])
                            <form class="form form-vertical" enctype="multipart/form-data">
                                <section id="basic-vertical-layouts">
                                    <div class="row match-height">
                                        <div class="col-md-12 col-12">
                                            <div class="cardStyleChange">
                                                <div class="card-body mt-1 pt-0">
                                                    <div class="form-body">
                                                        <div class="row">
                                                            <div class="col-md-2 col-12">
                                                                <div class="form-group">
                                                                    <label for="date">Month <span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="month" id="date"
                                                                        class="inputFieldHeight form-control" name="date"
                                                                        required>
                                                                    @error('date')
                                                                        <span class="error">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3 col-12">
                                                                <div class="form-group">
                                                                    <label for="st-class">Grade <span
                                                                            class="text-danger">*</span></label>
                                                                    <select class="inputFieldHeight form-control"
                                                                        id="st-class" name="class_name" required>
                                                                        <option value="">Select Grade</option>
                                                                        @foreach ($st_classes as $class_item)
                                                                            <option value="{{ $class_item->id }}"
                                                                                {{ isset($inputs) ? ($inputs['class_name'] == $class_item->id ? 'selected' : '') : '' }}>
                                                                                {{ $class_item->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('class_name')
                                                                        <span class="error">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-12">
                                                                <div class="form-group">
                                                                    <label for="st-section">Division <span
                                                                            class="text-danger">*</span></label>
                                                                    <select id="st-section"
                                                                        class="inputFieldHeight form-control @error('section') error @enderror"
                                                                        name="section" required>

                                                                        @isset($inputs)
                                                                            <option value="{{ $inputs['section']->id }}">
                                                                                {{ $inputs['section']->name }}</option>
                                                                        @else
                                                                            <option value="">Select Division</option>
                                                                        @endisset
                                                                    </select>
                                                                    @error('section')
                                                                        <span class="error">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <button type="submit"
                                                                    class="btn btn-primary mSearchingBotton formButton mt-2 mb-2"
                                                                    title="Search">
                                                                    <div class="d-flex">
                                                                        <div class="formSaveIcon">
                                                                            <img src="http://localhost/Office/beps-latest/assets/backend/app-assets/icon/searching-icon.png"
                                                                                width="25">
                                                                        </div>
                                                                        <div><span> Search</span></div>
                                                                    </div>
                                                                </button>
                                                            </div>
                                                            <div
                                                                class="col-md-3 text-right col-right-padding d-flex align-items-center justify-content-end">
                                                                <button type="button"
                                                                    class="btn btn-primary btn_create formButton mt-1"
                                                                    title="Add" data-toggle="modal"
                                                                    data-target="#newStudentAttendance">
                                                                    <div class="d-flex">
                                                                        <div class="formSaveIcon">
                                                                            <img src="{{ asset('assets/backend/app-assets/icon/add-icon.png') }}"
                                                                                width="25">
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
                                </section>
                            </form>
                            @if ($date && $class_id && $section_id)
                                <div class="daily-attendance-report">
                                    <div class=" d-flex justify-content-end">
                                        <a href="{{ route('student-attendance-print', ['date' => $date, 'class' => $class_id, 'section' => $section_id]) }}"
                                            class="btn btn-primary mr-1 mb-1" target="blank">Print</a>
                                    </div>

                                    <table class="table table-sm table-responsive table-bordered w-100">


                                        <tr>
                                            <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000"
                                                colspan="22 "height="65" align="middle" bgcolor="#A9D18E"><b> STUDENTS
                                                    ATTENDANCE LIST
                                                    ({{ date('M,Y', strtotime($today->firstOfMonth())) }})</b></td>
                                            <td colspan="9" align="middle" valign=middle><b>
                                                    Grade:{{ App\StudentClass::find($class_id)->name }}
                                                    Division:{{ App\Section::find($section_id)->name }} </b></td>


                                        </tr>
                                        <tr>
                                            <td class="td-class-1 td-class-9 "><b> SI NO</b></td>
                                            <td class="td-class-1 td-class-9 "><b> STUDENT NAME </b></td>
                                            <td class="td-class-1 td-class-9 "><b>FATHER NAME </b></td>
                                            <td class="td-class-1 td-class-9 "><b>STUDENT ID
                                                </b></td>
                                            <td class="td-class-1 td-class-9 "><b>MOBILE NUMBER
                                                </b></td>
                                            <td class="td-class-1 td-class-9 "><b>{{ date('Y', strtotime($date)) }}
                                                    GRADE</b></td>


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
                                                <td class="td-class-4"
                                                    style="background:{{ $background }}; padding:10px !important"><b>
                                                        {{ date('D', strtotime($item)) }} </b></td>
                                            @endforeach
                                            <td style="border-top: 1px solid #000000; border-right: 1px solid #000000"
                                                bgcolor="#F8CBAD"><b> TOTAL ABSENT </b></td>
                                            <td style="border-top: 1px solid #000000; border-left: 1px solid #000000"
                                                bgcolor="#F8CBAD"><b> TOTAL PRESENT </b></td>
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
                                                <td class="td-class-1" sdval="1" sdnum="1033;"><b>
                                                        {{ date('d', strtotime($item)) }}</b></td>

                                            @endforeach
                                            <td class="td-class-7"><b> <br></b></td>
                                            <td class="td-class-7" sdval="20" sdnum="1033;"><b> </b></td>
                                            <td align="left" valign=middle> <br></td>
                                        </tr>


                                        @foreach ($students as $key => $student)
                                            <tr>
                                                <td class="td-class-0"><b>{{ $key + 1 }} </b></td>
                                                <td class="td-class-0"><b> {{ $student->fname }}</b></td>
                                                <td class="td-class-0"> {{ $student->parent_profile->f_full_name }}</td>
                                                <td class="td-class-0">{{ $student->student_number }}</td>
                                                <td class="td-class-0"> {{ $student->permanent_telephone }}</td>
                                                <td class="td-class-0"><b>
                                                        {{ $student->student_class_id ? $student->className->name : '' }}
                                                        @if (!empty($student->sectionName->name))
                                                            {{ $student->sectionName->name }}
                                                        @endif
                                                    </b></td>

                                                @foreach ($dates as $item)
                                                    @if ($a = App\StudentAttendance::where('date', date('Y-m-d', strtotime($item)))->where('student_id', $student->id)->where('student_class_id', $class_id)->where('section_id', $section_id)->first())

                                                        @if ($a->status == 1)
                                                            <td class="td-class-1 bg-success"><b> <span
                                                                        class="td-class-p ">P</span></b></td>
                                                        @elseif ($a->status == 2)
                                                            <td class="text-center bg-warning">L</td>
                                                        @elseif ($a->status == 0)
                                                            <td class="td-class-1 bg-danger"><b>A </b></td>
                                                        @elseif ($a->status == 4)
                                                            <td class="td-class-1 bg-info"><b>SP </b></td>
                                                        @endif

                                                    @elseif ($student->status == 2)
                                                    <td class="td-class-1 text-danger"><b>TC </b></td>
                                                    @else
                                                    <td class="bg-light"></td>
                                                    @endif
                                                @endforeach
                                                <td class="td-class-7" valign=middle bgcolor="#DBDBDB" sdval="18"
                                                    sdnum="1033;"><b>
                                                        {{ $abs = App\StudentAttendance::whereYear('date', date('Y', strtotime($date)))->whereMonth('date', date('m', strtotime($date)))->where('status', 0)->where('student_id', $student->id)->where('student_class_id', $class_id)->where('section_id', $section_id)->count() }}
                                                    </b></td>
                                                <td class="td-class-7" bgcolor="#C5E0B4" valign=middle><b>
                                                        {{ $present = App\StudentAttendance::whereYear('date', date('Y', strtotime($date)))->whereMonth('date', date('m', strtotime($date)))->whereIn('status', [1, 2])->where('student_id', $student->id)->where('student_class_id', $class_id)->where('section_id', $section_id)->count() }}</b>
                                                </td>
                                                @php
                                                    $total_present=($abs + $present) > 0?  ($abs + $present):1;
                                                @endphp
                                                <td class="td-class-1" align="right" valign=middle bgcolor="#DBDBDB">
                                                    @if($present > 0){{ number_format(($present / ($abs+$present)) * 100, 1) }}% @else 0% @endif </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td class="td-class-4"
                                                colspan="6"style="text-align: left;vartical-align:middle; color:red"><b>
                                                    TOTAL PRESENT </b></td>
                                            @foreach ($dates as $key => $item)
                                                <td class="td-class-1" bgcolor="#A5A5A5" sdval="12" sdnum="1033;">
                                                    <b>{{ $presentl = App\StudentAttendance::where('date', date('Y-m-d', strtotime($item)))->whereIn('status', [1, 2])->where('student_class_id', $class_id)->where('section_id', $section_id)->count() }}</b>
                                                </td>
                                            @endforeach
                                            <td class="td-class-1" bgcolor="#A5A5A5"><b><br> </b></td>
                                            <td class="td-class-1" bgcolor="#A5A5A5"><b><br> </b></td>
                                            <td class="td-class-1" bgcolor="#A5A5A5"><b><br> </b></td>

                                        </tr>
                                        <tr>
                                            <td class="td-class-4"
                                                colspan="6"style="text-align: left;vartical-align:middle; color:red"><b>
                                                    TOTAL ABSENT</b></td>

                                            @foreach ($dates as $key => $item)
                                                <td class="td-class-1"
                                                    style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; text-align:center;"
                                                    bgcolor="#C5E0B4" sdval="1" sdnum="1033;">
                                                    <b>{{ $presentd = App\StudentAttendance::where('date', date('Y-m-d', strtotime($item)))->where('status', 0)->where('student_class_id', $class_id)->where('section_id', $section_id)->count() }}
                                                    </b></td>
                                            @endforeach
                                            <td class="td-class-1" bgcolor="#C5E0B4"><b><br></b></td>
                                            <td class="td-class-1" bgcolor="#C5E0B4"><b><br></b></td>
                                            <td class="td-class-1" bgcolor="#C5E0B4"><b><br></b></td>

                                        </tr>
                                        <tr>
                                            <td class="td-class-4" height="21"
                                                colspan="6"style="text-align: left;vartical-align:middle; color:red">
                                                <b>TOTAL</b></td>
                                            @foreach ($dates as $key => $item)
                                                <td class="td-class-1" bgcolor="#A5A5A5" sdval="13" sdnum="1033;">
                                                    <b>{{ $students->count() }}</b></td>
                                            @endforeach
                                            <td class="td-class-1" bgcolor="#A5A5A5" sdval="0" sdnum="1033;">
                                                <b></b></td>
                                            <td class="td-class-1" bgcolor="#A5A5A5" sdval="0" sdnum="1033;"><b>
                                                </b></td>
                                            <td class="td-class-1" bgcolor="#A5A5A5" sdval="0" sdnum="1033;">
                                                <b></b></td>

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
    <div class="modal fade bd-example-modal-lg" id="newStudentAttendance" tabindex="-1" rrole="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <section class="print-hideen border-bottom">
                    <div class="d-flex flex-row-reverse">
                        <div class="mIconStyleChange"><a href="#" class="close btn-icon btn btn-danger"
                                data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i
                                        class='bx bx-x'></i></span></a></div>
                        {{-- <div class="mIconStyleChange"><a href="#" class="btn btn-icon btn-success"><i class="bx bx-edit"></i></a></div>
                <div class="mIconStyleChange"><a href="#"  onclick="window.print();" class="btn btn-icon btn-secondary"><i class='bx bx-printer'></i></a></div>
                <div class="mIconStyleChange"><a href="#"  onclick="window.print();" class="btn btn-icon btn-primary"><i class='bx bxs-file-pdf'></i></a></div>
                <div class="mIconStyleChange"><a href="#"  onclick="window.print();" class="btn btn-icon btn-light"><i class='bx bxs-virus'></i></a></div> --}}
                    </div>
                </section>
                @include('backend.tab-file.modal-header-info')

                <!-- Basic Vertical form layout section start -->
                <section id="basic-vertical-layouts">
                    <div class="row match-height">
                        <div class="col-md-12 col-12">
                            <div class="cardStyleChange">
                                <h4 class="ml-2">Student Attendance</h4>
                                <div class="card-body">
                                    <form class="form form-vertical" action="{{ route('get_students') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-4 col-12">
                                                    <div class="form-group">
                                                        <label for="date">Date <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" id="date_name"
                                                            class="inputFieldHeight datepicker form-control @error('date') error @enderror"
                                                            name="date" autocomplete="off" placeholder="  DD/MM/YY"
                                                            value="{{date('d/m/Y')}}" required>
                                                        <small class="text-danger" id="holiday_message"></small>
                                                        @error('date')
                                                            <span class="error">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-12">
                                                    <div class="form-group">
                                                        <label for="st-class">Grade <span
                                                                class="text-danger">*</span></label>
                                                        <select id="st-class-two"
                                                            class="inputFieldHeight form-control @error('class_name') error @enderror"
                                                            name="class_name" required>
                                                            <option>Select Grade</option>
                                                            @foreach ($st_classes as $class_item)
                                                                <option value="{{ $class_item->id }}">
                                                                    {{ $class_item->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('class_name')
                                                            <span class="error">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-12">
                                                    <div class="form-group">
                                                        <label for="st-section">Division <span
                                                                class="text-danger">*</span></label>
                                                        <select id="st-section-two"
                                                            class="inputFieldHeight form-control @error('section') error @enderror"
                                                            name="section" required>
                                                            <option>Select Division</option>
                                                        </select>
                                                        @error('section')
                                                            <span class="error">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-12 d-flex justify-content-end">
                                                    <button type="tutton"
                                                        class="btn btn-primary formButton mSearchingBotton"
                                                        title="Searching" id="SearchButton">
                                                        <div class="d-flex">
                                                            <div class="formSaveIcon">
                                                                <img src="{{ asset('assets/backend/app-assets/icon/searching-icon.png') }}"
                                                                    alt="" srcset="" width="20">
                                                            </div>
                                                            <div><span> Search</span></div>
                                                        </div>
                                                    </button>
                                                </div>

                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="searchStudentAttendaceResultShow">

                    </div>
                </section>
                @include('backend.tab-file.modal-footer-info')
            </div>
        </div>
    </div>
@endsection
@push('js')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script type="text/javascript">
        $(function() {
            $(".datepicker").datepicker({
                dateFormat: "dd/mm/yy"
            }).val()
        });
    </script>
    <script>

var date = $('#date_name').val();
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
                    $("#date_name").val("");
                }else{
                    $("#holiday_message").html("");
                }
            }
        });


        $(document).ready(function() {
            $('#st-class').change(function() {
                var class_id = $(this).val();
                var csrf_token = '{{ csrf_token() }}';
                $.ajax({
                    url: '{{ route('get_sections') }}',
                    dataType: 'json',
                    type: 'post',
                    data: {
                        class_id: class_id,
                        _token: csrf_token
                    },
                    success: function(response) {
                        var optionHtml = '<option value> Select Division </option>';
                        response.forEach(function(element, index) {
                            optionHtml += "<option value='" + element.id + "'> " +
                                element.name + "</option>";
                        });
                        $('#st-section').html(optionHtml);
                    }
                });
            });
            $(document).on("change", "#st-class-two", function(e) {
                var class_id = $(this).val();
                var csrf_token = '{{ csrf_token() }}';
                $.ajax({
                    url: '{{ route('get_sections') }}',
                    dataType: 'json',
                    type: 'post',
                    data: {
                        class_id: class_id,
                        _token: csrf_token
                    },
                    success: function(response) {
                        var optionHtml = '<option value> Select Division </option>';
                        response.forEach(function(element, index) {
                            optionHtml += "<option value='" + element.id + "'> " +
                                element.name + "</option>";
                        });
                        $('#st-section-two').html(optionHtml);
                    }
                });
            });
            $(document).on("click", ".present-all", function(e) {
                $('.present-status').prop('checked', true);
                $('.set-new-class').addClass('d-none');
            })
            $(document).on("click", ".absent-all", function(e) {
                $('.absent-status').prop('checked', true);
                $('.set-new-class').addClass('d-none');
            })
            $(document).on("click", "#SearchButton", function(e) {
                e.preventDefault();
                var csrf_token = '{{ csrf_token() }}';
                var c_id = document.getElementById("st-class-two");
                var class_id = c_id.value;
                var s_id = document.getElementById("st-section-two");
                var section_id = s_id.value;
                var date = document.getElementById('date_name').value;
                if (date == '') {
                    alert('Please select date')
                } else {
                    $.ajax({
                        url: '{{ route('search-student-attendace') }}',
                        type: 'post',
                        data: {
                            class_id: class_id,
                            section_id: section_id,
                            date: date,
                            _token: csrf_token
                        },
                        success: function(response) {
                            document.getElementById("searchStudentAttendaceResultShow")
                                .innerHTML = response;
                        }
                    });
                }
            });
        });
        // $(document).on('click', '.radio', function(){
        //     let dataId = $(this).attr("data-id");
        //     var id = dataId.slice(8)
        //     var time = 'time-'+id
        //     var reason = 'reason-'+id
        // })
        $(document).on('click', '.remove-time-reason', function(e) {
            var _obj = $(this).closest('.trFontSize').find('.d-none').removeClass('d-none');
        });
        $(document).on('click', '.set-time-reason', function(e) {
            var _obj = $(this).closest('.trFontSize').find('.set-new-class').addClass('d-none');
        });
        $(document).on('change', '#date_name', function(e) {
            var date = $(this).val();
            var _token = '{{ csrf_token() }}';
            $.ajax({
                url: '{{ route('search-holiday-recode') }}',
                type: 'post',
                data: {
                    date: date,
                    _token: _token,
                },
                success: function(response) {
                    if (response == 'Weekend') {
                        $("#holiday_message").html(response);
                        $("#date_name").val("");
                    } else {
                        if (response) {
                            $("#holiday_message").html(response.reason);
                            $("#date_name").val("");
                        } else {
                            $("#holiday_message").html("");
                        }
                    }
                }
            });
        })
    </script>
@endpush
