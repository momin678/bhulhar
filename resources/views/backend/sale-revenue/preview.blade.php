
<style>
    html, body {
        height:100%;
    }

    thead {
        background: #34465b;
        color: #fff !important;
        height: 30px;
    }

    @media print{
        .table tr th,
        .table tr td{
            color: #000000 !important;
            font-weight:500 !important;
        }

        #purchase-widgets-Statistics1{
            padding: 10px 15px !important;
        }
    }

</style>
<section class="print-hideen border-bottom" style="background: #364a60;">
    <div class="d-flex flex-row-reverse">
        <div class="pr-1" style="padding-top: 8px;padding-right: 22px !important;"><a href="#" class="close btn-icon btn btn-danger" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class='bx bx-x'></i></span></a></div>
        <div class="pr-1" style="padding: 8px;padding-right: 0.2rem !important;"><a href="#" onclick="handlePrintClick('purchase-widgets-Statistics1')" class="btn btn-icon btn-secondary"><i class="bx bx-printer"></i></a></div>
        @if(!$sale->approved_by)
        <div class="pr-1" style="padding-top: 8px;padding-right: 0.2rem !important;"><a href="{{route('sale.revenues.edit',$sale)}}" class="btn btn-sm btn-icon btn-success" style="padding: 6px 8px;margin-right: -8px;"><i class="bx bx-edit"></i></a></div>
        <form action="{{route('sale.revenues.destroy',$sale)}}" method="POST" class="pr-1" style="padding-top: 9px;padding-right: 0.2rem !important;">
            @method('DELETE')
            @csrf
            <button type="submit" class="btn btn-sm btn-icon btn-danger" style="padding: 6px 8px;">
                <i class="bx bx-trash"></i>
            </button>
        </form>
        @endif

        <div class="pr-1 w-100 pl-2">
            <h4 style="font-family:Cambria;font-size: 2rem;color:white;"> Invoice </h4>
        </div>
    </div>
</section>

<div class="receipt-voucher-hearder invoice-view-wrapper" style="margin: 50px 20px; border-radius: 20px;">
    @include('layouts.backend.partial.modal-header-info')
</div>

