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
use Illuminate\Http\Request;
use App\Exports\AttendenceExport;
use Maatwebsite\Excel\Facades\Excel;
use DataTables;


class CitiesController extends BaseController
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
            $cities = Cities::select('id','name','state_id')->where('state_id',$request->state_id )->orderBy("name", "asc")->get();
        }
        else {
           //Default loading Dubai state
            $cities = Cities::select('id','name','state_id')->where('state_id',3391 )->orderBy("name", "asc")->get();
        }
        return view('superadmin.cities.index', compact('cities','states','selected_state_id'));
    }

    public function getcities()
    {

        $model = Cities::with('state')->skip(0)->take(10)->get();
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

        return view('superadmin.cities.create', compact('states'));
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

        $city = new Cities();
        $city->name = $request->name;
        $city->state_id = $request->state_id;
        $city->state_code = $state_data->iso2;
        $city->country_id = $country_data->id;
        $city->country_code = $country_data->iso2;

        $city->save();

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
        $cities = Cities::findOrFail($id);
        $states = States::select('id','name')->orderBy("name", "asc")->get();


        return view('superadmin.cities.edit', compact('cities', 'states'));
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

        $city = Cities::findOrFail($id);

        $state_id = $request->state_id;

        $state_data = States::find($state_id);
        $country_data = Countries::where('id',$state_data->country_id)->first();

        // $city = new Cities();
        $city->name = $request->name;
        $city->state_id = $request->state_id;
        $city->state_code = $state_data->iso2;
        $city->country_id = $country_data->id;
        $city->country_code = $country_data->iso2;

        $city->save();

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
        $city = Cities::findOrFail($id);
        $city->delete();
        toastr()->success(section_title() . ' Deleted Successfully');
        return redirect()->to(index_url());
    }

}
