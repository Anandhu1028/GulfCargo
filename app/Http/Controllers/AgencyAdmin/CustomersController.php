<?php

namespace App\Http\Controllers\AgencyAdmin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\CustomerAddresses;
use App\Models\Customers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomersController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'email' => 'nullable|email|unique:users',
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
            $customer->branch_id = agency_branch()->id;
            $customer->email = $request->email;
            $customer->type = $request->client_type;
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
            $address->zip_code = $request->zip_code;
            $address->address = $request->address;
            $address->save();
            DB::commit();
            $customer->address = $address;
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false, 'message' => $e->getMessage(),
            ]);
        }

        return response()->json([
            'success' => true, 'message' => 'Client Created Successfully', 'data' => $customer
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
