<?php

namespace App\Http\Controllers\Branch;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Agencies;
use App\Models\Branches;
use App\Models\Drivers; 
use App\Models\Vehicles; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;   
use Illuminate\Support\Collection;
use DataTables;

class DriverController extends BaseController
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
         
       
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getVehicleDetails(Request $request)
    {
        $driver = Drivers::findOrFail($request->id);  
        return view('branches.ships.driver_details', compact('driver' ));

    }

    public function getDriverDetails(Request $request)
    {        
        $driver = Drivers::findOrFail($request->driver_id);
        return response()->json($driver);

        return view('branches.ships.driver_details', compact('driver' ));

    }

    public function getVechileDetailsById(Request $request)
    {        
        $vehicle = Vehicles::findOrFail($request->vehicle_id);
        return response()->json($vehicle);  

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

    
}
