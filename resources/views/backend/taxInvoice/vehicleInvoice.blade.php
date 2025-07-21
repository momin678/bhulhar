@extends('layouts.backend.app')
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
    <style>

        .table-bordered {
            border: 1px solid #f4f4f4;
        }

        element.style {
}
/* .select2-container--default .select2-results>.select2-results__options {
    max-height: 200px !important;
    width: 500px !important;
    overflow-y: auto !important;
    border: none !important;
} */
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

        .card {
            margin-bottom: 0px !important;
            box-shadow: -8px 12px 18px 0 rgb(25 42 70 / 13%);
            transition: all .3s ease-in-out, background 0s, color 0s, border-color 0s;
        }


        .tarek-container{
            width: 85%;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 88% 12%;
            background-color: #ffff;
        }
option {
  width: 450px !important;
}

.invoice-label{
    font-size: 10px !important
}
        @media (min-width: 576px)
        {
            .modal-dialog {
            max-width: 740px !important;
            margin: 1.75rem auto;
        }
        }


        /* .col-1, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-10, .col-11, .col-12, .col, .col-auto, .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm, .col-sm-auto, .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12, .col-md, .col-md-auto, .col-lg-1, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg, .col-lg-auto, .col-xl-1, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl, .col-xl-auto {
    position: relative;
    width: 100%;
    padding-right: 15px;
    padding-left: 0px !important;
} */
    </style>
@endpush
@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">

            <div class="content-body">
                <!-- Widgets Statistics start -->
                <section id="widgets-Statistics">
                    <div class="row ">
                        <div class="col-md-10 ">
                            <div class="row">
                                <h4>Vehicle Wise Sales</h4>
                                <hr>
                            </div>
                            <div class="row details-view">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="row">
                                <h5 style="white-space: nowrap;">Invoices </h5>
                                <input type="text" class="form-control w-100" placeholder="Serach By Vehicle No" name="invoice_no" id="invoice_no_s">
                                {{-- <i class="bx bx-refresh btn btn-sm" id="refresh_invoice">Refresh</i> --}}
                                {{-- <div class="invoice-items">
                                    <ul>
                                        @foreach ($invoicess as $invoice)
                                        <li><a href="{{ route('invoiceView', $invoice) }}" id="sale-order-details"  data_target="{{ route('vehicleInvoiceDetails', $invoice) }}">{{ $invoice->invoice_no }}</a></li>

                                        @endforeach
                                    </ul>
                                </div> --}}

                                <div class="row invoice-items">
                                    @foreach ($invoicess as $invoice)
                                        <div class="col-md-12 btn btn-light  mx-1 mb-1 text-center"
                                            id="sale-order-details"
                                            data_target="{{ route('vehicleInvoiceDetails', $invoice->vehicle_no) }}">
                                            {{ $invoice->vehicle_no }}

                                        </div>
                                    @endforeach
                                </div>


                                <hr>
                            </div>

                        </div>
                    </div>

                </section>
            </div>
        </div>
    </div>


@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
    {{-- <script src="{{ asset('assets/backend/app-assets/vendors/js/jquery/jquery.min.js') }}"></script> --}}
    <script>

function refreshPage(){
    window.location.reload();
}
        $(document).ready(function() {
            $("#item_name").focus();
            var delay = (function() {
                var timer = 0;
                return function(callback, ms) {
                    clearTimeout(timer);
                    timer = setTimeout(callback, ms);
                };
            })();
            $(document).on("click", "#sale-order-details", function(e) {
                // alert(1);
                e.preventDefault();
                $(this).addClass('active-button-sale').siblings('div').removeClass('active-button-sale');

                var that = $(this);
                var urls = that.attr("data_target");
                // alert(urls);
                delay(function() {
                    $.ajax({
                        url: urls,
                        type: 'GET',
                        cache: false,
                        dataType: 'json',
                        success: function(response) {
                            //   alert('ok');
                            console.log(response);
                            $(".details-view").empty().append(response.page);
                        },
                        error: function() {
                            alert('Problem Found');
                        }
                    });
                }, 999);
            });

            $(document).on("keyup", "#invoice_no_s", function(e) {
                    var value = $(this).val();
                    var _token = $('input[name="_token"]').val();
                    // alert(1);
                    $.ajax({
                        url: "{{ route('searchVehicleInvoice') }}",
                        method: "GET",
                        data: {
                            value: value,
                            _token: _token,
                        },
                        success: function(response) {
                            // console.log(response);
                            $(".invoice-items").empty().append(response.page);
                        }
                    })
            });
        });
    </script>
@endpush



