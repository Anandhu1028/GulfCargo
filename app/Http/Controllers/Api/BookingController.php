<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shipments;
use App\Models\Statuses;
use App\Models\Ships;
use App\Models\ShipsBookings;
use App\Models\ShipTypes;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    
    public function list(Request $request){ 
           
        // $offset = $request->offset??0;
        // $limit = $request->limit??10;
        $shipments = Shipments::with(['driver' => function ($query) {
                $query->select('id', 'user_id', 'name', 'mobile', 'vehicle_number');
                }])->where("branch_id",$request->branch_id)
                // ->skip($offset)->take($limit)
                ->orderBy('created_at', 'desc')
                ->get(); 
 
       
        return response()->json(['data' => $shipments], 200);
    }

    public function store(Request $request){ 
           
        try {
            \DB::beginTransaction();

             // $nextBookingNumber = branch()->branch_code;
            $shipment  =   Shipments::select('id','booking_number')->orderBy('id', 'desc')->first();  
            if(!empty($shipment)){
                $bookingNum = $shipment->id+10000;  
                $nextBookingNumber = branch()->branch_code ? branch()->branch_code.$shipment->id+10000 : $shipment->id+10000;
            }       
            else{
                // $shipment =10000;
                $bookingNum = 10000;  
                $nextBookingNumber = branch()->branch_code ? branch()->branch_code.$bookingNum : $bookingNum;

            }


            $shipments = new Shipments();
            $shipments->booking_number = $nextBookingNumber;
            $shipments->sender_id = $request->sender_id;
            $shipments->receiver_id = $request->receiver_id;  
            $shipments->agency_id = $request->agency_id;            
            $shipments->shiping_method = $request->shiping_method; 
            $shipments->created_date = $request->created_date; 

            $shipments->payment_method = $request->payment_method;
            $shipments->number_of_pcs = $request->number_of_pcs??null;
            $shipments->status_id = $request->status_id;
            $shipments->collected_by = $request->collected_by;    
            $shipments->delivery_type = $request->delivery_type;    
                    

            if($request->driver_id){
                $shipments->driver_id = $request->driver_id;
                $shipments->staff_id = null;

            } else {
                $shipments->staff_id = $request->staff_id;
                $shipments->driver_id = null;
            }
            
            $shipments->lrl_tracking_code = $request->lrl_tracking_code;

            $shipments->created_by = $request->created_by;
            $shipments->shiping_date = date("Y-m-d");
            $shipments->branch_id = $request->branch_id;

 
            $shipments->save();
            $status = Statuses::find($request->status_id);
            $shipments->status()->attach($status);


            
            $ship = Ships::where('branch_id',  branch()->id)->orderBy('created_at', 'desc')->first();
            if($ship){
                $shipsbooking = new ShipsBookings();
                $shipsbooking->ship_id = $ship->id;
                $shipsbooking->booking_id =  $shipments->id;
                $shipsbooking->save();
            
            } 
            
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

            $shipments = Shipments::findOrFail($request->id);

            $shipments->sender_id = $request->sender_id;
            $shipments->receiver_id = $request->receiver_id;  
            $shipments->agency_id = $request->agency_id;            
            $shipments->shiping_method = $request->shiping_method; 
            $shipments->created_date = $request->created_date; 

            $shipments->payment_method = $request->payment_method;
            $shipments->number_of_pcs = $request->number_of_pcs??null;
            $shipments->status_id = $request->status_id;
            $shipments->collected_by = $request->collected_by;    
            $shipments->delivery_type = $request->delivery_type;    
                    

            if($request->driver_id){
                $shipments->driver_id = $request->driver_id;
                $shipments->staff_id = null;

            } else {
                $shipments->staff_id = $request->staff_id;
                $shipments->driver_id = null;
            }
            
            $shipments->lrl_tracking_code = $request->lrl_tracking_code;

            $shipments->created_by = $request->created_by;
            $shipments->shiping_date = date("Y-m-d");
            $shipments->branch_id = $request->branch_id; 
 
            $shipments->save();
            
            
            \DB::commit();
        } catch (\Exception $e) {

            \DB::rollBack();
            return response()->json(['data' => $e->getMessage(), 'status' => 'error'], 500);  
                
        }

        return response()->json(['message' => "success"], 200);
    }
 

}