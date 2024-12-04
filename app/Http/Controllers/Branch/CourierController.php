<?php

namespace App\Http\Controllers\Branch;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
use App\Models\Couriers;
use App\Models\CourierItems;   
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class CourierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $couriers = Couriers::latest()->orderBy('id', 'desc')->get();
        return view('branches.courier.index', compact('couriers'));
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
        $staffs = Staffs::where('role', '!=', 'admin')->get();  
        
        $cities_in_uae = Cities::where('country_id', '231')->get();   
        $countries = Countries::all();
        $previous_booking = Couriers::orderBy('id', 'desc')->first();  

        $previous_sender = Customers::where('type','sender')->orderBy('id', 'desc')->first(); 
        $previous_sender_state = States::where('country_id',  $previous_sender->address->country_id)->get();
        $previous_sender_city = Cities::where('state_id', $previous_sender->address->state_id )->get();
        $prev_sender_phon_length =Countries::select('phone_no_length')->where('id',  $previous_sender->address->country_id )->first();

        
 
        // $nextBookingNumber = branch()->branch_code;
        $courier  =   Couriers::select('id','courier_number')->orderBy('id', 'desc')->first();  
        if(!empty($courier)){
            $bookingNum = $courier->id+10000;  
            $nextBookingNumber = branch()->branch_code ? "COR".branch()->branch_code.$courier->id+10000 : $courier->id+10000;
        }       
        else{
            // $moving =10000;
            $bookingNum = 10000;  
            $nextBookingNumber = branch()->branch_code ? "COR".branch()->branch_code.$bookingNum : $bookingNum;

        }
 
        
        return view('branches.courier.create', compact('agencies', 'previous_sender','previous_sender_state', 'previous_sender_city', 'prev_sender_phon_length', 'previous_booking', 'countries', 'cities_in_uae',  'nextBookingNumber','drivers', 'bookingNum' , 'staffs', 'branches' ));

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
         
                    $courier = new Couriers(); 

                    $courier->courier_number =  $request->courier_number;
                    $courier->branch_id = $request->branch_id;
                    $courier->sender_id = $request->sender_id;
                    $courier->source_city = $request->source_city;
                    $courier->destination_city = $request->destination_city;
                    $courier->payment_method = $request->payment_method;
                    $courier->status_id = $request->status_id;
                    $courier->created_date = $request->created_date;
                    $courier->collected_by = $request->collected_by;
                    $courier->driver_id = $request->driver_id; 
                    $courier->time = $request->time;
                    $courier->save();

                    if(!empty($request->description)) {
                        for ($i = 0; $i < count($request->description); $i++) {
                            $courier_items = new CourierItems();
                            $courier_items->courier_id  =  $courier->id;
                            $courier_items->description = $request->description[$i];
                            $courier_items->weight = $request->weight[$i];
                            $courier_items->qty = $request->qty[$i];
                            $courier_items->save();  
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
