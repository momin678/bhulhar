
@extends('backend.master')
@php
    use Carbon\Carbon;
@endphp
@section('body')
    <style>

        .tab-menu-style {
            color: #000000;
            font-family: Roboto, sans-serif;
            font-weight: normal;
            font-size: 17px;
            FONT-WEIGHT: 600;
            margin-left: 3px;
            margin-right: 56px;
            text-transform: uppercase;
        }

        .modal_edit {
            cursor: pointer;
        }

        .modal-header {
            display: inline-block
        }

        .approv:hover {
            background: #96195F !important;
            color: #fff;
            cursor: pointer;
        }

        .category {
            text-transform: capitalize;
            font-weight: 700;
            color: #9A9A9A;
        }

        .dropdown-filter-content {
            margin-left: -61px
        }

        .modal-header {

            background: #e9e9e9;
        }

        .card .card-body,
        .flat-card .card-body {

            background: #F2F2F2;
        }

        .nav-item .nav-link,
        .nav-tabs .nav-link {
            -webkit-transition: all 300ms ease 0s;
            -moz-transition: all 300ms ease 0s;
            -o-transition: all 300ms ease 0s;
            -ms-transition: all 300ms ease 0s;
            transition: all 300ms ease 0s;
        }

        .now-ui-icons {
            display: inline-block;
            font: normal normal normal 14px/1 'Nucleo Outline';
            font-size: inherit;
            speak: none;
            text-transform: none;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        @-webkit-keyframes nc-icon-spin {
            0% {
                -webkit-transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @-moz-keyframes nc-icon-spin {
            0% {
                -moz-transform: rotate(0deg);
            }

            100% {
                -moz-transform: rotate(360deg);
            }
        }

        @keyframes nc-icon-spin {
            0% {
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        .now-ui-icons.objects_umbrella-13:before {
            content: "\ea5f";
        }

        .now-ui-icons.shopping_cart-simple:before {
            content: "\ea1d";
        }

        .now-ui-icons.shopping_shop:before {
            content: "\ea50";
        }

        .now-ui-icons.ui-2_settings-90:before {
            content: "\ea4b";
        }

        .nav-tabs {
            border: 0;
            padding: 15px 0.7rem;
        }

        .nav-tabs:not(.nav-tabs-neutral)>.nav-item>.nav-link.active {
            box-shadow: 0px 5px 35px 0px rgba(0, 0, 0, 0.3);
        }

        .card .nav-tabs {
            border-top-right-radius: 0.1875rem;
            border-top-left-radius: 0.1875rem;
        }

        .nav-tabs>.nav-item>.nav-link {
            color: #888888;
            margin: 0;
            margin-right: 5px;
            background-color: transparent;
            border: 1px solid transparent;
            border-radius: 30px;
            font-size: 14px;
            padding: 2px 15px;
            line-height: 1.5;
        }

        .nav-tabs>.nav-item>.nav-link:hover {
            background-color: transparent;
        }

        .nav-tabs>.nav-item>.nav-link.active {
            background-color: #444;
            border-radius: 30px;
            color: #FFFFFF;
        }

        .nav-tabs>.nav-item>.nav-link i.now-ui-icons {
            font-size: 14px;
            position: relative;
            top: 1px;
            margin-right: 3px;
        }

        .nav-tabs.nav-tabs-neutral>.nav-item>.nav-link {
            color: #FFFFFF;
        }

        .nav-tabs.nav-tabs-neutral>.nav-item>.nav-link.active {
            background-color: rgb(150 25 95);
            color: #FFFFFF;
        }

        .card {
            border: 0;
            border-radius: 0.1875rem;
            display: inline-block;
            position: relative;
            width: 100%;
            margin-bottom: 30px;
            box-shadow: 0px 5px 25px 0px rgba(0, 0, 0, 0.2);
        }

        .card .card-header {
            background-color: transparent;
            border-bottom: 0;
            background-color: transparent;
            border-radius: 0;
            padding: 0;
        }

        .card[data-background-color="orange"] {
            background-color: #cbcbcb;
        }

        .card[data-background-color="red"] {
            background-color: #FF3636;
        }

        .card[data-background-color="yellow"] {
            background-color: #FFB236;
        }

        .card[data-background-color="blue"] {
            background-color: #2CA8FF;
        }

        .card[data-background-color="green"] {
            background-color: #15b60d;
        }

        [data-background-color="orange"] {
            background-color: #cbcbcb;
        }

        [data-background-color="black"] {
            background-color: #2c2c2c;
        }

        [data-background-color]:not([data-background-color="gray"]) {
            color: #FFFFFF;
        }

        [data-background-color]:not([data-background-color="gray"]) p {
            color: #FFFFFF;
        }

        [data-background-color]:not([data-background-color="gray"]) a:not(.btn):not(.dropdown-item) {
            color: #000000;
        }

        [data-background-color]:not([data-background-color="gray"]) .nav-tabs>.nav-item>.nav-link i.now-ui-icons {
            color: #FFFFFF;
        }

        .btn, .btn-link.btn.btn-primary, .btn-link.btn.btn-secondary, .btn-link.btn.search-promo-link, .btn.btn-primary.btn-link-primary, .btn.btn-secondary.btn-link-primary, .btn.search-promo-link.btn-link-primary {
            padding: 14px 18px;
            padding: .8rem 1.8rem;
            line-height: 1;
        }
        @font-face {
            font-family: 'Nucleo Outline';
            src: url("https://github.com/creativetimofficial/now-ui-kit/blob/master/assets/fonts/nucleo-outline.eot");
            src: url("https://github.com/creativetimofficial/now-ui-kit/blob/master/assets/fonts/nucleo-outline.eot") format("embedded-opentype");
            src: url("https://raw.githack.com/creativetimofficial/now-ui-kit/master/assets/fonts/nucleo-outline.woff2");
            font-weight: normal;
            font-style: normal;

        }

        .now-ui-icons {
            display: inline-block;
            font: normal normal normal 14px/1 'Nucleo Outline';
            font-size: inherit;
            speak: none;
            text-transform: none;
            /* Better Font Rendering */
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }


        footer {
            margin-top: 50px;
            color: #555;
            background: #fff;
            padding: 25px;
            font-weight: 300;
            background: #f7f7f7;

        }

        .footer p {
            margin-bottom: 0;
        }

        footer p a {
            color: #555;
            font-weight: 400;
        }

        footer p a:hover {
            color: #e86c42;
        }

        @media screen and (max-width: 768px) {

            .nav-tabs {
                display: inline-block;
                width: 100%;
                padding-left: 100px;
                padding-right: 100px;
                text-align: center;
            }

            .nav-tabs .nav-item>.nav-link {
                margin-bottom: 5px;
            }

            .tap-hed-menu {}
        }
    </style>
    <nav aria-label="breadcrumb" style="background-color: #96195F !important;">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <ol class="breadcrumb text-right">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">HOME > </a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">RISK MANAGEMENT FRAMEWORK > </a></li>
                    <li class="breadcrumb-item `"><a href="#"> ML / FT RISK FACTORS > </a></li>
                    <li class="breadcrumb-item `"><a href="#"> CUSTOMER RISK > SOURCE OF EMPLOYEE </a></li>
                </ol>
            </div>
            <div class="col-md-2"></div>
        </div>

    </nav>
    <div class="container mt-5">
        <div class="row">
    <div class="col-md-12 col-xl-12 ">
                <!-- Tabs with Background on Card -->
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs nav-tabs-neutral justify-content-center" role="tablist"
                            data-background-color="orange">
                            <li class="nav-item tap-hed-menu tab-menu-style">
                                ATTENDANCE </li>
                        </ul>
                    </div>
                    <!-- Tab panes -->
                    <div class="tab-content text-center">

                {{-- *************************** employee table end in here *************************** --}}
                        <div class="tab-pane active" id="" role="tabpanel">
                            <div class="app-content content p-2 container-fluid ">
                                <div class="content-wrapper">
                                    <div class="content-body">

                                        <div class="row mt-5" id="table-bordered">
                                            <div class="col-md-1"></div>

                                            <div class="col-md-10">
                                                <button
                                                    type="button"style="background:#808080;margin-bottom: 5px;float: right;padding: 0.8rem 1.8re; font-weight: bold:"
                                                    class=" btn btn-success employee_modal_open"
                                                    data-modal="#payslip-modal">
                                                    TAKE ATTENDANCE
                                                    <i class="fa-solid fa-file"></i>
                                                </button>
                                                
                                                <button
                                                    type="button"style="background:#808080;margin-bottom: 5px; margin-right: 5px;padding: 0.8rem 1.8re; float: right; font-weight: bold:"
                                                    class=" btn btn-success attendence_modal"
                                                    data-modal="#search-modal">
                                                    ATTENDANCE SHEET
                                                    <i class="fa-solid fa-file"></i>
                                                </button>
                                                {{-- <button
                                                    type="button"style="background:#96195f; margin-bottom: 5px;float: right;margin-right: 5px;"
                                                    class=" btn btn-success employee_file_uplod"> UPLOAD EXCEL
                                                    <i data-toggle="tooltip"
                                                        data-placement="bottom"title="UPLOAD EXCEL !!"
                                                        class="fa-solid fa-user-plus"></i>
                                                </button> --}}
                                                <div class="table-responsive "
                                                    style="height:75vh;max-height:75vh; overflow:auto;">

                                                    <div>
                                                        @if ($date)
                                                            <div class="daily-attendance-report">
                                                                <div class=" d-flex justify-content-end">
                                                                    <a href="" class="btn btn-primary mr-1 mb-1" target="blank">Print</a>
                                                                </div>
                                                                @php
                                                                    $employees= App\Models\Payroll\Employee::get();
                                                                    // $today = Carbon::now()->startOfMonth(); 
                                                                    $today = Carbon::createFromFormat('Y-m', $date);
                                                                    $dates = []; 
                                                                    for($i=1; $i < $today->daysInMonth + 1; ++$i) {
                                                                        $dates[] = \Carbon\Carbon::createFromDate($today->year, $today->month, $i);
                                                                    }
                                                                @endphp
                                                                <table class="table table-sm table-responsive table-bordered">
                                                                    <tr style="background:yellow;">
                                                                        <td colspan="{{2+count($dates)}}"><h1 class="text-center" style="margin-bottom:0;">Daily Attendance Sheet</h1></td>
                                                                    </tr>
                                                                    <tr style="height: 20px; background-color: black;">
                                                                        <td colspan="{{2+count($dates)}}"></td>
                                                                    </tr>
                                                                    <tr style="height: 50px; background:#f1640d7b" class="text-center">
                                                                        <td colspan="{{2+count($dates)}}">
                                                                            <p class="text-center">Start Date Period 
                                                                                <br> {{date('d-F-Y', strtotime($today->firstOfMonth()))}} From {{date('d-F-Y', strtotime($today->lastOfMonth()))}}
                                                                            </p>
                                                                        </td>
                                                                    </tr>
                                                                    <tr style="height: 20px; background-color: black;">
                                                                        <td colspan="{{2+count($dates)}}"></td>
                                                                    </tr>
                                                                    <tr style="height: 70px;">
                                                                        <td style="background:yellow;">Rank</td>
                                                                        <td style="min-width: 150px !important;background:yellow;" class="text-center">Name</td>
                                                                        @foreach ($dates as $item)
                                                                            <td class="separate-color">Day {{ date('d', strtotime($item)) }}</td>
                                                                        @endforeach
                                                                    </tr>
                                                                    @foreach ($employees as  $key => $employee)
                                                                        <tr>
                                                                            <td>{{$key+1}}</td>
                                                                            <td>{{$employee->fname}}</td>
                                                                            @foreach ($dates as $item)
                                                                                @if ($a = App\Models\Payroll\EmployeeAttendence::where('date', date('Y-m-d', strtotime($item)))->where('employee_id', $employee->id)->first())
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
                                                                        <td colspan="2" class="text-center" style="background:yellow;">Attendace</td>
                                                                        @foreach ($dates as $item)
                                                                            <td class="bg-light text-center">
                                                                                {{count(App\Models\Payroll\EmployeeAttendence::where('date', date('Y-m-d', strtotime($item)))->where('status',1)->get())}}
                                                                            </td>
                                                                        @endforeach
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" class="text-center" style="background:yellow;">Attendace %</td>
                                                                        @foreach ($dates as $item)
                                                                            <td class="bg-light text-center">
                                                                                @php
                                                                                $f = 0;
                                                                                    $a = App\Models\Payroll\EmployeeAttendence::where('date', date('Y-m-d', strtotime($item)))->where('status',1)->get();
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
                                                        @endif
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-1"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- *************************** employee table end in here *************************** --}}

                    </div>
                    <!-- End Tabs on plain Card -->
                </div>
            </div>
        </div>
    </div>
    
@include('backend.payroll.attendence.modal')

<script src="{{ asset('assets/backend')}}/app-assets/vendors/js/forms/repeater/jquery.repeater.min.js"></script>
<script src="{{ asset('assets/backend')}}/app-assets/js/scripts/forms/form-repeater.js"></script>

<script>
    // Use the plugin once the DOM has been loaded.
    $(function() {
        
        // Apply the plugin
        $('.3filter-table').excelTableFilter();
        $('#3filter-table').excelTableFilter();

    });

    // show inser modal for insert data
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

<script type='text/javascript'>
    //CheckAll checkbox 
    $('body').on('click','#checkall',function(){
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

</script>


@include('backend.payroll.attendence.ajax')
@endsection
