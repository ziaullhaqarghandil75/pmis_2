<?php

namespace App\Http\Controllers\Plan;

use App\Http\Controllers\Controller;
use App\Models\Plan\Depratment;
use Illuminate\Http\Request;

class DepratmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() 
    {
        $departments = Depratment::get();
        return view('plan.department', compact('departments'));
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
            'name_da' => 'required|unique:departments',
            'name_en' => 'required|unique:departments',
            'status' => 'required',
        ]);

        // here we will insert product in db
        $depratment = new Depratment();
        $depratment->name_da = $request->name_da;
        $depratment->name_en = $request->name_en;
        $depratment->status = $request->status;
        $depratment->save();

        return redirect()->route('department.index')->with('success', 'دیپارتمنت شما اضافه شد.');
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
        $department = Depratment::find($id);
        return view('plan.edit_department', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $update = Depratment::find($id);
        $update->update([
            'name_da' => $request->name_da,
            'name_en' => $request->name_en,
            'status' => $request->status,
        ]);
        return redirect()->route('department.index')->with('success', ' معلومات دیپارتمنت شما ویرایش شد.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete = Depratment::find($id);
        $delete->delete();
        return redirect()->route('department.index')->with('warning', 'دیپارتمنت شما حذف گردید.');
    }
}
