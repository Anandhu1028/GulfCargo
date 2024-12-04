<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShipmentsStatuses extends Model
{
    use HasFactory, SoftDeletes;

    public function shipment(): BelongsTo
    {
        return $this->belongsTo(Shipments::class,"shipment_id");
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Statuses::class,'statuses_id');
    }
}
