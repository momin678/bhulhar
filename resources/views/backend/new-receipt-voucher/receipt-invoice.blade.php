

<table class="table table-bordered table-sm " >
    <thead>
        <tr>
            <th style="width: 5%">#</th>
            <th style="width: 28%">Invoice</th>
            <th style="width: 28%">Total Amount </th>
            <th style="width: 28%">Due Amount </th>
        </tr>
    </thead>
    @foreach ($invoices as $key => $inv)
    <tr id="TRow" >
        <td> {{$key+1}}</td>
        <td> {{$inv->invoice_no}} </td>
        <td> {{$inv->total_price}} </td>
        <td> {{$inv->due_amount}} </td>
    </tr>
    @endforeach
    <tr>
        <td colspan="2"></td>
        <td class="text-center" style="color: black">Total Due</td>
        <td>{{$invoices->sum('due_amount')}}</td>
    </tr>
</table>

