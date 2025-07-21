<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/print.css') }}">

    <title>Invoice</title>
</head>

<style>
    .headerGroup:after {
        content: 'Text';
        background-image: url('img/balraj-header.png');
    }
    .table-font tr td{
        font-size: 13px !important;
    }
    .table-font tr th{
        font-size: 13px !important;
    }
    .table-header tr th{
        font-size: 13px !important;
    }
    tbody, td, tfoot, th, thead, tr {
        border-color: #4b4949d2;
    }
    .description{
        min-width: 350px !important;
    }
    .company-info{
        color: white;
        background-color: rgb(230 108 96);
        padding-bottom: 5px;
    }
    h2{
        font-family: Cambria;
    }
</style>

<body onload="window.print();">
    @php
    $company_name= \App\Setting::where('config_name', 'company_name')->first();
    $company_address= \App\Setting::where('config_name', 'company_address')->first();
    $company_tele= \App\Setting::where('config_name', 'company_tele')->first();
    $company_email= \App\Setting::where('config_name', 'company_email')->first();
    $trn_no= \App\Setting::where('config_name', 'trn_no')->first();
    $company_logo= \App\Setting::where('config_name', 'company_logo')->first();
    $company_trn= \App\Setting::where('config_name', 'trn_no')->first();
    @endphp
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <table width="100%">
            <thead>
                <tr>
                    <td class="headerGroup">
                        <div class="header-block">
                            {{-- <table class="table table-bordered">
                                <tr>
                                    <th>Tax Invoice</th>
                                </tr>
                            </table> --}}
                        </div>
                    </td>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <td class="footerGroup">
                        <div class="footer-block"></div>
                    </td>
                </tr>
            </tfoot>
            <tbody>
                <tr>
                    <td>
                        <div class="page-container">
                            <div class="page">
                                <div class="row">
                                    <div class="col-md-12 text-center ">
                                        <h2>{{$driver_info->full_name}} Driver Commission</h2>
                                        <h5>
                                            @if ($from && $to)
                                                {{date('d/m/Y', strtotime($from))}} To {{date('d/m/Y', strtotime($to))}}
                                            @endif
                                        </h5>
                                    </div>
                                </div>
                            </div>
                            <div class="page">
                                <table class="table mb-0 table-sm table-hover table-bordered">
                                <thead class="">
                                    <tr style="height: 40px;">
                                        <th>Date</th>
                                        {{-- <th>Party Name</th> --}}
                                        <th>Truck</th>
                                        {{-- <th>Material</th> --}}
                                        <th>Crusher</th>
                                        <th>DSTN</th>
                                        {{-- <th>TKT NO</th> --}}
                                        <th>WGT</th>
                                        <th style="width:100px !important;">Commission</th>
                                    </tr>
                                </thead>
                                <tbody class="table-sm">
                                    @foreach ($records as $t_record)
                                        <tr class="trFontSize t-row">
                                            <input type="hidden" name="id[]" value="{{$t_record->id}}">
                                            <td>{{date('d/m/Y', strtotime($t_record->date))}}</td>
                                            {{-- <td>{{$t_record->customer?$t_record->customer->pi_name:''}}</td> --}}
                                            <td>{{$t_record->truck->vehicle_number}}</td>
                                            {{-- <td>{{$t_record->material}}</td> --}}
                                            <td class="crusher">{{$t_record->crusher}}</td>
                                            <td class="r-destination">{{$t_record->destination}}</td>
                                            {{-- <td>{{$t_record->tkt_number}}</td> --}}
                                            <td>{{$t_record->weight}}</td>
                                            <td class="text-center">{{$t_record->commision}}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="5" class="text-right pr-1"><Strong>Total: </Strong></td>
                                        <td class="pr-1"><Strong id="total_driver_amount">{{number_format($records->sum('commision'),2)}}</Strong></td>
                                    </tr>
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- ============ srtart absolute header/footer image========== -->
    <div class="header">
        <img src="{{ asset('img/Prince-head.png') }}" alt="header image" width="100%" height="70px"
            style="float:left; background-size: cover; "> <br>
            {{-- <span class="company-info" style="background-color: #ed1b24; color:white; padding:3px 25px 3px 25px; font-size: 20px !important;"><strong>Tel.: {{$company_tele->config_value}}, Email: {{$company_email->config_value}} TRN: {{$company_trn->config_value}}</strong></span>
            <div style="border-bottom: 1px solid black; margin-top:3px;"></div> --}}
    </div>
    <div class="footer">
        <img src="{{ asset('img/Prince-footer.png') }}" alt="Footer image" width="100%" height="50px"
            style="float:left; background-size: cover; "><br>
            <span style="color: #0005; padding-left:30px; font-size:6px;">
                Business Software Solutions by
                <img src="{{ asset('img/zisprink.png') }}" style="max-height: 20px" class="img-fluid" alt="">
            </span>
    </div>
    <div class="img">
        <img src="{{ asset('storage/upload/settings/'.$company_logo->config_value)}}" class="img-fluid" style="position: fixed; top:300px; left:20px; opacity:0.09; height:490px;" alt="">
    </div>
    <!-- ============ end absolute header/footer image========== -->

    <!-- Optional JavaScript; choose one of the two! -->
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
</body>

</html>
