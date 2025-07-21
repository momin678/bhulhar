
@php
    $c=0;
@endphp
<div class="table-responsive">
    <table class="table table-bordered table-sm" >
        <thead>
            <tr>
                <th class="px-1">#</th>
                <th style="min-width:110px;width: 28%">Bill No </th>
                <th style="min-width:110px;width: 28%">ACC.Head</th>
                <th style="min-width:110px;width: 28%">Total Amount </th>
                <th style="min-width:110px;width: 28%">Due Amount </th>
                <th style="min-width:110px;width: 28%">Receive Amount </th>
            </tr>
        </thead>
        @foreach ($add_lists as $item)
        <tr id="TRow" >
            <input type="hidden" value="{{$item->bill_id}}" name="bill_id[]">
            <td>{{++$c}}</td>
            <td>
                {{$item->purchase_expense_item->bill_no}}
            </td>
            <td>
                {{$item->purchase_expense_item->head->fld_ac_head}}
            </td>
            <td>
                {{$item->purchase_expense_item->total_amount}}
            </td>
            <td>
                {{$item->purchase_expense_item->due_amount}}
            </td>
            <td>
                <input type="number" step="any" max="{{$item->purchase_expense_item->due_amount}}" name="receive_amount[]">
            </td>
        </tr>
        @endforeach
    </table>
</div>


