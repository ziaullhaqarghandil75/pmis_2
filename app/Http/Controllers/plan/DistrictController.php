<?php

namespace App\Http\Controllers\Plan;

use App\Http\Controllers\Controller;
use App\Models\Plan\District;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DistrictController extends Controller
{
  /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(!(auth::user()->can('view_district') and auth::user()->can('districts'))){
            return view('layouts.403');
        }

        $districts = District::get();
        $edit_district = false;

        return view('plan.district', compact('edit_district','districts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(!(auth::user()->can('add_district') and auth::user()->can('districts'))){
            return view('layouts.403');
        }
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(!(auth::user()->can('add_district') and auth::user()->can('districts'))){
            return view('layouts.403');
        }
         $request->validate([
            'name' => 'string|required|unique:'.District::class,
        ]);

        // here we will insert product in db
        $unit = new District();
        $unit->name = $request->name;
        $unit->save();

        return redirect()->route('district.index')->with('success', 'ناحیه جدید اضافه شد.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if(!(auth::user()->can('view_district') and auth::user()->can('districts'))){
            return view('layouts.403');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if(!(auth::user()->can('edit_district') and auth::user()->can('districts'))){
            return view('layouts.403');
        }
        $districts = District::get();
        $edit_district = District::find($id);
        return view('plan.district', compact('edit_district','districts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if(!(auth::user()->can('edit_district') and auth::user()->can('districts'))){
            return view('layouts.403');
        }
        $request->validate([
            'name' => 'required',
        ]);

        $update = District::find($id);
        $update->update([
            'name' => $request->name,
        ]);
        return redirect()->route('district.index')->with('success', ' معلومات ناحیه شما تصحیح شد.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(!(auth::user()->can('delete_district') and auth::user()->can('districts'))){
            return view('layouts.403');
        }
        $delete = District::find($id);
        $delete->delete();
        return redirect()->route('district.index')->with('warning', 'ناحیه حذف گردید.');
    }
}
