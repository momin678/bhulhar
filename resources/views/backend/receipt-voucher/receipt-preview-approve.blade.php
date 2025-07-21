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
    $company_name= \App\Setting::where('config_name', 'company_name')->first();
    $company_address= \App\Setting::where('config_name', 'company_address')->first();
    $company_tele= \App\Setting::where('config_name', 'company_tele')->first();
    $company_email= \App\Setting::where('config_name', 'company_email')->first();
    $trn_no= \App\Setting::where('config_name', 'trn_no')->first();
    $whole = floor($recept->total_amount);
    $fraction = number_format($recept->total_amount - $whole, 2);
    $f = new NumberFormatter('en', NumberFormatter::SPELLOUT);
    $amount_in_word = $f->format($whole);
    $amount_in_word2 = $f->format((int)($fraction*100));
    $invoice_log= \App\Setting::where('config_name', 'invoice_img')->first();

@endphp
<section class="print-hideen border-bottom" style="padding: 5px 15px;background:#364a60;">
    <div class="d-flex flex-row-reverse" style="padding-right: 10px;">
        <div class="" style="margin-top: 6px;">
            <a href="#" class="close btn-icon btn btn-danger" data-dismiss="modal" aria-label="Close" title="Close"><span aria-hidden="true"><i class='bx bx-x'></i></span></a>
        </div>
        <div class="" style="padding-right: 3px;margin-top: 6px;"><a href="#" onclick="handlePrintClick('recipet-voucher')" class="btn btn-icon btn-success" title="Print"><i class="bx bx-printer"></i></a></div>

        <div class="w-100">
            <h4 style="font-family:Cambria;font-size: 2rem;color:white;">Receipt</h4>
        </div>
    </div>
</section>
{{-- <section>
    <div class="receipt-voucher-hearder invoice-view-wrapper" style=" border: 1px solid; margin: 50px 20px; border-radius: 20px;">
        @include('layouts.backend.partial.modal-header-info')
    </div>
</section> --}}
<div id="recipet-voucher">
    <section id="widgets-Statistics">
        <div class="payment-voucher px-2 pt-1 pb-4" style=" border: 1px solid; margin: 10px 5px; border-radius: 10px;">
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
                            <td class="td-top-border">{{$fraction*100}}</td>
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
                            <strong> No.:</strong>
                        </div>
                        <div class="col-5 col-left-padding">
                            <strong> {{$recept->receipt_no}}</strong>
                        </div>
                        <div class="col-7 text-right ">
                            <strong> Date</strong>
                        </div>
                        <div class="col-5 col-left-padding">
                            <strong> {{ date('d/m/Y', strtotime($recept->date)) }}</strong>
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
                            @if ($recept->receipt_from == 'sale-revenue')
                            {{$r->sale_revenue?$r->sale_revenue->invoice_no:''}}
                            @else
                            {{$r->invoice?$r->invoice->invoice_no:''}}
                            @endif

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
                        {{ $recept->name==null?  $recept->party->pi_name : $recept->name}}
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
                            {{ $amount_in_word }} Dirhams
                            @if ($fraction > 0)
                                {{ '& ' . $amount_in_word2 }}
                            @else
                                No
                            @endif Fils
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
                           @if ($recept->pay_mode=='Cheque')
                           {{$recept->deposit_date? date('d/m/Y',strtotime($recept->deposit_date)):''}}
                           @endif
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
                            @if ($recept->pay_mode=='Cheque')
                            {{$recept->issuing_bank? $recept->issuing_bank:''}}
                            {{$recept->branch? ', '.$recept->branch:''}}
                            {{$recept->cheque_no? ', '.$recept->cheque_no:''}}
                            @endif


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

        <div class="container mt-1 print-hide print-none">
            <h5 class="mb-2 fw-bold text-center">Support Documents </h5>
            @if($recept->voucher_file)
            @php
                $imageExtensions = ['png', 'jpeg', 'gif', 'jpg'];
                $pdfExtensions = ['pdf'];
            @endphp


            @if(in_array($recept->extension, $pdfExtensions))

            {{-- <div class="row justify-content-center">
                <a href="{{ Storage::url('upload/documents/' . $recept->voucher_file) }}">
                <div class="col-auto">
                    <img src="{{asset('icon/pdf-download-icon-2.png')}}" alt="Image" class="img-fluid">
                </div>
                </a>
            </div> --}}

            <div class="row justify-content-center">
            <a href="{{ Storage::url('upload/documents/' . $recept->voucher_file) }}" target="_blank">View
                <img src="{{asset('icon/pdf-download-icon-2.png')}}" alt="Image" class="img-fluid" style="height: 50px"></a>
            {{-- <iframe src="{{ Storage::url('upload/documents/' . $recept->voucher_file) }}" width="100%" height="600px" frameborder="0"></iframe> --}}
            </div>
            @else
            <div class="row justify-content-center">
                <div class="col-auto">
                   <a href="{{ asset('storage/upload/documents/' . $recept->voucher_file) }}" target="_blank"> <img src="{{ asset('storage/upload/documents/' . $recept->voucher_file) }}" alt="Image" class="img-fluid" ></a>
                </div>
            </div>
            @endif
            @endif
        </div>


        <div class="divFooter mb-1 ml-1 invoice-view-wrapper print-none">
            Business Software Solutions by
            <span style="color: #0005" class="spanStyle"><img class="img-fluid" src="{{ asset('img/zisprink.png') }}" alt="" width="70"></span>
        </div>
    </section>
    <div class="img receipt-bg">
        <img src="{{ asset('storage/upload/settings/' . $invoice_log->config_value) }}" class="img-fluid" style="position: fixed; top: 200px; left: 150px; opacity: 0.1; width: 700px !important; height: 500px;" alt="">
    </div>
</div>
