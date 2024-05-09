<?php

namespace App\Models\Project;

use App\Models\Plan\Depratment;
use App\Models\Plan\District;
use App\Models\Plan\GoalCategory;
use App\Models\Plan\Unit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{

    use HasFactory;
    protected $guarded = [];
    public function goals(){
        return $this->hasMany(GoalCategory::class,"id","goal_id");
    }
    public function units(){
        return $this->hasMany(Unit::class,"id","unit_id");
    }
    public function impliment_departments(){
        return $this->hasMany(Depratment::class,"id","impliment_department_id");
    }
    public function management_departments(){
        return $this->hasMany(Depratment::class,"id","management_department_id");
    }
    public function design_departments(){
        return $this->hasMany(Depratment::class,"id","design_department_id");
    }
    public function districts()
    {
        return $this->belongsToMany(District::class,'project_districts');
    }
    public function budgets()
    {
        return $this->hasMany(budgets::class);
    }

}
