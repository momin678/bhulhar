@if ($receivable_recordes->count()+$payable_recordes->count()>0)

    @if($receivable_recordes->count()>0)
        <table   class="table table-sm">
                                        
                                        
                                            
            <tr>                                
                <th colspan="8" class="text-center">Receivable</th>
            </tr>
            <tr>                                
                <th>Date</th>
                <th>Account</th>
                <th>Transection Details</th>
                <th>Transections</th>
                <th>Ref. No.</th>
                <th class="text-right">Debit</th>
                <th class="text-right">Credit</th>
                <th class="text-right">Amount</th>
            </tr>
                @php
                    $balance=0;
                    $each_ledger_dr=0;
                    $each_ledger_cr=0;
            
                @endphp
                @foreach ($receivable_recordes as $record)

                <tr class="trFontSize journalDetails" v-type="main" style="cursor: pointer;" id="{{$record->journal_id}}">
                    
                
                        <td>{{ \Carbon\Carbon::parse($record->journal_date)->format('d.m.Y')}}</td>
                        <td>
                            {{$record->account_head}} 
                        </td>
                        <td>{{$record->party->pi_name}}</td>
                        <td>{{$record->journal->journal_no}}</td>
                        <td></td>
                        <td class="text-right">{{ $dr_amount= $record->transaction_type=='DR' ? $record->amount : 0 }} </td>
                        <td class="text-right">{{ $cr_amount= $record->transaction_type=='CR' ? $record->amount : 0 }}</td>
                        @php
                            $balance=$balance+$dr_amount-$cr_amount;
                        @endphp
                        {{-- <td class="text-right">{{$balance==0? 0: ($balance>0? $balance.'DR': ($balance*(-1).'CR')) }}</td> --}}
                        <td class="text-right">{{ $cr_amount > $dr_amount? $cr_amount - $dr_amount.'CR': $dr_amount - $cr_amount.'DR'}}</td>
                    </tr>
                    @php
                        $each_ledger_dr= $each_ledger_dr+$dr_amount;
                        $each_ledger_cr= $each_ledger_cr+$cr_amount;
                    @endphp

                

                @endforeach
                <tr>                                
                    <th></th>
                    <th colspan="3"></th>
                    <th>Total</th>
                    <th class="text-right">{{ number_format($each_ledger_dr,2) }}</th>
                    <th class="text-right">{{ number_format($each_ledger_cr,2)}}</th>
                </tr>

                <tr>                                
                    <td> <p></p></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
        </table>
    @endif
@if($payable_recordes->count()>0)
    <table   class="table table-sm">                              
        <tr>                                
            <th colspan="8" class="text-center">Payable</th>
        </tr>
        <tr>                                
            <th>Date</th>
            <th>Account</th>
            <th>Transection Details</th>
            <th>Transections</th>
            <th>Ref. No.</th>
            <th class="text-right">Debit</th>
            <th class="text-right">Credit</th>
            <th class="text-right">Amount</th>
        </tr>
            @php
                $balance=0;
                $each_ledger_dr=0;
                $each_ledger_cr=0;
            @endphp
            @foreach ($payable_recordes as $record)

            <tr class="trFontSize journalDetails" v-type="main" style="cursor: pointer;" id="{{$record->journal_id}}">
                    <td>{{ \Carbon\Carbon::parse($record->journal_date)->format('d.m.Y')}}</td>
                    <td>
                        {{$record->account_head}} 
                    </td>
                    <td>{{$record->party->pi_name}}</td>
                    <td>{{$record->journal->journal_no}}</td>
                    <td></td>
                    <td class="text-right">{{ $dr_amount= $record->transaction_type=='DR' ? $record->amount : 0 }} </td>
                    <td class="text-right">{{ $cr_amount= $record->transaction_type=='CR' ? $record->amount : 0 }}</td>
                    @php
                        $balance=$balance+$dr_amount-$cr_amount;
                    @endphp
                    {{-- <td class="text-right">{{$balance==0? 0: ($balance>0? $balance.'DR': ($balance*(-1).'CR')) }}</td> --}}
                    <td class="text-right">{{ $cr_amount > $dr_amount? $cr_amount - $dr_amount.'CR': $dr_amount - $cr_amount.'DR'}}</td>
                </tr>
                @php
                    $each_ledger_dr= $each_ledger_dr+$dr_amount;
                    $each_ledger_cr= $each_ledger_cr+$cr_amount;
                @endphp
            @endforeach
            <tr>                                
                <th></th>
                <th colspan="3"></th>
                <th>Total</th>
                <th class="text-right">{{ number_format($each_ledger_dr,2) }}</th>
                <th class="text-right">{{ number_format($each_ledger_cr,2)}}</th>
            </tr>

            <tr>                                
                <td> <p></p></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
    </table>
@endif



@else
<tr>
    <td class="text-center text-danger" colspan="6">No Result Found</td>
</tr>

@endif
