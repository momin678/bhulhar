@php
    $company_name= \App\Setting::where('config_name', 'company_name')->first();
    $company_address= \App\Setting::where('config_name', 'company_address')->first();
    $company_tele= \App\Setting::where('config_name', 'company_tele')->first();
    $company_email= \App\Setting::where('config_name', 'company_email')->first();
    $trn_no= \App\Setting::where('config_name', 'trn_no')->first();
    $arabic_context= \App\Setting::where('config_name', 'arabic_context')->first();
    $po_box= \App\Setting::where('config_name', 'p.o_box')->first();

@endphp
<div class="divFoote  invoice-view-wrapper" style="background: #f6f5f5 ; padding-top:10px ; padding-bottom:10px">
    <p class="text-center" style="text-align: center !important">
        {{$arabic_context->config_value}} <br>
        Tel: {{$company_tele->config_value}}, P.O. Box: {{$po_box->config_value}}, {{$company_address->config_value}} <br> Email:
        {{$company_email->config_value}}</p>
</div>
<div class="divFooter text-left">
    Business Software Solutions by
    <span style="color: #0005" class="spanStyle"><img class="img-fluid"
            src="{{ asset('img/zisprink.png') }}" alt="" width="70"></span>
</div>
