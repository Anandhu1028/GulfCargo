<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Moving;
use Illuminate\Support\Facades\DB;


class MovingController extends Controller
{
    //


    public function getAllMoving(Request $request){
 
        // $offset = $request->offset??0;
        // $limit = $request->limit??10;

        $moving = Moving::where('branch_id', $request->branch_id)
                // ->skip($offset)->take($limit)
                ->orderBy('created_at', 'desc')
                ->get(); 
        return response()->json(['data' => $moving], 200);

    }


    public function getMovingById(Request $request){
 
        $moving = Moving::where('branch_id', $request->branch_id)
                            ->where('id', $request->id)        
                            ->get(); 
                            
        return response()->json(['data' => $moving], 200);

    }

    public function store(Request $request){
        try {
            \DB::beginTransaction();


            $moving  =   Moving::select('id','moving_number')->orderBy('id', 'desc')->first();  
            if(!empty($moving)){
                $bookingNum = $moving->id+10000;  
                $nextBookingNumber = branch()->branch_code ? "MOV".branch()->branch_code.$moving->id+10000 : $moving->id+10000;
            }       
            else{
                // $moving =10000;
                $bookingNum = 10000;  
                $nextBookingNumber = branch()->branch_code ? "MOV".branch()->branch_code.$bookingNum : $bookingNum;
    
            }



                $moving = new Moving();

                $moving->moving_number =  $nextBookingNumber;
                $moving->branch_id = $request->branch_id;
                $moving->sender_id = $request->sender_id;
                $moving->source_city = $request->source_city;
                $moving->destination_city = $request->destination_city;
                $moving->agency_id = $request->agency_id;
                $moving->shiping_method = "shiping_method"; //$request->shiping_method;
                $moving->payment_method = $request->payment_method;
                $moving->status_id = $request->status_id;
                $moving->created_date = $request->created_date;
                $moving->collected_by = $request->collected_by;
                $moving->driver_id = $request->driver_id;
                $moving->delivery_type = $request->delivery_type;
                $moving->total_amount = $request->total_amount;
                $moving->save();

                \DB::commit();
            } catch (\Exception $e) {

                \DB::rollBack();
                return response()->json(['data' => $e->getMessage(), 'status' => 'error'], 500);  
                
            }

            return response()->json(['message' => "success"], 200);


    }

    public function update(Request $request){
 
        try {
            \DB::beginTransaction();
            $moving = Moving::findOrFail($request->id);

 
            $moving->branch_id = $request->branch_id;
            $moving->sender_id = $request->sender_id;
            $moving->source_city = $request->source_city;
            $moving->destination_city = $request->destination_city;
            $moving->agency_id = $request->agency_id;
            $moving->shiping_method = "shiping_method";
            $moving->payment_method = $request->payment_method;
            $moving->status_id = $request->status_id;
            $moving->created_date = $request->created_date;
            $moving->collected_by = $request->collected_by;
            $moving->driver_id = $request->driver_id;
            $moving->delivery_type = $request->delivery_type;
            $moving->total_amount = $request->total_amount; 
            $moving->save();  


            \DB::commit();
        } catch (\Exception $e) {

            \DB::rollBack(); 
            return response()->json(['data' => $e->getMessage(), 'status' => 'error'], 500); 
        }
       
        return response()->json(['message' => "success"], 200); 

    }
}
