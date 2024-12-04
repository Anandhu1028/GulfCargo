<?php

namespace App\Http\Controllers\AgencyAdmin;

use App\Http\Controllers\Controller;
use App\Models\States;
use App\Models\Cities;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function states(Request $request)
    {
        $data = States::where('country_id', $request->country_id)->get();
        return response()->json($data);
    }

    public function cities(Request $request)
    {
        $data = Cities::where('state_id', $request->state_id)->get();
        return response()->json($data);
    } 

    public function setBrowserTimeZone(Request $request)
    {
        $browserTimezone = $request->timezone;
        date_default_timezone_set($browserTimezone);
        \Session::put("timezone",$browserTimezone);
        \Session::save();
 
        date_default_timezone_set( session('timezone') ); 
        //  return \Session::get("timezone")."  ".date('h:i:a');
        return "success";
    }
}