<div class="nav nav-tabs master-tab-section text-center" id="nav-tab" role="tablist">
    <!--<a href="{{ route('account-info.index') }}" class="nav-item nav-link {{ $activeMenu == 'currency' ? 'active' : ' ' }}" role="tab" aria-controls="nav-contact" aria-selected="false">-->
    <!--    <div class="master-icon text-cente">-->
    <!--        <img src="{{asset('assets/backend/app-assets/icon/master-account.png')}}" alt="" srcset="" class="img-fluid" width="50">-->
    <!--    </div>-->
    <!--    <div>Accounting Info</div>-->
    <!--</a>-->

    {{-- <a href="{{route("purchase-expense-invoice")}}" class="nav-item nav-link {{ $activeMenu == 'invoice' ? 'active' : ' ' }}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('assets/backend/app-assets/icon/master-account.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div>Invoice</div>
    </a> --}}
    <a href="{{route("purchase-expense-bill")}}" class="nav-item nav-link {{ $activeMenu=='bill' ? 'active' : ' ' }}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('icon/purchaseexpense-entry.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div>  Bills  </div>
    </a>
    <a href="{{route("purchase-expense")}}" class="nav-item nav-link {{ $activeMenu=='Garage' ? 'active' : ' ' }}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('icon/purchaseexpense-entry.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div> Garage Expense </div>
    </a>
    <a href="{{route("purchase-expense-office")}}" class="nav-item nav-link {{ $activeMenu=='Office' ? 'active' : ' ' }}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('icon/purchaseexpense-entry.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div> Office Expense  </div>
    </a>
    @if($activeMenu=='purchase_expense-edit')
    <a href="" class="nav-item nav-link {{ $activeMenu=='purchase_expense-edit' ? 'active' : ' ' }}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('icon/payment-voucher-list.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div>  Bills Edit </div>
    </a>
    @endif
    <a href="{{route("purchase-expense-list")}}" class="nav-item nav-link {{ $activeMenu == 'list' ? 'active' : ' ' }}" role="tab" aria-controls="nav-contact" aria-selected="false" id="mJournalAuthorizationSection">
        <div class="master-icon text-cente">
            <img src="{{asset('icon/list.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div> List</div>
    </a>
    <a href="{{route("expense-distribution.index")}}" class="nav-item nav-link {{ $activeMenu == 'purchase_expense_distribution' ? 'active' : ' ' }}" role="tab" aria-controls="nav-contact" aria-selected="false" id="mJournalAuthorizationSection">
        <div class="master-icon text-cente">
            <img src="{{asset('icon/payment-voucher.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div>Expense Distribution</div>
    </a>

</div>




