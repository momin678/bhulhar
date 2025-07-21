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
                        <div class="col-md-12">
                            <div class="row">
                                <h4>Purchase Return list</h4>
                                <hr>
                            </div>
                           

                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered" id="myTable">
                                        <thead>
                                            <tr>
                                                <th>Purchase Return No</th>
                                                <th>suplyer</th>
                                                <th>Contact No</th>

                                                <th>QTY</th>
                                              
                                                <th>Net Amount</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="all-data-area">

                                        @foreach ($Returns as $key => $item)
                                        <tr>
                                        <td>{{ $item->purchase_return_no}}</td>
                                        <td>{{ $item->supplier_id }}</td>
                                        <td>{{ $item->challan_number }}</td>
                                        <td>{{$item->items->sum('return_qty')}}</td>

                                        <td>{{$item->items->sum('total')}}</td>
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




