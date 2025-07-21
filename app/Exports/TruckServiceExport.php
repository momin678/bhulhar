<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TruckServiceExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $parameters;

    function __construct($parameters) {
        $this->parameters = $parameters;
    }
    public function collection()
    {
        $records =  DB::table('truck_records')
        ->join('employees', 'employees.id', '=', 'truck_records.driver_name')
        ->join('trucks', 'trucks.id', '=', 'truck_records.truck_id')
        ->join('party_infos', 'party_infos.id', '=', 'truck_records.customer_id')
                    ->select($this->parameters['request_fiels']);
        // dd($records);
        return $records->where('is_invoiced',0)->get();
    }
    public function headings(): array
    {
        $items = $this->parameters['request_fiels'];
        $select_title = [];
        foreach($items as $key => $item){
            array_push($select_title, $key);
        }
        return $select_title;
    }
}
