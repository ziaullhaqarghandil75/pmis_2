@extends('layouts.master')
@section('content')
<div class="row page-titles">
    <div class="col-md-12 align-self-center text-end">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb justify-content-end">
                <li class="breadcrumb-item"><a href="javascript:void(0)">افزودن سطوح دسترسی</a></li>
                <li class="breadcrumb-item"><a href="{{ route('role.index') }}">سطح دسترسی</a></li>
                <li class="breadcrumb-item active">تنظیمات حساب کاربری</li>
            </ol>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <form action="{{ route('role.update' , $roles->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-header bg-info">
                    <h4 class="m-b-0 text-white">افزودن سطوح دسترسی (permission) به {{ $roles->name }}</h4>
                </div>
                <div class="card-body">
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>دسته بندی</th>
                                    <th colspan="12">سطوح دسترسی (permission)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($permission_categories as $key => $permission_category)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{$permission_category->category_name}}</td>
                                    <td>
                                        @foreach ($permissions as $permission)
                                        @if ($permission_category->id == $permission->permission_gategory_id)
                                        <label class="btn btn-secondary border-0 text-info font-weight-medium active">
                                            <div class="mr-sm-2 form-check">
                                                <input type="checkbox" value="{{ $permission->id }}" name="permission_id[]" class="material-inputs form-check-input" id="checkbox4" @foreach ($role_permissions as $role_permission) @if ($role_permission->permission_id == $permission->id)
                                                checked=""
                                                @endif @endforeach>
                                                <label class="form-check-label" for="checkbox4">{{ $permission->description }}</label>
                                            </div>
                                        </label>
                                        @endif
                                        @endforeach
                                @endforeach
                            </tbody>
                        </table>
                </div>
        </div>
        <div class="form-actions">
            <div class="card-body">
                <button type="submit" class="btn btn-success text-white"> <i class="fa fa-check"></i>
                    ذخیره معلومات</button>
            </div>
        </div>
        </form>
    </div>
</div>
</div>
@endsection
