@extends('layouts.backend.app')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
@section('content')
    @include('layouts.backend.partial.style')
    <style>
        .changeColStyle span {
            min-width: 16%;
        }

        .changeColStyle .select2-container--default .select2-selection--single .select2-selection__arrow b {
            display: none;
        }

        .journaCreation {
            background: #1214161c;
        }

        .transaction_type {
            padding-right: 5px;
            padding-left: 5px;
            padding-bottom: 5px;
        }

        @media only screen and (max-width: 1500px) {
            .custome-project span {
                max-width: 140px;
            }
        }

        thead {
            background: #34465b;
            color: #fff !important;
        }

        th {
            color: #fff !important;
            font-size: 11px !important;
            height: 25px !important;
            text-align: center !important;
        }

        td {
            font-size: 12px !important;
            height: 25px !important;
        }

        .table-sm th,
        .table-sm td {
            padding: 0rem;
        }

        .card-body {
            flex: 1 1 auto;
            min-height: 1px;
            padding: 0rem !important;
        }

        .card {
            margin-bottom: 0rem;
            box-shadow: none;
        }
    </style>
    <div class="app-content content print-hideen">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <input type="hidden" name="standard_vat_rate" value="{{ $standard_vat_rate }}" id="standard_vat_rate">

                @include('clientReport.purchase._header', ['activeMenu' => 'purchase_expense'])
                <div class="tab-content journaCreation active">
                    <div id="journaCreation" class="tab-pane bg-white active">
                        <div class="py-1 px-1">
                            @include('clientReport.purchase._subhead_purchase', [
                                'activeMenu' => 'create',
                            ])
                        </div>
                        <section id="widgets-Statistics">

                            <form action="{{ route('expensepost') }}" method="POST" id="formSubmit"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="cardStyleChange bg-white">
                                    <div class="card-body ">

                                        <div class="row mx-1 pt-1">
                                            <div class="col-md-3 changeColStyle ">
                                                <div class="row align-items-center">
                                                    <div class="col-3">
                                                        <label for="">Project</label>

                                                    </div>
                                                    <div class="col-9">
                                                        <select name="project_id" id="project_id"
                                                            class="common-select2 w-100" >
                                                            <option value="">Select...</option>
                                                            @foreach ($invoices as $item)
                                                                <option value="{{ $item->id }}">
                                                                    {{ $item->project_code }}-{{ $item->project_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 changeColStyle  col-right-padding d-none">
                                                <div class="row d-flex align-items-center">
                                                    <div class="col-3">
                                                        <label for="project">Branch</label>
                                                    </div>
                                                    <div class="col-9">
                                                        <select name="project" class="common-select2 w-100" id="project"
                                                            required>
                                                            @foreach ($projects as $item)
                                                                <option value="{{ $item->id }}"
                                                                    {{ isset($journalF) ? ($journalF->project_id == $item->id ? 'selected' : '') : '' }}>
                                                                    {{ $item->proj_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('project')
                                                            <div class="btn btn-sm btn-danger">{{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 changeColStyle">
                                                <div class="row aling-items-center">
                                                    <div class="col-5">
                                                        <label for="">Party Code</label>
                                                    </div>
                                                    <div class="col-7">
                                                        <input type="text" name="pi_code" id="pi_code"
                                                            class="form-control inputFieldHeight" required
                                                            placeholder="Party Code">
                                                        @error('party_info')
                                                            <div class="btn btn-sm btn-danger">{{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 changeColStyle search-item-pi">
                                                <div class="row align-items-center">
                                                    <div class="col-3">
                                                        <label for="">Party Name</label>

                                                    </div>
                                                    <div class="col-7 customer-select">
                                                        <select name="party_info" id="party_info"
                                                            class="common-select2 party-info customer"
                                                            style="width: 100% !important" data-target="" required>
                                                            <option value="">Select...</option>
                                                            @foreach ($pInfos as $item)
                                                                <option value="{{ $item->id }}"
                                                                    {{ isset($journalF) ? ($journalF->party_info_id == $item->id ? 'selected' : '') : '' }}>
                                                                    {{ $item->pi_name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('party_info')
                                                            <div class="btn btn-sm btn-danger">{{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-2 col-left-padding d-flex align-items-center">
                                                        <a href="#" data-toggle="modal"
                                                            data-target="#customerModal"><img
                                                                src="{{ asset('assets/backend/app-assets/icon/add-icon.png') }}"
                                                                alt="" srcset="" class="img-fluid"
                                                                style="height:29px"></a>

                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-md-3 changeColStyle">
                                                <div class="row align-items-center">
                                                    <div class="col-2">
                                                        <label for="">
                                                            @if (!empty($currency->licence_name))
                                                                {{ $currency->licence_name }}
                                                            @endif
                                                        </label>

                                                    </div>
                                                    <div class="col-10">
                                                        <input type="text" class="form-control inputFieldHeight"
                                                            value="{{ isset($journalF) ? $journalF->partyInfo->trn_no : '' }}"
                                                            name="trn_no" id="trn_no" class="form-control" readonly>
                                                        @error('trn_no')
                                                            <div class="btn btn-sm btn-danger">{{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3 changeColStyle">
                                                <div class="row align-items-center">
                                                    <div class="col-3">
                                                        <label for="">
                                                            Contact
                                                        </label>

                                                    </div>
                                                    <div class="col-9">
                                                        <input type="text" class="form-control inputFieldHeight"
                                                            value="" name="party_contact" id="party_contact"
                                                            class="form-control" readonly>
                                                        @error('party_contact')
                                                            <div class="btn btn-sm btn-danger">{{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3 changeColStyle">
                                                <div class="row align-items-center">
                                                    <div class="col-3">
                                                        <label for="">
                                                            Address
                                                        </label>

                                                    </div>
                                                    <div class="col-9">
                                                        <input type="text" class="form-control inputFieldHeight"
                                                            value="" name="party_address" id="party_address"
                                                            class="form-control" readonly>
                                                        @error('party_address')
                                                            <div class="btn btn-sm btn-danger">{{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3 changeColStyle">
                                                <div class="row align-items-center">
                                                    <div class="col-4">
                                                        <label for="">Payment Mode</label>

                                                    </div>
                                                    <div class="col-8">
                                                        <select name="pay_mode" id="pay_mode"
                                                            class="form-control inputFieldHeight" required>
                                                            <option value="">Select...</option>

                                                            @foreach ($modes as $item)
                                                                <option value="{{ $item->title }}"
                                                                    {{ isset($journalF) ? ($journalF->txn_mode == $item->title ? 'selected' : '') : '' }}>
                                                                    {{ $item->title }} </option>
                                                            @endforeach
                                                        </select>
                                                        @error('pay_mode')
                                                            <div class="btn btn-sm btn-danger">{{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3 changeColStyle" id="printarea">
                                                <div class="row align-items-center">
                                                    <div class="col-2">
                                                        <label for="">Date</label>
                                                    </div>
                                                    <div class="col-10">
                                                        <input type="text"
                                                            value="{{ Carbon\Carbon::now()->format('d/m/Y') }}"
                                                            class="form-control inputFieldHeight datepicker"
                                                            name="date" placeholder="dd-mm-yyyy">
                                                        @error('date')
                                                            <div class="btn btn-sm btn-danger">{{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3 changeColStyle">
                                                <div class="row align-items-center">
                                                    <div class="col-3">
                                                        <label for="">Invoice No</label>
                                                    </div>
                                                    <div class="col-9">
                                                        <input type="text" name="invoice_no" id="invoice_no"
                                                            class="form-control inputFieldHeight" value="" required>
                                                        @error('pay_mode')
                                                            <div class="btn btn-sm btn-danger">{{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3 changeColStyle">
                                                <div class="row align-items-center">
                                                    <div class="col-3">
                                                        <label for="">Bill</label>
                                                    </div>
                                                    <div class="col-9">
                                                        <input type="text" name="" id=""
                                                            class="form-control inputFieldHeight"
                                                            value="{{ $purchase_expense_no }}" disabled>
                                                        @error('pay_mode')
                                                            <div class="btn btn-sm btn-danger">{{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3 changeColStyle">
                                                <div class="row align-items-center d-flex justify-content-end">
                                                    <div class="col-4">
                                                        <label for="">Invoice Type</label>
                                                    </div>
                                                    <div class="col-8">
                                                        <select name="invoice_type" id="invoice_type"
                                                            class="form-control inputFieldHeight" required>
                                                            <option value="Tax Invoice">With Tax</option>
                                                            <option value="Proforma Invoice">Without Tax</option>
                                                        </select>
                                                        @error('invoice_type')
                                                            <div class="btn btn-sm btn-danger">{{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-right-padding col-left-padding"
                                    style="margin-top:25px !important">
                                    <div class="row mx-1">
                                        <div class="cardStyleChange" style="width: 100%">
                                            <div class="card-body bg-white">
                                                <table class="table  table-sm ">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 25%">Description</th>
                                                            {{-- <th>QTY</th> --}}
                                                            <th>Task</th>
                                                            {{-- <th>Unit</th> --}}
                                                            <th>Amount</th>
                                                            <th class="vat-exist" style="width: 10%">Vat Rate</th>
                                                            <th class="vat-exist" style="width: 10%">Vat Amount</th>
                                                            <th>Total Amount</th>
                                                            <th class="NoPrint" style="width: 10px;padding: 2px;"> <button type="button"
                                                                    class="btn btn-sm btn-success addBtn"style="border: 1px solid green;
                                                                        color: #fff; border-radius: 10px;padding: 5px;"
                                                                    onclick="BtnAdd()"><i class="bx bx-plus" style="color: white;margin-top: -5px;"></i></button>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="TBody">
                                                        <tr id="TRow" class="text-center invoice_row">
                                                            <td>
                                                                <div
                                                                    class="d-flex justy-content-between align-items-center">
                                                                    <input type="text"
                                                                        name="group-a[0][multi_acc_head]" step="any"
                                                                        required placeholder="Item Description"
                                                                        class="text-center form-control inputFieldHeight2"style="width: 100%;height:36px;">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <select name="group-a[0][task]"
                                                                class="inputFieldHeight2 task_id form-control "
                                                                style="width: 100%;    HEIGHT: 36PX;">
                                                                <option value="" style="text-align:center;"> -- Choice Option --
                                                                </option>

                                                            </select>
                                                            </td>

                                                            <td>
                                                                <div
                                                                    class="d-flex justy-content-between align-items-center">
                                                                    <input type="number" step="any" name="group-a[0][amount]"
                                                                        step="any" required placeholder="Amount"
                                                                        class="text-center form-control inputFieldHeight2 amount"style="width: 100%;height:36px;">
                                                                </div>
                                                            </td>


                                                            <td class="vat-exist">
                                                                <select name="group-a[0][vat_rate]" required
                                                                    class="inputFieldHeight2 vat_rate form-control "
                                                                    style="width: 100%;HEIGHT: 36PX;text-align:center;">
                                                                    <option value=""> -- Choice Option --
                                                                    </option>
                                                                    @foreach ($vats as $vat)
                                                                        <option value="{{ $vat->value }}">
                                                                            {{ $vat->name . ' (' . $vat->value . ')' }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>

                                                            </td>

                                                            <td class="vat-exist"><input type="number" step="any"
                                                                    class="text-center form-control vat_amount inputFieldHeight2"
                                                                    required placeholder="Vat Amount"
                                                                    name="group-a[0][vat_amount]" readonly>
                                                            </td>
                                                            <td>
                                                                <input type="number" step="any"
                                                                    name="group-a[0][sub_gross_amount]" required
                                                                    class="text-center form-control sub_gross_amount inputFieldHeight2"
                                                                    placeholder="Amount" style="width: 100%;height:36px;"
                                                                    readonly>
                                                            </td>
                                                            </td>
                                                            <td class="NoPrint text-center"><button style="padding: 5px; margin: 4px;"
                                                                    type="button"
                                                                    class="btn btn-sm btn-danger"onclick="BtnDel(this)"><i class="bx bx-trash" style="color: white;margin-top: -5px;"></i></button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    <tbody>
                                                        <tr>
                                                            <td class="vat-exist"></td>
                                                            <td class="vat-exist"></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td class="text-center" style="color: black">TOTAL</td>
                                                            <td><input type="number" step="any" readonly
                                                                    id="taxable_amount"
                                                                    class="text-center form-control inputFieldHeight2 @error('taxable_amount') error @enderror inputFieldHeight taxable_amount"
                                                                    name="taxable_amount" value=""
                                                                    placeholder="Amount" readonly required>
                                                                @error('taxable_amount')
                                                                    <span class="error">{{ $message }}</span>
                                                                @enderror
                                                            </td>
                                                        </tr>
                                                        <tr class="text-center">
                                                            <td class="vat-exist"></td>
                                                            <td class="vat-exist"></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td class="text-center" style="color: black">VAT</td>
                                                            <td><input type="number" step="any" readonly
                                                                    id="total_vat"
                                                                    class="text-center inputFieldHeight2 form-control @error('total_vat') error @enderror inputFieldHeight total_vat"
                                                                    name="total_vat" value=""
                                                                    placeholder="@if (!empty($currency->vat_name)) {{ $currency->vat_name }} @endif SUBTOTAL"
                                                                    readonly required>
                                                                @error('total_vat')
                                                                    <span class="error">{{ $message }}</span>
                                                                @enderror
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="vat-exist"></td>
                                                            <td class="vat-exist"></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td class="text-center" style="color: black">TOTAL AMOUNT</td>
                                                            <td><input type="number" step="any" readonly
                                                                    id="total_amount"
                                                                    class="text-center inputFieldHeight2 form-control @error('total_amount') error @enderror inputFieldHeight total_amount"
                                                                    name="total_amount" value=""
                                                                    placeholder="TOTAL " readonly required>
                                                                @error('total_amount')
                                                                    <span class="error">{{ $message }}</span>
                                                                @enderror
                                                            </td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="cardStyleChange">
                                    <div class="card-body bg-white">
                                        <div class="row px-1">
                                            <div class="col-sm-6 form-group">
                                                <label for="">Narration</label>
                                                <input type="text" class="form-control inputFieldHeight"
                                                    name="narration" id="narration" placeholder="Narration"
                                                    value="{{ isset($journalF) ? $journalF->narration : '' }}" required>
                                            </div>

                                            <div class="col-sm-2 form-group">
                                                <label for="">Voucher Scan/File</label>
                                                <input type="file" class="form-control inputFieldHeight"
                                                    name="voucher_scan" accept="image/*">
                                            </div>

                                            <div class="col-sm-2 form-group">
                                                <label for="">Voucher Scan/File 2</label>
                                                <input type="file" class="form-control inputFieldHeight"
                                                    name="voucher_scan2" accept="image/*">
                                            </div>
                                            <div class="col-sm-2 text-right d-flex justify-content-end mt-2 mb-1">
                                                <button type="submit" class="btn btn-primary formButton "
                                                    id="submitButton">
                                                    <div class="d-flex">
                                                        <div class="formSaveIcon">
                                                            <img src="{{ asset('assets/backend/app-assets/icon/save-icon.png') }}"
                                                                alt="" srcset="" width="25">
                                                        </div>
                                                        <div><span>Save</span></div>
                                                    </div>
                                                </button>
                                                <a href="{{route("purchase-expense")}}" class="btn btn-warning  d-none" id="newButton">New</a>


                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </form>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- modal --}}
    <!-- END: Content-->
    <div class="modal fade bd-example-modal-lg" id="voucherPreviewModal" tabindex="-1" rrole="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div id="voucherPreviewShow">

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg" id="voucherDetailsPrintModal" tabindex="-1" rrole="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div id="voucherDetailsPrint">

                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
    <script src="{{ asset('assets/backend') }}/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
    <script src="{{ asset('assets/backend') }}/app-assets/js/scripts/forms/select/form-select2.js"></script>
    <script src="{{ asset('assets/backend') }}/app-assets/vendors/js/forms/repeater/jquery.repeater.min.js"></script>
    <script src="{{ asset('assets/backend') }}/app-assets/js/scripts/forms/form-repeater.js"></script>
    {{-- js work by mominul start --}}
    <script>
        function refreshPage() {
            window.location.reload();
        }
    </script>
    {{-- js work by mominul end --}}

    <script>
        $(document).ready(function() {

            // $('.btn_create').click(function(){
            $(document).on("click", ".btn_create", function(e) {
                e.preventDefault();
                // alert('Alhamdulillah');
                setTimeout(function() {
                    $('.multi-acc-head').select2();
                    $('.multi-tax-rate').select2();
                }, 1000);
            });


            $("#formSubmit").submit(function(e) {
                e.preventDefault(); // avoid executing the actual submit of the form.
                var form = $(this);
                var url = form.attr('action');
                $.ajax({
                    url: url,
                        method: 'POST',
                        data: new FormData(this),
                        dataType: 'JSON',
                        contentType: false,
                        cache: false,
                        processData: false,
                    success: function(response) {
                        alert(1)

                        if (response.warning) {
                            toastr.warning("{{ Session::get('message') }}", response.warning);
                        } else if (response.status) {
                            // Handle validation errors
                            for (var i = 0; i < Object.keys(response.status).length; i++) {
                                var key = i + ".invoice";
                                if (response.status.hasOwnProperty(key)) {
                                    var errorMessages = response.status[key];
                                    for (var j = 0; j < errorMessages.length; j++) {
                                        toastr.warning(errorMessages[j]);
                                    }
                                }
                            }
                        } else {
                            alert(1)
                            $("#submitButton").prop("disabled", true)
                            $(".deleteBtn").prop("disabled", true)
                            $(".addBtn").prop("disabled", true)
                            document.getElementById("voucherPreviewShow").innerHTML = response;
                            $('#voucherPreviewModal').modal('show');
                            $("#newButton").removeClass("d-none")
                            $("#submitButton").addClass("d-none")
                        }
                    },
                    error: function(err) {
                        let error = err.responseJSON;
                        $.each(error.errors, function(index, value) {
                            toastr.error(value, "Error");
                        });
                    }
                });
            });

            $("#date").focus();
            $('#project').change(function() {
                console.log($(this).val());
                if ($(this).val() != '') {
                    var value = $(this).val();
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "{{ route('findProject') }}",
                        method: "POST",
                        data: {
                            value: value,
                            _token: _token,
                        },
                        success: function(response) {
                            console.log(response);
                            $("#owner").val(response.owner_name);
                            $("#location").val(response.address);
                            $("#address").val(response.address);
                            $("#mobile").val(response.cont_no);
                        }
                    })
                }
            });

            $('#party_info').change(function() {
                if ($(this).val() != '') {
                    var value = $(this).val();
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "{{ route('partyInfoInvoice2') }}",
                        method: "POST",
                        data: {
                            value: value,
                            _token: _token,
                        },
                        success: function(response) {
                            console.log(response);
                            $("#trn_no").val(response.trn_no);
                            $("#pi_code").val(response.pi_code);
                            $("#party_contact").val(response.con_no);
                            $("#party_address").val(response.address);
                            $("#invoice_no").focus();
                        }
                    })
                }
            });

            $(document).on("keyup", "#pi_code", function(e) {
                // alert(1);
                var value = $(this).val();
                var _token = $('input[name="_token"]').val();
                if ($(this).val() != '') {
                    $.ajax({
                        url: "{{ route('partyInfoInvoice3') }}",
                        method: "POST",
                        data: {
                            value: value,
                            _token: _token,
                        },
                        success: function(response) {
                            console.log(response);
                            var qty = 1;
                            if (response != '') {
                                $("div.search-item-pi select").val(response.id);
                                $('.common-select2').select2();
                                $("#trn_no").val(response.trn_no);
                                $("#party_contact").val(response.con_no);
                                $("#party_address").val(response.address);

                                $("#invoice_no").focus();
                            }
                        }
                    })
                }
            });





            $(document).on("change", "#party", function(e) {
                e.preventDefault();
                $('.date').val('')
                var id = $(this).val();
                var invoice_no = $('#invoice_no').val();
                $.ajax({
                    url: "{{ URL('find-invoice') }}",
                    type: "post",
                    cache: false,
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id,
                        invoice_no: invoice_no,
                    },
                    success: function(response) {
                        $('#table-body').empty().append(response);
                    }
                });
            });


            $(document).on("keyup", "#invoice_no", function(e) {
                var inv = $(this).val();
                var party = $('#party_info').val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('invoice_no_validation') }}",
                    method: "POST",
                    data: {
                        inv: inv,
                        party: party,
                        _token: _token,
                    },
                    success: function(response) {
                        if (response.warning) {
                            toastr.warning(response.warning);
                        }
                    }
                })
            });


            $(document).on("change", "#invoice_type", function(e) {
                if ($(this).val() == 'Tax Invoice') {
                    $('.vat-exist').show();
                    $('.vat_rate').val('');
                    $(".vat_rate").attr('required',true);

                } else {
                    $('.vat-exist').hide();
                    $('.vat_amount').val(0);
                    $(".vat_rate").removeAttr('required');


                }
                total()
            });



            $(document).on("keyup", ".amount", function(e) {
                var amount = $(this).val();
                var invoice_type = $('#invoice_type').val();
                var vat_amount = 0;
                if (invoice_type == 'Tax Invoice') {
                    var vat_rate = $(this).closest("tr").find(".vat_rate").val();
                    vat_amount = (vat_rate / 100) * amount;

                    amount = (amount*1) + vat_amount;
                }
                amount=amount*1;
                $(this).closest("tr").find(".vat_amount").val(vat_amount.toFixed(2));
                $(this).closest("tr").find(".sub_gross_amount").val(amount.toFixed(2));
                total();

            });



            $(document).on("change", ".vat_rate", function(e) {
                var amount = $(this).closest("tr").find(".amount").val();
                var invoice_type = $('#invoice_type').val();
                var vat_amount = 0;
                if (invoice_type == 'Tax Invoice') {
                    var vat_rate = $(this).val();
                    vat_amount = (vat_rate / 100) * amount;

                    amount = (amount*1) + vat_amount;
                }
                $(this).closest("tr").find(".vat_amount").val(vat_amount.toFixed(2));

                $(this).closest("tr").find(".sub_gross_amount").val(amount.toFixed(2));

                total();
            });

            $(document).on("change", "#project_id", function(e) {
                var project = $(this).val();
                $.ajax({
                    url: "{{ URL('find-project-task') }}",
                    type: "post",
                    cache: false,
                    data: {
                        _token: '{{ csrf_token() }}',
                        project: project,
                    },
                    success: function(response) {
                        $('.task_id').empty().append(response);
                    }
                });
            });

            function total() {
                var sum=0;
                var total_vat = 0;
                $('.amount').each(function() {
                    var this_amount = $(this).val();
                    this_amount = (this_amount === '') ? 0 : this_amount;
                    var this_amount = parseFloat(this_amount);
                    sum = sum + this_amount;
                });
                $('.vat_amount').each(function() {
                    var this_amount = $(this).val();
                    this_amount = (this_amount === '') ? 0 : this_amount;
                    var this_amount = parseFloat(this_amount);
                    //
                    total_vat = total_vat + this_amount;
                });
                var taxable = sum.toFixed(2)
                var vat = total_vat.toFixed(2)
                var total =(vat*1)+(taxable*1)
                $(".taxable_amount").val(taxable);
                $(".total_vat").val(vat);
                $(".total_amount").val((total.toFixed(2)));
            };

        });

        function BtnAdd() {
            /* Add Button */
            var newRow = $("#TRow").clone();
            newRow.removeClass("d-none");
            newRow.find("input, select").val('').attr('name', function(index, name) {
                return name.replace(/\[\d+\]/, '[' + ($('#TBody tr').length) + ']');
            });
            newRow.find("th").first().html($('#TBody tr').length + 1);
            newRow.appendTo("#TBody");
            newRow.find(".common-select2").select2();
        }

        function BtnDel(v) {
            /* Delete Button */
            $(v).parent().parent().remove();

            $("#TBody").find("tr").each(function(index) {
                $(this).find("th").first().html(index);
            });
        }
    </script>
@endpush
