<?php

namespace App\Http\Controllers\SuperAdmin;


use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Vehicles;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\UploadedFile;
use App\Http\Requests\StoreFileRequest;

 
use DB;

class VehicleController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
    
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehicles = Vehicles:: orderBy('id', 'DESC')
                            ->get();

        return view('superadmin.vehicle.index', compact('vehicles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permission = Permission::get();
        return view('superadmin.vehicle.create', compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        $vehicle = new Vehicles();
        if (Vehicles::where('vehicle_no', '=', $request->vehicle_no)->first() != null) {
            toastr()->error('vehicle number already exists');
            return redirect()->back();
        }       
 
        $vehicle->name = $request->name;
        $vehicle->driver_name = $request->driver_name;
        $vehicle->driver_mobile = $request->driver_mobile;
        $vehicle->reg_date = $request->reg_date;
        $vehicle->reg_expiry = $request->reg_expiry;
        $vehicle->next_passing = $request->next_passing;
        $vehicle->sticker_permission_expiry = $request->sticker_permission_expiry;
        $vehicle->insurance_expiry = $request->insurance_expiry;
        $vehicle->traffic_no = $request->traffic_no;
        $vehicle->gps_permit_expiry = $request->gps_permit_expiry;
        $vehicle->vehicle_no = $request->vehicle_no;
        $vehicle->status = $request->status;          
        $vehicle->save();
        
        toastr()->success(section_title() . ' Created Successfully');
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
        // $role = Vehicles::find($id);
        // $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
        //     ->where("role_has_permissions.role_id", $id)
        //     ->get();

        // return view('superadmin.roles.show', compact('role', 'rolePermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vehicle = Vehicles::find($id);         
        return view('superadmin.vehicle.edit', compact('vehicle'));
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
        $this->validate($request, [
            'name' => 'required', 
        ]);
  
        $vehicle = Vehicles::find($id);

        $vehicle->name = $request->name;
        $vehicle->driver_name = $request->driver_name;
        $vehicle->driver_mobile = $request->driver_mobile;
        $vehicle->reg_date = $request->reg_date;
        $vehicle->reg_expiry = $request->reg_expiry;
        $vehicle->next_passing = $request->next_passing;
        $vehicle->sticker_permission_expiry = $request->sticker_permission_expiry;
        $vehicle->insurance_expiry = $request->insurance_expiry;
        $vehicle->traffic_no = $request->traffic_no;
        $vehicle->gps_permit_expiry = $request->gps_permit_expiry;
        $vehicle->vehicle_no = $request->vehicle_no;
        $vehicle->status = $request->status;          
        $vehicle->save(); 

        toastr()->success(section_title() . ' Updated Successfully');
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
        $vehicle = Vehicles::findOrFail($id); 
        $vehicle->delete();
        toastr()->success(section_title() . ' Deleted Successfully');
        return redirect()->to(index_url());
    }

    
}
