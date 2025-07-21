<div class="nav nav-tabs master-tab-section" id="nav-tab" role="tablist">
    <a href="{{route("taxInvoIssue")}}" class="nav-item nav-link {{ $activeMenu=='invoice' ? 'active' : ' ' }}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('icon/invoice.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp Invoice  &nbsp &nbsp  &nbsp &nbsp &nbsp</div>
    </a>
    <a href="{{route("tax-invoice-list")}}" class="nav-item nav-link {{ $activeMenu == 'list' ? 'active' : ' ' }}" role="tab" aria-controls="nav-contact" aria-selected="false" id="mJournalAuthorizationSection">
        <div class="master-icon text-cente">
            <img src="{{asset('icon/list.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp List &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</div>
    </a>
    <a href="{{route("new-receipt-voucher")}}" class="nav-item nav-link {{ $activeMenu == 'new-receipt-voucher' ? 'active' : ' ' }}" role="tab" aria-controls="nav-contact" aria-selected="false" id="mJournalAuthorizationSection">
        <div class="master-icon text-cente">
            <img src="{{asset('icon/payment-voucher.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div>Receipt Voucher</div>
    </a>
    <a href="{{route("receipt-voucher-list")}}" class="nav-item nav-link {{ $activeMenu == 'receipt-voucher-list' ? 'active' : ' ' }}" role="tab" aria-controls="nav-contact" aria-selected="false" id="mJournalAuthorizationSection">
        <div class="master-icon text-cente">
            <img src="{{asset('icon/payment-voucher-list.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div> &nbsp  &nbsp &nbsp Receipt List &nbsp  &nbsp &nbsp </div>
    </a>
</div>




