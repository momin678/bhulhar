<div class="nav nav-tabs master-tab-section print-hideen " id="nav-tab" role="tablist">
    @if (Auth::user()->hasPermission('Quotation'))
    <a href="{{route('lpo-projects.index')}}" class="nav-item nav-link {{ request()->is('*lpo-projects*') ? 'active' : '' }}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('assets/backend/app-assets/icon/fee-structure-icon.png')}}" alt="" srcset="" class="img-fluid" width="50" height="20">
        </div>
        <div class="text-center"> Quotation </div>
    </a>
    @endif
    @if (Auth::user()->hasPermission('Work_Order'))
    <a href="{{route('projects.index')}}" class="nav-item nav-link {{ request()->is('*/projects*') || request()->is('*work/statuion/create*') ? 'active' : '' }}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('assets/backend/app-assets/icon/payroll-icon.png')}}" alt="" srcset="" class="img-fluid" width="50" height="20">
        </div>
        <div> Work Order </div>
    </a>
    @endif
    @if (Auth::user()->hasPermission('p_Invoice'))
    <a href="{{route('project.invoice.index')}}" class="nav-item nav-link {{ request()->is('*job/project*/invoice*') ? 'active' : '' }}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('assets/backend/app-assets/icon/document-icon.png')}}" alt="" srcset="" class="img-fluid" width="50" height="20">
        </div>
        <div> Invoice  </div>
    </a>
    @endif
    <a href="{{route('projects.report')}}" class="nav-item nav-link {{ request()->is('*jobprojects/*reports') ? 'active' : '' }}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('assets/backend/app-assets/icon/report.png')}}" alt="" srcset="" class="img-fluid" width="50" height="20">
        </div>
        <div> Report </div>
    </a>
</div>
