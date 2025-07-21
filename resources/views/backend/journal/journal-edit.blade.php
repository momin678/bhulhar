@extends('layouts.backend.app')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
@section('content')
@include('layouts.backend.partial.style')
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
    height: 15px !important;
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
    padding-top: 0rem;
    padding-bottom: 0rem;

    padding-left: 1.7rem;
    padding-right: 1.7rem;

}
</style>
<div class="app-content content print-hideen">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            @include('clientReport.accounting._header', ['activeMenu' =>'jouranal-creation'])
            <div class="tab-content bg-white">
                <div id="journalList" class="tab-pane active p-2">
                    <input type="hidden" name="standard_vat_rate" value="{{$standard_vat_rate}}"  id="standard_vat_rate">
                    <section id="widgets-Statistics">
                        @isset($journalF)
                        <form action="{{ route('journalEntryEditPost', $journalF) }}" method="POST" enctype="multipart/form-data">
                        @else
                            <form action="{{ route('journalEntryPost') }}" method="POST" enctype="multipart/form-data" >
                            @endisset

                            @csrf
                            <div class="cardStyleChange bg-white">
                                <div class="card-body mt-1">
                                    <div class="row mt-1 d-flex justify-content-center" style="">
                                        <div class="col-md-3 changeColStyle  col-right-padding">
                                            <label for="project">Transection Types</label>
                                            <select name="transection_type" class="common-select2 w-100" id="transection_type" required>
                                               <option value="{{$journalF->transection_type}}">{{$journalF->transection_type}}</option>

                                            </select>
                                            @error('project')
                                                <div class="btn btn-sm btn-danger">{{ $message }}
                                                </div>
                                            @enderror

                                        </div>
                                        <div class="col-md-3 form-group d-none col-right-padding">
                                                    <label for="">Journal Entry No</label>
                                                    <input type="text" class="form-control" id="journal_no"
                                                        value="{{ isset($journalF) ? $journalF->journal_no : "$journal_no" }}"
                                                        name="journal_no" placeholder="Journal Entry No" readonly>
                                                    @error('journal_no')
                                                        <div class="btn btn-sm btn-danger">{{ $message }}
                                                        </div>
                                                    @enderror
                                        </div>
                                        <div class="col-md-3 changeColStyle  col-right-padding">
                                                        <label for="project">Branch</label>
                                                        <select name="project" class="common-select2 w-100" id="project" required>
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
                                        <div class="col-md-3 changeColStyle  ">
                                                        <label for="">Party Code</label>
                                                        <input type="text" name="pi_code" id="pi_code" value="{{$journalF->partyInfo->pi_code}}" class="form-control inputFieldHeight" required placeholder="Party Code">
                                                        @error('party_info')
                                                            <div class="btn btn-sm btn-danger">{{ $message }}
                                                            </div>
                                                        @enderror

                                        </div>
                                        <div class="col-md-3 changeColStyle search-item-pi col-right-padding ">
                                                   <div class="row d-flex align-items-end">
                                                    <div class="col-10 col-right-padding">
                                                                <label for="">Party Name</label>
                                                                <select name="party_info" id="party_info"
                                                                class="common-select2 party-info customer" style="width: 100% !important" data-target="" required>
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
                                                        <a href="#" data-toggle="modal" data-target="#customerModal"><img src="{{asset('assets/backend/app-assets/icon/add-icon.png')}}" alt="" srcset="" class="img-fluid" style="height:29px" ></a>

                                                    </div>
                                                   </div>
                                        </div>

                                        <div class="col-md-3 changeColStyle col-right-padding ">
                                                            <label for="">@if(!empty($currency->licence_name)){{$currency->licence_name}} @endif</label>
                                                            <input type="text" class="form-control inputFieldHeight"
                                                            value="{{ isset($journalF) ? $journalF->partyInfo->trn_no : '' }}"
                                                            name="trn_no" id="trn_no" class="form-control" readonly>
                                                        @error('trn_no')
                                                            <div class="btn btn-sm btn-danger">{{ $message }}
                                                            </div>
                                                        @enderror
                                        </div>
                                        <div class="col-md-3 changeColStyle col-right-padding ">
                                                            <label for="">Payment Mode</label>
                                                            <select name="pay_mode" id="pay_mode" class="form-control inputFieldHeight" required>
                                                                <option value="">Select...</option>

                                                                @foreach ($modes as $item)
                                                                    <option value="{{ $item->title }}"
                                                                        {{ isset($journalF) ? ($journalF->pay_mode == $item->title ? 'selected' : '') : '' }}>
                                                                        {{ $item->title }}</option>
                                                                @endforeach
                                                                <option value="NonCash">Special Transaction</option>

                                                            </select>
                                                            @error('pay_mode')
                                                                <div class="btn btn-sm btn-danger">{{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                        <div class="col-md-3">
                                                    <div class="row">
                                                     <div class="col-md-6 transaction_type">
                                                                 <label for="">Type</label>
                                                                 <select name="transaction_type" id="transaction_type" class="common-select2 inputFieldHeight" style="width: 100% !important"
                                                                 required>
                                                                 <option value="Increase" {{$journalF->transaction_type=='Increase'?'selected':''}}>General</option>
                                                                 <option value="Decrease" {{$journalF->transaction_type=='Decrease'?'selected':''}}>Adjustment</option>
                                                             </select>
                                                             @error('transaction_type')
                                                                 <div class="btn btn-sm btn-danger">{{ $message }}
                                                                 </div>
                                                             @enderror
                                                     </div>

                                                     <div class="col-md-6 changeColStyle" id="printarea">
                                                                 <label for="">Date</label>
                                                                 <input type="text" value="{{ date('d/m/Y', strtotime($journalF->date)) }}" class="form-control inputFieldHeight datepicker" name="date"  placeholder="dd/mm/yyyy" >
                                                                 @error('date')
                                                                     <div class="btn btn-sm btn-danger">{{ $message }}
                                                                     </div>
                                                                 @enderror
                                                     </div>
                                                    </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="row">
                                                <div class="col-md-12 form-group non-cash-account-head" style="display: {{ isset($journalF) ? ($journalF->txn_mode == "Credit" ? '' : 'none') : 'none' }}">
                                                    <label for="">Account Head</label>
                                                    <select name="acc_head_2" id="acc_head_2" class="common-select2" style="width: 100% !important"
                                                        >
                                                        <option value="">Select...</option>
                                                        @foreach ($acHeads as $item)
                                                            <option value="{{ $item->id }}"
                                                                {{ isset($journalF) ? ($journalF->ac_head_id == $item->id ? 'selected' : '') : '' }}>
                                                                {{ $item->fld_ac_code }} - {{ $item->fld_ac_head }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row my-1">
                                    <div class="cardStyleChange " style="width: 100%">
                                        <div class="card-body bg-white " style="padding: 0px !important;">
                                            <table class="table table-bordered table-sm mb-0">
                                                <thead>
                                                    <tr >
                                                        <th>#</th>
                                                        <th  style="width: 19%">A/C Head</th>
                                                        <th style="width: 19%">Invoice Number</th>
                                                        <th style="width: 19%">Total Amount</th>
                                                        <th  style="width: 19%"  >@if(!empty($currency->vat_name)){{$currency->vat_name}} @endif Subtotal</th>
                                                        <th  style="width: 19%">@if(!empty($currency->vat_name)){{$currency->vat_name}} @endif</th>
                                                        <th  class="NoPrint"> <button type="button" class="btn btn-sm btn-success "style="border: 1px solid #fff;
                                                            color: #fff; border-radius: 10px;padding: 5px; margin: 4px;" onclick="BtnAdd()">ADD</button>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                @php
                                                    $nums_record= $journalF->records->count();
                                                    $index=0;
                                                @endphp
                                                <tbody id="TBody">
                                                    @foreach($journalF->records->where('is_main_head',1) as $item)
                                                    <tr id="TRow" >
                                                        <td class="text-center">
                                                            <span class="item_input_text">
                                                                <small class="change-input item_input_field">
                                                                    <i class="bx bx-plus"></i>
                                                                </small>
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex justy-content-between align-items-center w-100">
                                                                <span class="item_change_input_option w-100">
                                                                    <select name="multi_acc_head[]"onchange="option(this);"  class="job_group_id form-control transection-heads multi-acc-head input-due-payment inputFieldHeight2" style="width: 100%;    HEIGHT: 36PX;" required>
                                                                        <option value="">Select...</option>
                                                                        @foreach ($acHeads as $head)
                                                                        <option value="{{ $head->id }}"
                                                                            {{ $item->account_head_id == $head->id ? 'selected' : ''}}>
                                                                            {{ $head->fld_ac_head }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </span>
                                                            </div>
                                                        </td>

                                                        <td><input type="text" name="invoice_no[]" required value="{{$item->invoice_no}}" step="any"  class="form-control inputFieldHeight2 "style="width: 100%;height:36px;"></td>

                                                        <td><input type="number" name="multi_total_amount[]" required step="any" value="{{$item->total_amount}}"  class="form-control inputFieldHeight2 amount_withvat"style="width: 100%;height:36px;"></td>
                                                            <td><input type="number" step="any"  class="form-control amount_without_vat inputFieldHeight2" required value="{{$item->gst_amount}}"    name="multi_amount[]"  >
                                                        <td>
                                                            <input type="number"  step="any"   name="multi_tax_rate[]" required value="{{$item->gst_subtotal}}" onchange="option(this);"onkeyup="gstSubtotal();"  class="form-control multi-tax-rate inputFieldHeight2" style="width: 100%;height:36px;">
                                                        </td>
                                                        <td class="NoPrint"><button style="padding: 2px; margin: 4px;" type="button" required class="btn btn-sm btn-danger"onclick="BtnDel(this)">DELETE</button></td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                                <tbody>
                                                    <tr>
                                                        <td colspan="4"></td>
                                                        <td class="text-center" style="color: black">TOTAL</td>
                                                        <td><input type="text" readonly id="total_amount" class="form-control inputFieldHeight2 @error('total_amount') error @enderror inputFieldHeight total"
                                                             name="total_amount" value="{{$journalF->amount}}" placeholder="TOTAL" readonly required>
                                                            @error('total_amount')
                                                            <span class="error">{{ $message }}</span>
                                                            @enderror</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4"></td>
                                                        <td class="text-center" style="color: black">@if(!empty($currency->vat_name)){{$currency->vat_name}} @endif SUBTOTAL</td>
                                                        <td><input type="text" readonly id="vat_subtotal" class="form-control  @error('vat_subtotal') error @enderror inputFieldHeight2 gst_subtotal"
                                                             name="vat_subtotal" value="{{$journalF->without_gst}}" placeholder="@if(!empty($currency->vat_name)){{$currency->vat_name}} @endif SUBTOTAL" readonly required>
                                                            @error('vat_subtotal')
                                                            <span class="error">{{ $message }}</span>
                                                            @enderror</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4"></td>
                                                        <td class="text-center" style="color: black">@if(!empty($currency->vat_name)){{$currency->vat_name}} @endif TOTAL</td>
                                                        <td><input type="text" readonly id="gst_total" class="form-control @error('gst_total') error @enderror inputFieldHeight2 gst_total"
                                                             name="gst_total" value="{{$journalF->vat_amount}}" placeholder="@if(!empty($currency->vat_name)){{$currency->vat_name}} @endif TOTAL " readonly required>
                                                            @error('gst_total')
                                                            <span class="error">{{ $message }}</span>
                                                            @enderror</td>
                                                    </tr>
                                                    <tr class="d-none">
                                                        <td colspan="4"></td>
                                                        <td class="text-center " style="color: black">@if(!empty($currency->vat_name)){{$currency->vat_name}} @endif FREE TOTAL</td>
                                                        <td><input type="text" readonly id="gst_free_total" class="form-control @error('free_amount') error @enderror inputFieldHeight2 gst_free_total"
                                                             name="free_amount" value="" placeholder="@if(!empty($currency->vat_name)){{$currency->vat_name}} @endif TOTAL " readonly required>
                                                            @error('free_amount')
                                                            <span class="error">{{ $message }}</span>
                                                            @enderror</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <input type="hidden" name="index_number" id="index_number" value="{{$index}}">
                            <div class="cardStyleChange">
                                <div class="card-body bg-white">
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label for="">Narration</label>
                                            <input type="text" class="form-control inputFieldHeight2" name="narration"
                                                id="narration" placeholder="Narration"
                                                value="{{ isset($journalF) ? $journalF->narration : '' }}"
                                                required>
                                        </div>

                                        <div class="col-md-3 form-group">
                                            <label for="">Voucher Scan/File</label>
                                            <input type="file" class="form-control inputFieldHeight2" name="voucher_scan" accept="image/*" >
                                        </div>

                                        <div class="col-md-3 form-group">
                                            <label for="">Voucher Scan/File 2</label>
                                            <input type="file" class="form-control inputFieldHeight2" name="voucher_scan2" accept="image/*" >
                                        </div>
                                        <div class="col-md-12 text-right d-flex justify-content-end align-items-center" >
                                            <button type="submit" class="btn btn-primary formButton" data-repeater-delete title="Add"  data-repeater-create>
                                                <div class="d-flex align-items-center">
                                                    <div class="formSaveIcon">
                                                        <img  src="{{asset('assets/backend/app-assets/icon/save-icon.png')}}" alt=""  srcset=""  height="15">
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
    <div class="modal fade bd-example-modal-lg" id="voucherPreviewModal" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div id="voucherPreviewShow">

            </div>
          </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg" id="voucherDetailsPrintModal" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div id="voucherDetailsPrint">

            </div>
          </div>
        </div>
    </div>
    <div id="temp_ac_head" class="d-none">
        <select name="multi_acc_head[]" onchange="option(this);" required  class="text-center job_group_id form-control transection-heads multi-acc-head input-due-payment inputFieldHeight2" style="width: 100%;  height: 36PX;">
            <option value="">Select...</option>
            @foreach ($acHeads as $head)
            <option value="{{ $head->id }}" >
                {{ $head->fld_ac_head }}</option>
            @endforeach
        </select>
    </div>
@endsection
@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
<script src="{{ asset('assets/backend')}}/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
<script src="{{ asset('assets/backend')}}/app-assets/js/scripts/forms/select/form-select2.js"></script>
<script src="{{ asset('assets/backend')}}/app-assets/vendors/js/forms/repeater/jquery.repeater.min.js"></script>
<script src="{{ asset('assets/backend')}}/app-assets/js/scripts/forms/form-repeater.js"></script>
{{-- js work by mominul start --}}

{{-- js work by mominul end --}}

<script>
    var item_input_text = `<small class="change-input item_select_option"><i class="bx bx-minus"></i></small>`
    var item_input_field = `<input type="text" placeholder="Account Head" class="form-control product" style="width: 260px;" name="multi_acc_head[]" id="product" required>`
    var item_input_field2 = $('#temp_ac_head').html();
    var item_input_text2 = `<small class="change-input item_input_field"><i class="bx bx-plus"></i></small>`
    $(document).on('click', '.item_input_field', function(e){
        e.preventDefault();
        var this_tr = $(this).closest("tr");
        this_tr.find(".item_change_input_option").empty().append(item_input_field);
        this_tr.find(".item_input_text").empty().append(item_input_text);
    });
    $(document).on('click', '.item_select_option', function(e){
        var this_tr = $(this).closest("tr");
        e.preventDefault();
        console.log(item_input_field2);
        this_tr.find(".item_change_input_option").empty().append($('#temp_ac_head').html());
        this_tr.find(".item_input_text").empty().append(item_input_text2);
    });
    $(document).ready(function() {

        // $('.btn_create').click(function(){
        $('#pay_mode').change(function() {
            var value = $(this).val();
            if (value=="NonCash") {
                $('.non-cash-account-head').show();
                // $("#acc_head_2").focus();
                $('.common-select2').select2();

            } else {
                $('.non-cash-account-head').hide();
                $("#ac_code").focus();
            }
        });
        $(document).on("keyup", ".amount_withvat", function(e) {
        var amount=$(this).val();
        $(this).closest("tr").find(".amount_without_vat").val(amount);
        var standard_vat_rate=$('#standard_vat_rate').val();
            var gst = (amount*standard_vat_rate)/(100+(standard_vat_rate*1));
           var value = gst.toFixed(2)
           var selectedValue = $(this).closest("tr").find(".multi-tax-rate").val(value);
            gstotal();
            total();
            sum_all_amount();
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
                        $("#invoice_no").focus();
                    }
                }
            })
        }
        });

    });

    function BtnAdd() {
    /* Add Button */
    var newRow = $("#TRow").clone();
    newRow.removeClass("d-none");

    newRow.find("input, select").val('').attr('name', function(index, name) {
        return name.replace(/\[\d+\]/, '[' + ($('#TBody tr').length) + ']');
    });

    newRow.find("th").first().html($('#TBody tr').length+1 );
    newRow.appendTo("#TBody");
    newRow.find(".common-select2").select2();
 }

 function BtnDel(v) {
    /* Delete Button */
    $(v).parent().parent().remove();
    sum_all_amount();

    $("#TBody").find("tr").each(function(index) {
        $(this).find("th").first().html(index);
    });
 }



 $(document).on("keyup", ".multi-tax-rate", function(e) {
            console.log(6)
            var amount1 = $(this).val();
            var standard_vat_rate=$('#standard_vat_rate').val();
            var vat_cal=standard_vat_rate*1;

            var gst1 = ((100+vat_cal)/vat_cal)*amount1;
           var value1 = gst1.toFixed(2)
           var selectedValue1 = $(this).closest("tr").find(".amount_without_vat").val(value1);
            gstotal();
            total();
            gst_free();
      });

      $(document).on("keyup", ".amount_without_vat", function(e) {
            var amount = $(this).val();
            var standard_val=$('#standard_vat_rate').val();
            var standard_vat_rate = standard_val*1;
            var gst = (amount*standard_vat_rate)/(100+(standard_vat_rate));
           var value = gst.toFixed(2)
           var selectedValue = $(this).closest("tr").find(".multi-tax-rate").val(value);
            gstotal();
            total();
            gst_free();
      });

      $(document).on("keyup", ".amount_withvat", function(e) {
           sum_all_amount();
      });


 function sum_all_amount(){
            var sum=0;
            $('.amount_withvat').each(function() {
                var this_amount= $(this).val();
                this_amount = (this_amount === '') ? 0 : this_amount;
                this_amount= parseInt(this_amount);
                //
                sum = sum+this_amount;
            });
            console.log(sum);
            $('#total_amount').val(sum);
        }

        function gstotal() {
            var sum=0;
            $('.multi-tax-rate').each(function() {
                var this_amount1= $(this).val();
                //console.log(this_amount)
                this_amount1 = (this_amount1 === '') ? 0 : this_amount1;
                var this_amount1 = parseFloat(this_amount1);
                //
                sum = sum+this_amount1;
            });
            var result1 = sum.toFixed(2)
            // console.log(sum);
            $(".gst_total").val(result1);
      };

      function total() {
            var sum1=0;
            $('.amount_without_vat').each(function() {
                var this_amount12= $(this).val();
                //console.log(this_amount)
                this_amount12 = (this_amount12 === '') ? 0 : this_amount12;
                var this_amount12 = parseFloat(this_amount12);
                //
                sum1 = sum1+this_amount12;
            });
            var result12 = sum1.toFixed(2)
            // console.log(sum1);
            $("#vat_subtotal").val(result12);
      };

</script>

@endpush
