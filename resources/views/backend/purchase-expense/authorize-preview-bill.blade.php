

<style>
    html, body {
        height:100%;
    }
    thead {
        background: #34465b;
        color: #fff !important;
        height: 30px;
    }
    .remove-document{
        border: none;
        border-radius: 50%:
    }

    .document-file:hover .remove-document{
        display: block !important;
    }
@media print{
        .table tr th,
        .table tr td{
            color: #000000 !important;
            font-weight:500 !important;
        }
    }
</style>
<section class="print-hideen border-bottom" style="background: #364a60;">
    <div class="d-flex flex-row-reverse">

        <div class="pr-1" style="padding-top: 8px;padding-right: 22px !important;"><a href="#" class="close btn-icon btn btn-danger" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class='bx bx-x'></i></span></a></div>
        <div class="pr-1" style="padding: 8px;padding-right: 0.2rem !important;"><a href="#" onclick="window.print();" class="btn btn-icon btn-primary"><i class="bx bx-printer"></i></a></div>

        <div class="pr-1" style="padding-top: 8px;padding-right: 0.2rem !important;"><a href="{{route('purchase-approve',$purchase_exp)}}" onclick="return confirm('about to approval purchase. Please, Confirm?')" class="btn btn-sm btn-icon btn-warning" style="padding: 6px 8px;margin-right: -8px;"><i class="bx bx-check"></i></a></div>
        {{-- <div class="pr-1" style="padding-top: 8px;padding-right: 0.2rem !important;"><a href="{{route('purchase-expense.edit',$purchase_exp)}}" class="btn btn-sm btn-icon btn-success" style="padding: 6px 8px;"><i class="bx bx-edit"></i></a></div> --}}
        <div class="pr-1" style="padding-top: 9px;padding-right: 0.2rem !important;"><a href="{{route('purchase-expense.delete',$purchase_exp)}}" class="btn btn-sm btn-icon btn-danger" style="padding: 6px 8px;" onclick="return confirm('Delete Confirm ?')"><i class="bx bx-trash"></i></a></div>

        <div class="pr-1 w-100 pl-2" style="margin-top: 2px;">
            <h4 style="font-family:Cambria;font-size: 2rem;color:white;"> Expense </h4>
        </div>
    </div>
</section>
<div class="receipt-voucher-hearder invoice-view-wrapper" style="margin: 50px 20px; border-radius: 20px;">
    @include('layouts.backend.partial.modal-header-info')
