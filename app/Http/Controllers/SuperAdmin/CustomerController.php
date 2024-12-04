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
use Spatie\Permission\Models\Permission;
use Illuminate\Http\UploadedFile;
use App\Http\Requests\StoreFileRequest;


use DB;

class CustomerController extends BaseController
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
            $customers = Customers:: orderBy('id', 'DESC')
                                    ->where('type',$type)->get();
        } else {
            $customers = Customers:: orderBy('id', 'DESC')->get();
        }
        return view('superadmin.customer.index', compact('customers'));
    }

    public function index()
    {
        $customers = Customers:: orderBy('id', 'DESC')
                            ->get();
        return view('superadmin.customer.index', compact('customers'));
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
        return view('superadmin.customer.create', compact('permission', 'countries'));
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
            'country_id.required' => 'Country is required',
            'state_id.required' => 'State is required',
        ];
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'country_id' => 'required',
            'state_id' => 'required'
        ]);


        try {
            DB::beginTransaction();
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->email = $request->email ?? $this->generateEmail($request->name);
            $user->password = bcrypt(123456);
            $user->save();
            $customer = new Customers();
            $customer->name = $request->name;
            $customer->country_code_phone = $request->country_code_phone;
            $customer->phone = $request->phone;
            $customer->country_code_whatsapp = $request->country_code_whatsapp;
            $customer->whatsapp_number = $request->whatsapp_number;
            $customer->user_id = $user->id;
            $customer->branch_id = $request->branch_id;
            $customer->post = $request->post;
            $customer->email = $request->email;
            $customer->type = $request->type;
            $customer->city_name = $request->cities;
            $customer->identification_type = $request->client_identification_type;
            $customer->identification_number = $request->client_identification_number;
            $customer->created_by = $request->user()->id;
            if ($request->file('document')) {
                $fileName = auth()->id() . '_' . time() . '.'. $request->document->extension();
                $type = $request->document->getClientMimeType();
                $size = $request->document->getSize();

                $request->document->move(public_path('uploads/customer_logo'), $fileName);
                $fileName = 'uploads/customer_logo/'.$fileName;
                $customer->logo = $fileName;

            }
            $customer->save();

            $address = new CustomerAddresses();
            $address->customer_id = $customer->id;
            $address->country_id = $request->country_id;
            $address->state_id = $request->state_id;
            $address->city_id = $request->city_id;
            $address->district_id = $request->district_id;
            $address->zip_code = $request->zip_code;
            $address->address = $request->address;
            $address->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false, 'message' => $e->getMessage(),
            ]);
        }

        toastr()->success(section_title() . ' Client Created Successfully');
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
        $role = Customers::find($id);
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
        $customer = Customers::find($id);
        $countries = Countries::all();
        return view('superadmin.customer.edit', compact('customer', 'countries'));
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


        try {
            DB::beginTransaction();

            $user = User::find($request->user_id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();

            $customer = Customers::find($id);

            $customer->name = $request->name;
            $customer->country_code_phone = $request->country_code_phone;
            $customer->phone = $request->phone;
            $customer->country_code_whatsapp = $request->country_code_whatsapp;
            $customer->whatsapp_number = $request->whatsapp_number;
            $customer->user_id = $user->id;
            $customer->post = $request->post;
            $customer->branch_id = $request->branch_id;
            $customer->email = $request->email;
            $customer->type = $request->type;
            $customer->city_name = $request->city_id;
            $customer->identification_type = $request->client_identification_type;
            $customer->identification_number = $request->client_identification_number;
            $customer->created_by = $request->user()->id;
            if ($request->file('document')) {
                $fileName = auth()->id() . '_' . time() . '.'. $request->document->extension();
                $type = $request->document->getClientMimeType();
                $size = $request->document->getSize();

                $request->document->move(public_path('uploads/customer_logo'), $fileName);
                $fileName = 'uploads/customer_logo/'.$fileName;
                $customer->logo = $fileName;

            }
            $customer->save();

            $address = new CustomerAddresses();
            $address = CustomerAddresses:: where('customer_id',$id)->first();

            $address->customer_id = $customer->id;
            $address->country_id = $request->country_id;
            $address->state_id = $request->state_id;
            $address->city_id = $request->city_id;
            $address->district_id = $request->district_id;
            $address->zip_code = $request->zip_code;
            $address->address = $request->address;
            $address->save();
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
        DB::table("customers")->where('id', $id)->delete();
        toastr()->success(section_title() . ' Deleted Successfully');
        return redirect()->to(index_url());
    }

}
