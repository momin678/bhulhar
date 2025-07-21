<style>
    html, body {
        height:100%;
    }
    thead {
    background: #34465b;
    color: #fff !important;
    height: 30px;
}
</style>
<section class="print-hideen border-bottom">
    <div class="d-flex flex-row-reverse">
        <div class="py-1 pr-1"><a href="#" class="close btn-icon btn btn-danger" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class='bx bx-x'></i></span></a></div>
                <div class="py-1 pr-1"><a href="#" onclick="window.print();" class="btn btn-icon btn-secondary"><i class="bx bx-printer"></i></a></div>

        {{-- <div class="py-1 pr-1"><a href="#" onclick="window.print();" class="btn btn-icon btn-light"><i class='bx bxs-virus'></i></a></div> --}}
    </div>
</section>
@include('layouts.backend.partial.modal-header-info')
<section id="widgets-Statistics">
    <div>
        <h4 class="text-center">Tax Invoice</h4>
    </div>
    @php
        $company_name = App\Setting::where('config_name', 'company_name')->first();
    @endphp
    <div class="row">
        <div class="col-md-12">
            <div class="">
                <div class="mx-2 mb-2">
                    <div class="row">
                        <div class="col-md-6 pb-2"><strong>To: </strong> {{$parti_info?$parti_info->pi_name:''}}</div>
                        <div class="col-md-6 pb-2"><strong>From: </strong>{{$company_name->config_value}}</div>
                        <div class="col-md-3">
                            <strong>Invoice No:</strong> {{ $requests['invoice_no']}}
                        </div>
                        <div class="col-md-3">
                            <strong>Date:</strong> {{ date('d/m/Y', strtotime($requests['date']))}} <strong class="pl-2">Pay Mode:</strong> {{ $requests['pay_mode']}}
                        </div>
                        <div class="col-md-3">
                            <strong>TRN:</strong> {{ $parti_info?$parti_info->trn_no:''}}
                        </div>
                        <div class="col-md-3">
                            <strong>ADDRESS:</strong> {{ $parti_info?$parti_info->address:''}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="border-botton">
                <div class="mx-2">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered border-botton">
                            <thead class="thead">
                                <tr>
                                    <th>Category</th>
                                    <th>Vehicle Brand</th>
                                    <th>Vehicle Name</th>
                                    <th>Vehicle Model</th>
                                    <th>Item Code</th>
                                    <th>QTY</th>
                                    <th>Rate</th>
                                    <th>Amount</th>
                                    <th>Vate</th>
                                    <th>Total</th>
                                </tr>
                            </thead>

                            <tbody class="user-table-body">
                                @foreach ($multi_item_code as $key => $item)
                                    @if ($item)
                                        <tr class="border-bottom text-center">
                                            @php
                                                $prouct = $product = App\Product::where('item_code_id', $item)->first();
                                                $item_code = App\ItemCode::find($item);
                                            @endphp
                                            <td>{{$prouct->category?$prouct->category->name:''}}</td>
                                            <td>{{$prouct->brand?$prouct->brand->name:''}}</td>
                                            <td>{{$prouct->vahicle_name?$prouct->vahicle_name->name:''}}</td>
                                            <td>{{$prouct->subBrand?$prouct->subBrand->name:''}}</td>
                                            <td>{{$item_code?$item_code->name:''}}</td>
                                            <td>{{$multi_qty[$key]}}</td>
                                            <td>{{$multi_unit_price[$key]}}</td>
                                            <td>{{$multi_total_price[$key]}}</td>
                                            <td>{{$multi_vat_price[$key]}}</td>
                                            <td>{{$multi_total_amount[$key]}}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                            <tbody>
                                <tr class="border-bottom">
                                    <td colspan="7"></td>
                                    <td class="text-center" style="color: black">Sub Total</td>
                                    <td colspan="2" class="text-center">{{$requests['amount']}}</td>
                                </tr>
                                <tr class="border-bottom">
                                    <td colspan="7"></td>
                                    <td class="text-center" style="color: black">Tax Amount</td>
                                    <td colspan="2" class="text-center">{{$requests['vat_amount']}}</td>
                                </tr>
                                <tr class="border-bottom">
                                    <td colspan="7"></td>
                                    <td class="text-center" style="color: black"> Total Amount</td>
                                    <td colspan="2" class="text-center">{{$requests['total_amount']}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="divFooter mb-1 ml-1">
        Business Software Solutions by
        <span style="color: #0005" class="spanStyle"><img class="img-fluid" src="{{ asset('img/zisprink.png')}}" alt="" width="70"></span>
    </div>
</section>

