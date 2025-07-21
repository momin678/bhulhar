@php
    $invoice_log= \App\Setting::where('config_name', 'invoice_img')->first();
@endphp

<section class="print-hideen border-bottom" style="padding: 5px 15px;background:#364a60;">
    <div class="row pl-2">
        <div class="col-md-6 pl-1"> <h3 style="font-family:Cambria;font-size: 2rem;color:white;">Receivable History</h3></div>
        <div class="col-md-6">
            <div class="d-flex flex-row-reverse" style="padding-right: 8px;padding-top: 6px;">
                <div class=""><a href="#" class="close btn-icon btn btn-danger" data-dismiss="modal" aria-label="Close" style="padding-bottom: 8px;"><span aria-hidden="true"><i class='bx bx-x'></i></span></a></div>
                <div class="" style="padding-right: 3px;">
                    <a href="#" onclick="handlePrintClick('widgets-Statistics1')" class="btn btn-icon btn-success"><i class="bx bx-printer"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="widgets-Statistics1">
    <div class="row">
        <div class="col-12 text-center mb-2">
            <h3> Receivable History </h3>
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
                        $t_balance=0
                    @endphp
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm " >
                            <thead>
                                <tr >
                                    <th style="width: 5%">#</th>
                                    <th>Date</th>
                                    <th>Invoice</th>
                                    <th>Amount <small>( @if(!empty($currency->symbole)){{$currency->symbole}}@endif)</small></th>
                                    <th>Invoice_balance</th>
                                    <th>Total Balance <small>( @if(!empty($currency->symbole)){{$currency->symbole}}@endif)</small></th>
                                </tr>
                            </thead>
                            @foreach ($invoices as $inv)
                            <tr id="TRow" style="border-top:2px solid black">
                                <td>{{++$c}}</td>
                                <td>{{date('d/m/Y',strtotime($inv->date))}}</td>
                                <td>
                                    {{$inv->invoice_no}}
                                </td>
                                <td>
                                    {{$inv->total_amount}}
                                </td>
                                <td>
                                    {{$balance=$inv->total_amount}}
                                </td>
                                <td>{{number_format($t_balance=$t_balance+$balance,2,'.','')}}</td>
                            </tr>
                            @if ($inv->receipts->count()>0)
                                @foreach ($inv->receipts as $rcpt)
                                <tr>
                                    <td colspan="2" style="border:none; background-color:#fff !important"></td>
                                    <td>
                                        <table class="table table-sm m-0">
                                            <tr>
                                                <td style="width: 30% !important">{{date('d/m/Y',strtotime($rcpt->payment->date))}}</td>
                                                <td>{{$rcpt->payment->receipt_no}}</td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>{{$rcpt->Total_amount}}</td>
                                    <td>{{number_format($balance=$balance-$rcpt->Total_amount,2,'.','')}}</td>
                                    <td>{{number_format($t_balance=$t_balance-$rcpt->Total_amount,2,'.','')}}  </td>
                                </tr>
                                @endforeach
                            @endif
                            @endforeach
                            @php
                            $c=0;
                            $t_balance=0
                            @endphp
                            @foreach ($sale_invoices as $inv)
                            <tr id="TRow" style="border-top:2px solid black">
                                <td>{{++$c}}</td>
                                <td>{{date('d/m/Y',strtotime($inv->date))}}</td>
                                <td>
                                    {{$inv->invoice_no}}
                                </td>
                                <td>
                                    {{$inv->total_amount}}
                                </td>
                                <td>
                                    {{$balance =$inv->total_amount}}
                                </td>
                                <td>{{number_format($t_balance=$t_balance+$balance,2,'.','')}}</td>
                            </tr>

                            @if ($inv->receipts->count()>0)
                                @foreach ($inv->receipts as $rcpt)
                                <tr>
                                    <td colspan="2" style="border:none; background-color:#fff !important"></td>
                                    <td>
                                        <table class="table table-sm m-0">
                                            <tr>
                                                <td style="width: 30% !important">{{date('d/m/Y',strtotime($rcpt->payment->date))}}</td>
                                                <td>{{$rcpt->payment->receipt_no}}</td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>{{$rcpt->Total_amount}}</td>
                                    <td>{{number_format($balance=$balance-$rcpt->Total_amount,2,'.','')}}</td>
                                    <td>{{number_format($t_balance=$t_balance-$rcpt->Total_amount,2,'.','')}}  </td>
                                </tr>
                                @endforeach
                            @endif

                            @endforeach
                            <tr>
                                <td colspan="4"></td>
                                <td class="text-center" style="color: black">Total Due</td>
                                <td style="color: black">
                                    {{number_format($invoices->sum('due_amount') + $sale_invoices->sum('due_amount'),2,'.','')}}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="divFooter  ml-1 invoice-view-wrapper footer-margin print-none">
        Business Software Solutions by
        <span style="color: #0005" class="spanStyle"><img class="img-fluid" src="{{ asset('img/zisprink.png')}}" alt="" width="70"></span>
    </div>
</section>


<div class="img receipt-bg invoice-view-wrapper">
    <img src="{{ asset('storage/upload/settings/' . $invoice_log->config_value) }}" class="img-fluid" style="position: fixed; top: 200px; left: 150px; opacity: 0.1; width: 700px !important; height: 500px;" alt="">

    {{-- <img src="{{ asset('img/finallogo.jpeg') }}" class="img-fluid" style="position: fixed; top:100px; left:0px; opacity:0.1;width:100%; " alt=""> --}}
</div>

