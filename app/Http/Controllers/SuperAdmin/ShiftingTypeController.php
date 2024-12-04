<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Branches;
use App\Models\ShiftingTypes;
use Illuminate\Http\Request;  


class ShiftingTypeController extends BaseController
{
    
    public function index(){

        $shifting_type = ShiftingTypes::orderBy("name", "asc")->get();
        return view('superadmin.shiftingtype.index',compact('shifting_type'));
    }

    public function create(){
        return view('superadmin.shiftingtype.create');
    }
    
    public function store(Request $request){
        
        $shifting_type = new ShiftingTypes();
        $shifting_type->name = $request->name;   
        $shifting_type->save();
       
        toastr()->success(section_title() . ' Created Successfully');
        return redirect()->to(index_url());
    }

    public function show($id){
        
    }

    public function edit($id){

        $shifting_type = ShiftingTypes::findOrFail($id);         
        return view('superadmin.shiftingtype.edit', compact('shifting_type'));
        
    }    
    
    public function update(Request $request, $id){
        
        $shifting_type = ShiftingTypes::findOrFail($id);  
        $shifting_type->name = $request->name;     
        $shifting_type->save();
       
        toastr()->success(section_title() . ' Updated Successfully');
        return redirect()->to(index_url());
    }

    public function destroy($id){
        $shifting_type = ShiftingTypes::findOrFail($id); 
        $shifting_type->delete();
        toastr()->success(section_title() . ' Deleted Successfully');
        return redirect()->to(index_url());
    } 
    
}
