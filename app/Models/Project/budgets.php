<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budgets extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function year_budgets(){
        return $this->hasMany(YearBudget::class,'budget_id','id');
    }
}
