<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendence;
use App\Models\AttendenceTimes;
use App\Models\Staffs;

class AttendenceController extends Controller
{

    public function getAttendence(Request $request)
    {

        $attend_time = AttendenceTimes::first();
        $date_from = $request->date_from;
        $date_to = $request->date_to;

        // $offset = $request->offset??0;
        // $limit = $request->limit??10;

        if ($date_to != null && $date_from != null) { 
            
            $attendances = Attendence::with(['staff' => function ($query) {
                $query->select('id', 'staff_id', 'full_name', 'role');
                }])->whereBetween("date", [$date_from, $date_to])
                ->where("branch_id",$request->branch_id)
                // ->skip($offset)->take($limit)
                ->get();

        } else { 

            $attendances = Attendence::with(['staff' => function ($query) {
            $query->select('id', 'staff_id', 'full_name', 'role');
            }])->where("date", date('Y-m-d'))->where("branch_id",$request->branch_id)
            // ->skip($offset)->take($limit)
            ->get();                                     

        }

        return response()->json(['data' => $attendances], 200);
 
    }

    public function getAttendencecount()
    {
       
        $request->date_from = date("Y-m-d");
        $request->date_to   = date("Y-m-d"); 
     
        if( $request->branch_id){           
               $attendances = Attendence::whereBetween("date", [$request->date_from, $request->date_to]) 
                                ->where('branch_id', $branch_id )
                                ->get(); 
        } else {
               $attendances = Attendence::whereBetween("date", [$request->date_from, $request->date_to]) 
                            ->get();
        }

            $attend_time = AttendenceTimes::first();
            $total_present = 0;
            $total_partial = 0;
            $total_absent = 0;   
              
            foreach($attendances as $day => $val ) {
                if( $val->clock_in != '' &&  $val->clock_out !=''){
                    $time_diff = $val->clock_out - $val->clock_in;
                    $difference_in_hour = gmdate("H", $time_diff);
                    if(  $val->clock_in <= strtotime($attend_time->checkin_to) ) {  
                        if($difference_in_hour < 6) {                                        
                            $total_absent = $total_absent+1;                                    

                        } else  if ( $difference_in_hour > 6  && $difference_in_hour < 12){                                    
                            $total_partial = $total_partial+1;
                        } 
                        else {                                    
                            $total_present = $total_present+1;
                        }          
                    } else if(  $val->clock_in > strtotime($attend_time->checkin_to)) {                                    
                        $difference_in_hour = gmdate("H", $difference_in_hour);
                        if($difference_in_hour >= 6) {                                    
                            $total_partial = $total_partial+1;
                        } else {                                        
                            $total_absent = $total_absent+1; 
                        } 
                    }  
                } else {
                        $attendance_status =  "NA";                            
                }                    
            }                
            
            $data = [
                        'total_present' => $total_present,
                        'total_partial' => $total_partial,
                        'total_absent' => $total_absent,
                ];

            return response()->json(['data' =>  $data], 200);
         

    }  


    public function createAttendence(Request $request)
    {
        $time = time();
        $date = date('Y-m-d');
        if ($request->staff_id != null && $request->type != null) {  

            $staff = Staffs::findOrFail($request->staff_id);

            $attendance = Attendence::where("user_id", $staff->user_id)
                ->where("staff_id", $staff->id)
                ->where("date", $date)
                ->first();
            if ($attendance == null) {
                $attendance = new Attendence();

            }
            $attendance->user_id = $staff->user_id;
            $attendance->staff_id = $staff->id;
            $attendance->branch_id = branch()->id;
            $attendance->lattitude= $request->lattitude;
            $attendance->longitude = $request->longitude;
            $attendance->location = $request->location;
            $attendance->date = $date;
            $msg = "Success";
            if ($request->type == "clockin") {
                $attendance->clock_in = $time;
                $msg = "Successfully Clocked In";
            }
            if ($request->type == "clockout") {
                $attendance->clock_out = $time;
                $msg = "Successfully Clocked Out";
            }
            $attendance->save();

            $data = [
                'message' => $msg
            ];

            return response()->json(['data' =>  $data], 200);
                       
        } else {

            $data = [
                'message' => "something went worng"
            ];
        return response()->json(['data' => $data], 500);
        } 
    }

    

}
