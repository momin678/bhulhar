<style>
    .bg-secondary {
        background-color: #34465b !important;
        border-radius: 40px;
        color:white  !important;
        padding: 2px 5px 2px 5px !important;
    }
    a.bg-secondary:hover, a.bg-secondary:focus,
    button.bg-secondary:hover,
    button.bg-secondary:focus {
        background-color: #475f7b30 !important;
        color:black!important;
    }
    tr:nth-child(even) {
        background-color: #c8d6e357;
    }
    a.text-dark:hover, a.text-dark:focus {
        color: #ffffff !important;
    }
    .btn-outline-secondary {
        border-radius: 40px;
        padding: 0.2px 9px 0.2px 9px !important;
    }
</style>

<div class="d-flex align-items-center gap-2">
    <a href="{{route("product.index")}}" class="btn btn-outline-secondary nav-item nav-link tabPadding {{  $activeMenu == 'product-create' ? 'bg-secondary text-white' : ' text-dark'}}" role="tab" aria-controls="nav-contact" aria-selected="false" style="margin-right:15px;">
        <div>&nbsp;&nbsp;List&nbsp;&nbsp;</div>
    </a>
    <a href="{{route('category.index')}}" class="btn btn-outline-secondary nav-item nav-link tabPadding {{  $activeMenu == 'category' ? 'bg-secondary text-white' : ' text-dark'}}" role="tab" aria-controls="nav-contact" aria-selected="false" style="margin-right:15px;">
        <div>&nbsp;Category &nbsp;</div>
    </a>
    <a href="{{route('brand.index')}}" class="btn btn-outline-secondary nav-item nav-link tabPadding {{  $activeMenu == 'vehicle-brand' ? 'bg-secondary text-white' : ' text-dark'}}" role="tab" aria-controls="nav-contact" aria-selected="false" style="margin-right:15px;">
        <div>Vehicle Brand</div>
    </a>
    <a href="{{route('vehicle-name.index')}}" class="btn btn-outline-secondary nav-item nav-link tabPadding {{  $activeMenu == 'vehicle-name' ? 'bg-secondary text-white' : ' text-dark'}}" role="tab" aria-controls="nav-contact" aria-selected="false" style="margin-right:15px;">
        <div>Vehicle Name</div>
    </a>
    <a href="{{route('sub-brand.index')}}" class="btn btn-outline-secondary nav-item nav-link tabPadding {{  $activeMenu == 'vehicle-model' ? 'bg-secondary text-white' : ' text-dark'}}" role="tab" aria-controls="nav-contact" aria-selected="false" style="margin-right:15px;">
        <div>Vehicle Model</div>
    </a>
    <a href="{{route('item-code.index')}}" class="btn btn-outline-secondary nav-item nav-link tabPadding {{  $activeMenu == 'item-code' ? 'bg-secondary text-white' : ' text-dark'}}" role="tab" aria-controls="nav-contact" aria-selected="false" style="margin-right:15px;">
        <div>Item Code</div>
    </a>
    @if (Request::route()->getName() == 'product.index')
    <button type="button" class="btn btn-primary formButton " title="Add" data-toggle="modal" style="margin-bottom: 5px" data-target="#excleUpload">
        <div class="d-flex">
            <div class="formSaveIcon">
                <img src="{{asset('assets/backend/app-assets/icon/excel-icon.png')}}" width="25">
            </div>
            <div><span>&nbsp; Import</span></div>
        </div>
    </button>
        
    @endif
</div>
