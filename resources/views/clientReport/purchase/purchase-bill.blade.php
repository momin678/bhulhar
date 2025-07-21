<style>
    .bg-secondary {
        background-color: #2c3034 !important;
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
        background-color: #475f7b30;
    }
    a.text-dark:hover, a.text-dark:focus {
        color: #ffffff !important;
        background-color: #475f7b30;
    }
    .btn-outline-secondary {
        border-radius: 40px;
        padding: 0.2px 9px 0.2px 9px !important;
    }
    .dropdown-toggle::after {
        display: none !important;
    }
</style>

<div class="d-flex align-items-center gap-2">
    <div>
        <a  href="javascript:void(0);" data-toggle="dropdown" class="btn btn-outline-secondary nav-item nav-link tabPadding dropdown-toggle d-flex nav-link dropdown-user-link {{ $activeMenu == 'bill' ? 'bg-secondary text-white'  :' text-dark'}}" role="tab" aria-controls="nav-contact" aria-selected="false" style="margin-right:15px;">
            <div>&nbsp;&nbsp;&nbsp; Bills &nbsp;</div>
            <i class='bx bxs-down-arrow' style="font-size: 15px"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-left pb-0">
            <a class="dropdown-item" href="{{route('purchase-expense-bill')}}">Create</a>
            <a class="dropdown-item" href="{{route('purchase_approve_bill')}}">Approve</a>
            <a class="dropdown-item" href="{{route('bill-list')}}">List</a>
        </div>
    </div>
    <div>
        <a  href="javascript:void(1);" data-toggle="dropdown" class="btn btn-outline-secondary nav-item nav-link tabPadding dropdown-toggle d-flex nav-link dropdown-user-link {{ $activeMenu == 'garage' ? 'bg-secondary text-white'  :' text-dark'}}" role="tab" aria-controls="nav-contact" aria-selected="false" style="margin-right:15px;">
            <div>&nbsp;&nbsp;&nbsp; Garage Expense &nbsp;</div>
            <i class='bx bxs-down-arrow' style="font-size: 15px"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-left pb-0">
            <a class="dropdown-item" href="{{route('purchase-expense')}}">Create</a>
            <a class="dropdown-item" href="{{route('purchase_approve', 'Garage')}}">Approve</a>
            <a class="dropdown-item" href="{{route('garage-list', 'Garage')}}">List</a>
        </div>
    </div>
    <div>
        <a  href="javascript:void(1);" data-toggle="dropdown" class="btn btn-outline-secondary nav-item nav-link tabPadding dropdown-toggle d-flex nav-link dropdown-user-link {{ $activeMenu == 'office' ? 'bg-secondary text-white'  :' text-dark'}}" role="tab" aria-controls="nav-contact" aria-selected="false" style="margin-right:15px;">
            <div>&nbsp;&nbsp;&nbsp; Office Expense &nbsp;</div>
            <i class='bx bxs-down-arrow' style="font-size: 15px"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-left pb-0">
            <a class="dropdown-item" href="{{route('purchase-expense-office')}}">Create</a>
            <a class="dropdown-item" href="{{route('purchase_approve', 'Office')}}">Approve</a>
            <a class="dropdown-item" href="{{route('garage-list', 'Office')}}">List</a>
        </div>
    </div>
    <a href="{{route('purchase-expense-list')}}" class="btn btn-outline-secondary nav-item nav-link tabPadding {{  $activeMenu == 'list' ? 'bg-secondary text-white' : ' text-dark'}}" role="tab" aria-controls="nav-contact" aria-selected="false" style="margin-right:15px;">
        <div>Expense List</div>
    </a>
    <a href="{{route('expense-distribution.index')}}" class="btn btn-outline-secondary nav-item nav-link tabPadding {{  $activeMenu == 'distribution' ? 'bg-secondary text-white' : ' text-dark'}}" role="tab" aria-controls="nav-contact" aria-selected="false" style="margin-right:15px;">
        <div>Expense Distribution</div>
    </a>
</div>
