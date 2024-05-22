<?php

namespace App\Models\Project;

use App\Models\Plan\Depratment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportProjectTracking extends Model
{
    use HasFactory;
    protected $table = 'report_project_tracking';
    protected $guarded = [];

    public function department_reprot(){
        return $this->hasMany(Depratment::class,'id');
    }
    public function department_activities(){
        return $this->hasMany(DepartmentActivity::class,'id','department_activity_id');
    }
    public function department()
    {
        return $this->belongsTo(Depratment::class);
    }
}
