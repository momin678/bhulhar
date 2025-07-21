@extends('layouts.backend.app')
@section('content')
@include('layouts.backend.partial.style')
<style>
    .table td{
        border-bottom: none;
    }
    .commonSelect2Style span{
        width: 100% !important;
    }
    .select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b{
        /* display: none; */
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow b{
        /* display: none; */
    }
    .master-icon{
        margin-top: 15px !important;
    }
    .nav-item{
        padding: 0 12px 5px !important;
    }
</style>
    <!-- BEGIN: Content-->
    <div class="app-content content print-hideen">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <div class="nav nav-tabs master-tab-section" id="nav-tab" role="tablist">

                    @if (Auth::user()->hasPermission('app.invoice.invoice_create'))
                    <a href="{{route("supplier-invoice")}}" class="nav-item nav-link {{ Request::is('supplier') ? 'active' : ''}}" role="tab" aria-controls="nav-contact" aria-selected="false" id="mJournalAuthorizationSection">
                        <div class="master-icon text-cente">
                            <img src="{{asset('assets/backend/app-assets/icon/supplier-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
                        </div>
                        <div> Supplier</div>
                    </a>
                    @endif
                    @if (Auth::user()->hasPermission('app.invoice.invoice_create'))
                    <a href="{{route("supplier-draft-invoice-list")}}" class="nav-item nav-link {{ Request::is('supplier-draft-invoice-list') ? 'active' : ''}}" role="tab" aria-controls="nav-contact" aria-selected="false" id="mJournalAuthorizationSection">
                        <div class="master-icon text-cente">
                            <img src="{{asset('assets/backend/app-assets/icon/draft.png')}}" alt="" srcset="" class="img-fluid" width="50">
                        </div>
                        <div>Draft</div>
                    </a>
                    @endif
                    @if (Auth::user()->hasPermission('app.invoice.invoice_authorize'))
                    <a href="{{route("authorize-supplier-invoice")}}" class="nav-item nav-link {{ Request::is('authorize-supplier-invoice*') ? 'active' : ''}}" role="tab" aria-controls="nav-contact" aria-selected="false" id="mJournalAuthorizationSection">
                        <div class="master-icon text-cente">
                            <img src="{{asset('assets/backend/app-assets/icon/invoice-authorize-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
                        </div>
                        <div>Authorize Invoice</div>
                    </a>
                    @endif
                    @if (Auth::user()->hasPermission('app.invoice.invoice_approval'))
                    <a href="{{route("approval-supplier-invoice")}}" class="nav-item nav-link {{ Request::is('approval-supplier-invoice*') ? 'active' : ''}}" role="tab" aria-controls="nav-contact" aria-selected="false" id="mJournalAuthorizationSection">
                        <div class="master-icon text-cente">
                            <img src="{{asset('assets/backend/app-assets/icon/invoice-approval-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
                        </div>
                        <div>Approval Invoice</div>
                    </a>
                    @endif

                    @if (Auth::user()->hasPermission('app.invoice.invoice_view'))
                    <a href="{{route("supplier-invoice-list")}}" class="nav-item nav-link {{ Request::is('supplier-invoice-list*') ? 'active' : ''}}" role="tab" aria-controls="nav-contact" aria-selected="false" id="mJournalAuthorizationSection">
                        <div class="master-icon text-cente">
                            <img src="{{asset('assets/backend/app-assets/icon/invoice-list-icon.png')}}" alt="" srcset="" class="img-fluid" width="40">
                        </div>
                        <div>Supplier Invoices</div>
                    </a>

                    <a href="{{route("declined-supplier-invoice")}}" class="nav-item nav-link {{ Request::is('declined-supplier-invoice*') ? 'active' : ''}}" role="tab" aria-controls="nav-contact" aria-selected="false" id="mJournalAuthorizationSection">
                        <div class="master-icon text-cente">
                            <img src="{{asset('assets/backend/app-assets/icon/invoice-declined-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
                        </div>
                        <div>Pending / Declined</div>
                    </a>
                    @endif

                    <a href="{{route("search-supplier-invoice")}}" class="nav-item nav-link {{ Request::is('search-supplier-invoice*') ? 'active' : ''}}" role="tab" aria-controls="nav-contact" aria-selected="false" id="mJournalAuthorizationSection">
                        <div class="master-icon text-cente">
                            <img src="{{asset('assets/backend/app-assets/icon/search-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
                        </div>
                        <div>&nbsp;&nbsp;&nbsp; Search &nbsp;&nbsp;&nbsp;</div>
                    </a>

                </div>
                <div class="tab-content bg-white">
                    <div class="tab-pane active">
                        <div class="row" id="table-bordered">
                            <div class="col-12">
                                <div class="card cardStyleChange">
                                    <div class="row" id="table-bordered">
                                        <div class="col-12">
                                            <div class="cardStyleChange p-2">
                                                <div class="d-flex">
                                                    <h4 class="flex-grow-1">Search Invoice</h4>
                                                </div>
                                                <section id="widgets-Statistics" class="mt-2 mb-1 pl-1">
                                                    <form action="">
                                                        <div class="row">
                                                            <div class="col-md-5 changeColStyle">
                                                                <label for="">Search Invoice</label>
                                                                <select name="supplier_id" class="inputFieldHeight form-control common-select2">
                                                                    <option value="">Select Supplier</option>
                                                                    @foreach ($suppliers as $supplier)
                                                                    <option value="{{$supplier->id}}">{{ $supplier->pi_name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="row col-md-7">
                                                                <div class="col-md-3 changeColStyle">
                                                                    <label for="">Single Date</label>
                                                                    <input type="text" class="form-control inputFieldHeight" name="date" placeholder="Search by Date" id="date">
                                                                </div>
                                                                <div class="col-md-3 changeColStyle">
                                                                    <label for="">From Date</label>
                                                                    <input type="text" class="form-control inputFieldHeight" name="from" placeholder="From"  id="from">
                                                                </div>
                                                                <div class="col-md-3 changeColStyle">
                                                                    <label for="">To Date</label>
                                                                    <input type="text" class="form-control inputFieldHeight" name="to" placeholder="To" id="to">
                                                                </div>
                                                                <div class="col-md-3 changeColStyle text-right mt-2">
                                                                    <button type="submit" class="btn btn-primary formButton mSearchingBotton" title="Searching">
                                                                        <div class="d-flex">
                                                                            <div class="formSaveIcon" style="margin-left: -10px;">
                                                                                <img  src="{{asset('assets/backend/app-assets/icon/searching-icon.png')}}" alt="" srcset=""  width="25">
                                                                            </div>
                                                                            <div><span> Search</span></div>
                                                                        </div>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </section>
                                                <div class="table-responsive">
                                                    <table class="table mb-0 table-sm table-hover">
                                                        <thead  class="thead-light">
                                                            <tr style="height: 50px;">
                                                                <th>Supplier</th>
                                                                <th>Invoice No</th>
                                                                <th>Date</th>
                                                                <th>Pay Mode</th>
                                                                <th>Amount </th>
                                                                <th class="text-right pr-2">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="table-sm">
                                                            @foreach ($invoices as $invoice)
                                                            <tr class="trFontSize">
                                                                <td>{{$invoice->supplier->pi_name}}</td>
                                                                <td>{{$invoice->invoice_no}}</td>
                                                                <td>{{ date('d/m/Y', strtotime($invoice->date)) }}</td>
                                                                <td>{{$invoice->pay_mode}}</td>
                                                                <td>{{$invoice->amount + $invoice->vat_amount}}</td>
                                                                <td class="text-right pr-1">
                                                                    <a href="{{ route('supplier-invoice-sumview', $invoice->id)}}" class="btn" title="Supplier Invoice" style="padding-top: 1px; padding-bottom: 1px; height: 30px; width: 30px;">
                                                                        <img src="{{asset('assets/backend/app-assets/icon/invoice-icon.png')}}" style=" height: 30px; width: 30px;">
                                                                    </a>
                                                                    <a href="{{ route('supplier-invoice-view', $invoice->id)}}" class="btn " title="Invoice Details" style="padding-top: 1px; padding-bottom: 1px; height: 30px; width: 30px;">
                                                                        <img src="{{asset('assets/backend/app-assets/icon/view-icon.png')}}" style=" height: 30px; width: 30px;">
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                            @foreach ($temp_invoices as $invoice)
                                                            <tr class="trFontSize">
                                                                <td>{{$invoice->supplier->pi_name}}</td>
                                                                <td>{{$invoice->invoice_no}}</td>
                                                                <td>{{ date('d/m/Y', strtotime($invoice->date)) }}</td>
                                                                <td>{{$invoice->pay_mode}}</td>
                                                                <td>{{$invoice->amount+$invoice->vat_amount}}</td>
                                                                <td class="text-right pr-1">
                                                                    <a href="{{ route('pre-supplier-invoice-view', $invoice->id)}}" class="btn " title="View" style="padding-top: 1px; padding-bottom: 1px; height: 30px; width: 30px;">
                                                                        <img src="{{asset('assets/backend/app-assets/icon/view-icon.png')}}" style=" height: 30px; width: 30px;">
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            @endforeach
        
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('js')
<script>
    // $(document).on("click", ".truckInfoEdit", function(e){
    //     e.preventDefault();
    //     $("#truckInfoEditModal").modal('show');
    // });

    // var items= @json(session('items'));
    @if(session('items'))
    var items=@json(session('items'));
    @else
    var items=[];
    @endif

    function delete_item(id){
        // alert('Deleted');
        var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "{{ route('remove-session-item') }}",
                        method: "POST",
                        data: {
                            data_id:   id,
                            _token: _token,
                        },
                        success: function(response) {
                            console.log(response);
                            create_service_table();

                        }
                    });
    }

    $('.add_item').click(function(){
        var fld_date        = $('#fld_date').val();
        var fld_truck       = $('#fld_truck').val();
        var vehicle_no      = $('#fld_truck').find(':selected').attr('vehicle-no');
        var fld_material    = $('#fld_material').val();
        var fld_crusher     = $('#fld_crusher').val();
        var fld_dstn        = $('#fld_dstn').val();
        var fld_serial      = $('#fld_serial').val();
        var fld_wight       = $('#fld_wight').val();
        var fld_truck_owner = $('#fld_truck_owner').val();
        var truck_owner_name= $('#fld_truck_owner').find(':selected').attr('party-name');
        var fld_customer    = $('#fld_customer').val();

        // alert(vehicle_no);

        if(fld_date ==''){
            alert('Date is Required');
        }else if(fld_customer ==''){
            alert('Customer field is Required');
        }else if(fld_truck ==''){
            alert('Truck field is Required');
        }else if(fld_material ==''){
            alert('Material field is Required');
        }else if(fld_crusher ==''){
            alert('Crusher field is Required');
        }else if(fld_dstn ==''){
            alert('DSTN Field is Required');
        }else if(fld_serial ==''){
            alert('Serial Field is Required');
        }else if(fld_wight ==''){
            alert('Weight is Required');
        }else if(fld_truck_owner ==''){
            alert('Truck field is Required');
        }else{
                    // var value = $(this).val();
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "{{ route('add-to-session') }}",
                        method: "POST",
                        data: {
                            fld_customer:   fld_customer,
                            fld_date:       fld_date,
                            fld_truck:      fld_truck,
                            vehicle_no:     vehicle_no,
                            fld_material:   fld_material,
                            fld_crusher:    fld_crusher,
                            fld_dstn:       fld_dstn,
                            fld_serial:     fld_serial,
                            fld_wight:      fld_wight,
                            fld_truck_owner:fld_truck_owner,
                            truck_owner_name:truck_owner_name,
                            _token: _token,
                        },
                        success: function(response) {
                            // console.log(response);
                            items= response;

                            create_service_table();

                        }
                    });
        }
    });

    function create_service_table(){
        console.log(items);
        console.log(items.length);
        var html='';
        if(items.length>0){
            console.log('if true');
            var img_url= "{{asset('assets/backend/app-assets/icon/delete-icon.png')}}";
            for (var i= 0; i < items.length; i++) {
                var item = items[i];

                html+=
                '<tr class="trFontSize">' +
                    '<td>'+item.date+'</td>' +
                    '<td>'+item.vehicle_no+'</td>' +
                    '<td>'+item.material+'</td>' +
                    '<td>'+item.crusher+'</td>' +
                    '<td>'+item.dstn+'</td>'+
                    '<td>'+item.serial+'</td>'+
                    '<td>'+item.wight+'</td>'+
                    '<td>'+item.truck_owner_name+'</td>'+
                    '<td class="">'+
                        '<a href="#" class="btn truckInfoEdit" onclick="delete_item('+i+')" title="Delete" style="padding-top: 1px; padding-bottom: 1px; height: 30px; width: 30px;">'+
                            '<img src="'+img_url+'" style=" height: 30px; width: 30px;">'+
                        '</a>'+
                    '</td>'+
                '</tr>';

            }
        }else{
            console.log('if else');
            // console.log(html);
            html= '<tr > <td colspan="9" te> <p class="text-center"> No record! </p> </td> </tr>';
        }

        $('#items_cart').html(html);
    }

    $('.btn_create').click(function(){
        create_service_table();
    });


    $('#record-submit').click(function(){
        // alert('Alhamdulillah');
        if(items.length>0){
            $('#save-form').submit();
        }else{
            alert('No record to submit!');
        }

    });

    // $('.btn-search').click(function(){
    //     $('#search_form').submit();
    // });

    // $('.btn-select-all').click(function(){
    //     // alert('Alhamdulillah');
    //     // $('.checkbox-record').not(this).prop('checked', this.checked);
    //     $('.checkbox-record').prop('checked', this.checked);
    // });

    $('.btn-select-all').click(function (event) {
        if (this.checked) {
            // Iterate each checkbox
            $(':checkbox').each(function () {
                this.checked = true;
            });
        } else {
            $(':checkbox').each(function () {
                this.checked = false;
            });
        }
    });

</script>
@endpush
