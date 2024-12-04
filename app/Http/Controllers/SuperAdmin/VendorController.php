<?php

namespace App\Http\Controllers\SuperAdmin;


use App\Http\Controllers\BaseController;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\CustomerAddresses;
use App\Models\Customers;
use App\Models\Countries;
use App\Models\States; 
use App\Models\Vendors;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\UploadedFile;
use App\Http\Requests\StoreFileRequest;

 
use DB;

class VendorController extends BaseController
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
    public function viewall($type)
    {
        if($type != 'all') {
            $vendors = Vendors:: orderBy('id', 'DESC')
                                    ->where('type',$type)->get(); 
        } else {
            $vendors = Vendors:: orderBy('id', 'DESC')->get();
        }
        return view('superadmin.vendor.index', compact('vendors'));
    }

    public function index()
    {
        $vendors = Vendors:: orderBy('id', 'DESC')
                            ->get();
        return view('superadmin.vendor.index', compact('vendors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Countries::all(); 
        $permission = Permission::get();
        return view('superadmin.vendor.create', compact('permission', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        $messages = [
            'email.required' => 'Email is required', 
           
        ];
        $request->validate([
            'name' => 'required',
            // 'mobile_number' => 'required',
            'email' => 'required|email|unique:users', 
        ]);
 

        DB::beginTransaction();

        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->email = $request->email ?? $this->generateEmail($request->name);
            $user->password = bcrypt(123456);
            $user->save();
            $vendor = new Vendors();
            $vendor->name = $request->name;
            $vendor->email = $request->email;
            $vendor->mobile_number = $request->mobile_number;
            $vendor->location = $request->location;
            $vendor->authorized_person = $request->authorized_person;
            $vendor->user_id = $user->id;
            $vendor->status = $request->status;
            $vendor->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            // toastr()->error( $e->getMessage() . ' Error ');

            return response()->json([
                'success' => false, 'message' => $e->getMessage(),
            ]);
        }

        toastr()->success(section_title() . ' Vendor Created Successfully');
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
        $vendor = Vendors::find($id);
        return view('superadmin.vendors.show', compact('vendor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vendor = Vendors::find($id);    
        return view('superadmin.vendor.edit', compact('vendor'));
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
            'mobile_number' => 'required',
        ]);
 
       
        if (User::where('email', '=', $request->email)->where('id', '!=', $request->user_id )->first() != null) {
            toastr()->error('Email already exists');
            return redirect()->back();
        }


        try {
            DB::beginTransaction();

            $user = User::find($request->user_id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save(); 
           
            $vendor = Vendors::find($id); 

            $vendor->name = $request->name;
            $vendor->email = $request->email;
            $vendor->mobile_number = $request->mobile_number;
            $vendor->location = $request->location;
            $vendor->authorized_person = $request->authorized_person;
            $vendor->user_id = $user->id;
            $vendor->status = $request->status; 
             
            $vendor->save();
             
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false, 'message' => $e->getMessage(),
            ]);
        } 
 
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
        Vendors::where( 'id', $id )->delete();
        toastr()->success(section_title() . ' Deleted Successfully');
        return redirect()->to(index_url());
    }
 
}
