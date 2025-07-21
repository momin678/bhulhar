

@extends('layouts.backend.app')
@push('css')
@include('layouts.backend.partial.style')

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

        .select2-container .select2-selection--single .select2-selection__rendered {
            display: block;
            padding-left: 0px;
            padding-right: 0px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
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

    </style>
@endpush
@section('content')

<div class="app-content content print-hideen">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            @include('clientReport.purchase.pruchase_header',['activeMenu'=>'purchase'])
            <div class="tab-content bg-white">
                <div class="tab-pane active">
                    <div class="row" id="table-bordered">
                        <div class="col-12">
                            <div class="cardStyleChange">
                                 <!-- Widgets Statistics start -->
                                <section id="widgets-Statistics " class="p-2">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div class="row">
                                                <div class="col-12">
                                                    <h4>Purchase Order</h4>
                                                </div>
                                            </div>
                                            <form action="{{ route('previewSavePurchase') }}" method="POST" >
                                                @csrf
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="card d-flex align-items-center">
                                                            <div class="card-body">
                                                                <div class="row d-flex align-items-center">
                                                                    <div class="col-sm-3 form-group">
                                                                        <label for="">Branch</label>
                                                                        <select name="branch" class="common-select2" style="width: 100% !important" id="branch" required>
                                                                            @foreach ($projects as $item)
                                                                                <option value="{{ $item->id }}">{{ $item->proj_name }}
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
                                                                    <input type="text" name="gl_code" id="gl_code" value="{{ isset($gl_code)?$gl_code->fld_ac_code:"" }}" class="form-control" readonly>

                                                                    </div>
                                                                    <div class="col-sm-3 form-group" id="printarea">
                                                                        <label for="">Purchase Date</label>
                                                                        <input type="text" value="" class="form-control" name="date" id="date" required placeholder="dd/mm/yyyy">
                                                                    </div>
                                                                    <div class="col-sm-3 form-group d-none">
                                                                        <label for="">Purchase No</label>
                                                                        <input type="text" class="form-control"
                                                                            value="{{ $purchase->purchase_no }}" name="purchase_no"
                                                                            id="purchase_no" readonly>
                                                                    </div>
                                                                    <div class="col-sm-3 form-group">
                                                                        <label for="">Payment Mode</label>
                                                                        <select name="pay_mode" id="pay_mode" class="common-select2" style="width: 100% !important" required>
                                                                            <option value="">Select...</option>
                                                                            @foreach ($modes as $item)
                                                                                <option value="{{ $item->title }}" {{ $item->title=="Cash"? 'selected':'' }}>{{ $item->title }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-sm-2 form-group pay-term d-none">
                                                                        <label for="">Payment Terms</label>
                                                                        <select name="pay_terms" id="pay_terms" class="common-select2" style="width: 100% !important"
                                                                            required>
                                                                            <option value="">Select...</option>
                                                                            @foreach ($terms as $item)
                                                                                <option value="{{ $item->value }}" {{ $item->title=="Today"? 'selected':'' }}>{{ $item->title }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-sm-3 form-group d-none">
                                                                        <label for="">Due Date</label>
                                                                        <input type="date" class="form-control" name="due_date"
                                                                            id="due_date" value="{{ date('Y-m-d') }}" readonly>
                                                                    </div>
                                                                    <div class="col-sm-3 form-group customer-select">
                                                                        <label for="">Supplier Name</label>
                                                                        <select name="customer_name" id="customer_name"
                                                                            class="common-select2 party-info customer" style="width: 100% !important" data-target="" required>
                                                                            <option value="">Select...</option>
                                                                            @foreach ($customers as $customer)
                                                                                <option value="{{ $customer->pi_code }}" >
                                                                                    {{ $customer->pi_name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-sm-1 d-none">
                                                                        <i class="bx bx-user-plus btn btn-info btn-sm text-center" data-toggle="modal" data-target="#customerModal"></i>
                                                                    </div>
                                                                    <div class="col-sm-3 form-group">
                                                                        <label for="">TRN</label>
                                                                        <input type="text" class="form-control" name="trn_no" id="trn_no"
                                                                            class="form-control" readonly>
                                                                    </div>


                                                                    <div class="col-sm-3 form-group">
                                                                        <label for="">Contact Number</label>
                                                                        <input type="text" class="form-control" name="contact_no"
                                                                            id="contact_no" readonly>
                                                                    </div>

                                                                    <div class="col-sm-3 form-group">
                                                                        <label for="">Address</label>
                                                                        <input type="text" class="form-control" name="address"
                                                                            id="address" readonly>
                                                                    </div>

                                                                    <div class="col-sm-3 form-group">
                                                                        <label for="">Supplier Invoice</label>
                                                                        <input type="text" class="form-control" name="supplier_invoice"
                                                                            id="supplier_invoice" >
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row pb-1">
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col-sm-3 search-style col-right-padding ">
                                                                <label class="invoice-label" for="">Product Name</label>
                                                                <select name="product_id" id="product_id" class="common-select2" style="width: 100% !important"  >
                                                                    <option value="">Select Product</option>
                                                                    @foreach ($itms as $item)
                                                                    <option style="width: 100px" value="{{ $item->id }}">{{ $item->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="col-sm-3 search-color col-right-padding col-left-padding" id="brand2">
                                                                <label class="invoice-label" for="">Category</label>
                                                                <input type="decimal" name="category_name" class="form-control" id="category_name" readonly>
                                                            </div>
                                                            <div class="col-sm-3 search-color col-right-padding col-left-padding">
                                                                <label class="invoice-label" for="">Brand</label>
                                                                <input type="decimal" name="brand_name" class="form-control" id="brand_name" readonly>
                                                            </div>

                                                            <div class="col-sm-3 search-color col-right-padding col-left-padding" id="unit2">
                                                                <label class="invoice-label" for="">Unit</label>
                                                                <input type="decimal" name="unit_name" class="form-control" id="unit_name" readonly>
                                                            </div>
                                                            <div class="col-sm-3 search-item search-size col-right-padding col-left-padding item-part">
                                                                <label class="invoice-label" for="">QTY</label>
                                                                <input type="decimal" name="amount" class="form-control" id="amount" >
                                                            </div>
                                                            <div class="col-sm-3 col-right-padding col-left-padding">
                                                                <label class="invoice-label" for="">Price</label>
                                                                <input type="decimal" class="form-control" name="price"
                                                                    id="price" >
                                                            </div>
                                                            <div class="col-sm-2 col-right-padding col-left-padding d-none">
                                                                <label class="invoice-label" for="">Discount</label>
                                                                <input type="decimal" class="form-control" name="discount_price"
                                                                    id="discount_price" >
                                                            </div>
                                                            <div class="col-sm-3 search-item search-size col-right-padding col-left-padding item-part">
                                                                <label class="invoice-label" for="">Total Price</label>
                                                                <input type="decimal" name="unit_price" class="form-control" id="unit_price" readonly>
                                                            </div>

                                                            <div class="col-sm-1">
                                                                <label for=""></label>
                                                                <div class="row">
                                                                    <input type="button" name="temp_invoice" class="btn btn-warning text-right" value="Add" id="temp_invoice">
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
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="">
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div class="row d-flex justify-content-end pt-1">
                                                    <div class="col-md-4">
                                                        {{-- <div class="form-group row">
                                                            <label for="" class="col-7 d-flex align-items-center col-right-padding col-left-padding">TAXABLE SUPPLIES (AED):</label>
                                                            <input type="text" class="form-control col-5 col-right-padding" name="tax_sup" id="tarek"
                                                                    min="0" step="any" class="form-control" value="0.00" readonly>
                                                        </div> --}}

                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group row">
                                                            <label for="" class="col-5 d-flex align-items-center col-right-padding">VAT (AED):</label>
                                                            <input type="number" placeholder="VAT" min="0" step="any"
                                                            class="form-control col-7 col-right-padding" value="0.00" name="total_vat"
                                                            id="total_vat" readonly>
                                                        </div>

                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group row">
                                                            <label for="" class="col-6 d-flex align-items-center col-right-padding">Total Gross (AED):</label>
                                                            <input type="number" name="total_gross" placeholder="Final Discount"
                                                            min="0" step="any" class="form-control col-6 col-right-padding" value="0.00"
                                                            id="total_gross" readonly>
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12 text-center">
                                                        <button type="submit"
                                                                            class="btn btn-sm final-save-btn only-save-btn  btn-primary" id="final_save">
                                                                            Save</button>
                                                                            <a  class="btn btn-sm btn-warning" onClick="refreshPage()">Refresh</a>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="row">
                                                <h5 style="white-space: nowrap;">Purchases </h5>
                                                <input type="text" class="form-control w-100" placeholder="Serach Purchase No" name="invoice_no" id="invoice_no_s">
                                                <i class="bx bx-refresh btn btn-sm" id="refresh_invoice">Refresh</i>
                                                <div class="invoice-items">
                                                    <ul>
                                                        @foreach ($purchases as $purch)
                                                        <li><a href="{{ route('purchaseView', $purch) }}">{{ $purch->purchase_no }}</a></li>

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
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="customerModal" tabindex="-1" role="dialog" aria-labelledby="customerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">New Supplier Form</h5>
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
                                    <label>Party Code</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="text" id=""
                                        class="form-control" name=""
                                        value="{{ $cc }}"
                                        placeholder="Party Code" disabled readonly>

                                </div>
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
                                <div class="col-md-8 form-group">
                                    <select name="pi_type" class="common-select2" style="width: 100% !important"
                                        id="pi_type" required>
                                        <option value="">Select...</option>
                                        @foreach ($costTypes as $item)
                                            <option value="{{ $item->title }}"
                                                {{ isset($costCenter) ? ($costCenter->pi_type == $item->title ? 'selected' : '') : '' }}>
                                                {{ $item->title }}</option>
                                        @endforeach
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
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
    {{-- <script src="{{ asset('assets/backend/app-assets/vendors/js/jquery/jquery.min.js') }}"></script> --}}
    <script>
        function refreshPage(){
            window.location.reload();
        }
        $(document).ready(function() {
            $(document).on("change", "#product_id", function(e) {
                if ($(this).val() != '') {
                    var product_id = $(this).val();
                    // alert(product_id);
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "{{ route('get-product-info') }}",
                        method: "POST",
                        data: {
                            product_id: product_id,
                            _token: _token,
                        },
                        success: function(response) {
                            $("#category_name").val(response[1].name);
                            if(response[2]){
                                $("#brand_name").val(response[2].name);
                            }else{
                                $("#brand_name").val('');
                            }
                            $("#unit_name").val(response[3].name);
                        }
                    })
                }
            });
            $(document).on("change", "#category", function(e) {
                if ($(this).val() != '') {
                    var category = $(this).val();
                    // alert(category);
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "{{ route('brand.fetch') }}",
                        method: "POST",
                        data: {
                            category: category,
                            _token: _token,
                        },
                        success: function(response) {
                            $("#brand2").empty().append(response.page);
                            $("#sub_brand2").empty();
                        }
                    })
                }
            });

            $(document).on("change", "#brand", function(e) {
                if ($(this).val() != '') {
                var brand = $(this).val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('sub_brand.fetch') }}",
                    method: "POST",
                    data: {
                        brand: brand,
                        _token: _token,
                    },
                    success: function(response) {
                        $("#sub_brand2").empty().append(response.page);
                    }
                })
            }
            });

            $(document).on("keyup", "#amount_from", function(e) {
                var value = $(this).val();
                var c = $('#total_gross').val();
                var to = value-c;
                $("#amount_to").val(to);
            });
            $(document).on("keypress", "#amount_from", function(e) {
                var key = e.which;
                if (e.which == 13) {
                    $("#final_save").focus();
                    e.preventDefault();
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
                            date:date,
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
                            date:date,
                            _token: _token,
                        },
                        success: function(response) {
                            $("#due_date").val(response);
                        }

                    })
                }
            });

            $('#temp_invoice').click(function() {
                // alert(1);
                var product_id = $('#product_id').val();
                var unit_price = $('#unit_price').val();
                var discount_price = $('#discount_price').val();
                var amount = $('#amount').val();
                var unit = $('#unit').val();
                var price = $('#price').val();
                var purchase_no = $('#purchase_no').val();
                var _token = $('input[name="_token"]').val();
                // alert(cost_price);
                $.ajax({
                    url: "{{ route('purchaseTemp') }}",
                    method: "GET",
                    data: {
                        product_id: product_id,
                        unit_price:unit_price,
                        discount_price:discount_price,
                        amount: amount,
                        unit:unit,
                        price: price,
                        _token: _token,
                        purchase_no:purchase_no
                    },
                    success: function(response) {
                        if(response.error)
                        {
                            toastr.error("{{ Session::get('message') }}",(response.error));
                        }
                        else
                        {
                        var vat = response.total_cost_price - response.total_unit_price;
                        $(".all-data-area").empty().append(response.page);
                        $("#total_gross").val(response.total_cost_price);
                        $("#tarek").val(response.total_unit_price);
                        $("#total_vat").val(response.vat_price);

                        // $("#item_name").val('');
                            $("div.search-item select").val('');
                            $("#unit_price").val('');
                            $("#discount_price").val('');
                            $("#cost_price").val('');
                            $("#net_amount").val('');
                            $("#quantity").val('');
                            $("#barcode").focus().val('');
                            $('.common-select2').select2();
                        }
                    }
                })


            });

            $(document).on("change", "#sub_brand", function(e) {
                if ($(this).val() != '') {
                    // alert(1);

                var brand = $(this).val();

                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('unit.fetch') }}",
                    method: "POST",
                    data: {
                        brand: brand,
                        _token: _token,
                    },
                    success: function(response) {
                        $("#unit2").empty().append(response.page);

                    }

                })
            }
            });

            $('#temp_invoice2').click(function() {
                // alert(1);
                var category = $('#service').val();
                // alert(sub_brand);
                var amount = $('#amount2').val();
                var price = $('#price2').val();
                var invoice_no = $('#invoice_no').val();
                var _token = $('input[name="_token"]').val();
                // alert(cost_price);
                $.ajax({
                    url: "{{ route('purchaseTemp') }}",
                    method: "GET",
                    data: {
                        category: category,
                        price: price,
                        _token: _token,
                        invoice_no:invoice_no
                    },
                    success: function(response) {
                        if(response.error)
                        {
                            toastr.error("{{ Session::get('message') }}",(response.error));
                        }
                        else
                        {
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
                            $('.common-select2').select2();
                        }
                    }
                })
            });

            $(document).on("keyup", "#price", function(e) {
                if ($(this).val() != '') {
                    var value = $(this).val();
                    // alert($('#amount').val());
                    var c = value*$('#amount').val();
                    if(c=="Infinity")
                    {
                        var c=0;
                        $("#unit_price").val(parseFloat(c).toFixed(2));
                    }
                    else
                    {
                        $("#unit_price").val(parseFloat(c).toFixed(2));
                    }
                }
            });
            $(document).on("keyup", "#amount", function(e) {
                if ($(this).val() != '') {

                    var value = $(this).val();
                    // alert($('#amount').val());
                    var c = $('#price').val()*value;
                    // alert(c);

                    if(c=="Infinity")
                    {
                        var c=0;
                        $("#unit_price").val(parseFloat(c).toFixed(2));
                    }
                    else
                    {
                        $("#unit_price").val(parseFloat(c).toFixed(2));
                    }
                }
                });
            $(document).on("keypress", "#quantity", function(e) {
                var key = e.which;
                if (e.which == 13) {
                    $("#temp_invoice").focus();
                    e.preventDefault();
                    return false;
                }
                else if ($(this).val() != '') {
                    var value = $(this).val();
                    var c = $('#unit_price').val();

                    var cost = c * value;
                    $("#net_amount").val(cost);
                }
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






            $('#pay_mode').change(function() {

                if ($(this).val() == 'Cash') {
                    $("div.pay-term select").val(0);
                    $('.common-select2').select2();
                    var value=$('#pay_terms').val()
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
                }
                else if($(this).val() != 'Cash')
                {
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

