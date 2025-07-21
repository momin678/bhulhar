<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow print-hidden" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto"><a class="navbar-brand" href="{{route('home')}}">

                    @php
                        $settings= \App\Setting::where('config_name', 'company_name')->first()
                    @endphp

                    <p style="font-size: 14px; color: #fff;">{{ $settings->config_value}}</p>
                </a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation" data-icon-style="">

            <li class="dropdown" id="sidebar-dropdown">
                <a href="{{ route('setup.report') }}" class="btn w-100 dropdown-toggle text-left
                    {{  (request()->is('setup/report')) ||
                     (request()->is('accounting/new-chart-of-account')) ||
                     (request()->is('accounting/cost-center-details')) ||
                     (request()->is('accounting/profit-details')) ||
                     (request()->is('accounting/party-info')) ||
                       (request()->is('accounting/new-account-head')) ? 'active' : ' ' }}">
                    Setup
                </a>
                <div id="dropdown-menu" class="{{ (request()->is('accounting*')) || (request()->is('setup/report')) ?  'show' : 'd-none'  }}">

                    {{-- @if (Auth::user()->hasPermission('Chart_of_Accounts')) --}}
                    <a class="dropdown-item {{ request()->is('accounting/new-chart-of-account') || request()->is('accounting/new-account-head') || request()->is('setup/new-account-head') ? 'active' : '' }}" href="{{ route('new-chart-of-account') }}">
                        <i class="bx bx-check-shield"></i>
                        <span class="menu-title text-truncate" data-i18n="Cost Center"> Chart of Accounts </span>
                    </a>
                    {{-- @endif --}}
                    {{-- @if (Auth::user()->hasPermission('Stake_Holder')) --}}
                    <a class="dropdown-item
                    {{(request()->is('*profit-details')) || request()->is('*-center/edit*') || request()->is('*cost-center-details') || request()->is('*party-info*') ? 'active' : '' }}
                    {{(request()->is('party-info')) || request()->is('*service-provider') || request()->is('new-donar') || request()->is('new-charity') ? 'active' : '' }}"
                    href="{{ route('costCenterDetails') }}">
                        <i class="bx bx-check-shield"></i>
                        <span class="menu-title text-truncate" data-i18n="Cost Center"> Stake Holder </span>
                    </a>
                    {{-- @endif --}}
                </div>
            </li>

            <li class="dropdown" id="sidebar-dropdown">
                <a href="{{ route('account-head1') }}" class="btn w-100 dropdown-toggle text-left
                    {{ (request()->is('setup/account-head')) ? 'active' : ' ' }}">
                    Account Head
                </a>
                <div id="dropdown-menu" class="{{ (request()->is('setup/account-head')) ?  'show' : 'd-none'  }}">

                    <a class="dropdown-item {{ request()->is('setup/account-head') ? 'active' : '' }}" href="{{ route('account-head1') }}">
                        <i class="bx bx-check-shield"></i>
                        <span class="menu-title text-truncate" data-i18n="Cost Center"> Chart of Accounts </span>
                    </a>

                </div>
            </li>
            @if (Auth::user()->hasPermission('app.invoice.invoice_create') || Auth::user()->hasPermission('app.invoice.invoice_authorize') || Auth::user()->hasPermission('app.invoice.invoice_approval') || Auth::user()->hasPermission('app.invoice.invoice_view'))

            <li class="dropdown" id="sidebar-dropdown">
                <a href="{{ route('vehicle.index') }}" class="btn w-100 dropdown-toggle text-left
                    {{ (request()->is('vehicle*')) && !Request::is('vehicle-expense*') && !Request::is('vehicle-wise*')  ? 'active' : ' ' }}">
                    Vehicle
                </a>
                <div id="dropdown-menu" class="{{ (request()->is('vehicle*')) && !Request::is('vehicle-expense*') && !Request::is('vehicle-wise*')  ?  'show' : 'd-none'  }}">

                    {{-- @if (Auth::user()->hasPermission('Chart_of_Accounts')) --}}
                    <a class="dropdown-item {{request()->is('vehicle/vehicle')  ? 'active' : '' }}" href="{{ route('vehicle.index') }}">
                        <i class="bx bx-check-shield"></i>
                        <span class="menu-title text-truncate" data-i18n="Cost Center"> Vehicle</span>
                    </a>
                    {{-- @endif --}}
                    {{-- @if (Auth::user()->hasPermission('Stake_Holder')) --}}
                    <a class="dropdown-item {{request()->is('vehicle-service')  ? 'active' : '' }}"
                    href="{{ route('vehicle-service') }}">
                        <i class="bx bx-check-shield"></i>
                        <span class="menu-title text-truncate" data-i18n="Cost Center"> Service </span>
                    </a>
                    {{-- @endif --}}
                    <a class="dropdown-item {{request()->is('vehicle/driver')  ? 'active' : '' }}" href="{{ route('driver.index') }}">
                        <i class="bx bx-check-shield"></i>
                        <span class="menu-title text-truncate" data-i18n="Cost Center"> Driver</span>
                    </a>
                    {{-- @endif --}}
                    {{-- @if (Auth::user()->hasPermission('Stake_Holder')) --}}
                    <a class="dropdown-item {{request()->is('vehicle/material')  ? 'active' : '' }}"
                    href="{{ route('material.index') }}">
                        <i class="bx bx-check-shield"></i>
                        <span class="menu-title text-truncate" data-i18n="Cost Center"> Material </span>
                    </a>
                    {{-- @endif --}}

                    {{-- @if (Auth::user()->hasPermission('Chart_of_Accounts')) --}}
                    <a class="dropdown-item {{request()->is('vehicle/crusher')  ? 'active' : '' }}" href="{{ route('crusher.index') }}">
                        <i class="bx bx-check-shield"></i>
                        <span class="menu-title text-truncate" data-i18n="Cost Center"> Source</span>
                    </a>
                    {{-- @endif --}}
                    {{-- @if (Auth::user()->hasPermission('Stake_Holder')) --}}
                    <a class="dropdown-item {{request()->is('vehicle/destination')  ? 'active' : '' }}"
                    href="{{ route('destination.index') }}">
                        <i class="bx bx-check-shield"></i>
                        <span class="menu-title text-truncate" data-i18n="Cost Center"> Destination </span>
                    </a>
                    {{-- @endif --}}
                    {{-- @if (Auth::user()->hasPermission('Stake_Holder')) --}}
                    <a class="dropdown-item {{request()->is('vehicle/rate')  ? 'active' : '' }}"
                        href="{{ route('rate.index') }}">
                            <i class="bx bx-check-shield"></i>
                            <span class="menu-title text-truncate" data-i18n="Cost Center"> Route </span>
                        </a>
                        {{-- @endif --}}

                </div>
            </li>
            @endif
            <li class="dropdown" id="sidebar-dropdown">
                <a href="{{ route('business-operation.report') }}" class="btn w-100 dropdown-toggle text-left
                    {{ (request()->is('business-operation*')) ? 'active' : ' ' }}">
                    Business Operation
                </a>
                <div id="dropdown-menu" class="{{ (request()->is('business-operation*')) ?  'show' : 'd-none'  }}">

                    <a class="dropdown-item {{ request()->is('business-operation/customer-invoice')||request()->is('business-operation/invoice-summery-view*')||request()->is('business-operation/customer-invoice-edit*')||request()->is('business-operation/temp-toll-invoice-view*')||request()->is('business-operation/temp-invoice-sumview*')||request()->is('business-operation/pre-invoice-view*')||request()->is('business-operation/toll-fee-invoice-sumview*')||request()->is('business-operation/invoice-approval-list')||request()->is('business-operation/approved-invoice-list')||request()->is('business-operation/declined-invoice-list')||request()->is('business-operation/search-customer-invoice') ? 'active' : '' }}" href="{{ route('customer-invoice') }}">
                        <i class="bx bx-check-shield"></i>
                        <span class="menu-title text-truncate" data-i18n="Cost Center"> Customer Invoice </span>
                    </a>
                    <a class="dropdown-item {{ request()->is('business-operation/supplier*') || request()->is('business-operation/authorize-supplier-invoice*') || request()->is('business-operation/approval-supplier-invoice*') || request()->is('business-operation/draft-pre-supplier-invoice-view*') || request()->is('business-operation/pre-supplier-invoice-view*') ? 'active' : '' }}" href="{{ route('supplier-invoice') }}">
                        <i class="bx bx-check-shield"></i>
                        <span class="menu-title text-truncate" data-i18n="Cost Center"> Supplier Invoice </span>
                    </a>
                    
                    @php
                        $toll_setup = App\Setup::where('name', 'Toll Setup')->first();
                    @endphp
                    @if ($toll_setup->value == 'Automatic')
                        <a class="dropdown-item {{ request()->is('business-operation/toll-fees-recharge*') ? 'active' : '' }}" href="{{ route('toll-fees-recharge.index') }}">
                            <i class="bx bx-check-shield"></i>
                            <span class="menu-title text-truncate" data-i18n="Cost Center"> Toll Fees Recharge </span>
                        </a>
                        <a class="dropdown-item {{ request()->is('business-operation/toll-fees-payment*') ? 'active' : '' }}" href="{{route('toll-fees-payment.index')}}">
                            <i class="bx bx-check-shield"></i>
                            <span class="menu-title text-truncate" data-i18n="Cost Center"> Toll Fees Payment </span>
                        </a>
                    @endif

                </div>
            </li>
            <li class="dropdown" id="sidebar-dropdown">
                <a href="{{ route('service-inventory.report') }}" class="btn w-100 dropdown-toggle text-left
                    {{ (request()->is('service-inventory*')) ? 'active' : ' ' }}">
                    Service & Inventory
                </a>
                <div id="dropdown-menu" class="{{ (request()->is('service-inventory*')) ?  'show' : 'd-none'  }}">

                    <a class="dropdown-item {{ request()->is('service-inventory/token-gereration') || request()->is('service-inventory/vehicle-expense') || request()->is('service-inventory/item-expense') ? 'active' : '' }}" href="{{ route('token-gereration.index') }}">
                        <i class="bx bx-check-shield"></i>
                        <span class="menu-title text-truncate" data-i18n="Cost Center"> Token </span>
                    </a>
                    <a class="dropdown-item {{ request()->is('service-inventory/product*') || request()->is('service-inventory/category*') || request()->is('service-inventory/brand*') ? 'active' : '' }}" href="{{ route('product.index') }}">
                        <i class="bx bx-check-shield"></i>
                        <span class="menu-title text-truncate" data-i18n="Cost Center"> Spare Parts </span>
                    </a>

                </div>
            </li>
            {{-- @if (Auth::user()->hasPermission('app.invoice.invoice_create') || Auth::user()->hasPermission('app.invoice.invoice_authorize') || Auth::user()->hasPermission('app.invoice.invoice_approval') || Auth::user()->hasPermission('app.invoice.invoice_view'))
            <li class="dropdown" id="sidebar-dropdown">
                <a href="{{ route('customer-invoice') }}" class="btn w-100 dropdown-toggle text-left
                    {{ (request()->is('customer-inv*') && !request()->is('customer-invoice*'))  ? 'active' : ' ' }}">
                    Customer Invoice
                </a>
                <div id="dropdown-menu" class="{{ (request()->is('customer-inv*') && !request()->is('customer-invoice*'))  ?  'show' : 'd-none'  }}">

                    <a class="dropdown-item {{request()->is('customer-inv/customer-invoice*')  ? 'active' : '' }}" href="{{ route('customer-invoice') }}">
                        <i class="bx bx-check-shield"></i>
                        <span class="menu-title text-truncate" data-i18n="Cost Center"> Invoice</span>
                    </a>
                    <a class="dropdown-item {{request()->is('customer-inv/invoice-approval-list*')   ? 'active' :  (isset($invoice_status)? ($invoice_status=='Approve'?'active':''):'') }}"
                    href="{{ route('invoice-approval-list') }}">
                        <i class="bx bx-check-shield"></i>
                        <span class="menu-title text-truncate" data-i18n="Cost Center"> Approval </span>
                    </a>
                    <a class="dropdown-item {{request()->is('customer-inv/approved-invoice-list*') || request()->is('customer-inv/invoice-summery-view*') || request()->is('customer-inv/invoice-view*') ? 'active' : '' }}" href="{{ route('approved-invoice-list') }}">
                        <i class="bx bx-check-shield"></i>
                        <span class="menu-title text-truncate" data-i18n="Cost Center"> Invoice List</span>
                    </a>
                    <a class="dropdown-item {{request()->is('customer-inv/declined-invoice-list*')  ? 'active' : (isset($invoice_status)? ($invoice_status=='Decline' ?'active':''):'') }}"
                    href="{{ route('declined-invoice-list') }}">
                        <i class="bx bx-check-shield"></i>
                        <span class="menu-title text-truncate" data-i18n="Cost Center"> Pending / Declined </span>
                    </a>
                    <a class="dropdown-item {{request()->is('customer-inv/search-customer-invoice*') || request()->is('customer-inv/toll-fee-invoice-sumview*') || request()->is('customer-inv/temp-toll-invoice-view*')  ? 'active' : '' }}"
                        href="{{ route('search-customer-invoice') }}">
                            <i class="bx bx-check-shield"></i>
                            <span class="menu-title text-truncate" data-i18n="Cost Center"> Toll Fee Invoice </span>
                        </a>
                </div>
            </li>
            @endif
            @if (Auth::user()->hasPermission('app.invoice.invoice_create') || Auth::user()->hasPermission('app.invoice.invoice_authorize') || Auth::user()->hasPermission('app.invoice.invoice_approval') || Auth::user()->hasPermission('app.invoice.invoice_view'))
            <li class="dropdown" id="sidebar-dropdown">
                <a href="{{ route('supplier-invoice') }}"
                class="btn w-100 dropdown-toggle text-left {{ (Request::is('supplier') ||
                     Request::is('supplier-draft-invoice-list') ||
                     Request::is('authorize-supplier-invoice*') ||
                     Request::is('approval-supplier-invoice*') ||
                     Request::is('supplier-invoice-list*') ||
                     Request::is('declined-supplier-invoice*') ||
                     Request::is('search-supplier-invoice*'))||
                     request()->is('draft-pre-supplier-invoice-view*')
                     || request()->is('supplier-invoice-summery-view*')
                     || request()->is('supplier-invoice-view*') || request()->is('supplier-invoice-process*')  ? 'active' :  (isset($invoice_status)? ($invoice_status=='Authorize1' || $invoice_status=='Approve1' || $invoice_status=='Decline1'?'active':''):'') }}">
                 Supplier Invoice
             </a>

                <div id="dropdown-menu" class="{{ (Request::is('supplier') ||
                Request::is('supplier-draft-invoice-list') ||
                Request::is('authorize-supplier-invoice*') ||
                Request::is('approval-supplier-invoice*') ||
                Request::is('supplier-invoice-list*') ||
                Request::is('declined-supplier-invoice*') ||
                Request::is('search-supplier-invoice*'))||
                request()->is('draft-pre-supplier-invoice-view*')
                || request()->is('supplier-invoice-summery-view*') || request()->is('supplier-invoice-view*') ||  request()->is('supplier-invoice-process*')  ?  'show' : (isset($invoice_status)? ($invoice_status=='Authorize1' || $invoice_status=='Approve1' || $invoice_status=='Decline1'?'show':'d-none'):'d-none')  }}">

                    <a class="dropdown-item {{Request::is('supplier') ||  request()->is('supplier-invoice-process*')  ? 'active' : '' }}" href="{{ route('supplier-invoice') }}">
                        <i class="bx bx-check-shield"></i>
                        <span class="menu-title text-truncate" data-i18n="Cost Center"> Supplier</span>
                    </a>
                    <a class="dropdown-item {{ Request::is('supplier-draft-invoice-list') || request()->is('draft-pre-supplier-invoice-view*') || request()->is('customer-inv/draft-invoice-edit*') ? 'active' : ''}}"
                    href="{{ route('supplier-draft-invoice-list') }}">
                        <i class="bx bx-check-shield"></i>
                        <span class="menu-title text-truncate" data-i18n="Cost Center"> Draft </span>
                    </a>
                    <a class="dropdown-item {{request()->is('authorize-supplier-invoice*')   ? 'active' : (isset($invoice_status)? ($invoice_status=='Authorize1'?'active':''):'') }}" href="{{ route('authorize-supplier-invoice') }}">
                        <i class="bx bx-check-shield"></i>
                        <span class="menu-title text-truncate" data-i18n="Cost Center"> Authorization</span>
                    </a>
                    <a class="dropdown-item {{Request::is('approval-supplier-invoice*')    ? 'active' :  (isset($invoice_status)? ($invoice_status=='Approve1'?'active':''):'') }}"
                    href="{{ route('approval-supplier-invoice') }}">
                        <i class="bx bx-check-shield"></i>
                        <span class="menu-title text-truncate" data-i18n="Cost Center"> Approval </span>
                    </a>
                    <a class="dropdown-item {{ Request::is('supplier-invoice-list*') || request()->is('supplier-invoice-summery-view*') || request()->is('supplier-invoice-view*') ? 'active' : '' }}" href="{{ route('supplier-invoice-list') }}">
                        <i class="bx bx-check-shield"></i>
                        <span class="menu-title text-truncate" data-i18n="Cost Center"> Supplier Invoices</span>
                    </a>
                    <a class="dropdown-item {{Request::is('declined-supplier-invoice*')  ? 'active' : (isset($invoice_status)? ($invoice_status=='Decline1' ?'active':''):'') }}"
                    href="{{ route('declined-supplier-invoice') }}">
                        <i class="bx bx-check-shield"></i>
                        <span class="menu-title text-truncate" data-i18n="Cost Center"> Pending / Declined </span>
                    </a>
                    <a class="dropdown-item {{Request::is('search-supplier-invoice*')|| request()->is('customer-inv/toll-fee-invoice-sumview*') || request()->is('customer-inv/temp-toll-invoice-view*')  ? 'active' : '' }}"
                        href="{{ route('search-supplier-invoice') }}">
                            <i class="bx bx-check-shield"></i>
                            <span class="menu-title text-truncate" data-i18n="Cost Center"> Toll Fee Invoice </span>
                    </a>
                </div>
            </li>
            @endif --}}



            {{-- @if (Auth::user()->hasPermission('Bill') ||
            Auth::user()->hasPermission('Payment_Voucher') ||
            Auth::user()->hasPermission('Payment_List')||
            Auth::user()->hasPermission('p_List')) --}}
            <li class="dropdown" id="sidebar-dropdown">
                <a href="{{ route('purchase-expense-bill') }}" class="btn w-100 dropdown-toggle text-left
                    {{ (request()->is('purchase*')) ? 'active' : ' ' }}">
                    Bill
                </a>
                <div id="dropdown-menu" class="{{ (request()->is('purchase*')) ?  'show' : 'd-none'  }}">
                    {{-- @if (Auth::user()->hasPermission('Bill')) --}}
                    <a class="dropdown-item {{ request()->is('*purchase-expense-bill') || request()->is('*purchase-approve-bill')  ? 'active' : '' }}" href="{{route("purchase-expense")}}">
                        <i class="bx bx-check-shield"></i>
                        <span class="menu-title text-truncate" data-i18n="Cost Center"> Bill </span>
                    </a>

                    <a class="dropdown-item {{ request()->is('purchase/garage-list/Garage') || request()->is('*purchase-expense-garage') || request()->is('*purchase-approve-bill/Garage')  ? 'active' : '' }}" href="{{route("purchase-expense")}}">
                        <i class="bx bx-check-shield"></i>
                        <span class="menu-title text-truncate" data-i18n="Cost Center"> Garage Expense </span>
                    </a>


                    <a class="dropdown-item {{ request()->is('purchase/garage-list/Office') || request()->is('*purchase-expense-office') || request()->is('*purchase-approve-bill/Office') ? 'active' : '' }}" href="{{route("purchase-expense")}}">
                        <i class="bx bx-check-shield"></i>
                        <span class="menu-title text-truncate" data-i18n="Cost Center"> Office Expense </span>
                    </a>
                    {{-- @endif
                    @if (Auth::user()->hasPermission('p_List')) --}}
                    <a class="dropdown-item {{ request()->is('*purchase-expense-list') ? 'active' : '' }}" href="{{route("purchase-expense-list")}}">
                        <i class="bx bx-check-shield"></i>
                        <span class="menu-title text-truncate" data-i18n="Cost Center"> List </span>
                    </a>
                    <a class="dropdown-item {{ request()->is('*expense-distribution') ? 'active' : '' }}" href="{{route("expense-distribution.index")}}">
                        <i class="bx bx-check-shield"></i>
                        <span class="menu-title text-truncate" data-i18n="Cost Center"> Expense Distribution </span>
                    </a>
                    {{-- @endif
                     
                </div>
            </li>
            {{-- @endif --}}
            <li class="dropdown" id="sidebar-dropdown">
                <a href="{{ route('fund-allocation.index') }}"class="btn w-100  text-left {{ request()->is('business/fund-allocation-approve*') || request()->is('business/fund-allocation*') ? 'active' : ' ' }}">
                    Business
                </a>
            </li>
            @if (Auth::user()->hasPermission('app.invoice.invoice_create') || Auth::user()->hasPermission('app.invoice.invoice_authorize') || Auth::user()->hasPermission('app.invoice.invoice_approval') || Auth::user()->hasPermission('app.invoice.invoice_view'))
            <li class="dropdown" id="sidebar-dropdown">
                <a href="{{ route('token-gereration.index') }}"
                class="btn w-100 dropdown-toggle text-left {{ (Request::is('token-generation') || request()->is('token-gereration*') || Request::is('vehicle-expense') || Request::is('item-expense')) ? 'active' : '' }}"> Token </a>

                <div id="dropdown-menu" class="{{(Request::is('token-generation') || request()->is('token-gereration*') || Request::is('vehicle-expense') || Request::is('item-expense')) ?  'show':'d-none'  }}">

                    {{-- @if (Auth::user()->hasPermission('Chart_of_Accounts')) --}}
                    <a class="dropdown-item {{ request()->is('token-gereration*')  ? 'active' : '' }}" href="{{ route('token-gereration.index') }}">
                        <i class="bx bx-check-shield"></i>
                        <span class="menu-title text-truncate" data-i18n="Cost Center"> Token</span>
                    </a>
                    {{-- @endif --}}
                    {{-- @if (Auth::user()->hasPermission('Stake_Holder')) --}}
                    <a class="dropdown-item {{ Request::is('vehicle-expense') ? 'active' : ''}}"
                    href="{{ route('vehicle-expense.index') }}">
                        <i class="bx bx-check-shield"></i>
                        <span class="menu-title text-truncate" data-i18n="Cost Center"> Preview</span>
                    </a>
                    {{-- @endif --}}
                    <a class="dropdown-item {{Request::is('item-expense') ? 'active':'' }}" href="{{ route('item-expense') }}">
                        <i class="bx bx-check-shield"></i>
                        <span class="menu-title text-truncate" data-i18n="Cost Center"> Maintenance Job</span>
                    </a>
                    {{-- @endif --}}

                </div>
            </li>
            @endif
            @if (Auth::user()->hasPermission('app.invoice.invoice_create') || Auth::user()->hasPermission('app.invoice.invoice_authorize') || Auth::user()->hasPermission('app.invoice.invoice_approval') || Auth::user()->hasPermission('app.invoice.invoice_view'))

            <li class="dropdown" id="sidebar-dropdown">
                <a href="{{ route('vehicle-expense-reports') }}" class="btn w-100 dropdown-toggle text-left
                    {{ (Request::is('vehicle-expense-reports') || Request::is('customer-invoice-reports')
                    || Request::is('stock-position-details') || Request::is('service-reports') || Request::is('third-party-report')|| Request::is('toll-fee-report')|| Request::is('toll-name-wise-report')|| Request::is('vehicle-wise-toll-report')|| Request::is('cusher-destination-report'))   ? 'active' : ' ' }}">
                    Daily  Reports
                </a>
                <div id="dropdown-menu" class="{{ (Request::is('vehicle-expense-reports') || Request::is('customer-invoice-reports')
                || Request::is('stock-position-details') || Request::is('service-reports') || Request::is('third-party-report')|| Request::is('toll-fee-report')|| Request::is('toll-name-wise-report')|| Request::is('vehicle-wise-toll-report')|| Request::is('cusher-destination-report'))  ?  'show' : 'd-none'  }}">

                    {{-- @if (Auth::user()->hasPermission('Chart_of_Accounts')) --}}
                    <a class="dropdown-item {{Request::is('vehicle-expense-reports')  ? 'active' : '' }}" href="{{ route('vehicle-expense-reports') }}">
                        <i class="bx bx-check-shield"></i>
                        <span class="menu-title text-truncate" data-i18n="Cost Center"> Vehicle ROI Report</span>
                    </a>
                    {{-- @endif --}}
                    {{-- @if (Auth::user()->hasPermission('Stake_Holder')) --}}
                    <a class="dropdown-item {{request()->is('customer-invoice-reports')  ? 'active' : '' }}"
                    href="{{ route('customer-invoice-reports') }}">
                        <i class="bx bx-check-shield"></i>
                        <span class="menu-title text-truncate" data-i18n="Cost Center"> Customer Invoice Report </span>
                    </a>
                    {{-- @endif --}}
                    <a class="dropdown-item {{Request::is('stock-position-details')  ? 'active' : '' }}" href="{{ route('stockPosition') }}">
                        <i class="bx bx-check-shield"></i>
                        <span class="menu-title text-truncate" data-i18n="Cost Center"> Item Stock Reports</span>
                    </a>
                    {{-- @endif --}}
                    {{-- @if (Auth::user()->hasPermission('Stake_Holder')) --}}
                    <a class="dropdown-item {{Request::is('service-reports')  ? 'active' : '' }}"
                    href="{{ route('service-reports') }}">
                        <i class="bx bx-check-shield"></i>
                        <span class="menu-title text-truncate" data-i18n="Cost Center"> Service Reports </span>
                    </a>
                    {{-- @endif --}}

                    {{-- @if (Auth::user()->hasPermission('Chart_of_Accounts')) --}}
                    <a class="dropdown-item {{Request::is('third-party-report') ? 'active' : '' }}" href="{{ route('third-party-report') }}">
                        <i class="bx bx-check-shield"></i>
                        <span class="menu-title text-truncate" data-i18n="Cost Center"> Third Party Reports</span>
                    </a>
                    {{-- @endif --}}
                    {{-- @if (Auth::user()->hasPermission('Stake_Holder')) --}}
                    <a class="dropdown-item {{Request::is('toll-fee-report')  ? 'active' : '' }}"
                    href="{{ route('toll-fee-report') }}">
                        <i class="bx bx-check-shield"></i>
                        <span class="menu-title text-truncate" data-i18n="Cost Center"> Toll Fee Reports </span>
                    </a>
                    {{-- @endif --}}
                    {{-- @if (Auth::user()->hasPermission('Stake_Holder')) --}}
                    <a class="dropdown-item {{Request::is('vehicle-wise-toll-report')  ? 'active' : '' }}"
                        href="{{ route('vehicle-wise-toll-report') }}">
                            <i class="bx bx-check-shield"></i>
                            <span class="menu-title text-truncate" data-i18n="Cost Center"> Vehicle Wise Toll Reports </span>
                    </a>
                   {{-- @endif --}}
                    {{-- @if (Auth::user()->hasPermission('Stake_Holder')) --}}
                    <a class="dropdown-item {{Request::is('cusher-destination-report')  ? 'active' : '' }}"
                        href="{{ route('cusher-destination-report') }}">
                            <i class="bx bx-check-shield"></i>
                            <span class="menu-title text-truncate" data-i18n="Cost Center"> Route Wise Report </span>
                    </a>
                   {{-- @endif --}}


                </div>
            </li>
            @endif
            <li class="dropdown" id="sidebar-dropdown">
                <a href="{{ route('accounting.report') }}" class="btn w-100 dropdown-toggle text-left
                    {{ (request()->is('accounting*')) &&
                     !(request()->is('accounting/party-info')) &&
                     ! (request()->is('accounting/new-chart-of-account')) &&
                     ! (request()->is('accounting/cost-center-details')) &&
                     ! (request()->is('accounting/profit-details')) &&
                     ! (request()->is('accounting/party-info')) &&
                     ! (request()->is('accounting/new-account-head'))  ? 'active' : ' ' }}">
                    Accounting
                </a>
                <div id="dropdown-menu" class="{{ (request()->is('accounting*')) ?  'show' : 'd-none'  }}">
                    <a class="d-none dropdown-item {{ request()->is('accounting/new-journal')   ? 'active' : '' }}" href="{{route("new-journal")}}">
                        <i class="bx bx-check-shield"></i>
                        <span class="menu-title text-truncate" data-i18n="Cost Center"> View </span>
                    </a>
                    <a class="d-none dropdown-item {{ request()->is('accounting/new-journal-creation') || request()->is('accounting/journal-success/*') || request()->is('accounting/journal-edit/*') ? 'active' : '' }}" href="{{route('new-journal-creation')}}">
                        <i class="bx bx-check-shield"></i>
                        <span class="menu-title text-truncate" data-i18n="Cost Center"> Entry </span>
                    </a>
                    <a class="d-none dropdown-item {{ request()->is('accounting/journal-authorization-section') ? 'active' : '' }}" href="{{route("journal-authorization-section")}}">
                        <i class="bx bx-check-shield"></i>
                        <span class="menu-title text-truncate" data-i18n="Cost Center"> Authorize </span>
                    </a>
                    <a class="d-none dropdown-item {{ request()->is('accounting/journal-approval-section') ? 'active' : '' }}" href="{{route("journal-approval-section")}}">
                        <i class="bx bx-check-shield"></i>
                        <span class="menu-title text-truncate" data-i18n="Cost Center"> Approve </span>
                    </a>
                    <a class="dropdown-item {{ request()->is('accounting/purchase-expense-bill') ? 'active' : '' }}" href="{{route("journal-authorization-section")}}">
                        <i class="bx bx-check-shield"></i>
                        <span class="menu-title text-truncate" data-i18n="Cost Center"> Expenses </span>
                    </a>
                    <a class="dropdown-item {{ request()->is('accounting/new-general-ledger') ? 'active' : '' }}" href="{{route("journal-approval-section")}}">
                        <i class="bx bx-check-shield"></i>
                        <span class="menu-title text-truncate" data-i18n="Cost Center"> Reports </span>
                    </a>
                </div>
            </li>
            <li class="dropdown" id="sidebar-dropdown">
                <a href="{{ route('report') }}" class="btn w-100 dropdown-toggle text-left
                    {{ (request()->is('reports*')) || request()->is('daily-summary') ? 'active' : ' ' }}">
                    Reports
                </a>
                <div id="dropdown-menu" class="{{ (request()->is('reports*'))  ?  'show' : 'd-none'  }}">
                    {{-- @if (Auth::user()->hasPermission('Accounting_Reports')) --}}
                    <a class="dropdown-item {{ request()->is('reports/accounting-report/*')   ? 'active' : '' }}" href="{{route("new-general-ledger")}}">
                        <i class="bx bx-check-shield"></i>
                        <span class="menu-title text-truncate" data-i18n="Cost Center"> Accounting Reports </span>
                    </a>
                    {{-- @endif
                    @if (Auth::user()->hasPermission('Financial_Reports')) --}}

                    <a class="dropdown-item {{ request()->is('reports/financial-report*') ? 'active' : '' }}" href="{{route('balance-sheet')}}">
                        <i class="bx bx-check-shield"></i>
                        <span class="menu-title text-truncate" data-i18n="Cost Center"> Financial Reports </span>
                    </a>
                    {{-- @endif --}}
                    <a class="dropdown-item {{  (request()->is('reports/daily-summary*')) ? 'active' : '' }}" href="{{ route('daily-summary.report') }}">
                        <i class="bx bx-check-shield"></i>
                        <span class="menu-title text-truncate" data-i18n="Cost Center">  Daily Summary </span>
                    </a>
                    <a class="dropdown-item {{ request()->is('reports/vat-report*') ? 'active' : '' }}" href="{{route('vat-report')}}">
                        <i class="bx bx-check-shield"></i>
                        <span class="menu-title text-truncate" data-i18n="Cost Center"> VAT Reports </span>
                    </a>
                </div>
            </li>
            <li class="dropdown" id="sidebar-dropdown">
                <a href="{{ route('receipt-voucher3') }}" class="btn w-100 dropdown-toggle text-left
                    {{ (request()->is('sales/receipt*')) || request()->is('receipt/receivable') || request()->is('receipt/receipt-voucher-list-show') || (request()->is('receipt/temp-receipt-voucher-approve')) ? 'active' : ' ' }}">
                    Receipt
                </a>
                <div id="dropdown-menu" class="{{ (request()->is('sales/receipt*'))|| request()->is('receipt/receipt-voucher-list-show') || request()->is('receipt/receivable')|| (request()->is('receipt/temp-receipt-voucher-approve'))  ?  'show' : 'd-none'  }}">
                    {{-- @if (Auth::user()->hasPermission('Receipt_Voucher')) --}}
                    <a class="dropdown-item {{ request()->is('sales/receipt-voucher3') || request()->is('receipt/temp-receipt-voucher*') || request()->is('receipt/receipt-voucher-edit*')  ? 'active' : '' }}" href="{{route("receipt-voucher3")}}">
                        <i class="bx bx-check-shield"></i>
                        <span class="menu-title text-truncate" data-i18n="Cost Center"> Receipt Voucher </span>
                    </a>
                    {{-- @endif
                    @if (Auth::user()->hasPermission('Receipt_List')) --}}
                    <a class="dropdown-item {{ request()->is('receipt/receipt-voucher-list-show') ? 'active' : '' }}" href="{{route("receipt-voucher-list-show")}}">
                        <i class="bx bx-check-shield"></i>
                        <span class="menu-title text-truncate" data-i18n="Cost Center"> Receipt List</span>
                    </a>
                    {{-- @endif
                    @if (Auth::user()->hasPermission('Receivable')) --}}
                    <a class="dropdown-item {{ request()->is('receipt/receivable') ? 'active' : '' }}" href="{{route("receivable")}}">
                        <i class="bx bx-check-shield"></i>
                        <span class="menu-title text-truncate" data-i18n="Cost Center"> Receivable</span>
                    </a>
                    {{-- @endif --}}
                </div>
            </li>
            <li class="dropdown" id="sidebar-dropdown">
                <a href="{{ route('payment-report') }}" class="btn w-100 dropdown-toggle text-left
                    {{ (request()->is('payment*')) ? 'active' : ' ' }}">
                    Payment
                </a>
                <div id="dropdown-menu" class="{{ (request()->is('payment*')) ?  'show' : 'd-none'  }}">
                    {{-- @if (Auth::user()->hasPermission('Payment_Voucher')) --}}
                    <a class="dropdown-item {{ request()->is('*payment-voucher2') || request()->is('*temp-payment-voucher-edit/*')|| request()->is('*temp-payment-voucher-*') ? 'active' : '' }}" href="{{route("payment-voucher2")}}">
                        <i class="bx bx-check-shield"></i>
                        <span class="menu-title text-truncate" data-i18n="Cost Center"> Payment Voucher </span>
                    </a>
                    {{-- @endif
                    @if (Auth::user()->hasPermission('Payment_List')) --}}
                    <a class="dropdown-item {{ request()->is('*payment-voucher2-list') ? 'active' : '' }}" href="{{route("payment-voucher2-list")}}">
                        <i class="bx bx-check-shield"></i>
                        <span class="menu-title text-truncate" data-i18n="Cost Center"> Payment List</span>
                    </a>
                    {{-- @endif
                    @if (Auth::user()->hasPermission('p_Payable')) --}}
                    <a class="dropdown-item {{ request()->is('*payable') ? 'active' : '' }}" href="{{route("payable")}}">
                        <i class="bx bx-check-shield"></i>
                        <span class="menu-title text-truncate" data-i18n="Cost Center">Payable</span>
                    </a>
                    {{-- @endif --}}
                </div>
            </li>
            {{-- <li class="nav-item {{ Request::is('receipt-voucher-list') || Request::is('receipt-voucher-list/*')  ? 'active' : ''}}">
                <a href="{{ route('receipt-voucher-list') }}">
                    <i class="bx bx-right-arrow-alt"></i>
                    <span class="menu-title text-truncate" data-i18n="Document">Receipt Voucher</span>
                </a>
            </li>
            <li class="nav-item {{ Request::is('payment-voucher-list') || Request::is('document/*')  ? 'active' : ''}}">
                <a href="{{ route('payment-voucher-list') }}">
                    <i class="bx bx-right-arrow-alt"></i>
                    <span class="menu-title text-truncate" data-i18n="Document">Payment Voucher</span>
                </a>
            </li> --}}
            {{-- @if (Auth::user()->hasPermission('app.document')) --}}
            {{-- <li class="dropdown" id="sidebar-dropdown">
                <a href="{{ route('document.index') }}" class="btn w-100 dropdown-toggle text-left
                {{ Request::is('document') || Request::is('document/*')  ? 'active' : ''}}">
                    Document
                </a>
                <div id="dropdown-menu" class="{{  Request::is('document') || Request::is('document/*') ?  'show' : 'd-none'  }}">
                    <a class="dropdown-item {{ Request::is('document') || Request::is('document/*')  ? 'active' : ''}}" href="{{ route('document.index') }}">
                        <i class="bx bx-check-shield"></i>
                        <span class="menu-title text-truncate" data-i18n="Cost Center">Document </span>
                    </a>

                </div>
            </li>

            @endif --}}


            {{-- @if (Auth::user()->hasPermissionAny(['app.style.index', 'app.color.index', 'app.size.index', 'app.item_list.index', 'app.stock.position', 'app.stock.reconciliation'])) --}}


                <li class="dropdown" id="sidebar-dropdown">
                    <a href="{{ route('product.index') }}" class="btn w-100 dropdown-toggle text-left
                    {{  Request::is('category*')  ||  Request::is('brand*') || Request::is('product*') ? 'active' : ''}}">
                    Product Specification
                    </a>
                    <div id="dropdown-menu" class="{{ Request::is('category*')  ||  Request::is('brand*') || Request::is('product*') ?  'show' : 'd-none'  }}">
                        {{-- @if (Auth::user()->hasPermission('Payment_Voucher')) --}}
                        <a class="dropdown-item {{ Request::is('product*') ? 'active' : ''}}" href="{{ route('product.index') }}">
                            <i class="bx bx-check-shield"></i>
                            <span class="menu-title text-truncate" data-i18n="Cost Center">Products </span>
                        </a>
                        {{-- @endif  --}}
                              {{-- @if (Auth::user()->hasPermission('Payment_Voucher')) --}}
                              <a class="dropdown-item {{ Request::is('category*') ? 'active' : ''}}" href="{{ route('category.index') }}">
                                <i class="bx bx-check-shield"></i>
                                <span class="menu-title text-truncate" data-i18n="Cost Center">Category </span>
                            </a>
                        {{-- @endif  --}}
                           {{-- @endif  --}}
                              {{-- @if (Auth::user()->hasPermission('Payment_Voucher')) --}}
                              <a class="dropdown-item {{ Request::is('brand*') ? 'active' : ''}}" href="{{ route('brand.index') }}">
                                <i class="bx bx-check-shield"></i>
                                <span class="menu-title text-truncate" data-i18n="Cost Center">Brand </span>
                            </a>
                        {{-- @endif  --}}

                    </div>
                </li>

            {{-- @endif --}}


            <li class="dropdown" id="sidebar-dropdown">
                <a href="{{ route('hr.payroll.report') }}" class="btn w-100  text-left dropdown-toggle
                    {{ (request()->is('hr/payroll/*')) || request()->is('salary-process*') || request()->is('pay-salary*')? 'active' : ' ' }}">
                    HR & PAYROLL
                </a>

                <div id="dropdown-menu" class="{{ (request()->is('hr/payroll/*')) || request()->is('salary-process*') || request()->is('pay-salary*') ? 'show' : 'd-none' }}">
                    <a class=" {{(request()->is('hr/*/employees*')) ? 'active':'' }}
                        {{(request()->is('*employees')) || request()->is('*division')
                        || request()->is('*department') || request()->is('*salary-types')
                        || request()->is('*nationality') || request()->is('*branch')
                        || request()->is('*grade*') || request()->is('*employee-salary*')
                        || request()->is('*salary-structures*') || request()->is('*employee-history*')
                        || request()->is('*employee-document*')? 'active':'' }}"
                         href="{{ route('employees.index')}} ">
                        <i class="bx bx-check-shield"></i>
                        <span class="menu-title text-truncate" data-i18n="Employee Profile"> Basic Info </span>
                    </a>

                    <a class="
                        {{ (request()->is('hr/*/new-employee-attendance')) || (request()->is('*new-employee-leave')) ? 'active' : ' ' }}"
                        href="{{ route('new-employee-attendance')}}">
                        <i class="bx bx-check-shield"></i>
                        <span class="menu-title text-truncate" data-i18n="Employee Profile"> Employees Attendance </span>
                    </a>

                    <a class="
                        {{(request()->is('hr/*/deduction-entry')) || request()->is('*salary-process')
                        || request()->is('*pay-salary') || request()->is('salary-structures') ? 'active':'' }}"
                         href="{{ route('deduction-entry.index')}} ">
                        <i class="bx bx-check-shield"></i>
                        <span class="menu-title text-truncate" data-i18n="Employee Profile"> Payroll Process </span>
                    </a>

                </div>
            </li>

            @if (Auth::user()->hasPermissionAny(['app.access_control.user', 'app.access_control.role', 'app.access_control.settings']))


                <li class="dropdown" id="sidebar-dropdown">
                    <a href="{{ route('user.index')}}" class="btn w-100 dropdown-toggle text-left
                    {{   Request::is('user*') ||  Request::is('role*') || Request::is('settings*') ? 'active' : ''}}">
                    Administration
                    </a>
                    <div id="dropdown-menu" class="{{ Request::is('role*')  ||  Request::is('settings*') || Request::is('company-setup*') || Request::is('user*') ?  'show' : 'd-none'  }}">
                        {{-- @if (Auth::user()->hasPermission('Payment_Voucher')) --}}
                        <a class="dropdown-item {{ Request::is('user*') ? 'active' : ''}}" href="{{ route('user.index') }}">
                            <i class="bx bx-check-shield"></i>
                            <span class="menu-title text-truncate" data-i18n="Cost Center">User Management </span>
                        </a>
                        {{-- @endif  --}}
                              {{-- @if (Auth::user()->hasPermission('Payment_Voucher')) --}}
                              <a class="dropdown-item {{ Request::is('role*') ? 'active' : ''}}" href="{{ route('role.index') }}">
                                <i class="bx bx-check-shield"></i>
                                <span class="menu-title text-truncate" data-i18n="Cost Center">Role </span>
                            </a>
                        {{-- @endif  --}}
                           {{-- @endif  --}}
                              {{-- @if (Auth::user()->hasPermission('Payment_Voucher')) --}}
                            <a class="dropdown-item {{ Request::is('settings*') ? 'active' : ''}}" href="{{ route('settings.index') }}">
                                <i class="bx bx-check-shield"></i>
                                <span class="menu-title text-truncate" data-i18n="Cost Center">Settings </span>
                            </a>
                        {{-- @endif  --}}
                        <a class="dropdown-item {{ Request::is('company-setup*') ? 'active' : ''}}" href="{{ route('company-setup.index') }}">
                            <i class="bx bx-check-shield"></i>
                            <span class="menu-title text-truncate" data-i18n="Cost Center">User Setup </span>
                        </a>
                    </div>
                </li>
            @endif
                {{-- <li class=" nav-item"><a href="#"><i class="bx bx-user-plus"></i><span class="menu-title text-truncate" data-i18n="Users">Users</span></a></li> --}}


            <li class=" nav-item">
                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();"><i class="bx bx-log-out-circle"></i><span class="menu-title text-truncate" data-i18n="Logout">Logout</span></a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</div>
