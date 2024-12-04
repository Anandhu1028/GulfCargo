<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Branches;
use App\Models\Staffs;
use App\Models\User;
use App\Models\States;
use App\Models\Countries;
use App\Models\Cities;
use App\Models\Districts;
use Illuminate\Http\Request;
use App\Exports\AttendenceExport;
use Maatwebsite\Excel\Facades\Excel;
use DataTables;


class DistrictsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $states = States::select('id','name','country_id')->orderBy("name", "asc")->get();
        $selected_state_id = $request->state_id?$request->state_id:'';
        if($request->state_id)
        {
            $districts = Districts::select('id','name','state_id')->where('state_id',$request->state_id )->orderBy("name", "asc")->get();
        }
        else {
           //Default loading Dubai state
            $districts = Districts::select('id','name','state_id')->where('state_id',3391 )->orderBy("name", "asc")->get();
        }
        return view('superadmin.districts.index', compact('districts','states','selected_state_id'));
    }

    public function getcities()
    {

        $model = Districts::with('state')->skip(0)->take(10)->get();
        return DataTables::of($model)->make();

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $states = States::select('id','name')->orderBy("name", "asc")->get();

        return view('superadmin.districts.create', compact('states'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $state_id = $request->state_id;

        $state_data = States::find($state_id);
        $country_data = Countries::where('id',$state_data->country_id)->first();

        $district = new Districts();
        $district->name = $request->name;
        $district->state_id = $request->state_id;
        $district->state_code = $state_data->iso2;
        $district->country_id = $country_data->id;
        $district->country_code = $country_data->iso2;

        $district->save();

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
        $districts = Districts::findOrFail($id);
        $states = States::select('id','name')->orderBy("name", "asc")->get();


        return view('superadmin.districts.edit', compact('districts', 'states'));
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

        $district = Districts::findOrFail($id);

        $state_id = $request->state_id;

        $state_data = States::find($state_id);
        $country_data = Countries::where('id',$state_data->country_id)->first();

        // $district = new Cities();
        $district->name = $request->name;
        $district->state_id = $request->state_id;
        $district->state_code = $state_data->iso2;
        $district->country_id = $country_data->id;
        $district->country_code = $country_data->iso2;

        $district->save();

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
        $district = Districts::findOrFail($id);
        $district->delete();
        toastr()->success(section_title() . ' Deleted Successfully');
        return redirect()->to(index_url());
    }

}
