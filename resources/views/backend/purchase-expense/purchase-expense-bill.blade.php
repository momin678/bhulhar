@extends('layouts.backend.app')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
@section('content')
@include('layouts.backend.partial.style')
<style>
    body {
        counter-reset: Serial;
    }

    .auto-index td:first-child:before {
        counter-increment: Serial;
        /* Increment the Serial counter */
        content: counter(Serial);
        /* Display the counter */
    }

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

    .paid-add-btn {
        width: 40px;
        border: none;
        background: yellowgreen;
        border-radius: 10px;
        margin-left: 10px;
        height: 35px;
        color: #fff;
    }
    .select2-container {
       width: 100% !important;
    }
</style>
<div class="app-content content print-hideen">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            <input type="hidden" name="standard_vat_rate" value="{{ $standard_vat_rate }}" id="standard_vat_rate">

            @include('clientReport.accounting._header', ['activeMenu' => 'expense'])
            <div class="tab-content journaCreation active">
                <div id="journaCreation" class="tab-pane bg-white active">
                    <div class="py-1 px-1">
                        @include('clientReport.purchase.purchase-bill', [
                        'activeMenu' => 'bill',
                        ])
                    </div>
                    <section id="widgets-Statistics">
                        <form action="{{ route('expensepost-bill') }}" method="POST" id="formSubmit"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="cardStyleChange bg-white">
                                <div class="px-1">
                                    <h4>Prepare Bill</h4>
                                    <div class="row ">
                                        <div class="col-12 col-md-2">
                                            <div class="form-group">
                                                <label for="date"> Date </label>
                                                <input type="text" name="date" value="{{date('d/m/Y')}}"
                                                    class="form-control inputFieldHeight datepicker">
                                            </div>
                                        </div>
                                        <div class="col-md-5 changeColStyle search-item-pi">
                                            <div class="row align-items-center">
                                                <div class="col-10 customer-select">
                                                    <label for="">Supplier Info</label>
                                                    <select name="client_info" id="client_info"
                                                        class="common-select2 party-info customer"
                                                        style="width: 100% !important" data-target="" required>
                                                        <option value="">Select...</option>
                                                        @foreach ($clients as $client)
                                                        <option value="{{$client->id}}"> {{$client->pi_name}} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-2 col-left-padding d-flex align-items-center mt-1">
                                                    <a href="#" data-toggle="modal"
                                                        data-target="#customerModal"><img
                                                            src="{{ asset('assets/backend/app-assets/icon/add-icon.png') }}"
                                                            alt="" srcset="" class="img-fluid"
                                                            style="height:29px"></a>

                                                </div>

                                            </div>
                                        </div>


                                        {{-- <div class="col-12 col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-8">
                                                        <label for="date"> Supplier </label>
                                                    </div>
                                                    <div class="col-4 text-right">
                                                        <a href="#" id="individual-party" data-type="Supplier"><img
                                                                src="{{ asset('assets/backend/app-assets/icon/add-icon.png') }}"
                                                                alt="" srcset="" class="img-fluid"
                                                                style="height:20px"></a>
                                                    </div>
                                                </div>
                                                <div class="customer-select">
                                                    <select name="party_info" id="party_info" required
                                                        class="common-select2 party-info customer inputFieldHeight customer"
                                                        style="width: 100% !important" data-target="">
                                                        <option value="">Select...</option>
                                                        @foreach ($suppliers as $item)
                                                        <option value="{{ $item->id }}" {{ isset($journalF) ?
                                                            ($journalF->party_info_id == $item->id ? 'selected' : '') :
                                                            '' }}>
                                                            {{ $item->pi_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>


                                            </div>
                                        </div> --}}

                                        <div class="col-12 col-md-2 col-right-padding">
                                            <div class="form-group">
                                                <label for="">Payment Mode</label>
                                                <select name="pay_mode" id="pay_mode"
                                                    class="form-control inputFieldHeight" required>
                                                    <option value="">Select...</option>

                                                    @foreach ($modes as $item)
                                                    <option value="{{ $item->title }}" {{ isset($journalF) ?
                                                        ($journalF->txn_mode == $item->title ? 'selected' : '') : '' }}>
                                                        {{ $item->title }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-3 col-right-padding">
                                            <div class="form-group">
                                                <label for=""> Invoice No </label>
                                                <input type="text" name="invoice_no"
                                                    class="form-control inputFieldHeight invoice_no" required>
                                            </div>
                                        </div>

                                        <div class="col-md-12 cheque-content" style="display: none">
                                            <div class="row">
                                                <div class="col-12 col-md-6 col-lg-3">
                                                    <div class="form-group">
                                                        <label for="">Issuing Bank</label>
                                                        <input type="text" autocomplete="off" name="issuing_bank"
                                                            id="issuing_bank" class="form-control inputFieldHeight"
                                                            placeholder="Issuing Bank">
                                                        @error('issuing_bank')
                                                        <div class="btn btn-sm btn-danger">{{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-6 col-lg-3">
                                                    <div class="form-group">
                                                        <label for=""> Branch </label>
                                                        <input type="text" autocomplete="off" name="bank_branch"
                                                            id="bank_branch" class="form-control inputFieldHeight"
                                                            placeholder="Branch">
                                                        @error('bank_branch')
                                                        <div class="btn btn-sm btn-danger">{{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-6 col-lg-3">
                                                    <div class="form-group">
                                                        <label for=""> Cheque No </label>
                                                        <input type="text" value="" autocomplete="off"
                                                            class="form-control inputFieldHeight" name="cheque_no"
                                                            placeholder="Cheque Number" id="cheque_no">
                                                        @error('cheque_no')
                                                        <div class="btn btn-sm btn-danger">{{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-6 col-lg-3">
                                                    <div class="form-group">
                                                        <label for=""> Deposit Date </label>
                                                        <input type="text" value="" autocomplete="off"
                                                            class="form-control inputFieldHeight datepicker deposit_date"
                                                            name="deposit_date" placeholder="dd/mm/yyyy">
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
                            <div class="col-md-12 col-right-padding col-left-padding"
                                style="margin-top:15px !important">
                                <div class="row px-1">
                                    <div class="cardStyleChange" style="width: 100%">
                                        <div class="table-responsive bg-white">
                                            <table class="table table-sm auto-index">
                                                <thead>
                                                    <tr style="white-space: nowrap;height:25px">
                                                        <th style="width:3%; text-align:center"> Sl </th>
                                                        <th style="width:20%"> Description
                                                            <i class="fa-plus text-info" style="font-size:20px" data-toggle="modal" data-target="#itemModal"></i>
                                                        </th>
                                                        <th style=" width:20%"> Vehicle
                                                            <i class="fa-plus text-info" style="font-size:20px" data-toggle="modal" data-target="#newTruckAddModal"></i>
                                                        </th>
                                                        <th style=" width:20%"> Qty </th>

                                                        <th style="width:10%;"> Amount </th>
                                                        <th style="width:10%;">Taxable Amount </th>

                                                        <th class="vat-exist" style="width: 10%"> Vat
                                                            Rate </th>
                                                        <th class="vat-exist" style="width: 10%"> Vat
                                                            Amount </th>
                                                        <th style="width:15%;"> Total Amount </th>
                                                        <th class="NoPrint" style="min-width: 10px;padding: 2px;">
                                                           Action
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody id="TBody">
                                                    <tr id="TRow" class="d-none p-0 h6">
                                                        <td class="text-center"></td>
                                                        <td>
                                                            <select name="inputs[0][description]"
                                                                class="inputFieldHeight2 task_id form-control"
                                                                style="width: 100%;    HEIGHT: 36PX;" disabled required>
                                                                <option value="" style="text-align:center;"> -- Choice
                                                                    Option -- </option>
                                                                @foreach ($account_heads as $account_head)
                                                                <option value="{{$account_head->id}}">
                                                                    {{$account_head->fld_ac_head}} </option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td class="cost_center">
                                                            <select name="inputs[0][cost_center]"
                                                                class="inputFieldHeight2 cost_center_id form-control d-inline"
                                                                style="width: 87%;    HEIGHT: 36PX;" disabled >
                                                                <option value="" style="text-align:center;"> -- Choice
                                                                    Option -- </option>
                                                                @foreach ($cost_center as $cost)
                                                                <option value="{{$cost->id}}"> {{$cost->vehicle_number}}
                                                                </option>
                                                                @endforeach
                                                            </select>

                                                        </td>
                                                        <td>
                                                            <div
                                                                class="d-flex justy-content-between align-items-center">
                                                                <input type="number" step="any"
                                                                    name="inputs[0][qty]" step="any" disabled required
                                                                    placeholder="Qty"
                                                                    class="text-center form-control inputFieldHeight2 qty"
                                                                    style="width: 100%;height:36px;">
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div
                                                                class="d-flex justy-content-between align-items-center">
                                                                <input type="number" step="any"
                                                                    name="inputs[0][amount]" step="any" disabled required
                                                                    placeholder="Amount"
                                                                    class="text-center form-control inputFieldHeight2 amount"
                                                                    style="width: 100%;height:36px;">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div
                                                                class="d-flex justy-content-between align-items-center">
                                                                <input type="number" step="any"
                                                                    name="inputs[0][taxable]" step="any" disabled readonly
                                                                    placeholder="Amount"
                                                                    class="text-center form-control inputFieldHeight2 taxable"
                                                                    style="width: 100%;height:36px;">
                                                            </div>
                                                        </td>

                                                        <td class="vat-exist">
                                                            <select name="inputs[0][vat_rate]" disabled required
                                                                class="inputFieldHeight2 vat_rate form-control "
                                                                style="width: 100%;HEIGHT: 36PX;text-align:center;">
                                                                <option value=""> -- Choice Option --
                                                                </option>
                                                                @foreach ($vats as $vat)
                                                                <option value="{{ $vat->value }}" {{ $vat->value==5? 'selected':'' }}>
                                                                    {{ $vat->name . ' (' . $vat->value . ')' }}
                                                                </option>
                                                                @endforeach
                                                            </select>

                                                        </td>

                                                        <td class="vat-exist"><input type="number" step="any"
                                                                class="text-center form-control vat_amount inputFieldHeight2"
                                                                required placeholder="Vat Amount"
                                                                name="inputs[0][vat_amount]" disabled readonly>
                                                        </td>
                                                        <td>
                                                            <input type="number" step="any"
                                                                name="inputs[0][sub_gross_amount]" disabled required
                                                                class="text-center form-control sub_gross_amount inputFieldHeight2"
                                                                placeholder="Amount" style="width: 100%;height:36px;"
                                                                readonly>
                                                        </td>
                                                        </td>
                                                        <td class="text-center" style="min-width: 73px;">
                                                            <button type="button" class="btn btn-sm "
                                                                style="border: 1px solid #fff;
                                                            color: #fff; border-radius: 10px;padding: 1px; margin: 0px; font-size:12px;background: #10853a;"
                                                                onclick="BtnAdd('#TRow', '#TBody')">ADD</button>
                                                            <button
                                                                style="border-radius: 10px;padding: 3px; margin: 0px; font-size:10px"
                                                                type="button" class="btn btn-sm btn-danger"
                                                                onclick="if(confirm('Are you sure you want to delete?')) { BtnDel(this); }">DEL</button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <tbody>
                                                    <tr>
                                                        <td class="d-none"></td>
                                                        <td class="vat-exist"></td>
                                                        <td class="vat-exist"></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td class="text-center" style="color: black">TOTAL</td>
                                                        <td><input type="number" step="any" readonly id="taxable_amount"
                                                                class="text-center form-control inputFieldHeight2 @error('taxable_amount') error @enderror inputFieldHeight taxable_amount"
                                                                name="taxable_amount" value="" placeholder="Amount"
                                                                readonly required>
                                                            @error('taxable_amount')
                                                            <span class="error">{{ $message }}</span>
                                                            @enderror
                                                        </td>
                                                    </tr>
                                                    <tr class="text-center">
                                                        <td class="d-none"></td>
                                                        <td class="vat-exist"></td>
                                                        <td class="vat-exist"></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td class="text-center" style="color: black">VAT</td>
                                                        <td><input type="number" step="any" readonly id="total_vat"
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
                                                        <td class="d-none"></td>
                                                        <td class="vat-exist"></td>
                                                        <td class="vat-exist"></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td class="text-center" style="color: black">TOTAL AMOUNT</td>
                                                        <td><input type="number" step="any" readonly id="total_amount"
                                                                class="text-center inputFieldHeight2 form-control @error('total_amount') error @enderror inputFieldHeight total_amount"
                                                                name="total_amount" value="" placeholder="TOTAL "
                                                                readonly required>
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
                                <div class="row p-2">
                                    <div class="col-12 col-md-6 col-right-padding">
                                        <div class="form-group">
                                            <label for=""> Narration </label>
                                            <input type="text" name="narration"
                                                class="form-control inputFieldHeight">
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-2">
                                        <div class="form-group">
                                            <label for=""> Files </label>
                                            <input type="file" name="files[]" class="form-control inputFieldHeight"
                                                multiple>
                                        </div>
                                    </div>
                                    <div class="text-right d-flex justify-content-end px-1 pb-3 col-md-4 mt-2">
                                        <button type="submit" class="btn btn-primary formButton " id="submitButton">
                                            <div class="d-flex">
                                                <div class="formSaveIcon">
                                                    <img src="{{ asset('assets/backend/app-assets/icon/save-icon.png') }}"
                                                        alt="" srcset="" width="25">
                                                </div>
                                                <div><span>Save</span></div>
                                            </div>
                                        </button>
                                        <a href="{{route("purchase-expense")}}" class="btn btn-warning  d-none"
                                            id="newButton">New</a>
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
                                    <option value="">Select...</option>
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
                                                <select name="origin" class="inputFieldHeight form-control common-select2" id="origin">
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
                                                <select name="owner" id="owner" class="inputFieldHeight form-control common-select2"  required>
                                                    <option value="">Select Owner</option>
                                                    @foreach ($parties as $party)
                                                    <option value="{{$party->id}}">{{$party->pi_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4 col-12 commonSelect2Style">
                                                <label for="">Driver Name</label>
                                                <select name="driver_id" id="driver_id_add" class="inputFieldHeight form-control common-select2">
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
    function BtnAdd(trow, tbody) {
        var $trow = $(trow);
        var $tbody = $(tbody);
        var newRow = $trow.clone().removeClass("d-none").removeAttr('id');
        newRow.find("input, select, textarea").prop('disabled', false);
        newRow.find("select").addClass('common-select2');
        newRow.find(".date-").addClass('datepicker');

        var $rows = $tbody.children('tr').not($trow);
        var lastIndex = 0;
        var lastRow = $rows.last();
            var lastInputName = lastRow.find("input[name^='inputs']").attr('name');
            var lastSelectName = lastRow.find("select[name^='inputs']").attr('name');
            var lastTextName = lastRow.find("textarea[name^='inputs']").attr('name');
            var lastName = lastInputName || lastSelectName || lastTextName;
            var match = lastName && lastName.match(/\[(\d+)\]/);
            if (match) {
                lastIndex = parseInt(match[1], 10);
            }
        var newIndex = lastIndex + 1;

        newRow.find("input, select, textarea").attr('name', function (index, name) {
            return name.replace(/\[\d+\]/, '[' + newIndex + ']');
        });
        newRow.appendTo(tbody);
        // Get values of the last row fields
        var fieldValues = {};
            lastRow.find("input, select, textarea").each(function (index, element) {
                var fieldName = $(element).attr('name');
                var fieldValue = $(element).val();
                fieldName = fieldName.replace(/\[\d+\]/, '[' + newIndex + ']');
                fieldValues[fieldName] = fieldValue;
                var updatedFieldName = fieldName.replace(/\[\d+\]/, '[' + newIndex + ']');
                newRow.find('[name="'+updatedFieldName+'"]').val(fieldValues[updatedFieldName]);

            });

        newRow.find(".wgt").focus().select();
        newRow.find(".common-select2").select2();
        newRow.find(".datepicker").datepicker({ dateFormat: "dd/mm/yy" });
        calTotal()
    }

    function BtnDel(v) {
        $(v).parent().parent().remove();
        calTotal()
    }


    // Event handler for arrow key navigation
    $(document).on('keydown', 'td', function (e) {

        var $this = $(this);
        var index = $this.index();
        var $tr = $this.closest('tr');

        switch (e.which) {
            case 37: // Left arrow key
                if (index > 0) {
                    e.preventDefault();
                    highlightAndFocus($tr.find('td:eq(' + (index - 1) + ')').find(':input'));
                }
                break;
            case 38: // Up arrow key
                e.preventDefault();
                var $prevRow = $tr.prev('tr');
                if ($prevRow.length > 0) {
                    highlightAndFocus($prevRow.find('td:eq(' + index + ')').find(':input'));
                }
                break;
            case 39: // Right arrow key
                e.preventDefault();
                if (index < $tr.find('td').length - 1) {
                    highlightAndFocus($tr.find('td:eq(' + (index + 1) + ')').find(':input'));
                }
                break;
            case 40: // Down arrow key
                e.preventDefault();
                var $nextRow = $tr.next('tr');
                if ($nextRow.length > 0) {
                    highlightAndFocus($nextRow.find('td:eq(' + index + ')').find(':input'));
                }
                break;
        }
     });

     $(document).on('change', 'select,.date- ', function () {
        var $this = $(this);
        var $td = $this.closest('td');

        var index = $td.index();
        var $tr = $this.closest('tr');
        var $element = $tr.find('td:eq(' + (index + 1) + ')').find(':input');
        $(':focus').removeClass('highlight');
        if ($element.hasClass('select2-hidden-accessible')) {
            $element.addClass('highlight').select2('open');
        } else {
            $element.addClass('highlight');
        }
    });

    function highlightAndFocus($element) {
            $(':focus').removeClass('highlight');
            if ($element.hasClass('select2-hidden-accessible')) {
                $element.siblings('.select2').find('.select2-selection').addClass('highlight').focus();
            } else {
                $element.addClass('highlight').focus();
            }
        }

    $(document).on('change', '.last-select', function (e) {
        if (e.which == 13) {
            e.preventDefault()
            BtnAdd('#TRow', '#TBody');

        }
    });

</script>
<script>
    function refreshPage() {
            window.location.reload();
        }
</script>
{{-- js work by mominul end --}}

<script>
    $(document).ready(function() {

        $('#voucherPreviewModal').on('hidden.bs.modal', function(e) {
            window.location.reload();
        });
        BtnAdd('#TRow', '#TBody');

        $("#formSubmit").submit(function(e) {
            e.preventDefault(); // avoid executing the actual submit of the form.
            var form = $(this);
            var url = form.attr('action');
            var data = new FormData(this);
            $("#submitButton").prop("disabled", true)
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
        $(document).on("keyup", ".amount, .qty", function(e) {
            var amount = parseFloat($(this).closest("tr").find(".amount").val()) || 0;
            var qty = parseFloat($(this).closest("tr").find(".qty").val()) || 0;
            var taxable = qty*amount;

            var invoice_type = 'Tax Invoice';
            // $('#invoice_type').val();
            var vat_amount = 0;
            if (invoice_type == 'Tax Invoice') {
                var vat_rate = $(this).closest("tr").find(".vat_rate").val();

                vat_amount = (vat_rate / 100) * taxable;

                total = taxable + vat_amount;
            }
            taxable=taxable*1;
            $(this).closest("tr").find(".taxable").val(taxable.toFixed(2));

            $(this).closest("tr").find(".vat_amount").val(vat_amount.toFixed(2));
            $(this).closest("tr").find(".sub_gross_amount").val(total.toFixed(2));
            calTotal();

        });

        $(document).on("change", ".vat_rate", function(e) {
            var amount = parseFloat($(this).closest("tr").find(".amount").val()) || 0;
            var qty = parseFloat($(this).closest("tr").find(".qty").val()) || 0;
            var taxable = qty*amount;
            var invoice_type = 'Tax Invoice';
            // $('#invoice_type').val();
            var vat_amount = 0;
            if (invoice_type == 'Tax Invoice') {
                var vat_rate = $(this).val();
                vat_amount = (vat_rate / 100) * taxable;

                taxable = (taxable*1) + vat_amount;
            }
            $(this).closest("tr").find(".vat_amount").val(vat_amount.toFixed(2));

            $(this).closest("tr").find(".sub_gross_amount").val(taxable.toFixed(2));

            calTotal();
        });


        $(document).on("keyup change", ".invoice_no, .client_info", function(e) {
            var invoice = $('.invoice_no').val() ||0;
            var client = $('#client_info').val();

            if(client){
                $.ajax({
                    url: "{{ URL('check-invoice') }}",
                    type: "get",
                    cache: false,
                    data: {
                        _token: '{{ csrf_token() }}',
                        client: client,
                        invoice:invoice
                    },
                    success: function(response) {
                    if (response == 1) {
                        toastr.warning('This invoice no is already in use.');
                        $('#submitButton').prop('disabled', true);
                    } else {
                        $('#submitButton').prop('disabled', false);
                    }
                }
                });
            }else{
                alert('First select supplier')

            }
            });
        $(document).on("change", "#project_id", function(e) {
            var project = $(this).val();
            if(project){
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
                        $('.task_id').prop("required", true);
                    }
                });
            }else{
                $('.task_id').empty().prop("required", false);
            }
        });



    });


    $(document).on('click', '.cost_center_modal',function(e){
        e.preventDefault();
        var index = $(this).closest('tr').index();

        $('.index').val(index +1);
        $('#cost_center_modal').modal('show');
    })

    function BtnAdd(trow, tbody) {

        var $trow = $(trow);
        var $tbody = $(tbody);
        var newRow = $trow.clone().removeClass("d-none").removeAttr('id');
        newRow.find("input, select, textarea").prop('disabled', false);
        newRow.find("select").addClass('common-select2');
        newRow.find(".date-").addClass('datepicker');

        var $rows = $tbody.children('tr').not($trow);
        var lastIndex = 0;
        var lastRow = $rows.last();
            var lastInputName = lastRow.find("input[name^='inputs']").attr('name');
            var lastSelectName = lastRow.find("select[name^='inputs']").attr('name');
            var lastTextName = lastRow.find("textarea[name^='inputs']").attr('name');
            var lastName = lastInputName || lastSelectName || lastTextName;
            var match = lastName && lastName.match(/\[(\d+)\]/);
            if (match) {
                lastIndex = parseInt(match[1], 10);
            }
        var newIndex = lastIndex + 1;

        newRow.find("input, select, textarea").attr('name', function (index, name) {
            return name.replace(/\[\d+\]/, '[' + newIndex + ']');
        });
        newRow.appendTo(tbody);
        // Get values of the last row fields
        var fieldValues = {};
            lastRow.find("input, select, textarea").each(function (index, element) {
                var fieldName = $(element).attr('name');
                var fieldValue = $(element).val();
                fieldName = fieldName.replace(/\[\d+\]/, '[' + newIndex + ']');
                fieldValues[fieldName] = fieldValue;
                var updatedFieldName = fieldName.replace(/\[\d+\]/, '[' + newIndex + ']');
                newRow.find('[name="'+updatedFieldName+'"]').val(fieldValues[updatedFieldName]);

            });

        newRow.find(".wgt").focus().select();
        newRow.find(".common-select2").select2();
        newRow.find(".datepicker").datepicker({ dateFormat: "dd/mm/yy" });
        calTotal()
    }

    function BtnDel(v) {
        $(v).parent().parent().remove();
        calTotal()
    }

    // Event handler for arrow key navigation
    $(document).on('keydown', 'td', function (e) {

        var $this = $(this);
        var index = $this.index();
        var $tr = $this.closest('tr');

        switch (e.which) {
            case 37: // Left arrow key
                if (index > 0) {
                    e.preventDefault();
                    highlightAndFocus($tr.find('td:eq(' + (index - 1) + ')').find(':input'));
                }
                break;
            case 38: // Up arrow key
                e.preventDefault();
                var $prevRow = $tr.prev('tr');
                if ($prevRow.length > 0) {
                    highlightAndFocus($prevRow.find('td:eq(' + index + ')').find(':input'));
                }
                break;
            case 39: // Right arrow key
                e.preventDefault();
                if (index < $tr.find('td').length - 1) {
                    highlightAndFocus($tr.find('td:eq(' + (index + 1) + ')').find(':input'));
                }
                break;
            case 40: // Down arrow key
                e.preventDefault();
                var $nextRow = $tr.next('tr');
                if ($nextRow.length > 0) {
                    highlightAndFocus($nextRow.find('td:eq(' + index + ')').find(':input'));
                }
                break;
        }
     });

     $(document).on('change', 'select,.date- ', function () {
        var $this = $(this);
        var $td = $this.closest('td');

        var index = $td.index();
        var $tr = $this.closest('tr');
        var $element = $tr.find('td:eq(' + (index + 1) + ')').find(':input');
        $(':focus').removeClass('highlight');
        if ($element.hasClass('select2-hidden-accessible')) {
            $element.addClass('highlight').select2('open');
        } else {
            $element.addClass('highlight');
        }
    });

    function highlightAndFocus($element) {
        $(':focus').removeClass('highlight');
        if ($element.hasClass('select2-hidden-accessible')) {
            $element.siblings('.select2').find('.select2-selection').addClass('highlight').focus();
        } else {
            $element.addClass('highlight').focus();
        }
    }

    $(document).on('change', '.last-select', function (e) {
        if (e.which == 13) {
            e.preventDefault()
            BtnAdd('#TRow', '#TBody');

        }
    });

    function calTotal(){
        var sum=0;
        var total_vat = 0;
        $('.taxable').each(function() {
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
                $('.task_id').append(newOption);
                $("#itemModal").modal('hide');
            }
        })
    });
    $("#truckAddNew").submit(function(e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.
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
</script>
@endpush
