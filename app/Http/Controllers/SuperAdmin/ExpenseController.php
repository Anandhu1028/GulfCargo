<?php

namespace App\Http\Controllers\SuperAdmin;


use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Expenses;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\UploadedFile;
use App\Http\Requests\StoreFileRequest;

 
use DB;

class ExpenseController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
    
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenses = Expenses:: orderBy('id', 'DESC')
                            ->get();

        return view('superadmin.expense.index', compact('expenses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permission = Permission::get();
        return view('superadmin.expense.create', compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        $expense = new Expenses();
        // if (Vehicles::where('vehicle_no', '=', $request->vehicle_no)->first() != null) {
        //     toastr()->error('vehicle number already exists');
        //     return redirect()->back();
        // }       
 
        $expense->particulars = $request->particulars;
        $expense->total_amount = $request->total_amount;
        $expense->chq_valid_till = $request->chq_valid_till;
        $expense->remarks = $request->remarks; 
        $expense->save();
        
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
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $expense = Expenses::find($id);         
        return view('superadmin.expense.edit', compact('expense'));
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
       
  
        $expense = Expenses::find($id);

        $expense->particulars = $request->particulars;
        $expense->total_amount = $request->total_amount;
        $expense->chq_valid_till = $request->chq_valid_till;
        $expense->remarks = $request->remarks; 
        $expense->save();

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
        $expense = Expenses::findOrFail($id); 
        $expense->delete();
        toastr()->success(section_title() . ' Deleted Successfully');
        return redirect()->to(index_url());
    }
     
    
}
