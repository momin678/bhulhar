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
    /* .journaCreation{
        background: #1214161c;
    } */
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
            @include('clientReport.service-inentory.header', ['activeMenu' => 'token'])
            <div class="tab-content journaCreation">
                @include('backend.token-gen.sub-head',['activeMenu' => 'maintenance_job'])
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
                                            class="common-select2 party-info " style="width: 100% !important" data-target="" >
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
                                                    <option value="{{ $item->title }}" {{$item->title=='Cash'?'selected':''}}>{{ $item->title }}</option>
                                                @endforeach
                                            </select>
                                            @error('pay_mode')
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
                                        <div class="col-md-2 transaction_type">
                                            <label for="">Token Number</label>
                                                <select name="token_no" id="token_no" class="common-select2 inputFieldHeight" style="width: 100% !important" >
                                                <option value="">Select Token</option>
                                                @foreach ($tokens as $item)
                                                    <option value="{{ $item->token_no }}">{{ $item->token_no }}</option>
                                                @endforeach
                                            </select>
                                            @error('token_no')
                                                <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-2 truck_id">
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
                                        <div class="col-md-2 changeColStyle">
                                            <label for="">Date</label>
                                            <input type="text" class="form-control inputFieldHeight" value='{{date('d/m/Y')}}' name="date" id="date" placeholder="dd/mm/yyyy" required>
                                            @error('date')
                                                <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 changeColStyle ">
                                            <label for="">Work Description</label>
                                            <input type="text" name="narration" class="form-control inputFieldHeight">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row pl-1 pr-1">
                                    <div class="cardStyleChange" style="width: 100%">
                                        <div class="card-body">
                                            <table class="table table-bordered table-sm ">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 5%;text-align:center;">#</th>
                                                        <th style="width: 20%;text-align:center;">Item Name </th>
                                                        <th style="width: 15%;text-align:center;">QTY</th>
                                                        <th style="width: 15%;text-align:center;">RATE</th>
                                                        <th style="width: 15%;text-align:center;">AMOUNT</th>
                                                        <th style="width: 20%;text-align:center;">REMARKS</th>
                                                        <th  class="NoPrint"> <button type="button" class="btn btn-sm "style="border: 1px solid black;
                                                            color: black; border-radius: 10px;padding: 5px; margin: 4px;" onclick="BtnAdd()">ADD</button>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody id="TBody">
                                                    <tr id="TRow" class="d-none">
                                                        <th scope="row" style="width: 5%; text-align:center;">1</th>
                                                        <td>
                                                             <select name="inputs[0][job_group_id]" onchange="option(this);"  class="job_group_id" style="width: 100%;    HEIGHT: 36PX;" >
                                                                <option value=""> ----- Choice Option ----</option>
                                                                @foreach ($products as $item)
                                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control text-end qty" name="inputs[0][qty]" onkeyup="Calc(this);">
                                                            <small id="inputs[0]sub_job_group_id" class="sub_job_group_id text-danger"></small>
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control text-end rate" name="inputs[0][rate]" onkeyup="Calc(this);" readonly step="any">
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control text-end amt" name="inputs[0][amt]" readonly>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="inputs[0][remark]"  class="form-control text-end"style="width: 100%;    HEIGHT: 36PX;">
                                                        </td>
                                                        <td class="NoPrint">
                                                            <button style="border-radius: 10px;padding: 5px; margin: 4px;" type="button" class="btn btn-sm btn-danger"onclick="BtnDel(this)">DELETE</button>
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                            <div class="row ">
                                                <div class="col-7"></div>
                                                <div class="col-5">
                                                    <div class="form-group row">
                                                        <label for="inputEmail3" class="col-sm-6 col-form-label">TOTAL </label>
                                                        <div class="col-sm-6">
                                                            <input type="text" id="sub_total"value="00" required readonly name="sub_total" class="form-control" >
                                                            @error('sub_total')
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
                            <div class="cardStyleChange bg-white">
                                <div class="card-body">
                                    <div class="row p-1">
                                        <div class="col-sm-5 form-group d-none">
                                            <label for="">Labour Charge </label>
                                            <input type="number" class="form-control inputFieldHeight" name="others_cost" >
                                        </div>
                                        <div class="col-sm-5 form-group">
                                            <label for="">Upload Document</label>
                                            <input type="file" class="form-control inputFieldHeight" name="voucher_scan" accept="image/*" >
                                        </div>
                                        <div class="col-sm-7 text-right d-flex justify-content-end mt-2 mb-1">
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

