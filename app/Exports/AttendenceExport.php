<?php

namespace App\Exports;

use App\Models\Attendence;
use App\Models\Staffs;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection; 
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use \Maatwebsite\Excel\Sheet;


class AttendenceExport implements FromCollection,WithHeadings, WithCustomStartCell, WithEvents 
{
   
    protected $id;

    function __construct($id) {
            $this->id = $id;
    }

    public function startCell(): string
    {
        return 'A4';
    }

    public function registerEvents(): array {
        
       
        return [
            AfterSheet::class => function(AfterSheet $event) {

                $oneMonthAgo = new \DateTime('1 month ago');
                $oneMonthAgo = $oneMonthAgo->format('Y-m-d');
                $currentDate =  date('Y-m-d');
        
                $staff = Staffs::notadmin()->with('branch')->where('id',$this->id)->first();

                // dd($staff);
                /** @var Sheet $sheet */
                $sheet = $event->sheet;

                $sheet->mergeCells('A1:E1');
                $sheet->setCellValue('A1', "Attendence from ". $oneMonthAgo ." to " .$currentDate); 
                $sheet->mergeCells('A2:E2');
                $sheet->setCellValue('A2', "Staff Name : " .$staff->full_name."| Branch Name: " . $staff->branch->name."");

                
                $styleArray = [
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ];
                
                
                $cellRange = 'A1:E1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray($styleArray);
            },
        ];
    }
      


    public function headings():array{

        $oneMonthAgo = new \DateTime('1 month ago');
        $oneMonthAgo = $oneMonthAgo->format('Y-m-d');
        $currentDate =  date('Y-m-d');

      

        // dd( $staff );
        return[
            'Branch',
            'Date',
            'Clock In',
            'Clock Out',
            'Present',
            'Absent' 
        ];
    } 


    /**
    * @return \Illuminate\Support\Collection
    */

    public function collection()
    {  
        $oneMonthAgo = new \DateTime('1 month ago');
        $oneMonthAgo = $oneMonthAgo->format('Y-m-d');
        $currentDate =  date('Y-m-d');
        // $rr = Attendence::where('staff_id',$this->id)->whereBetween('date', [$oneMonthAgo, $currentDate])->get();
        $rr = Attendence::where('staff_id',$this->id)->whereBetween('date', [$oneMonthAgo, $currentDate])->get()->map(function($staff) {
            return [

               'branch'  => $staff->branch->name,
               'date'  => $staff->date,
               'clock_in' => $staff->clock_in ?  date('h:i:a',$staff->clock_in) : '-',
               'clock_out' => $staff->clock_out ?  date('h:i:a',$staff->clock_out) : '-',
               'present' => $staff->present,
               'absent' => $staff->absent,
            ];
         }) ;
         return $rr;
 
        
    }
}
