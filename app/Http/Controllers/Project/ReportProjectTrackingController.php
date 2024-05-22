<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\Plan\Depratment;
use App\Models\Project\DepartmentActivity;
use App\Models\Project\Project;
use App\Models\Project\ReportProjectTracking;
use Carbon\Carbon;
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
        // $project->percentage        = $request->percentage;
        $project->department_activity_id        = $request->department_activity_id;

        $project->save();

        // $reject_activity = ReportProjectTracking::find($request->report_project_tracking_id);

        // $reject_activity->update(['reject_comment_activity' => $request->reject_comment_activity]);

        $update_number_reject_activity = $project->find($request->department_activity_for_add);
        if($update_number_reject_activity != null){

            // dd($update_number_reject_activity);
            $update_number_reject_activity->update([
                'number'=> 1,
            ]);
        }

        return redirect()->back()->with('success', 'گزارش شما ارسال گردید.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, string $department_id,string $project_tracking_id)
    {
        $project = Project::with('units','impliment_departments','management_departments','design_departments')->find($id);
        $reports = ReportProjectTracking::with('department_reprot','department_activities')
                                        ->where('project_id','=',$id)
                                        ->where('department_id','=',$department_id)->get();

        $department_activity_for_add_after_insert = ReportProjectTracking::with('department_reprot','department_activities')
                                                    ->where('project_id','=',$id)
                                                    ->where('department_id','=',$department_id)
                                                    ->where('reject_activity','!=',null)
                                                    ->where('number','=',0)->first();

        // dd($department_activity_for_add);
        $total_percentage = ReportProjectTracking::where('report_project_tracking.project_id', $id)
        ->where('report_project_tracking.department_id', $department_id)
        ->where('report_project_tracking.reject_activity', null)
        ->join('department_activities', 'department_activities.id', '=', 'report_project_tracking.department_activity_id')
        ->sum('department_activities.acitvity_percentage');


        if($project->procurement_type == '1'){
            $department_activities = DepartmentActivity::with('department_activities')->where('department_id','=',$department_id)
                ->where('status','=','1')
                ->orderBy('sort_of_activity','asc')->get();

            if($project->impliment_departments->first()->name_da =='سکتور خصوصی'or $project->impliment_departments->first()->name_da =='سکتور_خصوصی'){
                    if($department_activities != null and $department_activities->first()->department_activities->first()->name_da == 'ریاست تدارکات' or $department_activities->first()->department_activities->first()->name_da == 'ریاست_تدارکات'){

                        $depratment = Depratment::where('name_da','LIKE','%تدارکات%')
                        ->where('name_da','LIKE','%ملی%')
                        ->where('status','=','1')
                        ->first();

                        $department_activities = DepartmentActivity::with('department_activities')->where('department_id','=',$depratment->id)
                        ->where('status','=','1')
                        ->orderBy('sort_of_activity','asc')->get();
                    }

            }else{
                $department_activities = DepartmentActivity::with('department_activities')->where('department_id','=',$department_id)
                                                        ->where('status','=','1')
                                                        ->orderBy('sort_of_activity','asc')->get();
            }
                // dd($department_activities);
        }else{
            $department_activities = DepartmentActivity::with('department_activities')->where('department_id','=',$department_id)
                                                        ->where('status','=','1')
                                                        ->orderBy('sort_of_activity','asc')->get();
        }
        return view('project.report_project_tracking', compact('project','reports','department_id','id','total_percentage','project_tracking_id','department_activities','department_activity_for_add_after_insert'));

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

    public function reject_activity(Request $request)
    {
            $request->validate([
                'reject_comment_activity' => ['required'],
                'report_project_tracking_id' => ['required','exists:report_project_tracking,id'],
                // 'number' => 1+1,
            ]);

            $reject_activity = ReportProjectTracking::find($request->report_project_tracking_id);

            $reject_activity->update(['reject_comment_activity' => $request->reject_comment_activity]);

            $reject_activity->where('project_id','=',$reject_activity->project_id)
                            ->where('project_tracking_id','=',$reject_activity->project_tracking_id)
                            ->where('id','>=',$reject_activity->id)
                            ->update([
                                'reject_activity'=> Carbon::now(),
                            ]);

        return redirect()->back()->with('success', 'فعالیت شما رد شد');
    }

}
