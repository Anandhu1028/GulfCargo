<?php
namespace App\Http\Controllers\Branch;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Agencies;
use App\Models\Branches;
use App\Models\Statuses;
use App\Models\ShipTypes;
use App\Models\Drivers;
use App\Models\Staffs;
use App\Models\States;
use App\Models\Tripsheets;
use Illuminate\Http\Request;
use App\Models\GoodsDetails;
use App\Models\GoodsStatus;
use App\Models\BoxesStatuses;
use App\Models\Vehicles;
use App\Models\Vendors;



use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;



class TripsheetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
        $tripsheets = Tripsheets::with('vehicle','vendor')->where('branch_id', branch()->id)->get();  

      
         return view('branches.tripsheet.index', compact('tripsheets') );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $agencies = Agencies::all();
        $vendors = Vendors::all();
        $vehicles = Vehicles::all();
        // $drivers = Drivers::whereActive(true)->get(); 
 
        return view('branches.tripsheet.create', compact('vendors', 'vehicles', 'agencies') );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try {
            \DB::beginTransaction();
 
                $tripsheet_count = Tripsheets::where('branch_id' , branch()->id)->max('tripsheet_no'); 
                $tripsheet_no =  $tripsheet_count+1;
       

                $tripsheet = new Tripsheets();
                $tripsheet->tripsheet_no  = $tripsheet_no;
                $tripsheet->trip_date  = $request->trip_date;
                $tripsheet->trip_time  = $request->trip_time;
                $tripsheet->estimate_arrival_date  = $request->estimate_arrival_date;
                $tripsheet->agency_id  = $request->agency_id;
                $tripsheet->vehicle_id  = $request->vehicle_id;
                $tripsheet->driver_name  = $request->driver_name;
                $tripsheet->driver_mobile  = $request->driver_mobile;
                $tripsheet->hepler_name  = $request->hepler_name;
                $tripsheet->helper_mobile  = $request->helper_mobile;
                $tripsheet->start_km  = $request->start_km;
                $tripsheet->stop_km  = $request->stop_km;
                $tripsheet->total_km  = $request->total_km;
                $tripsheet->total_rent  = $request->total_rent;
                $tripsheet->destination  = $request->destination ;
                $tripsheet->diesel_amt  = $request->diesel_amt;
                $tripsheet->batha_amt  = $request->batha_amt;
                $tripsheet->phone_exp  = $request->phone_exp;
                $tripsheet->toll_expense  = $request->toll_expense;
                $tripsheet->food_amt  = $request->food_amt;
                $tripsheet->other_exp  = $request->other_exp;
                $tripsheet->expense_total  = $request->expense_total;
                $tripsheet->advance_amt  = $request->advance_amt;
                $tripsheet->balance_amount  = $request->balance_amount;
                $tripsheet->status  = $request->status;
                $tripsheet->status  = $request->status;

                $tripsheet->type  = $request->type;
                $tripsheet->vendor_id  = $request->vendor_id;
                $tripsheet->authorized_person  = $request->authorized_person;
                $tripsheet->mobile_number  = $request->mobile_number;
                $tripsheet->branch_id  = branch()->id;
               
                $tripsheet->save();

                \DB::commit();
            } catch (\Exception $e) {
    
                \DB::rollBack();
                Log::error($e->getMessage());
                toastr()->error($e->getMessage());
                return redirect()->back();
            }
    
            toastr()->success(section_title() . ' Added Successfully');
            return redirect()->to(index_url());

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $agencies = Agencies::all();
        // $drivers = Drivers::whereActive(true)->get(); 
        $vendors = Vendors::all();
        $vehicles = Vehicles::all();
        $tripsheet = Tripsheets::findOrFail($id);
        return view('branches.tripsheet.edit', compact('tripsheet', 'vendors', 'vehicles', 'agencies'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            \DB::beginTransaction();
            $tripsheet = Tripsheets::findOrFail($id);


            $tripsheet->trip_date  = $request->trip_date;
            $tripsheet->trip_time  = $request->trip_time;
            $tripsheet->estimate_arrival_date  = $request->estimate_arrival_date;
            $tripsheet->agency_id  = $request->agency_id;
            
            $tripsheet->hepler_name  = $request->hepler_name;
            $tripsheet->helper_mobile  = $request->helper_mobile;
            $tripsheet->start_km  = $request->start_km;
            $tripsheet->stop_km  = $request->stop_km;
            $tripsheet->total_km  = $request->total_km;
            $tripsheet->total_rent  = $request->total_rent;
            $tripsheet->destination  = $request->destination ;
            $tripsheet->diesel_amt  = $request->diesel_amt;
            $tripsheet->batha_amt  = $request->batha_amt;
            $tripsheet->phone_exp  = $request->phone_exp;
            $tripsheet->toll_expense  = $request->toll_expense;
            $tripsheet->food_amt  = $request->food_amt;
            $tripsheet->other_exp  = $request->other_exp;
            $tripsheet->expense_total  = $request->expense_total;
            $tripsheet->advance_amt  = $request->advance_amt;
            $tripsheet->balance_amount  = $request->balance_amount;
            $tripsheet->status  = $request->status;
            $tripsheet->type  = $request->type;
            if( $request->type == 'vehicle') {
                $tripsheet->vehicle_id  = $request->vehicle_id;
                $tripsheet->driver_name  = $request->driver_name;
                $tripsheet->driver_mobile  = $request->driver_mobile;

                $tripsheet->vendor_id  = NULL;
                $tripsheet->authorized_person  =NULL ;
                $tripsheet->mobile_number  = NULL ;

            } else {
                $tripsheet->vendor_id  = $request->vendor_id;
                $tripsheet->authorized_person  = $request->authorized_person;
                $tripsheet->mobile_number  = $request->mobile_number;

                $tripsheet->vehicle_id  = NULL; 
                $tripsheet->driver_name  = NULL; 
                $tripsheet->driver_mobile  = NULL; 
            }
            $tripsheet->branch_id  = branch()->id;           
            $tripsheet->save();

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tripsheet = Tripsheets::findOrFail($id); 
        $tripsheet->delete();
        toastr()->success(section_title() . ' Deleted Successfully');
        return redirect()->to(index_url());
    }

    public function cargos($tripsheet_id)
    {
        $goods = GoodsDetails::with('currentStatus')->where('trip_sheet_id', $tripsheet_id)->get();
        $goods_status = status_list_front();
        $tripsheet_id = $tripsheet_id;
        return view('branches.tripsheet.cargos', compact('goods', 'tripsheet_id', 'goods_status'));
     
    }
    

    public function updateStatus(Request $request) {   
       
        if(  $request->checkedArray != '') {
            $checkedArray =   explode(",", $request->checkedArray);
            if(!empty( $checkedArray )){
                foreach( $checkedArray as $invoice ) {
                    $invoice_arr = explode("-", $invoice);
                    $goods_id = $invoice_arr[1];
        
                    $goods = GoodsDetails::findOrFail( $goods_id );

                    // ADD ONE STATUS TO BOX STATUS TABLE FOR TRACKING PURPOSE
                    $bookings               = new BoxesStatuses();
                    $bookings->status_id    = $request->goods_status; 
                    $bookings->box_id       = $goods->box_id;
                    $bookings->created_at   =  date('Y-m-d');
                    $bookings->save();

                    $goods->current_status_id = $bookings->id;
                    $goods->save();
                }
                echo "<span style='color:green'>Goods Status Updated Successfully</span>";
            }
        } else {

                echo "<span style='color:red'>No Goods Selected</span>"; 
        }
         

    }  


    public function updateStatusSingle(Request $request) {   
       
        if(  $request->goods_id != '') { 
           
                   
                    $goods_id = $request->goods_id;
        
                    $goods = GoodsDetails::findOrFail( $goods_id );

                    // ADD ONE STATUS TO BOX STATUS TABLE FOR TRACKING PURPOSE
                    $bookings               = new BoxesStatuses();
                    $bookings->status_id    = $request->goods_status; 
                    $bookings->box_id       = $goods->box_id;
                    $bookings->created_at   =  date('Y-m-d');
                    $bookings->save();

                    $goods->current_status_id = $bookings->id;
                    $goods->save();
               
                echo "<span style='color:green'>Goods Status Updated Successfully</span>";
           
        } else {

                echo "<span style='color:red'>No Goods Selected</span>"; 
        }
    }  

    
    public function ajaxLoadupdate_lrNo(Request $request) {        
        $trip_sheet_id = $request->trip_sheet_id;
        $tripsheet_data = Tripsheets::select('url')->where('id',  $trip_sheet_id)->first();
        $html='';
        $checkValues = $request->checkValues;
        if(!empty( $checkValues)){
            $invoice_nos_lrno = GoodsDetails::whereIn('id', $checkValues )->get();
          
                $html = '<div>
                        <table style="width:100%">
                        <tr> 
                        <td  >Show Estimate Delivery Date: <input type="checkbox" name="estimateDelDate" id="estimateDelDate" class=""> <br></td>                        
                        </tr>
                        <tr>
                        <th>Url : <input type="text" id="url" name="url" class="form-control" placeholder="Please enter url.." value="'. $tripsheet_data->url.'"> </th>                        
                        </tr> 
                        <tr>
                        <th >Estimate Arrival Date : <input type="date" id="common_estimate_arrival_date" name="common_estimate_arrival_date" class="form-control" placeholder="Please Enter Estimate Delivery date.."> </th>                        
                        </tr> 
                        </table>
                        <table style="width:100%; margin-top:10px;">
                        <tr> 
                        <td><b>Invoice no</b></td>
                        <td><b>Lr No</b></td>
                        <td class="showEstimateDate"><b>Estimate Delivery Date</b></td>
                        <input name="sel_tripsheet_id_lr" id="sel_tripsheet_id_lr"  value="'.$trip_sheet_id.'" type="hidden">
                        </tr>';
 
                foreach( $invoice_nos_lrno as $val) { 
                    
                    $esimate_date = !empty($val->estimate_arrival_date)?date('Y-m-d', strtotime($val->estimate_arrival_date)):"";
                   

                    $html .=  '<tr> 
                                <td>   <input type="text" name="invoice_no[]" value="'.$val->invoice_number.'" class="form-control invoice_no" readonly> </td>
                                <td> <input type="text" name="lr_no[]" class="form-control lr_no" value="'.$val->lr_no.'" >                                
                                <input type="hidden" class="form-control goods_id" name="goods_id[]" value="'.$val->id.'"> </td>
                                <td  class="showEstimateDate"> 
                                     <input type="date" class="form-control estimate_arrival_date" name="estimate_arrival_date[]" value="'.$esimate_date.'">                                  
                                 </td>
                                </tr>'; 
                }

                $html .=  '</table>
                            </div>'; 
                echo  $html;   
        }
        else {
            $html='<span style="color:red; font-size:18px;font-weight:bold;">Please select goods !!</span>';
            echo  $html; 
        }
    }  



    public function ajaxUpdateLrNo(Request $request) {     
        
        $invoice_no_arr         = $request->invoice_array;
        $goods_id_array         = $request->goods_id_array;
        $sel_tripsheet_id_lr    = $request->sel_tripsheet_id_lr;        
        $common_date            = false; 

        if( $request->common_estimate_arrival_date !='') {
            $common_date                    = true; 
            $common_estimate_arrival_date   = $request->common_estimate_arrival_date;
        } else {
            $estimate_arrival_date  = $request->estimate_arrival_date_array;
        }
       
        $lr_no_arr      = $request->lr_no_array;        
        $tripsheet      = Tripsheets::findOrFail( $sel_tripsheet_id_lr );
        $tripsheet->url = $request->url;
        $tripsheet->save();

         foreach( $invoice_no_arr as $key => $val) {
            $url            = $request->url; 
            $invoice_no     = $val;
            $newUrl         = $url.$lr_no_arr[$key]; 

            $goods_details = GoodsDetails::where('id', $goods_id_array[$key] )->first(); 
		
            if( $common_date ){
                $goods_details->tracking_url            = $newUrl;
                $goods_details->lr_no                   = $lr_no_arr[$key];
                $goods_details->docket                   = $lr_no_arr[$key];
                $goods_details->estimate_arrival_date   = $common_estimate_arrival_date;
                $goods_details->save();
                                
            } else {

                $goods_details->tracking_url            = $newUrl;
                $goods_details->docket                   = $lr_no_arr[$key];
                $goods_details->lr_no                   = $lr_no_arr[$key];
                $goods_details->estimate_arrival_date   = $estimate_arrival_date[$key];
                $goods_details->save();

            }  
         }  
 
         
         $html='<span style="color:red; font-size:18px;font-weight:bold;">Successfully Updated !!</span>';
         echo  $html; 


    }

    


    
}
