<?php

namespace App\Imports;

use App\PartyInfo;
use App\Truck;
use App\TruckRecords;
use App\TempTruckRecord;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Facades\Excel;
use App\Setup;
use App\Destination;
use App\Cursher;
use App\TollRate;
class TruckServiceImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function startRow(): int
    {
        return 2;
    }
    public function model(array $row)
    {
        $token = Session::get('token');
        if($row[0]=='Party Name' || $row[0]=='PARTY NAME'){
            return;
        }else{
            if($row[0]){
                if(gettype($row[2]) == 'integer' || gettype($row[2]) == 'double'){
                    $excel_date = $row[2]; //here is that value 41621 or 41631
                    $unix_date = ($excel_date - 25569) * 86400;
                    // dd($unix_date);
                    $excel_date = 25569 + ($unix_date / 86400);
                    $unix_date = ($excel_date - 25569) * 86400;
                    $date1 = gmdate("Y-m-d", $unix_date);
                }else{
                    $date1 = strtr($row[2], '/', '-');
                }
                // $toll_setup = Setup::where('name', 'Toll Setup')->first();
                // if($toll_setup->value=='Automatic'){
                //     $destination = Destination::where('name', $row[6])->first();
                //     if(!$destination){
                //         $destination = new destination;
                //         $destination->name = $row[6];
                //         $destination->save();
                //     }
                //     $cruser = Cursher::where('name', $row[5])->first();
                //     if(!$cruser){
                //         $cruser = new Cursher;
                //         $cruser->name = $row[5];
                //         $cruser->save();
                //     }
                //     $toll_fees = TollRate::where('cursher_id', $cruser->id)->where('destination_id', $destination->id)->where('type', 'Fixed')->get();
                //     $toll_fee_change = TollRate::where('cursher_id', $cruser->id)->where('destination_id', $destination->id)->where('type', 'Changeable')->first();
                //     $toll_fee_amount = $toll_fees->sum('amount');
                //     if($toll_fee_change){
                //         $toll_fee_amount += $toll_fee_change->amount*$row[7];
                //     }
                // }else{
                //     $toll_fee_amount = $row[11];
                // }
                $toll_fee_amount = $row[11]>0?$row[11]:0.00;
                // dd($row[7]*$row[8]);
                return new TempTruckRecord([
                    'user_id'           => Auth::user()->id,
                    'token'             => $token,
                    'serial_no'         => 1001,
                    'date'              => date('Y-m-d', strtotime($date1)), //$row[2]
                    'tkt_no'            => $row[10],
                    'material'          => $row[4],
                    'truck_id'          => $row[3],
                    'crusher'           => $row[5],
                    'destination'       => $row[6],
                    'weight'            => $row[7],
                    'rate'              => $row[8],
                    'amount'            => null,
                    'rak_toll'          => 0,
                    'sharjah_toll'      => 0,
                    'fujairah_toll'     => 0, 
                    'customer_id'       => $row[0],
                    'transproter'       => null,
                    'driver_name'       => $row[1],
                    'truck_owner'       => null,
                    'commision'         => $row[9],
                    'toll_fee'          => $toll_fee_amount,
                    'amount'            => $row[7]*$row[8],
                ]);
            }
        }
        return;
    }
}
