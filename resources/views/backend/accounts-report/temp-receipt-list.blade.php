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

    .font-bold{
        font-weight: bold;
    }
    p,span{
        color: #333333;
        font-weight: 500;
        font-size:14px;
    }
    .text-lg{
        font-size:16px;
    }
    .text-md{
        font-size: 14px;
    }
    .text-sm{
        font-size:12px;
    }

    table{
        border-collapse:collapse;
    }
    table.date, table.date th, table.date td{
        border:  1px solid #313131 !important;
        font-size: 14px;
        color: #333333;
    }

    .item-table tr th{
        text-transform:capitalize;
        font-size: 14px;
        font-weight: bold;
        color: #fff;
        padding: 5px 0;
        border: none !important;
    }

    .item-table tr td{
        border: 1px solid #333333;
        color: #333333;
        font-size: 14px;
    }
</style>

<section class=" border-bottom" style="padding: 5px 15px;background:#364a60;">
    <div class="d-flex flex-row-reverse">
        <div class="" style="margin-top: 6px;">
            <a href="#" class="close btn-icon btn btn-danger" data-dismiss="modal" aria-label="Close" style="padding-bottom: 6px;" title="Close">
                <span aria-hidden="true"><i class='bx bx-x'></i></span>
            </a>
        </div>
        <div class="pr-1 w-100 pl-2">
            <h4 style="font-family:Cambria;font-size: 2rem;color:white;">Receipt List</h4>
        </div>
    </div>
</section>
<div class="receipt-voucher-hearder invoice-view-wrapper">
    @include('layouts.backend.partial.modal-header-info')
</div>
<section id="widgets-Statistics">
    <div class="pt-2">
        <table class="table table-bordered table-sm text-center">
            <thead class="thead">
                <tr >
                    <th  style="width: 7%">Sl No</th>
                    <th  style="width: 12%">Date</th>
                    <th  style="width: 12%">Receipt No</th>
                    <th style="width: 25%">Party Name</th>
                    <th  style="width: 24%">Narration</th>
                    <th  style="width: 10%"  >Amount</th>
                    <th style="width: 10%">Pay Mode</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="receipt-body">
                @foreach ($receipt_list as $key => $item)
                <tr class="tr-item">
                    <td class="receipt_exp_view"  id="{{$item->id}}">{{$key+1}}</td>
                    <td class="receipt_exp_view"  id="{{$item->id}}">{{date('d/m/Y',strtotime($item->date))}}</td>

                    <td class="receipt_exp_view"  id="{{$item->id}}">{{$item->receipt_no}}</td>
                    <td class="receipt_exp_view"  id="{{$item->id}}">{{$item->party?$item->party->pi_name:''}}</td>
                    <td class="receipt_exp_view"  id="{{$item->id}}">{{$item->narration}}</td>
                    <td class="receipt_exp_view"  id="{{$item->id}}" >{{$item->total_amount}}</td>
                    <td class="receipt_exp_view"  id="{{$item->id}}" >{{$item->pay_mode}}</td>
                    <td style="padding-bottom: 11px; padding-top: 0px">
                        <div class="d-flex justify-content-center">
                            <a href="#" data="{{ 'receipt-voucher-approve2/'. $item->id }}" class="btn btn-icon btn-warning pandding-accounting-approve" onclick="return confirm('Approve! Confirm?')" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Approve"><i class="bx bx-check"></i></a>
                        </div>
                    </td>
                </tr>

                @endforeach
            </tbody>

        </table>
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
