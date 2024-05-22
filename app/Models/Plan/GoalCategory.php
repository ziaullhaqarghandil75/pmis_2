<?php

namespace App\Models\Plan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoalCategory extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function goals(){
        return $this->hasMany(Goal::class,'id','goal_id');
    }
}
