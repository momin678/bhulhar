<div class="nav nav-tabs master-tab-section" id="nav-tab" role="tablist">
    <a href="{{route("product.index")}}" class="nav-item nav-link {{ $activeMenu=='product-list' ? 'active' : ' ' }}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('icon/purchaseexpense-entry.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div>&nbsp; &nbsp; Product&nbsp; &nbsp;</div>
    </a>
    <a href="{{route('daily-summery')}}" class="nav-item nav-link {{ $activeMenu == 'daily-summery' ? 'active' : ' ' }}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('icon/list.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div>&nbsp; &nbsp; Daily Summery &nbsp; &nbsp;</div>
    </a>
    <a href="{{route('daily-balance')}}" class="nav-item nav-link {{ $activeMenu == 'daily-balance' ? 'active' : ' ' }}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('icon/payment-voucher.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div>&nbsp; &nbsp; Daily Balance &nbsp; &nbsp;</div>
    </a>
    <a href="{{route('stockPosition')}}" class="nav-item nav-link {{ $activeMenu == 'stock' ? 'active' : ' ' }}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('icon/payment-voucher-list.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div>&nbsp; &nbsp; Stock &nbsp; &nbsp;</div>
    </a>
</div>




