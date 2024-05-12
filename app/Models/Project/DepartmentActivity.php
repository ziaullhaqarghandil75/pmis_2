<?php

namespace App\Models\Project;

use App\Models\Plan\Depratment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentActivity extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function department_activities()
    {
        return $this->hasMany(Depratment::class,"id","department_id");
    }
    // public function department_activities()
    // {
    //     return $this->hasMany(Depratment::class,"id","department_id");
    // }
}
