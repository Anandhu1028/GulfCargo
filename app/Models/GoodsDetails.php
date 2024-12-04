<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; 

class GoodsDetails extends Model
{
    use HasFactory;


    public function shipmentTransfer(): BelongsTo
    {
        return $this->belongsTo(ShipmentTransfers::class, "shipment_transfer_id");
    }

    public function transferTo(): BelongsTo
    {
        return $this->belongsTo(Branches::class,"transfer_to");
    }

    public function transferFrom(): BelongsTo
    {
        return $this->belongsTo(Branches::class,"transfer_from");
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(Customers::class);
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(Customers::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Companies::class);
    }

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agencies::class);
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Drivers::class);
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staffs::class);
    }

    public function status()
    {
        return $this->belongsToMany(Statuses::class)->withTimestamps();
    }

    public function statusVal()
    {
        return $this->hasOne(Statuses::class, 'id','status_id');
    }

    public function packages()
    {
        return $this->hasMany(Packages::class,'shipment_id');
    }

    public function boxes()
    {
        return $this->hasOne(Boxes::class, 'id','box_id');

    }

    public function shipType()
    {
        return $this->hasOne(ShipTypes::class, 'id','ship_id');
    }

    public function shipmentStatus()
    {
        return $this->hasMany(ShipmentsStatuses::class, 'shipments_id','id');
    }

    public function bookingNumberStatus()
    {
        return $this->hasMany(StatusesBookingNumber::class, 'booking_id','id');
    }

    public function currentStatus()
    {
        return $this->hasOne(BoxesStatuses::class, 'id','current_status_id');
    }

    public function vendorDetails()
    {
        return $this->hasOne(Vendors::class, 'id','vendor');

    }

    
}
