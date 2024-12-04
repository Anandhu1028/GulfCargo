<?php

namespace App\Http\Controllers\Branch;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Attendence;
use App\Models\AttendenceTimes;
use App\Models\Staffs;
use Illuminate\Http\Request;

class AttendanceController extends BaseController
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

        $selected_status            =  $request->status ?  $request->status : ''; 
        $selected_status_special    =  $request->special_attendence ? $request->special_attendence : '';
        
        if ($date != null && $date_from != null) { 


            $attendances = Attendence::with('staff')->whereHas('staff', function($q) use ($request) { 
                            $q->where('role','!=','admin');    
                            $q->where('staff_status', '!=', NULL );
                            $q->where('staff_status', 'active' );
                            $q->orderBy('full_name');  
                        })->whereBetween("date", [$date_from, $date])->where("branch_id",branch()->id);

            if( $request->status){
                $attendances = $attendances->where('status',  $request->status );
            }

            if( $request->special_attendence){
                $attendances = $attendances->where('special_attendence',  $request->special_attendence );

            }

            $attendances = $attendances->get();

          /*  if( $request->status){
                
                    $attendances = Attendence::with('staff')->whereHas('staff', function($q) use ($request) { 
                                    $q->where('role','!=','admin');    
                                    $q->where('staff_status', '!=', NULL );
                                    $q->where('staff_status', 'active' );
                                    $q->orderBy('full_name');  
                                })->whereBetween("date", [$date_from, $date])
                                ->where('status',  $request->status )->where("branch_id",branch()->id)->get();   
            } else {
                            $attendances = Attendence::with('staff')->whereHas('staff', function($q) use ($request) { 
                                $q->where('role','!=','admin');
                                $q->where('staff_status', '!=', NULL );    
                                $q->where('staff_status', 'active' );
                                $q->orderBy('full_name');    
                            })->whereBetween("date", [$date_from, $date])->where("branch_id",branch()->id)->get(); 
            }  */           

        } else { 

            $attendances = Attendence::with('staff')->whereHas('staff', function($q) use ($request) { 
                                $q->where('role','!=','admin');    
                                $q->where('staff_status', '!=', NULL );
                                $q->where('staff_status', 'active' );
                                $q->orderBy('full_name');   
                            })->where("date", date('Y-m-d'))->where("branch_id",branch()->id);   
            
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
            
        } 

     
        return view('branches.attendance.index', compact('attendances', 'date', 'date_from', 'attend_time','selected_status', 'selected_status_special'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {    
        // echo date("H:i", strtotime("04:25 PM"));

        $attend_time = AttendenceTimes::first();
        
        $search_user = $request->search_user;
        if($search_user != null) {
          
            $staffs = Staffs::where("role","!=","admin")
                              ->where('staff_status', 'active')
                              ->where('full_name','LIKE','%'.$search_user.'%')
                              ->where('branch_id','=',branch()->id)
                              ->get();
        } else {
            $staffs = Staffs::where("role","!=","admin")
                              ->where('staff_status', 'active')
                              ->where('branch_id','=',branch()->id)
                              ->get();
        }
        return view('branches.attendance.create', compact('staffs','search_user','attend_time'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $staffs = Staffs::notadmin()->get();
        $date = date('Y-m-d');
        foreach ($staffs as $staff) {
            $att = Attendence::where("user_id", $staff->user_id)
                ->where("staff_id", $staff->id)
                ->where("date", $date)
                ->get();

            if (count($att) == 0) {
                $attendance = new Attendence();
                $attendance->user_id = $staff->user_id;
                $attendance->staff_id = $staff->id;
                $attendance->branch_id = $staff->branch_id;
                $attendance->date = $date;
                $attendance->present = $request['attendance' . $staff->id];
                $attendance->late = $request['late' . $staff->id];
                $attendance->save();
            }
        }

        toastr()->success(section_title() . ' Added Successfully');
        return redirect()->to(index_url());
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
        $attendance = Attendence::findOrFail($id);
        return view('branches.attendance.edit', compact('attendance'));
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
        $attendance = Attendence::findOrFail($id);
        $attendance->present = $request['attendance'];
        $attendance->late = $request['late'];
        $attendance->save();
        toastr()->success(section_title() . ' Updated Successfully');
        return redirect()->to(index_url());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function clockInOut(Request $request)
    { 
 
            $time = time();
            $date = date('Y-m-d');
            if ($request->employ_id != null && $request->type != null) {
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
                $attendance->branch_id = branch()->id;
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
                if($request->ajax()){
                    return $msg;
                }
                else {
                    toastr()->success($msg);
                    return redirect()->back();
                }               
            }

            if($request->ajax()){
                return $msg;
            }
            else {
                toastr()->error(' Something went wrong');
                return redirect()->back();
            }           
    }
        
    
}
