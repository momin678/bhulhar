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
        /* display: none; */
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow b{
        /* display: none; */
    }
</style>
<div class="app-content content print-hideen">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            @include('clientReport.business-operation.header',['activeMenu' => 'supplier_invoice'])
            <div class="tab-content bg-white">
                @include('backend.supplier-invoice.sub-head',['activeMenu' => 'create'])
                <div class="tab-pane active">
                    <div class="row" id="table-bordered">
                        <div class="col-12">
                            <div class="cardStyleChange p-2">
                                <div class="d-flex">
                                    <h4 class="flex-grow-1">Supplier Invoice</h4>
                                </div>
                                <form action="{{ route('save-supplier-invoice')}}" method="POST" id="invoice-form">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Supplier Name</label>
                                                <select name="supplier_id" class="inputFieldHeight form-control common-select2">
                                                    <option value="">Select Name</option>
                                                    @foreach ($suppliers as $supplier)
                                                    <option value="{{$supplier->id}}" {{isset($supplier_id) && $supplier_id== $supplier->id ? 'selected' : ''}} >{{ $supplier->pi_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Project Name</label>
                                                <select name="project" class="inputFieldHeight form-control common-select2">
                                                    @foreach ($projects as $project)
                                                        <option value="{{$project->id}}">{{ $project->proj_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Cost Center</label>
                                                <select name="cost_center" class="inputFieldHeight form-control common-select2">
                                                    @foreach ($cost_centers as $cost_center)
                                                        <option value="{{$cost_center->id}}">{{ $cost_center->cc_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Payment Mode</label>
                                                <select name="pay_mode" id="pay_mode" class="inputFieldHeight form-control common-select2">
                                                    @foreach ($pay_modes as $pay_mode)
                                                        <option value="{{$pay_mode->title}}">{{ $pay_mode->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Date</label>
                                                <input type="text" class="inputFieldHeight form-control" name="date" id="date" placeholder="dd\mm\yyyy" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">UPLOAD DOCUMENT</label>
                                                <input type="file" class="inputFieldHeight form-control" name="invoice_scan">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        @isset($records)
                                        <table class="table mb-0 table-sm table-hover">
                                            <thead  class="thead-light">
                                                <tr style="height: 50px;">
                                                    <th>SL No.</th>
                                                    {{-- <th>Date</th> --}}
                                                    {{-- <th>Truck</th> --}}
                                                    <th>Description</th>
                                                    <th>WGT</th>
                                                    <th>Rate</th>
                                                    <th>Amount</th>
                                                    {{-- <th>Vat%</th> --}}
                                                </tr>
                                            </thead>
                                            <tbody class="table-sm">
                                                
                                                @foreach ($records as $t_record)

                                                <tr class="trFontSize t-row">
                                                    <td>{{ $loop->index+1 }}
                                                        <input type="hidden" name="record_id[]" value="{{$t_record->id}}">
                                                    </td>
                                                    {{-- <td>{{$t_record->date}}</td> --}}
                                                    {{-- <td>{{$t_record->truck->vehicle_number}}</td> --}}
                                                    <td>From {{$t_record->crusher}} To {{$t_record->destination}}</td>
                                                    <td>{{$t_record->qty}}
                                                        <input type="hidden" name="" value="{{$t_record->qty}}" class="r-weight">
                                                    </td>
                                                    <td><input type="text" class="r-rate" name="rate[]" placeholder="Customer rate: {{$t_record->rate}}" required></td>
                                                    <td><input type="text" class="r-amount" placeholder="Amount" readonly></td>
                                                    {{-- <td><input type="text" placeholder="Vat" name="v_rate" class="v-rate" value="5"></td> --}}
                                                    
                                                </tr>
                                                @endforeach
                                                <tr class="trFontSize">
                                                    <td colspan="4" align="right">Vat Rate</td>
                                                    <td><input type="text" name="v_rate" id="v_rate" value="5" required></td>
                                                    {{-- <td></td> --}}
                                                </tr>
                                                <tr class="trFontSize">
                                                    <td colspan="4" align="right">Total Vat</td>
                                                    <td><input type="text" name="total_vat" id="total_vat" readonly></td>
                                                    {{-- <td></td> --}}
                                                </tr>
                                                <tr class="trFontSize">
                                                    <td colspan="4" align="right">Total</td>
                                                    <td><input type="text" name="total_amount" id="total_amount" readonly></td>
                                                    {{-- <td></td> --}}
                                                </tr>
                                                <tr class="trFontSize">
                                                    <td colspan="4" align="right">Payment Applied</td>
                                                    <td><input type="text" name="payment_amount" id="payment_amount" required></td>
                                                    {{-- <td></td> --}}
                                                </tr>
                                                <tr class="trFontSize">
                                                    <td colspan="4" align="right">Balance Due</td>
                                                    <td><input type="text" name="due_amount" id="due_amount" readonly></td>
                                                    {{-- <td></td> --}}
                                                </tr>
                                                
                                                
                                            </tbody>
                                        </table>
                                        <p class="text-right"><button class="btn btn-info mt-1" type="submit">Procced</button></p>
                                        
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






</script>
@endpush
