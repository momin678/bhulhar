@extends('layouts.backend.app')
@section('content')
@include('layouts.backend.partial.style')
<style>
    .table td{
        border-bottom: none;
    }
    .commonSelect2Style span{
        width: 100% !important;
    }
    .select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b{
        display: none;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow b{
        display: none;
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
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <div class="card cardStyleChange">
                    <div class="row" id="table-bordered">
                        <div class="col-12">
                            <div class="cardStyleChange p-2">
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
                                <form action="{{ route('decline-customer-invoice-update', $invoice->id)}}" id="invoice-form" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Customer Name</label>
                                                <select name="customer_id" class="inputFieldHeight form-control common-select2">
                                                    <option value="">Select Name</option>
                                                    @foreach ($customers as $customer)
                                                    <option value="{{$customer->id}}" {{$invoice->customer_id==$customer->id? "selected":""}} >{{ $customer->pi_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Project Name</label>
                                                <select name="project" class="inputFieldHeight form-control common-select2">
                                                    @foreach ($projects as $project)
                                                        <option value="{{$project->id}}" {{$invoice->project_id==$project->id? "selected":""}}>{{ $project->proj_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Cost Center</label>
                                                <select name="cost_center" class="inputFieldHeight form-control common-select2">
                                                    @foreach ($cost_centers as $cost_center)
                                                        <option value="{{$cost_center->id}}" {{$invoice->cost_center_id==$cost_center->id? "selected":""}}>{{ $cost_center->cc_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Payment Mode</label>
                                                <select name="pay_mode" id="pay_mode" class="inputFieldHeight form-control common-select2">
                                                    @foreach ($pay_modes as $pay_mode)
                                                        <option value="{{$pay_mode->title}}" {{$invoice->pay_mode==$pay_mode->title? "selected":""}}>{{ $pay_mode->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Date</label>
                                                <input type="date" class="inputFieldHeight form-control" name="date" required value="{{$invoice->date}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        @isset($records)
                                        <table class="table mb-0 table-sm table-hover">
                                            <thead  class="thead-light">
                                                <tr style="height: 50px;">
                                                    <th>SL No.</th>
                                                    <th>Description</th>
                                                    <th>WGT</th>
                                                    <th>Rate</th>
                                                    <th>Amount</th>
                                                    <th>Toll Fee</th>
                                                    <th>Total Toll Fee</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-sm">
                                                @foreach ($invoice_items as $t_record)
                                                    <tr class="trFontSize t-row">
                                                        <td>{{ $loop->index+1 }}</td>
                                                        <td>From {{$t_record->crusher}} To {{$t_record->destination}}<span> ({{$t_record->total_trip}}) </span></td>
                                                        <input type="hidden" name="crushers[]" value="{{$t_record->crusher}}">
                                                        <input type="hidden" name="destinations[]" value="{{$t_record->destination}}">
                                                        <input type="hidden" name="" value="{{$t_record->total_trip}}" class="trip">
                                                        <input type="hidden" name="date_from[]" value="" class="">
                                                        <input type="hidden" name="date_to[]" value="" class="">
                                                        <td>{{$t_record->total_weight}}
                                                            <input type="hidden" name="" value="{{$t_record->total_weight}}" class="r-weight">
                                                        </td>
                                                        <td><input type="text" class="r-rate" name="rate[]" placeholder="Rate" required value="{{$t_record->rate}}"></td>
                                                        <td><input type="text" class="r-amount" placeholder="Amount" readonly style="max-width: 100px;" value="{{$t_record->rate * $t_record->total_qty}}"></td>
                                                        <td><input type="text" class="toll-amount" name="toll_fee[]" placeholder="Toll fees" style="max-width: 100px;" value="{{$t_record->toll_fee}}"></td>
                                                        <td><input type="text" class="total-toll-amount" placeholder="Total Toll fees" style="max-width: 100px;" readonly value="{{$t_record->total_trip * $t_record->toll_fee}}"></td>
                                                    </tr>
                                                @endforeach
                                                @foreach ($temp_records as $item)
                                                    <input type="hidden" name="truck_ids[]" value="{{$item->truck_id}}">
                                                @endforeach
                                            </tbody>
                                            <tbody id="truck_service_process" class="table-sm">
                                                
                                            </tbody>
                                            <tbody class="table-sm">
                                                <tr class="trFontSize">
                                                    <td colspan="6" align="right">Vat Rate</td>
                                                    <td><input type="text"  style="max-width: 100px;"name="v_rate" id="v_rate" value="5"></td>
                                                </tr>
                                                <tr class="trFontSize">
                                                    <td colspan="6" align="right">Total Vat</td>
                                                    <td><input type="text"  style="max-width: 100px;"name="total_vat" id="total_vat" readonly value="{{$invoice->vat_amount}}"></td>
                                                </tr>
                                                <tr class="trFontSize">
                                                    <td colspan="6" align="right">Total</td>
                                                    <td><input type="text"  style="max-width: 100px;"name="total_amount" id="total_amount" readonly value="{{$invoice->amount}}"></td>
                                                </tr>
                                                <tr class="trFontSize">
                                                    <td colspan="6" align="right">Payment Applied</td>
                                                    <td><input type="decimal" style="max-width: 100px;" name="payment_amount" id="payment_amount" required value="{{$invoice->paid_amount}}"></td>
                                                </tr>
                                                <tr class="trFontSize">
                                                    <td colspan="6" align="right">Balance Due</td>
                                                    <td><input type="text"  style="max-width: 100px;"name="due_amount" id="due_amount" readonly value="{{$invoice->due_amount}}"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <p class="text-right">
                                            <a href="{{ route('draft-invoice-list') }}" class="btn mt-1 mr-1 btn-primary">Back</a>
                                            <button class="btn btn-info mt-1" type="submit">Procced</button>
                                        </p>
                                        
                                        @endisset
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
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
                                        <div class="col-md-4">
                                            <label>Customer Name</label>
                                            <select name="customer_id" class="inputFieldHeight form-control common-select2" id="customer_id">
                                                <option value="">Select Name</option>
                                                @foreach ($customers as $customer)
                                                <option value="{{$customer->id}}" {{$invoice->customer_id==$customer->id? "selected":""}}>{{ $customer->pi_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Date From</label>
                                                <input type="date" class="inputFieldHeight form-control" name="date_from" id="date_from">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Date To</label>
                                                <input type="date" class="inputFieldHeight form-control" name="date_to" id="date_to">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <button class="btn btn-light mt-1 float-right" id="search">Search</button>
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
                                                <th>Serial</th>
                                                <th>WGT</th>
                                                <th>Third Party</th>
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

    $(document).on("keyup", ".r-rate", function(){
        var qty= ($(this).closest('.t-row').find('.r-weight').val());
        // var v_rate= ($(this).closest('.t-row').find('.v-rate').val());
        var v_rate= $('#v_rate').val();
        var rate= ($(this).val());
        var amount= qty*rate;
        $(this).closest('.t-row').find('.r-amount').val(amount.toFixed(2));
        total_vat(v_rate);
    });
    $(document).on("keyup", ".toll-amount", function(){
        var qty= ($(this).closest('.t-row').find('.trip').val());
        // var v_rate= ($(this).closest('.t-row').find('.v-rate').val());
        var v_rate= $('#v_rate').val();
        var rate= ($(this).val());
        var amount= qty*rate;
        $(this).closest('.t-row').find('.total-toll-amount').val(amount.toFixed(2));
        total_vat(v_rate);
    });

    function total_vat(vat_rate){
        var total_toll_fees = 0;
        $('.total-toll-amount').each(function() {
            var this_amount= $(this).val();
            this_amount = (this_amount === '') ? 0 : this_amount;
            this_amount= parseFloat(this_amount);
            total_toll_fees = total_toll_fees+this_amount;
        });
        var total_amount=0;
        $('.r-amount').each(function() {                    
            var this_amount= $(this).val();
            this_amount = (this_amount === '') ? 0 : this_amount;
            this_amount= parseFloat(this_amount);
            total_amount = total_amount+this_amount;
        });
        var total_vat= total_amount * vat_rate / 100;
        total_vat= Math.round(total_vat*100)/100;
        total_amount= Math.round(total_amount * 100)/100;
        total_amount= total_amount+total_vat+total_toll_fees;
        total_amount= Math.round(total_amount * 100)/100;
        $('#total_vat').val(total_vat);
        $('#total_amount').val(total_amount);
    }

    $('#payment_amount').keyup(function(){
        var payment_amount= $(this).val();
        var total_amount= $('#total_amount').val();
        var due_amount= total_amount-payment_amount;
        due_amount= Math.round(due_amount * 100)/100;
        $('#due_amount').val(due_amount);
    });
    var date_to = $('#date_to');
    var date_from = $('#date_from');
    var _token = $('input[name="_token"]').val();
    var customer_id = $("#customer_id").val();
    $('#search').on('click', function(e){
        e.preventDefault();
        if(customer_id){
            $.ajax({
                type: "post",
                url: "{{route('truck-service-add')}}",
                data: {
                    'customer_id':customer_id,
                    'date_to': date_to.val(),
                    'date_from': date_from.val(),
                    '_token': _token,
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
        $(':checkbox:checked').each(function(i){
            records[i] = $(this).val();
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
                    $('#truck_service_add').html('');
                    $('#truck_service_process').append(response);
                    $(':checkbox').each(function () {
                        this.checked = false;
                    });
                }
            });
        }
    });




</script>
@endpush
