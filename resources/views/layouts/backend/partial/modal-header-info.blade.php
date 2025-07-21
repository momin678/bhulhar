
<style>

    .company-info {
        color: white;
        background-color: rgb(230 108 96);
        padding-bottom: 5px;
    }

    h2 {
        font-family: Cambria;
    }
    .th-60 {
        width: 60px;
    }
    .text-right {
        text-align: right !important;
        padding-right: 10px !important;
    }
    .invoice-header {
            color: #040404;
            text-transform: uppercase;
            letter-spacing: 2px;
            /* text-align: center; */
            font-weight: 700;
            line-height: .5
        }

    .invoice-header1 {
            color: #040404;
            text-transform: uppercase;
            font-size: 50px;
            letter-spacing: 2px;
            /* text-align: center; */
            font-weight: 600;
            line-height: 1
        }

    .invoice-p {
        font-size: 12px;
        font-weight: 500;
        color: #3a3735;
        list-style: 1.3;
    }

    .image-box {
        display: flex;

    }

    .invoice-logo {
        width: 160px;
        height: auto;
        margin-left:40px;
        margin-top: -20px;
    }
</style>
@php
    $company_name= \App\Setting::where('config_name', 'company_name')->first();
    $company_address= \App\Setting::where('config_name', 'company_address')->first();
    $company_tele= \App\Setting::where('config_name', 'company_tele')->first();
    $company_email= \App\Setting::where('config_name', 'company_email')->first();
    $trn_no= \App\Setting::where('config_name', 'trn_no')->first();
    $company_logo= \App\Setting::where('config_name', 'company_logo')->first();
    $company_trn= \App\Setting::where('config_name', 'trn_no')->first();
    $invoice_arabic= \App\Setting::where('config_name', 'invoice_arabic')->first();
    $invoice_log= \App\Setting::where('config_name', 'invoice_img')->first();
@endphp

<section id="widgets-Statistics border-bottom print-info conpany-header mb-3" style="margin-bottom: 20px !important">
    <div class="header-block " style="padding: 2px 15px;">
        <div class="row">
            <div class="col-12">
                <div class="tex-left">
                    <div class="row full-height d-flex align-items-center" style="padding: 10px;">
                        <img src="{{ asset('img/Prince-head.png') }}" alt="header image" width="100%" height="140px" style="float:left; background-size: cover;">
                    </div>
                </div>
            </div>
      </div>
    </div>
</section>
