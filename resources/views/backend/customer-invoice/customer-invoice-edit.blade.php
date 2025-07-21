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
                            <h4 class="flex-grow-1">Invoice Edit</h4>
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
                        <form action="{{ route('update-customer-invoice')}}" id="invoice-form" method="POST">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="customer_id" value="{{$invoice->customer_id}}" id="customer_id_change">
                                <input type="hidden" name="invoice_id" value="{{$invoice->id}}" id="customer_id_change">

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Project Name <span> <input type="checkbox"  @if($invoice->column_show->customer_name_check == 1)
                                            checked @endif name="project_check" value="1"></span></label>
                                        <select name="project" class="inputFieldHeight form-control project common-select2">
                                            @foreach ($projects as $project)
                                                <option value="{{$project->id}}" {{$project->id == $invoice->proj_name ? 'selected':''}}>{{ $project->proj_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Customer Name <span> <input type="checkbox"
                                            @if($invoice->column_show->customer_name_check == 1)
                                            checked @endif name="customer_name_check" value="1"></span></label>
                                        <input type="text" value="{{$invoice->customer? $invoice->customer->pi_name:''}}" readonly class="inputFieldHeight customer_name_check form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Address Name <span> <input type="checkbox"  @if($invoice->column_show->customer_address_check == 1)
                                            checked @endif name="customer_address_check" value="1"></span></label>
                                        <input type="text" readonly value="{{$invoice->customer? $invoice->customer->address:''}}"  class="inputFieldHeight customer_address_check form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Phone Number <span> <input type="checkbox"  @if($invoice->column_show->customer_phone_check == 1)
                                            checked @endif name="customer_phone_check" value="1"></span></label>
                                        <input type="text" value="{{$invoice->customer? $invoice->customer->phone_no:''}}"  readonly class="inputFieldHeight customer_phone_check form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">TRN Number <span> <input type="checkbox"  @if($invoice->column_show->customer_trn_check == 1)
                                            checked @endif name="customer_trn_check" value="1"></span></label>
                                        <input type="text"value="{{$invoice->customer? $invoice->customer->trn_no:''}}"  readonly class="inputFieldHeight customer_trn_check form-control">
                                    </div>
                                </div>
                                {{-- <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Cost Center </label></label>
                                        <select name="cost_center" class="inputFieldHeight form-control cost_center common-select2">
                                            @foreach ($cost_centers as $cost_center)
                                                <option value="{{$cost_center->id}}"{{$cost_center->id == $invoice->cost_center_id ? 'selected':''}}>{{ $cost_center->cc_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> --}}
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Payment Mode</label>
                                        <select name="pay_mode" id="pay_mode" class="inputFieldHeight pay_mode form-control common-select2">
                                            @foreach ($pay_modes as $pay_mode)
                                                <option value="{{$pay_mode->title}}" {{$pay_mode->title == $invoice->pay_mode ? 'selected':''}}>{{ $pay_mode->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Date <span> <input type="checkbox"  @if($invoice->column_show->date_check == 1)
                                            checked @endif name="date_check" value="1"></span></label>
                                        <input type="text"  id="date" autocomplete="off" value="{{date('d/m/Y',strtotime($invoice->date))}}" placeholder="dd/mm/yyyy" class="inputFieldHeight date form-control" name="date" required>
                                    </div>
                                </div>
                                {{-- <div class="col-sm-3 form-group pay-term">
                                    <label for="">Payment Terms </label>
                                    <select name="pay_terms" id="pay_terms" class="common-select2 pay_terms" style="width: 100% !important"
                                        required>
                                        <option value="">Select...</option>
                                        @foreach ($terms as $item)
                                            <option value="{{ $item->value }}" {{ $item->value == $invoice->pay_terms? 'selected':'' }}>{{ $item->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-3 form-group">
                                    <label for="">Due Date </label>
                                    <input type="text" class="form-control due_date inputFieldHeight" name="due_date"
                                        id="due_date" value="{{ date('d/m/Y',strtotime($invoice->due_date)) }}" readonly>
                                </div> --}}
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">LPO Number <span> <input type="checkbox"  @if($invoice->column_show->lpo_check == 1)
                                            checked @endif name="lpo_check" value="1"></span></label>
                                        <input type="text" value="{{ $invoice->lpo_number }}"  class="inputFieldHeight lpo_number form-control" name="lpo_number" >
                                    </div>
                                </div>
                                {{-- <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">DO. NO <span> <input type="checkbox"  @if($invoice->column_show->do_check == 1)
                                            checked @endif name="do_check" value="1"></span></label>
                                        <input type="text" value="{{ $invoice->do_no }}" class="inputFieldHeight lpo_number form-control" name="do_number" required>
                                    </div>
                                </div> --}}
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Invoice Type</label>
                                        <select name="invoice_type"  class="common-select2 invoice_type" style="width: 100% !important" required>
                                            <option value="TAX INVOICE" {{$invoice->invoice_type == 'TAX INVOICE' ? 'selected':''}}>TAX INVOICE</option>
                                            <option value="INVOICE" {{$invoice->invoice_type == 'INVOICE' ? 'selected':''}}>INVOICE</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Month <span> <input type="checkbox" name="month_check" value="1" {{$invoice->column_show->month==1?'checked':''}} ></span></label>
                                        <input type="month" class="inputFieldHeight form-control" name="month" value="{{$invoice->month?date('Y-m', strtotime($invoice->month)):null}}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Pay Term <small>(Days)</small> <span> <input type="checkbox" {{$invoice->column_show->pay_term==1?'checked':''}} name="pay_term_check" value="1"></span></label>
                                        <input type="number"  class="inputFieldHeight pay_term form-control" name="pay_term" value="{{$invoice->pay_term}}" >
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table mb-0 table-sm table-hover table-bordered" id="invoiceTable">
                                    <thead class="thead-light">
                                        <tr style="height: 25px;">
                                            <th>SL No.</th>
                                            <th>Date <span> <input type="checkbox" @if($invoice->column_show->item_date_check == 1)
                                            checked @endif name="item_date_check" value="1"></span></th>

                                            <th>Truck <span> <input type="checkbox" @if($invoice->column_show->truck_check == 1)
                                            checked @endif name="truck_check" value="1"></span></th>

                                            <th>Material <span> <input type="checkbox" @if($invoice->column_show->material_check == 1)
                                            checked @endif name="material_check" value="1"></span></th>

                                            <th>Crusher <span> <input type="checkbox" @if($invoice->column_show->cursher_check == 1)
                                            checked @endif name="cursher_check" value="1"></span></th>

                                            <th>DSTN <span> <input type="checkbox" @if($invoice->column_show->dstn_e_check == 1)
                                            checked @endif name="dstn_e_check" value="1"></span></th>

                                            <th>DO. NO <span> <input type="checkbox" @if($invoice->column_show->serial_check == 1)
                                            checked @endif name="serial_check" value="1"></span></th>

                                            <th>TKT Number <span> <input type="checkbox" @if($invoice->column_show->tkt_number == 1)
                                                checked @endif name="tkt_number" value="1"></span></th>

                                            {{-- <th>Third Party <span> <input type="checkbox" @if($invoice->column_show->third_party_check == 1)
                                            checked @endif name="third_party_check" value="1"></span></th> --}}

                                            <th>WGT <span> <input type="checkbox" @if($invoice->column_show->wgt_check == 1)
                                            checked @endif name="wgt_check" value="1"></span></th>

                                            <th>Rate <span> <input type="checkbox" @if($invoice->column_show->rate_check == 1)
                                            checked @endif name="rate_check" value="1"></span></th>

                                            <th>Amount <span> <input type="checkbox" @if($invoice->column_show->amount_check == 1)
                                            checked @endif name="amount_check" value="1"></span></th>

                                            <th>VAT Rate <span> <input type="checkbox" @if($invoice->column_show->vat_rate_check == 1)
                                            checked @endif name="vat_rate_check" value="1"></span></th>

                                            <th>Discount <span> <input type="checkbox" @if($invoice->column_show->discount_check == 1)
                                            checked @endif name="discount_check" value="1"></span></th>

                                            <th>VAT Amount <span> <input type="checkbox" @if($invoice->column_show->vat_amount_check == 1)
                                            checked @endif name="vat_amount_check" value="1"></span></th>

                                            <th>Total Amount <span> <input type="checkbox" @if($invoice->column_show->tatl_amount_check == 1)
                                            checked @endif name="tatl_amount_check" value="1"></span></th>

                                            <th>Toll Fee <span> <input type="checkbox" @if($invoice->column_show->toll_check == 1)
                                            checked @endif name="toll_check" value="1"></span></th>

                                            <th class="d-none">Total Toll Fee <span> <input type="checkbox" @if($invoice->column_show->total_toll_check == 1)
                                            checked @endif name="total_toll_check" value="1"></span></th>
                                            <th style="width:40px !important;text-align:center">Action</th>

                                        </tr>
                                    </thead>
                                    <tbody id="truck_service_process" class="table-sm">
                                        @foreach ($invoice->items as $t_record)
                                            <tr class="trFontSize t-row">
                                                <td >{{ $loop->index+1 }}</td>
                                                <td>
                                                    <input type="text" class="r-material" placeholder="material" readonly  name="item_date[]"  value="{{date('d/m/Y',strtotime($t_record->date))}}">
                                                </td>

                                                <td>
                                                    <input type="text" class="r-is" readonly  value="{{$t_record->truck?$t_record->truck->vehicle_number:""}}">
                                                    <input type="hidden" class="r-is"  name="item_ids[]" readonly value="{{$t_record->item_id}}">
                                                </td>
                                                <td>
                                                    <input type="text" class="r-material"  placeholder="material" readonly  value="{{$t_record->record?$t_record->record->material:""}}">
                                                </td>
                                                <td>
                                                    <input type="text" class="crusher"  placeholder="crusher" readonly value="{{$t_record->crusher}}" >
                                                </td>
                                                <td>
                                                    <input type="text" class="r-destination"  placeholder="destination" readonly  value="{{$t_record->destination}}">
                                                </td>
                                                <td>
                                                    <input type="text" class="serial_no"  placeholder="DO. NO" value="{{$t_record->record?$t_record->record->serial_no:""}}" >
                                                </td>
                                                <td>
                                                    <input type="text" class="tkt_number"  placeholder="TKT Number" value="{{$t_record->record?$t_record->record->tkt_number:""}}" >
                                                </td>
                                                {{-- <td>
                                                    <input type="text" class="r-trasporter" placeholder="trasporter" readonly  value="{{$t_record->trasporter}}">
                                                </td> --}}
                                                <td>
                                                    <input type="text" class="r-weight" name="weight[]" placeholder="weight" value="{{$t_record->qty}}" >
                                                </td>
                                                {{-- <td>
                                                    <input type="text" name="" value="{{$t_record->total_weight}}" class="r-weight">
                                                </td> --}}
                                                <td>
                                                    <input type="text" class="r-rate" name="rate[]" placeholder="Rate" required value="{{$t_record->rate}}">
                                                </td>

                                                <td>
                                                    <input type="text" class="r-amount" name="amount[]" placeholder="Amount" readonly  value="{{$t_record->amount}}">
                                                </td>
                                                <td>
                                                    <select name="vat_rate[]" class="inputFieldHeight form-control vat_rate common-select2">
                                                        @foreach ($vats as $vat)
                                                            <option value="{{$vat->value}}"{{$t_record->vat_rate == $vat->value ? 'selected':''}} >{{ $vat->value}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="r-discount" name="discount[]" value="{{$t_record->discount}}" placeholder="discount"  >
                                                </td>
                                                <td>
                                                    <input type="text" class="r-vat_amount" name="vat_amount[]" placeholder="VAT Amount" readonly  value="{{$t_record->vat_amount}}">
                                                </td>

                                                <td>
                                                    <input type="text" class="total-amount" placeholder="Total Amount" name="total_amount[]" readonly  value="{{$t_record->rate*$t_record->qty}}">
                                                </td>
                                                <td class="d-none">
                                                    <input type="text" class="toll-amount" name="toll_fee[]" value="{{$t_record->toll_fee}}" placeholder="Toll fees" >
                                                </td>
                                                <td>
                                                    <input type="text" class="total-toll-amount" name="total_toll_fee[]" value="{{$t_record->toll_fee}}" placeholder="Total Toll fees"  readonly>
                                                </td>
                                                <td class="text-center">
                                                    <button class="btn btn-sm btn-danger row-delete"> <span>DEL</span></button>
                                                 </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                    <tbody class="table-sm">

                                        <tr class="trFontSize">
                                            <td class="colspan"  align="right">Total Taxable Amount</td>
                                            <td><input type="text"  style="max-width: 70px;"name="total_taxable_amount" value="{{$invoice->amount}}" required id="total_taxable_amount" readonly></td>
                                        </tr>
                                        <tr class="trFontSize">
                                            <td class="colspan" align="right">Total Discount Amount</td>
                                            <td><input type="text"  style="max-width: 70px;"name="total_discount_amount" value="{{$invoice->discount_amount}}" id="total_discount_amount" readonly></td>
                                        </tr>
                                        <tr class="trFontSize">
                                            <td class="colspan" align="right">Total VAT Amount</td>
                                            <td><input type="text"  style="max-width: 70px;"name="total_vat_amount" value="{{$invoice->vat_amount}}" id="total_vat_amount" readonly></td>
                                        </tr>

                                        <tr class="trFontSize">
                                            <td class="colspan" align="right">Total Toll Fee Amount</td>
                                            <td><input type="text"  style="max-width: 70px;"name="total_toll_fee_amount" value="{{$invoice->total_toll_fee}}" id="total_toll_fee_amount" readonly></td>
                                        </tr>
                                        <tr class="trFontSize">
                                            <td class="colspan" align="right">Total Amount</td>
                                            <td><input type="text"  style="max-width: 70px;"name="total_amount_sum" value="{{$invoice->total_amount}}" id="total_amount" required readonly></td>
                                        </tr>
                                        <tr class="trFontSize">
                                            <td class="colspan" align="right">Payment Applied</td>
                                            <td><input type="decimal" style="max-width: 70px;" value="{{$invoice->paid_amount}}" name="payment_amount" id="payment_amount" required></td>
                                        </tr>
                                        <tr class="trFontSize">
                                            <td class="colspan" align="right">Balance Due</td>
                                            <td><input type="text"  style="max-width: 70px;"name="due_amount" value="{{$invoice->due_amount}}" id="due_amount" readonly></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <p class="text-right"><button class="btn btn-info mt-1" type="submit">Procced</button></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
{{-- modal --}}

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
                                            <button class="btn btn-light mt-2 float-right" style="35px" id="search">Search</button>
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
    
    $(document).on('input', '.r-rate', function () {
        // Get the current row
        let $currentRow = $(this).closest('tr');
        // Extract the crusher and destination values from the current row
        let crusher = $currentRow.find('.crusher').val();
        let destination = $currentRow.find('.r-destination').val();
        // Get the new rate value entered
        let newRate = parseFloat($(this).val());
        // Loop through all rows
        $('.t-row').each(function () {
            let tr = $(this).closest('.t-row');
            let $row = $(this);
            let rowCrusher = $row.find('.crusher').val();
            let rowDestination = $row.find('.r-destination').val();
            // If crusher and destination match, update the rate and recalculate amount
            if (crusher === rowCrusher && destination === rowDestination) {
                let weight = parseFloat($row.find('.r-weight').val());
                if (!isNaN(newRate) && !isNaN(weight)) {
                    let amount = (newRate * weight).toFixed(2);
                    $row.find('.r-rate').val(newRate);
                    $row.find('.r-amount').val(amount);
                }
            }
            vat_discount_calculation(tr)
            total_toll(tr)
        });
    });
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
        total_calculation()
    }
    $(document).on('click', '.row-delete', function(e){
        if(confirm('Are You Sure!!')){
            $(this).closest('tr').remove();
            total_calculation()
        } else {
            return false;
        }
    });
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
    var date_from = $('#date_from');
    var destination = $('#destination');
    var crusher = $('#crusher');
    var _token = $('input[name="_token"]').val();
    var customer_id = $("#customer_id_change").val();


    $('#search').on('click', function(e){
        e.preventDefault();
        if(customer_id){
            $.ajax({
                type: "post",
                url: "{{route('truck-service-add')}}",
                data: {
                    customer_id:customer_id,
                    date_to: date_to.val(),
                    date_from: date_from.val(),
                    destination: destination.val(),
                    crusher: crusher.val(),
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
    $("#procced").on('click', function(e){
        e.preventDefault();
        var records = [];
        $('.item_show_ids:checkbox:checked').each(function(i, element){
            records.push($(element).val());
        });
        if(customer_id){
            $.ajax({
                type: "post",
                url: "{{route('truck-service-process')}}",
                data: {
                    customer_id:customer_id,
                    records:records,
                    date_to: date_to.val(),
                    date_from: date_from.val(),
                    _token: _token,
                },
                success: function (response) {
                    $('#newServiceAdd').modal('hide');

                   // $('#truck_service_add').html('');
                    $('#truck_service_process').append(response);
                    // var v_rate= $('#v_rate').val();
                    // var nvoice_type = $('.invoice_type').val('TAX INVOICE').change();
                    // $(':checkbox').each(function () {
                    //     this.checked = false;
                    // });
                    // total_calculation()
                    var nvoice_type = $('.invoice_type').val();
                    var nvoice_type = $('.invoice_type').val(nvoice_type).change();

                }
            });
        }
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

    $(document).ready(function() {
        var $table = $('#invoiceTable');
        var totalColumns = $table.find('tr').first().children('th').length;

        $table.find('.colspan').each(function() {
            var $row = $(this);
            $row.attr('colspan', totalColumns - 2);
        });
    });
</script>
@endpush
