<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\Plan\Depratment;
use App\Models\Plan\District;
use App\Models\Plan\Goal;
use App\Models\Plan\GoalCategory;
use App\Models\Plan\Unit;
use App\Models\Project\budgets;
use App\Models\Project\Project;
use App\Models\Project\ProjectTracking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(!(auth::user()->can('view_project') and Auth::user()->can('projects'))){
            return view('layouts.403');
        }

        if((auth::user()->can('show_all_projects'))){
            $project_trackings = false;
            $projects = Project::with('goals','units','impliment_departments','management_departments','design_departments')->orderByDesc('id')->get();
        }else{

            $project_trackings = ProjectTracking::with('project_projcts','project_departments')->where('department_id','=',auth::user()->department_id)->orderByDesc('id')->get();

            $projects = Project::with('goals','units','impliment_departments','management_departments','design_departments')->orderByDesc('id')->get();
        }
        return view('project.project', compact('projects','project_trackings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(!(auth::user()->can('add_project') and auth::user()->can('projects'))){
            return view('layouts.403');
        }
        $goles = GoalCategory::get();
        $units = Unit::get();
        $depratments = Depratment::where('status','=','1')->get();
        $districts = District::get();

        return view('project.add_project',compact('goles','units','depratments','districts','districts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(!(auth::user()->can('add_project') and auth::user()->can('projects'))){
            return view('layouts.403');
        }
        $request->validate([
            'name'                      => 'required|string|unique:projects',
            'number'                    => 'required_without_all:width,length_p',
            'width'                     => 'required_without_all:number',
            'length_p'                  => 'required_without_all:number',
            'unit_id'                   => 'required|exists:units,id',
            'goal_id'                   => 'required|exists:goal_categories,id',
            'impliment_department_id'   => 'required|exists:departments,id',
            'management_department_id'  => 'required|exists:departments,id',
            'design_department_id'      => 'required|exists:departments,id',
            'district_id'               => 'required|exists:districts,id',
            'main_budget'               => 'required|numeric',
            'for_this_year'             => 'required|numeric|lte:main_budget',
        ]);
        // dd($request->all());

        // here we will insert product in db
        $project = new Project();
        $project->goal_id                      = $request->goal_id;
        $project->name                         = $request->name;
        $project->length                       = $request->length;
        $project->width                        = $request->width;
        $project->number                       = $request->number;
        $project->unit_id                      = $request->unit_id ;
        $project->impliment_department_id      = $request->impliment_department_id  ;
        $project->management_department_id     = $request->management_department_id   ;
        $project->design_department_id         = $request->design_department_id    ;
        $project->save();

        $project->districts()->sync($request->input('district_id'));

        $budget = new budgets();
        $budget->project_id         = $project->id;
        $budget->department_id      = auth()->user()->department_id;
        $budget->year               = Carbon::now()->format('Y');
        $budget->main_budget        = $request->main_budget;
        $budget->for_this_year      = $request->for_this_year;
        $budget->save();

        return redirect()->route('project.index')->with('success', 'پروژه جدید اضافه کردید.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $project = Project::with('goals','units','impliment_departments','management_departments','design_departments')->find($id);
        return view('project.details_project',compact('project'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if(!(auth::user()->can('edit_project') and auth::user()->can('projects'))){
            return view('layouts.403');
        }
        $goals = GoalCategory::get();
        $units = Unit::get();
        $depratments = Depratment::where('status','=','1')->get();
        $districts = District::get();

        $project = Project::with('budgets')->find($id);

        return view('project.edit_project',compact('project','goals','units','depratments','districts','districts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if(!(auth::user()->can('edit_project') and auth::user()->can('projects'))){
            return view('layouts.403');
        }
        // dd($request);
        $request->validate([
            'name'                      => ['required','string',Rule::unique('projects')->ignore($id)],
            'number'                    => 'required_without_all:width,length_p',
            'width'                     => 'required_without_all:number',
            'length_p'                  => 'required_without_all:number',
            'unit_id'                   => 'required|exists:units,id',
            'goal_id'                   => 'required|exists:goal_categories,id',
            'impliment_department_id'   => 'required|exists:departments,id',
            'management_department_id'  => 'required|exists:departments,id',
            'design_department_id'      => 'required|exists:departments,id',
            'district_id'               => 'required|exists:districts,id',
            'main_budget'               => 'required|numeric',
            'for_this_year'             => 'required|numeric|lte:main_budget',
        ]);

        $update = Project::find($id);

        $update->update([
            'goal_id' => $request->goal_id,
            'name' => $request->name,
            'length' => $request->length_p,
            'width' => $request->width,
            'number' => $request->number,
            'unit_id' => $request->unit_id,
            'impliment_department_id' => $request->impliment_department_id,
            'management_department_id' => $request->management_department_id,
            'design_department_id' => $request->design_department_id,
        ]);

        $update->districts()->sync($request->input('district_id'));

        $budget = budgets::where('project_id','=',$id)->where('department_id','=',auth()->user()->department_id)->first();
        $budget->update([
            'main_budget' => $request->main_budget,
            'for_this_year' => $request->for_this_year,
        ]);

        return redirect()->route('project.index')->with('success', ' معلومات پروژه شما ویرایش شد.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(!(auth::user()->can('delete_project') and auth::user()->can('projects'))){
            return view('layouts.403');
        }
        $delete = Project::find($id);

        $delete->delete();
        return redirect()->route('project.index')->with('warning', 'پروژه شما حذف گردید.');
    }
}
