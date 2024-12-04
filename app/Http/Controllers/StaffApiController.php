<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staffs;
use App\Models\Districts;
use App\Models\States;
class StaffApiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // public function index(Request $request)
    // {

    //     if ($request->user()) {
    //         $user = $request->user();
    //         if ($user->superadmin == 1) {
    //             return redirect()->route('super-admin.dashboard');
    //         }
    //         else if( $user->superadmin == 2) {
    //             return redirect()->route('agency-admin.dashboard');
    //         }
    //         else
    //         return redirect()->route('branch.dashboard');

    //     }
    //     return redirect()->route('login');

    // }

    public function getStaffApi(Request $request)
    {
        $staff = Staffs::notadmin()->where('branch_id', 24)->get();
        return response()->json(['data' => $staff], 200);


    }



    public function get_state(Request $request){
        $states  = States::where('country_id', 101)->get();
        foreach($states as $state){
            foreach($request->all() as $dist){
                if($state->name == $dist['state']){
                    $district = new Districts();
                    $district->name = $dist['district'];
                    $district->state_id = $state->id;
                    $district->country_id = 101;
                    $district->country_code = 'IN';
                    $district->save();

                  }
            }
        }

        // foreach ($request->all() as $data) {
        //     $stateNames[] = ['state' => $data['state']];
        // }
        return response()->json('success');
    }


}
