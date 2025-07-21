<table class="table table-sm table-bordered return-item mt-3">
    <thead>
        <tr>
            <th>Pruchase No</th>
            <th>Style ID</th>
            <th scope="col">Item Name</th>
            <th scope="col">Pur. Rate</th>
            <th scope="col">Qty</th>
            <th scope="col">Amount(vat)</th>
            <th scope="col">Action</th>
            </th>
        </tr>
    </thead>
    <tbody id="tempLists" class="user-table-body">
        @foreach($return_item as $item)
        <tr class="data-row">
            <td>{{$item->purchase_no}}</td>
            <td>{{$item->itemName->style_name}}</td>
            <td>{{$item->itemName->item_name}}</td>
            <td>{{$item->purchase_rate}}</td>
            <td>{{$item->return_qty}}</td>
            <td>{{number_format((float)$item->total, 2, '.', '') }}</td>
            <td>
                <a type="button" class="btn btn-danger sm-btn delete_item_1" data-item_id1="{{$item->item_id }}" data-purchase_no1="{{$item->purchase_no}}"> <i class="bx bx-trash"></i> </a>
            </td>
        </tr>
        @endforeach


    </tbody>
 
</table>