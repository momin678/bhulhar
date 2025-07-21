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
                                    <h4 class="flex-grow-1">Tax Invoice</h4>
                                    {{-- <div>
                                        <button type="button" class="btn btn-primary btn_create formButton mr-1" title="Add" data-toggle="modal" data-target="#newTruckAddModal">
                                            <div class="d-flex">
                                                <div class="formSaveIcon">
                                                    <img src="{{asset('assets/backend/app-assets/icon/add-icon.png')}}" width="25">
                                                </div>
                                                <div><span>Add New</span></div>
                                            </div>
                                        </button>
                                    </div> --}}
                                </div>
                                <form action="{{ route('draft-save-customer-invoice', $invoice->id)}}" id="invoice-form" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Customer Name</label>
                                                <select name="customer_id" class="inputFieldHeight form-control common-select2" required>
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
                                        <div class="col-sm-3 form-group pay-term">
                                            <label for="">Payment Terms</label>
                                            <select name="pay_terms" id="pay_terms" class="common-select2" style="width: 100% !important"
                                                required>
                                                <option value="">Select...</option>
                                                @foreach ($terms as $item)
                                                    <option value="{{ $item->value }}" {{ $item->value==$invoice->pay_terms? 'selected':'' }}>{{ $item->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-3 form-group">
                                            <label for="">Due Date</label>
                                            <input type="text" class="form-control" name="due_date"
                                                id="due_date" value="{{ $invoice->due_date }}" readonly>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">LPO Number</label>
                                                <input type="text"  class="inputFieldHeight form-control" name="lpo_number" value="{{$invoice->lpo_number}}">
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
                                                </tr>
                                            </thead>
                                            <tbody class="table-sm">
                                                @foreach ($records as $t_record)
                                                <tr class="trFontSize t-row">
                                                    <input type="hidden" name="temp_id[]" value="{{$t_record->id}}">
                                                    <td>{{ $loop->index+1 }}
                                                        <input type="hidden" name="record_id[]" value="{{$t_record->id}}">
                                                    </td>
                                                    <td>From {{$t_record->crusher}} To {{$t_record->destination}}</td>
                                                    <td>{{$t_record->record->weight}}
                                                        <input type="hidden" name="t_weight[]" value="{{$t_record->record->weight}}" class="r-weight">
                                                    </td>
                                                    <td><input type="text" class="r-rate" name="rate[]" placeholder="Rate" required value="{{$t_record->rate}}"></td>
                                                    <td><input type="text" class="r-amount" placeholder="Amount" readonly value="{{$t_record->amount}}"></td>
                                                </tr>
                                                @endforeach
                                                <tr class="trFontSize">
                                                    <td colspan="4" align="right">Vat Rate</td>
                                                    <td><input type="text" name="v_rate" id="v_rate" value="5"></td>
                                                </tr>
                                                <tr class="trFontSize">
                                                    <td colspan="4" align="right">Total Vat</td>
                                                    <td><input type="text" name="total_vat" id="total_vat" readonly value="{{$invoice->vat_amount}}"></td>
                                                </tr>
                                                <tr class="trFontSize">
                                                    <td colspan="4" align="right">Total</td>
                                                    <td><input type="text" name="total_amount" id="total_amount" readonly value="{{$invoice->amount}}"></td>
                                                </tr>
                                                <tr class="trFontSize">
                                                    <td colspan="4" align="right">Payment Applied</td>
                                                    <td><input type="decimal" name="payment_amount" id="payment_amount" required value="{{$invoice->paid_amount}}"></td>
                                                </tr>
                                                <tr class="trFontSize">
                                                    <td colspan="4" align="right">Balance Due</td>
                                                    <td><input type="text" name="due_amount" id="due_amount" readonly value="{{$invoice->due_amount}}"></td>
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

        $('.r-rate').keyup(function(){
            var qty= ($(this).closest('.t-row').find('.r-weight').val());
            // var v_rate= ($(this).closest('.t-row').find('.v-rate').val());
            var v_rate= $('#v_rate').val();
            var rate= ($(this).val());
            var amount= qty*rate;
            $(this).closest('.t-row').find('.r-amount').val(amount.toFixed(2));
            total_vat(v_rate);

        });

        function total_vat(vat_rate){
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
                total_amount= total_amount+total_vat;
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
</script>
@endpush
