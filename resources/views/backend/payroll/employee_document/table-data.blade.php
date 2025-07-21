<table style="width: 100%" id="fund-history-table">
    <tr style="background: #fff">
    <th>Date</th>
    <th>Discription</th>
    <th>Update by</th>
    <th>Approve by</th>
    </tr>
    @foreach ($data->updateHistories as $record)
    <tr style="background: #fff">
    <td>{{$record->created_at}}</td>
    <td>{{$record->description}}</td>
    <td>{{$record->updater->name}}</td>
    @if(!empty($record->approver->name))
     <td>{{$record->approver->name}}</td>
     @else
     <td>Yet to be approved</td>
    @endif
    </tr>
    @endforeach
</table>
