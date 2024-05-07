@extends('layouts.master')
@section('content')
<div class="row page-titles">
    <div class="col-md-12 align-self-center text-end">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb justify-content-end">
                <li class="breadcrumb-item"><a href="javascript:void(0)">سطح دسترسی</a></li>
                <li class="breadcrumb-item active">تنظیمات حساب کاربری</li>
            </ol>
        </div>
    </div>
</div>
{{-- add permission --}}
@can('add_role')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <form action="{{ route('role.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-header bg-info">
                    <h4 class="m-b-0 text-white">افزودن سطح دسترسی (role)</h4>
                </div>
                <div class="card-body">
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group row">
                            <label class="control-label text-end col-md-1">نام</label>
                            <div class="col-md-8">
                                <input type="text" name="name" class="@error('name') is-invalid @enderror form-control"
                                    placeholder="">
                                @error('name')
                                <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group has-danger row">
                            <label class="control-label text-end col-md-2">توضحیات</label>
                            <div class="col-md-8">
                                <input type="text" name="description"
                                    class="@error('description') is-invalid @enderror form-control" placeholder="">
                                @error('description')
                                <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group row">
                            <label class="control-label col-md-2">حالت</label>
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
{{-- end add permission --}}
@endcan
{{-- list permission --}}
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">لیست سطح دسترسی (role)</h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>نام</th>
                            <th>سطح دستری های (role)</th>
                            <th>حالت</th>
                            <th>حذف</th>
                            <th>افزودن سطوح دسترسی (permission)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $key => $role)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{$role->name}}</td>
                                <td>{{$role->description}}</td>
                                <td>
                                    @if ($role->status == 0)
                                        <a href="{{ route('status.status_role',$role->id) }}" type="submit" class="btn waves-effect waves-light btn-danger text-white"> غیر  فعال <i class=" fas fa-times"></i> </button>
                                    @else
                                        <a href="{{ route('status.status_role',$role->id) }}" type="submit" class="btn waves-effect waves-light btn-success text-white"> فعال <i class=" fas fa-check"></i> </button>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('role.destroy',$role->id) }}" method="POST">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" class="btn waves-effect waves-light btn-danger text-white">حذف <i class="fas fa-trash-alt"></i> </button>
                                    </form>
                                </td>
                                <td>
                                    <a href="{{ route('role.edit',$role->id) }}" type="submit" class="btn btn-success text-white">افزودن سطوح دسترسی (permission) <i class="fas fa-eye-dropper"></i> </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')


@endsection
