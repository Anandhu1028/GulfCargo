<?php

namespace App\Http\Controllers\Branch;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Sales;
use App\Models\Branches;
use App\Models\Products;
use App\Models\ProductReports;
use Spatie\Permission\Models\Permission;
use Carbon\Carbon;
use Illuminate\Http\Request; 
use DB;

class ReportsController extends Controller
{
    public function index($id,$dateFrom,$dateTo) {
        $products = Products::get();
        $datas = ProductReports::with('product')->where('product_id',$id)->get();
        return view('branches.reports.index',compact('products','datas'));
    }

    public function viewData($id,$dateFrom,$dateTo) {
        $product = Products::find($id);
        $datas = ProductReports::with('product')
                            ->where('product_id',$id)
                            ->whereBetween('transaction_date', [$dateFrom, $dateTo])
                            ->get();
        $data['closing_stock'] = $product['closing_stock'];
        return response()->json($datas);
    }
}
