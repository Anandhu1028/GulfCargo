<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Branches;
use App\Models\Attendence;
use App\Models\AttendenceTimes;
use App\Models\Staffs;
use App\Models\User;
use App\Models\SalaryDetails; 
use Illuminate\Http\Request;  
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class AttendenceController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
     
        $attend_time = AttendenceTimes::first();
        $date = $request->date;
        $date_from = $request->date_from;
        $staff_id = $request->staff_id;
        $branch_id = $request->branch_id; 

        $selected_status        =  $request->status ?  $request->status : ''; 
        $selected_status_special =  $request->special_attendence ? $request->special_attendence : '';
        
        if ($date != null && $date_from != null) { 

            $attendances = Attendence::with('staff')->whereHas('staff', function($q) use ($request) { 
                            $q->where('role','!=','admin');    
                            // $q->where('staff_status',  $request->status ); 
                            $q->where('staff_status', '!=', NULL );    
                            $q->where('staff_status', 'active' );
                            $q->orderBy('full_name');
                        })->whereBetween("date", [$date_from, $date]);   


           if( $request->status){
                $attendances = $attendances->where('status',  $request->status );
           }

           if( $request->special_attendence){
                $attendances = $attendances->where('status',  $request->status );
           }

           $attendances = $attendances->get();

           /* i if( $request->status){  
                    $attendances = Attendence::with('staff')->whereHas('staff', function($q) use ($request) { 
                                    $q->where('role','!=','admin');    
                                    // $q->where('staff_status',  $request->status ); 
                                    $q->where('staff_status', '!=', NULL );    
                                    $q->where('staff_status', 'active' );
                                    $q->orderBy('full_name');
                                })->where('status',  $request->status )->whereBetween("date", [$date_from, $date])->get();   
                               
            } else {
                            $attendances = Attendence::with('staff')->whereHas('staff', function($q) use ($request) { 
                                $q->where('role','!=','admin');   
                                $q->where('staff_status', '!=', NULL );    
                                $q->where('staff_status', 'active' );
                                $q->orderBy('full_name');
                            })->whereBetween("date", [$date_from, $date])->get(); 
                         
            }     
            */        

        } else { 
           
            $attendances = Attendence::with('staff')->whereHas('staff', function($q) use ($request) { 
                            $q->where('role','!=','admin');    
                            $q->where('staff_status', '!=', NULL );
                            $q->where('staff_status', 'active' );
                            $q->orderBy('full_name');
                        })->where("date", date('Y-m-d'));  

            if( $request->status){
                if( $request->status == 'today_present') {
                    $attendances = $attendances->where('status', 'Present')->orWhere('status',  'Checked In' );
                } else if( $request->status == 'today_absent' ) {
                    $attendances = $attendances->where('status', 'Absent');
                } else {
                    $attendances = $attendances->where('status',  $request->status );
                }
            }
 

            $attendances = $attendances->get();
                
                /*    if( $request->status){
                    $attendances = Attendence::with('staff')->whereHas('staff', function($q) use ($request) { 
                                    $q->where('role','!=','admin');    
                                    $q->where('staff_status', '!=', NULL );
                                    $q->where('staff_status', 'active' );
                                    $q->orderBy('full_name');
                                })->where('status',  $request->status )->where("date", date('Y-m-d'))->get();   
                } else {
                                $attendances = Attendence::with('staff')->whereHas('staff', function($q) use ($request) { 
                                    $q->where('role','!=','admin');    
                                    $q->where('staff_status', '!=', NULL );
                                    $q->where('staff_status', 'active' );
                                    $q->orderBy('full_name');
                                })->where("date", date('Y-m-d'))->get(); 
                }    */

                
        }
               
        return view('superadmin.attendance.index', compact('attendances', 'attend_time','date', 'date_from', 'selected_status', 'selected_status_special')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
 


    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }    

    public function markAttendence(Request $request)
    {
 
         // echo date("H:i", strtotime("04:25 PM"));

        $attend_time = AttendenceTimes::first();
        $current_date = date('Y-m-d');
         $search_user = $request->search_user;
         if($search_user != null) {
           
             $staffs = Staffs::where("role","!=","admin")
                               ->where('staff_status', 'active')
                               ->where('full_name','LIKE','%'.$search_user.'%')
                               ->orderBy('full_name')
                               ->get();

         } else {
             $staffs = Staffs::where("role","!=","admin")
                               ->where('staff_status', 'active')
                               ->orderBy('full_name')
                               ->get();
 
         }
         return view('superadmin.attendance.create', compact('staffs','search_user','attend_time'));


    }

    public function markPresent(Request $request)
    {

        $attend_time = AttendenceTimes::first();

        $clock_in = strtotime($attend_time->checkin_from );
        $clock_out = strtotime($attend_time->checkout_from );
        $date = date('Y-m-d');
 
        if ($request->employ_id != null) {
            $staff = Staffs::findOrFail($request->employ_id);

                $attendance = Attendence::where("user_id", $staff->user_id)
                ->where("staff_id", $staff->id)
                ->where("date", $date)
                ->first();
            if ($attendance == null) {
                $attendance = new Attendence();
            }
            $attendance->user_id = $staff->user_id;
            $attendance->staff_id = $staff->id;
            $attendance->branch_id = $staff->branch_id;
            $attendance->date = $date;
            $attendance->clock_in = $clock_in;
            $attendance->clock_out = $clock_out; 
            $attendance->present = 1;
            $attendance->status = 'Present';
            $attendance->special_attendence = 1;

            $attendance->save();
        }
        toastr()->success(section_title() . ' Successfully Marked as Present');
        return  redirect()->route('super-admin.attendence.markAttendence');

    }


    public function markAbsent(Request $request)
    {

        // $attend_time = AttendenceTimes::first();

        // $clock_in = strtotime($attend_time->checkin_from );
        // $clock_out = strtotime($attend_time->checkout_from );
        $date = date('Y-m-d');
 
        if ($request->employ_id != null) {
            $staff = Staffs::findOrFail($request->employ_id);

                $attendance = Attendence::where("user_id", $staff->user_id)
                ->where("staff_id", $staff->id)
                ->where("date", $date)
                ->first();
            if ($attendance == null) {
                $attendance = new Attendence();
            }
            $attendance->user_id = $staff->user_id;
            $attendance->staff_id = $staff->id;
            $attendance->branch_id = $staff->branch_id;
            $attendance->date = $date;
            $attendance->clock_in = NULL;
            $attendance->clock_out = NULL; 
            $attendance->present = 0;
            $attendance->status = 'Absent';
            $attendance->special_attendence = 1;                      
          
            $attendance->save();
        }
        toastr()->success(section_title() . ' Successfully Marked as Absent');
        return  redirect()->route('super-admin.attendence.markAttendence');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function attendenceReport(Request $request)
    {

        $current_year  = date("Y");;
        $current_month =  date("m");; 
        $days = cal_days_in_month(CAL_GREGORIAN, $current_month, $current_year);  

        $attend_time = AttendenceTimes::first(); 
       
        $all_branches = Branches::all();
        $selected_branch_id =  $request->branch_id ?  $request->branch_id : '';
        $selected_status =  $request->status ?  $request->status : '';
       

        if($request->date_from){ //selected month
            $data = explode("-", $request->date_from);
            $sel_year = $data[0];
            $sel_month = $data[1];
            $sel_month_days = cal_days_in_month(CAL_GREGORIAN, $sel_month, $sel_year); 

            $date_from = $request->date_from."-01";
            $date_to = $request->date_from."-".$sel_month_days;

            $month_name = date("F", mktime(0, 0, 0, $sel_month, 10));
            $days =$sel_month_days;
        }
        else { //current month

            $date_from = $current_year."-".$current_month."-01";
            $date_to = $current_year."-".$current_month."-".$days ;
            $month_name = date("F", mktime(0, 0, 0, $current_month, 10));
        }

 
        $request->date_from = date("Y-m-d", strtotime($date_from));
        $request->date_to   = date("Y-m-d", strtotime( $date_to )); 

        if( $request->branch_id){ 

            if( $request->status){
                $empatts = Staffs::where('branch_id', $request->branch_id )->where('staff_status', $request->status )->with(['attendence' => function($q) use ($request) { 
                    $q->whereBetween('date', [$request->date_from, $request->date_to]);   
                    $q->where('branch_id', $request->branch_id ); 
                }])->where('role','!=', 'admin')->where('staff_status', '!=', NULL )->orderBy('full_name')->get();

            } else {
                $empatts = Staffs::where('branch_id', $request->branch_id )->where('staff_status', 'active' )->with(['attendence' => function($q) use ($request) { 
                    $q->whereBetween('date', [$request->date_from, $request->date_to]);   
                    $q->where('branch_id', $request->branch_id ); 
                }])->where('role','!=', 'admin')->where('staff_status', '!=', NULL )->orderBy('full_name')->get();
            }
            

        } else {
 
            if( $request->status){
                $empatts = Staffs::where('staff_status', $request->status )->with(['attendence' => function($q) use ($request) { 
                    $q->whereBetween('date', [$request->date_from, $request->date_to]);    
                }])->where('role','!=', 'admin')->where('staff_status', '!=', NULL )->orderBy('full_name')->get();
            }else {

           

                $empatts = Staffs::with(['attendence' => function($q) use ($request) { 
                     $q->whereBetween('date', [$request->date_from, $request->date_to]);    
                }])->where('role','!=', 'admin')->where('staff_status', '!=', NULL )->where('staff_status', 'active' )->orderBy('full_name')->get();
 
            }
    

        }
       
        if($request->branch_id ){
            $sel_branch = Branches::select('name')->findOrFail($request->branch_id);
            $selected_branch_name = "Branch Name :".$sel_branch->name;
            $title_for_pdf = "Attendence Report for the month:- ".$month_name;
        } else  {
            $selected_branch_name = 'All Branches';
            $title_for_pdf = "Attendence Report for the month:- ".$month_name;
        }

         

        return view('superadmin.attendance.report', compact('selected_branch_id', 'all_branches', 'attend_time',  'date_from', 'days', 'empatts','month_name', 'selected_branch_name', 'selected_status', 'title_for_pdf')); 
    }  


    public function getAttendencecount()
    {
       
        $date_from = date("Y-m-d");
        $date_to   = date("Y-m-d"); 
     
        
               $attendances = Attendence::whereBetween("date", [$date_from, $date_to]) 
                            ->get();
       
        $attend_time = AttendenceTimes::first();

        $total_present = 0;
        $total_partial = 0; 
        $total_absent  = 0;   
              
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

               return $data;
         

    }  

    public function attendenceReportSalary($staffId, $partial, $present, $absent, $dated) {
        $staff = Staffs::where('user_id',$staffId)->first();
        $dailyWage = (!empty($staff->daily_wage)) ? $staff->daily_wage : 0 ;
        $dated = $dated;
        $totalAbsent = $absent;
        $totalPresent = $present;
        $partialPresent = $partial;
        $totalWorking = $totalPresent + $partialPresent;
        $salary = $totalWorking * $dailyWage;
        $date = Carbon::createFromFormat('Y-m-d', $dated);
   
        $monthName = $date->format('F');
        $yearName = $date->format('Y');

        $checkExist = SalaryDetails::with('user')->where('user_id',$staffId)->where('month',$dated)->first();
        if(isset($checkExist)) {
            
            $checkExist->month = $dated;
            $checkExist->present = $totalPresent;
            $checkExist->partial_present = $partialPresent;
            $checkExist->total_absent = $totalAbsent;
            $checkExist->daily_wage = $dailyWage;
            $checkExist->salary = $salary;
            $checkExist->user_id = $staffId;
            $checkExist->save();
            $checkExist->month = $monthName.", ".$yearName;
            $getData = $checkExist;

        } else {
            $salaryData = new SalaryDetails();
            $salaryData->month = $dated;
            $salaryData->present = $totalPresent;
            $salaryData->partial_present = $partialPresent;
            $salaryData->total_absent = $totalAbsent;
            $salaryData->daily_wage = $dailyWage;
            $salaryData->salary = $salary;
            $salaryData->user_id = $staffId;
            $salaryData->save();
            $getData = SalaryDetails::with('user')->where('user_id',$staffId)->where('month',$dated)->first();
            $getData->month = $monthName.", ".$yearName;
            
        }
        $getData->title_for_pdf = "Salary Slip for the month of ".$monthName.", ".$yearName;
        return view('superadmin.attendance.salarySlip', compact('getData')); 
    }



   


}
