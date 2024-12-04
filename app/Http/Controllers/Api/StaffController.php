<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Staffs;


class StaffController extends Controller
{
    //

    public function getStaffApi(Request $request)
    {
        // $offset = $request->offset??0;
        // $limit = $request->limit??10;

        $staff = Staffs::notadmin()->where('branch_id', $request->branch_id)
                // ->skip($offset)->take($limit)
                ->orderBy('created_at', 'desc')
                ->get();
        return response()->json(['data' => $staff], 200);       

    }

    public function getAllStaff(Request $request)
    {
        // $offset = $request->offset??0;
        // $limit = $request->limit??10;

        $staff = Staffs::notadmin()->where('branch_id', $request->branch_id)
                // ->skip($offset)->take($limit)
                ->orderBy('created_at', 'desc')
                ->get();
        return response()->json(['data' => $staff], 200);       

    }

    public function getStaffById(Request $request)
    {
        

        $staff = Staffs::notadmin()->where('branch_id', $request->branch_id)
                        ->where('id', $request->id)  
                        ->get();
        return response()->json(['data' => $staff], 200);       

    }

    
}