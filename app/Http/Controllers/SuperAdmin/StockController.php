<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\StockTransfers;
use App\Models\Branches;
use App\Models\Products;
use App\Models\ProductReports;
use App\Models\StockTransferProducts;
use Spatie\Permission\Models\Permission;
use Carbon\Carbon;
use Illuminate\Http\Request; 
use DB;

class StockController extends Controller
{
    public function index() {
        $stocks = StockTransfers:: orderBy('id', 'DESC')->get();
        $branches = Branches::get();
        return view('superadmin.stocks.index', compact('stocks','branches'));
    }

    public function create() {
        $permission = Permission::get();
        $branches = Branches::get();
        $products = Products::get();
        $stockNumber = StockTransfers::orderBy('id', 'DESC')->first();
        if(isset($stockNumber)) {
            $getNumber = $stockNumber['stock_number'];
            $number = explode('TR', $getNumber);
            $nextNum = $number[1] + 1;
        } else {
            $nextNum = "1001";
        }
        $stockNum = "BETR".$nextNum;
        return view('superadmin.stocks.create', compact('permission','branches','products','stockNum'));
    }

    public function store(Request $request)
    { 
        $stock = new StockTransfers();
        if (StockTransfers::where('stock_number', '=', $request->stock_number)->first() != null) {
            toastr()->error('Stock already exists');
            return redirect()->back();
        }
        
        $stock->stock_number = $request->stock_number;
        $stock->stock_date = $request->stock_date;
        $stock->branch_id_from = $request->branch_id_from;
        $stock->branch_id_to = $request->branch_id_to;
        $stock->total_amount = $request->grandTotal;
        $stock->total_quantity = $request->branch_id;
        $stock->save();

        $products = $request->product_name;
        if(!empty($products)) {
            for( $i=0; $i < count($products); $i++ ) {
                $stock_product = new StockTransferProducts();
                $stock_product->product_id = $request->product_name[$i];
                $stock_product->stock_id = $stock->id;
                $stock_product->stock_number = $request->stock_number;
                $stock_product->quantity = $request->qty[$i];
                $stock_product->amount = $request->unit[$i];
                $stock_product->save();

                $product = Products::find($request->product_name[$i]);
                $request['opening_stock'] = $product->closing_stock;
                $request['closing_stock'] = $product->closing_stock - $request->qty[$i];
                $request['uom'] = $product->UOM;
                $request['product_id'] = $request->product_name[$i];
                $request['quantity'] = $request->qty[$i];
                $request['amount'] = $request->unit[$i];
                $request['branch_id'] = $request->branch_id_from;

                $product->closing_stock = $product->closing_stock - $request->qty[$i];
                $product->save();
            }
        }        
        $request['transaction_id'] = $stock->id;
        $this->transaction($request);
        toastr()->success(section_title() . ' Stock created Successfully');
        return redirect()->to(index_url());
    }

    public function edit($id)
    {
        $stock = StockTransfers::find($id);  
        $branches = Branches::get();
        $products = Products::get(); 
        $stockProducts = StockTransferProducts::where('stock_id',$id)->get();    
        return view('superadmin.stocks.edit', compact('stock','branches','products','stockProducts'));
    }

    public function update(Request $request, $id) {
        $stock = StockTransfers::find($id);
        $stock->stock_date = $request->stock_date;
        $stock->branch_id_from = $request->branch_id_from;
        $stock->branch_id_to = $request->branch_id_to;
        $stock->total_amount = $request->grandTotal;
        $stock->total_quantity = $request->branch_id;
        $stock->save();

        $stock_products = StockTransferProducts::where('stock_id', $id)->get();
        foreach($stock_products as $stock_product) {
            $product = Products::find($stock_product->product_id);
            $product->closing_stock = $product->closing_stock + $stock_product->quantity;
            $product->save();
        }
        
        $stock_products = StockTransferProducts::where('stock_id',$id)->delete();

        $products = $request->product_name;
        if(!empty($products)) {
            for( $i=0; $i < count($products); $i++ ) {
                $stock_product = new StockTransferProducts();
                $stock_product->product_id = $request->product_name[$i];
                $stock_product->stock_id = $id;
                $stock_product->stock_number = $request->stock_number;
                $stock_product->quantity = $request->qty[$i];
                $stock_product->amount = $request->unit[$i];
                $stock_product->save();

                $product = Products::find($request->product_name[$i]);
                $request['opening_stock'] = $product->closing_stock;
                $request['closing_stock'] = $product->closing_stock - $request->qty[$i];
                $request['uom'] = $product->UOM;
                $request['product_id'] = $request->product_name[$i];
                $request['quantity'] = $request->qty[$i];
                $request['amount'] = $request->unit[$i];
                $request['branch_id'] = $request->branch_id_from;

                $product->closing_stock = $product->closing_stock - $request->qty[$i];
                $product->save();
            }
        }   
        $transaction = ProductReports::where('transaction_id',$id)->where('transaction_type','Transfer')->first();

        $transaction->transaction_date = Carbon::now();
        $transaction->branch_id = $request->branch_id;
        $transaction->product_id = $request->product_id;
        $transaction->opening_stock = $request->opening_stock;
        $transaction->closing_stock = $request->closing_stock;
        $transaction->quantity = $request->quantity; 
        $transaction->amount = $request->amount; 
        $transaction->UOM = $request->uom; 
        $transaction->save();           
        
        toastr()->success(section_title() . ' Stock updated Successfully');
        return redirect()->to(index_url());
    }

    public function destroy(Request $request, $ids)
    {
        $id= $request->stockId;
        $stock_products = StockTransferProducts::where('stock_id', $id)->get();
        foreach($stock_products as $stock_product) {
            $product = Products::find($stock_product->product_id);
            $product->closing_stock = $product->closing_stock + $stock_product->quantity;
            $product->save();
        }
        DB::table("stock_transfer_products")->where('stock_id', $id)->delete();

        DB::table("stock_transfers")->where('id', $id)->delete();
        toastr()->success(section_title() . ' Deleted Successfully');
        return redirect()->to(index_url());
    }

    public function transaction($data){
        $transaction = new ProductReports();

        $transaction->transaction_date = Carbon::now();
        $transaction->transaction_type = 'Transfer';
        $transaction->transaction_id = $data->transaction_id;
        $transaction->branch_id = $data->branch_id;
        $transaction->product_id = $data->product_id;
        $transaction->opening_stock = $data->opening_stock;
        $transaction->closing_stock = $data->closing_stock;
        $transaction->quantity = $data->quantity; 
        $transaction->amount = $data->amount; 
        $transaction->UOM = $data->uom; 
        $transaction->save();
    }

}
