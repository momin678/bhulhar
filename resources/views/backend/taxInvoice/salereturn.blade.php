@extends('layouts.backend.app')
@push('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
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


    .tarek-container {
        width: 85%;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 88% 12%;
        background-color: #ffff;
    }

    .invoice-label {
        font-size: 10px !important
    }
</style>
@endpush
@section('content')
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            <!-- Widgets Statistics start -->
            <section id="widgets-Statistics">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <h4>Sales Return</h4>
                            <hr>
                        </div>
                        <div class="row ">
                            <div class="col-4 mb-1">
                                <select class="form-control common-select2" placeholder="Serach By Invoice Invoice No" name="invoice_no" id="invoice_no_s">
                                    <option value="">Serach By Invoice No</option>
                                    @foreach ($invoicess as $invoice)
                                    <option value="{{$invoice->invoice_no}}">{{ $invoice->invoice_no }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <form action="{{route('finalSaveSaleReturn')}}" class="apenddata" method="POST" target="_blank">
                            @csrf
                            <input type="hidden" value="{{$newReturn->sales_return_no }}" name="sales_return_no" id="sales_return_no">

                            <div class="apenddata invoice-items">
                            <div class="row ">
                                <div class="card d-flex align-items-center" style="min-height: 180px">
                                    <div class="card-body">
                                        <div class="row d-flex align-items-center">
                                            <div class="col-sm-3 form-group">
                                                <label for="">Branch</label>
                                                <select name="branch" class="form-control" id="" readonly disabled>
                                                    <option value="">Select...</option>

                                                </select>
                                            </div>

                                          
                                            <div class="col-sm-3 form-group">
                                                <label for="">Date</label>
                                                <input type="date" value="" class="form-control" name="date" id="date" readonly disabled>
                                            </div>
                                            <div class="col-sm-3 form-group">
                                                <label for="">Tax Invoice No</label>
                                                <input type="text" class="form-control" value="" name="invoice_no" id="invoice_no" readonly>
                                            </div>
                                            <div class="col-sm-3 form-group">
                                                <label for="">Customer Name</label>
                                                <select name="customer_name" id="customer_name" class="form-control party-info" data-target="" readonly disabled>
                                                    <option value="">Select...</option>

                                                </select>
                                            </div>
                                            <div class="col-sm-3 form-group">
                                                <label for="">TRN</label>
                                                <input type="text" class="form-control" value="" name="trn_no" id="trn_no" class="form-control" readonly disabled>
                                            </div>
                                            <div class="col-sm-3 form-group">
                                                <label for="">Payment Mode</label>
                                                <select name="pay_mode" id="" class="form-control" readonly disabled>
                                                    <option value="">Select...</option>

                                                </select>
                                            </div>
                                            <div class="col-sm-3 form-group">
                                                <label for="">Payment Terms </label>
                                                <select name="pay_terms" id="pay_terms" class="form-control" readonly disabled>
                                                    <option value="">Select...</option>


                                                </select>
                                            </div>
                                            <div class="col-sm-3 form-group">
                                                <label for="">Due Date</label>
                                                <input type="date" value="" class="form-control" name="due_date" id="due_date" readonly disabled>
                                            </div>

                                            <div class="col-sm-3 form-group">
                                                <label for="">Contact Number</label>
                                                <input type="text" value="" class="form-control" name="contact_no" id="contact_no" readonly disabled>
                                            </div>

                                            <div class="col-sm-3 form-group">
                                                <label for="">Shipping Address</label>
                                                <input type="text" value="" class="form-control" name="address" id="address" readonly disabled>
                                            </div>
                                            <div class="col-sm-4 form-group hide-entry ">
                                                <div class="form-group ">
                                                    <input type="checkbox" class="checkbox-record" name="vat_include" id="vat_include" value="1" {{$invoice? ($invoice->include_vat?'checked':''):'' }} disabled>
                                                    <label for=""> Include Vat</label>
                                                </div>
                                            </div>
                                           
                                            <div class="col-sm-3 form-group">
                                                <label for="">Style ID</label>
                                                <input type="Style_ID" value="" class="form-control" name="due_date" id="due_date" readonly>
                                            </div>

                                            <div class="col-sm-3 form-group">
                                                <label for="">Item_Name</label>
                                                <input type="text" value="" class="form-control" name="contact_no" id="contact_no" readonly>
                                            </div>

                                            <div class="col-sm-2 form-group">
                                                <label for="">QTY</label>
                                                <input type="QTY" value="" class="form-control" name="address" id="address">
                                            </div>
                                            <div class="col-sm-2 form-group">
                                                <label for="">Unit</label>
                                                <input type="Unit" value="" class="form-control" name="due_date" id="due_date" readonly>
                                            </div>
                                            <div class="col-sm-2 form-group">
                                                <label for="">Vat</label>
                                                <input type="Vat" value="" class="form-control" name="contact_no" id="contact_no" readonly>
                                            </div>
                                            <div class="col-sm-2 form-group">
                                                <label for="">Unit_Price</label>
                                                <input type="Unit_Price" value="" class="form-control" name="contact_no" id="contact_no" readonly>
                                            </div>

                                            <div class="col-sm-2 form-group">
                                                <label for="">Total Price</label>
                                                <input type="Total_Price" value="" class="form-control" name="address" id="address">
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
    </div>
</div>
</div>
@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
{{-- <script src="{{ asset('assets/backend/app-assets/vendors/js/jquery/jquery.min.js') }}"></script> --}}
<script>
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });
                    $(document).on('click', '.image-edite', function() {

                        let style_name = $(this).data('style_name');
                        let item_name = $(this).data('item_name');
                        let quantity = $(this).data('quantity');
                        let squantity = $(this).data('squantity');
                        let vat_rate = $(this).data('vat_rate');

                        let unit = $(this).data('unit');
                        let unit_price = $(this).data('unit_price');
                        let vat_amount = $(this).data('vat_amount');
                        let cost_price = $(this).data('cost_price');
                        let item_id = $(this).data('item_id');
                        let barcode = $(this).data('barcode');


                        $('#style_id').val(style_name);
                        $('#item_name').val(item_name);
                        $('#item_id').val(item_id);
                        $('#sqty').val(squantity);
                        $('#vat').val(vat_amount);

                        $('#qty').val(quantity);
                        $('#unit').val(unit);
                        $('#unit_price').val(unit_price);
                        $('#vat_rate').val(vat_rate);
                        $('#total_price').val(cost_price);
                        $('#barcode').val(barcode);

                        document.getElementById("qty").max = quantity;
                        $('.addonly-btn').removeAttr("disabled")
                    });

                  
                </script>
