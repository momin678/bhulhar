<style>
    .bg-secondary {
        background-color: #2c3034 !important;
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
        background-color: #475f7b30;
    }
    a.text-dark:hover, a.text-dark:focus {
        color: #ffffff !important;
        background-color: #475f7b30;
    }
    .btn-outline-secondary {
        border-radius: 40px;
        padding: 0.2px 9px 0.2px 9px !important;
    }
    .dropdown-toggle::after {
        display: none !important;
    }
</style>

<div class="d-flex align-items-center gap-2">
    <div>
        <a  href="javascript:void(0);" data-toggle="dropdown" class="btn btn-outline-secondary nav-item nav-link tabPadding dropdown-toggle d-flex nav-link dropdown-user-link {{ $activeMenu == 'accounting-report' ? 'bg-secondary text-white'  :' text-dark'}}" role="tab" aria-controls="nav-contact" aria-selected="false" style="margin-right:15px;">
            <div>Accounting Reports </div>
            <i class='bx bxs-down-arrow' style="font-size: 15px"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-left pb-0">
            <a class="dropdown-item" href="{{route('new-general-ledger')}}">General Ledger</a>
            <a class="dropdown-item" href="{{route('party-report')}}">Party Ledger</a>
            <a class="dropdown-item" href="{{route('new-trial-balance')}}">Trial Balance</a>
            <a class="dropdown-item" href="{{route('income-statement')}}">Income Statement</a>
        </div>
    </div>
    <div>
        <a  href="javascript:void(1);" data-toggle="dropdown" class="btn btn-outline-secondary nav-item nav-link tabPadding dropdown-toggle d-flex nav-link dropdown-user-link {{ $activeMenu == 'financial-report' ? 'bg-secondary text-white'  :' text-dark'}}" role="tab" aria-controls="nav-contact" aria-selected="false" style="margin-right:15px;">
            <div>Financial Reports</div>
            <i class='bx bxs-down-arrow' style="font-size: 15px"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-left pb-0">
            <a class="dropdown-item" href="{{route('balance-sheet')}}">Balance Sheet</a>
        </div>
    </div>
    <a href="{{route('daily-summary.report')}}" class="btn btn-outline-secondary nav-item nav-link tabPadding {{  $activeMenu == 'daily-summary' ? 'bg-secondary text-white' : ' text-dark'}}" role="tab" aria-controls="nav-contact" aria-selected="false" style="margin-right:15px;">
        <div>Daily Summary</div>
    </a>
    <a href="{{route('vat-report')}}" class="btn btn-outline-secondary nav-item nav-link tabPadding {{  $activeMenu == 'vat-reports' ? 'bg-secondary text-white' : ' text-dark'}}" role="tab" aria-controls="nav-contact" aria-selected="false" style="margin-right:15px;">
        <div>VAT Reports</div>
    </a>
</div>