<section id="purchase-widgets-Statistics1" class="print-page">
    <div class="row">

        <div class="col-md-12 text-center invoice-view-wrapper student_profle-print my-1">
            <h2> Invoice </h2>
        </div>

        <div class="col-md-12">
            <div class="">
                <div class="mx-2 mb-2 pt-2">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-12">
                                    <strong>Customer Info :</strong> {{ $sale->party->pi_name}}
                                </div>
                                @if( $sale->party->address)
                                <div class="col-3">
                                    <strong>Address:</strong> {{ $sale->party->address}}
                                </div>
                                @endif

                                @if( $sale->party->address)
                                <div class="col-3">
                                    <strong>Contact No:</strong> {{ $sale->party->con_no}}
                                </div>
                                @endif

                                <div class="col-3">
                                    <strong>Date:</strong>{{ \Carbon\Carbon::parse($sale->date)->format('d/m/Y') }}
                                </div>

                                <div class="col-3">
                                    <strong>Payment Mode:</strong> {{ $sale->pay_mode}}
                                </div>

                                {{-- <div class="col-3">
                                    <strong>Invoice No:</strong> {{ $sale->invoice_no}}
                                </div> --}}
                                <div class="col-3">
                                    <strong>Invoice No:</strong> {{ $sale->sale_no}}
                                </div>

                                <div class="col-3">
                                    <strong>Amount:</strong> @if(!empty($currency->symbole)){{$currency->symbole}}@endif {{ $sale->total_amount}}
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
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered border-botton">
                            <thead class="thead">
                                <tr >
                                    <th> Account Head </th>
                                    <th> Vehicle No </th>
                                    <th class="text-right pr-1"> Qty </th>
                                    <th class="text-right pr-1"> Amount</th>
                                    <th class="text-right pr-1"> Taxable </th>
                                    <th class="text-right pr-1"> Vat</th>
                                    <th class="text-right pr-1"> Total Amount <small>(@if(!empty($currency->symbole)){{$currency->symbole}}@endif)</small></th>
                                </tr>
                            </thead>

                            <tbody class="user-table-body">
                                @foreach ($sale->items as $item)
                                <tr>
                                    <td class="text-center">{{optional($item->head)->fld_ac_head}}</td>
                                    <td class="pl-1 text-center">{{optional($item->vehicle)->vehicle_number}}</td>
                                    <td class="text-right  pr-1">{{intval($item->qty)}}</td>
                                    <td class="text-right  pr-1">{{$item->rate}}</td>
                                    <td class="text-right  pr-1">{{$item->amount}}</td>
                                    <td class="text-right  pr-1">{{$item->vat_amount}}</td>
                                    <td class="text-right  pr-1">{{$item->total_amount}}</td>
                               </tr>

                                @endforeach
                                <tr>
                                    <td colspan="5" rowspan="5" class="px-1"><strong>Narration: {{$sale->narration}}</strong></td>
                                    <td  class="text-right pr-1"> Total Amount </td>
                                    <td  class="text-right pr-1">{{$sale->amount}}</td>
                                  </tr>

                                  <tr>

                                    <td  class="text-right pr-1"> VAT </td>
                                    <td  class="text-right pr-1">{{$sale->vat_amount}}</td>
                                  </tr>
                                  <tr style="border-bottom: 1px solid #dfe3e7;">

                                    <td  class="text-right pr-1"> Total Amount </td>
                                    <td  class="text-right bordered pr-1">{{$sale->total_amount}}</td>
                                  </tr>
                                  <tr style="border-bottom: 1px solid #dfe3e7;">

                                    <td  class="text-right pr-1"> Paid Amount </td>
                                    <td  class="text-right bordered pr-1">{{$sale->paid_amount}}</td>
                                  </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section>
        <div class="row pt-4 print-none">
            <div class="col-12 text-center">
                <h3> Supporting Document </h3>
            </div>
            @if (($sale->voucher_scan != '') && ($sale->voucher_scan2 != '') )
            <div class="col-6 text-center">
                <img src="{{asset('storage/upload/documents')}}/{{$sale->voucher_scan}}" class="img-fluid" style="width: 490px" alt="">
            </div>
            <div class="col-6 text-center">
                <img src="{{asset('storage/upload/documents2')}}/{{$sale->voucher_scan2}}" class="img-fluid" style="width: 490px" alt="">
            </div>
            @elseif(($sale->voucher_scan != '') && ($sale->voucher_scan2 == ''))
            <div class="col-12 text-center">
                <img src="{{asset('storage/upload/documents')}}/{{$sale->voucher_scan}}" class="img-fluid" style="width: 490px" alt="">

            </div>
            @elseif(($sale->voucher_scan == '') && ($sale->voucher_scan2 != ''))
            <div class="col-12 text-center">
                <img src="{{asset('storage/upload/documents2')}}/{{$sale->voucher_scan2}}" class="img-fluid" style="width: 490px" alt="">
            </div>
            @endif

            @if(!$sale->approved_by)
            <div class="col-md-12 text-center mt-2">
                <a href="{{ route('authorize-payment-voucher', ['type' => 'sale-invoice', 'id' => $sale->id]) }}" class="btn btn-info btn-sm" onclick="return confirm('about to approval purchase. Please, Confirm?')"> Approved </a>
            </div>
            @endif
        </div>
    </section>


    <div class="divFooter mb-1 ml-1 footer-margin print-none">
        Business Software Solutions by
        <span style="color: #0005" class="spanStyle"><img class="img-fluid" src="{{ asset('img/zisprink.png')}}" alt="" width="70"></span>
    </div>
</section>


