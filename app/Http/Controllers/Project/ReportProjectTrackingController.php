<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\Project\Project;
use App\Models\Project\ReportProjectTracking;
use Illuminate\Http\Request;

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
        // if(!(auth::user()->can('add_project') and auth::user()->can('projects'))){
        //     return view('layouts.403'); 
        // }
        $request->validate([
            'percentage' => ['required', 'numeric','between:0,100'],
            'description' => ['required', 'string'],
        ]);
        // dd($request->all());

        // here we will insert product in db
        $project = new ReportProjectTracking();
        $project->project_id        = $request->project_id;
        $project->department_id     = $request->department_id;
        $project->project_tracking_id     = $request->project_tracking_id;
        $project->description       = $request->description;
        $project->percentage        = $request->percentage;
    
        $project->save();
        
        return redirect()->back()->with('success', 'گزارش شما ارسال گردید.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, string $department_id,string $project_tracking_id)
    {       
        $project = Project::with('goals','units','impliment_departments','management_departments','design_departments')->find($id);
        $reports = ReportProjectTracking::with('department_reprot')->where('project_id','=',$id)->where('department_id','=',$department_id)->get();
        
        $percentage = ReportProjectTracking::with('department_reprot')
                                            ->where('project_id','=',$id)
                                            ->where('department_id','=',$department_id)
                                            ->sum('percentage');

        // $percentage = ReportProjectTracking::->purple();
        // dd($reports);
        return view('project.report_project_tracking', compact('project','reports','department_id','id','percentage','project_tracking_id'));

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
