<div class="nav nav-tabs master-tab-section" id="nav-tab" role="tablist">
    <a href="{{route("purchase.index")}}" class="nav-item nav-link {{ $activeMenu=='purchase_create' ? 'active' : ' ' }}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('icon/purchaseexpense-entry.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div>Purchase</div>
    </a>
    <a href="{{route('purchase-list')}}" class="nav-item nav-link {{ $activeMenu == 'list' ? 'active' : ' ' }}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('icon/list.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp List &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</div>
    </a>
</div>




