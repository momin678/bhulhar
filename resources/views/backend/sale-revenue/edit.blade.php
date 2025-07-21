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

                @include('clientReport.accounting._header', ['activeMenu' => 'sale'])

                <div class="tab-content journaCreation active">
                    <div id="journaCreation" class="tab-pane bg-white active">
                        <div class="py-1 px-2 pt-0">
                            @include('backend.sale-revenue._submenu', [
                                'activeMenu' => 'create',
                            ])
                        </div>
                        <section id="widgets-Statistics">
                            <form action="{{ route('sale.revenues.update', $sale->id) }}" method="POST" id="formSubmit"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="cardStyleChange bg-white">
                                    <div class="card-body ">
                                        <div class="row mx-1 ">
                                            <div class="col-md-4 changeColStyle search-item-pi">
                                                <div class="row align-items-center">

                                                    <div class="col-10 customer-select">
                                                        <label for="">Customer Info</label>

                                                        <select name="party_info" id="party_info"
                                                            class="common-select2 party-info customer"
                                                            style="width: 100% !important" data-target="" required>
                                                            <option value="">Select...</option>
                                                            @foreach ($pInfos as $item)
                                                                <option value="{{ $item->id }}"
                                                                    {{ $sale->customer_id == $item->id ? 'selected' : '' }}
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
                                            <div class="col-md-3 row">
                                                
                                                <div class="col-md-6 changeColStyle">
                                                    <div class="row align-items-center">

                                                        <div class="col-12">
                                                            <label for="">
                                                                @if (!empty($currency->licence_name))
                                                                    {{ $currency->licence_name }}
                                                                @endif
                                                            </label>
                                                            <input type="text" class="form-control inputFieldHeight"
                                                                name="trn_no" id="trn_no" class="form-control" readonly
                                                                value="{{ $sale->party->trn_no }}">
                                                            @error('trn_no')
                                                                <div class="btn btn-sm btn-danger">{{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 changeColStyle">
                                                    <div class="row align-items-center">

                                                        <div class="col-12">
                                                            <label for="">
                                                                Contact
                                                            </label>
                                                            <input type="text" class="form-control inputFieldHeight"
                                                                name="party_contact" id="party_contact"
                                                                value="{{ $sale->party->con_no }}" class="form-control"
                                                                readonly>
                                                            @error('party_contact')
                                                                <div class="btn btn-sm btn-danger">{{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-5 row">

                                                <div class="col-md-4 changeColStyle">
                                                    <div class="row align-items-center">
    
                                                        <div class="col-12">
                                                            <label for="">Payment Mode</label>
    
                                                            <select name="pay_mode" id="pay_mode"
                                                                class="form-control inputFieldHeight" required>
                                                                <option value="">Select...</option>
    
                                                                @foreach ($modes as $item)
                                                                    <option value="{{ $item->title }}"
                                                                        {{ $sale->pay_mode == $item->title ? 'selected' : '' }}>
                                                                        {{ $item->title }} </option>
                                                                @endforeach
    
                                                            </select>
                                                            <small id="pay_available_balance" class="text-danger"></small>
                                                        </div>
                                                    </div>
                                                </div>
    
                                                <div class="col-md-4 changeColStyle" id="printarea">
                                                    <div class="row align-items-center">
    
                                                        <div class="col-12">
                                                            <label for="">Date</label>
    
                                                            <input type="text"
                                                                value="{{ date('d/m/Y', strtotime($sale->date)) }}"
                                                                class="form-control inputFieldHeight datepicker"
                                                                name="date" placeholder="dd-mm-yyyy">
                                                            @error('date')
                                                                <div class="btn btn-sm btn-danger">{{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 changeColStyle" id="printarea">
                                                    <div class="row align-items-center">
                                                        <div class="col-12">
                                                            <label for="">Invoice No</label>
                                                            <input type="text" id="invoice_no" value="{{$sale->sale_no}}" class="form-control inputFieldHeight" name="sale_no" placeholder="Invoice No">
                                                            @error('sale_no')
                                                                <div class="btn btn-sm btn-danger">{{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-2 changeColStyle d-none">
                                                <div class="row align-items-center">
                                                    <div class="col-3">
                                                        <label for="">Bill</label>

                                                    </div>
                                                    <div class="col-9">
                                                        <input type="text" name="" id=""
                                                            class="form-control inputFieldHeight"
                                                            value="{{ $sale->purchase_no }}" disabled>
                                                        @error('pay_mode')
                                                            <div class="btn btn-sm btn-danger">{{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3 changeColStyle d-none">
                                                <div class="row align-items-center d-flex justify-content-end">
                                                    <div class="col-4">
                                                        <label for="">Invoice Type</label>

                                                    </div>
                                                    <div class="col-8">
                                                        <select name="invoice_type" id="invoice_type"
                                                            class="form-control inputFieldHeight" required>
                                                            <option value="Tax Invoice"
                                                                {{ $sale->invoice_type == 'Tax Invoice' ? 'selected' : '' }}>
                                                                With Tax</option>
                                                            <option value="Proforma Invoice"
                                                                {{ $sale->invoice_type == 'Proforma Invoice' ? 'selected' : '' }}>
                                                                Without Tax</option>

                                                        </select>
                                                        @error('invoice_type')
                                                            <div class="btn btn-sm btn-danger">{{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            @if ($sale->pay_mode=="Cheque")
                                                <div class="col-md-12 cheque-content">
                                            @else
                                                <div class="col-md-12 cheque-content" style="display: none;">
                                            @endif
                                                <div class="row">
                                                    <div class="col-md-5 changeColStyle">
                                                        <div class="row align-items-center">

                                                            <div class="col-12 col-left-padding">
                                                                <label for="">Issuing Bank</label>

                                                                <input type="text" autocomplete="off" name="issuing_bank"
                                                                    id="issuing_bank" class="form-control inputFieldHeight"
                                                                    placeholder="Issuing Bank" value="{{$sale->issuing_bank}}">
                                                                @error('issuing_bank')
                                                                    <div class="btn btn-sm btn-danger">{{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3 changeColStyle">
                                                        <div class="row align-items-center">

                                                            <div class="col-12">
                                                                <label for="">Branch</label>

                                                                <input type="text" autocomplete="off" name="bank_branch"
                                                                    id="bank_branch" class="form-control inputFieldHeight"
                                                                    placeholder="Branch" value="{{$sale->bank_branch}}">
                                                                @error('bank_branch')
                                                                    <div class="btn btn-sm btn-danger">{{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2 changeColStyle">
                                                        <div class="row align-items-center">

                                                            <div class="col-12 col-left-padding">
                                                                <label for="">Cheque No</label>

                                                                <input type="text" autocomplete="off"
                                                                    class="form-control inputFieldHeight" name="cheque_no"
                                                                    placeholder="Cheque Number" id="cheque_no" value="{{$sale->cheque_no}}">
                                                                @error('cheque_no')
                                                                    <div class="btn btn-sm btn-danger">{{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2 changeColStyle">
                                                        <div class="row align-items-center">

                                                            <div class="col-12 col-left-padding">
                                                                <label for="">Deposit Date</label>
                                                                <input type="text" autocomplete="off"
                                                                    class="form-control inputFieldHeight datepicker deposit_date"
                                                                    name="deposit_date" placeholder="dd/mm/yyyy" value="{{date('d/m/Y', strtotime($sale->deposit_date))}}">
                                                                @error('deposit_date')
                                                                    <div class="btn btn-sm btn-danger">{{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12"
                                    style="margin-top:10px !important">

                                    <div class="table-responsive">
                                        <table class="table  table-sm table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="width:20%"> Description
                                                        <i class="fa-plus text-info" style="font-size:20px" data-toggle="modal" data-target="#itemModal"></i>
                                                    </th>
                                                    <th style=" width:20%"> Vehicle
                                                        <i class="fa-plus text-info" style="font-size:20px" data-toggle="modal" data-target="#newTruckAddModal"></i>
                                                    </th>
                                                    <th>Qty</th>
                                                    <th>Rate</th>
                                                    <th>Amount</th>
                                                    <th class="vat-exist" style="width: 10%">Vat Rate</th>
                                                    <th class="vat-exist" style="width: 10%">Vat Amount</th>
                                                    <th>Total Amount</th>
                                                    <th class="NoPrint" style="width: 10px"> <button
                                                            type="button"
                                                            class="btn btn-sm btn-success addBtn"style="border: 1px solid green;
                                                                    color: #fff; border-radius: 10px;padding: 5px;"
                                                            onclick="BtnAdd()">ADD</button>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="TBody">
                                                @php
                                                    $indx=0;
                                                @endphp
                                                @foreach ($sale->items as $item)
                                                <tr id="TRow" class="invoice_row">

                                                    <td>
                                                        <select name="group-a[{{$indx}}][account_head_id]" id="account_head_id" class="form-control">
                                                            <option value=""> Selects  </option>
                                                            @foreach ($account_heads as $account_head)
                                                                <option value="{{$account_head->id}}" {{$account_head->id == $item->head_id ? 'selected' : 'none'}}> {{$account_head->fld_ac_head}} </option>
                                                            @endforeach
                                                        </select>
                                                    </td>

                                                    <td>
                                                        <select name="group-a[{{$indx}}][vehicle_id]"
                                                            class="inputFieldHeight2 cost_center_id form-control d-inline"
                                                            style="width: 87%;    HEIGHT: 36PX;">
                                                            <option value="" style="text-align:center;"> -- Choice
                                                                Option -- </option>
                                                            @foreach ($cost_center as $cost)
                                                                <option value="{{$cost->id}}" {{$cost->id == $item->truck_id ? 'selected' : ''}}> {{$cost->vehicle_number}}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <div
                                                            class="d-flex justy-content-between align-items-center">
                                                            <input type="number" step="any" name="group-a[{{$indx}}][qty]" value="{{$item->qty}}"
                                                                step="any" required placeholder="Item Qty"
                                                                class="text-center form-control inputFieldHeight2 qty"style="width: 100%;height:36px;">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div
                                                            class="d-flex justy-content-between align-items-center">
                                                            <input type="number" step="any" name="group-a[{{$indx}}][rate]" value="{{$item->rate}}"
                                                                step="any" required placeholder="Item rate"
                                                                class="text-center form-control inputFieldHeight2 rate"style="width: 100%;height:36px;">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div
                                                            class="d-flex justy-content-between align-items-center">
                                                            <input type="number" step="any"
                                                                name="group-a[{{$indx}}][amount]" step="any" value="{{$item->amount}}" required
                                                                placeholder="Amount"
                                                                class="form-control inputFieldHeight2 amount"style="width: 100%;height:36px;">
                                                        </div>
                                                    </td>


                                                    <td class="vat-exist">
                                                        <select name="group-a[{{$indx}}][vat_rate]" required
                                                            class="inputFieldHeight2 vat_rate form-control "
                                                            style="width: 100%;    HEIGHT: 36PX;">
                                                            <option value=""> -- Choice Option --
                                                            </option>
                                                            @foreach ($vats as $vat)
                                                                <option value="{{ $vat->value }}" {{$item->vat_amount>0?($vat->value==5?'selected':''):($vat->value!=5?'selected':'') }}>
                                                                    {{ $vat->name . ' (' . $vat->value . ')' }}
                                                                </option>
                                                            @endforeach
                                                        </select>

                                                    </td>

                                                    <td class="vat-exist"><input type="number" step="any"
                                                            class="form-control vat_amount inputFieldHeight2"
                                                            required placeholder="Vat Amount"  value="{{$item->vat_amount}}"
                                                            name="group-a[{{$indx}}][vat_amount]" readonly>
                                                    </td>
                                                    <td>
                                                        <input type="number" step="any"
                                                            name="group-a[{{$indx++}}][sub_gross_amount]" required
                                                            class="form-control sub_gross_amount inputFieldHeight2"
                                                            placeholder="Amount" style="width: 100%;height:36px;" value="{{$item->total_amount}}"
                                                            readonly>
                                                    </td>
                                                    </td>
                                                    <td class="NoPrint text-center"><button
                                                            style="padding: 2px; margin: 4px;" type="button"
                                                            class="btn btn-sm btn-danger"onclick="BtnDel(this)">DELETE</button>
                                                    </td>
                                                </tr>
                                                @endforeach

                                            </tbody>
                                            <tbody>
                                                <tr>
                                                    <td class="vat-exist"></td>
                                                    <td class="vat-exist"></td>
                                                    <td class="vat-exist"></td>
                                                    <td class="vat-exist"></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="text-center" style="color: black ; color: #757575;font-size: 12px !important;">TOTAL</td>
                                                    <td><input type="number" step="any" readonly
                                                            id="taxable_amount"
                                                            class="form-control inputFieldHeight2 @error('taxable_amount') error @enderror inputFieldHeight taxable_amount"
                                                            name="taxable_amount" value="{{$sale->amount}}"
                                                            placeholder="Amount" readonly required>
                                                        @error('taxable_amount')
                                                            <span class="error">{{ $message }}</span>
                                                        @enderror
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="vat-exist"></td>
                                                    <td class="vat-exist"></td>
                                                    <td class="vat-exist"></td>
                                                    <td class="vat-exist"></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="text-center" style="color: black ; color: #757575;font-size: 12px !important;">VAT</td>
                                                    <td><input type="number" step="any" readonly
                                                            id="total_vat"
                                                            class="inputFieldHeight2 form-control @error('total_vat') error @enderror inputFieldHeight total_vat"
                                                            name="total_vat" value="{{$sale->vat_amount}}"
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
                                                    <td class="vat-exist"></td>
                                                    <td class="vat-exist"></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="text-center" style="color: black;color: #757575;font-size: 12px !important;">TOTAL AMOUNT</td>
                                                    <td><input type="number" step="any" readonly
                                                            id="total_amount"
                                                            class="inputFieldHeight2 form-control @error('total_amount') error @enderror inputFieldHeight total_amount"
                                                            name="total_amount" value="{{$sale->total_amount}}"
                                                            placeholder="TOTAL " readonly required>
                                                        @error('total_amount')
                                                            <span class="error">{{ $message }}</span>
                                                        @enderror
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="vat-exist"></td>
                                                    <td class="vat-exist"></td>
                                                    <td class="vat-exist"></td>
                                                    <td class="vat-exist"></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="text-center" style="color: #757575;font-size: 12px !important;">PAID AMOUNT</td>
                                                    <td><input type="number" step="any"
                                                            id="paid_amount" style="text-align: left !important;"
                                                            class="text-center inputFieldHeight2 form-control @error('paid_amount') error @enderror inputFieldHeight paid_amount"
                                                            name="paid_amount" {{ $sale->pay_mode == 'Credit' ? 'readonly' : '' }} value="{{$sale->paid_amount}}"
                                                            placeholder="Paid Amount ">
                                                        @error('paid_amount')
                                                            <span class="error">{{ $message }}</span>
                                                        @enderror
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="cardStyleChange">
                                    <div class="card-body bg-white">
                                        <div class="row px-1">
                                            <div class="col-sm-6 form-group">
                                                <label for="">Narration</label>
                                                <input type="text" class="form-control inputFieldHeight"
                                                    name="narration" id="narration" placeholder="Narration"
                                                    value="{{$sale->narration}}" required>
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
                                                <a onclick="refreshPage()" class="btn btn-warning  d-none"
                                                    id="newButton">New</a>
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

    <div class="modal fade" id="itemModal" tabindex="-1" role="dialog" aria-labelledby="itemModalLabel"varia-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="padding: 5px 33px;background:#364a60;">
                    <h5 class="modal-title" id="exampleModalLabel"
                        style="font-family:Cambria;font-size: 2rem;color:white;">New Head</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="{{ route('head-store') }}" method="POST" enctype="multipart/form-data" id="itemAddNew">
                        @csrf
                        <div class="row match-height">
                            <div class="col-md-6">
                                <label>Name</label>

                                <input type="text" name="name" placeholder="Head Name" class="form-control inputFieldHeight" required>
                            </div>
                            <div class="col-md-6 col-12 b_party" >
                                <div class="form-group">
                                    <label>Master Account</label>
                                    <select name="master_acc_id" required class="form-control inputFieldHeight common-select2" style="width: 100% !important;" id="master_acc_id">
                                        @foreach ($masterAcc as $item)
                                            <option value="{{ $item->id }}" {{$item->id==4?'selected':''}}> {{ $item->mst_ac_head }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 d-flex justify-content-end mt-1">
                                <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- modal --}}
    <div class="modal fade bd-example" id="newTruckAddModal" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <section class="print-hideen border-bottom">
                <div class="d-flex">
                    <h4 class="mr-auto m-1">Vehicle Information</h4>
                    <div class="mIconStyleChange"><a href="#" class="close btn-icon btn btn-danger" data-dismiss="modal" aria-label="Close" onClick="window.location.reload();"><span aria-hidden="true"><i class='bx bx-x'></i></span></a></div>
                </div>
            </section>
            <div class="content-body">
                <form class="form form-vertical" action="{{ route('vehicle.store')}}" method="POST" enctype="multipart/form-data" id="truckAddNew">
                    @csrf
                    <section id="basic-vertical-layouts">
                        <div class="row match-height">
                            <div class="col-md-12 col-12">
                                <div class="cardStyleChange">
                                    <div class="card-body">
                                        <div class="form-body">
                                            <div class="row p-1">
                                                <div class="col-md-4 col-12 ">
                                                    <label for="">Vehicle Number</label>
                                                    <input type="text" name="vehicle_number" class="inputFieldHeight form-control vehicle_number_add" placeholder="Vehicle Number" required id="vehicle_number">
                                                    <span class="text-danger" id="error_show"></span>
                                                </div>
                                                <div class="col-md-4 col-12 ">
                                                    <label for="">Brand</label>
                                                    <input type="text" name="brand" class="inputFieldHeight form-control" placeholder="Brand" id="brand">
                                                </div>
                                                <div class="col-md-4 col-12 ">
                                                    <label for="">Model </label>
                                                    <input type="text" name="model" class="inputFieldHeight form-control" placeholder="Model" id="model">
                                                </div>
                                                <div class="col-md-4 col-12 commonSelect2Style">
                                                    <label for="">Origin</label>
                                                    <select name="origin" class="inputFieldHeight form-control" id="origin">
                                                        <option value="">Select Country</option>
                                                        @foreach ($countries as $country)
                                                        <option value="{{$country->name}}">{{$country->name}}</option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                                <div class="col-md-4 col-12 ">
                                                    <label for="">Engine Capacity</label>
                                                    <input type="text" name="engine_capacity" class="inputFieldHeight form-control" placeholder="Engine Capacity" id="engine_capacity">
                                                </div>
                                                <div class="col-md-4 col-12 ">
                                                    <label for="">Number of Tyres</label>
                                                    <input type="text" name="number_of_tyres" class="inputFieldHeight form-control" placeholder="Number of Tyres" id="number_of_tyres">
                                                </div>
                                                <div class="col-md-4 col-12 commonSelect2Style">
                                                    <label for="">Owner</label>
                                                    <select name="owner" id="owner" class="inputFieldHeight form-control"  required>
                                                        <option value="">Select Owner</option>
                                                        @foreach ($owners as $party)
                                                        <option value="{{$party->id}}">{{$party->pi_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4 col-12 commonSelect2Style">
                                                    <label for="">Driver Name</label>
                                                    <select name="driver_id" id="driver_id_add" class="inputFieldHeight form-control">
                                                        <option value="">Select Driver</option>
                                                        @foreach ($drivers as $driver)
                                                        <option value="{{$driver->id}}">{{$driver->full_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                {{-- <div class="col-md-4"></div> --}}
                                                <div class="col-md-4 d-flex justify-content-end mt-2 mb-2" >
                                                    <button type="submit" class="btn btn-primary formButton" title="Save" id="truck_add">
                                                        <div class="d-flex">
                                                            <div class="formSaveIcon">
                                                                <img src="{{asset('assets/backend/app-assets/icon/save-icon.png')}}" alt="" srcset="" width="20">
                                                            </div>
                                                            <div><span> Save</span></div>
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
    <div class="modal fade" id="balanceAdd" tabindex="-1" role="dialog" aria-labelledby="balanceAddLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-body d-flex">
                <h4 class="mr-auto">Add Balance</h4>
                <button type="button" class="btn  btn_create mr-1 float-right formButton"style=" background: #1a233a;color:#fff" title="Yes" id="new_balance_add">
                    Yes
                </button>
                <button type="button" class="btn btn_create mr-1 float-right formButton btn-danger"style=" background: #1a233a;color:#fff" title="No" data-dismiss="modal" aria-label="Close">
                    NO
                </button>
            </div>
          </div>
        </div>
    </div>

<div class="modal fade bd-example-modal-lg" id="newbalanceAdd" tabindex="-1" rrole="dialog"  aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <section class="print-hideen border-bottom">
                <div class="d-flex">
                    <h4 class="mt-1 ml-1 mr-auto">Add Balance</h4>
                    <div class="mIconStyleChange">
                        <a href="#" class="close btn-icon btn btn-danger" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">
                                <i class='bx bx-x'></i>
                            </span>
                        </a>
                    </div>
                </div>
            </section>
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

        if ($('#invoice_type').val() != 'Tax Invoice') {

            $('.vat-exist').hide();
            $('.vat_amount').val(0);
            $(".vat_rate").removeAttr('required');
        }


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
                var data = new FormData(this);
                data.append('_method', 'PUT');
                var pay_mode = $("#pay_mode").val();
                var total_amount = $("#total_amount").val();
                var task_total_amount = $("#task_total_amount").val();

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
                    $(".vat_rate").attr('required', true);

                } else {
                    $('.vat-exist').hide();
                    $('.vat_amount').val(0);
                    $(".vat_rate").removeAttr('required');


                }
                total()
            });


            $(document).on("keyup", ".qty, .rate", function(e) {
                var tr = $(this).closest('tr');
                var qty = tr.find('.qty').val();
                var rate = tr.find('.rate').val();
                var amount = qty*rate;

                var invoice_type = $('#invoice_type').val();
                var vat_amount = 0;
                if (invoice_type == 'Tax Invoice') {
                    var vat_rate = $(this).closest("tr").find(".vat_rate").val();
                    vat_amount = (vat_rate / 100) * amount;

                    total_amount = (amount*1) + vat_amount;
                }
                total_amount=total_amount*1;
                tr.find(".amount").val(amount.toFixed(2));
                tr.find(".vat_amount").val(vat_amount.toFixed(2));
                tr.find(".sub_gross_amount").val(total_amount.toFixed(2));
                total();

            });



            $(document).on("change", ".vat_rate", function(e) {
                var tr = $(this).closest('tr');
                var qty = tr.find('.qty').val();
                var rate = tr.find('.rate').val();
                var amount = qty*rate;

                var invoice_type = $('#invoice_type').val();
                var vat_amount = 0;
                if (invoice_type == 'Tax Invoice') {
                    var vat_rate = $(this).closest("tr").find(".vat_rate").val();
                    vat_amount = (vat_rate / 100) * amount;

                    total_amount = (amount*1) + vat_amount;
                }
                total_amount=total_amount*1;
                tr.find(".amount").val(amount.toFixed(2));
                tr.find(".vat_amount").val(vat_amount.toFixed(2));
                tr.find(".sub_gross_amount").val(total_amount.toFixed(2));
                total();
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
            var pay_mode = $(this).val();
                if(pay_mode == 'Petty Cash'){
                  $('.emp_id').show();
                }else{
                  $('.emp_id').hide();
            }
            var total = parseFloat($("#total_amount").val()) || 0;
            if (pay_mode.trim() == 'Credit') {
                $(".paid_amount").val(0.00.toFixed(2));
                $(".paid_amount").prop('readonly', true);
            } else {
                $(".paid_amount").val(total.toFixed(2));
                $(".paid_amount").prop('max', total.toFixed(2));
                $(".paid_amount").prop('readonly', false);
            }

        });

            function total() {
                var sum = 0;
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
                var total = (vat * 1) + (taxable * 1)
                $(".taxable_amount").val(taxable);
                $(".total_vat").val(vat);
                $(".total_amount").val((total.toFixed(2)));
                $(".paid_amount").prop('max', total.toFixed(2));
                var pay_mode = $('#pay_mode').val() || 0;

                if (pay_mode.trim() == 'Credit') {
                    $(".paid_amount").val(0.00.toFixed(2));
                    $(".paid_amount").prop('readonly', true);
                } else {
                    $(".paid_amount").val(total.toFixed(2));
                    $(".paid_amount").prop('readonly', false);
                }
            };


            $(document).on('keyup', '.task_amount', function(e){
                total = 0;
                $('.task_amount').each(function() {
                    var this_amount = $(this).val();
                    this_amount = (this_amount === '') ? 0 : this_amount;
                    var this_amount = parseFloat(this_amount);
                    total = total + this_amount;
                });
                console.log(total);
                $(".task_total_amount").val((total.toFixed(2)));
            });
        });

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
        }

        function task_BtnAdd() {
            /* Add Button */
            var newRow = $("#task_TRow").clone();
            newRow.removeClass("d-none");
            newRow.find("input, select,textarea").val('').attr('name', function(index, name) {
                return name.replace(/\[\d+\]/, '[' + ($('#task_TBody tr').length) + ']');
            });
            newRow.find("th").first().html($('#task_TBody tr').length + 1);
            newRow.appendTo("#task_TBody");
            newRow.find(".common-select2").select2();
        }

        $("#balanceformSubmit").submit(function(e) {
            e.preventDefault(); // avoid executing the actual submit of the form.

            var form = $(this);
            var url = form.attr('action');
            var data = new FormData(this);
            var pay_mode = $("#pay_mode").val();
            data.append('pay_mode', pay_mode);

            $.ajax({
                url: url,
                method: 'POST',
                data: data,
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    $('#balanceformSubmit').trigger('reset');
                    pay_available_balance = Number(pay_available_balance)+Number(response);
                    console.log(pay_available_balance);
                    $("#pay_available_balance").html(pay_mode+': ' + pay_available_balance);
                    $("#newbalanceAdd").modal('hide');
                },
                error: function(err) {
                    let error = err.responseJSON;
                    $.each(error.errors, function(index, value) {
                        toastr.error(value, "Error");
                    });
                }
            });
        });

        $("#itemAddNew").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
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
                    var newOption = $('<option>', {
                        value: response.id,
                        text: response.fld_ac_head
                    });
                    $('#account_head_id').append(newOption);
                    $("#itemModal").modal('hide');
                }
            })
        });

        $("#truckAddNew").submit(function(e) {
            e.preventDefault();
            var form = $(this);
            var url = form.attr('action');
            var vehicle_number = $("#vehicle_number").val();
            var brand = $("#brand").val();
            var model = $("#model").val();
            var engine_capacity = $("#engine_capacity").val();
            var origin = $("#origin").val();
            var number_of_tyres = $("#number_of_tyres").val();
            var owner = $("#owner").val();
            var driver_id = $("#driver_id_add").val();
            $.ajax({
                url: url,
                method: "POST",
                context:this,
                data: {
                    vehicle_number: vehicle_number,
                    brand: brand,
                    model: model,
                    engine_capacity: engine_capacity,
                    origin: origin,
                    number_of_tyres: number_of_tyres,
                    owner: owner,
                    come_form: 1,
                    driver_id: driver_id,
                    '_token': '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log(response);
                    $("#vehicle_number").val('');
                    $('#newTruckAddModal').modal('hide');
                    $('#truckAddNew')[0].reset();
                    if(response === 'error'){
                        toastr.error("Vehicle number already exit!", "Error");
                    }
                    var new_option = $('<option>', {
                        value:response.id,
                        text:response.vehicle_number
                    });
                    $('.cost_center_id').append(new_option);
                }
            })
        });
        $(document).on("change", "#invoice_no", function(e) {
            var inv = $(this).val();
            var party = $('#party_info').val();
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ route('sale_no_validation') }}",
                method: "POST",
                data: {
                    inv: inv,
                    party: party,
                    _token: _token,
                },
                success: function(response) {
                    if (response.warning) {
                        toastr.warning(response.warning);
                        $('#submitButton').prop('disabled', true);
                    }
                    else {
                        $('#submitButton').prop('disabled', false);
                    }
                }
            })
        });

    </script>
@endpush
