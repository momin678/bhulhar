<style>
    .row {
        display: flex;
    }

    .col-md-1 {
        max-width: 8.33% !important;
    }

    .col-md-2 {
        max-width: 16.66% !important;
    }

    .col-md-8 {
        max-width: 66.66% !important;
    }

    .col-md-10 {
        max-width: 83.33% !important;
    }

    .col-md-11 {
        max-width: 91.66% !important;
    }

    .customer-static-content {
        background: #ada8a81c;
    }

    .customer-dynamic-content {
        background: #706f6f33;
    }

    .proview-table tr td,
    .proview-table tr th {
        border: 1px solid black !important;
    }

    .customer-dynamic-content2 {
        background: #fff !important;
    }

    .customer-content {
        border: 1px solid black !important;
    }

    @media print and (color) {
        .proview-table {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
    }

    @media print {
        .row {
            display: flex;
        }

        .col-md-1 {
            max-width: 8.33% !important;
        }

        .col-md-2 {
            max-width: 16.66% !important;
        }

        .col-md-8 {
            max-width: 66.66% !important;
        }

        .col-md-10 {
            max-width: 83.33% !important;
        }

        .col-md-11 {
            max-width: 91.66% !important;
        }

        .customer-static-content {
            background: #ada8a81c;
        }

        .customer-dynamic-content {
            background: #706f6f33;
        }

        .proview-table tr td,
        table tr th {
            border: 1px solid black !important;
        }

        #widgets-Statistics {
            padding: 2px !important;
        }

        .customer-dynamic-content2 {
            background: #fff !important;
        }

        .customer-content {
            border: 1px solid black !important;
        }
    }
</style>

<section class=" border-bottom print-hideen " style="padding: 5px 15px;background:#364a60;">
    <div class="d-flex flex-row-reverse">
        <div class="" style="margin-top: 6px;"><a href="#" class="close btn-icon btn btn-danger"
                data-dismiss="modal" aria-label="Close" style="padding-bottom: 8px;" title="Close"><span
                    aria-hidden="true"><i class='bx bx-x'></i></span></a>
         </div>
        <div class="" style="padding-right: 3px;margin-top: 6px;">
            <a href="#" onclick="window.print();" class="btn btn-icon btn-success" title="Print"><i class="bx bx-printer"></i></a>
        </div>
        <div class="" style="padding-right: 3px;margin-top: 6px;">
            <a href="#" class="btn btn-icon btn-info distribute_view"  url="{{route('expense-distribution.edit',$distribute->id)}}" title="Edit"><i class="bx bx-edit"></i></a>
        </div>
        <div class="w-100">
            <h4 style="font-family:Cambria;font-size: 2rem;color:white;">
                Distribution
            </h4>
        </div>
    </div>
</section>
@php
    $trn_no = \App\Setting::where('config_name', 'trn_no')->first();
    $company_name = \App\Setting::where('config_name', 'company_name')->first();
@endphp
@include('layouts.backend.partial.modal-header-info')

<section id="widgets-Statistics">
    <div class="row pt-1">
        <div class="col-md-12">
            <div class="customer-info">
                <div class="row ml-1 mr-1 " style="border: 2px solid #bdbdbd;">
                    <div class="col-2 customer-static-content">
                       <strong> Date:</strong>  {{  date('d/m/Y', strtotime($distribute->date))}}
                    </div>
                    <div class="col-4">
                        <strong>Note:</strong> {{$distribute->note}}
                    </div>
                    <div class="col-2">
                        <strong>From Date</strong>: {{date('d/m/Y', strtotime($distribute->expense_from)) }}
                    </div>
                    <div class="col-2">
                       <strong> To Date:</strong> {{ date('d/m/Y', strtotime($distribute->expense_to)) }}
                    </div>
                    <div class="col-2">
                        <strong>Total Amount:</strong> {{$distribute->total_amount}}
                    </div>
                </div>
            </div>

        </div>

    </div>

    <div class="row" style="padding: 15px;">
        <div class="col-md-12">
            <table class="table table-sm table-bordered border-botton proview-table" style="color: black; ">
                <thead style="background: #E6BC99 !important;color: black;">
                    <tr class="text-center">
                        <th style="color: black !important;">Sl No.</th>
                        <th class="text-center" style="color: black !important;">Vehicle</th>
                        <th style="color: black !important;">Amount</th>
                    </tr>
                </thead>
                @php
                    $cc = 0;
                @endphp
                <tbody class="user-table-body">
                    @foreach ($distribute->items as $key=>$item)
                        <tr class="text-center">
                            <td>{{ ++$key }}</td>
                            <td>{{$item->vehicle->vehicle_number}}</td>
                            <td class="text-center">{{ $item->amount }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="text-center" colspan=""></td>
                        <td class="text-right pr-1" style="background: #ada8a81c">Total</td>
                        <td class="text-center" style="background: #ada8a81c">{{ number_format($distribute->items->sum('amount'),2) }}</td>
                    </tr>


                </tbody>
            </table>
        </div>
    </div>




    <div class="divFoote  invoice-view-wrapper" style="background: #f6f5f5 ; padding-top:10px ; padding-bottom:10px">
        <p class="text-center" style="text-align: center !important">
            تليفون : ٠٦٧٤٨۰۲۲۳، ص.ب : ۸۲۱٦، منطقة الصناعية الجديدة، عجمان - ا.ع.م <br>
            Tel: 06 7480223, P.O. Box: 8216, New Industrial Area, Ajman - U.A.E. <br> Email:
            binhindifabrication@yahoo.com</p>
    </div>
    <div class="divFooter mb-1 ml-1 invoice-view-wrapper  footer-margin">
        Business Software Solutions by
        <span style="color: #0005" class="spanStyle"><img class="img-fluid"
                src="{{ asset('img/zisprink.png') }}" alt="" width="70"></span>
    </div>
</section>
<div class="img receipt-bg invoice-view-wrapper">
    <img src="{{ asset('img/finallogo.PNG') }}" class="img-fluid"
        style="position: fixed; top: 420px; left: 200px; opacity: 0.2; width: 650px !important; height: 250px;"
        alt="">

    {{-- <img src="{{ asset('img/finallogo.jpeg') }}" class="img-fluid" style="position: fixed; top:100px; left:0px; opacity:0.1;width:100%; " alt=""> --}}
</div>
