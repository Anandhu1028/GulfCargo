<?php

namespace App\Http\Controllers\Branch;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Agencies;
use App\Models\Branches;
use App\Models\Countries;
use App\Models\Customers;
use App\Models\Statuses;
use App\Models\ShipTypes;
use App\Models\Drivers;
use App\Models\Staffs;
use App\Models\States;
use App\Models\Cities;
use App\Models\Moving;
use App\Models\MovingTypes;
use App\Models\MovingItems;
use App\Models\MovingDismantling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;



class MovingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
 
        $movings = Moving::latest()->orderBy('id', 'desc')->get();
        return view('branches.moving.index', compact('movings'));
 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $agencies = Agencies::whereActive(true)->get();
        $branches = Branches::all();
        $drivers = Drivers::whereActive(true)->get();
        $staffs = Staffs::notadmin()->get();  
        $movingTypes = MovingTypes::whereStatus(true)->get();

        
        $cities_in_uae = Cities::where('country_id', '231')->get();   
        $countries = Countries::all();
        $previous_booking = Moving::orderBy('id', 'desc')->first();  

        $previous_sender = Customers::where('type','sender')->orderBy('id', 'desc')->first(); 
        $previous_sender_state = States::where('country_id',  $previous_sender->address->country_id)->get();
        $previous_sender_city = Cities::where('state_id', $previous_sender->address->state_id )->get();
        $prev_sender_phon_length =Countries::select('phone_no_length')->where('id',  $previous_sender->address->country_id )->first();

        
 
        // $nextBookingNumber = branch()->branch_code;
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
 
        
        return view('branches.moving.create', compact('agencies','movingTypes', 'previous_sender','previous_sender_state', 'previous_sender_city', 'prev_sender_phon_length', 'previous_booking', 'countries', 'cities_in_uae',  'nextBookingNumber','drivers', 'bookingNum' , 'staffs', 'branches' ));

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
         
        $moving = new Moving();

        $moving->moving_number =  $request->moving_number;
        $moving->branch_id = $request->branch_id;
        $moving->sender_id = $request->sender_id;
        $moving->source_city = $request->source_city;
        $moving->destination_city = $request->destination_city;
        // $moving->agency_id = $request->agency_id;
        $moving->shiping_method = "shiping_method"; //$request->shiping_method;
        $moving->payment_method = $request->payment_method;
        $moving->status_id = $request->status_id;
        $moving->created_date = $request->created_date;
        $moving->collected_by = $request->collected_by;
        $moving->driver_id = $request->driver_id;
        $moving->delivery_type = $request->delivery_type;
        $moving->total_amount = $request->total_amount;
        $moving->total_discount = $request->total_discount;
        $moving->time = $request->time;
        $moving->total = $request->total;
        $moving->moving_type = $request->moving_type;            

        
        $moving->save();

        if(!empty($request->description)) {
            for ($i = 0; $i < count($request->description); $i++) {
                $moving_items = new MovingItems();
                $moving_items->moving_id  =  $moving->id;
                $moving_items->description = $request->description[$i];
                $moving_items->qty = $request->qty[$i];
                $moving_items->save();


            }

            for ($i = 0; $i < count($request->dis_description); $i++) {
                $moving_items = new MovingDismantling();
                $moving_items->description = $request->dis_description[$i];
                $moving_items->moving_id  =  $moving->id;
                $moving_items->qty = $request->dis_qty[$i];
                $moving_items->save();

            } 
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
     * Display the specified resource.
     *
     * @param  \App\Models\Moving  $moving
     * @return \Illuminate\Http\Response
     */
    public function show(Moving $moving)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Moving  $moving
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $moving = Moving::findOrFail($id); 
        $agencies = Agencies::whereActive(true)->get();
        $branches = Branches::all();
        $drivers = Drivers::whereActive(true)->get();
        $staffs = Staffs::notadmin()->get();  
        $countries = Countries::all();
        $movingTypes = MovingTypes::whereStatus(true)->get();



        $previous_sender = Customers::where('type','sender')->orderBy('id', 'desc')->first(); 
        $previous_sender_state = States::where('country_id',  $previous_sender->address->country_id)->get();
        $previous_sender_city = Cities::where('state_id', $previous_sender->address->state_id )->get();
        $prev_sender_phon_length =Countries::select('phone_no_length')->where('id',  $previous_sender->address->country_id )->first();


        
        $cities_in_uae = Cities::where('country_id', '231')->get();   
       

        $items = MovingItems::where('moving_id', $id)->get();
        $dis_items = MovingDismantling::where('moving_id', $id)->get();

        return view('branches.moving.edit', compact('agencies','movingTypes', 'previous_sender','previous_sender_state', 'previous_sender_city', 'prev_sender_phon_length',  'countries', 'moving', 'items', 'dis_items',  'cities_in_uae',  'drivers', 'staffs', 'branches' ));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Moving  $moving
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            \DB::beginTransaction();
            $moving = Moving::findOrFail($id);


            $moving->moving_number =  $request->moving_number;
            $moving->branch_id = $request->branch_id;
            $moving->sender_id = $request->sender_id;
            $moving->source_city = $request->source_city;
            $moving->destination_city = $request->destination_city;
            // $moving->agency_id = $request->agency_id;
            $moving->shiping_method = "shiping_method"; //$request->shiping_method;
            $moving->payment_method = $request->payment_method;
            $moving->status_id = $request->status_id;
            $moving->created_date = $request->created_date;
            $moving->collected_by = $request->collected_by;
            $moving->driver_id = $request->driver_id;
            $moving->delivery_type = $request->delivery_type;
            $moving->total_amount = $request->total_amount;
            $moving->total_discount = $request->total_discount;
            $moving->total = $request->total;
            $moving->time = $request->time;
            $moving->moving_type = $request->moving_type;            



            $moving->save(); 

            

            MovingItems::where('moving_id', $moving->id)->delete();
            MovingDismantling::where('moving_id', $moving->id)->delete();

        if(!empty($request->description)) {
            for ($i = 0; $i < count($request->description); $i++) {
                $moving_items = new MovingItems();
                $moving_items->moving_id  =  $moving->id;
                $moving_items->description = $request->description[$i];
                $moving_items->qty = $request->qty[$i];
                $moving_items->save();
    
    
            }
    
            for ($i = 0; $i < count($request->dis_description); $i++) {
                $moving_items = new MovingDismantling();
                $moving_items->description = $request->dis_description[$i];
                $moving_items->moving_id  =  $moving->id;
                $moving_items->qty = $request->dis_qty[$i];
                $moving_items->save();
    
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
     * @param  \App\Models\Moving  $moving
     * @return \Illuminate\Http\Response
     */
    public function destroy(Moving $moving)
    {
        //
    }
}
