<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response; 
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Branches;
use App\Models\Staffs;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    
    
    function index(Request $request)
    { 

        $user = User::where('email', $request->email)->first();  

        if(!$user || !Hash::check($request->password, $user->password)){

            return response([
                'message' =>['These credentials do not match our records.']
            ],404);
        }
            $token = $user->createToken('my-app-token')->plainTextToken; 
          
            $staff = Staffs::where('user_id', $user->id)->first();  

            $data=  [
                "user_id" => $user->id,
                "user_name"=> $user->name,
                "email"=> $user->email,
                "branch_id"=> $staff->branch->id,
                "branch_name"=> $staff->branch->name,
                "branch_code"=> $staff->branch->code,
                "branch_location"=> $staff->branch->location
            
                ];

            
            $response = [
                'user' => $data,
                'token' =>$token
            ];

            return response($response, 201 );  
        
    }

    public function logout() {
        auth()->user()->tokens()->delete();
        return [ 
            'message' => 'user logged out'
        ];
    }
}
