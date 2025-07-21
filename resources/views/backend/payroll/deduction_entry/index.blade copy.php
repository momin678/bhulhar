@extends('backend.master')
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
                    <li class="breadcrumb-item `"><a href="#"> CUSTOMER RISK > SOURCE OF employee </a></li>
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
                        <ul class="nav nav-tabs nav-tabs-neutral" style="justify-content: space-between;" role="tablist"
                            data-background-color="orange">
                            <li class="nav-item tap-hed-menu tab-menu-style " style="float: left;">
                                DEDUCTION ENTRY </li>
                            <li class="nav-item">
                                <a class="nav-link tab-link active" style="float: right;"  href="{{route('deduction-entry.index')}}" role="tab">DEDUCITION ENTRY</a>
                            </li>
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
                                                    type="button"style="background:#4f0d32;margin-bottom: 5px;float: right;"
                                                    class=" btn btn-success add-line"
                                                    data-modal="#employee-modal">
                                                    ADD NEW
                                                    <i class="fa-solid fa-user-plus"></i>
                                                </button>
                                                {{-- <button
                                                    type="button"style="background:#96195f; margin-bottom: 5px;float: right;margin-right: 5px;"
                                                    class=" btn btn-success employee_file_uplod"> UPLOAD EXCEL
                                                    <i data-toggle="tooltip"
                                                        data-placement="bottom"title="UPLOAD EXCEL !!"
                                                        class="fa-solid fa-user-plus"></i>
                                                </button> --}}
                                                <form action="">
                                                    <div class="table-responsive "
                                                    style="height:75vh;max-height:75vh; overflow:auto;">

                                                        <table class="table table-bordered table-sm employee_change  " id="2filter-table">
                                                            <thead style="position:sticky; top:-9px;">
                                                                <tr>
                                                                    <th>EMP ID</th>
                                                                    <th>Name</th>
                                                                    <th>Division</th>
                                                                    <th>Description</th>
                                                                    <th>Amount</th>
                                                                    <th>Date</th>
                                                                    <th>Document</th>

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($items as $key => $data)
                                                                    <tr>
                                                                        <td style="width: 10%">{{ $data->items->emp_id }}</td>
                                                                        <td class="employee"
                                                                            data-modal="#employee-modal"
                                                                            data-id="{{ route('deduction-entry.edit',$data) }}"style="width: 18%">{{ $data->items->first_name.' '.$data->items->last_name }}</td>
                                                                        <td class="employee"
                                                                            data-modal="#employee-modal"
                                                                            data-id="{{ route('deduction-entry.edit',$data) }}"style="width: 13%">{{ $data->items->div_name->name }}</td>
                                                                        <td class="employee"
                                                                            data-modal="#employee-modal"
                                                                            data-id="{{ route('deduction-entry.edit',$data) }}"style="width: 18%">{{ $data->description }}</td>
                                                                        <td class="employee"
                                                                            data-modal="#employee-modal"
                                                                            data-id="{{ route('deduction-entry.edit',$data) }}"style="width: 18%">{{ $data->due }}</td>
                                                                        <td class="employee"
                                                                            data-modal="#employee-modal"
                                                                            data-id="{{ route('deduction-entry.edit',$data) }}"style="width: 13%">{{ date('d/m/Y', strtotime($data->date)) }}</td>
                                                                        <td class="employee"
                                                                            data-modal="#employee-modal"
                                                                            data-id="{{ route('deduction-entry.edit',$data) }}"style="width: 10%"><input class="form-control" type="file" name="file" style="background:#B4C6E7; height:35px"></td>
                                                                    </tr>
                                                                @endforeach
                                                                
                                                            </tbody>
                                                        </table>
                                                        <div class="from-body" style="margin-top: -10px">
                                                                        
                                                        </div>
                                                </div>
                                                </form>

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
<script src="{{ asset('assets/backend')}}/app-assets/vendors/js/forms/repeater/jquery.repeater.min.js"></script>
<script src="{{ asset('assets/backend')}}/app-assets/js/scripts/forms/form-repeater.js"></script>
    
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
{{-- parent --}}
<script>
    @if (count($errors) > 0)
        $('#parentProfileAdd').modal('show');
    @endif
    function printFunction(){ 
        window.print();
    }

    var i = 0;
    // add line
    $(document).on("click", '.add-line', function(event) {
        
        // alert(11);

        if (i==0) {
            $(".from-body").append('<form action="{{route('deduction-entry.store')}}" method="POST" enctype="multipart/form-data">@csrf<tr><td><input type="text" name="emp_name" id="emp_name" style="width: 10%;background:#B4C6E7"></td><td><select name="employee_id" id="employee_id" style="width: 18% !important;background:#B4C6E7; height: 34px" required><option value="">Select ...</option>@foreach ($employees as $employee)<option value="{{$employee->id}}">{{$employee->first_name.' '.$employee->last_name}}</option>@endforeach</select></td><td><select name="division" id="division" style="width: 13% !important;background:#B4C6E7; height: 34px" required><option value="">Select </option>@foreach ($divisions as $division)<option value="{{$division->id}}">{{$division->name}}</option>@endforeach</select></td><td><input type="text" name="description" style="width: 18%;background:#B4C6E7"></td><td><input type="number" name="amount" style="width: 18%;background:#B4C6E7; height:35px"></td><td><input type="text" name="date" placeholder="DD/MM/YY" id="datepickers" required style="width: 13%;background:#B4C6E7; height:35px"></td><td><input type="file" name="file" style="width: 10%;background:#B4C6E7; height:35px"></td></tr><button style="margin-top: 1px;" type="submit" class="btn mr-1 btn-primary formButton" title="Form Save"><div class="d-flex"><div><span> SUBMIT</span></div></div></button></form>'); 
        }
        i++;

    });
    //remove line
    $(document).on("click", '.remove-row', function(event) {
        // alert('I am there');
        $(this).parents(".start").remove();
    });

     //employee name select
     $(document).on("change", "#employee_id", function(e) {
                if ($(this).val() != '') {
                var emp = $(this).val();
                // alert(544654);
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('employee-name') }}",
                    method: "GET",
                    data: {
                        emp: emp,
                        _token: _token,
                    },
                    success: function(response) {
                            $("#emp_name").val(response.page.emp_id);
                            $("#division").val(response.page.division);
                    }
                })
            }
    });

    //end employee name select

    //employee id select start

    $(document).on("keyup", "#emp_name", function(e) {
                if ($(this).val() != '') {
                var emp = $(this).val();
                // alert(category);
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('employee-name') }}",
                    method: "GET",
                    data: {
                        id: emp,
                        _token: _token,
                    },
                    success: function(response) {
                        console.log(response);
                            $("#employee_id").val(response.page.id).change();
                            $("#division").val(response.page.division);
                        
                    }
                })
            }
    });
    //employee id select end

    //division select start
    $(document).on("change", "#division", function(e) {
                if ($(this).val() != '') {
                var emp = $(this).val();
                // alert(544654);
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('employee-name') }}",
                    method: "GET",
                    data: {
                        division: emp,
                        _token: _token,
                    },
                    success: function(response) {
                        // console.log(response);
                        var optionHtml= '<option> Select Division </option>';
                        response.page.forEach(function(element, index) {
                            optionHtml += "<option value='"+element.id +"'> "+ element.first_name+"</option>";
                            });
                            $('#employee_id').html(optionHtml);
                    }
                })
            }
    });
    //division select end


</script>
    <script>
        // Use the plugin once the DOM has been loaded.
        $(function() {
            // Apply the plugin

            $('#2filter-table').excelTableFilter();

        });

        // show inser modal for insert data
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });




    </script>

    @include('backend.payroll.deduction_entry.modal')

    @include('backend.payroll.deduction_entry.ajax')


    @endsection
