<?php

namespace App\Http\Controllers\Branch;

use App\Http\Controllers\Controller;
use App\Models\States;
use App\Models\Districts;
use App\Models\Cities;
use App\Models\User;
use App\Models\Countries;
use App\Models\Customers;
use App\Models\BoxDimensions;
use Illuminate\Http\Request;
use App\Models\ShipTypes;
use Illuminate\Support\Facades\Log;


class DataController extends Controller
{
    public function states(Request $request)
    {
        $country = Countries::find($request->country_id);
        $data['states'] = States::where('country_id', $request->country_id)->get();
        $data['phonecode'] = $country->phonecode;
        $data['phone_no_length'] = $country->phone_no_length;
        return response()->json($data);
    }

    public function cities(Request $request)
    {
        $data = Cities::where('state_id', $request->state_id)->get();
        return response()->json($data);
    }
    public function districts(Request $request)
    {
        $data = Districts::where('state_id', $request->state_id)->get();
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

    public function getUnitValue(Request $request)
    {
        $datas = BoxDimensions::where('id', $request->id)->first();

        $value = ($datas['length'] *$datas['width']*$datas['height'])/$request->volume;
        $data['boxno'] = $request->boxNo;
        $data['volume'] = $request->volume;
        $data['packing'] = $request->packing;
        $data['value'] = $value;

        if($request->packing == 1){
            $data['rate'] = $datas['value'];
        } else {
            $data['rate'] = $datas['cargo_packing'];
        }
        return response()->json($data);
    }

    public function getRate(Request $request)
    {

        $collected_by = $request->collected_by;
        $shiping_method = $request->shiping_method;

        $datas = ShipTypes::where('id', $shiping_method)->first();

        if($collected_by == "driver"){
            $data['rate'] = $datas['driver_rate'];
        } else {
            $data['rate'] = $datas['office_rate'];
        }

        return response()->json($data);
    }

    public function getBoxCount(Request $request, $id, $method){
        $table = $request->query('table');
        if($method == "get"){
            $data = $table::all();
            return response()->json(['query' => $data]);
        }
        elseif($method == "list"){
            $data = $table::find($id);
            return response()->json(['query' => $data]);
        }
        elseif($method == "delete"){
            $data = $table::find($id)->delete();
            return response()->json(['query' => $data]);
        }
        $data = $table::all();
        return response()->json(['query' => $data, 'id'=> $id]);
    }

    public function getBoxPackingCharge(Request $request)
    {

        $packing_id = $request->packing_id;
        $dimension_id = $request->dimension_id;


        $datas = BoxDimensions::where('id', $request->dimension_id)->first();
        if( $packing_id  == 1 ) {  //customer packing

            $data['packing_rate'] = $datas['value'];

        }else if($packing_id  == 2 ) { //cargo packing

            $data['packing_rate'] = $datas['cargo_packing'];
        } else {
            $data['packing_rate'] = 0;

        }

        return response()->json($data);
    }

    public function getCountry(Request $request)
    {
        $country = Countries::where('phonecode',$request->country_code)->first();
        $data['phone_no_length'] = $country->phone_no_length;
        return response()->json($data);
    }


    public function checkNumberExists(Request $request)
    {
        $existPhone = Customers::where('whatsapp_number',$request->number)->where('country_code_whatsapp', $request->code)->first();
        if( $existPhone){
            $data['data'] = $existPhone;
            $data['status'] = "exist";
        }else {
            $data['status'] = "notexist";
        }

        return response()->json($data);
    }



    public function checkPhoneNumberExists(Request $request)
    {
        $existPhone = Customers::where('phone',$request->number)->where('country_code_phone', $request->code)->first();
        if( $existPhone){
            $data['data'] = $existPhone;
            $data['status'] = "exist";
        }else {
            $data['status'] = "notexist";
        }

        return response()->json($data);
    }




}
