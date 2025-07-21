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

        option {
            width: 450px !important;
        }

        .invoice-label {
            font-size: 10px !important
        }

        @media (min-width: 576px) {
            .modal-dialog {
                max-width: 740px !important;
                margin: 1.75rem auto;
            }
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
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-12">
                                    <h4>Purchase</h4>

                                </div>
                            </div>
                            <form action="{{ route('finalSavePurchase') }}" method="POST" onsubmit="return confirm('Please, confirm the invoice.')">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card d-flex align-items-center">
                                            <div class="card-body">
                                                <div class="row d-flex align-items-center">
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Branch</label>
                                                        <select name="branch" class="form-control"
                                                            style="width: 100% !important" id="branch" required readonly>
                                                            @foreach ($projects as $item)
                                                                <option value="{{ $item->id }}"
                                                                    {{ $purchase->project_id == $item->id ? 'selected' : '' }}>
                                                                    {{ $item->proj_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <div class="project-error" style="display: none">
                                                            <div class="btn btn-sm btn-danger">Required*
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3 form-group d-none">
                                                        <label for="">GL Code</label>
                                                        <input type="text" name="gl_code" id="gl_code"
                                                            value="{{ isset($gl_code) ? $gl_code->fld_ac_code : '' }}"
                                                            class="form-control" readonly>

                                                    </div>
                                                    <div class="col-sm-3 form-group" id="printarea">
                                                        <label for="">Purchase Date</label>
                                                        <input type="text" value="{{date('d/m/Y', strtotime( $purchase->date))}}" class="form-control" name="date" id="date" required readonly>
                                                    </div>
                                                    <div class="col-sm-3 form-group d-none">
                                                        <label for="">Purchase No</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $purchase->purchase_no }}" name="invoice_no"
                                                            id="invoice_no" readonly >
                                                    </div>
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Payment Mode</label>
                                                        <select name="pay_mode" id="pay_mode" class="form-control"
                                                            style="width: 100% !important" required readonly>
                                                            <option value="">Select...</option>
                                                            @foreach ($modes as $item)
                                                                <option value="{{ $item->title }}"
                                                                    {{ $purchase->pay_mode == $item->title ? 'selected' : '' }}>
                                                                    {{ $item->title }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-2 form-group pay-term d-none">
                                                        <label for="">Payment Terms</label>
                                                        <select name="pay_terms" id="pay_terms" class="form-control"
                                                            style="width: 100% !important" required readonly>
                                                            <option value="">Select...</option>
                                                            @foreach ($terms as $item)
                                                                <option value="{{ $item->value }}"
                                                                    {{ $purchase->pay_terms == $item->value ? 'selected' : '' }}>
                                                                    {{ $item->title }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-3 form-group d-none">
                                                        <label for="">Due Date</label>
                                                        <input type="date" class="form-control" name="due_date"
                                                            id="due_date" value="{{ $purchase->due_date }}" readonly readonly>
                                                    </div>
                                                    <div class="col-sm-3 form-group customer-select">
                                                        <label for="">Supplier Name</label>
                                                        <select name="customer_name" id="customer_name"
                                                            class="form-control party-info customer"
                                                            style="width: 100% !important" data-target="" required readonly>
                                                            <option value="">Select...</option>
                                                            @foreach ($customers as $customer)
                                                                <option value="{{ $customer->pi_code }}"
                                                                    {{ $customer->pi_code == $purchase->customer_name ? 'selected' : '' }}>
                                                                    {{ $customer->pi_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-sm-3 form-group">
                                                        <label for="">TRN</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $purchase->trn_no }}" name="trn_no" id="trn_no"
                                                            class="form-control" readonly readonly>
                                                    </div>


                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Contact Number</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $purchase->contact_no }}" name="contact_no"
                                                            id="contact_no" readonly>
                                                    </div>

                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Address</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $purchase->address }}" name="address" id="address"
                                                            readonly>
                                                    </div>

                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Supplier Invoice</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $purchase->supplier_invoice }}" name="supplier_invoice" id="supplier_invoice"
                                                            readonly>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered all-data-area">
                                        <thead>
                                            <tr>
                                                <th>Product Name</th>
                                                <th>Category</th>
                                                <th>Brand</th>
                                                <th>Unit Price</th>
                                                <th>Quantity</th>
                                                <th>Unit</th>
                                                <th>Total Price</th>
                                            </tr>
                                        </thead>
                                        <tbody class="">

                                            @foreach ($items as $item)
                                                <tr class="data-row">
                                                    <td>{{ $item->product->name }}</td>
                                                    <td>{{ $item->category->name }}</td>
                                                    <td>{{ isset( $item->brand)?$item->brand->name:"" }}</td>
                                                    <td>{{ $item->unit_price }}</td>
                                                    <td>{{ number_format($item->amount,0) }}</td>
                                                    <td>{{ $item->unitP->name}}</td>
                                                    <td>{{$item->price}}</td>
                                                </tr>
                                                <?php $i++; ?>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="row pt-1">

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="" class=" d-flex align-items-center col-right-padding">Vat (AED):</label>
                                            @if ($purchase->pay_mode == "Cash")
                                                <input type="number" name="vat" placeholder="Final Discount" min="0" step="any" class="form-control col-right-padding" value="{{number_format((float)( App\PurchaseTempItem::where('purchase_no', $purchase->purchase_no)->sum('vat') ), 0, '.', '') }}"
                                                    id="vat" readonly>
                                            @else
                                                <input type="number" name="vat" placeholder="Final Discount" min="0" step="any" class="form-control col-right-padding" value="{{number_format((float)( App\PurchaseTempItem::where('purchase_no', $purchase->purchase_no)->sum('vat') ), 2, '.', '') }}"
                                                id="vat" readonly>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3 d-none">
                                        <div class="form-group">
                                            <label for="" class="d-flex align-items-center col-right-padding">Discount(AED):</label>
                                            @if ($purchase->pay_mode == "Cash")
                                                <input type="number" name="discount_amount" placeholder="Final Discount" min="0" step="any" class="form-control col-right-padding" value="{{number_format((float)( App\PurchaseTempItem::where('purchase_no', $purchase->purchase_no)->sum('discount_price') ), 0, '.', '') }}"
                                            id="discount_amount" readonly>
                                            @else
                                                <input type="number" name="discount_amount" placeholder="Final Discount" min="0" step="any" class="form-control col-right-padding" value="{{number_format((float)( App\PurchaseTempItem::where('purchase_no', $purchase->purchase_no)->sum('discount_price') ), 2, '.', '') }}"
                                            id="discount_amount" readonly>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="" class="d-flex align-items-center col-right-padding">Total(AED):</label>
                                            @if ($purchase->pay_mode == "Cash")
                                                <input type="number" name="total_gross" placeholder="Final Discount" min="0" step="any" class="form-control col-right-padding" value="{{number_format((float)( App\PurchaseTempItem::where('purchase_no', $purchase->purchase_no)->sum('total_price') ), 2, '.', '') }}"
                                            id="total_gross" readonly>
                                            @else
                                                <input type="number" name="total_gross" placeholder="Final Discount" min="0" step="any" class="form-control col-right-padding" value="{{number_format((float)( App\PurchaseTempItem::where('purchase_no', $purchase->purchase_no)->sum('total_price') ), 2, '.', '') }}"
                                            id="total_gross" readonly>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="" class="d-flex align-items-center col-right-padding">Pay (AED):</label>
                                            @if ($purchase->pay_mode == "Cash")
                                                <input type="number" name="amount_from" placeholder="Amount" min="0" step="any" value="{{number_format((float)( App\PurchaseTempItem::where('purchase_no', $purchase->purchase_no)->sum('total_price') ), 0, '.', '') }}" class="form-control"
                                            id="amount_from" >
                                            @else
                                                <input type="number" name="amount_from" placeholder="Amount" min="0" step="any" value="{{number_format((float)( App\PurchaseTempItem::where('purchase_no', $purchase->purchase_no)->sum('total_price') ), 2, '.', '') }}" class="form-control"
                                            id="amount_from" >
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="" class="d-flex align-items-center col-right-padding">Due (AED):</label>
                                            <input type="number" value="00.00" name="amount_to" placeholder="Amount" step="any" class="form-control" id="amount_to" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-sm final-save-btn only-save-btn  btn-primary" id="final_save">Confirm</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-2">
                            <div class="row">
                                <h5 style="white-space: nowrap;">Purchases </h5>
                                <input type="text" class="form-control w-100" placeholder="Serach Purchase No"
                                    name="invoice_no" id="invoice_no_s">
                                <i class="bx bx-refresh btn btn-sm" id="refresh_invoice">Refresh</i>
                                <div class="invoice-items">
                                    <ul>
                                        @foreach ($purchases as $purch)
                                            <li><a
                                                    href="{{ route('purchaseView', $purch) }}">{{ $purch->purchase_no }}</a>
                                            </li>
                                        @endforeach
                                    </ul>



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
        function refreshPage() {
            window.location.reload();
        }
        $(document).ready(function() {
            $("#item_name").focus();

            $(document).on("keyup", "#amount_from", function(e) {
                var value = $(this).val();
                var c = $('#total_gross').val();

                var to = c - value;
                $("#amount_to").val(parseFloat(to).toFixed(2));

            });

            $(document).on("keypress", "#amount_from", function(e) {
                var key = e.which;
                if (e.which == 13) {
                    $("#final_save").focus();
                    e.preventDefault();
                    return false;
                }

            });
            $(document).on("keypress", "#barcode", function(e) {
                var key = e.which;
                if (e.which == 13) {
                    $("#amount_from").focus();
                    $("#amount_from").val($('#total_gross').val());
                    // e.preventDefault();
                    return false;
                }

            });



            $(document).on("change", "#branch", function(e) {
                $("#customer_name").focus();
            });

            $(document).on("change", "#date", function(e) {
                var value = $('#pay_terms').val();
                // alert(date);

                var date = $(this).val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('findDate') }}",
                    method: "POST",
                    data: {
                        value: value,
                        date: date,
                        _token: _token,
                    },
                    success: function(response) {
                        $("#due_date").val(response);
                    }

                })
            });

            $(document).on("change", "#customer_name", function(e) {
                $("#pay_mode").focus();
            });

            $(document).on("keyup", "#invoice_no_s", function(e) {
                var value = $(this).val();
                var _token = $('input[name="_token"]').val();

                $.ajax({
                    url: "{{ route('searchPurchase') }}",
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
                    var date = $('#date').val();
                    // alert(date);

                    var value = $(this).val();
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "{{ route('findDate') }}",
                        method: "POST",
                        data: {
                            value: value,
                            date: date,
                            _token: _token,
                        },
                        success: function(response) {
                            $("#due_date").val(response);
                        }

                    })
                }
            });
            $(document).on("keyup", "#barcode", function(e) {
                if ($(this).val().length > 3) {
                    var invoice_no = $('#invoice_no').val();

                    var value = $(this).val();
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "{{ route('findItem') }}",
                        method: "POST",
                        data: {
                            value: value,
                            invoice_no: invoice_no,
                            _token: _token,
                        },
                        success: function(response) {
                            var qty = 1;
                            $("div.search-item select").val(response.item.id);
                            $("#unit_price").val(response.item.total_amount);
                            $("#quantity").focus().val(qty);
                            $("#net_amount").val(response.net_amount);
                            $("#cost_price").val(response.cost_price);
                            $('.common-select2').select2();
                        }

                    })
                }
            });
            $(document).on("keypress", "#quantity", function(e) {
                var key = e.which;
                if (e.which == 13) {
                    $("#temp_invoice").focus();
                    e.preventDefault();
                    return false;
                } else if ($(this).val() != '') {
                    var value = $(this).val();
                    var c = $('#unit_price').val();

                    var cost = c * value;
                    $("#net_amount").val(cost);
                }
            });
            $(document).on("keyup", "#quantity", function(e) {

                var key = e.which;
                if (e.which == 13) {
                    $("#temp_invoice").focus();
                    e.preventDefault();
                    return false;
                } else if ($(this).val() != '') {
                    var value = $(this).val();
                    var invoice_no = $('#invoice_no').val();

                    var unit_price = $('#unit_price').val();
                    var item_name = $('#item_name').val();
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "{{ route('quantityFifo') }}",
                        method: "POST",
                        data: {
                            value: value,
                            invoice_no: invoice_no,
                            unit_price: unit_price,
                            item_name: item_name,
                            _token: _token,
                        },
                        success: function(response) {
                            if (response.fail) {
                                $('.project-error').show().delay(1200).fadeOut();
                            } else if (response.stockout) {
                                $('.stock-out').show().delay(1200).fadeOut();
                            } else {
                                $("#net_amount").val(response.net_amount);
                                $("#cost_price").val(response.cost_price);
                            }
                        }
                    })
                }


            });
            $('#temp_invoice').click(function() {
                // alert(1);
                var branch = $('#branch').val();
                var barcode = $('#barcode').val();
                var quantity = $('#quantity').val();
                var unit_price = $('#unit_price').val();
                var cost_price = $('#cost_price').val();
                var branch = $('#branch').val();
                var invoice_no = $('#invoice_no').val();
                var item_name = $('#item_name').val();
                var net_amount = $('#net_amount').val();
                var _token = $('input[name="_token"]').val();
                // alert(cost_price);
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
                        branch: branch,
                        net_amount: net_amount,

                        barcode: barcode,
                        _token: _token,
                    },
                    success: function(response) {
                        if (response.fail) {
                            $('.project-error').show().delay(1200).fadeOut();
                        } else if (response.stockout) {
                            $('.stock-out').show().delay(1200).fadeOut();
                        } else {
                            var vat = response.total_cost_price - response.total_unit_price;
                            $(".all-data-area").empty().append(response.page);
                            $("#total_gross").val(response.total_cost_price);
                            $("#tarek").val(response.total_unit_price);
                            $("#total_vat").val(response.total_vat_amount);
                            // $("#item_name").val('');
                            $("div.search-item select").val('');
                            $("#unit_price").val('');
                            $("#cost_price").val('');
                            $("#net_amount").val('');
                            $("#quantity").val('');
                            $("#barcode").focus().val('');
                        }
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
                    url: "{{ route('refresh_purchase') }}",
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
                if ($(this).val() != '') {
                    var invoice_no = $('#invoice_no').val();

                    var value = $(this).val();
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "{{ route('findItemId') }}",
                        method: "POST",
                        data: {
                            value: value,
                            invoice_no: invoice_no,
                            _token: _token,
                        },
                        success: function(response) {
                            var qty = 1;
                            $("#barcode").val(response.item.barcode);
                            $("#unit_price").val(response.item.total_amount);
                            $("#quantity").focus().val(qty);
                            $("#net_amount").val(response.net_amount);
                            $("#cost_price").val(response.cost_price);
                        }
                    })
                }
            });
            $('#pay_mode').change(function() {

                if ($(this).val() == 'Cash') {
                    $("div.pay-term select").val(0);
                    $('.common-select2').select2();
                    var value = $('#pay_terms').val()
                    // var value = $(this).val();
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
                            $("#item_name").focus();
                        }
                    })
                } else if ($(this).val() != 'Cash') {
                    $("#pay_terms").focus();
                }
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
                        $("div.customer-select select").val(response.newCustomer.pi_code);
                        $("#trn_no").val(response.newCustomer.trn_no);
                        $("#contact_no").val(response.newCustomer.con_no);
                        $("#address").val(response.newCustomer.address);
                        $("#customerModal").modal('hide');
                    }
                })
            });

            $('#reservationdatetime').datetimepicker({
                icons: {
                    time: 'far fa-clock'
                }
            });


        });
    </script>
@endpush
