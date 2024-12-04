<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerAddresses extends Model
{
    use HasFactory, SoftDeletes;

    public function country(): BelongsTo
    {
        return $this->belongsTo(Countries::class);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(States::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(Cities::class);
    }
    public function district(): BelongsTo
    {
        return $this->belongsTo(Districts::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customers::class);
    }
}
