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

<div class="d-flex align-items-center p-1">    
    <a href="{{route("token-gereration.index")}}" class="btn btn-outline-secondary nav-item nav-link tabPadding {{  $activeMenu == 'create' ? 'bg-secondary text-white' : ' text-dark'}}" role="tab" aria-controls="nav-contact" aria-selected="false" style="margin-right:15px;">
        <div>Create Token</div>
    </a>
    <a href="{{route('vehicle-expense.index')}}" class="btn btn-outline-secondary nav-item nav-link tabPadding {{  $activeMenu == 'vehicle_expense' ? 'bg-secondary text-white' : ' text-dark'}}" role="tab" aria-controls="nav-contact" aria-selected="false" style="margin-right:15px;">
        <div>Preview</div>
    </a>
    <a href="{{route('item-expense')}}" class="btn btn-outline-secondary nav-item nav-link tabPadding {{  $activeMenu == 'maintenance_job' ? 'bg-secondary text-white' : ' text-dark'}}" role="tab" aria-controls="nav-contact" aria-selected="false" style="margin-right:15px;">
        <div>Maintenance Job</div>
    </a>
</div>
