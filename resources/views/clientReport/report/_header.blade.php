<div class="nav nav-tabs master-tab-section print-hideen" id="nav-tab" role="tablist">
    {{-- @if (Auth::user()->hasPermission('Accounting_Reports')) --}}
    <a href="{{route("new-general-ledger")}}" class="nav-item nav-link {{ $activeMenu=='account_report' ? 'active' : ' ' }}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('icon/accounting-report.webp')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div> Accounting Reports</div>
    </a>
    {{-- @endif
    @if (Auth::user()->hasPermission('Financial_Reports')) --}}
    <a href="{{route('balance-sheet')}}" class="nav-item nav-link {{ $activeMenu == 'financial_reports' ? 'active' : ' ' }}" role="tab" aria-controls="nav-contact" aria-selected="false" id="mJournalAuthorizationSection">
        <div class="master-icon text-cente">
            <img src="{{asset('icon/payment-voucher-list.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div>Financial Reports</div>
    </a>
    {{-- @endif --}}
    <a href="{{route("daily-summary.report")}}" class="nav-item nav-link {{ $activeMenu=='daily_summary' ? 'active' : ' ' }}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('icon/invoice.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div> Daily Summary</div>
    </a>
    <a href="{{route('vat-report')}}" class="nav-item nav-link {{ $activeMenu == 'vat_report' ? 'active' : ' ' }}" role="tab" aria-controls="nav-contact" aria-selected="false" id="mJournalAuthorizationSection">
        <div class="master-icon text-cente">
            <img src="{{asset('icon/authorize.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div>VAT Reports</div>
    </a>
</div>




