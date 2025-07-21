<div class="nav nav-tabs master-tab-section print-hideen" id="nav-tab" role="tablist">
    @if (Auth::user()->hasPermission('app.invoice.invoice_create'))
    <a href="{{route("customer-invoice")}}" class="nav-item nav-link {{ Request::is('customer-inv/customer-invoice*') ? 'active' : ''}}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('assets/backend/app-assets/icon/invoice-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div>Invoicing</div>
    </a>
    @endif
    {{-- @if (Auth::user()->hasPermission('app.invoice.invoice_create'))
    <a href="{{route("draft-invoice-list")}}" class="nav-item nav-link {{ Request::is('customer-inv/draft-invoice-list') ? 'active' : ''}}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('assets/backend/app-assets/icon/draft.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div>Draft</div>
    </a>
    @endif
    @if (Auth::user()->hasPermission('app.invoice.invoice_authorize'))
    <a href="{{route("invoice-athurization-list")}}" class="nav-item nav-link {{ Request::is('customer-inv/invoice-athurization-list*') ? 'active' : ''}}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('assets/backend/app-assets/icon/invoice-authorize-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div>Authorization</div>
    </a>
    @endif --}}
    @if (Auth::user()->hasPermission('app.invoice.invoice_approval'))
    <a href="{{route("invoice-approval-list")}}" class="nav-item nav-link  {{ Request::is('customer-inv/invoice-approval-list*') ? 'active' : ''}}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('assets/backend/app-assets/icon/invoice-approval-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div>Approval</div>
    </a>
    @endif
    @if (Auth::user()->hasPermission('app.invoice.invoice_view'))
    <a href="{{route("approved-invoice-list")}}" class="nav-item nav-link  {{ Request::is('customer-inv/approved-invoice-list*') ? 'active' : ''}}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('assets/backend/app-assets/icon/invoice-list-icon.png')}}" alt="" srcset="" class="img-fluid" width="40">
        </div>
        <div>Invoice List</div>
    </a>

    <a href="{{route("declined-invoice-list")}}" class="nav-item nav-link  {{ Request::is('customer-inv/declined-invoice-list*') ? 'active' : ''}}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('assets/backend/app-assets/icon/invoice-declined-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div>Pending / Declined</div>
    </a>
    <a href="{{route("search-customer-invoice")}}" class="nav-item nav-link  {{ Request::is('customer-inv/search-customer-invoice*') ? 'active' : ''}}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('assets/backend/app-assets/icon/search-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div>Toll Fee Invoice</div>
    </a>
    <a href="{{route("driver-report")}}" class="nav-item nav-link  {{ Request::is('customer-inv/driver-report*') ? 'active' : ''}}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('assets/backend/app-assets/icon/employee-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div>Driver Reports</div>
    </a>
    <a href="{{route("vehicle-report")}}" class="nav-item nav-link  {{ Request::is('customer-inv/vehicle-report*') ? 'active' : ''}}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('assets/backend/app-assets/icon/vehicle-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div>Vehicle Reports</div>
    </a>
    @endif
</div>
