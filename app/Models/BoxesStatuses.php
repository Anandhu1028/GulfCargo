<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class BoxesStatuses extends Model
{
    use HasFactory, SoftDeletes;

    public function status(): BelongsTo
    {
        return $this->belongsTo(Statuses::class,'status_id');
    }
}
