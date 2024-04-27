<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\Plan\Depratment;
use App\Models\Plan\District;
use App\Models\Plan\Goal;
use App\Models\Plan\GoalCategory;
use App\Models\Plan\Unit;
use App\Models\Project\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $projects = Project::with('goals','units','impliment_departments','management_departments','design_departments')->get();
        return view('project.project', compact('projects'));
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
            'name' => ['required', 'string','unique:'.Project::class],
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

        return redirect()->route('project.index')->with('success', 'پروژه جدید اضافه کردید.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        $project = Project::find($id);

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
        
        $update = Project::find($id);
        
        $update->update([
            'goal_id' => $request->goal_id,
            'name' => $request->name,
            'length' => $request->length,
            'width' => $request->width,
            'number' => $request->number,
            'unit_id' => $request->unit_id,
            'impliment_department_id' => $request->impliment_department_id,
            'management_department_id' => $request->management_department_id,
            'design_department_id' => $request->design_department_id,
        ]);

        $update->districts()->sync($request->input('district_id'));

     
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
