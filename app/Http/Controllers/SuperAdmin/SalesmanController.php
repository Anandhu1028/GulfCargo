<?php

namespace App\Http\Controllers\SuperAdmin;


use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Salesman;
use App\Models\Vehicles;
use App\Models\Drivers;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\UploadedFile;
use App\Http\Requests\StoreFileRequest;

 
use DB;

class SalesmanController extends BaseController
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
        $salesman = Salesman::orderBy('id', 'DESC')
                            ->get(); 
        return view('superadmin.salesman.index', compact('salesman'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vehicles = Vehicles::all();
        $drivers = Drivers::all();

        
        return view('superadmin.salesman.create', compact('vehicles', 'drivers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        $salesman = new Salesman();
        // if (Salesman::where('name', '=', $request->name)->first() != null) {
        //     toastr()->error('vehicle number already exists');
        //     return redirect()->back();
        // }       
 
        $salesman->name = $request->name;
        $salesman->route = $request->route;
        $salesman->vehicle_id = $request->vehicle_id;  
        $salesman->driver_id = $request->driver_id;  
        $salesman->save();
        
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
        $vehicles = Vehicles::all();
        $drivers = Drivers::all();

        $salesman = Salesman::find($id);         
        return view('superadmin.salesman.edit', compact('salesman','vehicles', 'drivers'));
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
  
        $salesman = Salesman::find($id);

        $salesman->name = $request->name;
        $salesman->route = $request->route;
        $salesman->vehicle_id = $request->vehicle_id;  
        $salesman->driver_id = $request->driver_id;  
        $salesman->save();

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
        $salesman = Salesman::findOrFail($id); 
        $salesman->delete();
        toastr()->success(section_title() . ' Deleted Successfully');
        return redirect()->to(index_url());
    }

    
}
