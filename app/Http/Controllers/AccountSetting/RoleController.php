<?php

namespace App\Http\Controllers\AccountSetting;

use App\Http\Controllers\Controller;
use App\Models\account_settings\Role;
use App\Models\account_settings\Permission;
use App\Models\account_settings\PermissionCategory;
use App\Models\account_settings\PermissionRole;
use App\Models\account_settings\RolePermission;
// use Spatie\Permission\Models\Permission;
use Auth;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::get();

        return view('account_settings.role', compact('roles'));
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
        $permission = new Role();
        $permission->name = $request->name;
        $permission->description = $request->description;
        $permission->status = $request->status;
        $permission->save();

        return redirect()->route('role.index')->with('success', 'سطح دسترسی شما اضافه شد.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $roles = Role::find($id);
        $permissions = Permission::get();
        $permission_categories = PermissionCategory::get();
        $role_permissions = PermissionRole::where('role_id', '=', $roles->id)->get();

        return view('account_settings.add_permisson_to_role', compact('roles', 'permissions', 'permission_categories', 'role_permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $role_status = Role::find($id);
        $role = Role::find($id);
      
        $role->Permissions()->sync($request->input('permission_id'));
      
        return redirect()->back()->with('success', 'سطح دسترسی ویرایش شد.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete = Role::find($id);
        $delete->delete();

        return redirect()->route('role.index')->with('warning', 'سطح دسترسی شما حذف گردید.');
    }

    public function status_role($id){
        $role_status = Role::find($id);
        if ($role_status->status == 0) {
            $role_status->update([
                'status' => '1'
            ]);
            return redirect()->route('role.index')->with('success', 'حالت سطح دسترسی فعال شد.');
        } else {
            $role_status->update([
                'status' => '0'
            ]);
            return redirect()->route('role.index')->with('warning', 'حالت سطح دسترسی غیر فعال شد.');
        }  
    }
}
