
<option value="">Select...</option>

@foreach ($sale_invoices as $item)
<option value="{{$item->id}}" data-from="sale-revenue">{{$item->invoice_no}}</option>
@endforeach

@foreach ($invoices as $item)
<option value="{{$item->id}}">{{$item->invoice_no}}</option>
@endforeach

