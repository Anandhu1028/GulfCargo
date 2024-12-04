<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Branches;
use App\Models\Staffs;
use App\Models\User;
use App\Models\VisaTypes;
use App\Models\DocumentTypes;
use Illuminate\Http\Request;
use App\Exports\AttendenceExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class StaffsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $selected_status =  $request->status ?  $request->status : '';

        if( $request->status){
            $staffs = Staffs::notadmin()->whereHas("branch")->where('staff_status',  $request->status )->orderBy('full_name')->get();
        } else {
            $staffs = Staffs::notadmin()->whereHas("branch")->orderBy('full_name')->get();
        }

        // dd(count( $staffs ));
        return view('superadmin.staffs.index', compact('staffs','selected_status'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $staff = Staffs::select('id')->orderBy('created_at', 'desc')->first();

        if (isset($staff->id)) {
           $staff_id =  "AR".sprintf("%04d", $staff->id);
        } else {
            $id = 1;
            $staff_id =  "AR".sprintf("%04d", $id);
        }
        $visaTypes = VisaTypes::where('status',1)->get();
        $documentTypes = DocumentTypes::where('status',1)->get();


        return view('superadmin.staffs.create', compact('staff_id', 'visaTypes','documentTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            \DB::beginTransaction();

            $request->validate([
                'email' => 'required|email|unique:users,email',
            ]);

                $user = new User();
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = bcrypt($request->password);
                $user->save();
                $staff = new Staffs();
                $staff->branch_id = $request->branch_id;
                $staff->user_id = $user->id;
                $staff->full_name = $user->name;
                $staff->staff_id = $request->staff_id;
                $staff->staff_status = $request->staff_status;

                $staff->role = $request->role;
                $staff->fingerprint_mandatory = $request->fingerprint_mandatory;
                $staff->fingerprint = $request->txtIsoTemplate;
                $staff->visa_status = $request->visa_status;
                $staff->visa_type_id = $request->visa_type;
                $staff->appointment_date = $request->appointment_date;
                $staff->daily_wage = $request->daily_wage;
                $staff->visa_expiry_date = $request->visa_expiry_date;
                $staff->document_type_id = $request->document_type_id;
                $staff->document_number = $request->document_number;

                if ($request->file('document_path')) {
                    $fileName = auth()->id() . '_' . time() . '.'. $request->document_path->extension();
                    $type = $request->document_path->getClientMimeType();
                    $size = $request->document_path->getSize();

                    $request->document_path->move(public_path('uploads/staff_document'), $fileName);
                    $fileName = 'uploads/staff_document/'.$fileName;
                    $staff->document_path = $fileName;

                }

                if ($request->file('profile_photo')) {
                    $fileName = auth()->id() . '_' . time() . '.'. $request->profile_photo->extension();
                    $type = $request->profile_photo->getClientMimeType();
                    $size = $request->profile_photo->getSize();

                    $request->profile_photo->move(public_path('uploads/staff_profile_photo'), $fileName);
                    $fileName = 'uploads/staff_profile_photo/'.$fileName;
                    $staff->profile_photo = $fileName;

                }

                $staff->save();
                $user->assignRole($request->role);
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
        $staff = Staffs::findOrFail($id);
        $visaTypes = VisaTypes::where('status',1)->get();
        return view('superadmin.staffs.show', compact('staff','visaTypes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $staff = Staffs::findOrFail($id);
        if( $staff->staff_id == null ){
            $staff->staff_id =  "AR".sprintf("%04d", $staff->id);
        }
        $visaTypes = VisaTypes::where('status',1)->get();
        $documentTypes = DocumentTypes::where('status',1)->get();

        return view('superadmin.staffs.edit', compact('staff','visaTypes', 'documentTypes'));
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

            $user = User::findOrFail($request->user_id);
            $messages = [
                'email.unique' => 'Email already exists',
            ];

            $request->validate([
                'email' => ['required', Rule::unique('users', 'email')->ignore( $user->id )],
            ]);


                $staff = Staffs::findOrFail($id);
                $staff->full_name = $request->name;
                $staff->staff_id = $request->staff_id;
                $staff->staff_status = $request->staff_status;

                $staff->role = $request->role;
                $staff->branch_id = $request->branch_id;
                $staff->fingerprint_mandatory = $request->fingerprint_mandatory;
                $staff->fingerprint = $request->txtIsoTemplate;
                $staff->visa_status = $request->visa_status;
                $staff->visa_type_id = $request->visa_type;
                $staff->appointment_date = $request->appointment_date;
                $staff->daily_wage = $request->daily_wage;
                $staff->visa_expiry_date = $request->visa_expiry_date;

                $staff->document_type_id = $request->document_type_id;
                $staff->document_number = $request->document_number;

                if ($request->file('document_path')) {
                    $fileName = auth()->id() . '_' . time() . '.'. $request->document_path->extension();
                    $type = $request->document_path->getClientMimeType();
                    $size = $request->document_path->getSize();

                    $request->document_path->move(public_path('uploads/staff_document'), $fileName);
                    $fileName = 'uploads/staff_document/'.$fileName;
                    $staff->document_path = $fileName;
                }

                if ($request->file('profile_photo')) {
                    $fileName = auth()->id() . '_' . time() . '.'. $request->profile_photo->extension();
                    $type = $request->profile_photo->getClientMimeType();
                    $size = $request->profile_photo->getSize();

                    $request->profile_photo->move(public_path('uploads/staff_profile_photo'), $fileName);
                    $fileName = 'uploads/staff_profile_photo/'.$fileName;
                    $staff->profile_photo = $fileName;
                }

                $staff->save();
                $user = User::findOrFail($staff->user_id);
                $user->email = $request->email;
                $user->name = $request->name;
                if ($request->password != null && $request->password != "") {
                    $user->password = bcrypt($request->password);
                }
                $user->save();

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
        $staff = Staffs::findOrFail($id);
        $user = User::findOrFail($staff->user_id);
        $staff->delete();
        $user->delete();
        toastr()->success(section_title() . ' Deleted Successfully');
        return redirect()->to(index_url());
    }

    public function get_staff_attaendence_data(Request $request)
    {
        return Excel::download(new AttendenceExport($request->id), 'staff.xlsx');
    }

    public function getattendence(Request $request)
    {
        return view('superadmin.staffs.attendence');
    }

    public function staff_by_branch_id(Request $request)
    {

        $branch_id = $request->branch_id;

        $staffs = Staffs::notadmin()->where('branch_id', '=', $request->branch_id)->get();
        $html="";
        $html.="<option value=''>Select Staff</option>";
        foreach( $staffs as $staff ) {
            $html.="<option value=".$staff->user_id.">".$staff->full_name."</option>";
        }
        // dd($html);
        return $html;

    }
}
