<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourierItems extends Model
{
    use HasFactory;

    public function courier(): BelongsTo
    {
        return $this->belongsTo(Couriers::class);
    }
}
