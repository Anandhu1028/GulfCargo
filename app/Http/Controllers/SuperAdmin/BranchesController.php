<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Branches;
use App\Models\Staffs;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class BranchesController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $branches = Branches::all();
        return view('superadmin.branches.index', compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('superadmin.branches.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

            // $validator = Validator::make($request->all(), [
            //     'password' => 'required',
            //     'email'    => 'required|unique:users,email'
            // ], [
            //     'title.required' => 'Title required custom message',
            //     'title.unique' => 'Title unique custom message',
            //     // ...
            // ]);

            // if ($validator->fails()) {
            //     return redirect()->back()
            //                 ->withErrors($validator)
            //                 ->withInput();
            // }


    try {
        \DB::beginTransaction();

        $branch = new Branches();
        $branch->name = $request->name;
        $branch->location = $request->location;
        $branch->branch_code = $request->branch_code;
        $branch->save();



        // $user = new User();
        // $user->name = $branch->name . " Admin";
        // $user->email = $request->email;
        // $user->password = bcrypt($request->password);
        // $user->save();
        // $user->assignRole("admin");


        // $staff = new Staffs();
        // $staff->branch_id = $branch->id;
        // $staff->user_id = $user->id;
        // $staff->full_name = $user->name;
        // $staff->role = "admin";
        // $staff->save();

        \DB::commit();
    } catch (\Exception $e) {

        \DB::rollBack();
        Log::error($e->getMessage());
        toastr()->error($e->getMessage());
        return redirect()->back();
    }

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
        $branch = Branches::findOrFail($id);
        return view('superadmin.branches.edit', compact('branch'));
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

        try {
            \DB::beginTransaction();

        $branch = Branches::findOrFail($id);
        $branch->name = $request->name;
        $branch->location = $request->location;
        $branch->branch_code = $request->branch_code;
        $branch->save();
        if ($request->admin_id!=null&&$request->admin_id!="") {
            $user = User::findOrFail($request->admin_id);

            $request->validate([
                'email' => ['required', Rule::unique('users', 'email')->ignore( $user->id )],
            ]);

            $user->email = $request->email;
            if ($request->password != null && $request->password != "") {
                $user->password = bcrypt($request->password);
            }
            $user->save();
        }else{
            $request->validate([
                'email' => 'required|email|unique:users,email',
            ]);
            // $user = new User();
            // $user->name = $branch->name . " Admin";
            // $user->email = $request->email;
            // $user->password = bcrypt($request->password);
            // $user->save();
            // $staff = new Staffs();
            // $staff->branch_id = $branch->id;
            // $staff->user_id = $user->id;
            // $staff->full_name = $user->name;
            // $staff->role = "admin";
            // $staff->save();
            // $user->assignRole("admin");
        }
        \DB::commit();
    } catch (\Exception $e) {

        \DB::rollBack();
        Log::error($e->getMessage());
        toastr()->error($e->getMessage());
        return redirect()->back();
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

        $staff = Staffs::where('branch_id', $id)->get();

        if( count($staff) >  0 ){
            toastr()->error(section_title() . '---  Delete all the Staff in the branch');
            return redirect()->to(index_url());

        } else {
            $branch = Branches::findOrFail($id);
            $branch->delete();
            toastr()->success(section_title() . ' Deleted Successfully');
            return redirect()->to(index_url());
        }

    }
}
