@extends('layouts.backend.app')
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
    <style>
        td{
            text-align: center !important;
        }
    </style>
@endpush
@php
    $grand_total_value=0;
    $grand_total_pcs=0;
@endphp
@section('title', ' Purchase Summary')

@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.css" />

    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <!-- Widgets Statistics start -->
                <section id="widgets-Statistics">
                    <div class="row">
                        <div class="col-md-6">

                            <h4>{{ $date !=null? $date:($from != null? ( $from.' to '. $to) : date('d M Y')) }}  Sales Invoices Summary</h4>
                           </div>
                           <div class="col-md-2 text-right">
                            <form action="{{route('searchDaily')}}" method="post">
                                @csrf
                               <div class="row form-group">
                                <input type="text" class="form-control col-9" name="date"  placeholder="Select Date" onfocus="(this.type='date')" id="date" required>
                                <button class="bx bx-search col-3 btn-warning btn-block" type="submit"></button>
                               </div>
                            </form>
                           </div>
                           <div class="col-md-4  col-left-padding">
                            <form action="{{route('searchDailyRange')}}" method="post">
                                @csrf
                                <div class="row form-group">
                                    <div class="col-5 col-right-padding">
                                        <input type="text" class="form-control" name="from"
                                        placeholder="From"  value="{{ isset($searchDatefrom)? $searchDatefrom:"" }}"  onfocus="(this.type='date')"  id="from" required>

                                    </div>
                                    <div class="col-5  col-left-padding col-right-padding">
                                        <input type="text" class="form-control" name="to"
                                        placeholder="To" value="{{ isset($searchDateto)? $searchDateto:"" }}" onfocus="(this.type='date')" id="to" required>
                                    </div>
                                    <button class="bx bx-search col-2 btn-warning btn-block" type="submit"></button>
                                </div>
                            </form>

                            <input type="hidden" name="hidden_date_from" value="{{ isset($from)? $from:"" }}" id="hidden_date_from">
                            <input type="hidden" name="hidden_date_to" value="{{ isset($to)? $to:"" }}" id="hidden_date_to">
                        </div>
                    </div>

                    <table class="table table-sm table-bordered" id="myTable">
                                <thead>
                                    <tr>
                                        <th>Sales Invoice no</th>
                                        <th scope="col">Pay mode</th>
                                        <th scope="col">Customer Name</th>
                                        <th scope="col">Contact no</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">TRN</th>

                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tempLists"  class="user-table-body">
                                    @foreach ($invoicess as $item)
                                    <tr class="data-row">
                                        <td>{{$item->invoice_no}}</td>
                                        <td>{{$item->pay_mode}}</td>
                                        <td>{{$item->partInfo->pi_name}}</td>
                                        <td>{{$item->partInfo->con_no}}</td>
                                        <td>{{$item->partInfo->address}}</td>
                                        <td>{{$item->partInfo->trn_no}}</td>

                                        <td><a class="btn btn-sm btn-warning"href="{{ route('invoiceView', $item) }}">Show</a></td>
                                    </tr>
                                    @endforeach

                                </tbody>

                            </table>
                            {{ $invoicess->links() }}
                </section>
                <!-- Widgets Statistics End -->



            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
    {{-- <script src="{{ asset('assets/backend/app-assets/vendors/js/jquery/jquery.min.js') }}"></script> --}}
    <script>
        // $(document).ready(function() {
        // Page Script
        // alert("Alhamdulillah");
        // });
    </script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.js"></script>

<script>
    $(document).ready( function () {
    $('#myTable').DataTable();
} );
</script>

@endpush
