<?php

namespace App\Models;

use App\Models\Scopes\BranchScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Salesman extends Model
{
    use HasFactory ;
    protected $table = "salesman";

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new BranchScope());
    }
      
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicles::class);
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Drivers::class);
    }
}
