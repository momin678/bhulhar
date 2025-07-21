@extends('layouts.backend.app')
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
    <style>
        .table-bordered {
            border: 1px solid #f4f4f4;
        }

        .table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 20px;
        }

        table {
            background-color: transparent;
        }

        table {
            border-spacing: 0;
            border-collapse: collapse;
        }


        .tarek-container{
    width: 85%;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 88% 12%;
    background-color: #ffff;
}

.invoice-label{
    font-size: 10px !important
}

    </style>
@endpush
@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.css" />

    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">

            <div class="content-body">
                <!-- Widgets Statistics start -->
                <section id="widgets-Statistics">
                    <div class="row">
                        <div class="col-md-6">

                            <h4>{{ $date !=null? $date:($from != null? ( $from.' to '. $to) : date('d M Y')) }}  Purchase Return</h4>
                           </div>
                           <div class="col-md-2 text-right">
                            <form action="{{route('searchDailypr')}}" method="post">
                                @csrf
                               <div class="row form-group">
                                <input type="text" class="form-control col-9" name="date"  placeholder="Select Date" onfocus="(this.type='date')" id="date" required>
                                <button class="bx bx-search col-3 btn-warning btn-block" type="submit"></button>
                               </div>
                            </form>
                           </div>
                           <div class="col-md-4  col-left-padding">
                            <form action="{{route('searchDailyRangepr')}}" method="post">
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
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <hr>
                            </div>


                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered" id="myTable">
                                        <thead>
                                            <tr>
                                                <th>Purchase Return No</th>
                                                <th>PurchaseNo</th>

                                                <th>suplyer</th>
                                                <th>Contact No</th>
                                                <th>Adress</th>


                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="all-data-area">

                                        @foreach ($Returns as $key => $item)
                                        <tr>

                                        <td>{{ $item->purchase_return_no}}</td>

                                        <td>{{ $item->purchase_no}}</td>
                                        <td>{{ $item->supplier_id }}</td>
                                        <td>{{ $item->challan_number }}</td>
                                        <td>{{ $item->address }}</td>

                                         <td><a href="{{ route('ReturnPrint', $item->purchase_return_no) }}"class="btn btn-sm btn-warning" target="_blank">Print</a></td>
                                        </tr>


                                        @endforeach
                                        </tbody>



                                    </table>
                                </div>


                        </div>


                    </div>

                </section>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.js"></script>

<script>
    $(document).ready( function () {
    $('#myTable').DataTable();
} );
</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
    {{-- <script src="{{ asset('assets/backend/app-assets/vendors/js/jquery/jquery.min.js') }}"></script> --}}

@endpush




