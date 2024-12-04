<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tripsheets extends Model
{
    use HasFactory; 

    // public function driver(): BelongsTo
    // {
    //     return $this->belongsTo(Drivers::class, 'vehicle_id');
    // }

    public function vehicle()
    {
        return $this->hasOne(Vehicles::class, 'id','vehicle_id');
    }

    public function vendor()
    {
        return $this->hasOne(Vendors::class, 'id','vendor_id');
    }


    
}
