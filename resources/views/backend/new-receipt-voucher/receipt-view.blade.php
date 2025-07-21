<style>
    html,
    body {
        height: 100%;
    }

    thead {
        background: #34465b;
        color: #fff !important;
        height: 30px;
    }
    .receipt-bg{
        display: none;
    }
    @media print{
        .receipt-bg{
            display: block;
        }
    }
</style>
@php
    $whole = floor($recept->total_amount);
    $fraction = number_format($recept->total_amount - $whole, 2);
    // $f = new NumberFormatter('en', NumberFormatter::SPELLOUT);
    // $amount_in_word = $f->format($whole);
    // $amount_in_word2 = $f->format($fraction);
@endphp
<section class="print-hideen border-bottom">
    <div class="d-flex flex-row-reverse">
        <div class="py-1 pr-1">
            <a href="#" class="close btn-icon btn btn-danger" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class='bx bx-x'></i></span></a>
        </div>
        <div class="py-1 pr-1"><a href="#" onclick="window.print();" class="btn btn-icon btn-secondary"><i class="bx bx-printer"></i></a></div>

        <div class="py-1 mr-1">
            <a href="{{ route('receipt-voucher-delete', $recept) }}" class="btn btn-sm btn-icon btn-danger">Delete</a>
        </div>
        @if ($recept->status == 0)
            <div class="py-1 mr-1">
                <a href="{{ route('receipt-voucher-authorize', $recept) }}" class="btn btn-sm btn-icon btn-success">Authorize</a>
            </div>
        @else
            <div class="py-1 mr-1">
                <a href="{{ route('receipt-voucher-approve', $recept) }}" class="btn btn-sm btn-icon btn-success">Approve</a>
            </div>
        @endif
        <div class="py-1 pr-1 w-100 pl-2">
            <h4>Receipt</h4>
        </div>
    </div>
</section>
<section class=" print-area-avaible">
    <div class="receipt-voucher-hearder invoice-view-wrapper" style=" border: 1px solid; margin: 0px 20px; border-radius: 20px;">
        @include('layouts.backend.partial.modal-header-info')
        <div class="d-flex justify-content-between px-2">
            <div>
                <span>Tel: {{company_tele()}}</span><br>
                <span>P.O BOX: {{company_po_box()}}</span><br>
                <span>{{company_address()}}</span><br>
                <span>Email: {{company_email()}}</span><br>
            </div>
            <div style="text-align: right;">
                <span> {{company_tele()}}: الهاتف</span><br>
                <span>صندوق بريد: 8216</span><br>
                <span>{{company_address()}}</span><br>
                <span>{{company_email()}}:  ريد إلكتروني </span><br>
            </div>
        </div>
    </div>
