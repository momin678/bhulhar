
@php
    $c=0;
@endphp
<table class="table table-bordered table-sm " >
    <thead>
        <tr >
            <th  style="width: 5%">#</th>
            <th  style="width: 28%">Invoice</th>
            <th style="width: 28%">Total Amount <small>( @if(!empty($currency->symbole)){{$currency->symbole}}@endif)</small></th>
            <th  style="width: 28%">Due Amount <small>( @if(!empty($currency->symbole)){{$currency->symbole}}@endif)</small></th>
        </tr>
    </thead>
    @foreach ($invoices as $inv)
    <tr id="TRow" >
        <td>{{++$c}}</td>
        <td>
            {{$inv->invoice_no}}
        </td>
        <td>
            {{$inv->vat_amount+$inv->amount}}
    </td>
    <td>
        {{$inv->due_amount}}
    </td>
    </tr>
    @endforeach
    <tr>
        <td colspan="2"></td>
        <td class="text-center" style="color: black">Total Due</td>
        <td>{{$invoices->sum('due_amount')}}</td>
    </tr>
</table>

