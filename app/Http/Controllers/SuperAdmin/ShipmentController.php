<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Agencies;
use App\Models\Branches;
use App\Models\Countries;
use App\Models\Customers;
use App\Models\Packages;
use App\Models\Shipments;
use App\Models\ShipsBookings;
use App\Models\Ships;
use App\Models\Statuses;
use App\Models\Boxes;
use App\Models\Drivers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use DataTables;
use Carbon\Carbon;


class ShipmentController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $fromDate = '';
        $toDate = '';
        $search = '';
        $branchId = '';
        $branches = Branches::all();
        if ($request->has('keyword') != "") {
            $keyword = $request->keyword;
            $client_ids = Customers::where("phone", "like", "%$keyword%")
                ->orWhere("identification_number", "like", "%$keyword%")
                ->get()
                ->pluck('id');

            $shipments = Shipments::with('driver')->paginate(10);
            if (count($client_ids) > 0) {
                $shipments = $shipments->whereIn("sender_id", $client_ids);
            }
            $shipments = $shipments->orWhere('booking_number', 'like', '%' . $keyword . '%');

            $shipments = $shipments->orderBy('created_at', 'desc')->get();

        } else {
            $fromDate = $request->input('from_date');
            $toDate = $request->input('to_date');
            $search = $request->input('search');
            $branchId = $request->input('branch');

            $query = Shipments::with('driver', 'sender', 'receiver');

            if ($branchId) {
                $query->where('branch_id', $branchId); // Adjust 'branch_id' to your actual column name
            }

            if ($fromDate) {
                $fromDate = Carbon::createFromFormat('d/m/Y', $fromDate)->startOfDay()->toDateString();
                $query->whereDate('created_at', '>=', $fromDate);
            }

            if ($toDate) {
                $toDate = Carbon::createFromFormat('d/m/Y', $toDate)->endOfDay()->toDateString();
                $query->whereDate('created_at', '<=', $toDate);
            }

            if ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('booking_number', 'like', "%$search%")
                        ->orWhereHas('sender', function ($query) use ($search) {
                            $query->where('phone', 'like', "%$search%");
                        })
                        ->orWhereHas('receiver', function ($query) use ($search) {
                            $query->where('phone', 'like', "%$search%");
                        });
                });
            }

            $shipments = $query->latest()->paginate(10);


        }


        return view('superadmin.shipments.index', compact('shipments', 'search', 'fromDate', 'toDate','branches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $shipment = Shipments::with('driver')->findOrFail($id);
        $boxes = Boxes::with('packages')->where('shipment_id', $id)->get();

        $agencies = Agencies::all();
        $origin_offices = Branches::all();
        $countries = Countries::all();
        $drivers = Drivers::whereActive(true)->get();
        return view('superadmin.shipments.show', compact('shipment','boxes', 'agencies', 'origin_offices', 'countries','drivers'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {


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

    }


    public function createadditems($id)
    {

    }



    public function additemsstore(Request $request)
    {


    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_invoice($id)
    {

        $shipment = Shipments::find($id);

        if($shipment->boxes){
            foreach($shipment->boxes as $box){
                if($box->packages ){
                    foreach($box->packages as $package){
                        if($package != null){
                            $pkg = Packages::find($package->id);
                            $pkg->delete();
                            echo 'pkg deleted';
                        }
                    }
                }
                $bx = Boxes::find($box->id);
                $bx->delete();
                echo 'box deleted';
            }
        }
        $shipment->delete();
        return back();

    }

    public function reportList(Request $request) {
        $statuses = Statuses::where('status',1)->get();
        $branches = Branches::get();

        $query = Boxes::with('shipment.driver','shipment.boxes','shipment.shipmentStatus','shipment.sender','shipment.receiver.address','shipment.receiver.address.state','boxStatuses.status','shipment.boxes.boxStatuses','shipment.boxes.boxStatuses.status','shipment.agency','shipment.branch')->where('is_shipment',1);
        $ships = $query->orderBy('id','desc')->get();
        $datas = [];
        foreach($ships as  $key => $ship) {
            $getShip = Ships::with('createdBy')->where('id',$ship->ship_id)->first();
            $datas[$key]['createdDate'] = (!empty($getShip->created_date) ) ? date('d-m-Y',strtotime($getShip->created_date)) : '';
            $datas[$key]['portOfOrigins'] = (!empty($getShip->portOfOrigins) ) ? $getShip->portOfOrigins->name : '';
            $datas[$key]['clearingAgents'] = (!empty($getShip->clearingAgents) ) ? $getShip->clearingAgents->name : '';
            $datas[$key]['shipmentTypes'] = (!empty($getShip->shipmentMethodTypes) ) ? $getShip->shipmentMethodTypes->name : '';
            $datas[$key]['awb_number'] = (!empty($getShip->awb_number) ) ? $getShip->awb_number : '';
            $datas[$key]['createdBy'] = (!empty($getShip->awb_number) ) ? $getShip->awb_number : '';
            $datas[$key]['boxes'] = (!empty($ship->box_name) ) ? $ship->box_name : '';

            if(!empty($ship->shipment->bookingNumberStatus)) {
                $collectedType = collect($ship->shipment->shipmentStatus)->where('statuses_id', 15)->first();
                $receivedType = collect($ship->boxStatuses)->where('status_id', 1)->last();
                    $bookedType = collect($ship->boxStatuses)->where('status_id', 2)->last();
                    $forwardedType = collect($ship->boxStatuses)->where('status_id', 3)->last();
                    $arrivedType = collect($ship->boxStatuses)->where('status_id', 4)->last();
                    $waitingType = collect($ship->boxStatuses)->where('status_id', 5)->last();
                    $onHoldType = collect($ship->boxStatuses)->where('status_id', 7)->last();
                    $clearedType = collect($ship->boxStatuses)->where('status_id', 8)->last();
                    $arrangedType = collect($ship->boxStatuses)->where('status_id', 9)->last();
                    $outType = collect($ship->boxStatuses)->where('status_id', 10)->last();
                    $deliveredType = collect($ship->boxStatuses)->where('status_id', 11)->last();
                    $notDeliveredType = collect($ship->boxStatuses)->where('status_id', 12)->last();
                    $pendingType = collect($ship->boxStatuses)->where('status_id', 13)->last();
                    $moreTrackingType = collect($ship->boxStatuses)->where('status_id', 14)->last();
                    $transferType = collect($ship->boxStatuses)->where('status_id', 17)->last();

                    $datas[$key]['collectedDate'] = (!empty($collectedType)) ? date('d-m-Y',strtotime($collectedType->created_at)) : '' ;
                    $datas[$key]['receivedDate'] = (!empty($receivedType)) ? date('d-m-Y',strtotime($receivedType->created_at)) : '' ;
                    $datas[$key]['bookedDate'] = (!empty($bookedType)) ? date('d-m-Y',strtotime($bookedType->created_at)) : '' ;
                    $datas[$key]['forwardedDate'] = (!empty($forwardedType)) ? date('d-m-Y',strtotime($forwardedType->created_at)) : '' ;
                    $datas[$key]['arrivedDate'] = (!empty($arrivedType)) ? date('d-m-Y',strtotime($arrivedType->created_at)) : '' ;
                    $datas[$key]['waitingDate'] = (!empty($waitingType)) ?  date('d-m-Y',strtotime($waitingType->created_at)) : '' ;
                    $datas[$key]['onHoldDate'] = (!empty($onHoldType)) ?  date('d-m-Y',strtotime($onHoldType->created_at)) : '' ;
                    $datas[$key]['clearedDate'] = (!empty($clearedType)) ? date('d-m-Y',strtotime($clearedType->created_at)) : '' ;
                    $datas[$key]['arrangedDate'] = (!empty($arrangedType)) ?  date('d-m-Y',strtotime($arrangedType->created_at)) : '' ;
                    $datas[$key]['outDate'] = (!empty($outType)) ?  date('d-m-Y',strtotime($outType->created_at)) : '' ;
                    $datas[$key]['deliveredDate'] = (!empty($deliveredType)) ?  date('d-m-Y',strtotime($deliveredType->created_at)) : '' ;
                    $datas[$key]['notDeliveredDate'] = (!empty($notDeliveredType)) ?  date('d-m-Y',strtotime($notDeliveredType->created_at)) : '' ;
                    $datas[$key]['pendingDate'] = (!empty($pendingType)) ?  date('d-m-Y',strtotime($pendingType->created_at)) : '' ;
                    $datas[$key]['moreTrackingDate'] = (!empty($moreTrackingType)) ?  date('d-m-Y',strtotime($moreTrackingType->created_at)) : '' ;
                    $datas[$key]['transferDate'] = (!empty($transferType)) ?  date('d-m-Y',strtotime($transferType->created_at)) : '' ;

                    $status = collect($ship->boxStatuses)->last();
                    $shipmentStatus = collect($ship->shipment->shipmentStatus)->last();
                    $datas[$key]['lastStatus'] = (!empty($status)) ? $status->status->name : $shipmentStatus->status->name ;

                    if($datas[$key]['lastStatus'] == "Shipment on hold") {
                        $datas[$key]['style'] = 'background-color:#ffdb00;';
                    } else if($datas[$key]['lastStatus'] == "Pending") {
                        $datas[$key]['style'] = 'background-color:#ec1616e6;';
                    } else {
                        $datas[$key]['style'] = 'background-color:none;';
                    }
                $datas[$key]['booking_number'] = $ship->shipment->booking_number;
                $datas[$key]['shipment_id'] = $getShip->shipment_id;
                $datas[$key]['full_name'] = $getShip->createdBy->full_name??'';
                $datas[$key]['branch_name'] = $ship->shipment->branch->name??'';
                $datas[$key]['view'] = '<a href="javascript:void(0)" class="edit btn btn-secondary btn-sm detailedView">View</a>';
            }
        }
        return view('superadmin.shipments.reports',compact('statuses','branches','datas'));
    }

    public function viewDataReport($fromDate,$toDate) {
        $query = Boxes::with('shipment.driver','shipment.boxes','shipment.shipmentStatus','shipment.sender','shipment.receiver.address','shipment.receiver.address.state','boxStatuses.status','shipment.boxes.boxStatuses','shipment.boxes.boxStatuses.status','shipment.agency','shipment.branch')->where('is_shipment',1);
        $ships = $query->whereHas('boxStatuses', function ($q) use ($fromDate,$toDate) {
                        $q->whereBetween('boxes_statuses.created_at',[$fromDate, $toDate]);
                    })->orderBy('id','desc')->get();

        $datas = [];
            foreach($ships as  $key => $ship) {
                $getShip = Ships::with('createdBy')->where('id',$ship->ship_id)->first();
                $datas[$key]['createdDate'] = (!empty($getShip->created_date) ) ? date('d-m-Y',strtotime($getShip->created_date)) : '';
                $datas[$key]['portOfOrigins'] = (!empty($getShip->portOfOrigins) ) ? $getShip->portOfOrigins->name : '';
                $datas[$key]['clearingAgents'] = (!empty($getShip->clearingAgents) ) ? $getShip->clearingAgents->name : '';
                $datas[$key]['shipmentTypes'] = (!empty($getShip->shipmentMethodTypes) ) ? $getShip->shipmentMethodTypes->name : '';
                $datas[$key]['awb_number'] = (!empty($getShip->awb_number) ) ? $getShip->awb_number : '';
                $datas[$key]['createdBy'] = (!empty($getShip->awb_number) ) ? $getShip->awb_number : '';
                $datas[$key]['boxes'] = (!empty($ship->box_name) ) ? $ship->box_name : '';

                if(!empty($ship->shipment->bookingNumberStatus)) {
                    $collectedType = collect($ship->shipment->shipmentStatus)->where('statuses_id', 15)->last();
                    $receivedType = collect($ship->boxStatuses)->where('status_id', 1)->last();
                    $bookedType = collect($ship->boxStatuses)->where('status_id', 2)->last();
                    $forwardedType = collect($ship->boxStatuses)->where('status_id', 3)->last();
                    $arrivedType = collect($ship->boxStatuses)->where('status_id', 4)->last();
                    $waitingType = collect($ship->boxStatuses)->where('status_id', 5)->last();
                    $onHoldType = collect($ship->boxStatuses)->where('status_id', 7)->last();
                    $clearedType = collect($ship->boxStatuses)->where('status_id', 8)->last();
                    $arrangedType = collect($ship->boxStatuses)->where('status_id', 9)->last();
                    $outType = collect($ship->boxStatuses)->where('status_id', 10)->last();
                    $deliveredType = collect($ship->boxStatuses)->where('status_id', 11)->last();
                    $notDeliveredType = collect($ship->boxStatuses)->where('status_id', 12)->last();
                    $pendingType = collect($ship->boxStatuses)->where('status_id', 13)->last();
                    $moreTrackingType = collect($ship->boxStatuses)->where('status_id', 14)->last();
                    $transferType = collect($ship->boxStatuses)->where('status_id', 17)->last();

                    $datas[$key]['collectedDate'] = (!empty($collectedType)) ? date('d-m-Y',strtotime($collectedType->created_at)) : '' ;
                    $datas[$key]['receivedDate'] = (!empty($receivedType)) ? date('d-m-Y',strtotime($receivedType->created_at)) : '' ;
                    $datas[$key]['bookedDate'] = (!empty($bookedType)) ? date('d-m-Y',strtotime($bookedType->created_at)) : '' ;
                    $datas[$key]['forwardedDate'] = (!empty($forwardedType)) ? date('d-m-Y',strtotime($forwardedType->created_at)) : '' ;
                    $datas[$key]['arrivedDate'] = (!empty($arrivedType)) ? date('d-m-Y',strtotime($arrivedType->created_at)) : '' ;
                    $datas[$key]['waitingDate'] = (!empty($waitingType)) ?  date('d-m-Y',strtotime($waitingType->created_at)) : '' ;
                    $datas[$key]['onHoldDate'] = (!empty($onHoldType)) ?  date('d-m-Y',strtotime($onHoldType->created_at)) : '' ;
                    $datas[$key]['clearedDate'] = (!empty($clearedType)) ? date('d-m-Y',strtotime($clearedType->created_at)) : '' ;
                    $datas[$key]['arrangedDate'] = (!empty($arrangedType)) ?  date('d-m-Y',strtotime($arrangedType->created_at)) : '' ;
                    $datas[$key]['outDate'] = (!empty($outType)) ?  date('d-m-Y',strtotime($outType->created_at)) : '' ;
                    $datas[$key]['deliveredDate'] = (!empty($deliveredType)) ?  date('d-m-Y',strtotime($deliveredType->created_at)) : '' ;
                    $datas[$key]['notDeliveredDate'] = (!empty($notDeliveredType)) ?  date('d-m-Y',strtotime($notDeliveredType->created_at)) : '' ;
                    $datas[$key]['pendingDate'] = (!empty($pendingType)) ?  date('d-m-Y',strtotime($pendingType->created_at)) : '' ;
                    $datas[$key]['moreTrackingDate'] = (!empty($moreTrackingType)) ?  date('d-m-Y',strtotime($moreTrackingType->created_at)) : '' ;
                    $datas[$key]['transferDate'] = (!empty($transferType)) ?  date('d-m-Y',strtotime($transferType->created_at)) : '' ;

                    $status = collect($ship->boxStatuses)->last();
                    $shipmentStatus = collect($ship->shipment->shipmentStatus)->last();
                    $datas[$key]['lastStatus'] = (!empty($status)) ? $status->status->name : $shipmentStatus->status->name ;

                    if($datas[$key]['lastStatus'] == "Shipment on hold") {
                        $datas[$key]['style'] = 'background-color:#ffdb00;';
                    } else if($datas[$key]['lastStatus'] == "Pending") {
                        $datas[$key]['style'] = 'background-color:#ec1616e6;';
                    } else {
                        $datas[$key]['style'] = 'background-color:none;';
                    }
                    $datas[$key]['booking_number'] = $ship->shipment->booking_number;
                    $datas[$key]['shipment_id'] = $getShip->shipment_id;
                    $datas[$key]['full_name'] = $getShip->createdBy->full_name;
                    $datas[$key]['view'] = '<a href="javascript:void(0)" class="edit btn btn-secondary btn-sm detailedView">View</a>';
                    $datas[$key]['branch_name'] = $ship->shipment->branch->name;
                }
            }
        return response()->json($datas);
    }

    public function viewStatusDataReport($status) {
        $query = Boxes::with('shipment.driver','shipment.boxes','shipment.shipmentStatus','shipment.sender','shipment.receiver.address','shipment.receiver.address.state','boxStatuses.status','shipment.boxes.boxStatuses','shipment.boxes.boxStatuses.status','shipment.agency','shipment.branch')->where('is_shipment',1);
        $ships = $query->whereHas('boxStatuses', function ($q) use ($status) {
                $q->where('boxes_statuses.status_id',$status);
            })->orderBy('id','desc')->get();

        $datas = [];
            foreach($ships as  $key => $ship) {
                $getShip = Ships::with('createdBy')->where('id',$ship->ship_id)->first();
                $datas[$key]['createdDate'] = (!empty($getShip->created_date) ) ? date('d-m-Y',strtotime($getShip->created_date)) : '';
                $datas[$key]['portOfOrigins'] = (!empty($getShip->portOfOrigins) ) ? $getShip->portOfOrigins->name : '';
                $datas[$key]['clearingAgents'] = (!empty($getShip->clearingAgents) ) ? $getShip->clearingAgents->name : '';
                $datas[$key]['shipmentTypes'] = (!empty($getShip->shipmentMethodTypes) ) ? $getShip->shipmentMethodTypes->name : '';
                $datas[$key]['awb_number'] = (!empty($getShip->awb_number) ) ? $getShip->awb_number : '';
                $datas[$key]['createdBy'] = (!empty($getShip->awb_number) ) ? $getShip->awb_number : '';
                $datas[$key]['boxes'] = (!empty($ship->box_name) ) ? $ship->box_name : '';

                if(!empty($ship->boxStatuses)) {
                    $collectedType = collect($ship->shipment->shipmentStatus)->where('statuses_id', 15)->last();
                    $receivedType = collect($ship->boxStatuses)->where('status_id', 1)->last();
                    $bookedType = collect($ship->boxStatuses)->where('status_id', 2)->last();
                    $forwardedType = collect($ship->boxStatuses)->where('status_id', 3)->last();
                    $arrivedType = collect($ship->boxStatuses)->where('status_id', 4)->last();
                    $waitingType = collect($ship->boxStatuses)->where('status_id', 5)->last();
                    $onHoldType = collect($ship->boxStatuses)->where('status_id', 7)->last();
                    $clearedType = collect($ship->boxStatuses)->where('status_id', 8)->last();
                    $arrangedType = collect($ship->boxStatuses)->where('status_id', 9)->last();
                    $outType = collect($ship->boxStatuses)->where('status_id', 10)->last();
                    $deliveredType = collect($ship->boxStatuses)->where('status_id', 11)->last();
                    $notDeliveredType = collect($ship->boxStatuses)->where('status_id', 12)->last();
                    $pendingType = collect($ship->boxStatuses)->where('status_id', 13)->last();
                    $moreTrackingType = collect($ship->boxStatuses)->where('status_id', 14)->last();
                    $transferType = collect($ship->boxStatuses)->where('status_id', 17)->last();

                    $datas[$key]['collectedDate'] = (!empty($collectedType)) ? date('d-m-Y',strtotime($collectedType->created_at)) : '' ;
                    $datas[$key]['receivedDate'] = (!empty($receivedType)) ? date('d-m-Y',strtotime($receivedType->created_at)) : '' ;
                    $datas[$key]['bookedDate'] = (!empty($bookedType)) ? date('d-m-Y',strtotime($bookedType->created_at)) : '' ;
                    $datas[$key]['forwardedDate'] = (!empty($forwardedType)) ? date('d-m-Y',strtotime($forwardedType->created_at)) : '' ;
                    $datas[$key]['arrivedDate'] = (!empty($arrivedType)) ? date('d-m-Y',strtotime($arrivedType->created_at)) : '' ;
                    $datas[$key]['waitingDate'] = (!empty($waitingType)) ?  date('d-m-Y',strtotime($waitingType->created_at)) : '' ;
                    $datas[$key]['onHoldDate'] = (!empty($onHoldType)) ?  date('d-m-Y',strtotime($onHoldType->created_at)) : '' ;
                    $datas[$key]['clearedDate'] = (!empty($clearedType)) ? date('d-m-Y',strtotime($clearedType->created_at)) : '' ;
                    $datas[$key]['arrangedDate'] = (!empty($arrangedType)) ?  date('d-m-Y',strtotime($arrangedType->created_at)) : '' ;
                    $datas[$key]['outDate'] = (!empty($outType)) ?  date('d-m-Y',strtotime($outType->created_at)) : '' ;
                    $datas[$key]['deliveredDate'] = (!empty($deliveredType)) ?  date('d-m-Y',strtotime($deliveredType->created_at)) : '' ;
                    $datas[$key]['notDeliveredDate'] = (!empty($notDeliveredType)) ?  date('d-m-Y',strtotime($notDeliveredType->created_at)) : '' ;
                    $datas[$key]['pendingDate'] = (!empty($pendingType)) ?  date('d-m-Y',strtotime($pendingType->created_at)) : '' ;
                    $datas[$key]['moreTrackingDate'] = (!empty($moreTrackingType)) ?  date('d-m-Y',strtotime($moreTrackingType->created_at)) : '' ;
                    $datas[$key]['transferDate'] = (!empty($transferType)) ?  date('d-m-Y',strtotime($transferType->created_at)) : '' ;

                    $status = collect($ship->boxStatuses)->last();
                    $shipmentStatus = collect($ship->shipment->shipmentStatus)->last();
                    $datas[$key]['lastStatus'] = (!empty($status)) ? $status->status->name : $shipmentStatus->status->name ;

                    if($datas[$key]['lastStatus'] == "Shipment on hold") {
                        $datas[$key]['style'] = 'background-color:#ffdb00;';
                    } else if($datas[$key]['lastStatus'] == "Pending") {
                        $datas[$key]['style'] = 'background-color:#ec1616e6;';
                    } else {
                        $datas[$key]['style'] = 'background-color:none;';
                    }
                    $datas[$key]['booking_number'] = $ship->shipment->booking_number;
                    $datas[$key]['shipment_id'] = $getShip->shipment_id;
                    $datas[$key]['full_name'] = $getShip->createdBy->full_name;
                    $datas[$key]['branch_name'] = $ship->shipment->branch->name;
                    $datas[$key]['view'] = '<a href="javascript:void(0)" class="edit btn btn-secondary btn-sm detailedView">View</a>';
                }
            }
        return response()->json($datas);
    }

    public function getData(Request $request)
    {
        $number = $request->input('number');

        $data = ShipsBookings::get();

        return Datatables::of($data)->make(true);
    }

    public function detailed(Request $request)
    {
       $shipmentNumber = $request->shipmentNumber;
       $bookingNumber = $request->bookingNumber;
       $querys = Shipments::with('shipmentStatus','boxes','boxes.boxStatuses','boxes.boxStatuses.status')
                                    ->where('booking_number',$bookingNumber)->first();
        $boxeses = $querys->boxes;
        foreach($querys->boxes as $key => $boxes) {
            foreach($boxes->boxStatuses as $key1 => $status) {
                $boxeses[$key]['dated'] = date('d-m-Y',strtotime($status->created_at));
            }
        }
        return response()->json($boxeses);
    }

    public function invoce_status_change(Request $request){

    }

    public function exportView(Request $request)
    {

        // Get input data
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $search = $request->input('search');
        $branchId = $request->input('branch');

        // Create a query
        $query = Shipments::with('driver', 'sender', 'receiver');

        // Apply filters
        if ($branchId) {
            $query->where('branch_id', $branchId);
        }

        if ($fromDate) {
            $fromDate = Carbon::createFromFormat('d/m/Y', $fromDate)->startOfDay()->toDateString();
            $query->whereDate('created_at', '>=', $fromDate);
        }

        if ($toDate) {
            $toDate = Carbon::createFromFormat('d/m/Y', $toDate)->endOfDay()->toDateString();
            $query->whereDate('created_at', '<=', $toDate);
        }

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('booking_number', 'like', "%$search%")
                    ->orWhereHas('sender', function ($query) use ($search) {
                        $query->where('phone', 'like', "%$search%");
                    })
                    ->orWhereHas('receiver', function ($query) use ($search) {
                        $query->where('phone', 'like', "%$search%");
                    });
            });
        }

        // Get all data
        $shipments = $query->latest()->get();
        return view("superadmin.shipments.report", compact("shipments"));

    }

        public function print($id){

            $shipment = Shipments::with('boxes')->with('packages')->with('agency')->with('receiver')->with('sender')->findOrFail($id);
            return view('branches.shipments.printview', compact('shipment'));
        }

        public function printCustomer($id){
            $shipment = Shipments::with('boxes')->with('packages')->with('agency')->with('receiver')->with('sender')->findOrFail($id);
            return view('branches.shipments.printCustomerview', compact('shipment'));
        }

        public function loadingExport(Request $request) {
            if(!empty($request->boxId)) {
                $explode_id = explode(',', $request->boxId);
                // $datas = ShipsBookings::with('shipment','ship','shipment.boxes','shipment.bookingNumberStatus.status')->whereIn('booking_id', $explode_id)->get();
                $datas = Boxes::with('shipment.shipmentStatus','shipment.packages','boxStatuses.status')
                        ->where('is_transfer', 0)
                        ->whereIn('id', $explode_id)
                        ->get();


            } else {
                $request->shipIds;
                $datas = Boxes::with('shipment.shipmentStatus','shipment.packages','shipment.shipType','boxStatuses.status')
                        ->where('is_transfer', 0)
                        ->where('is_shipment', 1)
                        ->where('ship_id', $request->shipIds)
                        ->get();


                // $datas = ShipsBookings::with('shipment','ship','shipment.boxes','shipment.bookingNumberStatus.status')->where('ship_id', $request->shipIds)->get();
            }
            foreach($datas as $data) {
                $shipId = $data->ship_id;
            }
            $mode = Ships::with('shipmentMethodTypes')->find($shipId);
            $excelName = "loadinglist.xlsx";
            return view('branches.shipments.loadingExportList', compact('datas','excelName','mode'));
        }

        public function printall(Request $request){
            $shipments = Boxes::with('packages')->whereIn('id', $request->booking_ids)->get();
            $agency = Agencies::find($request->agency);
            $awb_no = $request->input('awb_no');
            return view('branches.shipments.printviewall', compact('shipments','agency','awb_no'));
    }
}
