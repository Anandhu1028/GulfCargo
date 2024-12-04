<?php

namespace App\Models;

use App\Models\Scopes\BranchScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Boxes extends Model
{
    use HasFactory ;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new BranchScope());
    }

    public function shipment(): BelongsTo
    {
        return $this->belongsTo(Shipments::class,'shipment_id');
    }

    public function packages()
    {
        return $this->hasMany(Packages::class,'box_id');
    }

    public function boxDimension(): BelongsTo
    {
        return $this->belongsTo(BoxDimensions::class,'box_dimension_id','id');
    }

    public function shipmentStatuses()
    {
        return $this->hasMany(ShipmentsStatuses::class,'box_id');
    }

    public function boxStatuses()
    {
        return $this->hasMany(BoxesStatuses::class,'box_id');
    }

    public function boxTransfer()
    {
        return $this->hasMany(ShipmentTransfers::class,'box_id');
    }
    public function ships()
    {
        return $this->hasOne(Ships::class, 'id');
    }

    public function shipments()
    {
        return $this->belongsTo(Shipments::class);
    }

    public function customer()
    {
        return $this->shipments->customer();
    }
    public function sender(): BelongsTo
    {
        return $this->belongsTo(Customers::class);
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(Customers::class);
    }


    public function getShip(): BelongsTo
    {
        return $this->belongsTo(Ships::class,'ship_id','id');
    }




}
