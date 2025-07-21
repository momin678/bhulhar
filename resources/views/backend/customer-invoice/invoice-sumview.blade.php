@extends('layouts.backend.app',['invoice_status'=>$invoice->status])
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
    <div class="app-content content print-hideen">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                @include('clientReport.business-operation.header',['activeMenu' => 'customer_invoice'])
    
                <div class="tab-content bg-white">
                    @include('backend.customer-invoice.sub-head',['activeMenu' => $invoice->status?'pending':'approved' ])
                    <div class="tab-pane active">
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
                                    <form action="{{ route('save-customer-invoice')}}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="">Customer Name</label>
                                                    <input type="text" class="inputFieldHeight form-control" value="{{$invoice->customer->pi_name}}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="">Project Name</label>
                                                    <input type="text" class="inputFieldHeight form-control" value="{{$invoice->project->proj_name}}" readonly>
                                                </div>
                                            </div>
                                            {{-- <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="">Cost Center</label>
                                                    <input type="text" class="inputFieldHeight form-control" value="{{$invoice->customer->pi_name}}"readonly>
                                                </div>
                                            </div> --}}
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="">Payment Mode</label>
                                                    <input type="text" class="inputFieldHeight form-control" value="{{$invoice->pay_mode}}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="">Date</label>
                                                    <input type="text" class="inputFieldHeight form-control" name="date" value="{{date('d/m/Y', strtotime($invoice->date))}}" readonly>
                                                </div>
                                            </div>
                                            {{-- <div class="col-sm-3 form-group pay-term">
                                                <label for="">Payment Terms</label>
                                                <select name="pay_terms" id="pay_terms" class="common-select2" style="width: 100% !important"
                                                    disabled>
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
                                            </div> --}}
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="">LPO Number</label>
                                                    <input type="text"  class="inputFieldHeight form-control" name="lpo_number" value="{{ $invoice->lpo_number }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="">Month</label>
                                                    <input type="month"  class="inputFieldHeight form-control" name="" value="{{$invoice->month?date('Y-m', strtotime($invoice->month)):null}}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="">Pay Term</label>
                                                    <input type="text"  class="inputFieldHeight form-control" name="" value="{{ $invoice->pay_term }} {{$invoice->pay_term>0?' Days':''}}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            @isset($invoice)
                                            @php
                                            $invoice_total= $invoice->amount+$invoice->vat_amount;
                                        @endphp
                                        @if ($invoice_total<10000)
                                        <table class="table table-sm ">
                                            <tr class="bg-color">
                                                <th>SL No.</th>
                                                <th>Particular Description</th>
                                                <th class="text-right pr-1">Quantity</th>
                                                <th class="text-right pr-1">Rate</th>
                                                <th class="text-right pr-1">VAT Rate</th>
                                                <th class="text-right pr-1">Total Amount</th>
                                            </tr>
                                                @php
                                                    $taxable_amount=0;
                                                    $vat=0;
                                                    $total_amount=0;
                                                    $sl = 1;
                                                    $toll_fees = 0;
                                                @endphp
                                                @foreach ($invoice_items as $item)
                                                    <tr>
                                                        <td>{{$sl}}</td>
                                                        <td class="description">From {{$item->crusher}} To {{$item->destination}}</td>
                                                        <td>{{$item->total_qty}}</td>
                                                        <td class="text-right pr-1">{{$item->rate}}</td>
                                                        <td class="text-right pr-1">{{$item->vat_rate}}</td>
                                                        <td class="text-right pr-1">{{$item->rate * $item->total_qty}}</td>
                                                    </tr>
                                                    @php
                                                        $vat_amount= (($item->rate * $item->total_qty) * $item->vat_rate / 100);
                                                        $taxable_amount= $taxable_amount+ ($item->rate * $item->total_qty);
                                                        $vat = $vat+ $vat_amount ;
                                                        $total_amount = $total_amount+ ($item->rate * $item->total_qty) + $vat_amount;
                                                        $sl +=1;
                                                    @endphp
                                                @endforeach
                                                @foreach ($invoice_items->where('toll_fee', '>', 0) as $item)
                                                    <tr>
                                                        <td>{{$sl}}</td>
                                                        <td class="description">Toll {{$item->crusher}} To {{$item->destination}}</td>
                                                        <td>{{$item->toll_fee}}</td>
                                                        <td>1</td>
                                                        <td>{{$item->toll_fee}}</td>
                                                        <td>0</td>
                                                        <td>0</td>
                                                        <td>{{$item->toll_fee}}</td>
                                                    </tr>
                                                    @php
                                                        $toll_fees += $item->toll_fee;
                                                        $sl +=1;
                                                    @endphp
                                                @endforeach
                                                <tr class="trFontSize">
                                                    <td colspan="5" class="text-right pr-1">Total Quantity: </td>
                                                    <td>{{ number_format($invoice_items->sum('total_qty'), 2)}}</td>
                                                </tr>
                                                <tr class="trFontSize">
                                                    <td colspan="5" class="text-right pr-1">Total VAT: </td>
                                                    <td>{{ number_format($invoice->items->sum('vat_amount'),2) }}</td>
                                                </tr>
                                                <tr class="trFontSize">
                                                    <td colspan="5" class="text-right pr-1">Total: </td>
                                                    <td>{{ $t_amount =  $invoice->items->sum('amount')+$invoice->items->sum('vat_amount')+$invoice->items->sum('toll_fee')-$invoice->items->sum('discount') }}</td>
                                                    <td></td>
                                                </tr>
                                                <tr class="trFontSize">
                                                    <td colspan="5" class="text-right pr-1">Payment Applied: </td>
                                                    <td>{{ $invoice->paid_amount}}</td>
                                                    <td></td>
                                                </tr>
                                                <tr class="trFontSize">
                                                    <td colspan="5" class="text-right pr-1">Balance Due: </td>
                                                    <td>{{number_format($t_amount-$invoice->paid_amount,2)}}</td>
                                                    <td></td>
                                                </tr>
                                        </table>
                                        @else
                                        <table   class="table table-sm ">
                                            <tr class="bg-color">
                                                <th class="text-center" >SL No.</th>
                                                <th class="text-center" >Description</th>
                                                <th class="text-center" >Rate</th>
                                                <th class="text-center" >Quantity</th>
                                                <th class="text-center" >Gross Amount</th>
                                                <th class="text-center" >Tax Rate</th>
                                                <th class="text-center" >Tax Amount</th>
                                                <th class="text-center" >Net Amount</th>
                                            </tr>
                                                @php
                                                $taxable_amount=0;
                                                $vat=0;
                                                $total_amount=0;
                                                $sl = 1;
                                                $toll_fees = 0;
                                                @endphp
                                                @foreach ($invoice_items as $item)
                                                    <tr>
                                                        <td>{{$sl}}</td>
                                                        <td class="description-two">From {{$item->crusher}} To {{$item->destination}}</td>
                                                        <td>{{$item->rate}}</td>
                                                        <td>{{$item->total_qty}}</td>
                                                        <td>{{$item->rate * $item->total_qty}}</td>
                                                        <td>{{$item->vat_rate}}</td>
                                                        <td>{{$item->total_vat_amount}}</td>
                                                        <td>{{($item->rate * $item->total_qty)+$item->total_vat_amount}}</td>
                                                    </tr>
                                                    @php
                                                        $vat_amount= (($item->rate * $item->total_qty) * $item->vat_rate / 100);
                                                        $taxable_amount= $taxable_amount+ ($item->rate * $item->total_qty);
                                                        $vat = $vat+ $vat_amount ;
                                                        $total_amount = $total_amount+ ($item->rate * $item->total_qty) + $vat_amount ;
                                                        $sl +=1;
                                                    @endphp
                                                @endforeach
                                                @foreach ($invoice_items->where('toll_fee', '>', 0) as $item)
                                                    <tr>
                                                       <td>{{$sl}}</td>
                                                        <td class="description">Toll {{$item->crusher}} To {{$item->destination}}</td>
                                                        <td>{{$item->toll_fee}}</td>
                                                        <td>1</td>
                                                        <td>{{$item->toll_fee}}</td>
                                                        <td>0</td>
                                                        <td>0</td>
                                                        <td>{{$item->toll_fee}}</td>
                                                    </tr>
                                                    @php
                                                        $toll_fees += $item->toll_fee;
                                                        $sl +=1;
                                                    @endphp
                                                @endforeach
                                                <tr class="trFontSize">
                                                    <td colspan="7" class="text-right pr-1">Total Quantity: </td>
                                                    <td>{{ number_format($invoice_items->sum('total_qty'), 2)}}</td>
                                                </tr>
                                                <tr class="trFontSize">
                                                    <td colspan="7" class="text-right pr-1">Total VAT: </td>
                                                    <td>{{ number_format($invoice->items->sum('vat_amount'),2) }}</td>
                                                </tr>
                                                <tr class="trFontSize">
                                                    <td colspan="7" class="text-right pr-1">Total: </td>
                                                    <td>{{ $t_amount =  $invoice->items->sum('amount')+$invoice->items->sum('vat_amount')+$invoice->items->sum('toll_fee')-$invoice->items->sum('discount') }}</td>
                                                    <td></td>
                                                </tr>
                                                <tr class="trFontSize">
                                                    <td colspan="7" class="text-right pr-1">Payment Applied: </td>
                                                    <td>{{ $invoice->paid_amount}}</td>
                                                    <td></td>
                                                </tr>
                                                <tr class="trFontSize">
                                                    <td colspan="7" class="text-right pr-1">Balance Due: </td>
                                                    <td>{{number_format($t_amount-$invoice->paid_amount,2)}}</td>
                                                    <td></td>
                                                </tr>
                                        </table>
                                        @endif

                                            @endisset
                                        </div>
                                    </form>
                                </div>
                                <p class="text-center">
                                    <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
                                    @if ($invoice->status)
                                    <a href="{{ route('temp-customer-invoice-sum-print',$invoice->id)}}" target="_blank" class="btn btn-info">Print</a>
                                    @else
                                    <a href="{{ route('customer-invoice-sum-print',$invoice->id)}}" target="_blank" class="btn btn-info">Print</a>
                                    @endif
                                </p>
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
    // $(document).on("click", ".truckInfoEdit", function(e){
    //     e.preventDefault();
    //     $("#truckInfoEditModal").modal('show');
    // });

        $('.r-rate').keyup(function(){
            var qty= ($(this).closest('.t-row').find('.r-weight').val());
            var v_rate= ($(this).closest('.t-row').find('.v-rate').val());
            var rate= ($(this).val());
            var amount= qty*rate;
            $(this).closest('.t-row').find('.r-amount').val(amount);
            total_vat(v_rate);

        });

        function total_vat(vat_rate){
            var total_amount=0;
                $('.r-amount').each(function() {
                    var this_amount= $(this).val();
                    this_amount = (this_amount === '') ? 0 : this_amount;
                    this_amount= parseInt(this_amount);
                    total_amount = total_amount+this_amount;
                });
                var total_vat= total_amount * vat_rate / 100;

                $('#total_vat').val(total_vat);
                $('#total_amount').val(total_vat+total_amount);
        }

        $('#payment_amount').keyup(function(){
            var payment_amount= $(this).val();
            var total_amount= $('#total_amount').val();
            $('#due_amount').val(total_amount-payment_amount);
        });






</script>
@endpush
