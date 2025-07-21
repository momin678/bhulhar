@extends('layouts.backend.app')
@section('title', 'Stock Position')
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
    <style>
        td{
            color: black !important;
        }
        th{
            color: black !important;
        }
    </style>
@endpush

@section('content')
@php

@endphp
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <!-- Widgets Statistics start -->
                <section id="widgets-Statistics">
                    <h4>Item Name: {{ isset($product->brand)? $product->brand->name:"" }}{{ isset($product->subBrand)? ', '.$product->subBrand->name:"" }}</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Puchase Reports</h5>
                            <table class="table table-bordered table-sm">
                                <tr>
                                    <th>Date</th>
                                    <th>Puchase Rate</th>
                                    <th>Vat Amount</th>
                                    <th>Amount</th>
                                </tr>
                                @foreach ($purchases as $item)
                                    <tr>
                                        <td>{{$item->purcahse->date}}</td>
                                        <td>{{$item->unit_price}}</td>
                                        <td>{{$item->vat}}</td>
                                        <td>{{$item->total_price}}</td>
                                    </tr>
                                @endforeach
                                <tr class="border-bottom">
                                    <td colspan="3">Total</td>
                                    <td>{{$purchases->sum('total_price')}}</td>
                                </tr>
                             </table>
                        </div>
                        <div class="col-md-6">
                            <h5>Sales Reports</h5>
                            <table class="table table-bordered table-sm">
                                <tr>
                                    <th>Date</th>
                                    <th>Sale Rate</th>
                                    <th>Vat Amount</th>
                                    <th>Amount</th>
                                </tr>
                                @foreach ($sales as $item)
                                    <tr>
                                        <td>{{$item->invoice->date}}</td>
                                        <td>{{$item->price}}</td>
                                        <td>{{$item->vat}}</td>
                                        <td>{{$item->total_price}}</td>
                                    </tr>
                                @endforeach
                                <tr class="border-bottom">
                                    <td colspan="3">Total</td>
                                    <td>{{$sales->sum('total_price')}}</td>
                                </tr>
                             </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
    {{-- <script src="{{ asset('assets/backend/app-assets/vendors/js/jquery/jquery.min.js') }}"></script> --}}
    <script>
        $(document).ready(function() {
            $(document).on("change", "#search", function(e) {
                if ($(this).val() != '') {

                var item = $(this).val();
                // alert(category);

                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('item.fetch') }}",
                    method: "POST",
                    data: {
                        item: item,
                        _token: _token,
                    },
                    success: function(response) {
                        $(".user-table-body").empty().append(response.page);
                        $("#url").empty().append(response.url);
                        $("#sub_brand2").empty();
                    }

                })
            }
            });

            $(document).on("change", "#category", function(e) {
                if ($(this).val() != '') {

                var category = $(this).val();
                // alert(category);

                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('categoryProduct.fetch') }}",
                    method: "POST",
                    data: {
                        category: category,
                        _token: _token,
                    },
                    success: function(response) {
                        $(".user-table-body").empty().append(response.page);
                        $("#url").empty().append(response.url);
                        $("#sub_brand2").empty();
                    }

                })
            }
            });
        });
    </script>
@endpush
