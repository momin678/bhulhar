<div class="nav nav-tabs master-tab-section" id="nav-tab" role="tablist">
    <a href="{{route("user.index")}}" class="nav-item nav-link {{ Request::is('user*') ? 'active' : ''}}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('assets/backend/app-assets/icon/employee-icon.png')}}" alt="" srcset="" class="img-fluid" width="50" height="20">
        </div>
        <div>User Management</div>
    </a>
    <a href="{{route("role.index")}}" class="nav-item nav-link {{request()->is('role*') ?'active':''}}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('assets/backend/app-assets/icon/invoice-authorize-icon.png')}}" alt="" srcset="" class="img-fluid" width="40" height="20">
        </div>
        <div>Role</div>
    </a>
    <a href="{{route('settings.index')}}" class="nav-item nav-link  {{Request::is('settings*')  ? 'active' : '' }}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('assets/backend/app-assets/icon/section-detail-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div>Settings</div>
    </a>
    <a href="{{route('company-setup.index')}}" class="nav-item nav-link  {{Request::is('company-setup*')  ? 'active' : '' }}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('assets/backend/app-assets/icon/section-detail-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div>User Setup</div>
    </a>

</div>
