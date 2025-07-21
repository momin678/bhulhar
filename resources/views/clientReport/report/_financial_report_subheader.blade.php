<style>
    .bg-secondary {
        background-color: #34465b !important;
        border-radius: 40px;
        color:white  !important;
        padding: 2px 5px 2px 5px !important;
    }
    a.bg-secondary:hover, a.bg-secondary:focus,
    button.bg-secondary:hover,
    button.bg-secondary:focus {
        background-color: #475f7b30 !important;
        color:black!important;
    }
    tr:nth-child(even) {
        background-color: #c8d6e357;
    }
    a.text-dark:hover, a.text-dark:focus {
        color: #ffffff !important;
    }
    .btn-outline-secondary {
        border-radius: 40px;
        padding: 0.2px 9px 0.2px 9px !important;
    }
</style>

<div class="d-flex align-items-center gap-2">

    <a href="{{route('balance-sheet')}}" class="btn btn-outline-secondary nav-item nav-link tabPadding {{  $activeMenu == 'balance_sheet' ? 'bg-secondary text-white' : ' text-dark'}}" role="tab" aria-controls="nav-contact" aria-selected="false" style="margin-right:15px;">

        <div>Balance Sheet</div>
    </a>

    {{-- <a href="{{route('purchase-reports')}}" class="btn btn-outline-secondary nav-item nav-link tabPadding {{  $activeMenu == 'purchase_reports' ? 'bg-secondary text-white' : ' text-dark'}}" role="tab" aria-controls="nav-contact" aria-selected="false" style="margin-right:15px;">
        <div>Purchase Reports</div>
    </a>
    <a href="{{route('sale-reports')}}" class="btn btn-outline-secondary nav-item nav-link tabPadding {{  $activeMenu == 'sale_reports' ? 'bg-secondary text-white' : ' text-dark'}}" role="tab" aria-controls="nav-contact" aria-selected="false" style="margin-right:15px;">
        <div>Sale Reports</div>
    </a> --}}
    <!--<a href="#" class="btn btn-outline-secondary nav-item nav-link tabPadding {{  $activeMenu == 'expense_income_reports' ? 'bg-secondary text-white' : ' text-dark'}}" role="tab" aria-controls="nav-contact" aria-selected="false" style="margin-right:15px;">-->
    <!--    <div>Expense/Income Reports</div>-->
    <!--</a>-->
    <!--<a href="{{route('receivable-reports')}}" class="btn btn-outline-secondary nav-item nav-link tabPadding {{  $activeMenu == 'receivable_reports' ? 'bg-secondary text-white' : ' text-dark'}}" role="tab" aria-controls="nav-contact" aria-selected="false" style="margin-right:15px;">-->
    <!--    <div>Receivable Reports</div>-->
    <!--</a>-->
    <!--<a href="{{route('payable-reports')}}" class="btn btn-outline-secondary nav-item nav-link tabPadding {{  $activeMenu == 'payable_reports' ? 'bg-secondary text-white' : ' text-dark'}}" role="tab" aria-controls="nav-contact" aria-selected="false" style="margin-right:15px;">-->
    <!--    <div>Payable Reports</div>-->
    <!--</a>-->



</div>
