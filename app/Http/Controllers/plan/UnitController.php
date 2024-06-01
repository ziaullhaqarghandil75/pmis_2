<?php

namespace App\Http\Controllers\Plan;

use App\Http\Controllers\Controller;
use App\Models\Plan\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(!(auth::user()->can('view_unit') and auth::user()->can('units'))){
            return view('layouts.403');
        }

        $units = Unit::get();
        $edit_unit = false;

        return view('plan.unit', compact('edit_unit','units'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(!(auth::user()->can('add_unit') and auth::user()->can('units'))){
            return view('layouts.403');
        }
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(!(auth::user()->can('add_unit') and auth::user()->can('units'))){
            return view('layouts.403');
        }
         $request->validate([
            'unit_name_fa' => 'required|unique:'.Unit::class,
            'unit_name_en' => 'required|unique:'.Unit::class,
        ]);

        // here we will insert product in db
        $unit = new Unit();
        $unit->unit_name_fa = $request->unit_name_fa;
        $unit->unit_name_en = $request->unit_name_en;
        $unit->save();

        return redirect()->route('unit.index')->with('success', 'واحد شما اضافه شد.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if(!(auth::user()->can('view_unit') and auth::user()->can('units'))){
            return view('layouts.403');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if(!(auth::user()->can('edit_unit') and auth::user()->can('units'))){
            return view('layouts.403');
        }
        $units = Unit::get();
        $edit_unit = Unit::find($id);
        return view('plan.unit', compact('edit_unit','units'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if(!(auth::user()->can('edit_unit') and auth::user()->can('units'))){
            return view('layouts.403');
        }
        $request->validate([
            'unit_name_fa' => 'required',
            'unit_name_en' => 'required',
        ]);

        $update = Unit::find($id);
        $update->update([
            'unit_name_fa' => $request->unit_name_fa,
            'unit_name_en' => $request->unit_name_en,
        ]);
        return redirect()->route('unit.index')->with('success', ' معلومات واحد شما تصحیح شد.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(!(auth::user()->can('delete_unit') and auth::user()->can('units'))){
            return view('layouts.403');
        }
        $delete = Unit::find($id);
        $delete->delete();
        return redirect()->route('unit.index')->with('warning', 'واحد حذف گردید.');
    }
}
