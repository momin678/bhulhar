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
        /* @media (min-width: 576px)
        {
            .modal-dialog {
                max-width: 740px !important;
                margin: 1.75rem auto;
            }
        } */

    </style>
    <style>
        .changeColStyle span{
            min-width: 16%;
        }
        .changeColStyle .select2-container--default .select2-selection--single .select2-selection__arrow b{
            display: none;
        }
        .journaCreation{
            background: #1214161c;
        }
        .transaction_type{
            padding-right:5px;
            padding-left:5px;
            padding-bottom:5px;
        }
        @media only screen and (max-width: 1500px) {
            .custome-project span{
                max-width: 140px;
            }
        }
    
        thead {
            background: #34465b;
            color: #fff !important;
        }
        th{
            color: #fff !important;
            font-size: 11px !important;
            height: 25px !important;
            text-align: center !important;
        }
        td
        {
            font-size: 12px !important;
            height: 25px !important;
        }
    
        .table-sm th, .table-sm td {
            padding: 0rem;
        }
        .card-body {
            flex: 1 1 auto;
            min-height: 1px;
            padding: 0rem !important;
        }
        .card{
            margin-bottom: 0rem;
            box-shadow: none;
        }
    </style>
@endpush
@section('content')
@include('layouts.backend.partial.style')
<div class="app-content content print-hidden">
    <div class="content-overlay"></div>
    <div class="content-wrapper">

        <div class="content-body">
            
            @include('clientReport.purchase._header',['activeMenu' => 'purchase_expense'])
            <div class="tab-content">
                <div class="tab-pane bg-white active">
                    <div class="py-1 px-2">
                        @include('backend.purchase.bottom-header', ['activeMenu' => 'edit',])
                    </div>
                    <section id="widgets-Statistics">
                        <form action="{{route('purchase-update')}}" method="POST" id="formSubmit" enctype="multipart/form-data" >
                            @csrf
                            <input type="hidden" value="{{$purchase->id}}" name="purchase_id">
                            <div class="cardStyleChange bg-white">
                                <div class="card-body">
                                    <div class="row d-flex align-items-center">
                                        <div class="col-sm-3 form-group d-none">
                                            <label for="">Branch</label>
                                            <select name="branch" class="common-select2" style="width: 100% !important" id="branch">
                                                @foreach ($projects as $item)
                                                    <option value="{{ $item->id }}" {{$purchase->project_id==$item->id?'selected':''}}>{{ $item->proj_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-3 form-group" id="printarea">
                                            <label for="">Purchase Date</label>
                                            <input type="text" value="{{ convert_date_format($purchase->date) }}" class="form-control date" name="date" id="date" required>
                                        </div>
                                        <div class="col-sm-3 form-group">
                                            <label for="">Payment Mode</label>
                                            <select name="pay_mode" id="pay_mode" class="common-select2" style="width: 100% !important" required>
                                                <option value="">Select...</option>
                                                @foreach ($modes as $item)
                                                    <option value="{{ $item->title }}" {{$purchase->pay_mode==$item->title?'selected':''}}>{{ $item->title }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-2 form-group pay-term d-none">
                                            <label for="">Payment Terms</label>
                                            <select name="pay_terms" id="pay_terms" class="common-select2" style="width: 100% !important">
                                                <option value="">Select...</option>
                                                @foreach ($terms as $item)
                                                    <option value="{{ $item->value }}" {{ $item->title=="Today"? 'selected':'' }}>{{ $item->title }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-3 form-group d-none">
                                            <label for="">Due Date</label>
                                            <input type="date" class="form-control" name="due_date" id="due_date" value="{{ date('Y-m-d') }}" readonly>
                                        </div>
                                        <div class="col-sm-4 form-group customer-select">
                                            <label for="">Supplier Name</label>
                                            <select name="customer_name" id="customer_name" class="common-select2 party-info customer" style="width: 100% !important" data-target="" required>
                                                <option value="">Select...</option>
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->pi_code }}" {{$purchase->customer_name==$customer->pi_code?'selected':''}}>{{ $customer->pi_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-2">
                                            <i class="bx bx-user-plus btn btn-info btn-sm text-center" data-toggle="modal" data-target="#customerModal"></i>
                                        </div>
                                        <div class="col-sm-3 form-group">
                                            <label for="">TRN</label>
                                            <input type="text" class="form-control" name="trn_no" id="trn_no" class="form-control" readonly value="{{$purchase->partInfo->trn_no}}">
                                        </div>
                                        <div class="col-sm-3 form-group">
                                            <label for="">Contact Number</label>
                                            <input type="text" class="form-control" name="contact_no" id="contact_no" readonly value="{{$purchase->partInfo->contact_no}}">
                                        </div>

                                        <div class="col-sm-3 form-group">
                                            <label for="">Address</label>
                                            <input type="text" class="form-control" name="address" id="address" readonly value="{{$purchase->partInfo->address}}">
                                        </div>

                                        <div class="col-sm-3 form-group">
                                            <label for="">Invoice No</label>
                                            <input type="text" class="form-control" name="supplier_invoice" id="supplier_invoice" required  value="{{$purchase->supplier_invoice}}">
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="mx-1">
                                <div class="cardStyleChange">
                                    <table class="table table-bordered table-sm ">
                                        <thead class="user-table-body">
                                            <tr>
                                                <th style="min-width: 120px !important;">Category</th>
                                                <th style="min-width: 120px !important;">Vehicle Brand</th>
                                                <th style="min-width: 120px !important;">Vehicle Name</th>
                                                <th style="min-width: 120px !important;">Vehicle Model</th>
                                                <th style="min-width: 120px !important;">Item Code <span style="font-size: 15px; font-weight: 800;" data-toggle="modal" data-target="#exampleModal">+</span></th>
                                                <th>QTY</th>
                                                <th>Rate</th>
                                                <th>Amount</th>
                                                <th>Vat</th>
                                                <th>Total</th>
                                                <th  class="NoPrint"> <button type="button" class="btn btn-sm btn-success addBtn"style="border: 1px solid green;
                                                    color: #fff; border-radius: 10px;padding: 5px;" onclick="BtnAdd()">ADD</button>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="TBody" class="user-table-body">
                                            @foreach ($purchase_items as $purchase_i)
                                            <tr class="purchase_tr">
                                                <td>
                                                    <select name="multi_category[]" class="inputFieldHeight2 form-control multi_category" style="width: 100%; HEIGHT: 36PX;">
                                                        <option value="">Select....</option>
                                                        @foreach ($categories as $item)
                                                            <option style="width: 100px" value="{{ $item->id }}" {{$item->id==$purchase_i->cat_id?'selected':''}}>{{ $item->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="multi_brand_td">
                                                    <select name="multi_brand[]" class="inputFieldHeight2 form-control multi_brand" style="width: 100%; HEIGHT: 36PX;">
                                                        <option value="">Select....</option>
                                                        @foreach ($purchase_i->item_brands($purchase_i) as $brand)
                                                            <option value="{{$brand->id}}" {{$brand->id==$purchase_i->brand_id?'selected':''}}>{{$brand->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="multi_vehicle_name_td">
                                                    <select name="multi_vehicle_name[]" class="inputFieldHeight2 form-control multi_vehicle_name" style="width: 100%; HEIGHT: 36PX;">
                                                        <option value="">Select....</option>
                                                        @foreach ($purchase_i->item_vehicle_names($purchase_i) as $vehicle_name)
                                                            <option value="{{$vehicle_name->id}}" {{$vehicle_name->id==$purchase_i->vehicle_name_id?'selected':''}}>{{$vehicle_name->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="multi_vehicle_model_td">
                                                    <select name="multi_vehicle_model[]" class="inputFieldHeight2 form-control multi_vehicle_model" style="width: 100%; HEIGHT: 36PX;">
                                                        <option value="">Select....</option>
                                                        @foreach ($purchase_i->item_model_names($purchase_i) as $sub_brand)
                                                            <option value="{{$sub_brand->id}}" {{$sub_brand->id==$purchase_i->sub_brand_id?'selected':''}}>{{$sub_brand->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="multi_item_code_td">
                                                    <select name="multi_item_code[]" class="inputFieldHeight2 form-control multi_item_code" style="width: 100%; HEIGHT: 36PX;">
                                                        <option value="">Select....</option>
                                                        @foreach ($purchase_i->item_codes($purchase_i) as $code)
                                                            <option value="{{$code->id}}" {{$code->id==$purchase_i->item_code_id?'selected':''}}>{{$code->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td><input type="number" name="multi_qty[]" step="any" class="inputFieldHeight2 form-control inputFieldHeight multi_qty" style="width: 100%;height:36px;" value="{{$purchase_i->quantity}}"></td>
                                                <td><input type="number" name="multi_unit_price[]" step="any" class="inputFieldHeight2 form-control inputFieldHeight multi_unit_price" style="width: 100%;height:36px;" value="{{$purchase_i->unit_price}}"></td>
                                                <td><input type="number" name="multi_total_price[]" step="any" class="inputFieldHeight2 form-control inputFieldHeight multi_total_price" style="width: 100%;height:36px;" readonly value="{{$purchase_i->price}}"></td>
                                                <td><input type="number" name="multi_vat_price[]" step="any" class="inputFieldHeight2 form-control inputFieldHeight multi_vat_price" style="width: 100%;height:36px;" readonly value="{{$purchase_i->vat}}"></td>
                                                <td><input type="number" name="multi_total_amount[]" step="any" class="form-control inputFieldHeight2 multi_total_amount"style="width: 100%;height:36px;" readonly value="{{$purchase_i->total_price}}"></td>
                                                <td class="NoPrint"><button style="padding: 2px; margin: 4px;" type="button" class="bx bx-trash"onclick="BtnDel(this)"></button></td>
                                            </tr>
                                            @endforeach
                                            <tr id="TRow" class="purchase_tr d-none">
                                                <td>
                                                    <select name="multi_category[]" class="inputFieldHeight2 form-control multi_category" style="width: 100%; HEIGHT: 36PX;">
                                                        <option value="">Select....</option>
                                                        @foreach ($categories as $item)
                                                            <option style="width: 100px" value="{{ $item->id }}">{{ $item->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="multi_brand_td">
                                                    <select name="multi_brand[]" class="inputFieldHeight2 form-control multi_brand" style="width: 100%; HEIGHT: 36PX;">
                                                        <option value="">Select....</option>
                                                    </select>
                                                </td>
                                                <td class="multi_vehicle_name_td">
                                                    <select name="multi_vehicle_name[]" class="inputFieldHeight2 form-control multi_vehicle_name" style="width: 100%; HEIGHT: 36PX;">
                                                        <option value="">Select....</option>
                                                    </select>
                                                </td>
                                                <td class="multi_vehicle_model_td">
                                                    <select name="multi_vehicle_model[]" class="inputFieldHeight2 form-control multi_vehicle_model" style="width: 100%; HEIGHT: 36PX;">
                                                        <option value="">Select....</option>
                                                    </select>
                                                </td>
                                                <td class="multi_item_code_td">
                                                    <select name="multi_item_code[]" class="inputFieldHeight2 form-control multi_item_code" style="width: 100%; HEIGHT: 36PX;">
                                                        <option value="">Select....</option>
                                                        @foreach ($item_codes as $item)
                                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td><input type="number" name="multi_qty[]" step="any" class="inputFieldHeight2 form-control inputFieldHeight multi_qty" style="width: 100%;height:36px;"></td>
                                                <td><input type="number" name="multi_unit_price[]" step="any" class="inputFieldHeight2 form-control inputFieldHeight multi_unit_price" style="width: 100%;height:36px;"></td>
                                                <td><input type="number" name="multi_total_price[]" step="any" class="inputFieldHeight2 form-control inputFieldHeight multi_total_price" style="width: 100%;height:36px;" readonly></td>
                                                <td><input type="number" name="multi_vat_price[]" step="any" class="inputFieldHeight2 form-control inputFieldHeight multi_vat_price" style="width: 100%;height:36px;" readonly></td>
                                                <td><input type="number" name="multi_total_amount[]" step="any" class="form-control inputFieldHeight2 multi_total_amount"style="width: 100%;height:36px;" readonly></td>
                                                <td class="NoPrint"><button style="padding: 2px; margin: 4px;" type="button" class="bx bx-trash"onclick="BtnDel(this)"></button></td>
                                            </tr>
                                        </tbody>
                                        <tbody>
                                            <tr>
                                                <td colspan="7"></td>
                                                <td colspan="2" class="text-center" style="color: black">Sub Total</td>
                                                <td colspan="2">
                                                    <input type="text" readonly id="sub_total" class="inputFieldHeight2 form-control inputFieldHeight sub_total" name="amount" value="{{$purchase->amount}}" placeholder="Sub Total">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="7"></td>
                                                <td colspan="2" class="text-center" style="color: black">Tax Amount</td>
                                                <td colspan="2">
                                                    <input type="text" readonly id="tax_amount" class="inputFieldHeight2 form-control inputFieldHeight tax_amount" name="vat_amount" value="{{$purchase->vat_amount}}" placeholder="Tax Amount">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="7"></td>
                                                <td colspan="2" class="text-center" style="color: black"> Total Amount</td>
                                                <td colspan="2">
                                                    <input type="text" readonly id="total_amount" class="inputFieldHeight2 form-control inputFieldHeight total_amount" name="total_amount" placeholder="Total Amount" value="{{$purchase->total_amount}}">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="cardStyleChange">
                                <div class="card-body bg-white">
                                    <div class="row px-1">
                                        <div class="col-sm-12 text-right d-flex justify-content-end mt-2 mb-1">
                                            <button type="button" class="btn btn-info formButton mr-1" id="purchase_form_preview">
                                                <div class="d-flex">
                                                    <div class="formSaveIcon">
                                                        <img  src="{{asset('assets/backend/app-assets/icon/save-icon.png')}}" width="25">
                                                    </div>
                                                    <div><span>Preview</span></div>
                                                </div>
                                            </button>
                                            <button type="submit" class="btn btn-primary form_submit_button" id="save">
                                                <div class="d-flex">
                                                    <div class="formSaveIcon">
                                                        <img  src="{{asset('assets/backend/app-assets/icon/save-icon.png')}}" width="25">
                                                    </div>
                                                    <div><span>Save</span></div>
                                                </div>
                                            </button>
                                            <button type="submit" class="btn btn-dark form_submit_button ml-1" id="save_print">
                                                <div class="d-flex">
                                                    <div class="formSaveIcon">
                                                        <img  src="{{asset('assets/backend/app-assets/icon/save-icon.png')}}" width="25">
                                                    </div>
                                                    <div><span>Save & Print</span></div>
                                                </div>
                                            </button>
                                            
                                            <button type="button" class="btn btn-warning d-none" id="new_form_button"> <a href="{{route('purchase.index')}}">New Entry</a> </button>
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


    <!-- Modal -->
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
                                        <input type="text" id="email" class="form-control" name="email" value="{{ isset($costCenter) ? $costCenter->email : '' }}" placeholder="Email">


                                        @error('email')
                                            <div class="btn btn-sm btn-danger">{{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-12 d-flex justify-content-end ">

                                        <button type="submit" class="btn btn-primary mr-1">Submit</button>
                                        <button type="reset" class="btn btn-light-secondary">Reset</button>

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
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
            
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg"  id="purchase_previewModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div id="purchase_preview">
    
            </div>
          </div>
        </div>
    </div>
    
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">New Product</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form action="{{  route('item-code.store') }}" method="POST" enctype="multipart/form-data" id="product_formSubmit">
                    @csrf
                    <div class="row match-height">
                        <div class="col-md-6">
                            <label for="">Item Code</label>
                            <input type="text" name="name" class="form-control inputFieldHeight" value="{{old('name')}}" required placeholder="Item Code">
                        </div>
                        <div class="col-md-6">
                            <label for="">Category</label>
                            <select  name="category_id" id="category_id" class="common-select2" style="width: 100% !important" required>
                                <option value="">Select......</option>
                                @foreach ($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="">Vehicle Brand</label>
                            <select  name="brand_id" id="brand_id" class="common-select2" style="width: 100% !important" required>
                                <option value="">Select......</option>
                                @foreach ($brands as $brand)
                                    <option value="{{$brand->id}}">{{$brand->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="">Vehicle Name</label>
                            <select  name="vehicle_name_id" id="vehicle_name_id" class="common-select2" style="width: 100% !important" required>
                                <option value="">Select......</option>
                                @foreach ($vehicle_names as $vehicle_name)
                                    <option value="{{$vehicle_name->id}}">{{$vehicle_name->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="">Vehicle Model</label>
                            <select  name="vehicle_model_id" id="vehicle_model_id" class="common-select2" style="width: 100% !important" required>
                                <option value="">Select......</option>
                                @foreach ($vehicle_models as $vehicle_model)
                                    <option value="{{$vehicle_model->id}}">{{$vehicle_model->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="">Sale Price</label>
                            <input type="text" name="sale_price" class="form-control inputFieldHeight" value="{{old('sale_pice')}}" placeholder="Sale Price">
                        </div>
                        <div class="col-md-6">
                            <label for="">Unit</label>
                            <select  name="unit_id" id="unit_id" class="common-select2" style="width: 100% !important" required>
                                <option value="">Select......</option>
                                @foreach ($units as $unit)
                                    <option value="{{$unit->id}}" {{old('unit_id')==$unit->id?'selected':''}}>{{$unit->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 d-flex justify-content-end mt-2">
                            <button type="submit" class="btn btn-primary btn-sm mr-1">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
          </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg"  id="preview_chekcModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div id="preview_chekc">
                
            </div>
          </div>
        </div>
    </div>
    <!-- End Modal -->
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
    {{-- <script src="{{ asset('assets/backend/app-assets/vendors/js/jquery/jquery.min.js') }}"></script> --}}
<script>
    
    $('#customer_name').change(function() {
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
                    $("#trn_no").val(response.trn_no);
                    $("#contact_no").val(response.con_no);
                    $("#address").val(response.address);
                    $("#invoice_no").focus();
                }
            })
        }
    });
    /* Add new tr */
    function BtnAdd() {
        var newRow = $("#TRow").clone();
        newRow.removeClass("d-none");
        newRow.find("input, select").val('').attr('name', function(index, name) {
            return name.replace(/\[\d+\]/, '[' + ($('#TBody tr').length) + ']');
        });
        newRow.find("th").first().html($('#TBody tr').length+1 );
        newRow.appendTo("#TBody");
        newRow.find(".multi_item_code").select2();
    }
    /* Delete tr */
    function BtnDel(v) {
        $(v).parent().parent().remove();
        sum_all_amount();
        $("#TBody").find("tr").each(function(index) {
            $(this).find("th").first().html(index);
        });
    }
    var vat_rate = "{{vat_rate()}}";
    function sum_all_amount(){
        var sum=0;
        var vat_amount = 0;
        $('.multi_total_price').each(function() {
            var this_amount= $(this).val();
            this_amount = (this_amount === '') ? 0 : this_amount;
            this_amount= Number(this_amount);
            sum = sum+this_amount;
            // tax calculate
            vat_amount += (this_amount*vat_rate)/100;
        });
        $('#sub_total').val(sum.toFixed(2));
        $('#tax_amount').val(vat_amount.toFixed(2));
        $('#total_amount').val((vat_amount+sum).toFixed(2));
    }

    $(document).on('keyup', '.multi_unit_price', function(e){
        var rate = $(this).val();
        var multi_total_amount_obj= $(this).closest('.purchase_tr').find('.multi_total_amount');
        var multi_total_price_obj= $(this).closest('.purchase_tr').find('.multi_total_price');
        var multi_qty_obj= $(this).closest('.purchase_tr').find('.multi_qty');
        var total_amount = rate*multi_qty_obj.val();
        multi_total_price_obj.val(total_amount.toFixed(2));
        // tax calculate
        var multi_tax_obj= $(this).closest('.purchase_tr').find('.multi_vat_price');
        var vat_amount = (total_amount*vat_rate)/100;
        multi_tax_obj.val(vat_amount.toFixed(2));
        multi_total_amount_obj.val((total_amount+vat_amount).toFixed(2));
        sum_all_amount();
    });

    $(document).on('keyup', '.multi_qty', function(e){
        var qty = $(this).val();
        var multi_total_amount_obj= $(this).closest('.purchase_tr').find('.multi_total_amount');
        var multi_unit_price_obj= $(this).closest('.purchase_tr').find('.multi_unit_price');
        var multi_total_price_obj= $(this).closest('.purchase_tr').find('.multi_total_price');
        var total_amount = qty*multi_unit_price_obj.val();
        multi_total_price_obj.val(total_amount.toFixed(2));
        
        var multi_tax_obj= $(this).closest('.purchase_tr').find('.multi_vat_price');
        var vat_amount = (total_amount*vat_rate)/100;
        multi_tax_obj.val(vat_amount.toFixed(2));
        multi_total_amount_obj.val((total_amount+vat_amount).toFixed(2))

        sum_all_amount();
    });

    $(document).on('click', '#purchase_form_preview', function(e){
        e.preventDefault();
        var form = $(this).closest('#formSubmit');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('purchase-preview') }}",
            type: 'POST',
            data: form.serialize(),
            success: function(response) {
                document.getElementById("purchase_preview").innerHTML = response;
                $('#purchase_previewModal').modal('show')
            }
        });
    });
    
    $(document).on("change", ".multi_category", function(e) {
        var category = $(this).val();
        var multi_brand_obj= $(this).closest('.purchase_tr').find('.multi_brand_td');
        var multi_item_code_obj= $(this).closest('.purchase_tr').find('.multi_item_code');
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: "{{ route('brand.fetch') }}",
            method: "POST",
            data: {
                category: category,
                _token: _token,
            },
            success: function(response) {
                multi_brand_obj.empty().append(response.page);
                multi_item_code_obj.empty();
            }
        })
    });
    $(document).on("change", ".multi_brand", function(e) {
        var brand = $(this).val();
        var category_id= $(this).closest('.purchase_tr').find('.multi_category').val();
        var multi_vehicle_name_obj= $(this).closest('.purchase_tr').find('.multi_vehicle_name');
        var multi_vehicle_model_td= $(this).closest('.purchase_tr').find('.multi_vehicle_name_td');
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: "{{ route('vehicle-name-fetch') }}",
            method: "POST",
            data: {
                brand: brand,
                category_id:category_id,
                _token: _token,
            },
            success: function(response) {
                multi_vehicle_model_td.empty().append(response.page);
                multi_vehicle_name_obj.empty();
            }
        })
    });
    $(document).on("change", ".multi_vehicle_name", function(e) {
        var vehicle_name_id = $(this).val();
        var brand_id= $(this).closest('.purchase_tr').find('.multi_brand').val();
        var category_id= $(this).closest('.purchase_tr').find('.multi_category').val();
        var multi_item_code_obj= $(this).closest('.purchase_tr').find('.multi_item_code');
        var multi_vehicle_model_td= $(this).closest('.purchase_tr').find('.multi_vehicle_model_td');
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: "{{ route('sub_brand.fetch') }}",
            method: "POST",
            data: {
                vehicle_name_id:vehicle_name_id,
                category_id:category_id,
                brand_id: brand_id,
                _token: _token,
            },
            success: function(response) {
                multi_vehicle_model_td.empty().append(response.page);
                multi_item_code_obj.empty();
            }
        })
    });
    $(document).on("change", ".multi_vehicle_model", function(e) {
        var vehicl_model = $(this).val();
        var brand_id= $(this).closest('.purchase_tr').find('.multi_brand').val();
        var category_id= $(this).closest('.purchase_tr').find('.multi_category').val();
        var vehicle_name_id= $(this).closest('.purchase_tr').find('.multi_vehicle_name').val();
        var multi_item_code_obj= $(this).closest('.purchase_tr').find('.multi_item_code_td');
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: "{{ route('vehicl-model-fetch') }}",
            method: "POST",
            data: {
                vehicle_name_id:vehicle_name_id,
                category_id:category_id,
                brand_id: brand_id,
                vehicl_model: vehicl_model,
                _token: _token,
            },
            success: function(response) {
                multi_item_code_obj.empty().append(response.page);
            }
        })
    });
    $("#product_formSubmit").submit(function(e) {
        e.preventDefault();
        var form = $('#product_formSubmit');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('product-add') }}",
            type: 'POST',
            data: form.serialize(),
            success: function(response) {
                optionText = response.name;
                optionValue = response.id;
                $('.multi_item_code').append(`<option value="${optionValue}">${optionText}</option>`);
                $("#exampleModal").modal('hide');
            }
        });
    });
    
    $(document).on('click', '.form_submit_button', function(e){
        e.preventDefault();
        var form = $(this).closest('#formSubmit');
        var button_type = $(this).attr('id');
        var party = $("#customer_name").val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        if(!party){
            toastr.warning('Party Name Select Please');
        }else{
            $.ajax({
                url: "{{ route('purchase-update') }}",
                type: 'POST',
                data: form.serialize(),
                success: function(response) {
                    $("#new_form_button").removeClass("d-none")
                    $(".form_submit_button").addClass("d-none")
                    if(button_type == 'save'){
                        toastr.success('Update successfully');                        
                    }else{
                        document.getElementById("preview_chekc").innerHTML = response;
                        $('#preview_chekcModal').modal('show');
                        setTimeout(function() { window.print(); }, 1000);
                    }
                }
            });
        }
    });
</script>

@endpush



