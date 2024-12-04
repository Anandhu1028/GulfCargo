<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomerAddresses;
use App\Models\Customers;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class CustomerController extends Controller
{
    

    public function store(Request $request){
        
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
            $customer->email = $request->email;
            $customer->type = $request->type;
            $customer->identification_type = $request->client_identification_type;
            $customer->identification_number = $request->client_identification_number;
            $customer->created_by = $request->created_by;
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
            $address->zip_code = $request->zip_code;
            $address->address = $request->address;
            $address->save();
            DB::commit();
            $customer->address = $address;
            
            } catch (\Exception $e) {

                \DB::rollBack();
                return response()->json(['data' => $e->getMessage(), 'status' => 'error'], 500);                 
            }

            return response()->json(['message' => "success"], 200); 

    }

    public function getAllSender(Request $request){ 

        $sender = Customers::with('address')->where('type', 'sender') ->get(); 
        return response()->json(['data' => $sender], 200); 

    }

    public function getAllReceiver(Request $request){
 
        $receiver = Customers::with('address')->where('type', 'receiver') ->get(); 
        return response()->json(['data' => $receiver], 200);

    }

    
}