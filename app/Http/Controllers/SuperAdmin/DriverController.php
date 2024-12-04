<?php

namespace App\Http\Controllers\SuperAdmin;


use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Drivers;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\UploadedFile;
use App\Http\Requests\StoreFileRequest;


use DB;

class DriverController extends BaseController
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
        $drivers = Drivers:: orderBy('id', 'DESC')
                            ->get();

        return view('superadmin.driver.index', compact('drivers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permission = Permission::get();
        return view('superadmin.driver.create', compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $driver = new Drivers();
        if (Drivers::where('vehicle_number', '=', $request->vehicle_number)->first() != null) {
            toastr()->error('vehicle number already exists');
            return redirect()->back();
        }
        if (User::where('email', '=', $request->email)->first() != null) {
            toastr()->error('Email already exists');
            return redirect()->back();
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        $driver->user_id = $user->id;
        $driver->name = $request->name;
        $driver->mobile = $request->mobile;
        // $driver->email = $request->email;
        $driver->location = $request->location;
        $driver->vehicle_number = $request->vehicle_number;
        $driver->branch_id = $request->branch_id;
        $driver->created_by = $request->user()->id;
        $driver->save();

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
        $role = Drivers::find($id);
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $id)
            ->get();

        return view('superadmin.roles.show', compact('role', 'rolePermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $driver = Drivers::find($id);
        return view('superadmin.driver.edit', compact('driver'));
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
            'email' => 'required',
        ]);

        if (User::where('email', '=', $request->email)->where('id', '!=', $request->user_id )->first() != null) {
            toastr()->error('Email already exists');
            return redirect()->back();
        }

        $user = User::find($request->user_id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();


        $driver = Drivers::find($id);

        $driver->user_id = $user->id;
        $driver->name = $request->name;
        $driver->mobile = $request->mobile;
        $driver->location = $request->location;
        $driver->vehicle_number = $request->vehicle_number;
        $driver->branch_id = $request->branch_id;
        $driver->created_by = $request->user()->id;
        $driver->save();

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
        DB::table("drivers")->where('id', $id)->delete();
        toastr()->success(section_title() . ' Deleted Successfully');
        return redirect()->to(index_url());
    }


}
