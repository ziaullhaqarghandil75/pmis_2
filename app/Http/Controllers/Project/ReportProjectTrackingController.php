<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\Project\DepartmentActivity;
use App\Models\Project\Project;
use App\Models\Project\ReportProjectTracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportProjectTrackingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(!(Auth::user()->can('add_project_tracking'))){
            return view('layouts.403');
        }
        $request->validate([
            // 'percentage' => ['required', 'numeric','between:0,100'],
            'description' => ['required', 'string'],
            'department_activity_id' => ['required','numeric'],
        ]);
        // dd($request->all());

        // here we will insert product in db
        $project = new ReportProjectTracking();
        $project->project_id        = $request->project_id;
        $project->department_id     = $request->department_id;
        $project->project_tracking_id     = $request->project_tracking_id;
        $project->description       = $request->description;
        $project->percentage        = $request->percentage;
        $project->department_activity_id        = $request->department_activity_id;

        $project->save();

        return redirect()->back()->with('success', 'گزارش شما ارسال گردید.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, string $department_id,string $project_tracking_id)
    {
        $project = Project::with('goals','units','impliment_departments','management_departments','design_departments')->find($id);
        $reports = ReportProjectTracking::with('department_reprot','department_activities')->where('project_id','=',$id)->where('department_id','=',$department_id)->get();


        $total_percentage = ReportProjectTracking::where('report_project_tracking.project_id', $id)
        ->where('report_project_tracking.department_id', $department_id)
        ->join('department_activities', 'department_activities.id', '=', 'report_project_tracking.department_activity_id')
        ->sum('department_activities.acitvity_percentage');

        $department_activity_for_add = DepartmentActivity::where('department_id','=',$department_id)
                                                    ->where('status','=','1')->get();

        $department_activities = DepartmentActivity::where('department_id','=',$department_id)
                                                    ->where('status','=','1')
                                                    ->orderBy('sort_of_activity','asc')->get();

        return view('project.report_project_tracking', compact('project','reports','department_id','id','total_percentage','project_tracking_id','department_activities'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

}