@endsection
@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
<script src="{{ asset('assets/backend')}}/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
<script src="{{ asset('assets/backend')}}/app-assets/js/scripts/forms/select/form-select2.js"></script>
<script src="{{ asset('assets/backend')}}/app-assets/vendors/js/forms/repeater/jquery.repeater.min.js"></script>
<script src="{{ asset('assets/backend')}}/app-assets/js/scripts/forms/form-repeater.js"></script>
<script>
    function GetPrint() {
        /For Print/
        window.print();
    }

    function BtnAdd() {
    /* Add Button */
    var newRow = $("#TRow").clone();
    newRow.removeClass("d-none");

    newRow.find("input, select").val('').attr('name', function(index, name) {
        return name.replace(/\[\d+\]/, '[' + ($('#TBody tr').length - 1) + ']');
    });

    newRow.find("th").first().html($('#TBody tr').length );
    newRow.appendTo("#TBody");
 }

    function BtnDel(v) {
        /* Delete Button */
        $(v).parent().parent().remove();
        GetTotal();

        $("#TBody").find("tr").each(function(index) {
            $(this).find("th").first().html(index);
        });
    }

    // **************************************** this function work to conver numaric value into respectibe work *****
    function number_to_text(number){
        // Arrays to represent textual words for numbers
        const ones = [
            '', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine'
        ];

        const teens = [
            'Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'
        ];

        const tens = [
            '', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'
        ];

        const thousands = ['', 'Thousand', 'Million', 'Billion', 'Trillion'];

        function convertChunk(chunk) {
            const words = [];
            const hundred = Math.floor(chunk / 100);
            const remainder = chunk % 100;

            if (hundred > 0) {
                words.push(ones[hundred] + ' Hundred');
            }

            if (remainder >= 10 && remainder <= 19) {
                words.push(teens[remainder - 10]);
            } else {
                const ten = Math.floor(remainder / 10);
                const one = remainder % 10;

                if (ten > 0) {
                    words.push(tens[ten]);
                }

                if (one > 0) {
                    words.push(ones[one]);
                }
            }

            return words.join(' ');
        }

        if (number === 0) {
            return 'Zero';
        }

        let result = '';
        let chunkIndex = 0;

        while (number > 0) {
            const chunk = number % 1000;
            if (chunk > 0) {
                result = convertChunk(chunk) + ' ' + thousands[chunkIndex] + ' ' + result;
            }

            number = Math.floor(number / 1000);
            chunkIndex++;
        }

        return result.trim();
    }
    // **************************************** this function work to conver numaric value into respectibe work *****

    function option(v) {
        //Detail Calculation Each Row/
        var index = $(v).parent().parent().index();
        var id = document.getElementsByClassName("job_group_id")[index].value;
        $.ajax({
        url: "{{ route('find-stock') }}",
        method: 'GET',
        data: {
                id: id
            },

        success: function(res) {
            var subJobGroupElement = document.getElementsByClassName("sub_job_group_id")[index];
            var qty = document.getElementsByClassName("qty")[index];
            subJobGroupElement.innerHTML = "Availabe qty "+ res.pcs;
            document.getElementsByClassName("rate")[index].value = res.avg_unit_price;
            document.getElementsByClassName("qty")[index].setAttribute('max', res.pcs);
        },
        error: function(err) {
            let error = err.responseJSON;
            $.each(error.errors, function(index, value) {
                toastr.error(value);

            })
        }
        });
    }
    function maincalc() {
        var advance_payment = parseFloat(document.getElementsByName("advance_payment")[0].value);
        var discount = parseFloat(document.getElementsByName("discount")[0].value);
        var sub_total = parseFloat(document.getElementsByName("sub_total")[0].value);

        if (isNaN(advance_payment)) {
            advance_payment = 0;
        }
        if (isNaN(discount)) {
            discount = 0;
        }

        var payable = sub_total - discount - advance_payment;

        var net_payable_input = document.getElementById("net_payable"); // Removed [0]
        net_payable_input.value = payable;
        const textualNumber = number_to_text(payable);
        document.getElementById("narration").value = textualNumber;
    }
    function Calc(v) {
        /Detail Calculation Each Row/
        var index = $(v).parent().parent().index();

        var qty = document.getElementsByClassName("qty")[index].value;
        var rate = document.getElementsByClassName("rate")[index].value;

        var amt = qty * rate;
        document.getElementsByClassName("amt")[index].value = amt;

        GetTotal();


    }

    function GetTotal() {
        var sum = 0;
        var amts = document.getElementsByClassName("amt");
        for (let index = 0; index < amts.length; index++) {
            var amt = amts[index].value;
            sum = +(sum) + +(amt);
        }
        document.getElementById("sub_total").value = sum;

    }
</script>

<script>
    $(document).ready(function() {
        $(document).on("click", ".btn_create", function(e){
            e.preventDefault();
            // alert('Alhamdulillah');
            setTimeout(function() {
                $('.multi-acc-head').select2();
            }, 1000);
        });
        $(document).on("change", ".find-stock", function(e){
            e.preventDefault();
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
        $('#token_no').change(function() {
            var value = $(this).val();
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ route('get-token-info') }}",
                method: "POST",
                data: {
                    value: value,
                    _token: _token,
                },
                success: function(response) {
                    $("div.truck_id select").val(response.truck_id);
                    $('.common-select2').select2();
                }
            })
        });
    });
</script>

@endpush
