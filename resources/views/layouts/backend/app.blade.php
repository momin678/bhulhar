<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="Frest admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Frest admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
    $settings= \App\Setting::where('config_name', 'title_name')->first()
    @endphp
    <title>{{ $settings->config_value}} - @yield('title') </title>
    <link rel="apple-touch-icon" href="{{ asset('assets/backend')}}/app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/backend')}}/app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend')}}/app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend')}}/app-assets/vendors/css/forms/select/select2.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend')}}/app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend')}}/app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend')}}/app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend')}}/app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend')}}/app-assets/css/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend')}}/app-assets/css/themes/semi-dark-layout.css">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend')}}/app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend')}}/app-assets/css/plugins/forms/validation/form-validation.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/')}}/app-assets/vendors/css/extensions/toastr.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/')}}/app-assets/css/plugins/extensions/toastr.css">

    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend')}}/assets/css/style.css">

    <link rel="stylesheet" type="text/css" href="{{ asset('filter')}}/excel-bootstrap-table-filter-style.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('filter')}}/style.css">
    <!-- END: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend') }}/style.css">
    <!-- BEGIN: Page CSS-->
    @stack('css')
    <!-- END: Page CSS-->
    <style>
        .table-bordered {
            border: 1px solid #f4f4f4;
        }
        .table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 20px;
        }
        table {
            background-color: transparent;
        }
        table {
            border-spacing: 0;
            border-collapse: collapse;
        }
        .tarek-container{
        width: 85%;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 88% 12%;
        background-color: #ffff;
        }
        .invoice-label{
            font-size: 10px !important
        }
        .content-padding{
            padding: 5px 10px 12px;
        }
        .content-title{
            padding: 10px 0 0 10px;
        }
        .bx-filter{
            font-size: 30px;
            line-height: 0px;
        }

        /* Tareq custom css */
        .active-button-sale{
        color: red;
        }
        .card-body {
        flex: 1 1 auto;
        min-height: 1px;
        padding: 0.5rem !important;
        }

        .print-info{
            top: 0;
        }
        .conpany-header{
            display: none !important;
        }
        .invoice-view-wrapper{
            display:none;
        }

        @media print{
            .print-info{
                top: 0;
            }
            .invoice-view-wrapper{
                display: block;
            }
        }
        /* Tareq custom css */

        /* work by mominul */
        @media print{
            .conpany-header{
                display: block;
            }
            .print-hidden{
                display: none;
            }
        }
        #sidebar-toggler{
            border:1px solid #364a60;
        }
        @media (max-width: 1199.98px) {
            .navbar {
                left: 260px !important;
            }
            .content{
                margin-left: 260px !important;
            }
            .main-menu{
                opacity: 1 !important;
                width: 260px !important;
                left: 0 !important;
            }
        }
    </style>
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern semi-dark-layout 2-columns  navbar-sticky footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">

    <!-- BEGIN: Header-->
    <div class="header-navbar-shadow"></div>
    @include('layouts.backend.partial.nav')
    <!-- END: Header-->


    <!-- BEGIN: Main Menu-->

    <div>


        @if(isset($invoice_status))
        @include('layouts.backend.partial.sidebar',['invoice_status'=>$invoice_status])
        @else
        @include('layouts.backend.partial.sidebar')

        @endif
    </div>
    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    @yield('content')

    <!-- END: Content-->

    <!-- demo chat-->
    <div class="widget-chat-demo">
        <!-- widget chat demo footer button start -->
        {{-- <button class="btn btn-primary chat-demo-button glow px-1"><i class="livicon-evo" data-options="name: comments.svg; style: lines; size: 24px; strokeColor: #fff; autoPlay: true; repeat: loop;"></i></button> --}}
        <!-- widget chat demo footer button ends -->
        <!-- widget chat demo start -->
        {{-- <div class="widget-chat widget-chat-demo d-none">
            <div class="card mb-0">
                <div class="card-header border-bottom p-0">
                    <div class="media m-75">
                        <a href="JavaScript:void(0);">
                            <div class="avatar mr-75">
                                <img src="{{ asset('assets/backend')}}/app-assets/images/portrait/small/avatar-s-2.jpg" alt="avtar images" width="32" height="32">
                                <span class="avatar-status-online"></span>
                            </div>
                        </a>
                        <div class="media-body">
                            <h6 class="media-heading mb-0 pt-25"><a href="javaScript:void(0);">Kiara Cruiser</a></h6>
                            <span class="text-muted font-small-3">Active</span>
                        </div>
                    </div>
                    <div class="heading-elements">
                        <i class="bx bx-x widget-chat-close float-right my-auto cursor-pointer"></i>
                    </div>
                </div>
                <div class="card-body widget-chat-container widget-chat-demo-scroll">
                    <div class="chat-content">
                        <div class="badge badge-pill badge-light-secondary my-1">today</div>
                        <div class="chat">
                            <div class="chat-body">
                                <div class="chat-message">
                                    <p>How can we help? 😄</p>
                                    <span class="chat-time">7:45 AM</span>
                                </div>
                            </div>
                        </div>
                        <div class="chat chat-left">
                            <div class="chat-body">
                                <div class="chat-message">
                                    <p>Hey John, I am looking for the best admin template.</p>
                                    <p>Could you please help me to find it out? 🤔</p>
                                    <span class="chat-time">7:50 AM</span>
                                </div>
                            </div>
                        </div>
                        <div class="chat">
                            <div class="chat-body">
                                <div class="chat-message">
                                    <p>Stack admin is the responsive bootstrap 4 admin template.</p>
                                    <span class="chat-time">8:01 AM</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer border-top p-1">
                    <form class="d-flex" onsubmit="widgetChatMessageDemo();" action="javascript:void(0);">
                        <input type="text" class="form-control chat-message-demo mr-75" placeholder="Type here...">
                        <button type="submit" class="btn btn-primary glow px-1"><i class="bx bx-paper-plane"></i></button>
                    </form>
                </div>
            </div>
        </div> --}}
        <!-- widget chat demo ends -->

    </div>
    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <!-- BEGIN: Footer-->
    @include('layouts.backend.partial.footer')
    <!-- END: Footer-->
    {{-- party add model --}}
    <div class="modal fade" id="customerModal" tabindex="-1" role="dialog" aria-labelledby="customerModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">New Party Form</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

                    <form action="{{ route('customerPost') }}" method="POST" id="customerAddNew" >

                    @csrf
                    <div class="row match-height">



                        <div class="col-md-6">

                            <div class="form-body">
                                <div class="row">


                                    <div class="col-md-4">
                                        <label>Party Name</label>
                                    </div>
                                    <div class="col-md-8 form-group">
                                        <input type="text" id="pi_name"
                                            class="form-control" name="pi_name"
                                            value="{{ isset($costCenter) ? $costCenter->pi_name : '' }}"
                                            placeholder="Party Name" required>
                                        @error('pi_name')
                                            <div class="btn btn-sm btn-danger">{{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label>Party Type</label>
                                    </div>
                                    <div class="col-md-8 form-group customer-select">
                                        <select name="pi_type" class="common-select2" style="width: 100% !important" id="pi_type" required>
                                            @if(request()->is('*supplier*') || request()->is('*project*')|| request()->is('*purchase-expense-bill*')|| request()->is('*purchase_expense_edit*')|| request()->is('*purchase-expense-garage*')|| request()->is('*purchase-expense-office*'))
                                            <option value="Supplier">Supplier</option>
                                            @else
                                            <option value="Customer">Customer</option>
                                            @endif
                                        </select>

                                        @error('pi_type')
                                            <div class="btn btn-sm btn-danger">{{ $message }}
                                            </div>
                                        @enderror
                                    </div>


                                    <div class="col-md-4">
                                        <label>TRN No</label>
                                    </div>
                                    <div class="col-md-8 form-group">
                                        <input type="text" id="trn_no2"
                                            class="form-control" name="trn_no"
                                            value="{{ isset($costCenter) ? $costCenter->trn_no : '' }}"
                                            placeholder="TRN Number" >


                                        @error('trn_no')
                                            <div class="btn btn-sm btn-danger">{{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label>Address</label>
                                    </div>
                                    <div class="col-md-8 form-group">
                                        <input type="text" id="address2"
                                            class="form-control" name="address"
                                            value="{{ isset($costCenter) ? $costCenter->address : '' }}"
                                            placeholder="Address">


                                        @error('address')
                                            <div class="btn btn-sm btn-danger">{{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Contact Person</label>
                                    </div>
                                    <div class="col-md-8 form-group">
                                        <input type="text" id="con_person"
                                            class="form-control" name="con_person"
                                            value="{{ isset($costCenter) ? $costCenter->con_person : '' }}"
                                            placeholder="Contact Person">


                                        @error('con_person')
                                            <div class="btn btn-sm btn-danger">{{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label>Mobile Phone No</label>
                                    </div>
                                    <div class="col-md-8 form-group">
                                        <input type="number" id="con_no"
                                            class="form-control" name="con_no"
                                            value="{{ isset($costCenter) ? $costCenter->con_no : '' }}"
                                            placeholder="Mobile No">


                                        @error('con_no')
                                            <div class="btn btn-sm btn-danger">{{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label>Phone No</label>
                                    </div>
                                    <div class="col-md-8 form-group">
                                        <input type="number" id="phone_no"
                                            class="form-control" name="phone_no"
                                            value="{{ isset($costCenter) ? $costCenter->phone_no : '' }}"
                                            placeholder="Phone No">
                                        @error('phone_no')
                                            <div class="btn btn-sm btn-danger">{{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label>Email</label>
                                    </div>
                                    <div class="col-md-8 form-group">
                                        <input type="text" id="email"
                                            class="form-control" name="email"
                                            value="{{ isset($costCenter) ? $costCenter->email : '' }}"
                                            placeholder="Email">


                                        @error('email')
                                            <div class="btn btn-sm btn-danger">{{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-12 d-flex justify-content-end ">

                                        <button type="submit"
                                            class="btn btn-primary mr-1">Submit</button>
                                        <button type="reset"
                                            class="btn btn-light-secondary">Reset</button>

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

    <div class="modal fade" id="notice_modal" tabindex="-1" role="dialog" aria-labelledby="customerModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 100%" role="document">
        <div class="modal-content">
            <div class="modal-header" style="padding: 5px 33px;background:#364a60;">
                <h5 class="modal-title" id="exampleModalLabel" style="font-family:Cambria;font-size: 2rem;color:white;">View Notice</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body " id="notice_show" style="height: 400px;overflow:auto">


            </div>
        </div>
    </div>
    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset('assets/backend')}}/app-assets/vendors/js/vendors.min.js"></script>
    <script src="{{ asset('assets/backend')}}/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.tools.js"></script>
    <script src="{{ asset('assets/backend')}}/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.defaults.js"></script>
    <script src="{{ asset('assets/backend')}}/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{asset('assets/backend/')}}/app-assets/vendors/js/extensions/toastr.min.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{ asset('assets/backend')}}/app-assets/js/core/app-menu.js"></script>
    <script src="{{ asset('assets/backend')}}/app-assets/js/core/app.js"></script>
    <script src="{{ asset('assets/backend')}}/app-assets/js/scripts/components.js"></script>
    <script src="{{ asset('assets/backend')}}/app-assets/js/scripts/footer.js"></script>
    <!-- END: Theme JS-->

    <script src="{{ asset('assets/backend')}}/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
    <script src="{{ asset('assets/backend')}}/app-assets/js/scripts/forms/select/form-select2.js"></script>
    <script src="{{ asset('filter')}}/file.js"></script>

    <!-- BEGIN: Page JS-->
    @stack('js')
    <script>
    $(document).on('submit','#document-upload',function(e){
            e.preventDefault();
            var url = $(this).attr('action');
            var data = new FormData(this);

            $.ajax({
                type:'post',
                url:url,
                data:data,
                contentType:false,
                processData:false,
                success:function(res){
                    $('#documents').html(res);
                    toastr.success('Files has been uploaded successfully','success');
                }
            })
        })
         $(document).on('click','.remove-document',function(){
            var id = $(this).data('id');
            var url = $(this).data('url');
            $.ajax({
                type:'get',
                url: url,
                success:function(){
                    $(`#document-${id}`).hide();
                    toastr.success('The image has been deleted successfully!');
                }
            })
        })
    //   $(document).on('click', '#sidebar-toggler', function() {
    //         var $menu = $('.main-menu');
    //         var $content = $('.content');
    //         var $top_nav = $('.main-header-navbar ');


    //         if ($menu.css('display') === 'none') {
    //             $menu.css('display', 'block');
    //             $content.css('margin-left', '260px');
    //             $top_nav.css('left','260px')
    //         } else {
    //             $menu.css('display', 'none');
    //             $content.css('margin-left', '0px');
    //             $top_nav.css('left','0px')
    //         }
    //     });

    $(document).on('click', '#sidebar-toggler', function() {
    var $menu = $('.main-menu');
    var $content = $('.content');
    var $top_nav = $('.main-header-navbar');

    if ($menu.css('display') === 'none') {
        $menu[0].style.setProperty('display', 'block', 'important');
        $content[0].style.setProperty('margin-left', '260px', 'important');
        $top_nav[0].style.setProperty('left', '260px', 'important');
    } else {
        $menu[0].style.setProperty('display', 'none', 'important');
        $content[0].style.setProperty('margin-left', '0px', 'important');
        $top_nav[0].style.setProperty('left', '0px', 'important');
    }
});
        $(document).ready(function() {
                $('.common-select2').select2();
        })
        @if(Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}";
            console.log(type);
            toastr.options =
                {
                    "closeButton" : true,
                    "tapToDismiss": false,
                };
            switch(type){
                case 'info':
                    toastr.info("{{ Session::get('message') }}","Info");
                    break;

                case 'warning':
                    toastr.warning("{{ Session::get('message') }}","Warning");
                    break;

                case 'success':
                    toastr.success("{{ Session::get('message') }}", "Success");
                    break;

                case 'error':
                    toastr.error("{{ Session::get('message') }}", "Error");
                    break;
            }
        @endif
    </script>

    <script>
        function downloadCSV(csv, filename) {
            var csvFile;
            var downloadLink;

            // CSV file
            csvFile = new Blob([csv], {
                type: "text/csv"
            });

            // Download link
            downloadLink = document.createElement("a");

            // File name
            downloadLink.download = filename;

            // Create a link to the file
            downloadLink.href = window.URL.createObjectURL(csvFile);

            // Hide download link
            downloadLink.style.display = "none";

            // Add the link to DOM
            document.body.appendChild(downloadLink);

            // Click download link
            downloadLink.click();
        }

        function exportTableToCSV(filename) {
            var csv = [];
            var rows = document.querySelectorAll("table tr");

            for (var i = 0; i < rows.length; i++) {
                var row = [],
                    cols = rows[i].querySelectorAll("td, th");

                for (var j = 0; j < cols.length; j++)
                    row.push("\"" + cols[j].innerText + "\"");

                csv.push(row.join(","));
            }

            // Download CSV file
            downloadCSV(csv.join("\n"), filename);
        }
    </script>

    <script>
        $(document).ready(function() {
            toastr.options.timeOut = 10000;
            @if (Session::has('error'))
                toastr.error('{{ Session::get('error') }}');
            @elseif(Session::has('success'))
                toastr.success('{{ Session::get('success') }}');
            @endif
        });
        $(document).ready(function() {

            $(document).on('keypress', '.ajax-search', function(e) {
                if (e.which == 13) {
                    e.preventDefault();
                }
            });


            /////////////////////////////////////

            var delay = (function() {
                var timer = 0;
                return function(callback, ms) {
                    clearTimeout(timer);
                    timer = setTimeout(callback, ms);
                };
            })();

            $(document).on("keyup", ".ajax-search", function(e) {
                e.preventDefault();
                // alert('ok');
                var that = $(this);
                var q = e.target.value;
                var url = that.attr("data-url");
                var urls = url + '?q=' + q;
                // var datalist = $("#products");
                // datalist.empty();
                // alert(urls);


                delay(function() {
                    $.ajax({
                        url: urls,
                        type: 'GET',
                        cache: false,
                        dataType: 'json',
                        success: function(response) {
                            //   alert('ok');
                            // console.log(response);
                            // $(".pagination").remove();
                            $(".user-table-body").empty().append(response.page);
                        },
                        error: function() {
                            //   alert('no');
                        }
                    });
                }, 999);
            });


        });
    </script>
    <!-- END: Page JS-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script type="text/javascript">
        $(function() {
            $("#datepicker").datepicker({ dateFormat: "dd/mm/yy" }).val();
        });
        $(function() {
            $("#ord_date").datepicker({ dateFormat: "dd/mm/yy" }).val();
        });
        $(function() {
            $("#hnd_over_date").datepicker({ dateFormat: "dd/mm/yy" }).val();
        });

        $(function() {
            $("#date").datepicker({ dateFormat: "dd/mm/yy" }).val();
        });
        $(function() {
            $("#from").datepicker({ dateFormat: "dd/mm/yy" }).val();
        });
        $(function() {
            $("#to").datepicker({ dateFormat: "dd/mm/yy" }).val();
        });
        $(function() {
            $("#date_edit").datepicker({ dateFormat: "dd/mm/yy" }).val();
        });
        $(function() {
            $("#fld_date").datepicker({ dateFormat: "dd/mm/yy" }).val();
        });
        $(function() {
            $("#date_from").datepicker({ dateFormat: "dd/mm/yy" }).val();
        });
        $(function() {
            $("#date_to").datepicker({ dateFormat: "dd/mm/yy" }).val();
        });
        $(function() {
            var currentDate = new Date();
            currentDate.setFullYear(currentDate.getFullYear() - 1); // Go back to the previous year
            currentDate.setMonth(11); // Set the month to December (0-based index)
            currentDate.setDate(31);
            $(".datepicker").datepicker({ dateFormat: "dd/mm/yy" }); // Initialize datepicker for elements with class .datepicker
            $(".datepicker-dob").datepicker({
                maxDate: currentDate,
                dateFormat: "dd/mm/yy"
            }); // Initialize datepicker for elements with class .datepicker-dob
        });
        $("#customerAddNew").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            var form = $(this);
            var url = form.attr('action');
            var pi_name = $("#pi_name").val();
            var pi_type = $("#pi_type").val();
            var trn_no = $("#trn_no2").val();
            var address = $("#address2").val();
            var con_person = $("#con_person").val();
            var con_no = $("#con_no").val();
            var phone_no = $("#phone_no").val();
            var email = $("#email").val();
            // alert(mobile);
            $.ajax({
                url: url,
                method: "POST",
                data: {
                    pi_name: pi_name,
                    pi_type: pi_type,
                    trn_no: trn_no,
                    address: address,
                    con_person: con_person,
                    con_no: con_no,
                    phone_no: phone_no,
                    phone_no: phone_no,
                    email: email,
                    '_token': '{{ csrf_token() }}'
                },
                success: function(response) {
                    $(".customer").empty().append(response.page);
                    $("div.customer-select select").val(response.newCustomer.id);
                    $("#trn_no").val(response.newCustomer.trn_no);
                    $("#pi_code").val(response.newCustomer.pi_code);
                        $("#customerModal").modal('hide');
                }
            })
        });

        // **************************javascript iframe universal print function******************************
        //  writing by joman
        async function handlePrintClick(tableId) {
            const tableToPrint = document.getElementById(tableId);
            if (!tableToPrint) {
                toastr.warning(`Table element with id '${tableId}' not found`);
                return;
            }

            const currentDate = new Date().toLocaleDateString();
            const iframe = document.createElement('iframe');
            iframe.style.display = 'none';
            document.body.appendChild(iframe);

            try {
                // Cache header and footer if they don't change often
                const [headerResponse, footerResponse, stylesheetResponse] = await Promise.all([
                    fetch('/get-header').then(response => response.text()),
                    fetch('/get-footer').then(response => response.text()),
                    fetch('https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css').then(response => response.text())
                ]);

                const content = `
                    <html>
                        <head>
                            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                            <title>lavish_perfume_print_report_${currentDate}</title>
                            <style>
                                @media print {
                                    .print-none { display: none !important; }
                                    .print-show { display: block !important; }

                                    .header-title { margin-top:15px !imaportant; margin-bottom:15px !important;}
                                    @page { margin: 1cm; }
                                    .table td { color: #000000b8 !important; }
                                    .header { position: fixed; top: 0; left: 0; right: 0; }
                                    .footer { position: fixed; bottom: 0; left: 0; right: 0; page-break-before: always; page-break-after: always; }
                                    .row-style { border: 1px solid; border-radius: 7px; text-transform: uppercase; padding: 12px; }
                                    body { margin-bottom: 2cm; }
                                    .receipt-price td{
                                        padding: 1rem 10px !important;
                                        font-size: 15px !important;

                                    }
                                    .tr-border{
                                        border: 1px solid #000;
                                    }
                                    .td-top-border
                                    {
                                        border-top: 1px solid black !important;
                                    }
                                    .td-bottom-border
                                    {
                                        border-bottom: 1px solid black !important;
                                    }
                                    .td-right-border
                                    {
                                        border-right: 1px solid black !important;
                                    }
                                }
                                .footer {
                                    position: fixed;
                                    bottom: 0;
                                    left: 0;
                                    right: 0;
                                    page-break-before: always;
                                    page-break-after: always;
                                }
                                ${stylesheetResponse}
                            </style>
                        </head>
                        <body>
                            ${headerResponse}
                            <div>${tableToPrint.outerHTML}</div>
                        </body>
                    </html>
                `;

                iframe.contentDocument.open();
                iframe.contentDocument.write(content);
                iframe.contentDocument.close();

                const footer = document.createElement('div');
                footer.innerHTML = footerResponse;
                footer.classList.add('footer');
                iframe.contentDocument.body.appendChild(footer);

                const images = iframe.contentDocument.images;
                const imagesTotal = images.length;

                const onImagesLoaded = () => {
                    iframe.contentWindow.print();
                    document.body.removeChild(iframe);
                };

                if (imagesTotal === 0) {
                    onImagesLoaded();
                } else {
                    let imagesLoaded = 0;
                    const checkImagesLoaded = () => {
                        imagesLoaded++;
                        if (imagesLoaded >= imagesTotal) {
                            onImagesLoaded();
                        }
                    };

                    for (let img of images) {
                        if (img.complete) {
                            checkImagesLoaded();
                        } else {
                            img.onload = checkImagesLoaded;
                            img.onerror = checkImagesLoaded;
                        }
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                document.body.removeChild(iframe);
            }
        }

    </script>



   <!-- ************************************************** ////////////////////////////// *********************************************************** -->
     <!-- ************************************************** API function form zms systme start code  *************************************************** -->
     <!-- ************************************************** //////////////////////////////************************************************************* -->

     @php
        $client_id_ = \App\AppConfig::where('config_name', 'client_id')->first()->config_value;
        $api_endpoint = \App\AppConfig::where('config_name', 'api_endpoint')->first()->config_value;
        $company_name_api = \App\Setting::where('config_name', 'title_name')->first();


    @endphp
    <input type="hidden" id="api_url_list" value="{{$api_endpoint}}/api/client-requirement-list/{{$client_id_}}">
    <input type="hidden" id="api_url_moduls" value="{{$api_endpoint}}/api/agreement-module/{{$client_id_}}">
    <input type="hidden" id="api_url_suspension" value="{{$api_endpoint}}/api/suspension/{{$client_id_}}">


    <input type="hidden" id="api_url" value="{{$api_endpoint}}">
    <input type="hidden" id="company_name_api" value="{{$company_name_api->config_value}}">

    <link rel="stylesheet" href="{{ asset('filter/datatable.css') }}">
    <script src="{{ asset('filter/datafilter.js') }}"></script>

    <script>
        $(document).ready(function () {
            function getStoredNewDateTime() {
                const stored = localStorage.getItem('newDateTime');
                return stored !== null ? new Date(stored) : null;
            }

            function storeNewDateTime(dateTime) {
                localStorage.setItem('newDateTime', dateTime.toISOString());
            }


            const suspension_url = $('#api_url_suspension').val();
            $.ajax({
                url: suspension_url,
                method: 'GET',
                success: function (response) {
                    console.log('Suspension check: ' + response.status);

                    if (response.status === true) {
                        // Redirect to the suspension page with a message
                        window.location.href = "/suspend?message=" + encodeURIComponent(response.message);
                    } else {
                        window.location.href = "/home";
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching suspension status:', error);
                }
            });

            const currentDate = new Date();
            currentDate.setHours(0, 0, 0, 0);
            const api_end_point = $('#api_url').val();

            console.log('Step 1: Check API by using AJAX request');
            $.ajax({
                url: "{{ url('get-expiry-date') }}",
                method: 'GET',
                success: function (response) {
                    console.log('Step 2: Check local configs value from database:', response.expiryCheck_interval);
                    const currentDateTime = new Date();
                    let newDateTime = getStoredNewDateTime();

                    if (newDateTime === null || currentDateTime >= newDateTime) {
                        fetchApiNotification(response.client_id);
                        fetchApiData(response.client_id);
                        const randomInterval = Math.floor(Math.random() * parseInt(response.expiryCheck_interval)) + 1;
                        const randomIntervalInMilliseconds = randomInterval * 60 * 1000;
                        newDateTime = new Date(currentDateTime.getTime() + randomIntervalInMilliseconds);
                        storeNewDateTime(newDateTime);
                        console.log(`Step 3: Condition met. Current minute: ${currentDateTime}, newMinutes: ${newDateTime}`);
                    } else {
                        console.log(`Step 4: Condition not met. Current minute: ${currentDateTime}, newMinutes: ${newDateTime}`);
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Step 5: Error fetching local configs value:', error);
                }
            });

            function fetchApiData(clientId) {
                console.log('Step 6: Fetching API data from ZMS using API request.');

                $.ajax({
                    url: `${api_end_point}/api/expiry-date-chaeck/${clientId}`,
                    method: 'GET',
                    success: function (apiResponse) {
                        console.log('Step 7: Received all API data from ZMS API response:', apiResponse);
                        const apiExpiryDate = new Date(apiResponse.expiry_date);
                        apiExpiryDate.setHours(0, 0, 0, 0);
                        const differenceInDays = Math.ceil((apiExpiryDate - currentDate) / (1000 * 60 * 60 * 24));
                        console.log('Step 8: Check date interval for showing expiry popup if data difference is <= 7:', differenceInDays);

                        if (differenceInDays <= 7) {
                            showPopup(apiExpiryDate, apiResponse.company_name, clientId);
                        }

                        updateApiOrDatabase(
                            apiResponse.company_name,
                            apiResponse.end_point,
                            apiResponse.next_time_interval
                        );
                    },
                    error: function (xhr, status, error) {
                        console.error('Step 9: Error fetching API data from ZMS:', error);
                    }
                });
            }

            function showPopup(date, name, clientId) {
                console.log('Step 10: Displaying popup with message:', name);
                const formattedDate = new Intl.DateTimeFormat('en-US', {
                    month: 'long',
                    day: 'numeric',
                    year: 'numeric'
                }).format(new Date(date));

                const currentDate = new Date();
                 const expirationText = currentDate < new Date(date) ? 'will expire' : 'expired';

                const popup = $(`
                    <div class="popup" style="
                    background: rgba(255, 255, 255, 0.95);
                    color: #333;
                    padding: 20px 30px;
                    border-radius: 10px;
                    position: fixed;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    z-index: 9999;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                    width: 500px;
                    font-size: 16px;
                ">
                    <h2 style="margin-top: 0; color: #007BFF;">Subscription Expiry Notice</h2>
                    <p>Dear <strong>${name}</strong>,</p>
                    <p>
                        We wanted to remind you that your subscription ${expirationText}  on <strong>${formattedDate}</strong>.
                        To continue enjoying uninterrupted access to all premium features and services, we encourage you to
                        extend your subscription immediately.
                    </p>
                    <p>
                        Renewing your subscription will ensure that you continue to benefit from:
                        <ul>
                            <li>Exclusive access to advanced tools and features</li>
                            <li>Priority customer support</li>
                            <li>Enhanced performance and regular updates</li>
                            <li>Seamless operations for your business needs</li>
                        </ul>
                    </p>
                    <p style="font-weight: bold;">Act now to avoid disruption in service!</p>
                    <div style="text-align: right; margin-top: 20px;">

                        <button style="
                            background-color: #6c757d;
                            color: white;
                            border: none;
                            padding: 10px 20px;
                            border-radius: 5px;
                            cursor: pointer;
                            font-size: 16px;
                            margin-left: 10px;
                        " class="colse-button">Close</button>
                    </div>
                </div>
                `);
                $('body').append(popup);
                notification_log(clientId);
            }

            function notification_log(clientId) {
                const user_name = '{{Auth::user()->name}}';
                $.ajax({
                    url: `${api_end_point}/api/notification-log-update`,
                    method: 'post',
                    data: {
                        user_name: user_name,
                        clientId: clientId,
                        type: 'Expiry'
                    },
                    success: function (apiResponse) {
                        console.log('Step 11: Update Notification log in ZMS:', apiResponse);
                    },
                    error: function (xhr, status, error) {
                        console.error('Step 12: Notification update Error in ZMS:', error);
                    }
                });
            }

            $(document).on("click", ".colse-button", function (e) {
                $('.popup').hide();
            });

            function fetchApiNotification(clientId) {
                $.ajax({
                    url: `${api_end_point}/api/notification/${clientId}`,
                    method: 'GET',
                    success: function (apiResponse) {
                        notificationshowPopup(apiResponse.notification, apiResponse.notification_history_id, clientId);
                        console.log('Step 13: Received Notification from ZMS API response:', apiResponse);
                    },
                    error: function (xhr, status, error) {
                        console.error('Step 14: Error Notification found from ZMS API data:', error);
                    }
                });
            }

            function notificationshowPopup(notification, notification_history_id, clientId) {
                console.log('notificaton show.')
                $('#notice_show').html(notification);
                $('#notice_modal').modal('show');
                notification_log_update(notification_history_id, clientId);
            }

            function notification_log_update(notification_history_id, clientId) {
                const user_name = '{{Auth::user()->name}}';
                $.ajax({
                    url: `${api_end_point}/api/notification-log-update`,
                    method: 'post',
                    data: {
                        user_name: user_name,
                        clientId: clientId,
                        notification_history_id: notification_history_id,
                        type: 'Notices'
                    },
                    success: function (apiResponse) {
                        console.log('Step 15: Notice update in ZMS by API:', apiResponse);
                    },
                    error: function (xhr, status, error) {
                        console.error('Step 16: Notification log API Error:', error);
                    }
                });
            }

            $(document).on("click", ".colse-button2", function (e) {
                $('.popup2').hide();
            });

            function updateApiOrDatabase(company_name, end_point, next_time_interval) {
                $.ajax({
                    url: "{{url('get-expiry-date-update')}}",
                    method: 'POST',
                    data: {
                        company_name: company_name,
                        end_point: end_point,
                        next_time_interval: next_time_interval,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        console.log('Step 17: Configs updated successfully.', response);
                    },
                    error: function (xhr, status, error) {
                        console.error('Step 18: Updating error:', error);
                    }
                });
            }

            function updateTimeInterval(next_time_interval) {
                $.ajax({
                    url: "{{url('update-time-interval-date-update')}}",
                    method: 'POST',
                    data: {
                        next_time_interval: next_time_interval,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        console.log('Step 19: Time interval updated successfully.', response);
                    },
                    error: function (xhr, status, error) {
                        console.error('Step 20: Time interval update error:', error);
                    }
                });
            }
        });
    </script>
     <!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
     <!-- ************************************************** API function form zms systme end code  ****************************************************** -->
     <!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
</body>
<!-- END: Body-->

</html>
