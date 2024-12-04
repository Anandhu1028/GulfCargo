<?php

namespace App\Http\Controllers\AgencyAdmin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Agencies;
use App\Models\Branches;
use App\Models\Countries;
use App\Models\Customers;
use App\Models\Packages;
use App\Models\Shipments;
use App\Models\Statuses;
use App\Models\Staffs;
use App\Models\Ships;
use App\Models\ShipsBookings; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AddToShipController extends BaseController
{
     
    public function addbookingToShip(Request $request) {
        
        $ships = Ships::with('createdBy')->with('shipmentStatus')->findOrFail($request->ship_id); 
        $bookings = Shipments::where('ship_id', '')->orWhere('ship_id', NULL)->get();

        $ship_bookingsList =  ShipsBookings::with('shipment')->with('ship')->where('ship_id', $request->ship_id)->get();


        return view('agencyadmin.addtoship.addbooking', compact('bookings','ships', 'ship_bookingsList'));
    }

    public function createbookingtoship(Request $request) {

        $ships = Ships::findOrFail($request->ship_id);
        $ships->shipment_id = $request->shipment_id;
        $ships->shipment_status = $request->status_id;
        $ships->awd_id = $request->awd_id;
        $ships->shipment_status = $request->status_id;
        $ships->estimated_delivery = $request->estimated_delivery;
        $ships->created_date = $request->created_date;
        
        $ships->save();

        $booking_ids = $request->booking_ids;
        if(!empty($booking_ids)) {
            foreach( $booking_ids as $booking_id) {
                $shipsbooking = new ShipsBookings();
                $shipsbooking->ship_id = $request->ship_id;
                $shipsbooking->booking_id =  $booking_id;
                $shipsbooking->save();
                Shipments::where('id', $booking_id)->update(['ship_id' => $request->ship_id, 'status_id'=> $request->status_id]);           
            }
        }        
        toastr()->success(section_title() . ' Updated Successfully');
        return  redirect()->route('agencyadmin.ships.addbookingtoship', array('ship_id' => $request->ship_id));

    }

    public function updatebookingtoship(Request $request) {

    // dd("sasas");
        $ships = Ships::findOrFail($request->ship_id);
        $ships->tracking_url = $request->tracking_url;
        $ships->shipment_status = $request->status_id; 
        $ships->created_date = $request->created_date; 
        $ships->save();
        toastr()->success(section_title() . ' Updated Successfully');
 
        return  redirect()->route('agencyadmin.ships.addbookingtoship', array('ship_id' => $request->ship_id));
        
    }
    public function undoaddbooking($id) {

        $shipsbooking = ShipsBookings::findOrFail($id);
        $ship_id = $shipsbooking->ship_id;
        Shipments::where('id', $shipsbooking->booking_id)->update(['ship_id' => null]);  
        ShipsBookings::where('id', $id)->delete();
        toastr()->success(section_title() . ' Deleted Successfully');
        return  redirect()->route('agencyadmin.ships.addbookingtoship', array('ship_id' => $ship_id));

    }

    
}
