<style>
    .content-body .nav-tabs .nav-item{
        padding: 8px 4px !important;
    }
</style>
<div class="nav nav-tabs master-tab-section" id="nav-tab" role="tablist">
    <a href="{{route("vehicle-expense-reports")}}" class="nav-item nav-link {{Request::is('vehicle-expense-reports') ?'active':''}}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('assets/backend/app-assets/icon/supplier-icon.png')}}" alt="" srcset="" class="img-fluid" width="50" height="20">
        </div>
        <div>Vehicle ROI Report</div>
    </a>
    <a href="{{route("customer-invoice-reports")}}" class="nav-item nav-link {{request()->is('customer-invoice-reports') ?'active':''}}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('assets/backend/app-assets/icon/list-icon.png')}}" alt="" srcset="" class="img-fluid" width="40" height="20">
        </div>
        <div>Customer Invoice Report</div>
    </a>
    <a href="{{route('stockPosition')}}" class="nav-item nav-link  {{Request::is('stock-position-details')  ? 'active' : '' }}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('icon/list.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div>Item Stock Reports</div>
    </a>
    <a href="{{route('service-reports')}}" class="nav-item nav-link {{Request::is('service-reports')  ? 'active' : '' }}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('icon/list-view.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div>Service Reports</div>
    </a>
    <a href="{{route('third-party-report')}}" class="nav-item nav-link {{Request::is('third-party-report') ? 'active' : '' }}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('icon/stake-holder.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div>3rd Party Reports</div>
    </a>
    <a href="{{route('toll-fee-report')}}" class="nav-item nav-link {{Request::is('toll-fee-report') ? 'active' : '' }}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('icon/payment-voucher.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div>Toll Free </div>
    </a>
    <a href="{{route('vehicle-wise-toll-report')}}" class="nav-item nav-link {{Request::is('vehicle-wise-toll-report') ? 'active' : '' }}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('icon/payment.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div>Vehicle Wise Toll</div>
    </a>
    <a href="{{route('cusher-destination-report')}}" class="nav-item nav-link {{Request::is('cusher-destination-report') ? 'active' : '' }}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('icon/invoice.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div>Route Wise</div>
    </a>
    <a href="{{route('driver-commission')}}" class="nav-item nav-link {{Request::is('driver-commission')?'active':''}}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('assets/backend/app-assets/icon/business-icon.png')}}" alt="" srcset="" class="img-fluid" width="60">
        </div>
        <div>Driver Commission</div>
    </a>
</div>
