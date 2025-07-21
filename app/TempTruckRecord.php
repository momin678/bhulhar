<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TempTruckRecord extends Model
{
    protected $fillable = ['user_id', 'token', 'truck_id', 'customer_id', 'driver_name', 'material', 'crusher', 'destination', 'serial_no', 'weight', 'date', 'truck_owner', 'toll_fee', 'tkt_no', 'rate', 'amount', 'rak_toll', 'sharjah_toll', 'fujairah_toll', 'transproter', 'commision'];
    public function check_truck_number($number){
        // dd($number);
        $truck = Truck::where('vehicle_number',$number)->first();
       return $truck;
    }
    public function check_customer_name($name){
        $customer = null;
        if($name){
            $customer = PartyInfo::where('pi_name',$name)->first();
        }
        return $customer;
    }
    public function check_tkt_number($tkt_number){
        $tkt_number = TempTruckRecord::where('tkt_no', $tkt_number)->get();
        $tkt_number1 = TruckRecords::where('tkt_number', $tkt_number)->get();
        if(count($tkt_number)+count($tkt_number1)>1){
            return true;
        }else{
            return false;
        }
        
    }
    public function check_rate($cruser, $destination){
        
        $cruser_id = Cursher::where('name', $cruser)->first();
        // dd($cruser_id);
        // return $cruser_id;
        $rate = null;
        $destination_id = Destination::where('name', $destination)->first();
        // dd($destination_id);
        if($cruser_id && $destination_id){
            $rate = Rate::where('cursher_id', $cruser_id->id)->where('destination_id', $destination_id->id)->first();
            // dd($rate);
        }
        return $rate;
    }
    public function check_toll_rate($cruser, $destination, $weight){
        $cruser_id = Cursher::where('name', $cruser)->first();
        $total_amount = 0;
        $rate = 0;
        $destination_id = Destination::where('name', $destination)->first();
        if($cruser_id && $destination_id){
            $amount = TollRate::where('cursher_id', $cruser_id->id)->where('destination_id', $destination_id->id)->where('type', 'Fixed')->sum('amount');
            $rate = TollRate::where('cursher_id', $cruser_id->id)->where('destination_id', $destination_id->id)->where('type', 'Changeable')->get();
            $fnrc_toll = 0;
            foreach($rate as $r){
                $add_amount = 0;
                $get_amount = ($r->amount*$weight)/10;
                $integer = floor($get_amount);
                $fraction = number_format($get_amount - $integer,2);
                if($fraction> .5){
                    $add_amount = 10;
                }
                $fnrc_toll += $integer*10 + $add_amount;
            }
            $total_amount = $amount+$fnrc_toll;
        }
        return $total_amount;
    }
}
