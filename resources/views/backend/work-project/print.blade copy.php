<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend') }}/app-assets/css/bootstrap.css">
        <link rel="stylesheet" href="{{ asset('css/print.css') }}">

    <style>
        body {
            margin: 0;
            padding: 0;
            background: #fff !important;
        }

        .customer-static-content {
            background: #ada8a81c;
        }

        .customer-dynamic-content {
            background: #706f6f33;
        }

        .customer-dynamic-content2{
            background: #fff !important;
        }
        .customer-content{
            border: 1px solid black !important;
        }
        th, td{
            color: black !important;
        }


        @media print {

.headerGroup:after {
    opacity: .1;
    padding-bottom: 10px !important;
}
.content ,.content-wrapper{
    padding: 0 !important;
    margin: 0 !important;
    background-color: #fff;
}
.header, .header-block {
    height: 150px;
    background-color: #fff;
    padding: 0;
    margin: 0;
    margin-bottom: 10px;
}
.footer, .footer-block {
    height: 150px !important;
    background-color: none;
}
footer {
    page-break-after: always;
    height: 30px !important;
}


}
    </style>

    <title>Invoice</title>
</head>

<body onload="window.print();">

    @php
    $trn_no = \App\Setting::where('config_name', 'trn_no')->first()->config_value;
    $company_name= \App\Setting::where('config_name', 'company_name')->first();
@endphp
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <table width="100%">
            <thead>
                <tr>
                    <td class="headerGroup">
                        <div class="header-block">
                            {{-- print header --}}
                        </div>
                    </td>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <td class="footerGroup">
                        <div class="footer-block">
                            {{-- print footer --}}
                        </div>
                    </td>
                </tr>
            </tfoot>
            <tbody>
                <tr>
                    <td>
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class=" text-center" style="margin:0;padding:0;line-height:29px;"> QUOTATION </h4>

                                <div class="customer-info">
                                    <div class="row ml-1 mr-1 ">
                                        <div class="col-sm-2 customer-static-content">
                                            TO, <br>
                                            M/S: <br>
                                            Address: <br>
                                            Attention: <br>
                                            Contact No: <br>
                                            Subject: <br>
                                            Site/Delivey: <br>
                                        </div>
                                        <div class="col-sm-10 customer-dynamic-content">
                                            <br>
                                            {{ $lpo_project->party->pi_name ? $lpo_project->party->pi_name : '...' }} <br>
                                            {{ $lpo_project->party->address ? $lpo_project->party->address : '...' }} <br>
                                            {{ $lpo_project->party->con_person ? $lpo_project->party->con_person : '...'}}<br>
                                            {{ $lpo_project->party->con_no ? $lpo_project->party->con_no :'...'}} <br>
                                            {{ $lpo_project->project_description }} <br>
                                            {{ $lpo_project->site_delivery }} <br>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="px-1 ml-1">
                            <p style="font-size:15px; line-hight:0 !important;font-weight:500;color:black;margin:5px 20px 0 0;"> <span
                                    style="font-weight:400"> Dear sir : </span> </p>
                            <p style="font-size:15px; line-hight:0 !important;font-weight:400;color:black;margin:5px 20px 0 0;">
                                As per our discussion with you, we are submitting the following details and
                                price for Below Mentioned works for your Kind Approval.
                            </p>
                        </div>
                        <div class="row" style="padding: 15px;">
                            <div class="col-sm-12">
                                <table class="table table-sm table-bordered border-botton proview-table" style="color: black; ">
                                    <thead style="background: #E6BC99 !important;color: black;">
                                        <tr>
                                            <th class="" style="color:#444;font-weight:600; width:3%"> S.no </th>
                                            <th class="text-center" style="color:#444;font-weight:600 ;width: 60%"> Description of work </th>
                                            <th class="text-center" style="color:#444;font-weight:600;"> Unit </th>
                                            <th class="text-center" style="color:#444;font-weight:600;"> Qty </th>
                                            <th class="text-center" style="color:#444;font-weight:600;"> Rate ({{ $currency->symbole }}) </th>
                                            <th class="text-center" style="color:#444;font-weight:600;"> Amount ({{ $currency->symbole }}) </th>
                                        </tr>
                                    </thead>
                                    @php
                                        $cc = 0;
                                    @endphp
                                    <tbody class="user-table-body">
                                        @foreach ($lpo_project->tasks as $key => $task)
                                        <tr class="text-center">
                                            <td class="text-right">{{ $key + 1 }}</td>
                                            <td class="text-left">
                                                {{ $task->task_name }} <br>
