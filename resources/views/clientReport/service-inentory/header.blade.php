<div class="nav nav-tabs master-tab-section" id="nav-tab" role="tablist">
    <a href="{{route('token-gereration.index')}}" class="nav-item nav-link {{ $activeMenu=='token' ? 'active' : ' ' }}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('icon/invoice.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div> Token </div>
    </a>
    <a href="{{route('product.index')}}" class="nav-item nav-link {{ $activeMenu=='spare-parts' ? 'active' : ' ' }}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('icon/purchaseexpense-entry.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div> Spare Parts </div>
    </a>

</div>
