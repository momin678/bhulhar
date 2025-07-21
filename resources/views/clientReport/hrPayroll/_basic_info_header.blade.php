<style>
    .card{
        margin-bottom: 0.5rem;
    }
</style>
<div class="nav nav-tabs master-tab-section" id="nav-tab" role="tablist">
    <a href="{{ route('employees.index') }}" class="nav-item nav-link {{$activeMenu == 'employee-profile' ? 'active' : '' }}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('assets/backend/app-assets/icon/employee-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div> Employee Profile </div>
    </a>
    @if (Auth::user()->hasPermission('salary_procedure'))
    {{-- <a href="{{ route('division.index') }}" class="nav-item nav-link {{$activeMenu == 'base-table' ? 'active' : '' }}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('assets/backend/app-assets/icon/supplier-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div> Salary Procedure </div>
    </a> --}}
    
   @endif
   <a href="{{route('grade-wise-salary-components.index')}}" class="nav-item nav-link {{ $activeMenu == 'grade-wise-salary-components' ? 'active' : '' }}" role="tab" aria-controls="nav-contact" aria-selected="false" id="parentProfileTab">
    <div class="master-icon text-cente">
        <img src="{{asset('assets/backend/app-assets/icon/expenses-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
    </div>
    <div class="text-dark"> Salary Procedure </div>
</a>
    <a href="{{ route('division.index') }}" class="nav-item nav-link {{$activeMenu == 'base-table' ? 'active' : '' }}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('assets/backend/app-assets/icon/supplier-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div> Base Table  </div>
    </a>

</div>
