<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\Plan\Depratment;
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
        $projects = Project::get();
        
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
        $departments = Depratment::where('status','=',1)->get();

        return view('project.add_project',compact('goles','units','departments'));
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