<script>
    function refreshPage() {
        window.location.reload();
    }
    $(document).ready(function() {
        
        $("#invoice_print").focus();
        $(document).on("change", "#invoice_no_s", function(e) {
            var value = $(this).val();
            var _token = $('input[name="_token"]').val();

            $.ajax({
                url: "{{ route('searchInvoice-data') }}",
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

        $('#customer_name').change(function() {
            // alert(1);
            if ($(this).val() != '') {
                var value = $(this).val();
                var _token = $('input[name="_token"]').val();

                $.ajax({
                    url: "{{ route('partyInfoInvoice') }}",
                    method: "POST",
                    data: {
                        value: value,
                        _token: _token,
                    },
                    success: function(response) {
                        console.log(response);
                        $("#trn_no").val(response.trn_no);
                        $("#contact_no").val(response.con_no);
                        $("#address").val(response.address);
                    }
                })
            }
        });


        $('#pay_terms').change(function() {
            if ($(this).val() != '') {
                var value = $(this).val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('findDate') }}",
                    method: "POST",
                    data: {
                        value: value,
                        _token: _token,
                    },
                    success: function(response) {
                        $("#due_date").val(response);
                    }
                })
            }
        });

        $(document).on("keyup", "#barcode", function(e) {
            if ($(this).val().length == 4) {
                var value = $(this).val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('findItem') }}",
                    method: "POST",
                    data: {
                        value: value,
                        _token: _token,
                    },
                    success: function(response) {
                        console.log(response);
                        var qty = 0;
                        $("#item_name").val(response.item_name);
                        $("div.search-item select").val(response.barcode);
                        $("#unit_price").val(response.sell_price);
                        $("#cost_price").val(response.sell_price);
                        $("#net_amount").val(response.sell_price);
                        $("#quantity").focus().val(qty);
                    }
                })
            }
        });
        $(document).on("keyup", "#quantity", function(e) {
            if ($(this).val() != '') {
                var value = $(this).val();
                var _token = $('input[name="_token"]').val();
                var c = $('#net_amount').val();
                var cost = c * value;
                $("#cost_price").val(cost);
                $("#temp_invoice").focus();
            }
        });
        $('#temp_invoice').click(function() {
            var barcode = $('#barcode').val();
            var quantity = $('#quantity').val();
            var unit_price = $('#unit_price').val();
            var cost_price = $('#cost_price').val();
            var invoice_no = $('#invoice_no').val();
            var item_name = $('#item_name').val();
            var net_amount = $('#net_amount').val();

            var _token = $('input[name="_token"]').val();

            $.ajax({
                url: "{{ route('tempInvoice') }}",

                method: "GET",
                data: {
                    barcode: barcode,
                    quantity: quantity,
                    unit_price: unit_price,
                    cost_price: cost_price,
                    invoice_no: invoice_no,
                    item_name: item_name,
                    net_amount: net_amount,

                    barcode: barcode,
                    _token: _token,
                },

                success: function(response) {
                    // alert(response.total_vat_amount);
                    var vat = response.total_cost_price - response.total_unit_price;
                    $(".all-data-area").empty().append(response.page);
                    $("#total_gross").val(response.total_cost_price);
                    $("#tarek").val(response.total_unit_price);
                    $("#total_vat").val(response.total_vat_amount);
                    $("#item_name").val('');
                    $("div.search-item select").val('');
                    $("#unit_price").val('');
                    $("#cost_price").val('');
                    $("#net_amount").val('');
                    $("#quantity").val('');
                    $("#barcode").focus().val('');
                    // $("#item_name").val(response.item_name);

                }

            })

        });

        var delay = (function() {
            var timer = 0;
            return function(callback, ms) {
                clearTimeout(timer);
                timer = setTimeout(callback, ms);
            };
        })();

        $(document).on("click", '.invoice-item-delete', function(event) {
            event.preventDefault();
            var that = $(this);
            var urls = that.attr("data_target");
            var _token = $('input[name="_token"]').val();
            var invoice_no = $('#invoice_no').val();
            // alert(invoice_no);
            $.ajax({
                url: urls,
                method: "GET",
                invoice_no: invoice_no,
                _token: _token,

                success: function(response) {
                    // alert("hukka");
                    console.log(response);
                    $(".all-data-area").empty().append(response.page);
                    $("#total_gross").val(response.total_cost_price);
                    $("#tarek").val(response.total_unit_price);
                    $("#total_vat").val(response.total_vat_amount);

                },
                error: function() {
                    //   alert('no');
                }
            });

        });

        $('#refresh_invoice').click(function() {
            // alert(1);

            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ route('refresh_invoice') }}",
                method: "GET",
                data: {
                    _token: _token,
                },
                success: function(response) {
                    $(".invoice-items").empty().append(response.page);
                }
            })
        });

        $('#item_name').change(function() {
            // alert(1);
            if ($(this).val() != '') {
                var value = $(this).val();
                var _token = $('input[name="_token"]').val();

                $.ajax({
                    url: "{{ route('findItem') }}",
                    method: "POST",
                    data: {
                        value: value,
                        _token: _token,
                    },

                    success: function(response) {
                        console.log(response);
                        var qty = 1;
                        // alert(response.item_name);
                        $("#barcode").val(response.barcode);
                        $("div.search-item select").val(response.barcode);
                        $("#unit_price").val(response.sell_price);
                        $("#cost_price").val(response.sell_price);
                        $("#net_amount").val(response.sell_price);
                        $("#quantity").focus().val(qty);
                        // $('#qua').focus()

                    }

                })
            }
        });

        // $(document).on("keyup", "#amount_from", function(e) {
        //     if ($(this).val() != '') {
        //         var value = $(this).val();
        //         var _token = $('input[name="_token"]').val();
        //         var c = $('#total_gross').val();
        //         var cost =  value - c ;
        //         $("#amount_to").val(cost);

        //     }
        // });

        $(document).on("keypress", "#amount_from", function(e) {
            var key = e.which;
            if (e.which == 13) {
                if ($(this).val() != '') {
                    var value = $(this).val();
                    var c = $('#total_gross').val();
                    var invoice = $('#invoice_no').val();
                    var _token = $('input[name="_token"]').val();

                    $.ajax({
                        url: "{{ route('amountto') }}",
                        method: "POST",
                        data: {
                            value: value,
                            c: c,
                            invoice: invoice,
                            _token: _token,
                        },

                        success: function(response) {
                            console.log(response);
                            var qty = 1;
                            $("#amount_to").val(response.amount_to);


                        }

                    })
                }
            }



        });



        $('#reservationdatetime').datetimepicker({
            icons: {
                time: 'far fa-clock'
            }
        });


    });
