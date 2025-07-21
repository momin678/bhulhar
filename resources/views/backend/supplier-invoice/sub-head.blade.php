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
    <a href="{{route("supplier-invoice")}}" class="btn btn-outline-secondary nav-item nav-link tabPadding {{  $activeMenu == 'create' ? 'bg-secondary text-white' : ' text-dark'}}" role="tab" aria-controls="nav-contact" aria-selected="false" style="margin-right:15px;">
        <div>Create Invoice</div>
    </a>
    <a href="{{route('supplier-draft-invoice-list')}}" class="btn btn-outline-secondary nav-item nav-link tabPadding {{  $activeMenu == 'draft' ? 'bg-secondary text-white' : ' text-dark'}}" role="tab" aria-controls="nav-contact" aria-selected="false" style="margin-right:15px;">
        <div>Draft Invoice</div>
    </a>
    <a href="{{route('authorize-supplier-invoice')}}" class="btn btn-outline-secondary nav-item nav-link tabPadding {{  $activeMenu == 'authorize' ? 'bg-secondary text-white' : ' text-dark'}}" role="tab" aria-controls="nav-contact" aria-selected="false" style="margin-right:15px;">
        <div>Pending For Authorize</div>
    </a>
    <a href="{{route('approval-supplier-invoice')}}" class="btn btn-outline-secondary nav-item nav-link tabPadding {{  $activeMenu == 'approved' ? 'bg-secondary text-white' : ' text-dark'}}" role="tab" aria-controls="nav-contact" aria-selected="false" style="margin-right:15px;">
        <div>Approval Invoices</div>
    </a>
    <a href="{{route('supplier-invoice-list')}}" class="btn btn-outline-secondary nav-item nav-link tabPadding {{  $activeMenu == 'supplier' ? 'bg-secondary text-white' : ' text-dark'}}" role="tab" aria-controls="nav-contact" aria-selected="false" style="margin-right:15px;">
        <div>Supplier Invoices</div>
    </a>
    <a href="{{route('declined-supplier-invoice')}}" class="btn btn-outline-secondary nav-item nav-link tabPadding {{  $activeMenu == 'declined' ? 'bg-secondary text-white' : ' text-dark'}}" role="tab" aria-controls="nav-contact" aria-selected="false" style="margin-right:15px;">
        <div>Declined Invoices</div>
    </a>
    {{-- <a href="{{route('search-supplier-invoice')}}" class="btn btn-outline-secondary nav-item nav-link tabPadding {{  $activeMenu == 'list' ? 'bg-secondary text-white' : ' text-dark'}}" role="tab" aria-controls="nav-contact" aria-selected="false" style="margin-right:15px;">
        <div>Invoices List</div>
    </a> --}}
</div>
