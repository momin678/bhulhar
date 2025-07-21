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

                @include('clientReport.sales._header', ['activeMenu' => 'g'])
                <div class="tab-content journaCreation active">
                    <div id="journaCreation" class="tab-pane bg-white active">
                    <div class="py-1 px-2">
                        @include('clientReport.sales._subhead_sale', [ 'activeMenu' => 'edit',])
                    </div>
                        <section id="widgets-Statistics">
                            <form action="{{ route('saleIssuepost.edit') }}" method="POST" id="formSubmit"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="cardStyleChange bg-white">
                                    <div class="card-body ">

                                        <div class="row mx-1 pt-1">
                                            <div class="col-md-2 changeColStyle  col-right-padding d-none">
                                                <div class="row d-flex align-items-center">
                                                    <div class="col-3">
                                                        <label for="project">Branch</label>
                                                    </div>
                                                    <input type="hidden" value="{{$sales->id}}" name="id">
                                                    <div class="col-9">
                                                        <select name="project" class="common-select2 w-100" id="project"
                                                            required>
                                                            @foreach ($projects as $item)
                                                                <option value="{{ $item->id }}"
                                                                   {{isset($sales->project_id) ? ($sales->project_id == $item->id ? 'selected' : '') : '' }}>
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
                                                    <div class="col-4">
                                                        <label for="">Party Code</label>
                                                    </div>
                                                    <div class="col-8">
                                                        <input type="text" name="pi_code" id="pi_code" value="{{$sales->party->pi_code}}"
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
                                                    <div class="col-2">
                                                        <label for="">Party Name</label>

                                                    </div>
                                                    <div class="col-8 customer-select">
                                                        <select name="party_info" id="party_info"
                                                            class="common-select2 party-info customer"
                                                            style="width: 100% !important" data-target="" required>
                                                            <option value="">Select...</option>
                                                            @foreach ($pInfos as $item)
                                                                <option value="{{ $item->id }}"
                                                                    {{ isset($sales->party_id) ? ($sales->party_id == $item->id ? 'selected' : '') : '' }}>
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
                                                        value="{{$sales->party->trn_no}}"
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
                                                        value="{{$sales->party->con_person}}"
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
                                                        value="{{$sales->party->address}}"
                                                        name="party_address" id="party_address"
                                                            class="form-control" readonly>
                                                        @error('party_address')
                                                            <div class="btn btn-sm btn-danger">{{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>




                                            <div class="col-md-2 changeColStyle">
                                                <div class="row align-items-center">
                                                    <div class="col-5">
                                                        <label for="">Payment Mode</label>

                                                    </div>
                                                    <div class="col-7">
                                                        <select name="pay_mode" id="pay_mode"
                                                            class="form-control inputFieldHeight" required>
                                                            <option value="">Select...</option>

                                                            @foreach ($modes as $item)
                                                                <option value="{{ $item->title }}"
                                                                    {{ isset($sales) ? ($sales->pay_mode == $item->title ? 'selected' : '') : '' }}>
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

                                            <div class="col-md-2 changeColStyle" id="printarea">
                                                <div class="row align-items-center">
                                                    <div class="col-3">
                                                        <label for="">Date</label>

                                                    </div>
                                                    <div class="col-9">
                                                        <input type="text"
                                                            value="  {{date('d/m/Y',strtotime($sales->date))}}"
                                                            class="form-control inputFieldHeight datepicker"
                                                            name="date" placeholder="dd-mm-yyyy">
                                                        @error('date')
                                                            <div class="btn btn-sm btn-danger">{{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- <div class="col-md-3 changeColStyle">
                                                 <div class="row align-items-center">
                                                    <div class="col-3">
                                                        <label for="">Invoice No</label>

                                                    </div>
                                                    <div class="col-9">
                                                        <input type="text" name="invoice_no" id="invoice_no" class="form-control inputFieldHeight" value="" required>
                                                        @error('pay_mode')
                                                            <div class="btn btn-sm btn-danger">{{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div> --}}

                                            <div class="col-md-3 changeColStyle">
                                                <div class="row align-items-center">
                                                    <div class="col-4">
                                                        <label for="">Invoice</label>

                                                    </div>
                                                    <div class="col-8">
                                                        <input type="text" name="" id=""
                                                            class="form-control inputFieldHeight"
                                                            value="{{ $sales->invoice_no }}" disabled>
                                                        @error('pay_mode')
                                                            <div class="btn btn-sm btn-danger">{{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-2 changeColStyle">
                                                <div class="row align-items-center d-flex justify-content-end">
                                                    <div class="col-4">
                                                        <label for="">Invoice Type</label>

                                                    </div>
                                                    <div class="col-8">
                                                        <select name="invoice_type" id="invoice_type"
                                                            class="form-control inputFieldHeight" required>
                                                            <option value="Tax Invoice" {{ isset($sales) ? ($sales->invoice_type == 'Tax Invoice'? 'selected' : '') : '' }}>Tax Invoice</option>
                                                            <option value="Proforma Invoice" {{ isset($sales) ? ($sales->invoice_type =='Proforma Invoice' ? 'selected' : '') : '' }}>Proforma Invoice</option>
                                                            <option value="Direct Invoice">Direct Invoice</option>
                                                        </select>
                                                        @error('invoice_type')
                                                            <div class="btn btn-sm btn-danger">{{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 cheque-content" style="display: {{$sales->pay_mode=="Cheque"?'':'none'}}">
                                                <div class="row">
                                                    <div class="col-md-5 changeColStyle">
                                                        <div class="row align-items-center">
                                                            <div class="col-3">
                                                                <label for="">Issuing Bank</label>
                                                            </div>
                                                            <div class="col-9 col-left-padding">
                                                                <input type="text" autocomplete="off" name="issuing_bank"
                                                                    id="issuing_bank" class="form-control inputFieldHeight"
                                                                    placeholder="Issuing Bank" value="{{$sales->issuing_bank}}" {{$sales->pay_mode=="Cheque"?'required':''}}>
                                                                @error('issuing_bank')
                                                                    <div class="btn btn-sm btn-danger">{{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3 changeColStyle">
                                                        <div class="row align-items-center">
                                                            <div class="col-2">
                                                                <label for="">Branch</label>
                                                            </div>
                                                            <div class="col-10">
                                                                <input type="text" autocomplete="off" name="bank_branch"
                                                                    id="bank_branch" class="form-control inputFieldHeight"
                                                                    placeholder="Branch" value="{{$sales->branch}}" {{$sales->pay_mode=="Cheque"?'required':''}}>
                                                                @error('bank_branch')
                                                                    <div class="btn btn-sm btn-danger">{{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2 changeColStyle">
                                                        <div class="row align-items-center">
                                                            <div class="col-5 col-right-padding">
                                                                <label for="">Cheque No</label>
                                                            </div>
                                                            <div class="col-7 col-left-padding">
                                                                <input type="text" autocomplete="off"
                                                                    class="form-control inputFieldHeight" name="cheque_no"
                                                                    placeholder="Cheque Number" id="cheque_no" value="{{$sales->cheque_no}}" {{$sales->pay_mode=="Cheque"?'required':''}}>
                                                                @error('cheque_no')
                                                                    <div class="btn btn-sm btn-danger">{{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2 changeColStyle">
                                                        <div class="row align-items-center">
                                                            <div class="col-6 col-right-padding">
                                                                <label for="">Deposit Date</label>
                                                            </div>
                                                            <div class="col-6 col-left-padding">
                                                                <input type="text"  autocomplete="off"
                                                                    class="form-control inputFieldHeight datepicker deposit_date"
                                                                    name="deposit_date" placeholder="dd/mm/yyyy" value="{{date('d/m/Y',strtotime($sales->deposit_date))}}" {{$sales->pay_mode=="Cheque"?'required':''}}>
                                                                @error('deposit_date')
                                                                    <div class="btn btn-sm btn-danger">{{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 changeColStyle">
                                                <div class="row align-items-center">
                                                    <div class="col-3">
                                                        <label for="">D.o No</label>

                                                    </div>
                                                    <div class="col-9">
                                                        <input type="text" name="do_no" id="do_no"
                                                        class="form-control inputFieldHeight"
                                                        placeholder="D.O No" value="{{$sales->do_no}}">
                                                        @error('do_no')
                                                            <div class="btn btn-sm btn-danger">{{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-2 changeColStyle">
                                                <div class="row align-items-center">
                                                    <div class="col-3">
                                                        <label for="">LPO No</label>

                                                    </div>
                                                    <div class="col-9">
                                                        <input type="text" name="lpo_no" id="lpo_no"
                                                        class="form-control inputFieldHeight"
                                                        placeholder="LPO No" value="{{$sales->lpo_no}}">
                                                        @error('lpo_no')
                                                            <div class="btn btn-sm btn-danger">{{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3 changeColStyle">
                                                <div class="row align-items-center">
                                                    <div class="col-3">
                                                        <label for="">Quotation No</label>

                                                    </div>
                                                    <div class="col-9">
                                                        <input type="text" name="quotation_no" id="quotation_no"
                                                        class="form-control inputFieldHeight"
                                                        placeholder="Quotation No" value="{{$sales->quotation_no}}">
                                                        @error('quotation_no')
                                                            <div class="btn btn-sm btn-danger">{{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4 changeColStyle">
                                                <div class="row align-items-center">
                                                    <div class="col-3">
                                                        <label for="">Site/Project</label>

                                                    </div>
                                                    <div class="col-9">
                                                        <input type="text" name="site_project" id="site_project"
                                                        class="form-control inputFieldHeight"
                                                        placeholder="Site/Project" value="{{$sales->site_project}}">
                                                        @error('site_project')
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
                                                <table class="table table-bordered table-sm ">
                                                    <thead>
                                                        <tr class="text-center">
                                                            <th style="width: 36%">Description</th>
                                                            <th style="width: 15%">QTY</th>

                                                            <th style="width: 15%">Unit</th>
                                                            <th style="width: 15%">Rate</th>
                                                            <th style="width: 15%">Amount</th>
                                                            <th class="NoPrint" style="width: 1%;padding: 2px;"> <button type="button"
                                                                    class="btn btn-sm btn-success addBtn"style="border: 1px solid green;
                                                                color: #fff; border-radius: 10px;padding: 5px;"
                                                                    onclick="BtnAdd()"><i class="bx bx-plus" style="color: white;margin-top: -5px;"></i></button>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="TBody">
                                                        @foreach ($sales->items as $key => $item)
                                                        <tr id="TRow" class="text-center invoice_row">
                                                            <td>
                                                                <div
                                                                    class="d-flex justy-content-between align-items-center">
                                                                    <input type="text"
                                                                        name="group-a[{{$key}}][multi_acc_head]" step="any" value="{{$item->item_description}}"
                                                                        required placeholder="Item Description"
                                                                        class="text-center form-control inputFieldHeight2"style="width: 100%;height:36px;">
                                                                </div>
                                                            </td>

                                                            <td>
                                                                <div
                                                                    class="d-flex justy-content-between align-items-center">
                                                                    <input type="text" name="group-a[{{$key}}][qty]" value="{{$item->qty}}"
                                                                        step="any" required
                                                                        class="text-center form-control inputFieldHeight2 qty"style="width: 100%;height:36px;">
                                                                </div>

                                                            </td>


                                                            <td>
                                                                <input name="group-a[{{$key}}][unit]" type="text" value="{{$item->unit_id}}" required
                                                                    class="text-center inputFieldHeight2 unit form-control "
                                                                    style="width: 100%;    HEIGHT: 36PX;">


                                                            </td>
                                                            <td><input type="number" step="any"
                                                                    class="text-center form-control rate inputFieldHeight2" required
                                                                    name="group-a[{{$key}}][rate]" value="{{$item->rate}}">
                                                            <td>
                                                                <input type="number" step="any"
                                                                    name="group-a[{{$key}}][amount]" required value="{{$item->amount}}"
                                                                    class="text-center form-control amount inputFieldHeight2"
                                                                    style="width: 100%;height:36px;" readonly>
                                                            </td>
                                                            </td>
                                                            <td class="NoPrint"><button style="padding: 5px; margin: 4px;"
                                                                    type="button"
                                                                    class="btn btn-sm btn-danger"onclick="BtnDel(this)"><i class="bx bx-trash" style="color: white;margin-top: -5px;"></i></button>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tbody>
                                                        <tr>
                                                            <td colspan="3"></td>
                                                            <td class="text-center" style="color: black">TOTAL</td>
                                                            <td><input type="number" step="any" readonly
                                                                    id="taxable_amount"
                                                                    class="text-center form-control inputFieldHeight2 @error('taxable_amount') error @enderror inputFieldHeight taxable_amount"
                                                                    name="taxable_amount" value="{{$sales->amount}}"
                                                                    placeholder="Amount" readonly required>
                                                                @error('taxable_amount')
                                                                    <span class="error">{{ $message }}</span>
                                                                @enderror
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3"></td>
                                                            <td class="text-center" style="color: black">VAT</td>
                                                            <td><input type="number" step="any" readonly
                                                                    id="total_vat"
                                                                    class="text-center inputFieldHeight2 form-control @error('total_vat') error @enderror inputFieldHeight total_vat"
                                                                    name="total_vat" value="{{$sales->vat}}"
                                                                    placeholder="@if (!empty($currency->vat_name)) {{ $currency->vat_name }} @endif SUBTOTAL"
                                                                    readonly required>
                                                                @error('total_vat')
                                                                    <span class="error">{{ $message }}</span>
                                                                @enderror
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3"></td>
                                                            <td class="text-center" style="color: black">TOTAL AMOUNT</td>
                                                            <td><input type="number" step="any" readonly
                                                                    id="total_amount"
                                                                    class="text-center inputFieldHeight2 form-control @error('total_amount') error @enderror inputFieldHeight total_amount"
                                                                    name="total_amount" value="{{$sales->total_amount}}"
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
                                            {{-- <div class="col-sm-6 form-group">
                                                <label for="">Narration</label>
                                                <input type="text" class="form-control inputFieldHeight"
                                                    name="narration" id="narration" placeholder="Narration"
                                                    value="{{ isset($sales) ? $sales->narration : '' }}" required>
                                            </div> --}}

                                            <div class="col-sm-3 form-group">
                                                <label for="">Voucher Scan/File</label>
                                                <input type="file" class="form-control inputFieldHeight"
                                                    name="voucher_scan" accept="image/*">
                                            </div>

                                            <div class="col-sm-3 form-group">
                                                <label for="">Voucher Scan/File 2</label>
                                                <input type="file" class="form-control inputFieldHeight"
                                                    name="voucher_scan2" accept="image/*">
                                            </div>
                                            <div class="col-sm-6 text-right d-flex justify-content-end mt-2 mb-1">
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
        function BtnAdd() {
            /* Add Button */
            var newRow = $("#TRow").clone();
            newRow.removeClass("d-none");
            newRow.find("input, select,textarea").val('').attr('name', function(index, name) {
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
            total()
        }

        // $('.btn_create').click(function(){
        $(document).on("click", ".btn_create", function(e) {
            e.preventDefault();
            // alert('Alhamdulillah');
            setTimeout(function() {
                $('.multi-acc-head').select2();
                $('.multi-tax-rate').select2();
            }, 1000);
        });


        $('#pay_mode').change(function() {
                if ($(this).val() == 'Cheque') {
                    $(".deposit_date").attr('required',true);
                    $("#bank_branch").attr('required',true);;
                    $("#issuing_bank").attr('required',true);
                    $("#cheque_no").attr('required',true);
                    $('.cheque-content').show();

                } else {
                    $(".deposit_date").removeAttr('required');
                    $("#bank_branch").removeAttr('required');;
                    $("#issuing_bank").removeAttr('required');
                    $("#cheque_no").removeAttr('required');
                    $('.cheque-content').hide();
                }

            });

        $("#formSubmit").submit(function(e) {
            e.preventDefault(); // avoid executing the actual submit of the form.
            var form = $(this);
            var url = form.attr('action');
            var data = new FormData(this);
            $.ajax({
                url: url,
                method: 'POST',
                data: data,
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
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
                        // $("#submitButton").prop("disabled", true)
                        // $(".deleteBtn").prop("disabled", true)
                        // $(".addBtn").prop("disabled", true)
                        document.getElementById("voucherPreviewShow").innerHTML = response;
                        $('#voucherPreviewModal').modal('show');
                        // $("#newButton").removeClass("d-none")
                        // $("#submitButton").addClass("d-none")
                    }
                    $('.show-edit-form').hide();
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



        $(document).on("keyup", ".qty", function(e) {
            var qty = $(this).val();
            var rate = $(this).closest("tr").find(".rate").val();
            var amount = qty * rate;
            $(this).closest("tr").find(".amount").val(amount);
            total();
        });

        $(document).on("keyup", ".rate", function(e) {
            var rate = $(this).val();
            var qty = $(this).closest("tr").find(".qty").val();
            var amount = qty * rate;
            $(this).closest("tr").find(".amount").val(amount);
            total();
        });

        $(document).on("change", "#invoice_type", function(e) {
            total()

        });

        function total() {
            var sum = 0;
            $('.amount').each(function() {
                var this_amount = $(this).val();
                this_amount = (this_amount === '') ? 0 : this_amount;
                var this_amount = parseFloat(this_amount);
                //
                sum = sum + this_amount;
            });
            var result = sum.toFixed(2)
            var standard_vat_rate = $('#standard_vat_rate').val();
            var invoice_type = $('#invoice_type').val();
            if (invoice_type == 'Tax Invoice') {
                var vat = (standard_vat_rate / 100) * result;
            } else {
                var vat = 0;
            }
            // alert(vat);
            var total_vat = vat.toFixed(2)
            $(".taxable_amount").val(result);
            $(".total_vat").val(vat.toFixed(2));
            $(".total_amount").val((total_vat * 1) + (result * 1));
        };
    </script>
@endpush