<pre class="text-left border-0">
{{$task->description}}
</pre>
                                            </td>
                                            <td class="text-center">
                                                {{ $task->unit }}
                                            </td>
                                            <td class="text-center">
                                                {{ $task->qty }}
                                            </td>
                                            <td class="text-center">
                                                {{ $task->rate }}
                                            </td>
                                            <td class="text-center">
                                                {{ $task->amount + $task->discount }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if($lpo_project->discount)
                                    <tr>
                                        <td colspan="5" class=" text-right"
                                            style="border-right:1px solid #ddd;font-size:14px;font-weight:500;">
                                            Total
                                        </td>
                                        <td class="text-center "
                                            style="border-right:1px solid #f2dede;font-size:14px;font-weight:500;">
                                            {{ $lpo_project->budget }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="5" class=" text-right"
                                            style="border-right:1px solid #ddd;font-size:14px;font-weight:500;">
                                            Discount
                                        </td>
                                        <td class="text-center "
                                            style="border-right:1px solid #f2dede;font-size:14px;font-weight:500;">
                                            {{ $lpo_project->discount }}
                                        </td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td colspan="5" class=" text-right"
                                            style="border-right:1px solid #ddd;font-size:14px;font-weight:500;">
                                            Total Amount ({{ $currency->symbole }})
                                        </td>
                                        <td class="text-center "
                                            style="border-right:1px solid #f2dede;font-size:14px;font-weight:500;">
                                            {{ $lpo_project->total_budget }}
                                        </td>
                                    </tr>

                                    <tr>
                                        @php

                                            $whole = floor($lpo_project->total_budget);
                                            $fraction = number_format($lpo_project->total_budget - $whole, 2);
                                            $f = new NumberFormatter('en', NumberFormatter::SPELLOUT);
                                            $amount_in_word = $f->format($whole);
                                            $amount_in_word2 = $f->format($fraction*100);
                                        @endphp
                                        <td colspan="7" class="text-center  text-capitalize"
                                            style="border-right:1px solid #f2dede;font-size:14px;font-weight:500;">
                                            In Words: {{ $amount_in_word }} Dirhams
                                            @if ($fraction > 0)
                                                {{ '& ' . $amount_in_word2 }}
                                            @else
                                            No
                                            @endif Fils
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="7" class="text-center "
                                            style="border-right:1px solid #f2dede;font-size:14px;font-weight:500;">
                                            Note: 5% vat will be added to the total amount.(TRN) {{$trn_no}}
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-12">
                                <div class="invoice-view-wrapper px-1">
                                    <div class="summernote">
                                         {!!$lpo_project->project_term!!}

                                    </div>


                                    <p style="font-size:13px; line-hight:0 !important;font-weight:500;color:#000;margin:5px 20px 0 0;"> <span
                                            style="font-weight:400"> BIN HINDI FABRICATION METAL AND IRON WORKS LLC </span> </p>
                                    <p style="font-size:13px; line-hight:0 !important;font-weight:400;color:#000;margin:0px 20px 0 0;"> Jani Barua (MD)
                                    </p>
                                    <p style="font-size:13px; line-hight:0 !important;font-weight:400;color:#000;margin:0px 20px 0 0;"> 050 628 7964
                                    </p>
                                    <p style="font-size:13px; line-hight:0 !important;font-weight:400;color:#000;margin:5px 20px 0 0;"> Office:</p>
                                    <p style="font-size:13px; line-hight:0 !important;font-weight:400;color:#000;margin:0px 20px 0 0;"> Utpal Barua:
                                        056 583 1841 </p>

                                </div>
                            </div>
                        </div>


                    </td>
                </tr>

            </tbody>
        </table>
    </div>

    <!-- ============ srtart absolute header/footer image========== -->
    <div class="header">
        @include('layouts.backend.partial.modal-header-info')
    </div>
    <div class="footer">


        <div class="divFoote  invoice-view-wrapper" style="background: #f6f5f5 ; padding-top:10px ; padding-bottom:10px">
            <p class="text-center" style="text-align: center !important">
                تليفون : ٠٦٧٤٨۰۲۲۳، ص.ب : ۸۲۱٦، منطقة الصناعية الجديدة، عجمان - ا.ع.م <br>
                Tel: 06 7480223, P.O. Box: 8216, New Industrial Area, Ajman - U.A.E. <br> Email:
                binhindifabrication@yahoo.com</p>
        </div>
        <div class="divFooter text-left">
            Business Software Solutions by
            <span style="color: #0005" class="spanStyle"><img class="img-fluid"
                    src="{{ asset('img/zisprink.png') }}" alt="" width="70"></span>
        </div>
    </div>
    <!-- ============ end absolute header/footer image========== -->

    <!-- Optional JavaScript; choose one of the two! -->
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
</body>

</html>
