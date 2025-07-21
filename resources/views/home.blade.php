@extends('layouts.backend.app')

@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            {{-- <div class="content-header row">
                <div class="content-header-left col-12 mb-2 mt-1">
                    <div class="breadcrumbs-top">
                        <h5 class="content-header-title float-left pr-1 mb-0">Widgets</h5>
                        <div class="breadcrumb-wrapper d-none d-sm-block">
                            <ol class="breadcrumb p-0 mb-0 pl-1">
                                <li class="breadcrumb-item"><a href="index.html"><i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item active">Widgets
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="content-body">
                <!-- Widgets Statistics start -->
                <section id="widgets-Statistics">
                    <div class="row">
                        {{-- <div class="col-12 col-md-6 col-lg-3 mb-1" style="background-color: rgb(185, 78, 138, 0.95);">
                            <div class="box box-light-pink p-1 text-center" >
                                <div class="d-flex flex-column">
                                    <h2> {{ number_format($receivable,2) }} </h2>
                                    <p class="h5" style="color: #fff;"> Receivable </p>
                                </div>
                                <i class='bx bx-receipt'></i>
                            </div>
                            <div class="linner-box bg-light-pink d-flex align-items-center justify-content-center" style="background-color: #B94E8A;">
                                <a href="{{route('receivable')}}"> More info </a>
                                <i class="text-primary bx bx-right-arrow-alt"></i>
                            </div>
                        </div> --}}
                        <div class="col-12 col-md-6 col-lg-3 mb-1">
                            <div class="box box-info p-1 text-center" style="background-color: rgb(185, 78, 138, 0.95);">
                                <div class="d-flex flex-column">
                                    <h2> {{ number_format($receivable,2) }} </h2>
                                    <p class="h5" style="color: #fff;"> Receivable </p>
                                </div>
                                {{-- <i class='bx bxs-calendar'></i> --}}
                            </div>
                            <div class="linner-box bg-info bg-gradient d-flex align-items-center justify-content-center" style="background-color: #b94e8bab !important;">
                                <a href="{{route('receivable')}}"> More info </a>
                                <i class="text-info bx bx-right-arrow-alt"></i>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3 mb-1">
                            <div class="box box-info p-1 text-center" style="background-color: rgb(13, 202, 240, 0.7);">
                                <div class="d-flex flex-column">
                                    <h2> {{ number_format($payble,2) }} </h2>
                                    <p class="h5" style="color: #fff;"> Payable </p>
                                </div>
                                {{-- <i class='bx bxs-calendar'></i> --}}
                            </div>
                            <div class="linner-box bg-info bg-gradient d-flex align-items-center justify-content-center">
                                <a href="{{route('payable')}}"> More info </a>
                                <i class="text-info bx bx-right-arrow-alt"></i>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3 mb-1 modalopen" data-collection="EMPLOYEE-LIST">
                            <div class="box box-success p-1 text-center" style="background-color: rgb(57, 218, 138, 0.9);">
                                <div class="d-flex flex-column">
                                    <h2> {{ number_format($cash,2) }} </h2>
                                    <p class="h5" style="color: #fff;"> Cash </p>
                                </div>
                                {{-- <i class='bx bxs-credit-card-alt'></i> --}}
                            </div>
                            <div class="linner-box bg-success bg-gradient d-flex align-items-center justify-content-center">
                                <a href="#">  </a>
                                <i class="text-success bx bx-right-arrow-alt"></i>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3 mb-1">
                            <div class="box box-light-green p-1  text-center" style="background-color: rgb(148, 221, 77, 0.86);">
                                <div class="d-flex flex-column">
                                    <h2> {{ number_format($m_sales,2) }} </h2>
                                    <p class="h5" style="color: #fff;"> Income/Revenue </p>
                                </div>
                                {{-- <i class='bx bx-git-branch'></i> --}}
                            </div>
                            <div class="linner-box bg-light-green bg-gradient d-flex align-items-center justify-content-center" style="background-color: #94DD4D;">
                                <a href="{{route('approved-invoice-list')}}"> More info </a>
                                <i class="bx bx-right-arrow-alt"></i>
                            </div>
                        </div>
                    </div>
                    <div class="row print-hide">
                        <div class="col-12 col-md-6 px-1 mt-2">
                            <div class="due-fee bg-white px-1">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mt-1"> Income/Revenue </h6>
                                    <div class="d-flex algin-items-center">
                                        {{-- <button class="due-btn bg-info modalopen" data-collection="DUE-STUDENT-WISE"> <i
                                                class='bx bxs-analyse'></i> Quick View </button> --}}
                                        <a href="{{route('approved-invoice-list')}}" class="ml-2 due-btn text-dark"> All <i class='bx bx-right-arrow-alt'></i> </a>
                                    </div>
                                </div>

                                <div class="">
                                    <table class="table table-sm">
                                        <thead class="bg-light">
                                            <tr class="text-center">
                                                <th style="color:white;">Date</th>
                                                <th style="color:white;">Invoice No</th>
                                                <th style="color:white;">Party Name</th>
                                                <th style="color:white;">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody style="font-size: 12px !important;">
                                            @foreach ($sales as $item)
                                                <tr class="text-center">
                                                    <td>{{date('d/m/Y',strtotime($item->date))}}</td>
                                                    <td>{{$item->invoice_no}}</td>
                                                    <td>{{$item->customer->pi_name}}</td>
                                                    <td>{{number_format($item->total_amount,2)}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 px-1 mt-2">
                            <div class="due-fee bg-white px-1">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mt-1"> Purchase </h6>
                                    <div class="d-flex algin-items-center">
                                        {{-- <button class="due-btn bg-info modalopen" data-collection="DUE-STUDENT-WISE"> <i
                                                class='bx bxs-analyse'></i> Quick View </button> --}}
                                        <a href="{{route('purchase-expense-list')}}" class="ml-2 due-btn text-dark"> All <i class='bx bx-right-arrow-alt'></i> </a>
                                    </div>
                                </div>

                                <div class="">
                                    <table class="table table-sm">
                                        <thead class="bg-light">
                                            <tr class="text-center">
                                                <th style="color:white;">Date</th>
                                                <th style="color:white;">Bill No</th>
                                                <th style="color:white;">Party Name</th>
                                                <th style="color:white;">Amount <small>(@if(!empty($currency->symbole)){{$currency->symbole}}@endif)</small></th>
                                            </tr>
                                        </thead>
                                        <tbody style="font-size: 12px !important;">
                                            @foreach ($expenses as $item)
                                                <tr class="text-center">
                                                    <td>{{ date('d/m/Y', strtotime($item->date)) }}</td>
                                                    <td>{{ $item->purchase_no }}</td>
                                                    <td>{{ $item->party->pi_name }}</td>
                                                    <td>{{number_format( $item->total_amount,2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 px-1 mt-2">
                            <div class="due-fee bg-white px-1">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mt-1"> Payments </h6>
                                    <div class="d-flex algin-items-center">
                                        {{-- <button class="due-btn bg-info modalopen" data-collection="DUE-STUDENT-WISE"> <i
                                                class='bx bxs-analyse'></i> Quick View </button> --}}
                                        <a href="{{route('payment-voucher2-list')}}" class="ml-2 due-btn text-dark"> All <i class='bx bx-right-arrow-alt'></i> </a>
                                    </div>
                                </div>

                                <div class="">
                                    <table class="table table-sm ">
                                        <thead class="bg-light">
                                            <tr class="text-center">
                                                <th style="color:white;">Date</th>
                                                <th style="color:white;">Payment No</th>
                                                <th style="color:white;">Party Name</th>
                                                <th style="color:white;">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody class="mb-2" style="font-size: 12px !important;">
                                            @foreach ($payments as $item)
                                                <tr class="text-center">
                                                    <td>{{date('d/m/Y', strtotime($item->date))}}</td>
                                                    <td>{{$item->payment_no}}</td>
                                                    <td>{{$item->party->pi_name}}</td>
                                                    <td>{{number_format($item->total_amount,2)}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 px-1 mt-2">
                            <div class="due-fee bg-white px-1">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mt-1"> Receipt </h6>
                                    <div class="d-flex algin-items-center">
                                        {{-- <button class="due-btn bg-info modalopen" data-collection="DUE-STUDENT-WISE"> <i
                                                class='bx bxs-analyse'></i> Quick View </button> --}}
                                        <a href="{{route('receipt-voucher-list-show')}}" class="ml-2 due-btn text-dark"> All <i class='bx bx-right-arrow-alt'></i> </a>
                                    </div>
                                </div>

                                <div class="">
                                    <table class="table table-sm">
                                        <thead class="bg-light">
                                            <tr class="text-center">
                                                <th style="color:white;">Date</th>
                                                <th style="color:white;">Receipt No</th>
                                                <th style="color:white;">Party Name</th>
                                                <th style="color:white;">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody style="font-size: 12px !important;">
                                            @foreach ($receipt_list as $item)
                                                <tr class="text-center">
                                                    <td>{{date('d/m/Y',strtotime($item->date))}}</td>
                                                    <td>{{$item->receipt_no}}</td>
                                                    <td>{{ $item->name==null?  $item->party->pi_name : $item->name}}</td>
                                                    <td >{{number_format($item->total_amount,2)}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Widgets Statistics End -->



            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection

@push('js')
    {{-- <script src="{{ asset('assets/backend/app-assets/vendors/js/jquery/jquery.min.js') }}"></script> --}}
    <script>
        // $(document).ready(function() {
            // Page Script
            // alert("Alhamdulillah");
        // });
    </script>
@endpush