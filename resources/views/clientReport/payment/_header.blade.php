<div class="nav nav-tabs master-tab-section text-center" id="nav-tab" role="tablist">

    <a href="{{route("payment-voucher2")}}" class="nav-item nav-link {{ $activeMenu == 'payment_voucher' ? 'active' : ' ' }}" role="tab" aria-controls="nav-contact" aria-selected="false" id="mJournalAuthorizationSection">
        <div class="master-icon text-cente">
            <img src="{{asset('icon/payment-voucher.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div>Payment Voucher</div>
    </a>
    <a href="{{route("payment-voucher2-list")}}" class="nav-item nav-link {{ $activeMenu == 'payments' ? 'active' : ' ' }}" role="tab" aria-controls="nav-contact" aria-selected="false" id="mJournalAuthorizationSection">
        <div class="master-icon text-cente">
            <img src="{{asset('icon/payment-voucher-list.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div> &nbsp  &nbsp &nbsp Payment List &nbsp  &nbsp &nbsp </div>
    </a>

    <a href="{{route("payable")}}" class="nav-item nav-link {{ $activeMenu == 'payable' ? 'active' : ' ' }}" role="tab" aria-controls="nav-contact" aria-selected="false" id="mJournalAuthorizationSection">
        <div class="master-icon text-cente">
            <img src="{{asset('icon/payment.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div> &nbsp  &nbsp &nbsp Payable &nbsp  &nbsp &nbsp </div>
    </a>

</div>




