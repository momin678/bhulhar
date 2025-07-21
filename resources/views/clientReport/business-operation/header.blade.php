<div class="nav nav-tabs master-tab-section" id="nav-tab" role="tablist">
    <a href="{{route('customer-invoice')}}" class="nav-item nav-link {{ $activeMenu=='customer_invoice' ? 'active' : ' ' }}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('icon/invoice.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div> Customer Invoice </div>
    </a>

    {{-- <a href="{{route('sale.revenues.create')}}" class="nav-item nav-link {{ $activeMenu=='sale' ? 'active' : ' ' }}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('icon/invoice.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div> Sale </div>
    </a> --}}


    <a href="{{route('supplier-invoice')}}" class="nav-item nav-link {{ $activeMenu=='supplier_invoice' ? 'active' : ' ' }}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('icon/purchaseexpense-entry.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div> Supplier Invoice </div>
    </a>
    <a href="{{route('toll-fees-recharge.index')}}" class="nav-item nav-link {{ $activeMenu=='toll_fees_recharge' ? 'active' : ' ' }}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('icon/payable.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div> Toll Fees Recharge </div>
    </a>
    <a href="{{route('toll-fees-payment.index')}}" class="nav-item nav-link {{ $activeMenu=='toll_fees_payment' ? 'active' : ' ' }}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('icon/list.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div> Toll Fees Payment </div>
    </a>

</div>
