<?php

namespace App\Exports;

use App\Models\Attendence;
use App\Models\ShipsBookings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection; 
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use \Maatwebsite\Excel\Sheet;


class LoadingListExport implements FromCollection,WithHeadings 
{
   
    protected $id;

    function __construct($id) {
            $this->id = $id;
    }

    public function styles(Worksheet $sheet)
    {
        return [
        // Style the first row as bold text.
        1    => ['font' => ['bold' => true]],
        ];
    }

    public function headings():array{
        return[
            'DATE',
            'BOOKING NUMBER',
            'INVOICE NUMBER',
            'WEIGHT',
            'DEST' ,
            'MODE',
            'ITEM LIST',
            'OFFICE',
            'STATUS'

        ];
    } 


    /**
    * @return \Illuminate\Support\Collection
    */

    public function collection()
    {  
        $rr = ShipsBookings::with('shipment','ship')->whereIn('booking_id', $this->id)->get()->map(function($loads) {
            $itemList = [];
            foreach($loads->shipment->packages as $item) {
                $itemList[] = $item->description;
            }
            $List = implode(', ', $itemList);
            return [
               'date'  => date('Y-m-d', strtotime($loads->ship->created_date)),
               'booking_number' => $loads->shipment->booking_number,
               'invoice_number' => $loads->shipment->booking_number,
               'weight' => $loads->shipment->total_weight + $loads->shipment->msic_weight,
               'dest' => $loads->shipment->receiver->address->state->name,
               'mode' => '',
               'item_list' => $List,
               'office' => $loads->shipment->branch->name,
               'status' => $loads->ship->shipmentStatus->name,
            ];
         }) ;
         return $rr;
 
        
    }
}
