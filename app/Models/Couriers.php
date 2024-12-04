<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\BranchScope; 
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Couriers extends Model
{
    use HasFactory;

    protected $table ="couriers";

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

    public function couriertems()
    {
        return $this->hasMany(CourierItems::class,'courier_id');
    } 

    public function statusVal()
    {
        return $this->hasOne(Statuses::class, 'id','status_id');
    }

}
