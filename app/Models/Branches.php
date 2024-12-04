<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branches extends Model
{
    use HasFactory, SoftDeletes;


    public function admin()
    {
        $staff = Staffs::where("branch_id", $this->id)->first();
        return $staff->user ?? "";
    }


}
