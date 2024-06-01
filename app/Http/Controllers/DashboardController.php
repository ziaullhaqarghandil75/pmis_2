<?php

namespace App\Http\Controllers;

use App\Models\Project\Project;
use App\Models\Project\ProjectTracking;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::count();
        $all_project = Project::count();
        $all_projects = Project::with('impliment_departments','management_departments','design_departments','project_trackings','project_trackings.project_tracking_details.department_activities')->get();
        $in_progress_project = 0;
        $completed_project = 0;

        foreach($all_projects as $all_project_in_progress_and_completed){
            // dd(!$all_project->project_trackings->isEmpty());
            if(!$all_project_in_progress_and_completed->project_trackings->isEmpty() and $all_project_in_progress_and_completed->closed_project == '0'){
                $in_progress_project +=1;
            }
            if(!$all_project_in_progress_and_completed->project_trackings->isEmpty() and $all_project_in_progress_and_completed->closed_project == '1'){
                $completed_project +=1;
            }


        }
        // dd($users);
        return view('dashboard', compact('users','all_project','in_progress_project','completed_project'));
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
        //
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
