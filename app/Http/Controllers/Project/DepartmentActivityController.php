<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\Plan\Depratment;
use App\Models\Project\DepartmentActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartmentActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(!(Auth::user()->can('view_department_activity') and Auth::user()->can('department_activities'))){
            return view('layouts.403');
        }
        $edit_department_activity = false;
        $departments = Depratment::where('status','=','1')->get();
        $department_activities = DepartmentActivity::with('department_activities')->orderByDesc('id')->get();

        return view('project.department_activities', compact('department_activities','edit_department_activity','departments'));
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

        if(!(auth::user()->can('add_department_activity') and auth::user()->can('department_activities'))){
            return view('layouts.403');
        }
        $request->validate([
            'acitvity_name'       => ['required', 'string','unique:'.DepartmentActivity::class],
            'acitvity_percentage' => ['required','numeric','between:0,100'],
            'department_id'       => ['required'],
            'status'              => ['required','numeric','between:0,1'],
            'sort_of_activity'    => ['required','numeric'],
        ]);
        // dd($request->all());


        // here we will insert product in db
        $departmentd_ctivity = new DepartmentActivity();
        if($departmentd_ctivity->where('department_id','=',$request->department_id)->where('status','=','1')->sum('acitvity_percentage') > 100){

            return redirect()->back()->with('warning', 'فیصدی فعالیت این دیپارتمنت 100 فیصد است.');

        }elseif($departmentd_ctivity->where('department_id','=',$request->department_id)->where('status','=','1')->sum('acitvity_percentage')+$request->acitvity_percentage > 100){

            return redirect()->back()->with('warning', 'فیصدی فعالیت این دیپارتمنت 100 فیصد است.');

        }

        $departmentd_ctivity->acitvity_name          = $request->acitvity_name;
        $departmentd_ctivity->acitvity_deys          = $request->acitvity_deys;
        $departmentd_ctivity->acitvity_percentage    = $request->acitvity_percentage;
        $departmentd_ctivity->department_id          = $request->department_id;
        $departmentd_ctivity->status                 = $request->status;
        $departmentd_ctivity->sort_of_activity       = $request->sort_of_activity;
        $departmentd_ctivity->save();

        return redirect()->back()->with('success', 'فعالیت شما اضافه گریدید.');
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
        if(!(auth::user()->can('edit_department_activity') and auth::user()->can('department_activities'))){
            return view('layouts.403');
        }

        $department_activities = DepartmentActivity::with('department_activities')->orderByDesc('id')->get();
        $departments = Depratment::where('status','=','1')->get();
        $edit_department_activity = DepartmentActivity::find($id);

        return view('project.department_activities', compact('department_activities','departments','edit_department_activity'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if(!(auth::user()->can('edit_department_activity') and auth::user()->can('department_activities'))){
            return view('layouts.403');
        }
        $request->validate([
            'acitvity_name'       => ['required', 'string'],
            // 'acitvity_deys'       => ['numeric'],
            'acitvity_percentage' => ['required','numeric','between:0,100'],
            'department_id'       => ['required','numeric'],
            'sort_of_activity'       => ['required','numeric'],
        ]);

        $update = DepartmentActivity::find($id);
        $departmentd_ctivity = new DepartmentActivity();

        if($departmentd_ctivity->where('department_id','=',$request->department_id)->where('status','=','1')->sum('acitvity_percentage') > 100){
            return redirect()->back()->with('warning', 'فیصدی فعالیت این دیپارتمنت 100 فیصد است.');

        }elseif($departmentd_ctivity->where('department_id','=',$request->department_id)->where('status','=','1')->sum('acitvity_percentage')+$request->acitvity_percentage > 100){

            return redirect()->back()->with('warning', 'فیصدی فعالیت این دیپارتمنت 100 فیصد است.');

        }

        $update->update([
            'acitvity_name' => $request->acitvity_name,
            'acitvity_deys' => $request->acitvity_deys,
            'acitvity_percentage' => $request->acitvity_percentage,
            'department_id' => $request->department_id,
            'sort_of_activity' => $request->sort_of_activity,
        ]);
        return redirect()->back()->with('success', 'فعالیت شما ویرایش گریدید.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(!(auth::user()->can('delete_department_activity') and auth::user()->can('department_activities'))){
            return view('layouts.403');
        }
        $delete = DepartmentActivity::find($id);
        $delete->delete();

        return redirect()->back()->with('warning', 'فعالیت شما حذف گریدید.');

    }

    public function status_department_activity($id,$department_id){

        if(!(auth::user()->can('edit_department_activity') and auth::user()->can('department_activities'))){
            return view('layouts.403');
        }

        $status_department_activity = DepartmentActivity::find($id);
        if ($status_department_activity->status == 0) {

            $departmentd_ctivity = new DepartmentActivity();
            // dd();
            // dd($departmentd_ctivity->where('department_id','=',$department_id)->where('status','=','1')->sum('acitvity_percentage'));

            if($departmentd_ctivity->where('department_id','=',$department_id)->where('status','=','1')->sum('acitvity_percentage')+$status_department_activity->acitvity_percentage > 100){
                return redirect()->back()->with('warning', 'فیصدی فعالیت این دیپارتمنت 100 فیصد است.');

            }

            $status_department_activity->update([
                'status' => '1'
            ]);
            return redirect()->back()->with('success', 'حالت فعال شد.');
        } else {
            $status_department_activity->update([
                'status' => '0'
            ]);
            return redirect()->back()->with('warning', 'حالت غیر فعال شد.');
        }
    }
}
