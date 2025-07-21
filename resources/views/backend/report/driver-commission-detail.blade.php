<section class="print-hideen border-bottom" style="padding: 5px 15px;">
    <div class="d-flex flex-row-reverse">
        <div class="pr-1" style="margin-top: 5px;">
            <a href="#" class="close btn-icon btn btn-danger" data-dismiss="modal" aria-label="Close" title="Close"><spanaria-hidden="true"><i class='bx bx-x' style="padding-bottom: 3px;"></i></spanaria-hidden=></a>
        </div>
        <div class="pr-1" style="margin-top: 5px;">
            <a href="{{ route('driver-commission-print', ['id' => $driver_info->id, 'from' => $from, 'to' => $to]) }}" target="_blank" class="btn btn-icon btn-secondary"><i class="bx bx-printer"></i></a>
        </div>
        <div class="w-100">
            <h4 style="font-family:Cambria;font-size: 2rem;">Commission Details</h4>
        </div>
    </div>
</section>
<div>
    <form action="{{route('driver-commission-update')}}" method="post">
        @csrf
        <table class="table mb-0 table-sm table-hover table-bordered">
            <thead class="">
                <tr style="height: 50px;">
                    <th>Date</th>
                    <th>Party Name</th>
                    <th>Truck Number</th>
                    <th>Material</th>
                    <th>Crusher</th>
                    <th>DSTN</th>
                    <th>TKT NO</th>
                    <th>WGT</th>
                    <th>Commission</th>
                </tr>
            </thead>
            <tbody class="table-sm">
                @foreach ($records as $t_record)
                    <tr class="trFontSize t-row">
                        <input type="hidden" name="id[]" value="{{$t_record->id}}">
                        <td>{{date('d/m/Y', strtotime($t_record->date))}}</td>
                        <td>{{$t_record->customer?$t_record->customer->pi_name:''}}</td>
                        <td>{{$t_record->truck->vehicle_number}}</td>
                        <td>{{$t_record->material}}</td>
                        <td class="crusher">{{$t_record->crusher}}</td>
                        <td class="r-destination">{{$t_record->destination}}</td>
                        <td>{{$t_record->tkt_number}}</td>
                        <td>{{$t_record->weight}}</td>
                        <td>
                            <input type="number" step="any" value="{{$t_record->commision}}" class="r-rate" required name="commission[]">
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="8" class="text-right pr-1"><Strong>Total: </Strong></td>
                    <td class="pr-1"><Strong id="total_driver_amount">{{number_format($records->sum('commision'),2)}}</Strong></td>
                </tr>
            </tbody>
        </table>
        <div class="text-right">
            <button type="submit" class="btn btn-success m-1"> Update</button>
        </div>
    </form>
</div>