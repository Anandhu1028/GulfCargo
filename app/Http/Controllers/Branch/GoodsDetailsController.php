<?php

namespace App\Http\Controllers\Branch;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Agencies;
use App\Models\Branches;
use App\Models\Vehicles;
use App\Models\Countries;
use App\Models\Customers;
use App\Models\Packages;
use App\Models\Shipments;
use App\Models\BoxDimensions;
use App\Models\Discount;
use App\Models\Weight;
use App\Models\Statuses;
use App\Models\Ships;
use App\Models\ShipsBookings;
use App\Models\ShipTypes;
use App\Models\Boxes;
use App\Models\Drivers;
use App\Models\Staffs;
use App\Models\States;
use App\Models\Cities;
use App\Models\GoodsDetails;
use App\Models\Vendors;
use App\Models\BoxesStatuses;
use App\Models\ShipmentTransfers;
use App\Models\Tripsheets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Exports\LoadingListExport;
use Maatwebsite\Excel\Facades\Excel;
use DataTables;

class GoodsDetailsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        $serachq = $request->serachq; 
        $search = array();
        $tripsheets = Tripsheets::where('branch_id', branch()->id)->where('status', 'trip_created')->get();
        $branches = Branches::all();
        $vehicles = Vehicles::all();
        $vendors = Vendors::all();

        
        
        
        if (isset($request->serachq) && $request->serachq!= 'all') {   
           
            if( $serachq =='phone'){
                
                $goods_det = GoodsDetails::with('boxes','vendorDetails','currentStatus', 'boxes.boxStatuses', 'boxes.boxStatuses.status','receiver', 'receiver.address',
                'receiver.address.state','receiver.address.city')->whereHas('receiver', function($q) use ($request) { 
                    $q->where('phone', $request->search);             
                })->where('branch_id',branch()->id)->where('trip_sheet_id',NULL)->where('transfer_status', 'confirmed')->latest()->orderBy('created_at', 'desc')->paginate(15);               
            }

            if( $serachq =='address'){
                
                $goods_det = GoodsDetails::with('boxes','vendorDetails','currentStatus', 'boxes.boxStatuses', 'boxes.boxStatuses.status','receiver', 'receiver.address',
                'receiver.address.state','receiver.address.city')->whereHas('receiver', function($q) use ($request) { 
                    $q->where('receiver.address', $request->search);             
                })->where('branch_id',branch()->id)->where('trip_sheet_id',NULL)->where('transfer_status', 'confirmed')->latest()->orderBy('created_at', 'desc')->paginate(15);               
            }

            if( $serachq =='state'){
                
                $goods_det = GoodsDetails::with('boxes','vendorDetails','currentStatus', 'boxes.boxStatuses', 'boxes.boxStatuses.status','receiver', 'receiver.address',
                'receiver.address.state','receiver.address.city')->whereHas('receiver.address.state', function($q) use ($request) { 
                    $q->where('name', $request->search);             
                })->where('branch_id',branch()->id)->where('trip_sheet_id',NULL)->where('transfer_status', 'confirmed')->latest()->orderBy('created_at', 'desc')->paginate(15);               
            }

            if( $serachq =='district'){
                
                $goods_det = GoodsDetails::with('boxes','vendorDetails','currentStatus', 'boxes.boxStatuses', 'boxes.boxStatuses.status','receiver', 'receiver.address',
                'receiver.address.state','receiver.address.city')->whereHas('receiver.address.city', function($q) use ($request) { 
                    $q->where('name', $request->search);             
                })->where('branch_id',branch()->id)->where('trip_sheet_id',NULL)->where('transfer_status', 'confirmed')->latest()->orderBy('created_at', 'desc')->paginate(15);               
            }


            if( $serachq =='number_of_pcs' || $serachq =='vendor' || $serachq =='weight'  ||   $serachq =='invoice_number' ||   $serachq =='status' ||  $serachq =='courier_company'){
                $search = array( $serachq =>  $request->search );
                // print_r( $search);
                // die;
                $goods_det = GoodsDetails::with('boxes','vendorDetails','currentStatus', 'boxes.boxStatuses', 'boxes.boxStatuses.status','receiver', 'receiver.address',
                'receiver.address.state','receiver.address.city')->where( $search )->where('branch_id',branch()->id)->where('trip_sheet_id',NULL)->where('transfer_status', 'confirmed')->latest()->orderBy('created_at', 'desc')->paginate(15);    
            } 


        } else {
           
            $goods_det = GoodsDetails::with('boxes','vendorDetails','currentStatus', 'boxes.boxStatuses', 'boxes.boxStatuses.status')->where('branch_id',branch()->id)->where('trip_sheet_id',NULL)->where('transfer_status', 'confirmed')->latest()->orderBy('created_at', 'desc')->paginate(15);
        } 

        // $boxes = Boxes::with('boxStatuses')->where('id', 36)->get();
        // dd($goods_det ); 
        // dd($boxes );

        //currentStatus
 

        return view('branches.goods_details.allgoods', compact('goods_det','tripsheets', 'branches', 'vendors', 'vehicles'));

    } 
    

    public function updateSortOrder(Request $request){

        $max_sort_order = GoodsDetails::select('sort_order')->where('branch_id',branch()->id)->where('trip_sheet_id',NULL)->max('sort_order');
        if($max_sort_order == null){
            $sort_order = 1;
        } else {
            $sort_order = $max_sort_order + 1;
        }

        $goods_ids = explode("-",  $request->id);
        $goods = GoodsDetails::findOrFail($goods_ids[1]);
        if($request->flag == "true") {
            $goods->sort_order = $sort_order;
        } else {
            $goods->sort_order = NULL;
        }
        $goods->save();
       
    }

    public function updateMultipleSortOrder(Request $request){

        $max_sort_order = GoodsDetails::select('sort_order')->where('branch_id',branch()->id)->where('trip_sheet_id',NULL)->max('sort_order');
        if($max_sort_order == null){
            $sort_order = 1;
        } else {
            $sort_order = $max_sort_order + 1;
        }

        $checkedArray = $request->checkedArray;
        foreach( $checkedArray as $invoice ) {
            $invoice_arr    = explode("-", $invoice);
            $goods_id       = $invoice_arr[1];

            $goods = GoodsDetails::findOrFail( $goods_id ); 
            $goods->sort_order = $sort_order;             
            $goods->save();

            $sort_order = $sort_order+1;
        }       
    }


    public function resetSortOrder(Request $request){
       $res = GoodsDetails::where('branch_id',branch()->id)->where('trip_sheet_id',NULL)->update(['sort_order'=>NULL]);
       if($res){
        echo "Reset Successfully";
       }
    } 

    public function addCargos(Request $request) {
      
        $max_sort_order = GoodsDetails::select('sort_order')->where('branch_id',branch()->id)->where('trip_sheet_id',NULL)->max('sort_order');
        if($max_sort_order == null){
            $sort_order = 1;
        } else {
            $sort_order = $max_sort_order + 1;
        }

        $trip_sheet_id = $request->trip_sheet_id;
        if(  $request->checkedArray != '') {
            $checkedArray =   explode(",", $request->checkedArray);          
            if(!empty( $checkedArray )){                
                foreach( $checkedArray as $invoice ) {
                    $invoice_arr    = explode("-", $invoice); 
                    $goods_id       = $invoice_arr[1];
        
                    $goods  = GoodsDetails::findOrFail( $goods_id ); 
                   
        

                    //   ADD ONE STATUS TO BOX STATUS TABLE FOR TRACKING PURPOSE
                    $bookings = new BoxesStatuses();
                    $bookings->status_id = 18; //  Out for Delivery
                    $bookings->box_id = $goods->box_id;
                    $bookings->created_at =  date('Y-m-d');
                    $bookings->save();

                    $goods->trip_sheet_id   = $trip_sheet_id;    
                    $goods->sort_order      = $sort_order;         
                    $goods->current_status_id      = $bookings->id;         
                    $goods->save();

                    $sort_order = $sort_order+1;
                }  
                echo "<span style='color:green'>Goods Added Successfully</span>";
            }
        } else {

                echo "<span style='color:red'>No Goods Selected</span>"; 
        }
         

    }    

    public function inTripsheet(Request $request) { 

        if ($request->has('keyword') != "") {            
            $goods = GoodsDetails::where('branch_id',branch()->id)
                                    ->where('transfer_status', 'confirmed')            
                                    ->whereNotNull('trip_sheet_id' )            
                                    ->latest()->orderBy('created_at', 'desc')->get();            
        } else {

            $goods = GoodsDetails::where('branch_id',branch()->id)
                                    ->where('transfer_status', 'confirmed')            
                                    ->whereNotNull('trip_sheet_id')            
                                    ->latest()->orderBy('created_at', 'desc')->get();          
        } 
        return view('branches.goods_details.goods_in_tripsheet', compact('goods' ));

    }

    public function notInTripsheet(Request $request) {

        if ($request->has('keyword') != "") {            
            $goods = GoodsDetails::where('branch_id',branch()->id)
                                    ->where('transfer_status', 'confirmed')            
                                    ->whereNull('trip_sheet_id' )            
                                    ->latest()->orderBy('created_at', 'desc')->get();            
        } else {

            $goods = GoodsDetails::where('branch_id',branch()->id)
                                    ->where('transfer_status', 'confirmed')            
                                    ->whereNull('trip_sheet_id')            
                                    ->latest()->orderBy('created_at', 'desc')->get();          
        } 
        return view('branches.goods_details.goods_not_in_tripsheet', compact('goods' ));
        
    }


    public function getByID(Request $request) {

        $id             = $request->goods_id;
        $GoodsDetails   = GoodsDetails::with('currentStatus')->where('id', $id )->first(); 
        return $GoodsDetails;
        
    }


    public function ajaxUpdate(Request $request) {

        $id                 = $request->goods_id; 
        $re_weight          = $request->re_weight;
        $received_date      = $request->received_date;
        $connecting_date    = $request->connecting_date;
        $number_of_pcs      = $request->number_of_pcs;
        $vendor             = $request->vendor;
        $status             = $request->status;
        $remarks            = $request->remarks;

           
        $status_name    = Statuses::findOrFail( $request->status );   
        $status_name    = $status_name->name;

        $goodsDetails = GoodsDetails::where('id', $id )->first(); 
        
         // ADD ONE STATUS TO BOX STATUS TABLE FOR TRACKING PURPOSE
         $bookings = new BoxesStatuses();
         $bookings->status_id =  $request->status; // Hold, Short, Recived
         $bookings->box_id = $goodsDetails->box_id;
         $bookings->created_at =  date('Y-m-d');
         $bookings->save();
       
        $goodsDetails->re_weight            = $re_weight;
        $goodsDetails->received_date        = $received_date;
        $goodsDetails->connecting_date      = $connecting_date;
        $goodsDetails->number_of_pcs        = $number_of_pcs;
        $goodsDetails->vendor               = $vendor;
        $goodsDetails->current_status_id    = $bookings->id;
        $goodsDetails->status           = $status_name;
        $goodsDetails->remarks          = $remarks;     
         
          
        $res = $goodsDetails->save(); 
        if($res )
        {
            echo "Updated Successfully !";
        } else {
            echo "Error"; 
        }
 
    }

    public function autocomplete(Request $request) {
        $data = $request->all();
        $query = $data['query'];
        $filter_data = GoodsDetails::select('invoice_number')
                        ->where('invoice_number', 'LIKE', '%'.$query.'%')
                        ->get();
        $data = array();
        foreach ($filter_data as $hsl)
            {
                $data[] = $hsl->invoice_number;
            }                   

        return response()->json($data); 
    }   
    
    public function getVehicleDetails(Request $request) {
       
        $vehicle_Details = Vehicles::where('id',  $request->vehicle_id)->first();
        $html = "<table>
                    <tr> 
                    <td>Driver name    </td><td>: &nbsp;&nbsp;". $vehicle_Details->driver_name."</td></tr>
                    <td>Vehicle Name   </td><td>: &nbsp;&nbsp;". $vehicle_Details->name."</td></tr>
                    <td>Vehicle Number  &nbsp;&nbsp;</td><td>: &nbsp;&nbsp;". $vehicle_Details->vehicle_no."</td></tr>
                    <td>Vehicle Reg Exp </td><td>: &nbsp;&nbsp;". $vehicle_Details->reg_expiry."</td></tr>
                    </table>";

        echo $html;
        exit;
         
    }   

    public function branchTransfer(Request $request) {
        $vehicle_id  =  $request->vehicle_id;
        $transfer_to  =  $request->transfer_to;
        $transfer_from  =  $request->transfer_from; 

        if( $request->sel_goods_id ==''){
            $goods_ids = [];
        } else {
            $goods_ids = explode(',', $request->sel_goods_id);
        }

        if(!empty($goods_ids)){
            foreach( $goods_ids as $goods ){ 

                $goods_id_arr = explode('-', $goods); 
                
                $goods_id = $goods_id_arr[1];
                $goods_details = GoodsDetails::findOrFail($goods_id);

                
                // ADD ONE STATUS TO BOX STATUS TABLE FOR TRACKING PURPOSE
                $bookings = new BoxesStatuses();
                $bookings->status_id = 17; // Transfer status id
                $bookings->box_id = $goods_details->box_id;
                $bookings->created_at =  date('Y-m-d');
                $bookings->save();


                $shipmentTransfer = new ShipmentTransfers(); 
                $shipmentTransfer->goods_details_id     = $goods_details->id;
                $shipmentTransfer->box_id               = $goods_details->box_id;
                $shipmentTransfer->tracking_number      = $goods_details->tracking_number;
                $shipmentTransfer->invoice_number       = $goods_details->invoice_number;
                $shipmentTransfer->transfer_from        = $request->transfer_from;
                $shipmentTransfer->transfer_to          = $request->transfer_to;
                $shipmentTransfer->vehicle_id           = $request->vehicle_id;  
                $shipmentTransfer->transferred_status   = 'pending';                 
                $shipmentTransfer->save(); 

                $goods_details->branch_id               = $request->transfer_to;
                $goods_details->is_transfer             = 1;
                $goods_details->transfer_status         = 'pending';
                $goods_details->current_status_id       = $bookings->id; // transferred
                $goods_details->shipment_transfer_id    = $shipmentTransfer->id;
                $goods_details->sort_order              = NULL; // update sort order column null if the action is transfer
                $goods_details->save();

                echo "Transfered Succesfully";
                exit;

            }
        } else {
            echo "Please select goods";
            exit;
        }


       

         
    }   

    // 


    
    
}