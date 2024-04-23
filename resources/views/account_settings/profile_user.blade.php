@extends('layouts.master')
@section('content')
<div class="row page-titles">
    <div class="col-md-12 align-self-center text-end">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb justify-content-end">
            <li class="breadcrumb-item"><a href="javascript:void(0)">پروفایل کابر</a></li>
            <li class="breadcrumb-item"><a href="{{ route('user.index') }}">کاربران</a></li>
                <li class="breadcrumb-item active">تنظیمات حساب کاربری</li>
            </ol>
        </div>
    </div>
</div>

<div class="card-header bg-info">
    <h4 class="m-b-0 text-white">پروفایل کاربر </h4>
</div>
<div class="row">
                    <!-- Column -->
    <div class="col-lg-4 col-xlg-3 col-md-5">
                        <div class="card">
                            <div class="card-body">
                            <!-- {{  asset('$user->img ? img/user.jpg') }} -->
                                <center class="m-t-30"> <img src="{{ asset($user->img) }}" class="img-circle" width="150" height="150">
                                    <h4 class="card-title m-t-10">{{ $user->name }} " {{ $user->last_name }} "</h4>
                                    <h6 class="card-subtitle">@foreach ($user->roles as $role){{ $role->name }}@endforeach</h6>
                                    <!-- <div class="row text-center justify-conten t-md-center">
                                    </div> -->
                                </center>
                            </div>
                            <div>
                                <hr> </div>
                            <div class="card-body">
                                 <small class="text-muted">ایمل</small>
                                <h6>{{ $user->email }}</h6>
                                 <small class="text-muted p-t-30 db">شماره تماس</small>
                                <h6>{{ $user->phone }}</h6>
                                 <small class="text-muted p-t-30 db">دیپارتمنت</small>
                                <h6>@foreach ($user->departments as $department){{ $department->name_da }}@endforeach</h6>
                                <small class="text-muted">حالت</small>
                                <h6>@if($user->status == 1)فعال @else غیر فعال @endif</h6>

                                <br>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-8 col-xlg-9 col-md-7">
                        <div class="card">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs profile-tab" role="tablist">
                                <li class="nav-item"> <a class="nav-link active" data-bs-toggle="tab" href="#home" role="tab" aria-selected="true">تنظیمات</a> </li>
                                <!-- <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab" href="#profile" role="tab" aria-selected="false">Profile</a> </li> -->
                                <!-- <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab" href="#settings" role="tab" aria-selected="false">Settings</a> </li> -->
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane active" id="home" role="tabpanel">
                                    <div class="card-body"> 
                                        <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="form-horizontal form-material">
                                            @csrf
                                            @method('put')
                                            <div class="form-group">
                                                <label class="col-md-12">اسم</label>
                                                <div class="col-md-12">
                                                    <input type="text" name="name" value="{{ $user->name }}" placeholder="اسم" class="@error('name') is-invalid @enderror form-control form-control-line">
                                                    @error('name')
                                                    <p class="invalid-feedback">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-12">تخلص</label>
                                                <div class="col-md-12">
                                                    <input type="text" name="last_name" value="{{ $user->last_name }}" placeholder="تخلص" class="@error('last_name') is-invalid @enderror form-control form-control-line">
                                                    @error('last_name')
                                                    <p class="invalid-feedback">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-12">شماره تماس</label>
                                                <div class="col-md-12">
                                                    <input type="text" name="phone" value="{{ $user->phone }}" placeholder="شماره تماس" class="@error('phone') is-invalid @enderror form-control form-control-line">
                                                    @error('phone')
                                                    <p class="invalid-feedback">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="example-email" class="col-md-12">ایمل</label>
                                                <div class="col-md-12">
                                                    <input type="email" name="email" value="{{ $user->email }}"  placeholder="ایمل" class="@error('email') is-invalid @enderror form-control form-control-line" name="example-email" id="example-email">
                                                    @error('email')
                                                    <p class="invalid-feedback">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-12">پسورد</label>
                                                <div class="col-md-12">
                                                    <input type="password" name="password"  class="@error('password') is-invalid @enderror form-control form-control-line">
                                                </div>
                                            </div>
                                
                                            <div class="form-group">
                                                <label class="col-sm-12">دیپارتمنت</label>
                                                <div class="col-sm-12">
                                                    <select name="departmen_id" class="form-control form-control-line">
                                                    @foreach ($departments as $department)
                                                        <option value="{{ $department->id }}" @if($user->department_id == $department->id) selected @endif>
                                                            {{ $department->name_da }}
                                                        </option>
                                                    @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                
                                            <div class="form-group">
                                                <label class="col-sm-12">سطح دسترسی (role)</label>
                                                <div class="col-sm-12">
                                                    <select name="role_id" class="form-control form-control-line">
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role->id }}" @if($user->role_id == $role->id) selected @endif>
                                                            {{ $role->description}}
                                                        </option>
                                                    @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-12">تصویر</label>
                                                <div class="col-md-12">
                                                    <input type="file" name="img" class="@error('img') is-invalid @enderror form-control form-control-line">
                                                    @error('img')
                                                    <p class="invalid-feedback">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <button class="btn btn-success text-white">ویرایش معلومات</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>
@endsection
@section('script')


@endsection