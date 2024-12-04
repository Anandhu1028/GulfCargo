<?php

namespace App\Http\Controllers\Branch;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Sales;
use App\Models\Branches;
use App\Models\Products;
use App\Models\SaleProducts;
use Spatie\Permission\Models\Permission;
use Carbon\Carbon;
use Illuminate\Http\Request; 
use App\Models\ProductReports;
use DB;

class SalesController extends Controller
{
    public function index()
    {
        $sales = Sales::with('branch')->orderBy('id', 'DESC')->get();
        return view('branches.sales.index', compact('sales'));
    }

    public function create() {
        $permission = Permission::get();
        $branches = Branches::where("id",branch()->id)->get();
        $products = Products::get();
        $saleNumber = Sales::orderBy('id', 'DESC')->first();
        if(isset($saleNumber)) {
            $getNumber = $saleNumber['sale_number'];
            $number = explode('PS', $getNumber);
            $unique_code = $number[1] + 1;
        } else {
            $unique_code = "1001"; 
        }
        $saleNum = "BEPS".$unique_code;
        return view('branches.sales.create', compact('permission','branches','products','saleNum'));
    }

    public function store(Request $request)
    { 
        $sale = new Sales();
        if (Sales::where('sale_number', '=', $request->sale_number)->first() != null) {
            toastr()->error('Sale already exists');
            return redirect()->back();
        }
        
        $sale->sale_number = $request->sale_number;
        $sale->sale_date = $request->sale_date;
        $sale->branch_id = $request->branch_id;
        $sale->total_amount = $request->grandTotal;
        $sale->total_quantity = $request->branch_id;
        $sale->save();

        $products = $request->product_name;
        if(!empty($products)) {
            for( $i=0; $i < count($products); $i++ ) {
                $sale_product = new SaleProducts();
                $sale_product->product_id = $request->product_name[$i];
                $sale_product->sale_id = $sale->id;
                $sale_product->sale_number = $request->sale_number;
                $sale_product->quantity = $request->qty[$i];
                $sale_product->amount = $request->unit[$i];
                $sale_product->save();

                $product = Products::find($request->product_name[$i]);
                $request['opening_stock'] = $product->closing_stock;
                $request['closing_stock'] = $product->closing_stock - $request->qty[$i];
                $request['uom'] = $product->UOM;
                $request['product_id'] = $request->product_name[$i];
                $request['quantity'] = $request->qty[$i];
                $request['amount'] = $request->unit[$i];

                $product->closing_stock = $product->closing_stock - $request->qty[$i];
                $product->save();

                $request['transaction_id'] = $sale->id;
                $this->transaction($request);
            }
        }        
        
        toastr()->success(section_title() . ' Sale created Successfully');
        return redirect()->to(index_url());
    }
    public function edit($id)
    {
        $sale = Sales::find($id);  
        $branches = Branches::get();
        $products = Products::get(); 
        $saleProducts = SaleProducts::where('sale_id',$id)->get();    
        return view('branches.sales.edit', compact('sale','branches','products','saleProducts'));
    }

    public function update(Request $request, $id) {
        $sale = Sales::find($id);
        $sale->sale_date = $request->sale_date;
        $sale->branch_id = $request->branch_id;
        $sale->total_amount = $request->grandTotal;
        $sale->total_quantity = $request->branch_id;
        $sale->save();

        $sale_products = SaleProducts::where('sale_id', $id)->get();
        foreach($sale_products as $sale_product) {
            $product = Products::find($sale_product->product_id);
            $product->closing_stock = $product->closing_stock + $sale_product->quantity;
            $product->save();
        }
        
        $sale_products = SaleProducts::where('sale_id',$id)->delete();

        $products = $request->product_name;
        if(!empty($products)) {
            for( $i=0; $i < count($products); $i++ ) {
                $sale_product = new SaleProducts();
                $sale_product->product_id = $request->product_name[$i];
                $sale_product->sale_id = $sale->id;
                $sale_product->sale_number = $request->sale_number;
                $sale_product->quantity = $request->qty[$i];
                $sale_product->amount = $request->unit[$i];
                $sale_product->save();

                $product = Products::find($request->product_name[$i]);
                $request['opening_stock'] = $product->closing_stock;
                $request['closing_stock'] = $product->closing_stock - $request->qty[$i];
                $request['uom'] = $product->UOM;
                $request['product_id'] = $request->product_name[$i];
                $request['quantity'] = $request->qty[$i];
                $request['amount'] = $request->unit[$i];

                $product->closing_stock = $product->closing_stock - $request->qty[$i];
                $product->save();

                $transaction = ProductReports::where('transaction_id',$id)
                                        ->where('product_id',$request->product_name[$i])
                                        ->where('transaction_type','Sale')
                                        ->first();
                if(empty($transaction)) {
                    $transaction = new ProductReports();
                    $transaction->transaction_date = Carbon::now();
                    $transaction->transaction_type = 'Sale';
                    $transaction->transaction_id = $id;
                }
                $transaction->branch_id = branch()->id;
                $transaction->product_id = $request->product_name[$i];
                $transaction->opening_stock = $request->opening_stock;
                $transaction->closing_stock = $request->closing_stock;
                $transaction->quantity = $request->quantity; 
                $transaction->amount = $request->amount; 
                $transaction->UOM = $request->uom; 
                $transaction->save();       
            }
        }  

        toastr()->success(section_title() . ' Sale updated Successfully');
        return redirect()->to(index_url());
    }

    public function destroy(Request $request, $ids)
    {
        $id= $request->saleId;
        $stock_products = SaleProducts::where('sale_id', $id)->get();
        foreach($stock_products as $stock_product) {
            $product = Products::find($stock_product->product_id);
            $product->closing_stock = $product->closing_stock + $stock_product->quantity;
            $product->save();
        }
        $transaction = ProductReports::where('transaction_id',$id)
                                        ->where('transaction_type','Sale')
                                        ->delete();
        DB::table("sale_products")->where('sale_id', $id)->delete();

        DB::table("sales")->where('id', $id)->delete();
        toastr()->success(section_title() . ' Deleted Successfully');
        return redirect()->to(index_url());
    } 

    public function transaction($data){
        $transaction = new ProductReports();

        $transaction->transaction_date = Carbon::now();
        $transaction->transaction_type = 'Sale';
        $transaction->transaction_id = $data->transaction_id;
        $transaction->branch_id = branch()->id;
        $transaction->product_id = $data->product_id;
        $transaction->opening_stock = $data->opening_stock;
        $transaction->closing_stock = $data->closing_stock;
        $transaction->quantity = $data->quantity; 
        $transaction->amount = $data->amount; 
        $transaction->UOM = $data->uom; 
        $transaction->save();
    }
}
