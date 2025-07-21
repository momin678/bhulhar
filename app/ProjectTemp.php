<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectTemp extends Model
{
    public function items()
    {
        return $this->hasMany(projectItemTemp::class,'pro_id');
    }
}
