<?php

namespace App\Models;


use App\Models\Scopes\BranchScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Scope;


class Staffs extends Model
{
    use HasFactory, SoftDeletes;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new BranchScope());
    }

    public function scopeNotadmin($query)
    {
        return $query->where('role', '!=', 'admin');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branches::class);
    }

    public function visaType(): BelongsTo
    {
        return $this->belongsTo(VisaTypes::class);
    }

    public function documentType(): BelongsTo
    {
        return $this->belongsTo(DocumentTypes::class);
    }

    public function attendence()
    {
        return $this->hasMany(Attendence::class,'staff_id');
    }

}
