<?php

namespace App\Imports;

use App\PartyInfo;
use App\Truck;
use App\TruckRecords;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Facades\Excel;
class ClientType implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $truck_details = Truck::where('vehicle_number', $row[3])->first();
        $customer = PartyInfo::where('pi_name', $row[7])->first();
        if($truck_details && $customer && $row[6]){
            $excel_date = $row[0]; //here is that value 41621 or 41631
            $unix_date = ($excel_date - 25569) * 86400;
            $excel_date = 25569 + ($unix_date / 86400);
            $unix_date = ($excel_date - 25569) * 86400;
            return new TruckRecords([
                'truck_id'          => $truck_details->id,
                'customer_id'       => $customer->id,
                'driver_name'       => $row[8],
                'material'          => $row[2],
                'crusher'           => $row[4],
                'destination'       => $row[5],
                'serial_no'         => $row[1],
                'weight'            => $row[6],
                'date'              => gmdate("Y-m-d", $unix_date),
                'truck_owner'       => $truck_details->party->id,
                'toll_fee'          => $row[9],
            ]);
        }
        return;
    }
}
