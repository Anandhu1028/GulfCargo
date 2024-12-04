<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Purchases;
use App\Models\Branches;
use App\Models\Products;
use App\Models\PurchaseProducts;
use Spatie\Permission\Models\Permission;
use App\Models\ProductReports;
use Carbon\Carbon;
use Illuminate\Http\Request; 
use DB;


class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchases:: orderBy('id', 'DESC')->get();
        $branches = Branches::get();
        return view('superadmin.purchase.index', compact('purchases','branches'));
    }

    public function create() {
        $permission = Permission::get();
        $branches = Branches::get();
        $products = Products::get();
        $purchaseNumber = Purchases::orderBy('id', 'DESC')->first();
        if(isset($purchaseNumber)) {
            $getNumber = $purchaseNumber['purchase_number'];
            $number = explode('PU', $getNumber);
            $unique_code = $number[1] + 1;
        } else {
            $unique_code = "1001"; 
        }
        $purchaseNum = "BEPU".$unique_code;
        return view('superadmin.purchase.create', compact('permission','branches','products','purchaseNum'));
    }

    public function store(Request $request)
    { 
        $purchase = new Purchases();
        if (Purchases::where('purchase_number', '=', $request->purchase_number)->first() != null) {
            toastr()->error('Purchase already exists');
            return redirect()->back();
        }
        
        $purchase->purchase_number = $request->purchase_number;
        $purchase->purchase_date = $request->purchase_date;
        $purchase->branch_id = $request->branch_id;
        $purchase->total_amount = $request->totalAmount;
        $purchase->total_quantity = $request->totalQuantity;
        $purchase->save();

        $products = $request->product_name;
        if(!empty($products)) {
            for( $i=0; $i < count($products); $i++ ) {
                $purchase_product = new PurchaseProducts();
                $purchase_product->product_id = $request->product_name[$i];
                $purchase_product->purchase_id = $purchase->id;
                $purchase_product->purchase_number = $request->purchase_number;
                $purchase_product->quantity = $request->qty[$i];
                $purchase_product->amount = $request->unit[$i];
                $purchase_product->save();

                $product = Products::find($request->product_name[$i]);
                $request['opening_stock'] = $product->closing_stock;
                $request['closing_stock'] = $product->closing_stock + $request->qty[$i];
                $request['uom'] = $product->UOM;
                $request['product_id'] = $request->product_name[$i];
                $request['quantity'] = $request->qty[$i];
                $request['amount'] = $request->unit[$i];

                $product->closing_stock = $product->closing_stock + $request->qty[$i];
                $product->save();
                $request['transaction_id'] = $purchase->id;
                $this->transaction($request);
            }
        }        
        
        toastr()->success(section_title() . ' Purchase created Successfully');
        return redirect()->to(index_url());
    }

    public function edit($id)
    {
        $purchase = Purchases::find($id);  
        $branches = Branches::get();
        $products = Products::get(); 
        $purchaseProducts = PurchaseProducts::where('purchase_id',$id)->get();    
        return view('superadmin.purchase.edit', compact('purchase','branches','products','purchaseProducts'));
    }

    public function update(Request $request, $id) {
        $purchase = Purchases::find($id);
        $purchase->purchase_date = $request->purchase_date;
        $purchase->branch_id = $request->branch_id;
        $purchase->total_amount = $request->totalAmount;
        $purchase->total_quantity = $request->totalQuantity;
        $purchase->save();

        $purchase_products = PurchaseProducts::where('purchase_id', $id)->get();
        foreach($purchase_products as $purchase_product) {
            $product = Products::find($purchase_product->product_id);
            $product->closing_stock = $product->closing_stock - $purchase_product->quantity;
            $product->save();
        }
        
        $purchase_products = PurchaseProducts::where('purchase_id',$id)->delete();

        $products = $request->product_name;
        if(!empty($products)) {
            for( $i=0; $i < count($products); $i++ ) {
                $purchase_product = new PurchaseProducts();
                $purchase_product->product_id = $request->product_name[$i];
                $purchase_product->purchase_id = $purchase->id;
                $purchase_product->purchase_number = $request->purchase_number;
                $purchase_product->quantity = $request->qty[$i];
                $purchase_product->amount = $request->unit[$i];
                $purchase_product->save();

                $product = Products::find($request->product_name[$i]);
                $request['opening_stock'] = $product->closing_stock;
                $request['closing_stock'] = $product->closing_stock + $request->qty[$i];
                $request['uom'] = $product->UOM;
                $request['product_id'] = $request->product_name[$i];
                $request['quantity'] = $request->qty[$i];
                $request['amount'] = $request->unit[$i];

                $transaction = ProductReports::where('transaction_id',$id)
                                                ->where('product_id',$request->product_name[$i])
                                                ->where('transaction_type','Purchase')->first();
                if(empty($transaction)) {
                    $transaction = new ProductReports();
                    $transaction->transaction_date = Carbon::now();
                    $transaction->transaction_type = 'Purchase';
                    $transaction->transaction_id = $id;
                }
                $transaction->branch_id = $request->branch_id;
                $transaction->product_id = $request->product_id;
                $transaction->opening_stock = $request->opening_stock;
                $transaction->closing_stock = $request->closing_stock;
                $transaction->quantity = $request->quantity; 
                $transaction->amount = $request->amount; 
                $transaction->UOM = $request->uom; 
                $transaction->save();       
                
                $product->closing_stock = $product->closing_stock + $request->qty[$i];
                $product->save();
            }
        }
        
        toastr()->success(section_title() . ' Purchase updated Successfully');
        return redirect()->to(index_url());
    }

    public function destroy(Request $request, $ids)
    {
        $id= $request->purchaseId;
        $purchase_products = PurchaseProducts::where('purchase_id', $id)->get();
        foreach($purchase_products as $purchase_product) {
            $product = Products::find($purchase_product->product_id);
            $product->closing_stock = $product->closing_stock - $purchase_product->quantity;
            $product->save();
        }
        $transaction = ProductReports::where('transaction_id',$id)
                                        ->where('transaction_type','Purchase')
                                        ->delete();
        DB::table("purchase_products")->where('purchase_id', $id)->delete();

        DB::table("purchases")->where('id', $id)->delete();
        toastr()->success(section_title() . ' Deleted Successfully');
        return redirect()->to(index_url());
    }

    public function transaction($data){
        $transaction = new ProductReports();
        $transaction->transaction_date = Carbon::now();
        $transaction->transaction_type = 'Purchase';
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
