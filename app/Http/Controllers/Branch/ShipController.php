<?php

namespace App\Http\Controllers\Branch;

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
use App\Models\Boxes;
use App\Models\Vehicles;
use App\Models\Drivers;
use App\Models\ShipsBookings;
use App\Models\ShipTypes;
use App\Models\ShipmentTypes;
use App\Models\Tripsheets;
use App\Models\ClearingAgents;
use App\Models\PortOfOrigins;
use App\Models\ShipmentsStatuses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use DataTables;
use DB;

class ShipController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $ships =  Ships::with('createdBy','shipmentStatus','shipmentMethodTypes','portOfOrigins','portOfDestinations','clearingAgents')->where('branch_id', branch()->id)->orderBy('id', 'desc')->get();
        $staffs = Staffs::notadmin()->get();
        $shipmentTypes = ShipTypes::all();
        $statuses = status_list_admin(); //Statuses::get();
        $ports = PortOfOrigins::where('status',1)->get();
        $agents = Agencies::all();
        return view('branches.ships.create', compact('staffs', 'ships', 'shipmentTypes', 'ports', 'agents','statuses'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //  return $request;
        // if (Ships::where('shipment_id', '=', $request->shipment_id)->first() != null) {
        //     toastr()->error('shipment id already exists');
        //     return redirect()->back();
        // }

        // if (Ships::where('shipment_name', '=', $request->shipment_name)->first() != null) {
        //     toastr()->error('shipment name already exists');
        //     return redirect()->back();
        // }

        // $messages = [
        //     'shipment_id.required' => 'shipment number is required',
        //     'shipment_name.required' => 'shipment name is required',
        //     'shipment_type.required' => 'shipment type is required',
        //     'port_of_origin.required' => 'port of origin required',
        //     'port_of_origin.required' => 'port of origin required',
        // ];

        // $request->validate([
        //     'shipment_id' => 'required|unique:ships',
        //     'shipment_name' => 'required',
        //     'shipment_type' => 'required',
        //     'port_of_origin' => 'required',
        // ]);


        try {
            \DB::beginTransaction();
            $ships = new Ships();
            $ships->shipment_id = $request->shipment_id;
            $ships->shipment_name = $request->shipment_id;
            $ships->shipment_type_id = $request->shipment_type;
            $ships->port_of_origin_id = $request->port_of_origin;
            $ships->port_of_destination_id = $request->port_of_destination;
            $ships->clearing_agent_id = $request->clearing_agent;
            $ships->awd_id = $request->awd_number;
            $ships->awb_number = $request->awd_number;
            $ships->created_date = $request->created_date;
            // $ships->created_time = $request->created_time;
            $ships->license_details = $request->license_details;
            $ships->shipment_details = $request->shipment_details;
            $ships->created_by = $request->created_by;
            $ships->branch_id = branch()->id;
            $ships->shipment_status = $request->status;
            $ships->exchange_rate = $request->exchange_rate;
            $ships->save();
            $ship_id = $ships->id;

            \DB::commit();
        } catch (\Exception $e) {

            \DB::rollBack();
            Log::error($e->getMessage());
            toastr()->error($e->getMessage());
            return redirect()->back();
        }

        $ship_id = Ships::where('id',$ship_id )->first();
        toastr()->success(section_title() . 'Added Successfully');

        return  redirect()->route('branch.ship.create');
        }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bookings = Shipments::where('ship_id', '')->get();

        return view('branches.ships.create', compact('bookings'));

        // $shipment = Shipments::with('driver')->findOrFail($id);
        // return view('branches.shipments.show', compact('shipment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $shipment = Shipments::with('driver')->findOrFail($id);
        $agencies = Agencies::all();
        $origin_offices = Branches::all();
        $countries = Countries::all();
        $drivers = Drivers::whereActive(true)->get();
        return view('branches.shipments.edit', compact('shipment', 'agencies', 'origin_offices', 'countries','drivers'));

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
        try {
            \DB::beginTransaction();
            $shipments = Shipments::findOrFail($id);
            $shipments->booking_number = $request->booking_number;
            $shipments->status_id = $request->status_id;
            $shipments->sender_id = $request->sender_id;
            $shipments->receiver_id = $request->receiver_id;
            $shipments->created_by = $request->user()->id;
            $shipments->shiping_date = date("Y-m-d");
            $shipments->receipt_number = $request->receipt_number;
            $shipments->packing_type = $request->packing_type;
            $shipments->courier_company = $request->courier_company;
            $shipments->shiping_method = $request->shiping_method;
            $shipments->payment_method = $request->payment_method;
            $shipments->number_of_pcs = $request->number_of_pcs;
            $shipments->weight = $request->weight;
            $shipments->rate = $request->rate;
            $shipments->packing_charge = $request->packing_charge;
            $shipments->other_charges = $request->other_charges;
            $shipments->discount = $request->discount;
            $shipments->total_amount = $request->total_amount;
            $shipments->length = $request->length;
            $shipments->width = $request->width;
            $shipments->height = $request->height;
            $shipments->driver_id = $request->driver_id;
            $shipments->barcode = $request->barcode;
            $shipments->lrl_tracking_code = $request->lrl_tracking_code;
            $shipments->updated_by = $request->user()->id;
            $shipments->save();
            $status = Statuses::find($request->status_id);
            $shipments->status()->attach($status);
            Packages::where('shipment_id', $shipments->id)->delete();

            if ($request->description!=null) {
                for ($i = 0; $i < count($request->description); $i++) {
                    $package = new Packages();
                    $package->shipment_id = $shipments->id;
                    $package->branch_id = $shipments->branch_id;
                    $package->description = $request->description[$i];
                    $package->quantity = $request->qty[$i];
                    $package->unit_price = $request->unit[$i];
                    $package->subtotal = $request->subtotal[$i];
                    $package->save();
                }
            }
            \DB::commit();
        } catch (\Exception $e) {

            \DB::rollBack();
            Log::error($e->getMessage());
            toastr()->error($e->getMessage());
            return redirect()->back();
        }
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

    public function print($id){
        $shipment = Shipments::with('boxes')->with('packages')->with('agency')->with('receiver')->with('sender')->findOrFail($id);
        return view('branches.shipments.printview', compact('shipment'));
    }

    public function groupbookings(Request $request){

        // $bookinigIds = $request->bookinigId;
        $bookinigIds = explode(',',  $request->bookinigId);
        $ship_id = $request->ship_id;
        $shipments = Shipments::where('ship_id', $ship_id)->update(['ship_id' => null]);

        ShipsBookings::where('ship_id', $ship_id)->delete();

        foreach( $bookinigIds as   $bookinigId ) {
            $ship_bookings = new ShipsBookings();
            $ship_bookings->ship_id = $ship_id;
            $ship_bookings->booking_number =$bookinigId;
            $ship_bookings->save();
            $shipment = Shipments::where('id', $bookinigId)->update(['ship_id' =>  $ship_id]);
        }

        $ship_bookingsList = ShipsBookings::with('shipment')->with('ship')->where('ship_id', $ship_id)->get();
        $res ='';
        $tot_weight = 0;
        $tot_value = 0;
        $tot_temp =0;
        foreach( $ship_bookingsList as $booking) {
            $tot_temp= $booking->shipment->total_weight +$booking->shipment->msic_weight;
            $tot_weight +=$tot_temp;
            $tot_value += $booking->shipment->grand_total;
            $res.= '<tr><td style="text-align:center" >'.$booking->shipment->booking_number.'</td> ';
            $res.= ' <td style="text-align:center">'.$booking->ship->shipment_name.'</td>';
            $res.= ' <td style="text-align:center">'.$booking->shipment->number_of_pcs .'</td>';
            $res.= ' <td style="text-align:center">'.$booking->shipment->total_weight +$booking->shipment->msic_weight .'</td>';
            $res.= ' <td style="text-align:center">'.$booking->shipment->grand_total.'</td>';
            $res.= ' <td style="text-align:center"> Shipment Forwarded </td>';
            $res.= '<td>
                    <a href="#"
                       class="btn btn-icon waves-effect waves-light btn-success">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="shipment/print/'.$booking->shipment->id.'"
                       class="btn btn-icon waves-effect waves-light btn-success">
                        <i class="fas fa-print"></i>
                    </a>
                    <a href="#"
                       class="btn btn-icon waves-effect waves-light btn-dark">
                        <i class="fas fa-undo"></i>
                    </a>
                 </td> </tr>';
            }
            $res.='<tr><td  colspan="3"> </td><td style="text-align:center">'. $tot_weight.'</td><td style="text-align:center" >'.$tot_value.'</td> <td colspan="2"  ></td></tr>';
            return $res;

    }

    public function getBoxDetails(Request $request) {
        $boxId = $request->boxId;
        $boxName = $request->boxName;
        // $checkStatus = ShipsBookings::with('shipment.boxes','shipment.boxes.boxStatuses.status')->where('booking_id',$bookingId)->first();
        $checkStatus = Boxes::with('boxStatuses.status')->where('id',$boxId)->first();
        // foreach($checkStatus->shipment->boxes as $key => $boxes) {
        foreach($checkStatus->boxStatuses as $key1 => $status) {
            $checkStatus['dated'] = date('d-m-Y',strtotime($status->created_at));
        }
        // }
        return response()->json($checkStatus);
    }

    public function viewManifesto(Request $request, $id) {
        $id= $id;
        $statuses = status_list_admin(); //Statuses::get();
        $getShips = Ships::find($id);
        // $querys = ShipsBookings::with('shipment','shipment.shipmentStatus','shipment.bookingNumberStatus.status','shipment.sender','shipment.receiver.address','shipment.receiver.address.state','shipment.boxes','shipment.boxes.boxStatuses','shipment.boxes.boxStatuses.status','shipment.agency','shipment.branch','ship','ship.createdBy','ship.origin','ship.portOfOrigins','ship.shipmentTypes','ship.clearingAgents')->where('ship_id',$id);

        $querys =Boxes::with('shipment.driver','shipment.boxes','shipment.shipmentStatus','shipment.sender','shipment.receiver.address','shipment.receiver.address.state','shipment.boxes','shipment.boxes.boxStatuses','shipment.boxes.boxStatuses.status','shipment.agency','shipment.branch')->where('ship_id', $id)->where('is_transfer',0);

        $ships = $querys->get();

        return view('branches.ships.viewManifesto',compact('id','ships','getShips','statuses'));
    }

    public function manifestoExportView(Request $request, $id) {
        $id= $id;
            // $querys = ShipsBookings::with('shipment','shipment.shipmentStatus','shipment.bookingNumberStatus.status','shipment.sender','shipment.receiver.address','shipment.receiver.address.state','shipment.boxes','shipment.boxes.boxStatuses','shipment.boxes.boxStatuses.status','shipment.branch','ship','ship.createdBy','ship.portOfOrigins','ship.shipmentTypes','ship.clearingAgents')
            //                         ->where('ship_id',$id);

            // $querys = ShipsBookings::with('shipment','shipment.agency','shipment.shipmentStatus','shipment.bookingNumberStatus.status','shipment.sender','shipment.receiver.address','shipment.receiver.address.state','shipment.boxes','shipment.boxes.packages','shipment.boxes.boxStatuses','shipment.boxes.boxStatuses.status','shipment.branch','ship','ship.createdBy','ship.origin','ship.portOfOrigins','ship.shipmentTypes','ship.clearingAgents')->whereHas('shipment',function ($query) use ($request) {
            //     $query->where('branch_id', branch()->id);
            //     $query->where('is_transfer', NULL);
            // })->where('ship_id',$id);
// dd(branch()->id );
            // $querys =Boxes::with('shipment')->whereHas('shipment',function ($query) use ($id) {
            //         $query->where('branch_id', branch()->id);
            //         $query->where('ship_id',$id);
            //     })->where('is_transfer',0);
            $querys = Boxes::with('shipment')->where('ship_id',$id)->where('is_transfer',0);

            $boxes = $querys->get();

            //   dd($boxes);
            $getShips = Ships::find($id);
            $statuses = status_list_admin(); //Statuses::get();
            $branches = Branches::all();
            $drivers = Drivers::all();
            $tripsheets = Tripsheets::where('branch_id', branch()->id)->where('status', 'trip_created')->get();


        return view('branches.ships.manifestoView',compact('id','boxes', 'branches', 'drivers', 'tripsheets','statuses','getShips'));
    }

    public function editShip($id) {
        $shipId = $id;
        $ship =  Ships::with('createdBy','shipmentStatus','shipmentMethodTypes','portOfOrigins','portOfDestinations','clearingAgents')->where('branch_id', branch()->id)->orderBy('id', 'desc')->find($id);
        $staffs = Staffs::notadmin()->get();
        $shipmentTypes = ShipTypes::all();
        $statuses = status_list_admin(); //Statuses::get();
        $ports = PortOfOrigins::where('status',1)->get();
        $agents = Agencies::all();
       $haveBox = Boxes::all()->where('ship_id', $shipId);
    
        return view('branches.ships.editShips', compact('staffs', 'ship', 'shipmentTypes', 'ports', 'agents','statuses','haveBox'));
    }

    public function shipDetailesUpdate(Request $request) {
         try {
            \DB::beginTransaction();
            $ships = Ships::find($request->shipId);
            $ships->shipment_id = $request->shipment_id;
            $ships->shipment_name = $request->shipment_id;
            $ships->shipment_type_id = $request->shipment_type;
            $ships->port_of_origin_id = $request->port_of_origin;
            $ships->port_of_destination_id = $request->port_of_destination;
            $ships->clearing_agent_id = $request->clearing_agent;
            $ships->awd_id = $request->awd_number;
            $ships->awb_number = $request->awd_number;
            $ships->created_date = $request->created_date;
            // $ships->created_time = $request->created_time;
            $ships->license_details = $request->license_details;
            $ships->shipment_details = $request->shipment_details;
            $ships->created_by = $request->created_by;
            $ships->branch_id = branch()->id;
            $ships->shipment_status = $request->status;
            $ships->exchange_rate = $request->exchange_rate;
            $ships->save();
            $ship_id = $ships->id;

            \DB::commit();
        } catch (\Exception $e) {

            \DB::rollBack();
            Log::error($e->getMessage());
            toastr()->error($e->getMessage());
            return redirect()->back();
        }

        $ship_id = Ships::where('id',$ship_id )->first();
        toastr()->success('Shipment Updated Successfully');

        return redirect()->route('branch.ship.create');
    }

    public function detailedView($id) {
        $shipId = $id;
        $shipment = Ships::with('createdBy','shipmentStatus','shipmentMethodTypes','portOfOrigins','portOfDestinations','clearingAgents')->where('branch_id', branch()->id)->findOrFail($id);
        // $shipBookings = ShipsBookings::with('shipment','shipment.boxes')->where('ship_id', $shipId)->get();
        $shipBookings =  Boxes::with('boxStatuses.status','shipment.shipmentStatus','shipment.packages','boxStatuses.status')->whereHas('shipment',function ($query) {
            $query->where('branch_id', branch()->id);
        })->where('is_shipment',1)->where('ship_id',$shipId)->get();

        foreach($shipBookings as $key => $box) {
            $lastStatus = collect($box->boxStatuses)->last();
            $shipBookings[$key]["last_status"] = $lastStatus->status->name;
        }
        // return $shipBookings;
        return view('branches.ships.detailedView', compact('shipment','shipBookings'));
    }

}
