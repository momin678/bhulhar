

<style>


    thead {
    background: #8d8888;
    color: #fff !important;
    height: 30px;
}
</style>
<section class="print-hideen border-bottom" style="padding: 5px 15px;background:#364a60;">
    <div class="d-flex flex-row-reverse">
        <div class="" style="padding-top:5px;"><a href="#" class="close btn-icon btn btn-danger" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class='bx bx-x'></i></span></a></div>
        {{-- <div class=""><a href="#"  onclick="window.print();" class="btn btn-icon btn-secondary"><i class='bx bx-printer'></i></a></div> --}}
        {{-- <div class=""><a href="#" onclick="window.print();" class="btn btn-icon btn-light"><i class='bx bxs-virus'></i></a></div> --}}
        <div class="w-100">
            <h4 style="font-family:Cambria;font-size: 2rem;color:white;">{{$acc_head->fld_ac_head}} - Ledger</h4>
        </div>
    </div>
</section>
@include('layouts.backend.partial.modal-header-info')
<section id="widgets-Statistics">

    <div class="row pl-1 pr-1 pt-1">
        <div class="col-md-12">
            <table class="table table-sm">
                <tr>
                    <th>{{ $acc_head->fld_ac_code }}</th>
                    <th><a
                            href="{{ route('head-details', $acc_head->id) }}">{{ $acc_head->fld_ac_head }}</a>
                    </th>
                    <th></th>
                    <th class="text-right"></th>
                    <th class="text-right"></th>
                </tr>
                <tr>
                    <th>Date</th>
                    <th>Narration</th>
                    <th>Ref. No.</th>
                    <th class="text-right">Debit</th>
                    <th class="text-right">Credit</th>
                </tr>
                @php
                    $each_ledger_dr = 0;
                    $each_ledger_cr = 0;
                @endphp
                @foreach (App\JournalRecord::where('account_head_id', $acc_head->id)->where('journal_id', '!=', 0)->where('opening_balance_entry', false)->orderBy('journal_date', 'ASC')->get() as $record)
                    @php
                        $reverse = $record->transaction_type == 'DR' ? 'CR' : 'DR';
                    @endphp
                    @foreach ($r_count = App\JournalRecord::where('journal_id', $record->journal_id)->where('opening_balance_entry', false)->where('transaction_type', $reverse)->get() as $ledger_record)
                        @if ($r_count->count() > 1)
                            <tr class="trFontSize journalDetails" v-type="main"
                                style="cursor: pointer;" id="{{ $record->journal_id }}">
                                <td>{{ \Carbon\Carbon::parse($ledger_record->journal_date)->format('d/m/Y') }}
                                </td>
                                <td>
                                    {{ $ledger_record->account_head }}
                                </td>
                                <td></td>
                                <td class="text-right">
                                AED {{ $dr_amount = $record->transaction_type == 'DR' ? $ledger_record->amount : 0 }}
                                </td>
                                <td class="text-right">
                                AED {{ $cr_amount = $record->transaction_type == 'CR' ? $ledger_record->amount : 0 }}
                                </td>
                            </tr>
                        @else
                            <tr class="trFontSize journalDetails" v-type="main"
                                style="cursor: pointer;" id="{{ $record->journal_id }}">
                                <td>{{ \Carbon\Carbon::parse($ledger_record->journal_date)->format('d/m/Y') }}
                                </td>
                                <td>
                                    {{ $ledger_record->account_head }}
                                </td>
                                <td></td>
                                <td class="text-right">
                                    AED {{ $dr_amount = $record->transaction_type == 'DR' ? $record->amount : 0 }}
                                </td>
                                <td class="text-right">
                                    AED {{ $cr_amount = $record->transaction_type == 'CR' ? $record->amount : 0 }}
                                </td>
                            </tr>
                        @endif

                        @php
                            $each_ledger_dr = $each_ledger_dr + $dr_amount;
                            $each_ledger_cr = $each_ledger_cr + $cr_amount;
                        @endphp
                    @endforeach
                @endforeach
                <tr>
                    <th colspan="2"></th>
                    <th colspan="">Balance C/D</th>
                    <th class="text-right">
                        AED  {{ $each_ledger_dr > $each_ledger_cr ? '0' : number_format($each_ledger_cr - $each_ledger_dr, 2) }}
                    </th>

                    <th class="text-right">
                        AED  {{ $each_ledger_dr > $each_ledger_cr ? number_format($each_ledger_dr - $each_ledger_cr, 2) : '0' }}
                    </th>
                </tr>
                <tr>
                    <th></th>
                    <th></th>
                    <th>Total</th>
                    <th class="text-right">
                        AED  {{ $each_ledger_dr > $each_ledger_cr ? number_format($each_ledger_dr, 2) : number_format($each_ledger_cr, 2) }}
                    </th>
                    <th class="text-right">
                        AED  {{ $each_ledger_dr > $each_ledger_cr ? number_format($each_ledger_dr, 2) : number_format($each_ledger_cr, 2) }}
                    </th>
                </tr>
                <tr>
                    <td>
                        <p></p>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
        </table>
        </div>
    </div>
</section>

