<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Branches;
use App\Models\Products;
use App\Models\ProductReports;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request; 
use Carbon\Carbon;
use DB;

class ProductController extends Controller
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
        $products = Products::with('branch')->orderBy('id', 'DESC')
                            ->get();

        return view('superadmin.product.index', compact('products'));
    }

    public function create() {
        $permission = Permission::get();
        $branches = Branches::get();
        return view('superadmin.product.create', compact('permission','branches'));
    }

    public function store(Request $request)
    { 
        $product = new Products();
        if (Products::where('product_name', '=', $request->product_name)->first() != null) {
            toastr()->error('Product name already exists');
            return redirect()->back();
        }
        
        $product->product_name = $request->product_name;
        $product->UOM = $request->uom;
        $product->opening_stock = $request->opening_stock;
        $product->closing_stock = $request->closing_stock;
        $product->unit_rate = $request->unit_rate; 
        $product->length = $request->length; 
        $product->width = $request->width; 
        $product->height = $request->height; 
        $product->branch_id = $request->branch_id; 
        $product->save();

        $request['product_id'] = $product->id;
        
        $this->transaction($request);
        toastr()->success(section_title() . ' Created Successfully');
        return redirect()->to(index_url());
    }

    public function edit($id)
    {
        $product = Products::find($id);   
        $branches = Branches::get();
        return view('superadmin.product.edit', compact('product','branches'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'product_name' => 'required',
        ]);

        $product = Products::find($id);

        $product->product_name = $request->product_name;
        $product->UOM = $request->uom;
        $product->opening_stock = $request->opening_stock;
        $product->closing_stock = $request->closing_stock;
        $product->unit_rate = $request->unit_rate; 
        $product->length = $request->length; 
        $product->width = $request->width; 
        $product->height = $request->height; 
        $product->branch_id = $request->branch_id;
        $product->save();
        $request['product_id'] = $id;
        
        $transaction = ProductReports::where('transaction_id',$id)->first();
        $transaction->transaction_date = Carbon::now();
        $transaction->transaction_type = '';
        $transaction->branch_id = $request->branch_id;
        $transaction->product_id = $request->product_id;
        $transaction->opening_stock = $request->opening_stock;
        $transaction->closing_stock = $request->closing_stock;
        $transaction->quantity = $request->opening_stock; 
        $transaction->amount = $request->unit_rate; 
        $transaction->UOM = $request->uom; 
        $transaction->save();

        toastr()->success(section_title() . ' Updated Successfully');
        return redirect()->to(index_url());
    }

    public function destroy($id)
    {
        $delete = DB::table("products")->where('id', $id)->where('closing_stock','0')->delete();
        if(!$delete) {
            toastr()->success(section_title() . ' already in Stock! Sorry!');
        } else {
            toastr()->success(section_title() . ' Deleted Successfully');
        }
        return redirect()->to(index_url());
    }

    public function transaction($data){
        $transaction = new ProductReports();

        $transaction->transaction_date = Carbon::now();
        $transaction->transaction_type = '';
        $transaction->transaction_id = $data->product_id;
        $transaction->branch_id = $data->branch_id;
        $transaction->product_id = $data->product_id;
        $transaction->opening_stock = $data->opening_stock;
        $transaction->closing_stock = $data->closing_stock;
        $transaction->quantity = $data->opening_stock; 
        $transaction->amount = $data->unit_rate; 
        $transaction->UOM = $data->uom; 
        $transaction->save();
    }


}
