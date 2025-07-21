@extends('layouts.backend.app')
@section('content')
@include('layouts.backend.partial.style')
<style>

    #truck_service_process td {
        padding: 0;
        max-width: 100px;
    }

    #truck_service_process td input {
        padding: 0 5px;
        width: 100% !important;
        height: 29px;
    }

    #truck_service_process input {
        border:none;
    }
    .commonSelect2Style span{
        width: 100% !important;
    }
    .select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b{
        /* display: none; */
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow b{
        /* display: none; */
    }
    .master-icon{
        margin-top: 15px !important;
    }
    .nav-link{
        padding: 0 18px 5px !important;
    }
    span.select2.select2-container.select2-container--default{
        width: 100% !important;
    }

</style>
    <!-- BEGIN: Content-->
    <div class="app-content content print-hideen">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                @include('clientReport.business-operation.header',['activeMenu' => 'customer_invoice'])
                <div class="tab-content bg-white">
                    @include('backend.customer-invoice.sub-head',['activeMenu' => 'create'])
                    <div class="p-2">
                        <div class="d-flex">
                            <h4 class="flex-grow-1">Invoice</h4>
                            <div>
                                <button type="button" class="btn btn-primary btn_create formButton" title="Add" data-toggle="modal" data-target="#newServiceAdd">
                                    <div class="d-flex">
                                        <div class="formSaveIcon">
                                            <img src="{{asset('assets/backend/app-assets/icon/add-icon.png')}}" width="25">
                                        </div>
                                        <div><span>Service Add</span></div>
                                    </div>
                                </button>
                            </div>
                        </div>
                        <form action="{{ route('save-customer-invoice')}}" id="invoice-form" method="POST">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="customer_id" id="customer_id_change">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Project Name <span> <input type="checkbox" checked name="project_check" value="1"></span></label>
                                        <select name="project" class="inputFieldHeight form-control project common-select2">
                                            @foreach ($projects as $project)
                                                <option value="{{$project->id}}">{{ $project->proj_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Customer Name <span> <input type="checkbox" checked name="customer_name_check" value="1"></span></label>
                                        <input type="text" readonly class="inputFieldHeight customer_name_check form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Address Name <span> <input type="checkbox" checked name="customer_address_check" value="1"></span></label>
                                        <input type="text" readonly  class="inputFieldHeight customer_address_check form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Phone Number <span> <input type="checkbox" checked name="customer_phone_check" value="1"></span></label>
                                        <input type="text" readonly class="inputFieldHeight customer_phone_check form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">TRN Number <span> <input type="checkbox" checked name="customer_trn_check" value="1"></span></label>
                                        <input type="text" readonly class="inputFieldHeight customer_trn_check form-control">
                                    </div>
                                </div>
                                {{-- <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Cost Center </label></label>
                                        <select name="cost_center" class="inputFieldHeight form-control cost_center common-select2">
                                            @foreach ($cost_centers as $cost_center)
                                                <option value="{{$cost_center->id}}">{{ $cost_center->cc_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> --}}
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Payment Mode</label>
                                        <select name="pay_mode" id="pay_mode" class="inputFieldHeight pay_mode form-control common-select2">
                                            @foreach ($pay_modes as $pay_mode)
                                                <option value="{{$pay_mode->title}}">{{ $pay_mode->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Date <span> <input type="checkbox" checked name="date_check" value="1"></span></label>
                                        <input type="text"  id="date" autocomplete="off" value="{{ date('d/m/Y') }}" placeholder="dd/mm/yyyy" class="inputFieldHeight date form-control" name="date" required>
                                    </div>
                                </div>
                                {{-- <div class="col-sm-3 form-group pay-term">
                                    <label for="">Payment Terms </label>
                                    <select name="pay_terms" id="pay_terms" class="common-select2 pay_terms" style="width: 100% !important"
                                        required>
                                        <option value="">Select...</option>
                                        @foreach ($terms as $item)
                                            <option value="{{ $item->value }}" {{ $item->title=="Today"? 'selected':'' }}>{{ $item->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-3 form-group">
                                    <label for="">Due Date </label>
                                    <input type="text" class="form-control due_date inputFieldHeight" name="due_date"
                                        id="due_date" value="{{ date('d/m/Y') }}" readonly>
                                </div> --}}
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">LPO Number <span> <input type="checkbox" checked name="lpo_check" value="1"></span></label>
                                        <input type="text"  class="inputFieldHeight lpo_number form-control" name="lpo_number" >
                                    </div>
                                </div>
                                {{-- <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">DO. NO <span> <input type="checkbox" checked name="do_check" value="1"></span></label>
                                        <input type="text"  class="inputFieldHeight lpo_number form-control" name="do_number" required>
                                    </div>
                                </div> --}}
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Invoice Type</label>
                                        <select name="invoice_type"  class="common-select2 invoice_type" style="width: 100% !important" required>
                                            <option value="TAX INVOICE">TAX INVOICE</option>
                                            <option value="INVOICE">INVOICE</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Month <span> <input type="checkbox" checked name="month_check" value="1"></span></label>
                                        <input type="month" class="inputFieldHeight form-control month" name="month">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Pay Term <small>(Days)</small> <span> <input type="checkbox" checked name="pay_term_check" value="1"></span></label>
                                        <input type="number"  class="inputFieldHeight pay_term form-control" name="pay_term" >
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Invoice No</label>
                                        <input type="text" class="inputFieldHeight form-control" name="invoice_no" id="invoice_no" required>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table mb-0 table-sm table-hover table-bordered">
                                    <thead class="thead-light">
                                        <tr style="height: 25px;">
                                            {{-- <th>SL No.</th> --}}
                                             <th style="width: 25px">SL</th>
                                            <th>Date <span> <input type="checkbox" checked name="item_date_check" value="1"></span></th>
                                            <th>Truck <span> <input type="checkbox" checked name="truck_check" value="1"></span></th>
                                            <th>Material <span> <input type="checkbox" checked name="material_check" value="1"></span></th>
                                            <th>Crusher <span> <input type="checkbox" checked name="cursher_check" value="1"></span></th>
                                            <th>DSTN <span> <input type="checkbox" checked name="dstn_e_check" value="1"></span></th>
                                            <th>DO. NO <span> <input type="checkbox" checked name="serial_check" value="1"></span></th>
                                            <th>TKT Number <span> <input type="checkbox" checked name="tkt_number" value="1"></span></th>
                                            <th>WGT <span> <input type="checkbox" checked name="wgt_check" value="1"></span></th>
                                            <th>Rate <span> <input type="checkbox" checked name="rate_check" value="1"></span></th>

                                            <th>Amount <span> <input type="checkbox" checked name="amount_check" value="1"></span></th>
                                            <th>VAT Rate <span> <input type="checkbox" checked name="vat_rate_check" value="1"></span></th>
                                            <th>Discount <span> <input type="checkbox" checked name="discount_check" value="1"></span></th>
                                            <th>VAT Amount <span> <input type="checkbox" checked name="vat_amount_check" value="1"></span></th>
                                            <th>Total Amount <span> <input type="checkbox" checked name="tatl_amount_check" value="1"></span></th>
                                            <th>Toll Fee <span> <input type="checkbox" checked name="toll_check" value="1"></span></th>
                                            <th class="d-none">Total Toll Fee <span> <input type="checkbox" checked name="total_toll_check" value="1"></span></th>
                                            <th style="width:40px !important;text-align:center">Action</th>

                                        </tr>
                                    </thead>
                                    <tbody id="truck_service_process" class="table-sm">

                                    </tbody>
                                    <tbody class="table-sm">

                                        <tr class="trFontSize">
                                            <td colspan="15" align="right">Total Taxable Amount</td>
                                            <td><input type="text"  style="max-width:70px;"name="total_taxable_amount" required id="total_taxable_amount" readonly></td>
                                        </tr>
                                        <tr class="trFontSize">
                                            <td colspan="15" align="right">Total Discount Amount</td>
                                            <td><input type="text"  style="max-width:70px;"name="total_discount_amount" id="total_discount_amount" readonly></td>
                                        </tr>
                                        <tr class="trFontSize">
                                            <td colspan="15" align="right">Total VAT Amount</td>
                                            <td><input type="text"  style="max-width:70px;"name="total_vat_amount" id="total_vat_amount" readonly></td>
                                        </tr>

                                        <tr class="trFontSize">
                                            <td colspan="15" align="right">Total Toll Fee Amount</td>
                                            <td><input type="text"  style="max-width:70px;"name="total_toll_fee_amount" id="total_toll_fee_amount" readonly></td>
                                        </tr>
                                        <tr class="trFontSize">
                                            <td colspan="15" align="right">Total Amount</td>
                                            <td><input type="text"  style="max-width:70px;"name="total_amount_sum" id="total_amount" required readonly></td>
                                        </tr>
                                        <tr class="trFontSize">
                                            <td colspan="15" align="right">Payment Applied</td>
                                            <td><input type="decimal" style="max-width:70px;" name="payment_amount" id="payment_amount" required></td>
                                        </tr>
                                        <tr class="trFontSize">
                                            <td colspan="15" align="right">Balance Due</td>
                                            <td><input type="number" step='any'  style="max-width:70px;"name="due_amount" id="due_amount" min='0' readonly></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <p class="text-right"><button class="btn btn-info mt-1" type="submit" id="submit_button">Procced</button></p>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
{{-- modal --}}
    <div class="modal fade bd-example-modal-lg" id="newTruckAddModal" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <section class="print-hideen border-bottom">
                <div class="d-flex flex-row-reverse">
                    <div class="mIconStyleChange"><a href="#" class="close btn-icon btn btn-danger" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class='bx bx-x'></i></span></a></div>
                    <div class="mIconStyleChange"><a href="#" class="btn btn-icon btn-success"><i class="bx bx-edit"></i></a></div>
                    <div class="mIconStyleChange"><a href="#" onclick="window.print();" class="btn btn-icon btn-secondary"><i class='bx bx-printer'></i></a></div>
                    <div class="mIconStyleChange"><a href="#" onclick="window.print();" class="btn btn-icon btn-primary"><i class='bx bxs-file-pdf'></i></a></div>
                    <div class="mIconStyleChange"><a href="#" onclick="window.print();" class="btn btn-icon btn-light"><i class='bx bxs-virus'></i></a></div>
                </div>
            </section>
            <div class="content-body">
                <form class="form form-vertical" id="save-form" action="{{ route('save-truck-service')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <section id="basic-vertical-layouts">
                        <div class="row match-height">
                            <div class="col-md-12 col-12">
                                <div class="cardStyleChange">
                                    <div class="card-body">
                                        <div class="form-body">
                                            <h4> WEIGH BRIDGE / DELIVERY NOTE</h4>
                                            <div class="row">
                                                <div class="col-md-1 col-12 ">
                                                    <label for="">Party</label>
                                                </div>
                                                <div class="col-md-6 col-12 commonSelect2Style">
                                                    <select name="party_id" id="fld_customer" class="inputFieldHeight form-control common-select2">
                                                        <option value="">Select Name</option>
                                                        @foreach ($customers as $customer)
                                                        <option value="{{$customer->id}}" >{{ $customer->pi_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-5"></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3 col-12 ">
                                                    <label for="">Date</label>
                                                    <input type="date" name="date" id="fld_date" class="inputFieldHeight form-control" placeholder="Date">
                                                </div>
                                                <div class="col-md-3 col-12 commonSelect2Style">
                                                    <label for="">Truck</label>
                                                    <select name="truck_id" id="fld_truck" class="inputFieldHeight form-control common-select2">
                                                        <option value="">Select Name</option>
                                                        @foreach ($trucks as $truck)
                                                        <option value="{{$truck->id}}" vehicle-no="{{$truck->vehicle_number}}" >{{ $truck->vehicle_number}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3 col-12 ">
                                                    <label for="">Material</label>
                                                    <input type="text" name="material" id="fld_material" class="inputFieldHeight form-control" placeholder="Material">
                                                </div>
                                                <div class="col-md-3 col-12 ">
                                                    <label for="">Crusher/Site </label>
                                                    <input type="text" name="crusher" id="fld_crusher" class="inputFieldHeight form-control" placeholder="Crusher/Site">
                                                </div>
                                                <div class="col-md-3 col-12 ">
                                                    <label for="">DSTN</label>
                                                    <input type="text" name="dstm" id="fld_dstn" class="inputFieldHeight form-control" placeholder="DSTN">
                                                </div>
                                                <div class="col-md-3 col-12 ">
                                                    <label for="">Serial</label>
                                                    <input type="text" name="serial" id="fld_serial" class="inputFieldHeight form-control" placeholder="Serial">
                                                </div>
                                                <div class="col-md-3 col-12 ">
                                                    <label for="">WGT</label>
                                                    <input type="text" name="wgt" id="fld_wight" class="inputFieldHeight form-control" placeholder="WGT">
                                                </div>
                                                <div class="col-md-3 col-12 commonSelect2Style">
                                                    <label for="">Third Party</label>
                                                    <select name="third_party_id" id="fld_truck_owner" class="inputFieldHeight form-control common-select2">
                                                        <option value="">Select Name</option>
                                                        @foreach ($suppliers as $supplier)
                                                        <option value="{{$supplier->id}}" party-name="{{$supplier->pi_name}}">{{ $supplier->pi_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-12 d-flex justify-content-end mt-2 mb-2" >
                                                    <button type="button" class="btn btn-primary formButton add_item" title="Searching">
                                                        <div class="d-flex">
                                                            <div class="formSaveIcon">
                                                                <img src="{{asset('assets/backend/app-assets/icon/add-icon.png')}}" alt="" srcset="" width="20">
                                                            </div>
                                                            <div><span>Add</span></div>
                                                        </div>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <table class="table mb-0 table-sm table-hover">
                                            <thead  class="thead-light">
                                                <tr style="height: 50px;">
                                                    <th>Date</th>
                                                    <th>Truck</th>
                                                    <th>Material</th>
                                                    <th>Crusher/Site</th>
                                                    <th>DSTN</th>
                                                    <th>Serial</th>
                                                    <th>WGT</th>
                                                    <th>Third Party</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-sm" id="items_cart">
                                                <tr class="trFontSize">
                                                    <td>10-Oct-2022</td>
                                                    <td>19383-RAK</td>
                                                    <td>60-95MM</td>
                                                    <td>Power INT.</td>
                                                    <td>Rak Port</td>
                                                    <td>109667</td>
                                                    <td>82.88</td>
                                                    <td>Al Anood Transport Raghbir</td>
                                                    <td class="">
                                                        <a href="#" class="btn truckInfoEdit" onclick="delete_item(0)" title="Delete" style="padding-top: 1px; padding-bottom: 1px; height: 30px; width: 30px;">
                                                            <img src="{{asset('assets/backend/app-assets/icon/delete-icon.png')}}" style=" height: 30px; width: 30px;">
                                                        </a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-12 d-flex justify-content-end mt-2 mb-2" >
                                        <button type="button" class="btn btn-primary formButton" id="record-submit" title="Searching">
                                            <div class="d-flex">
                                                <div class="formSaveIcon">
                                                    <img src="{{asset('assets/backend/app-assets/icon/save-icon.png')}}" alt="" srcset="" width="20">
                                                </div>
                                                <div><span>save</span></div>
                                            </div>
                                        </button>
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
    <div class="modal fade bd-example-modal-lg" id="newServiceAdd" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <section class="print-hideen border-bottom">
                <div class="d-flex flex-row-reverse">
                    <div class="mIconStyleChange"><a href="#" class="close btn-icon btn btn-danger" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class='bx bx-x'></i></span></a></div>
                </div>
            </section>
            <div class="content-body">
                {{-- <form class="form form-vertical" id="save-form"> --}}
                    <section id="basic-vertical-layouts">
                        <div class="row match-height">
                            <div class="col-md-12 col-12">
                                <div class="cardStyleChange">
                                    <div class="row m-1">
                                        <div class="col-md-3">
                                            <label>Customer Name</label>
                                            <select name="customer_id" class="inputFieldHeight form-control common-select2" id="customer_id">
                                                <option value="">Select Name</option>
                                                @foreach ($customers as $customer)
                                                <option value="{{$customer->id}}">{{ $customer->pi_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label>	Crusher/Site</label>
                                            <select name="crusher" class="inputFieldHeight form-control common-select2" id="crusher">
                                                <option value="">Select Crusher/Site</option>
                                                @foreach ($crusher as $item)
                                                <option value="{{$item->name}}" data-crusher_id="{{$item->id}}">{{$item->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label>	DSTN</label>
                                            <select name="destination" class="inputFieldHeight form-control common-select2" id="destination">
                                                <option value="">Select DSTN</option>
                                                @foreach ($destination as $item)
                                                <option value="{{$item->name}}" data-dstm_id="{{$item->id}}">{{$item->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">Date From</label>
                                                <input type="text" class="inputFieldHeight form-control" name="date_from" id="date_from" placeholder="dd/mm/yyyy">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">Date To</label>
                                                <input type="text" class="inputFieldHeight form-control" name="date_to" id="date_to" placeholder="dd/mm/yyyy">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <button class="btn btn-light mt-2 float-right" style="height: 35px" id="search">Search</button>
                                        </div>
                                    </div>
                                    <table class="table mb-0 table-sm table-hover">
                                        <thead  class="thead-light">
                                            <tr style="height: 50px;">
                                                <th>
                                                    <input type="checkbox" id="vehicle1" class="btn-select-all"  name="vehicle1" value="Bike">
                                                    <label for="vehicle1">Check All</label>
                                                </th>
                                                <th>SL</th>
                                                <th>Date</th>
                                                <th>Truck</th>
                                                <th>Material</th>
                                                <th>Crusher/Site</th>
                                                <th>DSTN</th>
                                                <th>TKT Number</th>
                                                <th>WGT</th>
                                                <th>Rate</th>
                                                {{-- <th>Third Party</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody class="table-sm" id="truck_service_add">

                                        </tbody>
                                    </table>
                                    <p class="text-right"><button class="btn btn-info mt-1 mr-2" id="procced">Add To Invoice</button></p>
                                </div>
                            </div>
                        </div>
                    </section>
                {{-- </form> --}}
            </div>
          </div>
        </div>
    </div>
@endsection
@push('js')
<script>

    $(document).on("keyup", ".r-rate,.r-weight", function(){
        var tr =  $(this).closest('.t-row')
        var qty= parseFloat((tr.find('.r-weight').val()) || 0);
        var rate = parseFloat((tr.find('.r-rate').val()) || 0);
        var amount= parseFloat(qty*rate);
        tr.find('.r-amount').val(amount.toFixed(2));
        vat_discount_calculation(tr)
        total_toll(tr)
    });
    $(document).on("keyup", ".toll-amount", function(){

        var tr =  $(this).closest('.t-row')
        total_toll(tr)
    });
    $(document).on("change ", ".vat_rate", function(){
       var tr =  $(this).closest('.t-row')
       vat_discount_calculation(tr)
    });
    $(document).on("keyup ", ".r-discount", function(){
       var tr =  $(this).closest('.t-row')
       vat_discount_calculation(tr)
    });
    $(document).on("change", ".invoice_type", function(){
        var nvoice_type = $('.invoice_type').val();
        if (nvoice_type == 'INVOICE') {
        $('.vat_rate').each(function(){
            $(this).val(0).change();
        });
    } else {
        $('.vat_rate').each(function(){
            $(this).val(5).change();
        });
    }
    });
    // ************vat and discount calculation *****************************
    function vat_discount_calculation(tr){
        var nvoice_type = $('.invoice_type').val();
        var vat_rate = parseFloat(tr.find('.vat_rate').val() || 0);
        var taxable = parseFloat(tr.find('.r-amount').val() || 0);
        var discount = parseFloat(tr.find('.r-discount').val() || 0);
        var without_discount_taxable = parseFloat(taxable - discount);
        var vat_value = 0;
        if(nvoice_type == 'TAX INVOICE'){
            var vat_value = parseFloat((vat_rate*without_discount_taxable)/100);
            tr.find('.r-vat_amount').val(vat_value.toFixed(2));
        }else{
            tr.find('.r-vat_amount').val(vat_value.toFixed(2));
        }
        var total_amount = parseFloat(vat_value + taxable - discount);
        tr.find('.total-amount').val(total_amount.toFixed(2))
        total_calculation()    }
    // ************vat and discount calculation *****************************

    // ************ totla  calculation *****************************

    function total_toll(tr){
        var qty= parseFloat((tr.find('.toll-amount').val()) || 0);
        var rate = parseFloat((tr.find('.r-rate').val()) || 0 );
        var amount= parseFloat(qty);
        tr.find('.total-toll-amount').val(amount.toFixed(2));
        total_calculation()()
    }

    function total_calculation(){

        var total_vat = 0;
        var total_amount = 0;
        var total_discount = 0;
        var total_taxble = 0;
        var total_toll = 0;

        $('.r-vat_amount').each(function(index, element){
            total_vat += parseFloat($(element).val()) || 0;
        });
        $('.total-amount').each(function(index, element){
            total_amount += parseFloat($(element).val()) || 0;

        })
        $('.r-discount').each(function(index ,element){
            total_discount += parseFloat($(element).val()) || 0;
        })
        $('.r-amount').each(function(index ,element){
            total_taxble += parseFloat($(element).val()) || 0;

        })
        $('.total-toll-amount').each(function(index ,element){
            total_toll += parseFloat($(element).val()) || 0;
        })
        var  total_amount_with_toll = total_amount + total_toll;
        $('#total_vat_amount').val(total_vat.toFixed(2));
        $('#total_discount_amount').val(total_discount.toFixed(2));
        $('#total_taxable_amount').val(total_taxble.toFixed(2));
        $('#total_toll_fee_amount').val(total_toll.toFixed(2));
        $('#total_amount').val(total_amount_with_toll.toFixed(2));

    }

    $('.btn-select-all').click(function (event) {
        if (this.checked) {
            // Iterate each checkbox
            $(':checkbox').each(function () {
                this.checked = true;
            });
        } else {
            $(':checkbox').each(function () {
                this.checked = false;
            });
        }
    });
    var date_to = $('#date_to');
    var destination = $('#destination');
    var crusher = $('#crusher');

    var date_from = $('#date_from');
    var _token = $('input[name="_token"]').val();
    var customer_id = null;
    $('#customer_id').on('change', function() {
        customer_id = this.value;
        $("#customer_id_change").val(this.value);
        $('#truck_service_process').html('');
        if(customer_id){
            $.ajax({
                type: "post",
                url: "{{route('remove-truck_id-session')}}",
                data: {
                    customer_id:customer_id,
                    _token: _token,
                },
                success: function (response) {
                    $("#customer_id_change").val(response.id);
                    $(".customer_name_check").val(response.pi_name);
                    $(".customer_address_check").val(response.address);
                    $(".customer_phone_check").val(response.phone_no);
                    $(".customer_trn_check").val(response.trn_no);
                    console.log('session remove');
                }
            });
        }
    });
    $('#search').on('click', function(e){
        e.preventDefault();
        if(customer_id){
            var item_id = [];
            if ($('.selected_item_id').length > 0) {

                $('.selected_item_id').each(function(i, element) {
                    item_id.push($(element).val());
                });
            }

            $.ajax({
                type: "post",
                url: "{{route('truck-service-add')}}",
                data: {
                    customer_id:customer_id,
                    date_to: date_to.val(),
                    destination: destination.val(),
                    crusher: crusher.val(),
                    date_from: date_from.val(),
                    item_id:item_id,
                    _token: _token,
                },
                success: function (response) {
                    $('#truck_service_add').html(response);
                }
            });
        }else{
            alert("Please Select Customer Name");
        }
    });
    $(document).ready(function() {
    $("#procced").on('click', function(e){
        e.preventDefault();

        var records = [];
        $('.item_show_ids:checkbox:checked').each(function(i, element) {
            records.push($(element).val());
        });

        var customer_id = $('#customer_id').val(); // Assuming you get customer_id from an input field with id customer_id
        var date_to = $('#date_to'); // Assuming date_to is an input field
        var date_from = $('#date_from'); // Assuming date_from is an input field
        var _token = $('meta[name="csrf-token"]').attr('content'); // Assuming CSRF token is in a meta tag

        if(customer_id) {
            $.ajax({
                type: "post",
                url: "{{ route('truck-service-process') }}",
                data: {
                    customer_id: customer_id,
                    records: records,
                    date_to: date_to.val(),
                    date_from: date_from.val(),
                    _token: _token,
                },
                success: function(response) {
                    $('#newServiceAdd').modal('hide');
                    $('#truck_service_add').html('');
                    $('#truck_service_process').append(response);
                    var v_rate = $('#v_rate').val();
                    var invoice_type = $('.invoice_type').val('TAX INVOICE').change();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        } else {
            console.error('Customer ID is required.');
        }
    });
});

    $('#payment_amount').keyup(function(){
        var payment_amount= $(this).val();
        var total_amount= $('#total_amount').val();
        var due_amount= total_amount-payment_amount;
        due_amount= Math.round(due_amount * 100)/100;
        $('#due_amount').val(due_amount);
    });
    $(document).one("submit", "#invoice-form", function(e){
        e.preventDefault();
        var pay_mode= $('#pay_mode').val();
        var payment_amount= $('#payment_amount').val();
        var total_amount= $('#total_amount').val();
        if((pay_mode=='Cash' || pay_mode=='Card') && payment_amount==0){
            alert('Payment amount can not be zero (0) when payment mode is Cash or Card!');
        }else if(total_amount==payment_amount && pay_mode=='Credit'){
            alert('Payment mode can not be Credit when it is fully paid.');
        }else{
            $(this).submit();
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
                    var dateAr = response.split('-');
                    var newDate = dateAr[2] + '/' + dateAr[1] + '/' + dateAr[0];
                    $("#due_date").val(newDate);
                }
            })
        }
    });
    $(document).on('click', '.row-delete', function(e){
        if(confirm('Are You Sure!!')){
            $(this).closest('tr').remove();
        } else {
            return false;
        }
    });
    $(document).on('keyup', '#invoice_no', function(){
        // $('#invoice_id').keyup(function() {
        var invoice_no = $(this).val();
        document.getElementById("submit_button").disabled = false;

    })


    $(document).on('change', '#invoice_no', function(){
        // $('#invoice_id').keyup(function() {
        var invoice_no = $(this).val();
        $.ajax({
            type: "post",
            url: "{{route('check-invoice-no')}}",
            data: {
                invoice_no:invoice_no,
                _token: _token,
            },
            success: function (response) {
                if(response){
                    toastr.warning(response,"Warning");
                    document.getElementById("submit_button").disabled = true;
                }
                else{
                    document.getElementById("submit_button").disabled = false;
                }
            }
        });
    })
</script>
@endpush
