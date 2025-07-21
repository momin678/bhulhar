@extends('layouts.backend.app')
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
    <style>    
        thead {
            background: #34465b;
            color: #fff !important;
        }
        th{
            color: #fff !important;
            font-size: 11px !important;
            height: 25px !important;
            text-align: center !important;
        }
        td
        {
            font-size: 12px !important;
            height: 25px !important;
        }
    </style>
@endpush
@section('content')
@include('layouts.backend.partial.style')

    <div class="app-content content print-hidden">
        <div class="content-overlay"></div>
        <div class="content-wrapper">

            <div class="content-body">
                
                @include('clientReport.purchase._header',['activeMenu' => 'purchase_expense'])
                <div class="tab-content">
                    <div class="tab-pane bg-white active">
                        <div class="py-1 px-2">
                            @include('backend.purchase.bottom-header', ['activeMenu' => 'authorize',])
                        </div>
                        <section id="widgets-Statistics">
                            
                            <div class="mx-1">
                                <div class="cardStyleChange">
                                    <table class="table table-bordered table-sm ">
                                        <thead class="user-table-body">
                                            <tr>
                                                <td>Purchase No</td>
                                                <td>Date</td>
                                                <td>Supplier Name</td>
                                                <td>Invoice</td>
                                                <td>Pay Mode</td>
                                                <td>Amount</td>
                                                <td>Vat</td>
                                                <td>Total Amount</td>
                                                <td>Action</td>
                                            </tr>
                                        </thead>
                                        <tbody class="user-table-body">
                                            @foreach ($purchases as $purchase)
                                                <tr>
                                                    <td>{{$purchase->purchase_no}}</td>
                                                    <td>{{convert_date_format($purchase->date)}}</td>
                                                    <td>{{$purchase->partInfo->pi_name}}</td>
                                                    <td>{{$purchase->supplier_invoice}}</td>
                                                    <td>{{$purchase->pay_mode}}</td>
                                                    <td>{{$purchase->amount}}</td>
                                                    <td>{{$purchase->vat_amount}}</td>
                                                    <td>{{$purchase->total_amount}}</td>
                                                    <td>
                                                        <a href="#" class="btn purchase-view" title="View" id="{{$purchase->id}}" style="margin-right:-10px; padding-top: 1px; padding-bottom: 1px; height: 25px; width: 25px;">
                                                            <img src="{{asset('assets/backend/app-assets/icon/view-icon.png')}}" alt="" srcset="" style="margin-left: -12px; height: 25px; width: 25px;">
                                                        </a>
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


    <div class="modal fade bd-example-modal-lg"  id="purchase_previewModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div id="purchase_preview">
    
            </div>
          </div>
        </div>
      </div>
    <!-- End Modal -->
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
    {{-- <script src="{{ asset('assets/backend/app-assets/vendors/js/jquery/jquery.min.js') }}"></script> --}}
<script>
    
    $(document).on("click", ".purchase-view", function(e) {
        console.log(12);
        var purchase_id = $(this).attr('id');
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: "{{ route('temp-purchase-view') }}",
            method: "POST",
            data: {
                purchase_id: purchase_id,
                _token: _token,
            },
            success: function(response) {
                document.getElementById("purchase_preview").innerHTML = response;
                $('#purchase_previewModal').modal('show');
            }
        })
    });
</script>

@endpush



