<div class="nav nav-tabs master-tab-section" id="nav-tab" role="tablist">

    <a href="{{route("purchase.index")}}" class="nav-item nav-link {{ $activeMenu == 'purchase' ? 'active' : ' ' }}" role="tab" aria-controls="nav-contact" aria-selected="false" id="mJournalAuthorizationSection">
        <div class="master-icon text-cente">
            <img src="{{asset('icon/payment-voucher.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div>Purchase</div>
    </a>
    <a href="{{route("purchase.report")}}" class="nav-item nav-link {{ $activeMenu == 'purchase-report' ? 'active' : ' ' }}" role="tab" aria-controls="nav-contact" aria-selected="false" id="mJournalAuthorizationSection">
        <div class="master-icon text-cente">
            <img src="{{asset('icon/payment-voucher-list.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div> Purchase Report</div>
    </a>

    <a href="{{route("party-wish-report")}}" class="nav-item nav-link {{ $activeMenu == 'party-wise-report' ? 'active' : ' ' }}" role="tab" aria-controls="nav-contact" aria-selected="false" id="mJournalAuthorizationSection">
        <div class="master-icon text-cente">
            <img src="{{asset('icon/stake-holder.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div> Supplier Wise Report</div>
    </a>
    <a href="{{route("purchase-due-payment")}}" class="nav-item nav-link {{ $activeMenu == 'due-payment' ? 'active' : ' ' }}" role="tab" aria-controls="nav-contact" aria-selected="false" id="mJournalAuthorizationSection">
        <div class="master-icon text-cente">
            <img src="{{asset('icon/payment.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div> Purchase Due Payment</div>
    </a>

</div>




