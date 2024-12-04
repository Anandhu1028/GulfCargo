<?php

namespace App\Models;

use App\Models\Scopes\BranchScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use SebastianBergmann\CodeCoverage\Driver\Driver;

class Shipments extends Model
{
    use HasFactory, SoftDeletes;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new BranchScope());
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branches::class);
    }

    public function prevBranch(): BelongsTo
    {
        return $this->belongsTo(Branches::class);
    }

    public function created_by(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function updated_by(): BelongsTo
    {
        return $this->belongsTo(User::class);
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
        return $this->hasMany(Boxes::class,'shipment_id');
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

    public function shipmentTransfer(): BelongsTo
    {
        return $this->belongsTo(ShipmentTransfers::class);
    }

    public function movingType()
    {
        return $this->hasOne(MovingTypes::class, 'id','moving_type');
    }

    public function shipMethType()
    {
        return $this->hasOne(ShipTypes::class, 'id','shipping_method_id');
    }



}
