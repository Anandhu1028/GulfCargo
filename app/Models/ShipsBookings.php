<?php

namespace App\Models;

use App\Models\Scopes\BranchScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShipsBookings extends Model
{
    use HasFactory;
    
    protected $table ="ships_bookings";

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new BranchScope());
    }


    public function shipment(): BelongsTo
    {
        return $this->belongsTo(Shipments::class,"booking_id");
    }


    public function ship(): BelongsTo
    {
        return $this->belongsTo(Ships::class);
    }
 
}
