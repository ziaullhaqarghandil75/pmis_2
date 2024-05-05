<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\Plan\Depratment;
use App\Models\Project\Project;
use App\Models\Project\ProjectTracking;
use App\Models\Project\ReportProjectTracking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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

        $project_trackings = ProjectTracking::with('project_departments','project_projcts')->where('project_id','=',$id)->get();
        $percentage_project_trackings = ReportProjectTracking::where('project_id','=',$id)->get();
        $departments = Depratment::where('status','=','1')->get();
        // $current_department = Depratment::where('status','=','1')->where('id','=',auth::user()->department_id)->pluck('id');

        $project = Project::with('goals','units','impliment_departments','management_departments','design_departments')->find($id);
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


        if($request->department_id == '0'){
            return redirect()->route('project_tracking.show',$id)->with('warning', 'لطفا دیپارتمنت را انتخاب نماید.');
        }

        $date = Carbon::now();

        $project_name = Project::select('name')->find($id);
        $ProjectTracking = new ProjectTracking();

        // start check for percentage
        $current_department_id = $ProjectTracking->where('project_id','=',$id)->orderByDesc('id')->first();
        // dd($current_department_id);
        if(!$current_department_id  == null){

            $recprot_current_department_percentage = ReportProjectTracking::where('project_id','=',$id)
                                                                            ->where('department_id','=',$current_department_id->department_id)
                                                                            ->sum('percentage');

            if($recprot_current_department_percentage < 100){
                return redirect()->back()->with('warning', 'فیصدی کار انجام کم است .');
            }
        }
        // end check for percentage

            $request->validate([
                'file' => ['required','mimes:pdf,PDF'],
                'description' => ['required'],
            ]);

            //  check select dpartment
            if($request->department_id == '0'){
                return redirect()->route('project_tracking.show',$id)->with('warning', 'لطفا دیپارتمنت را انتخاب نماید.');
            }


            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $extension = $file->getClientOriginalExtension();
                $fileName = $date->format('Y-m-d').'-'.time().'.'.$extension;
                $path = 'project_file/'.$project_name->name.'/';
                $file->move($path, $fileName);
            }

            // here we will insert product in db

            $ProjectTracking->project_id = $id;
            $ProjectTracking->department_id = $request->department_id;
            $ProjectTracking->description = $request->description;
            $ProjectTracking->file = $path.$fileName;
            $ProjectTracking->date_of_send = $request->date_of_send;
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
}
