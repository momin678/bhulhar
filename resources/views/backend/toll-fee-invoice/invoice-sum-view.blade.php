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
                                    <h4 class="flex-grow-1">Toll Fee Invoice Summary</h4>
                                </div>
                                <form action="{{ route('save-customer-invoice')}}" method="POST" onsubmit="return confirm('Please, cornfirm?')">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Customer Name</label>
                                                <input type="text" class="inputFieldHeight form-control" value="{{$toll_invoice->customer->pi_name}}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Project Name</label>
                                                <input type="text" class="inputFieldHeight form-control" value="{{$toll_invoice->project->proj_name}}" readonly>
                                            </div>
                                        </div>
                                        {{-- <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Cost Center</label>
                                                <input type="text" class="inputFieldHeight form-control" value="{{$toll_invoice->customer->pi_name}}"readonly>
                                            </div>
                                        </div> --}}
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Payment Mode </label>
                                                <input type="text" class="inputFieldHeight form-control" value="{{$toll_invoice->pay_mode}}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Date</label>
                                                <input type="text" class="inputFieldHeight form-control" name="date" value="{{date('d/m/Y', strtotime($toll_invoice->date))}}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive">

                                        <table class="table mb-0 table-sm table-hover">
                                            <thead  class="thead-light">
                                                <tr style="height: 50px;">
                                                    <th>SL. No</th>
                                                    <th >Destination</th>
                                                    <th >Source</th>
                                                    <th >TKT Number</th>
                                                    <th class="text-right pr-1">Total Toll Fee</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-sm">
                                                @php $i = 1; @endphp
                                                @foreach ($toll_items as  $key => $item)

                                                    @if ($toll_items->sum('amount')>0)
                                                        <tr>
                                                            <td>{{$i}}</td>
                                                            <td>{{$item->destination}}</td>
                                                            <td >{{$item->source}}</td>
                                                            <td >{{$item->truck_record->tkt_number}}</td>
                                                            <td class="text-right pr-1">{{$item->amount}}</td>
                                                        </tr>
                                                        @php $i++; @endphp
                                                    @endif
                                                @endforeach
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="text-right pr-1">Total Toll Fee:</td>
                                                    <td class="text-right pr-1">{{$toll_invoice->amount}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </form>

                            </div>

                            <p class="text-center">
                                <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
                                <a href="{{ route('toll-fee-invoice-sum-print', $toll_invoice->id)}}" target="_blank" class="btn btn-info">Print</a>
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
