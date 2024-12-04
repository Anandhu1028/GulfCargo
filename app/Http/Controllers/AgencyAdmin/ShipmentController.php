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
use App\Models\Boxes;
use App\Models\Drivers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ShipmentController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('keyword') != "") {
            $keyword = $request->keyword;
            $client_ids = Customers::where("phone", "like", "%$keyword%")
                ->orWhere("identification_number", "like", "%$keyword%")
                ->get()
                ->pluck('id');

            $shipments = Shipments::with('driver')->query();
            if (count($client_ids) > 0) {
                $shipments = $shipments->whereIn("sender_id", $client_ids);
            }
            $shipments = $shipments->orWhere('booking_number', 'like', '%' . $keyword . '%');
            // $shipments = $shipments->where('branch_id', branch()->id);

            $shipments = $shipments->orderBy('created_at', 'desc')->get();
            
        } else {
            // $shipments = Shipments::latest()->where('branch_id', branch()->id)->orderBy('created_at', 'desc')->get();
            $shipments = Shipments::with('driver')->latest()->orderBy('created_at', 'desc')->get();
        }


        return view('agencyadmin.shipments.index', compact('shipments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $agencies = Agencies::whereActive(true)->get();
        $drivers = Drivers::whereActive(true)->get();

        $countries =  Countries::all(); 

        // $nextBookingNumber = branch()->branch_code;
        $shipment  =   Shipments::select('booking_number')->orderBy('id', 'desc')->first();
        $nextBookingNumber = agency_branch()->branch_code?agency_branch()->branch_code.$shipment->id+10000 :$shipment->id+10000;
         
        return view('agencyadmin.shipments.create', compact('agencies', 'countries','nextBookingNumber','drivers'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        // $request->validate([
        //     'booking_number' => 'required|unique:shipments',
        //     'status_id' => 'required' 
        // ]); 

        try {
            \DB::beginTransaction();
            $shipments = new Shipments();
            $shipments->booking_number = $request->booking_number;
            $shipments->agency_id = $request->agency_list;
            $shipments->sender_id = $request->sender_id;
            $shipments->receiver_id = $request->receiver_id;
            $shipments->receipt_number = $request->receipt_number;
            $shipments->packing_type = $request->packing_type;
            $shipments->courier_company = $request->courier_company;            
            $shipments->shiping_method = $request->shiping_method; 
            $shipments->created_date = $request->created_date; 

            


            $shipments->payment_method = $request->payment_method;
            $shipments->number_of_pcs = $request->number_of_pcs;
            $shipments->status_id = $request->status_id;

            $shipments->driver_id = $request->driver_id;
            $shipments->lrl_tracking_code = $request->lrl_tracking_code;

            $shipments->created_by = $request->user()->id;
            $shipments->shiping_date = date("Y-m-d");
            $shipments->branch_id = agency_branch()->id;
            
           
            
            // $shipments->barcode = $request->barcode;
            // $shipments->prev_branch_id = $request->prev_branch_id;
            // $shipments->created_by = $request->user()->id;
            // $shipments->packing_charge = $request->packing_charge;
            // $shipments->other_charges = $request->other_charges;
            // $shipments->discount = $request->discount;

            // $shipments->total_weight = $request->total_weight;
            // $shipments->msic_weight = $request->msic_weight;
            // $shipments->grand_total_box_value = $request->grand_total_box_value;
            // $shipments->total_freight = $request->total_freight;
            // $shipments->misc_freight = $request->misc_freight;
            // $shipments->document_charge = $request->document_charge;
            // $shipments->grand_total = $request->grand_total;
            // $shipments->package_total_amount = $request->package_total_amount;
            // $shipments->package_total_quantity = $request->package_total_quantity;

 
            $shipments->save();
            $status = Statuses::find($request->status_id);
            $shipments->status()->attach($status);


            

            // for ($i = 0; $i < $request->number_of_pcs; $i++) {
            //     $j= $i+1;
            //     $box = new Boxes();
            //     $box->shipment_id = $shipments->id;
            //     $box->length = $request->input("length".$j);
            //     $box->width = $request->input("width".$j);
            //     $box->height = $request->input("height".$j);
            //     $box->weight = $request->input("weight".$j);
            //     $box->unit_value = $request->input("unit_value".$j);
            //     $box->total_value = $request->input("total_value".$j);                
            //     $box->save();
            // }

            // $box_ids = Boxes::where('shipment_id',$shipments->id)->get()->pluck('id');
            
            // $p = 0;
            // foreach( $box_ids as  $key => $id ){
            //     $p = $p +1;
            //     for ($k = 0; $k <  count($request->input("description".$key+1) ); $k++) {
            //         $package = new Packages();
            //         $package->shipment_id = $shipments->id;
            //         $package->branch_id = $shipments->branch_id;
            //         $package->box_id = $id;
            //         $package->description = $request->input("description".$p)[$k];
            //         $package->quantity = $request->input("qty".$p)[$k];
            //         $package->unit_price = $request->input("unit".$p)[$k];
            //         $package->subtotal =$request->input("subtotal".$p)[$k];
            //         $package->save();  
            //     }
            // }
            
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
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $shipment = Shipments::with('driver')->findOrFail($id);
        return view('agencyadmin.shipments.show', compact('shipment'));
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

        if($shipment->branch_id != agency_branch()->id) {
            toastr()->error(section_title() . 'No permission to view other branches');
            return redirect()->to(index_url());
        }
        $boxes = Boxes::with('packages')->where('shipment_id', $id)->get();

        $agencies = Agencies::all();
        $origin_offices = Branches::all();
        $countries = Countries::all();
        $drivers = Drivers::whereActive(true)->get();
        return view('agencyadmin.shipments.edit', compact('shipment','boxes', 'agencies', 'origin_offices', 'countries','drivers'));

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
            $shipments->agency_id = $request->agency_list;
            $shipments->sender_id = $request->sender_id;
            $shipments->receiver_id = $request->receiver_id;
            $shipments->receipt_number = $request->receipt_number;
            $shipments->packing_type = $request->packing_type;
            $shipments->courier_company = $request->courier_company;            
            $shipments->shiping_method = $request->shiping_method;
            $shipments->payment_method = $request->payment_method;
            $shipments->number_of_pcs = $request->number_of_pcs;
            $shipments->status_id = $request->status_id;
            $shipments->driver_id = $request->driver_id;
            $shipments->lrl_tracking_code = $request->lrl_tracking_code;
            $shipments->created_by = $request->user()->id;
            $shipments->shiping_date = date("Y-m-d");
            $shipments->branch_id = agency_branch()->id;
            $shipments->created_date = $request->created_date; 

            $shipments->barcode = $request->barcode;
            $shipments->prev_branch_id = $request->prev_branch_id;
            $shipments->created_by = $request->user()->id;
            $shipments->packing_charge = $request->packing_charge;

            $shipments->other_charges = $request->other_charges;
            $shipments->discount = $request->discount;
            $shipments->total_weight = $request->total_weight;
            $shipments->msic_weight = $request->msic_weight;
            $shipments->grand_total_box_value = $request->grand_total_box_value;
            $shipments->total_freight = $request->total_freight;
            $shipments->misc_freight = $request->misc_freight;
            $shipments->document_charge = $request->document_charge;
            $shipments->grand_total = $request->grand_total;
            $shipments->package_total_amount = $request->package_total_amount;
            $shipments->package_total_quantity = $request->package_total_quantity;

            $shipments->save(); 

            $status = Statuses::find($request->status_id);
            $shipments->status()->attach($status); 
           
 
            $box_ids = Boxes::where('shipment_id',$shipments->id)->get()->pluck('id');

            for ($i = 0; $i < count($box_ids); $i++) {
                $j= $i+1;
                $box = Boxes::findOrFail( $request->input("box_id".$j));
                $box->shipment_id = $shipments->id;
                $box->length = $request->input("length".$j);
                $box->width = $request->input("width".$j);
                $box->height = $request->input("height".$j);
                $box->weight = $request->input("weight".$j);
                $box->unit_value = $request->input("unit_value".$j);
                $box->total_value = $request->input("total_value".$j);                
                $box->save();
            }

            $p = 0;
            foreach( $box_ids as  $key => $id ){    

                Packages::where('box_id', $id)->delete();
                $p = $p +1;               
                if(!empty( $request->input("description".$p) )) {
                    for ($k = 0; $k <  count($request->input("description".$p) ); $k++) {                        
                        $package = new Packages();
                        $package->shipment_id = $shipments->id;
                        $package->branch_id = $shipments->branch_id;
                        $package->box_id = $id;

                        $package->description = $request->input("description".$p)[$k];
                        $package->quantity = $request->input("qty".$p)[$k];
                        $package->unit_price = $request->input("unit".$p)[$k];
                        $package->subtotal =$request->input("subtotal".$p)[$k];
                        if( !empty($request->input("description".$p)[$k])  &&  !empty($request->input("qty".$p)[$k]) && !empty( $request->input("unit".$p)[$k])){
                            $package->save();
                        }
                    }
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


    public function createadditems($id)
    {
        $shipment = Shipments::with('driver')->findOrFail($id); 
        if($shipment->branch_id != agency_branch()->id) {
            toastr()->error(section_title() . 'No permission to view other branches');
            return redirect()->to(index_url());
        }
        $box = Boxes::with('packages')->where('shipment_id', $id)->get();
        $agencies = Agencies::all();
        $origin_offices = Branches::all();
        $countries = Countries::all();
        $drivers = Drivers::whereActive(true)->get();
      
        return view('agencyadmin.shipments.createadditems', compact('shipment', 'box', 'agencies', 'origin_offices', 'countries','drivers'));
    }



    public function additemsstore(Request $request)
    {
 
        // $request->validate([
        //     'booking_number' => 'required|unique:shipments',
        //     'status_id' => 'required',
        // //     'sender_id' => 'required',
        // //     'receiver_id' => 'required'
        // ]); 
 
        try {
            \DB::beginTransaction();
            $shipments = Shipments::findOrFail( $request->shipment_id ); 
            $shipments->booking_number = $request->booking_number;
            $shipments->agency_id = $request->agency_list;
            $shipments->sender_id = $request->sender_id;
            $shipments->receiver_id = $request->receiver_id;
            $shipments->receipt_number = $request->receipt_number;
            $shipments->packing_type = $request->packing_type;
            $shipments->courier_company = $request->courier_company;            
            $shipments->shiping_method = $request->shiping_method;


            $shipments->payment_method = $request->payment_method;
            $shipments->number_of_pcs = $request->number_of_pcs;
            $shipments->status_id = $request->status_id;

            $shipments->driver_id = $request->driver_id;
            $shipments->lrl_tracking_code = $request->lrl_tracking_code;

            $shipments->created_by = $request->user()->id;
            $shipments->shiping_date = date("Y-m-d");
            $shipments->branch_id = agency_branch()->id; //$request->branch_id;
            
           
            
            $shipments->barcode = $request->barcode;
            $shipments->prev_branch_id = $request->prev_branch_id;
            $shipments->created_by = $request->user()->id;
            $shipments->packing_charge = $request->packing_charge;
            $shipments->other_charges = $request->other_charges;
            $shipments->discount = $request->discount;

            $shipments->total_weight = $request->total_weight;
            $shipments->msic_weight = $request->msic_weight;
            $shipments->grand_total_box_value = $request->grand_total_box_value;
            $shipments->total_freight = $request->total_freight;
            $shipments->misc_freight = $request->misc_freight;
            $shipments->document_charge = $request->document_charge;
            $shipments->grand_total = $request->grand_total;
            $shipments->package_total_amount = $request->package_total_amount;
            $shipments->package_total_quantity = $request->package_total_quantity;

 
            $shipments->save();
            $status = Statuses::find($request->status_id);
            $shipments->status()->attach($status);

            for ($i = 0; $i < $request->number_of_pcs; $i++) {
                $j= $i+1;
                $box = new Boxes();
                $box->shipment_id = $shipments->id;
                $box->length = $request->input("length".$j);
                $box->width = $request->input("width".$j);
                $box->height = $request->input("height".$j);
                $box->weight = $request->input("weight".$j);
                $box->unit_value = $request->input("unit_value".$j);
                $box->total_value = $request->input("total_value".$j);                
                $box->save();
            }

            $box_ids = Boxes::where('shipment_id',$shipments->id)->get()->pluck('id');
            
            $p = 0;
            foreach( $box_ids as  $key => $id ){
                $p = $p +1;
                if(!empty( $request->input("description".$p) )) {
                    for ($k = 0; $k <  count($request->input("description".$p) ); $k++) {                        
                        $package = new Packages();
                        $package->shipment_id = $shipments->id;
                        $package->branch_id = $shipments->branch_id;
                        $package->box_id = $id;

                        $package->description = $request->input("description".$p)[$k];
                        $package->quantity = $request->input("qty".$p)[$k];
                        $package->unit_price = $request->input("unit".$p)[$k];
                        $package->subtotal =$request->input("subtotal".$p)[$k];
                        if( !empty($request->input("description".$p)[$k])  &&  !empty($request->input("qty".$p)[$k]) && !empty( $request->input("unit".$p)[$k])){
                            $package->save();
                        }
                    }
                }

            }


            if ($shipments->receiver) {
                $message_receiver = "Dear " . $shipments->receiver->name . ",
            Thank you for choosing Best Express Cargo!
            Your shipment SD# $shipments->booking_number has been booked!. Please share your valuable feedback
             Weblink:https://bestexpresscargo.com/";
              $phone = !empty($shipments->receiver->whatsapp_number) ? $shipments->receiver->country_code_whatsapp.$shipments->receiver->whatsapp_number :$shipments->receiver->country_code.$shipments->receiver->phone;
                send_message($phone, $message_receiver);
          
            }

            if ($shipments->sender) {
                $message_sender = "Dear " . $shipments->sender->name . ",
            Thank you for choosing Best Express Cargo!
            Your shipment SD# $shipments->booking_number has been booked!. Please share your valuable feedback
             Weblink: https://bestexpresscargo.com/";
              $phone = !empty($shipments->sender->whatsapp_number) ? $shipments->sender->country_code_whatsapp.$shipments->sender->whatsapp_number :$shipments->sender->country_code.$shipments->sender->phone;
                send_message($phone, $message_sender);
          
            }
            
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
        $shipment = Shipments::with('boxes')->with('packages')->with('receiver')->with('sender')->findOrFail($id); 
        return view('agencyadmin.shipments.printview', compact('shipment'));
    }

    public function printall(Request $request){
       
            $shipments = Shipments::with('boxes')->with('packages')->with('receiver')->with('sender')->whereIn('id', $request->booking_ids)->get();  
            return view('agencyadmin.shipments.printviewall', compact('shipments'));
        
        
    }
    
}
