<?php

namespace App\Http\Controllers\Procurement;

use App\Http\Controllers\Controller;
use App\Models\Procurement\Company;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dd('sd');
        if(!(auth::user()->can('view_company') and auth::user()->can('companies'))){
            return view('layouts.403');
        }

        $companies = Company::get();
        $edit_company = false;

        return view('procurement.company', compact('edit_company','companies'));
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
        // dd('sd');
        if(!(auth::user()->can('add_company') and auth::user()->can('companies'))){
            return view('layouts.403');
        }
         $request->validate([
            'company_name' => 'required|unique:'.Company::class,
            'phone' => 'required|unique:'.Company::class,
            'email' => 'required|unique:'.Company::class,
            'licence_number' => 'required|unique:'.Company::class,
            'agent_name' => 'required',
            'file' => 'required|mimes:pdf,PDF',
        ]);
        $date = Carbon::now();
        if ($request->hasFile('file')) {
            $file       = $request->file('file');
            $extension  = $file->getClientOriginalExtension();
            $fileName   = $date->format('Y-m-d').'-'.time().'.'.$extension;
            $path       = 'company/'.$request->company_name.'/';
            $file->move($path, $fileName);
        }
        $company = new Company();
        // $fileContent = file_get_contents($value->getRealPath());
        $company->company_name = $request->company_name;
        $company->phone = $request->phone;
        $company->email = $request->email;
        $company->licence_number = $request->licence_number;
        $company->agent_name = $request->agent_name;
        $company->file = $path.$fileName;
        $company->save();


        return redirect()->back()->with('success', 'معلومات شرکت اضافه گردید.');
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
        if(!(auth::user()->can('edit_company') and auth::user()->can('companies'))){
            return view('layouts.403');
        }

        $companies = Company::get();
        $edit_company = Company::find($id);

        return view('procurement.company', compact('edit_company','companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if(!(auth::user()->can('edit_company') and auth::user()->can('companies'))){
            return view('layouts.403');
        }
        $company = Company::find($id);

        $request->validate([
            'company_name' => 'required|string|unique:companies,company_name,' . $company->id,
            'phone' => 'required|string|unique:companies,phone,' . $company->id,
            'email' => 'required|string|unique:companies,email,' . $company->id,
            'licence_number' => 'required|string|unique:companies,licence_number,' . $company->id,
            'agent_name' => 'required',
            'file' => 'mimes:pdf,PDF',
        ]);

        // $update = Company::find($id);
        $date = Carbon::now();

        if($request->has('file')){
            $file       = $request->file('file');
            $extension  = $file->getClientOriginalExtension();
            $fileName   = $date->format('Y-m-d').'-تصحیح'.'-'.time().'.'.$extension;
            $path       = 'company/'.$request->company_name.'/';
            $file->move($path, $fileName);

            if($company->file){
                File::delete($company->file);
            }

            $company->update([
            'file' => $path.$fileName,
            ]);

        }
        $company->update([
            'company_name' => $request->company_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'licence_number' => $request->licence_number,
            'agent_name' => $request->agent_name,
        ]);

        return redirect()->route('companies.index')->with('success', ' معلومات شرکت تصحیح گردید.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(!(auth::user()->can('delete_company') and auth::user()->can('companies'))){
            return view('layouts.403');
        }
        $delete = Company::find($id);
        $delete->delete();

        if($delete->file){
            File::delete($delete->file);
        }

        return redirect()->back()->with('warning', 'شرکت حذف گردید.');
    }
}
