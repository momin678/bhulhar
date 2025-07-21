<div class="nav nav-tabs master-tab-section" id="nav-tab" role="tablist">
    <a href="{{route("product.index")}}" class="nav-item nav-link {{ Request::is('product*') ? 'active' : ''}}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('assets/backend/app-assets/icon/truck-icon2.png')}}" alt="" srcset="" class="img-fluid" width="50" height="20">
        </div>
        <div>Products</div>
    </a>
    <a href="{{route("category.index")}}" class="nav-item nav-link {{request()->is('category*') ?'active':''}}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('assets/backend/app-assets/icon/truck-icon.png')}}" alt="" srcset="" class="img-fluid" width="40" height="20">
        </div>
        <div>Category</div>
    </a>
    <a href="{{route('brand.index')}}" class="nav-item nav-link  {{Request::is('brand*')  ? 'active' : '' }}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('assets/backend/app-assets/icon/section-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div>Brand</div>
    </a>

</div>
