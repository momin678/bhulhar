<div class="d-flex align-items-center gap-2" style="border-bottom: 1px solid #ddd">
    <a href="{{route('opening-asset')}}" class="nav-item nav-link {{ Request::is('*opening-asset*') ? 'text-white bg-secondary' : ' text-dark'}}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="">Opening Fixed Asset</div>
    </a>


    <a href="{{route('opening-expence')}}" class="nav-item nav-link {{ Request::is('*opening-expence') ? 'text-white bg-secondary' : ' text-dark'}}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="">Opening Expense</div>
    </a>


    <a href="{{route('opening-inventory')}}" class="nav-item nav-link {{ Request::is('*opening-inventory*') ? 'text-white bg-secondary' : ' text-dark'}}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="">Opening Inventory</div>
    </a>


    <a href="{{route('opening-cash-asset')}}" class="nav-item nav-link {{ Request::is('*opening-cash-asset*') ? 'text-white bg-secondary' : ' text-dark'}}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="">Opening Assets</div>
    </a>


    <a href="{{route('opening-reciavable-payable')}}" class="nav-item nav-link {{ Request::is('*opening-reciavable-payable*') ? 'text-white bg-secondary' : ' text-dark'}}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="">Opening Receivables/Payables</div>
    </a>


    <a href="{{route('opening-others')}}" class="nav-item nav-link {{ Request::is('*opening-others*') ? 'text-white bg-secondary' : ' text-dark'}}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="">Opening Others</div>
    </a>
</div>