</div>
<section id="widgets-Statistics">

    <div class="row">
        <div class="col-md-12 text-center invoice-view-wrapper student_profle-print my-1">
            <h2>Purchase - Bill</h2>
        </div>
        <div class="col-md-12">
            <div class="">
                <div class="mx-2 mb-2 pt-2">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-12">
                                    <strong>Client:</strong> {{$purchase_exp->client?$purchase_exp->client->pi_name : ' '}}
                                </div>

                                <div class="col-12 col-md-6 col-lg-3">
                                    <strong>Date:</strong> {{ date('d/m/Y',strtotime($purchase_exp->date))}}
                                </div>

                                <div class="col-12 col-md-6 col-lg-3">
                                    <strong>Payment Mode:</strong> {{ $purchase_exp->pay_mode}}
                                </div>

                                <div class="col-12 col-md-6 col-lg-3">
                                    <strong>Bill No:</strong> {{ $purchase_exp->purchase_no}}
                                </div>


                                <div class="col-12 col-md-6 col-lg-3">
                                    <strong>Amount:</strong> @if(!empty($currency->symbole)){{$currency->symbole}}@endif {{$purchase_exp->total_amount}}
                                </div>
                                @if ($purchase_exp->pay_mode=='Cheque')
                                <div class="col-12 col-md-6 col-lg-3">
                                    <strong>Issuing Bank:</strong> {{$purchase_exp->issuing_bank}}
                                </div>
                                <div class="col-12 col-md-6 col-lg-3">
                                    <strong>Branch:</strong> {{$purchase_exp->bank_branch}}
                                </div>
                                <div class="col-12 col-md-6 col-lg-3">
                                    <strong>Cheque No:</strong> {{$purchase_exp->cheque_no}}
                                </div>
                                <div class="col-12 col-md-6 col-lg-3">
                                    <strong>Deposit Date:</strong> {{date('d/m/Y', strtotime($purchase_exp->deposit_date))}}
                                </div>

                                @endif
                            </div>
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
                                    <th class="px-1"> SL </th>
                                    <th style="min-width: 150px;"> Description </th>
                                    <th style="min-width: 100px;"> Vehicle </th>
                                    <th style="min-width: 100px;">Qty </th>
                                    <th class="" style="min-width: 100px;"> Amount </th>
                                    <th class="" style="min-width: 100px;">Taxable Amount </th>
                                    <th class="" style="min-width: 100px;"> VAT </th>
                                    <th class="" style="min-width: 130px;"> Total Amount <small>(@if(!empty($currency->symbole)){{$currency->symbole}}@endif)</small></th>
                                </tr>
                            </thead>

                            <tbody class="user-table-body">
                                  @foreach ($items as $key => $item)
                                  <tr>
                                    <td class="text-center"> {{$key+1}} </td>
                                    <td class="text-center"> {{$item->head ? $item->head->fld_ac_head : ''}} </td>
                                    <td class="text-center"> {{$item->costCenter ? $item->costCenter->vehicle_number : ''}} </td>
                                    <td class="text-center"> {{ $item->qty}} </td>
                                    <td class="text-center">{{$item->rate}}</td>

                                    <td class="text-center">{{$item->amount}}</td>
                                    <td class="text-center">{{$item->vat}}</td>
                                    <td class="text-center">{{$item->total_amount}}</td>
                                 </tr>

                                  @endforeach
                                  <tr>
                                    <td colspan="{{$purchase_exp->invoice_type=='bill'?6:5}}" rowspan="3" class="text-center"><strong class="text-center">Narration: {{$purchase_exp->narration}}</strong></td>
                                    <td class="text-center"> Total Amount</td>
                                    <td  class="text-center">{{$purchase_exp->amount}}</td>
                                  </tr>
                                  <tr>
                                    <td class="text-center">VAT</td>
                                    <td  class="text-center">{{$purchase_exp->vat}}</td>
                                  </tr>
                                  <tr>

                                    <td class="text-center">Total Amount</small></td>
                                    <td  class="text-center">{{$purchase_exp->total_amount}}</td>
                                  </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 print-hideen ml-2">
            <form id="document-upload" action="{{route('temp.document.uoload',$purchase_exp->id)}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="d-flex align-items-center">
                    <div class="form-group">
                        <label for=""> Upload Document </label>
                        <input type="file" name="files[]" multiple class="form-control" required>
                    </div>

                    <input type="hidden" name="relation_column" value="purchase_id">

                    <button type="submit" id="document-submit-btn" class="btn btn-primary" style="margin-top:5px;"> Upload </button>
                </div>
            </form>
        </div>

        <div class="row p-2" id="documents">
            @if($purchase_exp->documents->count() > 0)
                @foreach ($purchase_exp->documents as $document)
                <div class="col-6 col-md-2 text-center px-4 print-hideen document-file" id="document-{{$document->id}}">
                    <button class="remove-document py-1 d-none" data-id={{$document->id}} data-url="{{route('temp.document.destroy',$document->id)}}">
                        <i class="bx bx-trash text-danger"></i>
                    </button>

                    <a href="{{asset($document->file_path)}}" target="blank" class="py-2">
                        <img src="{{asset($document->file_path)}}" class="img-fluid" style="min-width:100px; width:100%; max-height:150px;" alt="{{$document->extension}}">
                    </a>
                </div>
                @endforeach
            @endif
        </div>

        {{-- @if (isset($new))
        @else
        <div class="col-md-12 text-center mb-4">
            <a href="{{route('purchase-authorize',$purchase_exp)}}" class="btn btn-info btn-sm" onclick="return confirm('about to authorize purchase. Please, Confirm?')"> Authorize </a>

        </div>
        @endif --}}

    </div>




    <div class="divFooter mb-1 ml-1 footer-margin invoice-view-wrapper">
        Business Software Solutions by
        <span style="color: #0005" class="spanStyle"><img class="img-fluid" src="{{ asset('img/zisprink.png')}}" alt="" width="70"></span>
    </div>
</section>

<div class="img receipt-bg invoice-view-wrapper footer-margin">
    <img src="{{ asset('img/finallogo.PNG') }}" class="img-fluid" style="position: fixed; top: 420px; left: 200px; opacity: 0.2; width: 650px !important; height: 250px;" alt="">

    {{-- <img src="{{ asset('img/finallogo.jpeg') }}" class="img-fluid" style="position: fixed; top:100px; left:0px; opacity:0.1;width:100%; " alt=""> --}}
</div>
