<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Branches;
use App\Models\ShipTypes;
use Illuminate\Http\Request;  


class ShipTypeController extends BaseController
{
    
    public function index(){

        $ship_type = ShipTypes::orderBy("name", "asc")->get();
        return view('superadmin.shiptype.index',compact('ship_type'));
    }

    public function create(){
        return view('superadmin.shiptype.create');
    }
    
    public function store(Request $request){
        
        $ship_type = new ShipTypes();
        $ship_type->name = $request->name;
        $ship_type->value = $request->value;      
        $ship_type->driver_rate = $request->driver_rate;      
        $ship_type->office_rate = $request->office_rate;      
        $ship_type->save();
       
        toastr()->success(section_title() . ' Created Successfully');
        return redirect()->to(index_url());
    }

    public function show($id){
        
    }

    public function edit($id){

        $ship_type = ShipTypes::findOrFail($id);         
        return view('superadmin.shiptype.edit', compact('ship_type'));
        
    }    
    
    public function update(Request $request, $id){
        
        $ship_type = ShipTypes::findOrFail($id);  
        $ship_type->name = $request->name;
        $ship_type->value = $request->value;   
        $ship_type->driver_rate = $request->driver_rate;      
        $ship_type->office_rate = $request->office_rate;         
        $ship_type->save();
       
        toastr()->success(section_title() . ' Updated Successfully');
        return redirect()->to(index_url());
    }

    public function destroy($id){
        $ship_type = ShipTypes::findOrFail($id); 
        $ship_type->delete();
        toastr()->success(section_title() . ' Deleted Successfully');
        return redirect()->to(index_url());
    }
}
