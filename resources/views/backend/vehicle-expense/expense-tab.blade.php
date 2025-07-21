<div class="nav nav-tabs master-tab-section" id="nav-tab" role="tablist">
    <a href="{{route("token-gereration.index")}}" class="nav-item nav-link {{Request::is('token-gereration')?'active':''}}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('assets/backend/app-assets/icon/supplier-icon.png')}}" alt="" srcset="" class="img-fluid" width="50" height="20">
        </div>
        <div>Token</div>
    </a>
    <a href="{{route("vehicle-expense.index")}}" class="nav-item nav-link {{Request::is('vehicle-expense')?'active':''}}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('assets/backend/app-assets/icon/list-icon.png')}}" alt="" srcset="" class="img-fluid" width="40" height="20">
        </div>
        <div>Preview</div>
    </a>
    <a href="{{route('vehicle-expense.create')}}" class="nav-item nav-link d-none" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('assets/backend/app-assets/icon/add-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div>Expense Entry</div>
    </a>
    <a href="{{route('item-expense')}}" class="nav-item nav-link {{Request::is('item-expense')?'active':''}}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('assets/backend/app-assets/icon/add-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div>Maintenance Job  </div>
    </a>
    {{-- <a href="{{route('labour-expense.index')}}" class="nav-item nav-link {{Request::is('labour-expense')?'active':''}}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('assets/backend/app-assets/icon/business-icon.png')}}" alt="" srcset="" class="img-fluid" width="60">
        </div>
        <div>Labour Cost</div>
    </a>
    <a href="{{route('labour-expense-add')}}" class="nav-item nav-link {{Request::is('labour-expense-add')?'active':''}}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('assets/backend/app-assets/icon/add-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div>Labour Cost Add</div>
    </a> --}}
</div>
