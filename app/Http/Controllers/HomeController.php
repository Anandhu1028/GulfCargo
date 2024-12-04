<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staffs;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {

        if ($request->user()) {
            $user = $request->user(); 
            if ($user->superadmin == 1) {
                return redirect()->route('super-admin.dashboard');
            }
            else if( $user->superadmin == 2) {
                return redirect()->route('agency-admin.dashboard');
            }
            else
            return redirect()->route('branch.dashboard');

        }
        return redirect()->route('login');

    } 
  
   
}
