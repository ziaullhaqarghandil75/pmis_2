<?php

namespace App\Models\Plan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    use HasFactory;
    protected $fillable = [
        'goal_name',
        'gole_category_id',
    ];

    public function goal_categories(){
        return $this->hasMany(GoalCategory::class,'id','gole_category_id');
    }
}
