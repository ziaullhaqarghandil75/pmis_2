<?php

namespace App\Http\Controllers\AccountSetting;

// PermissionCategory
use App\Http\Controllers\Controller;
use App\Models\account_settings\PermissionCategory;
use Illuminate\Http\Request;

class PermissionCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return view('account_settings.permission');
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
            'category_name' => ['required'],
        ]);
        $permission_category = new PermissionCategory();

        $permission_category->category_name = $request->category_name;

        $permission_category->save();

        return redirect()->route('permission.index')->with('success', 'دسته بندی شما اضافه شد.');
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
