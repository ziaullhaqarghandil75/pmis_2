<?php

namespace App\Models\Project;

use App\Models\Plan\Depratment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectTracking extends Model
{
    use HasFactory;
    public function project_departments()
    {
        return $this->hasMany(Depratment::class,"id","department_id");
    }
    public function project_projcts()
    {
        return $this->hasMany(Project::class,"id","project_id");
    }
    public function percentage_project_view()
    {
        return $this->belongsTo(ReportProjectTracking::class,'id','project_tracking_id');
    }
}
