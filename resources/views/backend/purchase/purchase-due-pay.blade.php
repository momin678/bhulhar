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


        .tarek-container {
            width: 85%;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 88% 12%;
            background-color: #ffff;
        }

        option {
            width: 450px !important;
        }

        .invoice-label {
            font-size: 10px !important
        }

        @media (min-width: 576px) {
            .modal-dialog {
                max-width: 740px !important;
                margin: 1.75rem auto;
            }
        }
    </style>
@endpush
@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">

            <div class="content-body">
                <!-- Widgets Statistics start -->
                <section id="widgets-Statistics">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-12">
                                    <h4>Purchase</h4>

                                </div>
                            </div>
                            <form action="{{ route('final-due-payment') }}" method="POST" onsubmit="return confirm('Please, confirm the payment.')">
                                @csrf
                                <input type="hidden" name="purchase_id" value="{{$purchases->id}}">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card d-flex align-items-center">
                                            <div class="card-body">
                                                <div class="row d-flex align-items-center">
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Branch</label>
                                                        <input type="text" value="{{$purchases->project->proj_name}}" class="form-control" readonly>
                                                    </div>
                                                    <div class="col-sm-3 form-group" id="printarea">
                                                        <label for="">Purchase Date</label>
                                                        <input type="text" value="{{date('d/m/Y', strtotime( $purchases->date))}}" class="form-control" readonly>
                                                    </div>
                                                    <div class="col-sm-3 form-group d-none">
                                                        <label for="">Purchase No</label>
                                                        <input type="text" class="form-control" value="{{ $purchases->purchase_no }}" readonly >
                                                    </div>
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Payment Mode</label>
                                                        <input type="text" class="form-control" value="{{ $purchases->pay_mode }}" readonly >
                                                    </div>
                                                    <div class="col-sm-3 form-group customer-select">
                                                        <label for="">Supplier Name</label>
                                                        <input type="text" class="form-control" value="{{ $purchases->partyInfo($purchases->customer_name)->pi_name }}" readonly >
                                                    </div>
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Supplier Invoice</label>
                                                        <input type="text" class="form-control" value="{{ $purchases->supplier_invoice }}" readonly>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="">Pay Mode</label>
                                                        <select name="pay_mode" id=""  class="form-control">
                                                            @foreach ($modes as $item)
                                                                @if ($item->title != 'Credit')
                                                                    <option value="{{$item->title}}">{{$item->title}}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-3 form-group" id="printarea">
                                                        <label for="">Purchase Date</label>
                                                        <input type="text" value="{{date('d/m/Y')}}" class="form-control" name="date" id="date"  required placeholder="dd/mm/yyyy">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered all-data-area">
                                        <thead>
                                            <tr>
                                                <th>Code</th>
                                                <th>Category/Service</th>
                                                <th>Brand</th>
                                                <th>Description</th>
                                                <th>Unit Price</th>

                                                <th>Amount</th>
                                                <th>Unit</th>
                                                <th>Price</th>
                                            </tr>
                                        </thead>
                                        <tbody class="">

                                            @foreach ($items as $item)
                                                <tr class="data-row">
                                                    @if($item->cat_id!=null)
                                                    <td>{{ $item->barcode }}</td>
                                                    <td>{{ $item->category->name }}</td>
                                                    <td>{{ isset( $item->brand)?$item->brand->name:"" }}</td>
                                                    <td>{{ isset($item->subBrand)?$item->subBrand->name:"" }}</td>
                                                    <td>{{ $item->unit_price }}</td>

                                                    <td>{{ $item->amount }}</td>
                                                    <td>{{ $item->unitP->name}}</td>
                                                    <td>{{$item->price}}</td>
                                                    @else
                                                    <td></td>
                                                    <td>{{ $item->service->name }}</td>
                                                    <td>N/A</td>
                                                    <td>N/A</td>
                                                    <td>N/A</td>
                                                    <td>N/A</td>
                                                    <td>{{$item->total_price}}</td>

                                                    @endif
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="row pt-1">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="" class="d-flex align-items-center col-right-padding">Discount(AED):</label>
                                            <input type="number" placeholder="Amount" value="{{number_format($purchases->discount_price,2) }}" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="" class="d-flex align-items-center col-right-padding">Total(AED):</label>
                                            <input type="number" placeholder="Amount" value="{{number_format($purchases->total_price,2) }}" class="form-control" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="" class="d-flex align-items-center col-right-padding">Pay (AED):</label>
                                            <input type="number" placeholder="Amount" value="{{number_format($purchases->paid_price,2) }}" class="form-control" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="" class="d-flex align-items-center col-right-padding">Due (AED):</label>
                                            <input type="number" value="{{$purchases->due_price}}" name="due_amount" placeholder="Amount" step="any" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-sm final-save-btn only-save-btn  btn-primary" id="final_save">Confirm</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </section>
            </div>
        </div>
    </div>

@endsection

@push('js')
@endpush
