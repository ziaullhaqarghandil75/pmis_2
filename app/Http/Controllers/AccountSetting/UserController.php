<?php

namespace App\Http\Controllers\AccountSetting;

use App\Http\Controllers\Controller;
use App\Models\account_settings\Role;
use App\Models\User;
use App\Models\Plan\Depratment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dd(auth::user()->id);
        // dd(auth::user()->hasRole('admin'));
        if(!(auth::user()->can('view_user') and auth::user()->can('users'))){
            return view('layouts.403');
        }
        $users = User::with('roles')->get();

        $departments = Depratment::get();
        $roles = Role::get();
        return view('account_settings.user', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        if(!(auth::user()->can('add_user') and auth::user()->can('users'))){
            return view('layouts.403');
        }
        $departments = Depratment::where('status','=','1')->get();
        $roles = Role::where('status','=','1')->get();
        return view('account_settings.add_user',compact('departments','roles'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(!(auth::user()->can('add_user') and auth::user()->can('users'))){
            return view('layouts.403');
        }
        $request->validate([
            'name' => ['required','string'],
            'phone' => ['required','min:10','numeric','unique:'.User::class],
            'img' => ['required','mimes:jpg,png,JPG,PNG'],
            'password' => ['required','string','min:8','max:100'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'department_id' => ['required'],
            'role_id' => ['required'],
        ]);
        if($request->has('img')){
            $file = $request->file('img');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $path = 'img/users/';
            $file->move($path,$filename);
        }


        // here we will insert product in db
        $user = new User();
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->img = $path.$filename;
        $user->department_id = $request->department_id;
        $user->status = $request->status;
        $user->save();

        $user->roles()->sync($request->input('role_id'));


        return redirect()->route('user.index')->with('success', 'کاربر جدید اضافه کردید.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if(!(auth::user()->can('view_user') and auth::user()->can('users'))){
            return view('layouts.403');
        }
        $users = User::get();
        return view('account_settions.user', compact('users'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if(!(auth::user()->can('edit_user') and auth::user()->can('users'))){
            return view('layouts.403');
        }

        $departments = Depratment::where('status','=','1')->get();
        $roles = Role::get();
        $user = User::with('roles','departments')->find($id);

        return view('account_settings.profile_user',compact('departments','roles','user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if(!(auth::user()->can('edit_user') and auth::user()->can('users'))){
            return view('layouts.403');
        }
        $request->validate([
            'name' => ['required','string'],
            'phone' => ['required','min:10','numeric','unique:'.User::class.',phone,'.$id],
            'img' => ['mimes:jpg,png,JPG,PNG'],
            'password' => ['string'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class.',email,'.$id],
        ]);

        $update = User::find($id);

        if($request->has('img')){
            $file = $request->file('img');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $path = 'img/users/';
            $file->move($path,$filename);

            if($update->img){
                File::delete($update->img);
            }

            $update->update([
            'img' => $path.$filename,
            ]);

        }

        $update->update([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
        ]);

        // $update->roles()->sync($request->input('role_id'));


        return redirect()->back()->with('success', ' معلومات شما ویرایش شد.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(!(auth::user()->can('delete_user') and auth::user()->can('users'))){
            return view('layouts.403');
        }
        $delete = User::find($id);
        if(File::exists($delete->img)){
            File::delete($delete->img);
        }

        $delete->delete();
        return redirect()->route('user.index')->with('warning', 'کاربر شما حذف گردید.');

    }
    public function change_password(Request $request, string $id)
    {

        if(!(auth::user()->can('change_password_user'))){
            return view('layouts.403');
        }

        $request->validate([
            'old_password' => ['required','min:8','max:100'],
            'new_password' => ['required','min:8','max:100'],
            'confirm_password' => ['required','same:new_password'],
        ]);

        $update = User::find($id);

        $update->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->back()->with('success', ' پسورد شما تغیر کرد.');
    }
    public function user_status($id){
        if(!(auth::user()->can('edit_user') and auth::user()->can('users'))){
            return view('layouts.403');
        }
        $user_status = User::find($id);
        if ($user_status->status == 0) {
            $user_status->update([
                'status' => '1'
            ]);
            return redirect()->back()->with('success', 'کاربر فعال شد.');
        } else {
            $user_status->update([
                'status' => '0'
            ]);
            return redirect()->back()->with('warning', 'کاربر غیر فعال شد.');
        }
    }
}
