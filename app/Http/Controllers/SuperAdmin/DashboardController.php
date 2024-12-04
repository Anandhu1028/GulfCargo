<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\SuperAdmin\AttendenceController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendence;
use App\Models\Branches;
use App\Models\Customers;
use App\Models\User;
use App\Models\Moving;
use Carbon\Carbon;
use App\Models\StockTransfers;
use App\Models\Staffs;
use App\Models\Shipments;

class DashboardController extends BaseController
{


    public function index(){
        $staffs = Staffs::notadmin()->whereHas("branch")->get();
        $present = User::whereHas('attendence', function($q) { 
            $q->where('date', Carbon::now());    
        })->get();
        $absent = User::whereHas('attendence', function($q) { 
            $q->where('date', Carbon::now());    
        })->get();
        $senders = Customers::where('type','sender')->get();
        $receivers = Customers::where('type','receiver')->get();
        $branches = Branches::get();
        $shipments = Shipments::with('driver');
        $enqCollected = $shipments->where('status_id','15')->get();
        $pendings = $shipments->where('status_id','13')->get();
        $outDelivery = $shipments->where('status_id','10')->get();
        $clearance = $shipments->where('status_id','10')->get();

        $movingEnq  =   Moving::where('status_id','1')->get();
        $movingPending  =   Moving::where('status_id','4')->get(); 
        

        $result = (new AttendenceController())->getAttendencecount(); 

        $total_present = $result['total_present'];
        $total_partial = $result['total_partial']; 
        $total_absent = $result['total_absent']; 

        return view('superadmin.dashboard.index',compact('total_present','total_partial', 'total_absent', 'staffs','present','absent','senders','receivers','branches','enqCollected','pendings','outDelivery','clearance','movingEnq','movingPending'));
    }
}
