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
                                    <h4 class="flex-grow-1">Invoice Details</h4>
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
                                <form action="#" method="POST" onsubmit="return confirm('Please, cornfirm?')">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Customer Name</label>
                                                <input type="text" class="inputFieldHeight form-control" value="{{ $invoice->customer?$invoice->customer->pi_name :''}}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Project Name</label>
                                                <input type="text" class="inputFieldHeight form-control" value="{{$invoice->project?$invoice->project->proj_name:''}}" readonly>
                                            </div>
                                        </div>
                                        {{-- <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Cost Center</label>
                                                <input type="text" class="inputFieldHeight form-control" value="{{ $invoice->customer?$invoice->customer->pi_name :''}}"readonly>
                                            </div>
                                        </div> --}}
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Payment Mode </label>
                                                <input type="text" class="inputFieldHeight form-control" value="{{$invoice->pay_mode}}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Date</label>
                                                <input type="text" class="inputFieldHeight form-control" name="date" value="{{date('d/m/Y', strtotime($invoice->date))}}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 form-group pay-term">
                                            <label for="">Payment Terms</label>
                                            <select name="pay_terms" id="pay_terms" class="common-select2" style="width: 100% !important"
                                                disabled>
                                                <option value="">Select...</option>
                                                @foreach ($terms as $item)
                                                    <option value="{{ $item->value }}" {{ $item->value==$invoice->pay_tems? 'selected':'' }}>{{ $item->title }}
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
                                                <input type="text"  class="inputFieldHeight form-control" name="lpo_number" value="{{ $invoice->lpo_number }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        @isset($invoice)
                                        @php
                                            $invoice_total= $invoice->amount+$invoice->vat_amount;
                                        @endphp
                                        @if ($invoice_total<10000)

                                        <table class="table mb-0 table-sm table-hover">
                                            <thead  class="thead-light">
                                                <tr style="height: 50px;">
                                                    <th>SL No.</th>
                                                    <th>Date</th>
                                                    <th>Truck</th>
                                                    <th>Destination</th>
                                                    <th class="text-right pr-1">QTY</th>
                                                    <th class="text-right pr-1">Rate</th>
                                                    <th class="text-right pr-1">Amount</th>

                                                </tr>
                                            </thead>
                                            <tbody class="table-sm">

                                                @foreach ($invoice->items as $item)
                                                <tr class="trFontSize t-row">
                                                    <td>{{$loop->index+1}}</td>
                                                    <td>{{date('d/m/Y', strtotime($item->date))}}</td>
                                                    <td>{{$item->truck?$item->truck->vehicle_number:''}}</td>
                                                    <td>{{$item->description}}</td>
                                                    <td class="text-right pr-1">{{$item->qty}}</td>
                                                    <td class="text-right pr-1">{{$item->rate}}</td>
                                                    <td class="text-right pr-1">{{$item->amount}}</td>
                                                </tr>
                                                @endforeach
                                                <tr class="trFontSize">
                                                    <td colspan="6" class="text-right pr-1">Total Quatity</td>
                                                    <td class="text-right pr-1">{{ number_format($invoice->items->sum('qty'), 2)}}</td>
                                                    <td></td>
                                                </tr>
                                                <tr class="trFontSize">
                                                    <td colspan="6" class="text-right pr-1">Total VAT</td>
                                                    <td class="text-right pr-1">{{ $invoice->vat_amount}}</td>
                                                    <td></td>
                                                </tr>
                                                <tr class="trFontSize">
                                                    <td colspan="6" class="text-right pr-1">Total</td>
                                                    <td class="text-right pr-1">{{ $invoice->vat_amount+$invoice->amount}}</td>
                                                    <td></td>
                                                </tr>
                                                <tr class="trFontSize">
                                                    <td colspan="6" class="text-right pr-1">Payment Applied</td>
                                                    <td class="text-right pr-1">{{ $invoice->paid_amount}}</td>
                                                    <td></td>
                                                </tr>
                                                <tr class="trFontSize">
                                                    <td colspan="6" class="text-right pr-1">Balance Due</td>
                                                    <td class="text-right pr-1">{{ $invoice->due_amount}}</td>
                                                    <td></td>
                                                </tr>


                                            </tbody>
                                        </table>
                                        @else
                                        <table class="table mb-0 table-sm table-hover">
                                            <thead  class="thead-light">
                                                <tr style="height: 50px;">
                                                    <th>SL No.</th>
                                                    <th>Date</th>
                                                    <th>Truck</th>
                                                    <th>Description</th>
                                                    <th class="text-right pr-1">QTY</th>
                                                    <th class="text-right pr-1">Rate</th>
                                                    <th class="text-right pr-1">Amount</th>
                                                    <th class="text-right pr-1">Tax Rate</th>
                                                    <th class="text-right pr-1">Tax Amount</th>
                                                    <th class="text-right pr-1">Total Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-sm">

                                                @foreach ($invoice->items as $item)

                                                <tr class="trFontSize t-row">
                                                    <td>{{$loop->index+1}}</td>
                                                    <td>{{date('d/m/Y', strtotime($item->date))}}</td>
                                                    <td>{{$item->truck?$item->truck->vehicle_number:''}}</td>
                                                    <td>{{$item->description}}</td>
                                                    <td>{{$item->qty}}</td>
                                                    <td>{{$item->rate}}</td>
                                                    <td>{{$item->amount}}</td>
                                                    <td>{{floatval($item->vat_rate)}}</td>
                                                    <td>{{$item->vat_amount}}</td>
                                                    <td>{{$item->amount + $item->vat_amount}}</td>


                                                </tr>
                                                @endforeach
                                                <tr class="trFontSize">
                                                    <td colspan="9" class="text-right pr-1">Total Quantity: </td>
                                                    <td>{{ number_format($invoice->items->sum('qty'),2)}}</td>
                                                    {{-- <td></td> --}}
                                                </tr>
                                                <tr class="trFontSize">
                                                    <td colspan="9" class="text-right pr-1">Total VAT: </td>
                                                    <td>{{ $invoice->vat_amount}}</td>
                                                    {{-- <td></td> --}}
                                                </tr>
                                                <tr class="trFontSize">
                                                    <td colspan="9" class="text-right pr-1">Total: </td>
                                                    <td>{{ $invoice->vat_amount+$invoice->amount}}</td>
                                                    {{-- <td></td> --}}
                                                </tr>
                                                <tr class="trFontSize">
                                                    <td colspan="9" class="text-right pr-1">Payment Applied: </td>
                                                    <td>{{ $invoice->paid_amount}}</td>
                                                    {{-- <td></td> --}}
                                                </tr>
                                                <tr class="trFontSize">
                                                    <td colspan="9" class="text-right pr-1">Balance Due: </td>
                                                    <td>{{ $invoice->due_amount}}</td>
                                                    {{-- <td></td> --}}
                                                </tr>


                                            </tbody>
                                        </table>
                                        @endif

                                        @endisset


                                    </div>
                                </form>

                            </div>
                            <p class="text-center">
                                <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
                                <a href="{{route('draft-invoice-submit', $invoice->id)}}" class="btn btn-primary">Submit</a>
                                <a href="{{ route('draft-invoice-print', $invoice->id)}}" target="_blank" class="btn btn-secondary">Print</a>
                            </p>
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
