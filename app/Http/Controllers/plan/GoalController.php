<?php

namespace App\Http\Controllers\Plan;

use App\Http\Controllers\Controller;
use App\Models\Plan\Goal;
use App\Models\Plan\GoalCategory;
use Illuminate\Http\Request;

class GoalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $goal_categories = GoalCategory::with('goals')->get();

        $goals = Goal::get();
        $edit_goal_category = false;
        $edit_goal = false;

        return view('plan.goal', compact('goal_categories','goals','edit_goal_category','edit_goal'));
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
            'goal_name' => 'required|unique:'.Goal::class,
        ]);

        // here we will insert product in db
        $goal_category = new Goal();
        $goal_category->goal_name = $request->goal_name;
        $goal_category->save();

        return redirect()->route('goal.index')->with('success', 'هدف شما اضافه شد.');
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
        $edit_goal_category = false;

        $edit_goal = Goal::find($id);
        $goal_categories = GoalCategory::get();
        $goals = Goal::get();

        return view('plan.goal', compact('goal_categories','goals','edit_goal','edit_goal_category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'goal_name' => 'required',
        ]);
        $update = Goal::find($id);
        $update->update([
            'goal_name' => $request->goal_name,
        ]);
        return redirect()->route('goal.index')->with('success', ' معلومات هدف شما تصحیح شد.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete = Goal::find($id);
        $delete->delete();
        return redirect()->route('goal.index')->with('warning', 'هدف حذف گردید.');
    }
}
