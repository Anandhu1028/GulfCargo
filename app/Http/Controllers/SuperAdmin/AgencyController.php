<?php
namespace App\Http\Controllers\SuperAdmin;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Agencies;
use App\Models\Branches;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\UploadedFile;
use App\Http\Requests\StoreFileRequest;
use DB;
use Illuminate\Support\Facades\Log;


class AgencyController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
//        $this->middleware('permission:role-index|role-create|role-edit|role-delete', ['only' => ['index', 'store']]);
//        $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
//        $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
//        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $agencies = Agencies:: orderBy('id', 'DESC')
                            ->get();

        return view('superadmin.agency.index', compact('agencies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permission = Permission::get();
        return view('superadmin.agency.create', compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Agencies::where('name', '=', $request->name)->first() != null) {
            toastr()->error('Name already exists');

            return redirect()->back();
        }
        if (Agencies::where('email', '=', $request->email)->first() != null) {
            toastr()->error('Email already exists');

            return redirect()->back();
        }
        try {
            \DB::beginTransaction();

        $fileName = auth()->id() . '_' . time() . '.'. $request->logo->extension();
        $type = $request->logo->getClientMimeType();
        $size = $request->logo->getSize();

        $request->logo->move(public_path('uploads/agency_logo'), $fileName);
        $fileName = 'uploads/agency_logo/'.$fileName;

        // $branch = new Branches();
        // $branch->name = $request->name;
        // $branch->location = $request->address;
        // $branch->branch_code = $request->agency_code;
        // $branch->save();

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->superadmin = '2';
        $user->password = bcrypt($request->password);
        $user->save();
        // $user->assignRole("admin");


        $agency = new Agencies();
        $agency->name = $request->name;
        $agency->email = $request->email;
        $agency->address = $request->address;
        $agency->agency_code = $request->agency_code;
        $agency->contact_no = $request->contact_no;
        $agency->gst_no = $request->gst_no;
        $agency->logo = $fileName;
        $agency->user_id = $user->id;
        // $agency->branch_id = $branch->id;

        $agency->country = $request->country;
        $agency->state = $request->state;
        $agency->district = $request->district;
        $agency->post = $request->post;
        $agency->pincode = $request->pincode;

        $agency->save();

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
        $role = Agencies::find($id);
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
        $agency = Agencies::find($id);
        return view('superadmin.agency.edit', compact('agency'));
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
        // $this->validate($request, [
        //     'name' => 'required',
        //     'email' => 'required',
        // ]);
        try {
            \DB::beginTransaction();

        $agency = Agencies::find($id);
        if( isset($request->logo ) ) {
            $fileName = auth()->id() . '_' . time() . '.'. $request->logo->extension();
            $type = $request->logo->getClientMimeType();
            $size = $request->logo->getSize();

            $request->logo->move(public_path('uploads/agency_logo'), $fileName);
            $fileName = 'uploads/agency_logo/'.$fileName;
            $agency->logo = $fileName;
        }


        $agency->name = $request->input('name');
        $agency->email = $request->input('email');
        $agency->address = $request->input('address');
        $agency->contact_no = $request->input('contact_no');
        $agency->gst_no = $request->input('gst_no');
        $agency->agency_code = $request->agency_code;

        $agency->country = $request->country;
        $agency->state = $request->state;
        $agency->district = $request->district;
        $agency->post = $request->post;
        $agency->pincode = $request->pincode;


        $agency->save();


        $user = User::where('email', $request->input('email'))->first();
        if(!$user){
            $user = new User();
        }
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->superadmin = '2';
        if($request->input('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        $user->save();

        // $branch = Branches::find($agency->branch_id);
        // if(!$branch) {
        //     $branch = new Branches();
        // }
        // $branch->name =  $request->input('name');
        // $branch->location =  $request->input('address');
        // $branch->branch_code =  $request->input('agency_code');
        // $branch->save();
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
        DB::table("agencies")->where('id', $id)->delete();
        toastr()->success(section_title() . ' Deleted Successfully');
        return redirect()->to(index_url());
    }

    public function agencyGetdata(Request $request)
    {
        $agencyId = $request->agencyId;
         $agency = Agencies::where('id',$agencyId)->first();
         return view('superadmin.agency.agencyGetdata',compact('agency'));
    }
}
