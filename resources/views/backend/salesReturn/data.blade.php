<table class="table table-sm table-bordered return-item">
        <thead>
            <tr>
                <th>SL</th>
                <th>Style ID</th>
                <th>Item Name</th>    
                <th>QTY</th>
              
                <th>Unit Price</th>
                <th>Vat rate</th>
                <!-- <th>Vat Amount</th>  -->
                <th>Total Price </th>
                 <th>Action </th>
            </tr>
        </thead>
        <tbody class="all-data-area">
            @foreach ($return_item as $item)
            <tr class="data-row">
                <td>{{ ++$i }}</td>
                <td>{{ $item->style_name }}</td>
                <td>{{$item->item_name }}</td>

                <td>{{ $item->ruturn_qty }}</td>
                <td>{{ $item->unit_price }}</td>
                <td>{{ $item->vat_rate }}</td>
          
              
                <td>{{number_format((float)( $item->total),'2','.','') }}</td>
  <td>                <a type="button" class="btn btn-danger sm-btn delete_item_1" data-item_id1="{{$item->item_id }}" data-invoice_no1="{{$item->invoice_no}}"> <i class="bx bx-trash"></i> </a></td>
            </tr>
            @endforeach

           
        </tbody>
    </table>