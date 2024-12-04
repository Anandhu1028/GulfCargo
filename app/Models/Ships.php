<?php

namespace App\Models;


use App\Models\Scopes\BranchScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ships extends Model
{
    use HasFactory, SoftDeletes;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new BranchScope());
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(Staffs::class, 'created_by');
    }

    public function shipmentStatus(): BelongsTo
    {
        return $this->belongsTo(Statuses::class, 'shipment_status');
    }

    public function portOfOrigins(): BelongsTo
    {
        return $this->belongsTo(PortOfOrigins::class, 'port_of_origin_id');
    }

    public function portOfDestinations(): BelongsTo
    {
        return $this->belongsTo(PortOfOrigins::class, 'port_of_destination_id');
    }

    public function clearingAgents(): BelongsTo
    {
        return $this->belongsTo(Agencies::class, 'clearing_agent_id');
    }


    public function shipmentTypes()
    {
        return $this->belongsTo(ShipmentTypes::class, 'shipment_type_id');
    }

    public function shipmentMethodTypes()
    {
        return $this->belongsTo(ShipTypes::class, 'shipment_type_id');
    }

    public function shipsBookings(): BelongsTo
    {
        return $this->belongsToMany(ShipsBookings::class, 'ship_id');
    }

    public function origin(): BelongsTo
    {
        return $this->belongsTo(Branches::class, 'branch_id');
    }

    // public function trasnferredBranch(): BelongsTo
    // {
    //     return $this->belongsToMany(ShipsBookings::class, 'trasnfer_branch_id');
    // }


}
