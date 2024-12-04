<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Agencies;
use App\Models\Branches;
use App\Models\Countries;
use App\Models\Customers;
use App\Models\Packages;
use App\Models\Shipments;
use App\Models\Statuses;
use App\Models\Staffs;
use App\Models\Boxes;
use App\Models\Ships;
use App\Models\ShipsBookings;
use App\Models\ShipmentsStatuses;
use App\Models\StatusesBookingNumber;
use App\Models\BoxesStatuses;
use App\Models\ShipTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AddToShipController extends Controller
{
    public function addbookingToShip(Request $request){
        $ships = Ships::with('createdBy')->with('shipmentStatus')->findOrFail($request->ship_id);
        $bookings = Shipments::where('branch_id', $request->branch_id)->where('ship_id',  NULL)->get();

        $ship_bookingsList =  Boxes::with('shipment.shipmentStatus','boxStatuses.status')->whereHas('shipment',function ($query) use ($request)  {
                                        $query->where('branch_id', $request->branch_id);
                                    })->where('is_transfer',0)->where('is_shipment',1)
                                    ->where('ship_id',$request->ship_id)->get();
        // dd($ship_bookingsList[0]);
        // ShipsBookings::with('shipment','shipment.boxes')->with('ship')
        //                         ->where('ship_id', $request->ship_id)
        //                         ->whereHas('shipment.shipmentStatus', function ($q) {
        //                             $q->where('shipments.branch_id',branch()->id);
        //                         })
        //                         ->get();
        $shipId = $request->ship_id;
        $shipments = Shipments::with('driver')->where('branch_id',$request->branch_id)->latest()->orderBy('created_at', 'desc')->get();
        $querys =Boxes::with('shipment.driver','shipment.boxes','packages')->whereHas('shipment',function ($query) use ($request){
                                $query->where('branch_id', $request->branch_id);
                                $query->where('ship_id', NULL);
                            })->where('is_transfer',0)->where('is_shipment',0);

        $boxes = $querys->get();
        $ship_types = ShipTypes::all();
        $agencies = Agencies::all();
        return view('superadmin.addtoship.addbooking', compact('bookings','ships', 'ship_bookingsList','shipId','shipments','boxes', 'ship_types', 'agencies'));
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
        return route('superadmin.ships.addbookingtoship', array('ship_id' => $request->ship_id));

    }

    public function customermanifestprint(Request $request){

        $ships = Ships::with('createdBy')->with('shipmentStatus')->findOrFail($request->ship_id);
        $bookings = Shipments::where('ship_id',  NULL)->get();

        $ship_bookingsList = Boxes::with('shipment.shipmentStatus','boxStatuses.status')
                        ->where('is_transfer', 0)
                        ->where('is_shipment', 1)
                        ->where('ship_id', $request->ship_id)
                        ->get();


        // ShipsBookings::with('shipment','shipment.boxes')->with('ship')
        //                         ->where('ship_id', $request->ship_id)
        //                         ->whereHas('shipment.shipmentStatus', function ($q) {
        //                             $q->where('shipments.branch_id',branch()->id);
        //                         })
        //                         ->get();
        // dd($ship_bookingsList[0]);
        $shipId = $request->ship_id;
        $shipments = Shipments::with('driver')->latest()->orderBy('created_at', 'desc')->get();
        $querys = Boxes::with('shipment.driver','shipment.boxes')
                ->whereHas('shipment', function ($query) {
                    $query->where('ship_id', NULL);
                })
                ->where('is_transfer', 0)
                ->where('is_shipment', 0);


        $boxes = $querys->get();
        return view('superadmin.addtoship.customermanifestprint', compact('bookings','ships', 'ship_bookingsList','shipId','shipments','boxes'));
    }

    public function deliverylistptint(Request $request){

        $ships = Ships::with('createdBy')->with('shipmentStatus')->findOrFail($request->ship_id);
        $bookings = Shipments::where('ship_id',  NULL)->get();
        $ship_bookingsList = Boxes::with('shipment.shipmentStatus', 'boxStatuses.status')
                          ->where('is_transfer', 0)
                          ->where('is_shipment', 1)
                          ->where('ship_id', $request->ship_id)
                          ->get();


        // ShipsBookings::with('shipment','shipment.boxes')->with('ship')
        //                         ->where('ship_id', $request->ship_id)
        //                         ->whereHas('shipment.shipmentStatus', function ($q) {
        //                             $q->where('shipments.branch_id',branch()->id);
        //                         })
        //                         ->get();
        // dd($ship_bookingsList[0]);
        $shipId = $request->ship_id;
        $shipments = Shipments::with('driver')->latest()->orderBy('created_at', 'desc')->get();
        $querys = Boxes::with('shipment.driver', 'shipment.boxes')
               ->whereHas('shipment', function ($query) {
                   $query->where('ship_id', NULL);
               })
               ->where('is_transfer', 0)
               ->where('is_shipment', 0);


        $boxes = $querys->get();
        $idsss = [];
        foreach ($ship_bookingsList as $box) {
            foreach ($bookings as $bookin) {
                if($box->shipment->booking_number == $bookin->booking_number ) {
                    $idsss[] = $bookin->id;
                }
            }
        }
        $delivery_list = [];
        $z = array_values(array_unique($idsss));
        foreach ($z as $zz) {
            $shipment = Shipments::find($zz);
            if ($shipment) {
                $delivery_list[] = $shipment;
            }
        }

        $shipmentsCollection = collect($delivery_list);
        return view('superadmin.addtoship.deliverylistptint', compact('bookings','ships', 'ship_bookingsList','shipId','shipments','boxes', 'delivery_list'));
    }

    public function packinglistptint(Request $request){
        $ships = Ships::with('createdBy')->with('shipmentStatus')->findOrFail($request->ship_id);
        $bookings = Shipments::where('ship_id',  NULL)->get();

        $ship_bookingsList = Boxes::with('shipment.shipmentStatus', 'boxStatuses.status', 'packages')
                            ->where('is_transfer', 0)
                            ->where('is_shipment', 1)
                            ->where('ship_id', $request->ship_id)
                            ->get();


        // ShipsBookings::with('shipment','shipment.boxes')->with('ship')
        //                         ->where('ship_id', $request->ship_id)
        //                         ->whereHas('shipment.shipmentStatus', function ($q) {
        //                             $q->where('shipments.branch_id',branch()->id);
        //                         })
        //                         ->get();
        // dd($ship_bookingsList[0]);

        $shipId = $request->ship_id;
        $shipments = Shipments::with('driver')->latest()->orderBy('created_at', 'desc')->get();
        $querys = Boxes::with('shipment.driver', 'shipment.boxes')
               ->whereHas('shipment', function ($query) {
                   $query->where('ship_id', NULL);
               })
               ->where('is_transfer', 0)
               ->where('is_shipment', 0);

        $boxes = $querys->get();
        return view('superadmin.addtoship.packinglistptint', compact('bookings','ships', 'ship_bookingsList','shipId','shipments','boxes'));
    }

    public function updatebookingtoship(Request $request) {
        $ships = Ships::findOrFail($request->ship_id);
        $ships->tracking_url = $request->tracking_url;
        $ships->shipment_status = $request->status_id;
        $ships->created_date = $request->created_date;
        $ships->save();
        toastr()->success(section_title() . ' Updated Successfully');

        return  redirect()->route('branch.ships.addbookingtoship', array('ship_id' => $request->ship_id));

    }

    public function multiUpdatebookingtoship(Request $request) {

        $shipsIds = explode(",",$request->shipIds);
        $shipmentIds = explode(",",$request->shipmentIds);
        $boxesvals = explode(",",trim($request->selectedBoxId,","));
        foreach($boxesvals as $boxes) {
            $bookings = new BoxesStatuses();
            $bookings->status_id = $request->status_id;
            $bookings->box_id = $boxes;
            $bookings->comment = $request->comment;
            $bookings->created_at = (!empty($request->created_date)) ? $request->created_date : date('Y-m-d');
            $bookings->save();
        }
        // foreach(array_unique($shipmentIds) as $shipmentId) {
        //     $checkTranssfered = StatusesBookingNumber::where('status_id',17)->where('booking_id',$shipmentId)->first();
        //     if(empty($checkTranssfered)) {
        //         $ships = new StatusesBookingNumber();
        //         $ships->status_id = $request->status_id;
        //         $ships->booking_id = $shipmentId;
        //         $ships->created_at = $request->created_date;
        //         $ships->save();

        //         $shipments = Shipments::findOrFail($shipmentId);
        //         $shipments->status_id = $request->status_id;
        //         $shipments->created_date = $request->created_date;
        //         $shipments->save();
        //     } else {
        //         return response()->json(['success'=>'Already Transferred Item.']);
        //     }
        // }

        // toastr()->success(section_title() . ' Updated Successfully');

        // return response()->json(['success'=>'Status Updated Successfully']);

    }

    public function boxStatusUpdatetoship(Request $request) {
        foreach($request->boxIds as $key => $boxId) {
            if($request->status[$key] != '0') {
                $bookings = new BoxesStatuses();
                $bookings->status_id = $request->status[$key];
                $bookings->box_id = $boxId;
                $bookings->created_at = (!empty($request->statusDate[$key])) ? $request->statusDate[$key] : date('Y-m-d');
                $bookings->save();
            }
        }
        toastr()->success('Status Updated Successfully');

        return redirect()->route('superadmin.ships.addbookingtoship', array('ship_id' => $request->ship_id));
    }

    public function undoaddbooking($id) {
        $boxes  = Boxes::findOrFail($id);
        $boxes->is_shipment = 0;
        $boxes->ship_id = null;
        $boxes->is_select = 0;
        $boxes->save();

        $boxStatuses = BoxesStatuses::where('box_id',$id)->delete();
        toastr()->success(section_title() . ' Deleted Successfully');
        return  redirect()->back();

    }

    public function addMoreBookingtoship(Request $request) {
        $ships = Ships::with('createdBy')->with('shipmentStatus')->findOrFail($request->ship_id);
        $bookings = Shipments::where('branch_id', branch()->id)->where('ship_id',  NULL)->get();
        $ship_bookingsList =  Boxes::with('shipment.shipmentStatus','boxStatuses.status')->whereHas('shipment',function ($query) {
                                            $query->where('branch_id', branch()->id);
                                        })->where('is_transfer',0)->where('ship_id',$request->ship_id)->where('is_shipment',1)->get();
        $statuses = status_list_admin(); //Statuses::get();
        return view('superadmin.addtoship.addMoreBooking', compact('bookings','ships', 'ship_bookingsList','statuses'));
    }

    public function addMoreBookingtoshipSubmit(Request $request) {
        $shipsbooking = new ShipsBookings();
        $shipsbooking->ship_id = $request->ship_id;
        $shipsbooking->booking_id =  $request->booking_id;
        $shipsbooking->save();
        Shipments::where('id', $request->booking_id)->update(['ship_id' => $request->ship_id, 'status_id'=> $request->ship_status]);
        toastr()->success('Booking Added Successfully to the Shipment.');
        return  redirect()->route('branch.ships.addMoreBookingtoship', array('ship_id' => $request->ship_id));
    }

    public function addMultipleBookingtoshipSubmit(Request $request) {
        $boxIds = explode(",",$request->box_id);
        $getShip = Ships::find($request->ship_id);
        foreach($boxIds as $boxId) {
            $boxes = Boxes::find($boxId);
            $boxes->is_shipment = 1;
            $boxes->ship_id = $request->ship_id;
            $boxes->save();

            $bookings = new BoxesStatuses();
            $bookings->status_id = $getShip->shipment_status;
            $bookings->box_id = $boxId;
            $bookings->created_at = date('Y-m-d');
            $bookings->save();
        }
        toastr()->success('Booking Added Successfully to the Shipment.');
        return  redirect()->route('superadmin.ships.addbookingtoship', array('ship_id' => $request->ship_id));
    }

    public function multiSelectionUpdate(Request $request) {
        $selectedBoxes = $request->selectedBoxes;
        Log::info($selectedBoxes);
        $boxIds = explode(",",$selectedBoxes);
        $hidSelectLists = explode(",",$request->hidSelectList);
        Boxes::where('is_shipment',0)->whereIn('id',$hidSelectLists)->update(['is_select'=>0]);
        $boxes = Boxes::whereIn('id',$boxIds)->where('is_shipment',0)->update(['is_select'=>1]);

        $querys =Boxes::with('shipment.driver','shipment.boxes')->whereHas('shipment',function ($query) {
            $query->where('branch_id', branch()->id);
            $query->where('ship_id', NULL);
        })->where('is_transfer',0)->where('is_shipment',0)->where("is_select",1);
        $boxes = $querys->get();
        $box_id = [];
        foreach($boxes as $key => $box) {
            $box_id["boxes"][$key] = $box->id;
        }
        return $box = $box_id;
    }

    public function manifestoFilterData($ship_id,$type,$status) {
        $query =  Boxes::with('shipment.shipmentStatus','boxStatuses.status')->whereHas('shipment',function ($query) {
            $query->where('branch_id', branch()->id);
        })->where('is_transfer',0)->where('ship_id',$ship_id)->where('is_shipment',1);
        if($type == "status") {
            $ships = $query->whereHas('boxStatuses', function ($q) use ($status) {
                $q->where('boxes_statuses.status_id',$status);
            })->orderBy('id','desc')->get();
        } else if($type == 'boxNumber') {
            $ships = $query->where('box_name','LIKE',"%".$status."%")->orderBy('id','desc')->get();
        } else {
            $ships = $query->whereHas('shipment', function ($q) use ($status) {
                $q->where('shipments.booking_number','LIKE',$status);
            })->orderBy('id','desc')->get();
        }
            foreach($ships as $key => $ship) {
                if(!empty($ship->boxStatuses)) {
                    $lastStatus = collect($ship->boxStatuses)->last();
                    $ships[$key]["last_status"] =  $lastStatus->status->name;
                } else {
                    $ships[$key]["last_status"] = "";
                }
                $ships[$key]["dated_on"] =  date('d-m-Y',strtotime($ship->created_at));
                if($lastStatus->status->name == 'Pending') {
                    $style= "background-color:#ec1616e6;";
                } else if ($lastStatus->status->name == 'Shipment on hold') {
                    $style= "background-color:#ffdb00;";
                } else {
                    $style= "background-color:none;";
                }
                $ships[$key]["style"] = $style;
            }
        return $ships;
    }

    public function viewManifestoFilterData($ship_id,$type,$status) {
        $query =  Boxes::with('shipment.driver','shipment.boxes','shipment.shipmentStatus','shipment.sender.address','shipment.receiver.address','shipment.receiver.address.state','shipment.receiver.address.country','shipment.boxes','boxStatuses.status','shipment.agency','shipment.branch')->whereHas('shipment',function ($query) {
            $query->where('branch_id', branch()->id);
        })->where('is_transfer',0)->where('ship_id',$ship_id)->where('is_shipment',1);
        if($type == "status") {
            $ships = $query->whereHas('boxStatuses', function ($q) use ($status) {
                $q->where('boxes_statuses.status_id',$status);
            })->orderBy('id','desc')->get();
        } else if($type == 'boxNumber') {
            $ships = $query->where('box_name','LIKE',$status)->orderBy('id','desc')->get();
        } else {
            $ships = $query->whereHas('shipment', function ($q) use ($status) {
                $q->where('shipments.booking_number',$status);
            })->orderBy('id','desc')->get();
        }
        if(!empty($ships)) {
            foreach($ships as $key => $ship) {
                if(!empty($ship->boxStatuses)) {
                    $lastStatus = collect($ship->boxStatuses)->last();
                    $ships[$key]["statusId"] =  $lastStatus->status->id;
                    $ships[$key]["last_status"] =  $lastStatus->status->name;
                } else {
                    $ships[$key]["last_status"] = "";
                }
                $ships[$key]["dated_on"] =  date('d-m-Y',strtotime($ship->created_at));
                if($lastStatus->status->name == 'Pending') {
                    $style= "background-color:#ec1616e6;";
                    $disabled = "disabled='disabled'";
                    $newClass ="k-state-disabled";
                } else if ($lastStatus->status->name == 'Shipment on hold') {
                    $style= "background-color:#ffdb00;";
                    $disabled = "disabled='disabled'";
                    $newClass ="k-state-disabled";
                } else {
                    $style= "background-color:none;";
                    $disabled = "";
                    $newClass = "k-checkbox";
                }
                $ships[$key]["style"] = $style;
                $ships[$key]["disabled"] = $disabled;
                $ships[$key]["newClass"] = $newClass;

                $itemList = [];
                foreach($ship->packages as $item) {
                    $itemList[] = $item->description."-".$item->quantity;
                }
                $ships[$key]["itemsList"] = implode(', ', $itemList);

                $addressString = $ship->shipment->receiver->address->address;
                $pieces = explode(',', $addressString);
                $ships[$key]["district"] = array_pop($pieces);

            }
        }
        return $ships;

    }




}
