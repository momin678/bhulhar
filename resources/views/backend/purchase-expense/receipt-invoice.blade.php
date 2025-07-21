
@php
    $c=0;
@endphp
<div class="table-responsive">
    <table class="table table-bordered table-sm" >
        <thead>
            <tr>
                <th>
                    <input type="checkbox" id="vehicle1" class="btn-select-all">
                    <label for="vehicle1" style="color: white;">S All</label>
                </th>
                <th>Purchase No</th>
                <th>Bill No </th>
                <th>Total Amount </th>
                <th>Due Amount </th>
                <th style="width: 150px;">Pay Amount </th>
            </tr>
        </thead>
        @foreach ($expenses as $item)
        <tr id="TRow" class="tr_obj">
            <td>
                <input type="checkbox" class="checkbox-record id_input" name="records[]" value="{{$item->id}}">
                <input type="checkbox" class="checkbox-record type_input" name="type_input[]" value="expenses" style="display: none !important;">
            </td>
            <input type="hidden" name="type[]" value="expenses">
            <input type="hidden" name="ids[]" value="{{$item->id}}">
            <td>
                {{$item->purchase_no}}
            </td>
            <td>
                {{$item->invoice_no}}
            </td>
            <td>
                {{$item->total_amount}}
            </td>
            <td>
                {{$item->due_amount}}
            </td>
            <td>
                <input type="number" step="any" name="due_pay_amount[]" style="width: 150px;" class="due_pay_amount" max="{{$item->due_amount}}">
            </td>
        </tr>
        @endforeach
        @foreach ($service_expense as $item)
        <tr id="TRow" class="tr_obj">
            <td>
                <input type="checkbox" class="checkbox-record id_input" name="records[]" value="{{$item->id}}">
                <input type="checkbox" class="checkbox-record type_input" for name="type_input[]" value="service_expense" style="display: none !important;">
            </td>
            <input type="hidden" name="type[]" value="service_expense">
            <input type="hidden" name="ids[]" value="{{$item->id}}">
            <td>
                {{$item->invoice_no}}
            </td>
            <td></td>
            <td>
                {{$item->amount+$item->vat_amount}}
            </td>
            <td>
                {{$item->due_amount}}
            </td>
            <td>
                <input type="number" step="any" name="due_pay_amount[]" style="width: 150px;" class="due_pay_amount" max="{{$item->due_amount}}">
            </td>
        </tr>
        @endforeach
        <tr>
            <td colspan="3"></td>
            <td class="text-center" style="color: black">Total Due <small>( @if(!empty($currency->symbole)){{$currency->symbole}}@endif)</small> </td>
            <td>{{$expenses->sum('due_amount')+$service_expense->sum('due_amount')}}</td>
        </tr>
    </table>
</div>


