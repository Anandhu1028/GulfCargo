<?php

namespace App\Http\Controllers\SuperAdmin;


use App\Http\Controllers\BaseController;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller;
use App\Models\User;  
use App\Models\Countries;
use App\Models\States; 
use App\Models\Vendors;
use App\Models\MovingTypes;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\UploadedFile;
use App\Http\Requests\StoreFileRequest;

 
use DB;

class MovingTypeController extends BaseController
{
    
    function __construct()
    {
    
    } 

    public function index() {

        $movingtypes = MovingTypes:: orderBy('id', 'DESC')->paginate(15);
        return view('superadmin.movingtype.index', compact('movingtypes'));
    }

   
    public function create() {
        $countries = Countries::all(); 
        $permission = Permission::get();
        return view('superadmin.movingtype.create', compact('permission', 'countries'));
    }

 
    public function store(Request $request) {  

        DB::beginTransaction();
        try {
            $movingType = new MovingTypes();
            $movingType->name = $request->name;
            $movingType->status = $request->status;             
            $movingType->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack(); 
            return response()->json([
                'success' => false, 'message' => $e->getMessage(),
            ]);
        }
        toastr()->success(section_title() . ' Moving Type Created Successfully');
        return redirect()->to(index_url()); 
    }

    
    // public function show($id)
    // {
    //     $vendor = MovingTypes::find($id);
    //     return view('superadmin.vendors.show', compact('vendor'));
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $movingType = MovingTypes::find($id);    
        return view('superadmin.movingtype.edit', compact('movingType'));
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

            $movingType                    = MovingTypes::findOrFail($id); 
            $movingType->name      = $request->name;
            $movingType->status              = $request->status;
          
            $movingType->save();  

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
        Vendors::where( 'id', $id )->delete();
        toastr()->success(section_title() . ' Deleted Successfully');
        return redirect()->to(index_url());
    }
 
}
