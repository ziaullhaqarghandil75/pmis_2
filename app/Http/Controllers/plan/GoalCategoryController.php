<?php

namespace App\Http\Controllers\Plan;

use App\Http\Controllers\Controller;
use App\Models\Plan\Goal;
use App\Models\Plan\GoalCategory;
use Illuminate\Http\Request;

class GoalCategoryController extends Controller
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
        $request->validate([
            'name' => 'required',
        ]);

        // here we will insert product in db
        $goal_category = new GoalCategory();
        $goal_category->name = $request->name;
        $goal_category->save();

        return redirect()->route('goal.index')->with('success', 'دسته بندی هدف شما اضافه شد.');
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
        
        $edit_goal_category = GoalCategory::find($id);

        $goal_categories = GoalCategory::get();
        $edit_goal = false;
        
        $goals = Goal::with('goal_categories')->get();
        return view('plan.goal', compact('edit_goal_category','goal_categories','goals','edit_goal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $update = GoalCategory::find($id);
        $update->update([
            'name' => $request->name,
        ]);
        return redirect()->route('goal.index')->with('success', ' معلومات دسته بندی شما ویرایش شد.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete = GoalCategory::find($id);
        $delete->delete();
        return redirect()->route('goal.index')->with('warning', 'دسته بندی هدف حذف گردید.');
    }
}