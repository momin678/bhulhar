<div class="nav nav-tabs master-tab-section" id="nav-tab" role="tablist">


    {{-- <a href="{{route("new-journal")}}" class="nav-item nav-link {{ $activeMenu == 'jouranal' ? 'active' : ' ' }} d-none" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('icon/list-view.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div>&nbsp &nbsp &nbsp &nbsp &nbsp  View &nbsp &nbsp &nbsp &nbsp &nbsp  </div>
    </a>
    <a href="{{route('new-journal-creation')}}" class="nav-item nav-link {{ $activeMenu=='jouranal-creation' ? 'active' : ' ' }} d-none" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('icon/account-entry.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div>&nbsp &nbsp &nbsp &nbsp &nbsp Entry &nbsp &nbsp &nbsp &nbsp &nbsp</div>
    </a>
    <a href="{{route("journal-authorization-section")}}" class="nav-item nav-link {{ $activeMenu == 'journal_authorize' ? 'active' : ' ' }} d-none" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('icon/authorize.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div> &nbsp &nbsp &nbsp  Authorize &nbsp &nbsp &nbsp  </div>
    </a>
    <a href="{{route("journal-approval-section")}}" class="nav-item nav-link {{ $activeMenu == 'jouranal-approve' ? 'active' : ' ' }} d-none" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('icon/approve.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div> &nbsp &nbsp &nbsp  Approve &nbsp &nbsp &nbsp </div>
    </a> --}}
    <a href="{{route("purchase-expense-bill")}}" class="nav-item nav-link {{ $activeMenu == 'expense' ? 'active' : ' ' }}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('icon/approve.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div> &nbsp &nbsp &nbsp  Expenses &nbsp &nbsp &nbsp </div>
    </a>

    <a href="{{route("sale.revenues.create")}}" class="nav-item nav-link {{ $activeMenu == 'sale' ? 'active' : ' ' }}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('icon/invoice.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div> Sale </div>
    </a>


    <a href="{{route("fund-allocation.index")}}" class="nav-item nav-link {{ $activeMenu == 'fund-allocation' ? 'active' : ' ' }}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('icon/payment-voucher.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div> Fund Alocation </div>
    </a>
    <a href="{{route("receipt-voucher3")}}" class="nav-item nav-link {{ $activeMenu == 'receipt-voucher' ? 'active' : ' '}}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('icon/invoice.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div> Receipt Voucher </div>
    </a>
    <a href="{{route("payment-voucher2")}}" class="nav-item nav-link {{ $activeMenu == 'payment-report' ? 'active' : ' ' }}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('icon/payment-voucher-list.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div> Payment Voucher </div>
    </a>
    <a href="{{route("new-general-ledger")}}" class="nav-item nav-link {{ $activeMenu == 'reports' ? 'active' : ' ' }}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('icon/accounting-report.webp')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div> &nbsp &nbsp &nbsp  Reports &nbsp &nbsp &nbsp </div>
    </a>


</div>




