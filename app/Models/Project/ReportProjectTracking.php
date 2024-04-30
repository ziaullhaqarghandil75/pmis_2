<?php

namespace App\Models\Project;

use App\Models\Plan\Depratment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportProjectTracking extends Model
{
    use HasFactory;
    protected $table = 'report_project_tracking';

    public function department_reprot(){
        return $this->hasMany(Depratment::class,'id');
    }
}
