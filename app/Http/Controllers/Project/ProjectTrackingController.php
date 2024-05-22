<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\Plan\Depratment;
use App\Models\Project\budgets;
use App\Models\Project\Project;
use App\Models\Project\ProjectTracking;
use App\Models\Project\ReportProjectTracking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Morilog\Jalali\Jalalian;

class ProjectTrackingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if(!(auth::user()->can('view_project_tracking'))){
            return view('layouts.403');
        }
        $project = Project::with('units','impliment_departments','management_departments','design_departments')->find($id);

        $project_trackings = ProjectTracking::with('project_departments','project_projcts')->where('project_id','=',$id)->get();
        $percentage_project_trackings = ReportProjectTracking::where('project_id','=',$id)->get();

        $departments = Depratment::where('status','=','1')->get();

        return view('project.project_tracking', compact('project','departments','project_trackings','percentage_project_trackings'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        if(!(auth::user()->can('add_project_tracking'))){
            return view('layouts.403');
        }

        $date = Carbon::now();

        $project = Project::select('name','design_department_id')->find($id);

        $ProjectTracking = new ProjectTracking();
        // start check for percentage and budget
        $current_department_id = $ProjectTracking->where('project_id','=',$id)->orderByDesc('id')->first();


        if(!$current_department_id  == null){

            $current_department_percentage = ReportProjectTracking::where('report_project_tracking.project_id', $id)
            ->where('report_project_tracking.department_id', $current_department_id->department_id)
            ->where('report_project_tracking.reject_activity', null)
            ->join('department_activities', 'department_activities.id', '=', 'report_project_tracking.department_activity_id')
            ->sum('department_activities.acitvity_percentage');


            if($current_department_percentage < 100){
                return redirect()->back()->with('warning', 'فیصدی فعالیت انجام کم است .');
            }

            if($project->design_department_id == $current_department_id->department_id ){

                $budget = Budgets::where('project_id','=',$id)->first();
                if($budget->budget_after_design == 0 or $budget->budget_after_design == null){
                    return redirect()->back()->with('warning', 'لطفا بودیجه بعد از دیزاین را اضافه نماید .');

                }
            }
            $current_department_for_Check_contract_budget = $current_department_id->project_departments()->first();

            if(    $current_department_for_Check_contract_budget->name_da == 'ریاست تدارکات'
                or $current_department_for_Check_contract_budget->name_da == 'تدارکات'
                or $current_department_for_Check_contract_budget->name_da == 'ریاست_تدارکات'
            ){
                $budget = Budgets::where('project_id','=',$id)->first();
                if($budget->contract_budget == 0 or $budget->contract_budget == null){
                    return redirect()->back()->with('warning', 'لطفا بودیجه قرار داد شده را اضافه نماید .');
                }
            }
        }

        // end check for percentage and budget

            $request->validate([
                'file' => ['required','mimes:pdf,PDF'],
                'description' => ['required'],
                'department_id' => ['required'],
            ]);

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $extension = $file->getClientOriginalExtension();
                $fileName = $date->format('Y-m-d').'-'.time().'.'.$extension;
                $path = 'project_file/'.$project->name.'/';
                $file->move($path, $fileName);
            }

            $ProjectTracking->project_id = $id;
            $ProjectTracking->department_id = $request->department_id;
            $ProjectTracking->description = $request->description;
            $ProjectTracking->file = $path.$fileName;
            $ProjectTracking->date_of_send = Jalalian::fromFormat('Y/m/d', $request->date_of_send)->toCarbon();
            $ProjectTracking->save();


        return redirect()->route('project_tracking.show',$id)->with('success', 'پروژه شما ارسال گردید.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function add_budget_after_design(Request $request, string $id)
    {

        if(!(auth::user()->can('add_budget_after_design'))){
            return view('layouts.403');
        }

        $budget = new budgets();

        $budget = $budget->where('project_id','=',$id)->first();


            $request->validate([
                'budget_after_design' => ['required','numeric'],
            ]);
            $budget->update([
                'budget_after_design' => $request->budget_after_design,
            ]);


        return redirect()->route('project_tracking.show',$id)->with('success', 'بودیجه شما اضافه گردید.');
    }
    public function add_contract_budget(Request $request, string $id)
    {

        if(!(auth::user()->can('add_contract_budget'))){
            return view('layouts.403');
        }

        $budget = new budgets();

        $budget = $budget->where('project_id','=',$id)->first();


            $request->validate([
                'contract_budget' => ['required','numeric'],
            ]);
            $budget->update([
                'contract_budget' => $request->contract_budget,
            ]);


        return redirect()->route('project_tracking.show',$id)->with('success', 'بودیجه شما اضافه گردید.');
    }
    public function changes_procurement_type(Request $request, string $id)
    {

        // if(!(auth::user()->can('add_contract_budget'))){
        //     return view('layouts.403');
        // }

        // $project = new Project();
        $procurement_type_update = Project::find($id);
        // dd($procurement_type_update);
        $procurement_type_update->update([
            'procurement_type' => '1',
        ]);
        return redirect()->back()->with('success', 'حالت تدارکاتی شما تغیر کرد.');
    }
}
