<?php

namespace App\Http\Controllers\Branch;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Agencies;
use App\Models\Branches; 
use App\Models\Vendors; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;   
use Illuminate\Support\Collection;
use DataTables;

class VendorController extends BaseController
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
 

    public function getVendorDetailsById(Request $request)
    {        
        $vendors = Vendors::findOrFail($request->vendor_id);
        return response()->json($vendors);  

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
