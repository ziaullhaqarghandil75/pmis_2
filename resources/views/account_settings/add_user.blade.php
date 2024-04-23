@extends('layouts.master')
@section('content')
<div class="row page-titles">
    <div class="col-md-12 align-self-center text-end">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb justify-content-end">
            <li class="breadcrumb-item"><a href="javascript:void(0)">افزودن کابر جدید</a></li>
            <li class="breadcrumb-item"><a href="{{ route('user.index') }}">کاربران</a></li>
                <li class="breadcrumb-item active">تنظیمات حساب کاربری</li>
            </ol>
        </div>
    </div>
</div>
{{-- add user --}}
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-header bg-info">
                    <h4 class="m-b-0 text-white">افزودن کاربر جدید</h4>
                </div>
                <div class="card-body">
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group row">
                            <label class="control-label text-end col-md-3">نام*</label>
                            <div class="col-md-8">
                                <input type="text" name="name" class="@error('name') is-invalid @enderror form-control"
                                    placeholder="">
                                @error('name')
                                <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group has-danger row">
                            <label class="control-label text-end col-md-3">تخلص</label>
                            <div class="col-md-8">
                                <input type="text" name="last_name"
                                    class="@error('last_name') is-invalid @enderror form-control" placeholder="">
                                @error('last_name')
                                <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group has-danger row">
                            <label class="control-label text-end col-md-3">شماره تماس</label>
                            <div class="col-md-8">
                                <input type="text" name="phone"
                                    class="@error('phone') is-invalid @enderror form-control" placeholder="">
                                @error('phone')
                                <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group has-danger row">
                            <label class="control-label text-end col-md-3">ایمل*</label>
                            <div class="col-md-8">
                                <input type="email" name="email"
                                    class="@error('email') is-invalid @enderror form-control" placeholder="">
                                @error('email')
                                <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group has-danger row">
                            <label class="control-label text-end col-md-3">پسورد*</label>
                            <div class="col-md-8">
                                <input type="password" name="password"
                                    class="@error('password') is-invalid @enderror form-control" placeholder="">
                                @error('password')
                                <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group has-danger row">
                            <label class="control-label text-end col-md-3">تصویر</label>
                            <div class="col-md-8">
                                <input type="file" name="img"
                                    class="@error('img') is-invalid @enderror form-control" placeholder="">
                                @error('img')
                                <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group has-danger row">
                            <label class="control-label text-end col-md-3">دیپارتمنت*</label>
                            <div class="col-md-8">
                                <select name="department_id" class="form-control form-select">
                                    <option>--انتخاب دیپارتمنت--</option>
                                    @foreach ($departments as $department )
                                    <option value="{{ $department->id }}">
                                        {{ $department->name_da }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('department_id')
                                <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group has-danger row">
                            <label class="control-label text-end col-md-3">سطح دسترسی (role)*</label>
                            <div class="col-md-8">
                                <select name="role_id" class="form-control form-select">
                                    <option>--انتخاب سطح دسترسی (role)--</option>
                                    @foreach ($roles as $role )
                                    <option value="{{ $role->id }}">
                                        {{ $role->description }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('department_id')
                                <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group row">
                            <label class="control-label text-end col-md-3">حالت</label>
                            <div class="col-md-8">
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="status" value="1" id="customRadio3"
                                        class="form-check-input" checked>
                                    <label class="form-check-label" for="customRadio3">فعال</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="status" value="0" id="customRadio4"
                                        class="form-check-input">
                                    <label class="form-check-label" for="customRadio4">غیر فعال</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="card-body">
                            <button type="submit" class="btn btn-success text-white"> <i class="fa fa-check"></i>
                                ذخیره</button>
                            <button type="reset" class="btn btn-dark">لفوه</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- end add user --}}



@endsection
@section('script')


@endsection