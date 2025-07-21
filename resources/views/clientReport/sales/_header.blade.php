<div class="nav nav-tabs master-tab-section print-hideen" id="nav-tab" role="tablist">

    <a href="{{route("saleIssue")}}" class="nav-item nav-link {{ $activeMenu=='invoice' ? 'active' : ' ' }}" role="tab" aria-controls="nav-contact" aria-selected="false">
        <div class="master-icon text-cente">
            <img src="{{asset('icon/invoice.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp Invoice  &nbsp &nbsp  &nbsp &nbsp &nbsp</div>
    </a>
    <a href="{{route("sale-list")}}" class="nav-item nav-link {{ $activeMenu == 'list' ? 'active' : ' ' }}" role="tab" aria-controls="nav-contact" aria-selected="false" id="mJournalAuthorizationSection">
        <div class="master-icon text-cente">
            <img src="{{asset('icon/list.png')}}" alt="" srcset="" class="img-fluid" width="50">
        </div>
        <div>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp List &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</div>
    </a>

</div>




