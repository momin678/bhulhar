<div class="nav nav-tabs master-tab-section" id="nav-tab" role="tablist">
    <a href="{{route('payment-voucher-list')}}" class="nav-item nav-link {{Request::route()->getName()=='payment-voucher-list'?'active':''}}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('assets/backend/app-assets/icon/list-icon.png')}}" alt="" srcset="" class="img-fluid" width="38" height="20">
        </div>
        <div>Voucher View</div>
    </a>
    @if (Auth::user()->hasPermission('payment_voucher_create'))
    <a href="{{route('payment-voucher')}}" class="nav-item nav-link {{Request::is('payment-voucher')?'active':''}}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('assets/backend/app-assets/icon/add-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div>Voucher Entry</div>
    </a>
    @endif
    @if (Auth::user()->hasPermission('payment_voucher_authorize'))
    <a href="{{route('authorize-payment-voucher-list')}}" class="nav-item nav-link {{ Request::is('authorize-payment-voucher-list') ? 'active' : ''}}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('assets/backend/app-assets/icon/authorization-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div>Authorization</div>
    </a>
    @endif
    @if (Auth::user()->hasPermission('payment_voucher_approval'))
    <a href="{{route('approval-payment-voucher-list')}}" class="nav-item nav-link {{ Request::is('approval-payment-voucher-list') ? 'active' : ''}}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('assets/backend/app-assets/icon/approval-icon.png')}}" alt="" srcset="" class="img-fluid" width="55">
        </div>
        <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Approval &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
    </a>
    @endif
    <a href="{{route("payment-voucher-reject-list")}}" class="nav-item nav-link {{Request::is('payment-voucher-reject-list') ? 'active' : ''}}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('assets/backend/app-assets/icon/invoice-declined-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div> &nbsp;&nbsp; Rejected  &nbsp;&nbsp;</div>
    </a>
</div>