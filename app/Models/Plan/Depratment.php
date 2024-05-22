<?php

namespace App\Models\Plan;

use App\Models\Project\ReportProjectTracking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depratment extends Model
{
    use HasFactory;
    protected $table = 'departments';
    protected $guarded = [];

    // public function reprot_project_tracking_departments(){
    //     return $this->belongsTo(ReportProjectTracking::class,'project_id','id');
    // }
     public function reprot_project_tracking_departments()
    {
        return $this->hasMany(ReportProjectTracking::class,'department_id');
    }

}
