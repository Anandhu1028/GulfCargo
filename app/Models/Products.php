<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Products extends Model
{
    use HasFactory;

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branches::class);
    }

    public function productPurchase() {
        return $this->hasMany(PurchaseProducts::class,'product_id');
    }

    public function stockProducts() {
        return $this->hasMany(StockTransferProducts::class,'product_id');
    }

    public function saleProducts() {
        return $this->hasMany(SaleProducts::class,'product_id');
    }
}
