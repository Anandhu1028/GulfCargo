<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; 

class ShipmentTransfers extends Model
{
    use HasFactory ;

    public function shipment(): BelongsTo
    {
        return $this->belongsTo(Shipments::class,"shipment_id");
    }

    public function transferTo(): BelongsTo
    {
        return $this->belongsTo(Branches::class,"transfer_to");
    }

    public function transferFrom(): BelongsTo
    {
        return $this->belongsTo(Branches::class,"transfer_from");
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Drivers::class,"driver_id");
    }


    
}
