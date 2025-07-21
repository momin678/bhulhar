<style>

    thead {
    background: #34465b;
    color: #fff !important;
    height: 30px;
    }
    .print-show{
        display: none;
    }
    @media print{
    {
        .print-show
        {
            display: block !important;
        }
    }
}
</style>
<section class="print-hideen border-bottom" style="padding: 5px 15px;background: #34465b;">
    <div class="d-flex flex-row-reverse" style="padding: 0 11px;">
        <div class="mIconStyleChange" style="padding: 10px 2px !important;"><a href="#" class="close btn-icon btn btn-danger" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class='bx bx-x'></i></span></a></div>
        {{-- <div class="mIconStyleChange"><a href="#" class="btn btn-icon btn-success"><i class="bx bx-edit"></i></a></div> --}}
        <div class="mIconStyleChange" style="padding: 10px 2px !important;"><a href="#"   onclick="handlePrintClick('widgets-Statistics1')"  class="btn btn-icon btn-success" title="Print"><i class='bx bx-printer'></i></a></div>
        {{-- <div class="mIconStyleChange" style="padding: 10px 2px !important;"><a href="{{route("tem-journal-view-pdf", $journal->id)}}" class="btn btn-icon btn-primary"  title="PDF"><i class='bx bxs-file-pdf'></i></a></div> --}}
        {{-- <div class="mIconStyleChange"><a href="#"  onclick="window.print();" class="btn btn-icon btn-light"><i class='bx bxs-virus'></i></a></div> --}}
        <div class="w-100">
            <h4 style="font-family:Cambria;font-size: 2rem;color:white;">Journal</h4>
        </div>
    </div>
</section>
{{-- <div class="print-show">
    @include('layouts.backend.partial.modal-header-info')
</div> --}}

<section id="widgets-Statistics1" style="padding: 0 15px;">
    <div class="cardStyleChange">

        <div class="card-body p-0 pt-1">
                <div class="row">
                    <div class="col-md-12 text-center invoice-view-wrapper student_profle-print">
                        <h2>Journal</h2>
                    </div>
                    <div class="col-3">
                        <strong>Journal No:</strong>  {{ $journal->journal_no}}
                    </div>

                    <div class="col-2">
                        <strong>Date:</strong> {{ date('d/m/Y',strtotime($journal->date))}}
                    </div>

                    <div class="col-2">
                        <strong>Payment Mode:</strong> {{ $journal->pay_mode}}
                    </div>
                    <div class="col-3">
                        <strong>Party Name:</strong> {{ $journal->PartyInfo->pi_name}}
                    </div>

                    <div class="col-2">
                        <strong>Amount:</strong> @if(!empty($currency->symbole)){{$currency->symbole}}@endif{{ $journal->amount}}
                    </div>

            </div>
        </div>
    </div>
    <div class="cardStyleChange">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-bordered border-botton">
                    <thead class="thead">
                        <tr >
                            {{-- <th>Date</th> --}}
                            <th>HEAD</th>
                            <th>Invoice No</th>
                            <th>Debit</th>
                            <th>Credit</th>
                        </tr>
                    </thead>

                    <tbody class="user-table-body">
                            @php
                                $rowcount=$journal->records->count();
                            @endphp
                            @foreach ($journal->records()->orderBy('transaction_type','DESC')->get() as $record)
                            <tr class="text-center trFontSize">
                                <td >{{$record->account_head }}</td>
                                <td >{{$record->invoice_no }}</td>

                                <td >{{ $retVal = ($record->transaction_type=='DR') ? $currency->symbole .' '.$record->amount : ''  }}</td>
                                <td >{{ $retVal = ($record->transaction_type=='CR') ? $currency->symbole .' '.$record->amount : ''  }}</td>
                            </tr>
                            @endforeach
                            <tr class="border-bottom">
                                <td colspan="4" class="text-center"> ( {{$journal->narration}} ) </td>

                            </tr>
                    </tbody>
                </table>
            </div>
            <div class="row d-flex align-items-center justify-content-center print-none">
                <div class="col-12 text-center">
                    <h3>Supporting Document</h3>

                </div>
                @if (($journal->voucher_scan != '') && ($journal->voucher_scan2 != '') )
                <div class="col-6 text-center">
                    <img src="{{asset('storage/upload/documents')}}/{{$journal->voucher_scan}}" class="img-fluid" style="height: 490px" alt="">
                </div>
                <div class="col-6 text-center">
                    <img src="{{asset('storage/upload/documents2')}}/{{$journal->voucher_scan2}}" class="img-fluid" style="height: 490px" alt="">
                </div>
                @elseif(($journal->voucher_scan != '') && ($journal->voucher_scan2 == ''))
                <div class="col-12 text-center">
                    <img src="{{asset('storage/upload/documents')}}/{{$journal->voucher_scan}}" class="img-fluid" style="height: 490px" alt="">

                </div>
                @elseif(($journal->voucher_scan == '') && ($journal->voucher_scan2 != ''))
                <div class="col-12 text-center">
                    <img src="{{asset('storage/upload/documents2')}}/{{$journal->voucher_scan2}}" class="img-fluid" style="height: 490px" alt="">

                </div>
                @endif
            <div class="col-12 d-flex justify-content-end print-hideen print-none">
                <button type="submit" class="btn btn-info formButton" title="Approve">
                    <a href="{{ route('journalMakeApprove',$journal) }}" onclick="return confirm('about to authorize journal. Please, Confirm?')" class="btn btn-info formButton btn-block">
                        <img src="{{asset('assets/backend/app-assets/icon/save-icon.png')}}" alt="" srcset="" width="25">
                        Approve
                    </a>
                </button>
            </div>
        </div>
    </div>
</section>
@include('layouts.backend.partial.modal-footer-info')
