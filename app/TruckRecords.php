<?php

namespace App;

use App\Models\Payroll\Employee;
use Illuminate\Database\Eloquent\Model;

class TruckRecords extends Model
{
    protected $fillable = ['truck_id', 'customer_id', 'driver_name', 'material', 'crusher', 'destination', 'serial_no', 'weight', 'date', 'truck_owner', 'toll_fee', 'tkt_no', 'rate', 'amount', 'rak_toll', 'sharjah_toll', 'fujairah_toll', 'transproter', 'commision'];
    public function truck(){
        return $this->belongsTo(Truck::class, 'truck_id');
    }

    public function customer(){
        return $this->belongsTo(PartyInfo::class,'customer_id');
    }

    public function supplier(){
        return $this->belongsTo(PartyInfo::class,'truck_owner');
    }
    public function driver_name_info(){
        return $this->belongsTo(Employee::class, 'driver_name','id');
    }
    public static function check_toll_rate($cruser, $destination, $weight){
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
