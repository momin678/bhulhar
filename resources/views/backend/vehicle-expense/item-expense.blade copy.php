@extends('layouts.backend.app')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
@section('content')
@include('layouts.backend.partial.style')
<style>
    .changeColStyle span{
        min-width: 16%;
    }
    .changeColStyle .select2-container--default .select2-selection--single .select2-selection__arrow b{
        /* display: none; */
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
</style>
<div class="app-content content print-hideen">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            <div class="nav nav-tabs master-tab-section" id="nav-tab" role="tablist">
                <a href="{{route("vehicle-expense.index")}}" class="nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/list-icon.png')}}" alt="" srcset="" class="img-fluid" width="50" height="20">
                    </div>
                    <div>Preview</div>
                </a>
                <a href="{{route('vehicle-expense.create')}}" class="nav-item nav-link d-none" role="tab" aria-controls="nav-contact" aria-selected="false">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/add-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
                    </div>
                    <div>Expense Entry</div>
                </a>
                <a href="{{route('item-expense')}}" class="nav-item nav-link active" role="tab" aria-controls="nav-contact" aria-selected="false">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/add-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
                    </div>
                    <div>Allocation</div>
                </a>
            </div>
            <div class="tab-content journaCreation">
                <div id="journaCreation" class="tab-pane active">
                    <section id="widgets-Statistics">
                        <form action="{{ route('item-expense-store') }}" method="POST" enctype="multipart/form-data" >
                            @csrf
                            <div class="cardStyleChange bg-white">
                                <div class="card-body pb-1">
                                    <div class="row m-1">
                                        <div class="col-md-3 transaction_type d-none">
                                            <label for="project">Project</label>
                                            <select name="project" class="form-control common-select2" id="project" required>
                                                @foreach ($projects as $item)
                                                    <option value="{{ $item->id }}">{{ $item->proj_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('project')
                                                <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3 transaction_type search-item d-none">
                                            <label for="">Cost Center Name</label>
                                            <select name="cost_center_name" id="cost_center_name"
                                            class="common-select2 party-info " style="width: 100% !important" data-target="" required>
                                                {{-- <option value="">Select...</option> --}}
                                                @foreach ($cCenters as $item)
                                                    <option value="{{ $item->id }}">{{ $item->cc_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('cost_center_name')
                                                <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3 transaction_type search-item-pi d-none">
                                            <label for="">Party Name</label>
                                            <select name="party_info" id="party_info"
                                            class="common-select2 party-info" style="width: 100% !important" data-target="" required>
                                                <option value="">Select...</option>
                                                @foreach ($pInfos as $item)
                                                    <option value="{{ $item->id }}" {{$item->pi_code=='PI-0001'?'selected':''}}>{{ $item->pi_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('party_info')
                                                <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3 transaction_type d-none">
                                            <label for="">Transaction Type</label>
                                            <select name="transaction_type" id="transaction_type" class="common-select2 inputFieldHeight" style="width: 100% !important" required>
                                                <option value="Increase" selected>General</option>
                                                <option value="Decrease">Adjustment</option>
                                            </select>
                                            @error('transaction_type')
                                                <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3 changeColStyle d-none">
                                            <label for="">Payment Mode</label>
                                            <select name="pay_mode" id="pay_mode" class="form-control inputFieldHeight" required>
                                                @foreach ($modes as $item)
                                                    <option value="{{ $item->title }}">{{ $item->title }}</option>
                                                @endforeach
                                            </select>
                                            @error('pay_mode')
                                                <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3 changeColStyle">
                                            <label for="">Date</label>
                                            <input type="text" class="form-control inputFieldHeight" name="date" id="date" placeholder="dd/mm/yyyy" >
                                            @error('date')
                                                <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3 changeColStyle d-none">
                                            <label for="">Invoice No</label>
                                            <input type="text" class="form-control inputFieldHeight" name="invoice_no" value="100001" id="invoice_no" placeholder="Invoice No" required>
                                            @error('invoice_no')
                                                <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3 transaction_type">
                                            <label for="">Vehicle Number</label>
                                                <select name="vehicle_id" id="vehicle_id" class="common-select2 inputFieldHeight" style="width: 100% !important" required>
                                                <option value="">Select Vehicle</option>
                                                @foreach ($vehicles as $item)
                                                    <option value="{{ $item->id }}">{{ $item->vehicle_number }}</option>
                                                @endforeach
                                            </select>
                                            @error('vehicle_id')
                                                <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row p-1">
                                    <div class="cardStyleChange" style="width: 100%">
                                        <div class="card-body">
                                            <div class="repeater-default" id="form-repeat-container">
                                                <div data-repeater-list="group-a">
                                                    <div data-repeater-item>
                                                        <div class="row every-form-row">
                                                            <div class="col-md-4 transaction_type">
                                                                <label for="">Item Name</label>
                                                                <select name="multi_acc_head" class="form-control common-select2 multi-acc-head input-due-payment find-stock">
                                                                    <option value="">Select Product...</option>
                                                                    @foreach ($products as $item)
                                                                        <option value="{{ $item->id }}">{{ $item->category->name.' '.$item->brand->name.' '.$item->subBrand->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-2 changeColStyle">
                                                                <label for="">Quantity</label>
                                                                <input type="number" id="quantity" name="multi_quanyity" class="form-control inputFieldHeight multi-quanyity habib" placeholder="Quantity" step="any">
                                                                
                                                                    <span class="invalid feedback" role="alert" style="font-size: 11px; color:rgb(233, 162, 10); font-weight:bold">
                                                                        
                                                                    </span>
                                                            </div>
                                                            <div class="col-md-2 changeColStyle">
                                                                <label for="">RATE</label>
                                                                <input type="number" id="rate" name="multi_total_amount" class="form-control inputFieldHeight amount_withvat habib" placeholder="Rate" step="any">
                                                            </div>

                                                            <div class="col-md-3 changeColStyle">
                                                                <label for="">Line Total</label>
                                                                <input type="number" id="total_amount" name="multi_amount" class="form-control amount_without_vat inputFieldHeight habib"  step="any" placeholder="Total Amount" readonly>
                                                            </div>

                                                            <div class="col-md-1 col-sm-12 d-flex pt-2 changeColStyle justify-content-end">
                                                                <button type="button" class="btn btn-danger formButton mDeleteIcon" data-repeater-delete title="Delete">
                                                                    <div class="d-flex align-items-right">
                                                                        <div class="formSaveIcon">
                                                                            <img  src="{{asset('assets/backend/app-assets/icon/delete-icon.png')}}" alt="" srcset=""  width="25">
                                                                        </div>
                                                                    </div>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <div class="col p-0">
                                                                <button type="button" class="btn btn-primary btn_create formButton" data-repeater-delete title="Add" data-repeater-create>
                                                                    <div class="d-flex">
                                                                        <div class="formSaveIcon">
                                                                            <img  src="{{asset('assets/backend/app-assets/icon/add-icon.png')}}" alt="" srcset=""  width="25">
                                                                        </div>
                                                                        <div><span>Add More Item</span></div>
                                                                    </div>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-12">
                                                        <div>
                                                            <input type="text" id="grand_total" class="form-control @error('total_amount') error @enderror inputFieldHeight" name="grand_total" value="" placeholder="Total Amount" readonly required>
                                                            @error('total_amount')
                                                            <span class="error">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="cardStyleChange">
                                <div class="card-body">
                                    <div class="row p-1">
                                        <div class="col-sm-7 form-group">
                                            <label for="">Narration</label>
                                            <input type="text" class="form-control inputFieldHeight" name="narration" id="narration" placeholder="Narration"value=""required>
                                        </div>

                                        <div class="col-sm-3 form-group">
                                            <label for="">Upload Document</label>
                                            <input type="file" class="form-control inputFieldHeight" name="voucher_scan" accept="image/*" >
                                        </div>
                                        <div class="col-sm-2 text-right d-flex justify-content-end mt-2 mb-1">
                                            <button type="submit" class="btn btn-primary formButton" data-repeater-delete title="Add" data-repeater-create>
                                                <div class="d-flex">
                                                    <div class="formSaveIcon">
                                                        <img  src="{{asset('assets/backend/app-assets/icon/save-icon.png')}}" alt="" srcset=""  width="25">
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
@endsection
@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
<script src="{{ asset('assets/backend')}}/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
<script src="{{ asset('assets/backend')}}/app-assets/js/scripts/forms/select/form-select2.js"></script>
<script src="{{ asset('assets/backend')}}/app-assets/vendors/js/forms/repeater/jquery.repeater.min.js"></script>
<script src="{{ asset('assets/backend')}}/app-assets/js/scripts/forms/form-repeater.js"></script>
{{-- js work by mominul start --}}
<script>
    $(document).on("click", ".voucherDetails", function(e) {
        e.preventDefault();
        var id= $(this).attr('id');
		$.ajax({
			url: "{{URL('voucher-details-modal')}}",
			type: "post",
			cache: false,
			data:{
				_token:'{{ csrf_token() }}',
                id:id,
			},
			success: function(response){
                document.getElementById("voucherDetailsPrint").innerHTML = response;
                $('#voucherDetailsPrintModal').modal('show')
			}
		});
	});
    $(document).on("click", ".mVoucherPreview", function(e) {
        e.preventDefault();
        var id= $(this).attr('id');
		$.ajax({
			url: "{{URL('voucher-preview-modal')}}",
			type: "post",
			cache: false,
			data:{
				_token:'{{ csrf_token() }}',
                id:id,
			},
			success: function(response){
                document.getElementById("voucherPreviewShow").innerHTML = response;
                $('#voucherPreviewModal').modal('show')
			}
		});
	});
    $(document).on("change", "#voucherType", function(e){
        let type = $(this).val();
        document.getElementById("mVoucherType").value = type;
    })
</script>
{{-- js work by mominul end --}}

<script>
    $(document).ready(function() {

        // $('.btn_create').click(function(){
        $(document).on("click", ".btn_create", function(e){
            e.preventDefault();
            // alert('Alhamdulillah');
            setTimeout(function() {
                $('.multi-acc-head').select2();
            }, 1000);
        });
        $(document).on("change", ".find-stock", function(e){
            e.preventDefault();
            // alert('Alhamdulillah');
            // var div_id = 
            $(this).closest('.every-form-row').find('.invalid').addClass("intro");

            var _token = $('input[name="_token"]').val();
            var p_id= $(this).val()

            $.ajax({
                url: "{{ route('find-stock') }}",
                method: "POST",
                data: {
                    p_id: p_id,
                    _token: _token,

                },
                success: function(response) {
                    if(response.stock != null){
                        $(".intro").empty().append('max stock quantity '+ response.stock.pcs);


                        $(".intro").closest('.every-form-row').find('.multi-quanyity').attr({
                        "max" : response.stock.pcs,
                        "min" : 1
                        });                   
                    }
                    else{
                        $(".intro").empty().append('no stock quantity remining!!');
                        $(".intro").closest('.every-form-row').find('.habib').attr('readonly', true);
                        // <strong>{{ 'no stock quantity remining!!' }}.</strong>

                    }
                    $(".intro").removeClass('intro');

                }
            })
        });

        // on change amount
        $('.repeater-default').on("keyup", ".amount_withvat", function(e) {
            var amount = $(this).val();
            var tax_rate= 3;
            var amount_obj= $(this).closest('.every-form-row').find('.amount_without_vat');
            var quantity= $(this).closest('.every-form-row').find('.multi-quanyity');
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ route('findamount') }}",
                method: "POST",
                data: {
                    amount: amount,
                    tax_rate:tax_rate,
                    _token: _token,
                },
                success: function(response) {
                    amount = response.total_amount;
                    $(amount_obj).val(amount*quantity.val());
                    sum_all_amount();
                }
            })
        });
        // on change tax rate
        $('.repeater-default').on('keyup', '.multi-quanyity', function(){
            var value = $(this).val();
            var amount_withvat= $(this).closest('.every-form-row').find('.amount_withvat').val();
            $(this).closest('.every-form-row').find('.amount_without_vat').val(amount_withvat*value);
            sum_all_amount();
        });

        function sum_all_amount(){

            var sum=0;
            $('.amount_without_vat').each(function() {
                //
                var this_amount= $(this).val();
                this_amount = (this_amount === '') ? 0 : this_amount;
                sum = sum+parseInt((this_amount === '') ? 0 : this_amount);
            });
            console.log(sum);

            $('#grand_total').val(sum);
        }
        $("#date").focus();

        $(document).on("change", "#date", function(e) {
            $("#txn_type").focus();
        })

        $(document).on("keypress", "#date", function(e) {
            var key = e.which;
            var value = $(this).val();
            if (e.which == 13) {
                $("#txn_type").focus();
                e.preventDefault();
                return false;
            }

        });

        $('#txn_type').change(function() {
            $("#cc_code").focus();

        });
        var value = $('#project').val();
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
        });

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

        $(document).on("change", "#credit_party_info", function(e) {
            $("#ac_code").focus();
        });

        $(document).on("keyup", "#cc_code", function(e) {
            var value = $(this).val();

            var _token = $('input[name="_token"]').val();
            if ($(this).val() != '') {
            $.ajax({
                url: "{{ route('findCostCenter') }}",
                method: "POST",
                data: {
                    value: value,
                    _token: _token,
                },
                success: function(response) {
                    var qty = 1;
                    if(response != '')
                    {
                        $("div.search-item select").val(response.id);
                    $('.common-select2').select2();
                    $("#pi_code").focus();
                    }
                }
            })
        }
        });

        $(document).on("keypress", "#cc_code", function(e) {
            var key = e.which;
            var value = $(this).val();
            if (e.which == 13) {
                $("#cost_center_name").focus();
                e.preventDefault();
                return false;
            }

        });

        $(document).on("change", "#cost_center_name", function(e) {
            if ($(this).val() != '') {
                var value = $(this).val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('findCostCenterId') }}",
                    method: "POST",
                    data: {
                        value: value,
                        _token: _token,
                    },
                    success: function(response) {
                        $("#cc_code").val(response.cc_code);
                        $("#pi_code").focus();
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
                        $("#invoice_no").focus();

                    }
                })
            }
        });

        $(document).on("change", "#cost_center_name", function(e) {
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

        $(document).on("keypress", "#pi_code", function(e) {
            var key = e.which;
            var value = $(this).val();
            if (e.which == 13) {


                $("#party_info").focus();
                e.preventDefault();
                return false;
            }

        });

        $(document).on("keypress", "#invoice_no", function(e) {
            var key = e.which;
            var value = $(this).val();
            if (e.which == 13) {


                $("#pay_mode").focus();
                e.preventDefault();
                return false;
            }

        });

        $(document).on("keyup", "#ac_code", function(e) {
            // alert(1);
            var value = $(this).val();
            var _token = $('input[name="_token"]').val();
            if ($(this).val() != '') {
            $.ajax({
                url: "{{ route('findAccHead') }}",
                method: "POST",
                data: {
                    value: value,
                    _token: _token,
                },
                success: function(response) {
                    var qty = 1;
                    if (response != '') {

                    $("div.search-item-head select").val(response.id);
                    $("#amount").focus();
                    $('.common-select2').select2();
                    }


                }
            })
        }
        });

        $(document).on("keypress", "#ac_code", function(e) {
            var key = e.which;
            var value = $(this).val();
                if (e.which == 13) {
                $("#acc_head").focus();
                e.preventDefault();
                return false;
            }


        });

        $('#acc_head').change(function() {
            if ($(this).val() != '') {
                var value = $(this).val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('findAccHeadId') }}",
                    method: "POST",
                    data: {
                        value: value,
                        _token: _token,
                    },
                    success: function(response) {
                        console.log(response);
                        $("#ac_code").val(response.fld_ac_code);
                        $("#amount").focus();
                    }
                })
            }
        });

        $(document).on("keypress", "#amount", function(e) {
            var key = e.which;
            var value = $(this).val();
                if (e.which == 13) {
                $("#tax_rate").focus();
                e.preventDefault();
                return false;
            }
        });

    });
</script>

@endpush
