<?php

namespace App\Http\Controllers\AccountSetting;

use App\Http\Controllers\Controller;
use App\Models\account_settings\Permission;
use App\Models\account_settings\PermissionCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   

        $permission_categories = PermissionCategory::orderBy('created_at', 'desc')->get();
        $permissions = Permission::get();

        return view('account_settings.permission', compact('permission_categories', 'permissions'));
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
            'name' => ['required'],
            'description' => ['required'],
            'status' => ['required'],
        ]);

        // here we will insert product in db
        $permission = new Permission();
        $permission->name = $request->name;
        $permission->description = $request->description;
        $permission->permission_gategory_id = $request->permission_gategory_id;
        $permission->status = $request->status;
        $permission->save();

        return redirect()->route('permission.index')->with('success', 'سطوح دسترسی شما اضافه شد.');
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
