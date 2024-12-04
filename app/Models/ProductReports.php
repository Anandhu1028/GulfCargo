<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class ProductReports extends Model
{
    use HasFactory;
    
    public function product() {
        return $this->hasOne(Products::class,'id','product_id');
    }

    public function getTransactionDateAttribute( $value ) {
        return Carbon::parse($value)->format('d-m-Y');
    }


}
