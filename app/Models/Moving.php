<?php

namespace App\Models;

use App\Models\Scopes\BranchScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Moving extends Model
{
    use HasFactory;


    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new BranchScope());
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branches::class);
    }


    public function sender(): BelongsTo
    {
        return $this->belongsTo(Customers::class);
    }

    public function sourcecity(): BelongsTo
    {
        return $this->belongsTo(Cities::class,'source_city');   
    }
    public function destinationcity(): BelongsTo
    {
        return $this->belongsTo(Cities::class,'destination_city');   
    }

    public function movingItems()
    {
        return $this->hasMany(MovingItems::class,'moving_id');
    }

    public function movingDismantling()
    {
        return $this->hasMany(MovingDismantling::class,'moving_id');
    }

    public function statusVal()
    {
        return $this->hasOne(Statuses::class, 'id','status_id');
    }


}
