<?php

namespace App\Models;

use App\Models\Scopes\BranchScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Districts extends Model
{
    use HasFactory, SoftDeletes;
    // protected $table ="countries";

    public function state(): BelongsTo
    {
        return $this->belongsTo(States::class);
    }

}