</section>
<section id="widgets-Statistics">
    <div class="payment-voucher px-2 pt-1 pb-4" style=" border: 1px solid; margin: 20px; border-radius: 20px;">
        <div class="row  mb-2">
            <div class="col-4">
                <table class="receipt-price">
                    <tr>
                        <td class="td-bottom-border" style="width: 60% !important;padding-bottom:0px !important">
                            <div class="d-flex justify-content-between w-100">
                                <div>Dhs.</div>
                                <div>درهم</div>
                            </div>
                        </td>
                        <td class="td-bottom-border" style="width: 40% !important;padding-bottom:0px !important">
                            <div class="d-flex justify-content-between w-100">
                                <div>Fils</div>
                                <div>فلس</div>
                            </div>
                        </td>
                    </tr>
                    <tr class="tr-border">
                        <td class="td-top-border td-right-border" >{{$whole}}</td>
                        <td class="td-top-border">{{$fraction}}</td>
                    </tr>

                </table>
            </div>
            <div class="col-4 text-center ">
                <div class="invoice-view-wrapper">
                    <h1 style="color: #313131; border-bottom: 1px solid;">سند القبض</h1>
                    <h3 style="color: #313131">RECEIPT VOUCHER</h3>
                </div>

            </div>
            <div class="col-4 d-flex align-items-center justify-content-end">
                <div class="row">
                    <div class="col-7 text-right ">
                        <strong> No:</strong>
                    </div>
                    <div class="col-5 col-left-padding">
                        <strong> {{$recept->receipt_no}}</strong>
                    </div>
                    <div class="col-7 text-right ">
                        <strong> Date:</strong>
                    </div>
                    <div class="col-5 col-left-padding">
                        <strong> {{ convert_date_format($recept->date) }}</strong>
                    </div>
                </div>
                <br><br>
            </div>
        </div>


        <div class="d-flex w-100">
            <div class="d-flex justify-content-between aligin-items-center mb-1 w-100">
                <span style="width:70px !important; color:#313131;font-size:15px;font-weight:bold; line-height:23px !important;">
                    Invoice:
                </span>
                <div class="w-100" style="border-bottom:1px dashed #111;margin-left: 15px;">
                    <p style="margin:0 !important; padding:0!important;color:#313131;font-size:15px;font-weight:500 !important; padding-left:30px">
                      @foreach ($recept->items as $r)
                        {{$r->invoice->invoice_no}}
                      @endforeach
                    </p>
                </div>

            </div>
        </div>

        <div class="d-flex justify-content-between aligin-items-center mb-1">
            <span style="width:260px !important; color:#313131;font-size:15px;font-weight:bold; line-height:23px !important;">
                Received from Mr./Ms.</span>
            <div class="w-100" style="border-bottom:1px dashed #111;">
                <p style="margin:0 !important;padding:0!important;color:#313131;font-size:15px;font-weight:500 !important; padding-left:30px">
                    {{ $recept->partyInfo->pi_name }}
                </p>
            </div>
            <span style="width:200px !important; color:#313131;font-size:15px;font-weight:bold; line-height:23px !important;">
                وردت من السيد / السيدة
            </span>
        </div>


        <div class="d-flex w-100">
            <div class="d-flex justify-content-between aligin-items-center mb-1 w-100">
                <span style="width:150px !important; color:#313131;font-size:15px;font-weight:bold; line-height:23px !important;">
                    The Sum of Dhs:
                </span>
                <div class="w-100" style="border-bottom:1px dashed #111;">
                    <p style="margin:0 !important;padding:0!important;color:#313131;font-size:15px;font-weight:500 !important; padding-left:30px;text-transform: uppercase">
                        {{-- {{ $amount_in_word }}
                        @if ($fraction > 0)
                            {{ '& ' . substr($amount_in_word2, 10) }}
                        @endif {{ $currency->symbole }} --}}
                    </p>
                </div>
                <span style="width:80px !important; color:#313131;font-size:15px;font-weight:bold; line-height:23px !important;">
                    المبلغ درهم
                </span>
            </div>
        </div>



        <div class="d-flex w-100">
            <div class="d-flex justify-content-between aligin-items-center mb-1 w-100">
                <span style="width:300px !important; color:#313131;font-size:15px;font-weight:bold; line-height:23px !important;">
                    By Cash / Cheque No:
                </span>
                <div class="w-100" style="border-bottom:1px dashed #111;">
                    <p style="margin:0 !important;padding:0!important;color:#313131;font-size:15px;font-weight:500 !important; padding-left:30px">
                        <span style="  text-transform: uppercase !important;">
                            {{ $recept->pay_mode }}
                        </span>
                    </p>
                </div>
                <span style="width:180px !important; color:#313131;font-size:15px;font-weight:bold; line-height:23px !important;">
                    نقدا / رقم الشيك
                </span>
            </div>
            <div class="d-flex justify-content-between aligin-items-center mb-1 w-100">
                <span style="width:70px !important; color:#313131;font-size:15px;font-weight:bold; line-height:23px !important;" class="pl-2">
                    Date:
                </span>
                <div class="w-100" style="border-bottom:1px dashed #111;">
                    <p style="margin:0 !important;padding:0!important;color:#313131;font-size:15px;font-weight:500 !important; padding-left:30px">
                        {{$recept->deposit_date? convert_date_format($recept->deposit_date):''}}
                    </p>
                </div>
                <span style="width:50px !important; color:#313131;font-size:15px;font-weight:bold; line-height:23px !important;">
                    تاريخ
                </span>
            </div>
        </div>

        <div class="d-flex justify-content-between aligin-items-center mb-1">
            <span style="width:50px !important; color:#313131;font-size:15px;font-weight:bold; line-height:23px !important;">
                Bank:
            </span>
            <div class="w-100" style="border-bottom:1px dashed #111;">
                <p style="margin:0 !important;padding:0!important;color:#313131;font-size:15px;font-weight:500 !important; padding-left:30px">
                    <span style="">
                        {{$recept->issuing_bank? $recept->issuing_bank:''}}
                        {{$recept->branch? ', '.$recept->branch:''}}
                        {{$recept->cheque_no? ', '.$recept->cheque_no:''}}
                    </span>
                </p>
            </div>
            <span style="width:35px !important; color:#313131;font-size:15px;font-weight:bold; line-height:23px !important;">
                بنك
            </span>
        </div>

        <div class="d-flex justify-content-between aligin-items-center mb-1">
            <span
                style="width:100px !important; color:#313131;font-size:15px;font-weight:bold; line-height:23px !important;">
                Narration</span>
            <div class="w-100" style="border-bottom:1px dashed #111;">
                <p style="margin:0 !important;padding:0!important;color:#313131;font-size:15px;font-weight:500 !important; padding-left:30px">
                    <span style="">
                        {{$recept->narration}}
                    </span>
                </p>
            </div>
            <span style="width:35px !important; color:#313131;font-size:15px;font-weight:bold; line-height:23px !important;">
                كون
            </span>
        </div>

        <div class="d-flex justify-content-between aligin-items-center mt-3">
            <div class="d-flex justify-content-between aligin-items-center mb-1 w-100">
                <span style="width:230px !important; color:#313131;font-size:15px;font-weight:bold; line-height:23px !important;">
                    Receiver's Sign
                </span>
                <div class="w-100" style="border-bottom:1px dashed #111;">
                    <p style="margin:0 !important;padding:0!important;color:#313131;font-size:15px;font-weight:500 !important; padding-left:30px">
                        <span style="  text-transform: uppercase !important;">

                        </span>
                    </p>
                </div>
                <span style="width:150px !important; color:#313131;font-size:15px;font-weight:bold; line-height:23px !important;">
                    علامة المتلقي
                </span>
            </div>
            <div class="d-flex justify-content-between aligin-items-center mb-1 w-100">
                <span style="width:100px !important; color:#313131;font-size:15px;font-weight:bold; line-height:23px !important;" class="pl-2">
                    Signature
                </span>
                <div class="w-100" style="border-bottom:1px dashed #111;">
                    <p style="margin:0 !important;padding:0!important;color:#313131;font-size:15px;font-weight:500 !important; padding-left:30px">

                    </p>
                </div>
                <span style="width:50px !important; color:#313131;font-size:15px;font-weight:bold; line-height:23px !important;">
                    إمضاء
                </span>
            </div>
        </div>

    </div>


    <div class="divFooter mb-1 ml-1 invoice-view-wrapper">
        Business Software Solutions by
        <span style="color: #0005" class="spanStyle"><img class="img-fluid" src="{{ asset('img/zisprink.png') }}" alt="" width="70"></span>
    </div>
</section>
<div class="img receipt-bg">
    <img src="{{ asset('img/finallogo.PNG') }}" class="img-fluid" style="position: fixed; top: 420px; left: 200px; opacity: 0.3; width: 650px !important; height: 250px;" alt="">

    {{-- <img src="{{ asset('img/finallogo.jpeg') }}" class="img-fluid" style="position: fixed; top:100px; left:0px; opacity:0.1;width:100%; " alt=""> --}}
</div>
