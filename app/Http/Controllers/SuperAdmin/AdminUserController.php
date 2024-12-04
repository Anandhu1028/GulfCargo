<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Staffs;
use App\Models\User;


class AdminUserController extends BaseController
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function profile()
    {
        $user = Auth::user(); 
        $user_details = Staffs::where('user_id', $user->id)->first(); 
        //  dd($user, $user_details );
        return view('superadmin.settings.editProfile', compact('user' , 'user_details')); 
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
        return redirect()->route('super-admin.user.profile'); 

    }


    // 

    
}
