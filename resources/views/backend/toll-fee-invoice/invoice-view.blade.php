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
                            <form action="{{route('toll-fee-invoice-confirm')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="temp_invoice_id" value="{{$toll_invoice->id}}">
                                <div class="cardStyleChange p-2">
                                    <div class="d-flex">
                                        <h4 class="flex-grow-1">Toll Invoice Details</h4>
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
                                                <input type="text" class="inputFieldHeight form-control" value="{{$toll_invoice->project->proj_name}}" readonly dis>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Payment Mode</label>
                                                <select name="pay_mode" id="pay_mode" class="inputFieldHeight form-control common-select2" required {{$toll_setup->value=='Automatic'?'disabled':''}}>
                                                    @foreach ($pay_modes as $pay_mode)
                                                        @if ($pay_mode->title != 'Credit')
                                                            <option value="{{$pay_mode->title}}">{{ $pay_mode->title}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
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
                                                    <th>Truck No</th>
                                                    <th>Date</th>
                                                    <th>Destination</th>
                                                    <th>Source</th>
                                                    <th>TKT Number</th>
                                                    <th class="text-right pr-1">Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-sm">
                                                @foreach ($toll_items as $item)
                                                    <tr class="trFontSize t-row">
                                                        <td>{{$item->truck_record->truck->vehicle_number}}</td>
                                                        <td>{{date('d/m/Y', strtotime($item->date))}}</td>
                                                        <td>{{$item->destination}}</td>
                                                        <td>{{$item->source}} </td>
                                                        <td>{{$item->truck_record->tkt_number}}</td>
                                                        <td class="text-right pr-1">{{$item->amount}}</td>
                                                    </tr>
                                                @endforeach
                                                <tr>
                                                    <td class="text-right" colspan="5">Total Amount:</td>
                                                    <td class="text-right pr-1">{{$toll_items->sum('amount')}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <p class="text-center">
                                    <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
                                    @if ($toll_invoice->status == 'Draft')
                                    <button type="submit" class="btn btn-primary" title="Save" onclick="return confirm('Please Confirm ?')">
                                        <div class="d-flex">
                                            <div class="formSaveIcon">
                                                <img src="{{asset('assets/backend/app-assets/icon/save-icon.png')}}" width="25">
                                            </div>
                                            <div><span>Submit</span></div>
                                        </div>
                                    </button>
                                    {{-- <a href="{{ route('toll-fee-invoice-confirm', $toll_invoice->id)}}" class="btn btn-success">Confirm</a> --}}
                                    @endif
                                </p>
                            </form>
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
