@php
        $invoice_log= \App\Setting::where('config_name', 'invoice_img')->first();

@endphp
<section class="print-hideen border-bottom" style="background: #364a60;">
    <div class="row pl-2">
        <div class="col-8 pl-1"><h3 style="font-family:Cambria;font-size: 2rem;color:white;">Payable History</h3></div>
        <div class="col-4">
            <div class="d-flex flex-row-reverse" style="padding-right: 8px;padding-top: 6px;">
                <div class="pr-1"><a href="#" class="close btn-icon btn btn-danger" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class='bx bx-x'></i></span></a></div>
                <div class="" style="padding-right: 3px;"><a href="#" onclick="handlePrintClick('widgets-Statistics1')" class="btn btn-icon btn-success"><i class="bx bx-printer"></i></a></div>
            </div>
        </div>
    </div>

</section>
{{-- <div style="margin: 70px 20px;">
    @include('layouts.backend.partial.modal-header-info')
</div> --}}
<section id="widgets-Statistics1">
    <div class="row ">
        <div class="col-12 text-center">
            <h3>Payable History</h3>
        </div>
        <div class="col-md-12">
            <div class="">
                <div class="mx-2 mb-2">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-3">
                                    <strong>Party Name:</strong> {{ $info->pi_name}}
                                </div>
                                <div class="col-3">
                                    <strong>Address:</strong> {{ $info->address}}
                                </div>
                                <div class="col-3">
                                    <strong>Attention:</strong> {{ $info->con_person}}
                                </div>
                                <div class="col-3">
                                    <strong>Contact No:</strong> {{ $info->con_no}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="border-botton">
                <div class="mx-2">
                    @php
                        $c=0;
                    @endphp
                    <div class="table-responsive">

                        @php
                        $c=0;
                        @endphp
                        <table class="table table-bordered table-sm " >
                        <thead>
                            <tr >
                                <th style="min-width: 50px;">SL No</th>
                                <th style="min-width: 80px;">Date</th>
                                <th style="min-width:110px;width: 28%">Purchase</th>
                                <th style="min-width:120px; width: 28%">Total Amount </th>
                                <th  style="min-width:120px; width: 28%">Due Amount </th>
                            </tr>
                        </thead>
                        @foreach ($expenses as $item)
                        <tr id="TRow" >
                            <td>{{++$c}}</td>
                            <td>{{date('d/m/Y',strtotime($item->date))}}</td>
                            <td>
                                {{$item->purchase_no}}
                            </td>
                            <td>
                                {{number_format($item->total_amount,2)}}
                            </td>
                            <td>
                                {{number_format($item->due_amount,2)}}
                            </td>
                        </tr>
                        @endforeach
                        @foreach ($suppliers as $item)
                        <tr id="TRow" >
                            <td>{{++$c}}</td>
                            <td>{{date('d/m/Y',strtotime($item->date))}}</td>
                            <td>
                                {{$item->invoice_no}}
                            </td>
                            <td>
                                {{number_format($item->amount+ $item->vat_amount,2)}}
                            </td>
                            <td>
                                {{number_format($item->due_amount,2)}}
                            </td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="3"></td>
                            <td class="text-center" style="color: black">Total Due <small>( @if(!empty($currency->symbole)){{$currency->symbole}}@endif)</small> </td>
                            <td>{{number_format($expenses->sum('due_amount')+$suppliers->sum('due_amount'),2,'.','')}}</td>
                        </tr>
                        </table>

                    </div>
                </div>
            </div>
        </div>

    </div>



    <div class="divFooter  ml-1  footer-margin print-none">
        Business Software Solutions by
        <span style="color: #0005" class="spanStyle"><img class="img-fluid" src="{{ asset('img/zisprink.png')}}" alt="" width="70"></span>
    </div>
</section>


<div class="img receipt-bg invoice-view-wrapper">
    <img src="{{ asset('storage/upload/settings/' . $invoice_log->config_value) }}" class="img-fluid" style="position: fixed; top: 200px; left: 150px; opacity: 0.1; width: 700px !important; height: 500px;" alt="">

    {{-- <img src="{{ asset('img/finallogo.jpeg') }}" class="img-fluid" style="position: fixed; top:100px; left:0px; opacity:0.1;width:100%; " alt=""> --}}
</div>





