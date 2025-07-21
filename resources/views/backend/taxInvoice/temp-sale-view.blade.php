

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
            <div class="py-1 pr-1"><a href="{{route('temp-tax-invoice-delete', $tax_invoice->id)}}" class="btn btn-icon btn-danger" onclick="return confirm('Delete! Confirm?')"><i class='bx bxs-trash'></i></a></div>
            <div class="py-1 pr-1"><a href="{{ route('tax-invoice-edit', $tax_invoice->id) }}" class="btn btn-icon btn-info"><i class="bx bx-edit"></i></a></div>
            @if ($tax_invoice->status == 0)
                <div class="py-1 pr-1">
                    <a href="{{ route('temp-tax-invoice-authorize-submit', $tax_invoice->id) }}" class="btn btn-icon btn-success" onclick="return confirm('Approve! Confirm?')">Approve</a>
                </div>
            @else
                <div class="py-1 pr-1">
                    <a href="{{ route('temp-tax-invoice-approve-submit', $tax_invoice->id) }}" class="btn btn-icon btn-success" onclick="return confirm('Approve! Confirm?')">Approve</a>
                </div>
            @endif
    </div>
</section>
@include('layouts.backend.partial.modal-header-info')
<section id="widgets-Statistics">
    <div>
        <h4 class="text-center">Tax Invoice View</h4>
    </div>
    @php
        $company_name = App\Setting::where('config_name', 'company_name')->first();
    @endphp
    <div class="row">
        <div class="col-md-12">
            <div class="">
                <div class="mx-2 mb-2">
                    <div class="row">
                        <div class="col-md-6 pb-2"><strong>To: </strong> {{$tax_invoice->partInfo->pi_name}}</div>
                        <div class="col-md-6 pb-2"><strong>From: </strong>{{$company_name->config_value}}</div>
                        <div class="col-md-3">
                            <strong>Invoice No:</strong> {{ $tax_invoice->invoice_no}}
                        </div>
                        <div class="col-md-3">
                            <strong>Date:</strong> {{ convert_date_format($tax_invoice->date)}}
                            <strong class="pl-2">Pay Mode:</strong> {{ $tax_invoice->pay_mode}}
                        </div>
                        <div class="col-md-3">
                            <strong>TRN:</strong> {{ $tax_invoice->partInfo->trn_no}}
                        </div>
                        <div class="col-md-3">
                            <strong>ADDRESS:</strong> {{ $tax_invoice->partInfo->address}}
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
                                    <th>Vat</th>
                                    <th>Total</th>
                                </tr>
                            </thead>

                            <tbody class="user-table-body">
                                @foreach ($items as $key => $item)
                                    @php
                                        $v_name = App\VehicleName::find($item->vehicle_name_id);
                                        $v_model = App\SubBrand::find($item->sub_brand_id);
                                    @endphp
                                    <tr class="border-bottom text-center">
                                        <td>{{$item->category->name}}</td>
                                        <td>{{$item->brand->name}}</td>
                                        <td>{{$v_name->name}}</td>
                                        {{-- <td>{{$item->vehicle_name?$item->vehicle_name->name:''}}</td> --}}
                                        {{-- <td>{{$item->vehicle_model?$item->vehicle_model->name:''}}</td> --}}
                                        <td>{{$v_model->name}}</td>
                                        <td>{{$item->item_code->name}}</td>
                                        <td>{{$item->quantity}}</td>
                                        <td>{{$item->unit_price}}</td>
                                        <td>{{$item->price}}</td>
                                        <td>{{$item->vat}}</td>
                                        <td>{{$item->total_price}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tbody>
                                <tr class="border-bottom">
                                    <td colspan="7"></td>
                                    <td class="text-center" style="color: black">Sub Total</td>
                                    <td colspan="2" class="text-center">{{$tax_invoice->price}}</td>
                                </tr>
                                <tr class="border-bottom">
                                    <td colspan="7"></td>
                                    <td class="text-center" style="color: black">Tax Amount</td>
                                    <td colspan="2" class="text-center">{{$tax_invoice->vat_amount}}</td>
                                </tr>
                                <tr class="border-bottom">
                                    <td colspan="7"></td>
                                    <td class="text-center" style="color: black"> Total Amount</td>
                                    <td colspan="2" class="text-center">{{$tax_invoice->total_price}}</td>
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

