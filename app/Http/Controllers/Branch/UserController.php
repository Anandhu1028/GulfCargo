<?php

namespace App\Http\Controllers\Branch;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;  
use Illuminate\Http\Request;
use Auth;
use App\Models\Staffs;
use App\Models\User;

class UserController extends BaseController
{
  
    public function profile()
    {
        $user = Auth::user(); 
        $user_details = Staffs::where('user_id', $user->id)->first(); 
        //  dd($user, $user_details );
        return view('branches.profile.editProfile', compact('user' , 'user_details'));
    }

    public function profileupdate(Request $request)
    {
        $user_id = $request->user_id;
        $staff_id = $request->staff_id;

        $user = User::find($user_id); 
        $user->name = $request->name;
        $user->save();
        $staff = Staffs::find($staff_id);

        $staff->full_name =  $request->name;

        if ($request->file('profile_photo')) {
            $fileName = auth()->id() . '_' . time() . '.'. $request->profile_photo->extension();
            $type = $request->profile_photo->getClientMimeType();
            $size = $request->profile_photo->getSize();

            $request->profile_photo->move(public_path('uploads/staff_profile_photo'), $fileName);
            $fileName = 'uploads/staff_profile_photo/'.$fileName;
            $staff->profile_photo = $fileName;                   
        }
        $staff->save(); 

        toastr()->success(section_title() . ' Updated Successfully');
        return redirect()->route('branch.user.profile'); 

    }     
    
}