</script>

<script>
$(document).on('click', '#item-return-add', function(e) {

        e.preventDefault();
        var sqty = $('#sqty').val();
        var qty = $('#qty').val();
        var item_id = $('#item_id').val();
        var unit_price = $('#unit_price').val();
        var vat_rate = $('#vat_rate').val();
        var style_name = $('#style_id').val();
        var item_name = $('#item_name').val();
        var total_price = $('#purchase_rate').val();
        var vat = $('#vat').val();
        var invoice_no = $('#invoice_no').val();
        var sales_return_no = $('#sales_return_no').val();



        // alert(purchase_no);
        $.ajax({
            url: "{{ route('sales_item_temp') }}",
            method: "post",
            data: {
                sqty: sqty,
                qty: qty,
                item_id: item_id,
                unit_price: unit_price,
                vat_rate: vat_rate,
                style_name:style_name,
                item_name:item_name,
                total_price: total_price,
                vat: vat,
                invoice_no: invoice_no,
                sales_return_no:sales_return_no
            },
            success: function(response) {
                if (response.message) {


                    toastr.error(response.message, response.title);
                } else {
                    // $("#item_name").val('');
                    $(".return-item").empty().append(response.page);
                    $('.only-save-btn').removeAttr("disabled");
                    $("#total_price").val('');

                    $("#sqty").val('');
                    $("#qty").val('');
                    $("#vat").val('');
                    $("#qty").val('');

                    $("#style_id").val('');
                    $("#item_name").val('');


                }
            }
        })
    });
    $(document).on("click", ".delete_item_1", function(e) {
            e.preventDefault();
            alert('are yor sure delete it !!');
            let item_id1 = $(this).data('item_id1');

            var invoice_no1 = $(this).data('invoice_no1');
            // alert(purchase_no1 + item_id1);


            $.ajax({
                url: "{{ route('sales_item_temp_delete') }}",
                method: "post",
                data: {

                    item_id1: item_id1,
                    invoice_no1: invoice_no1,

                },
                success: function(response) {

                    // $("#item_name").val('');
                    $(".return-item").empty().append(response.page);

                }
            })

        });
</script>
@endpush