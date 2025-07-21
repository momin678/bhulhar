@extends('layouts.backend.app')
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
@endpush
@section('content')
@include('layouts.backend.partial.style')
    <!-- BEGIN: Content-->
<div class="app-content content print-hideen">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            @include('clientReport.business-operation.header',['activeMenu' => 'toll_fees_payment'])
            <div class="tab-content bg-white">
                <div class="tab-content bg-white">
                    <div>
                        <section id="widgets-Statistics" class="mr-1 ml-1">
                            <div class="row">
                                <div class="col-md-6  mt-2">
                                    <h4>Toll Fees Payment</h4>
                                </div>
                            </div>
                            <div class="row d-none">
                                <div class="col-12 profit-center-form">
                                    <form action="{{ route('toll-fees-payment.store') }}" method="POST">
                                            @csrf
                                        <div class="cardStyleChange">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label for="">Toll Name</label>
                                                    <select name="toll_fees_id" id="toll_fees_id" class="form-control inputFieldHeight" required>
                                                        <option value="">Select Toll</option>
                                                        @foreach ($toll_names as $item)
                                                            <option value="{{$item->id}}">{{$item->name}}</option>        
                                                        @endforeach
                                                    </select>
                                                    @error('toll_fees_id')
                                                    <div class="btn btn-sm btn-danger">{{ $message }} </div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="">Truck Number</label>
                                                    <select name="truck_id" id="truck_id" class="form-control inputFieldHeight common-select2" required>
                                                        <option value="">Select Truck Number</option>
                                                        @foreach ($trucks as $item)
                                                            <option value="{{$item->id}}">{{$item->vehicle_number}}</option>        
                                                        @endforeach
                                                    </select>
                                                    @error('truck_id')
                                                    <div class="btn btn-sm btn-danger">{{ $message }} </div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Date</label>
                                                    <input type="text" class="form-control inputFieldHeight" name="date" placeholder="dd/mm/yyyy" id="date" required>
                                                    @error('date')
                                                    <div class="btn btn-sm btn-danger">{{ $message }} </div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Description</label>
                                                    <input type="text" class="form-control inputFieldHeight" name="description" value="{{ old('description') }}" placeholder="description" required>
                                                    @error('description')
                                                    <div class="btn btn-sm btn-danger">{{ $message }} </div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4">
                                                    <label>Trip Number</label>
                                                    <input type="number" class="form-control inputFieldHeight" id="trip_number" name="trip_number" value="{{ old('trip_number') }}" placeholder="Trip number" required>
                                                    @error('trip_number')
                                                    <div class="btn btn-sm btn-danger">{{ $message }} </div>
                                                    @enderror
                                                </div>

                                                <div class="col-md-4">
                                                    <label>Rate</label>
                                                    <input type="number" id="rate" class="form-control inputFieldHeight" name="rate" value="{{ old('rate') }}" placeholder="Rate" required>
                                                    @error('amount')
                                                    <div class="btn btn-sm btn-danger">{{ $message }} </div>
                                                    @enderror
                                                </div>

                                                <div class="col-md-4">
                                                    <label>Total Amount</label>
                                                    <input type="number" id="amount" class="form-control inputFieldHeight" name="amount" value="{{ old('amount') }}" placeholder="Recharge Amount" required readonly>
                                                    @error('amount')
                                                    <div class="btn btn-sm btn-danger">{{ $message }} </div>
                                                    @enderror
                                                </div>
                                                    <div class="col-12 d-flex justify-content-end mt-1">
                                                        <button type="submit" class="btn btn-primary formButton" title="Form Save">
                                                            <div class="d-flex">
                                                                <div class="formSaveIcon">
                                                                    <img  src="{{asset('assets/backend/app-assets/icon/save-icon.png')}}" alt="" srcset="" class="img-fluid" width="25">
                                                                </div>
                                                                <div><span> Save</span></div>
                                                            </div>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </section>

                        <section class="mr-1 ml-1">
                            <div class="mt-2">
                                <div class="cardStyleChange">
                                    <table class="table mb-0 table-sm table-hover">
                                        <thead  class="thead-light">
                                            <tr style="height: 50px;">
                                                <th>Toll Name</th>
                                                <th>Payment Amount</th>
                                                <th class="text-right pr-2">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="user-table-body">
                                            @foreach ($toll_names as $item)
                                            <tr class="trFontSize">
                                                <td>{{ $item->name }}</td>
                                                <td>{{ number_format($item->invoice_toll_amount->sum('amount'),2) }}</td>
                                                <td style="padding-bottom: 11px; padding-top: 0px" class="pr-2">
                                                <div class="d-flex justify-content-end">
                                                    <a href="#" class="btn paymentView" style="height: 30px; width: 30px;" title="View" id="{{$item->id}}">
                                                        <img src="{{ asset('assets/backend/app-assets/icon/view-icon.png')}}" style=" height: 30px; width: 30px;">
                                                    </a>
                                                </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </section>
                    
                    </div>
                
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- END: Content-->
    <div class="modal fade bd-example-modal-lg" id="paymentViewPrintModal" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div id="paymentViewPrint">
              
            </div>
          </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).on('change', '#rate', function(e){
            e.preventDefault();
            var rate = $(this).val();
            var trip_number = $("#trip_number").val();
            $("#amount").val(rate*trip_number);
        });
        $(document).on('change', '#trip_number', function(e){
            e.preventDefault();
            var trip_number = $(this).val();
            var  rate= $("#rate").val();
            $("#amount").val(rate*trip_number);
        });
        $(document).on("click", ".paymentView", function(e) {
            e.preventDefault();
            var id= $(this).attr('id');
            $.ajax({
                url: "{{route('toll-fees-payment-view-modal')}}",
                type: "post",
                cache: false,
                data:{
                    _token:'{{ csrf_token() }}',
                    id:id,
                },
                success: function(response){
                    document.getElementById("paymentViewPrint").innerHTML = response;
                    $('#paymentViewPrintModal').modal('show')
                }
            });
        });

    </script>
@endpush
