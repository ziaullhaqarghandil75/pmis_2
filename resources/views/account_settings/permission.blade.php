@extends('layouts.master')
@section('content')
<div class="row page-titles">
    <div class="col-md-12 align-self-center text-end">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb justify-content-end">
                <li class="breadcrumb-item"><a href="javascript:void(0)">سطوح دسترسی</a></li>
                <li class="breadcrumb-item active">تنظیمات حساب کاربری</li>
            </ol>
        </div>
    </div>
</div>
{{-- add permission --}}
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <form action="{{ route('permission.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-header bg-info">
                    <h4 class="m-b-0 text-white">افزودن سطوح دسترسی (permission)</h4>
                </div>
                <div class="card-body">
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group row">
                            <label class="control-label text-end col-md-3">نام</label>
                            <div class="col-md-8">
                                <input type="text" name="name" class="@error('name') is-invalid @enderror form-control"
                                    placeholder="">
                                @error('name')
                                <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
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
                    <div class="col-md-6">
                        <div class="form-group has-danger row">
                            <label class="control-label text-end col-md-2">دسته بندی</label>
                            <div class="col-md-8">
                                <select name="permission_gategory_id" class="form-control form-select">
                                    <option>--انتخاب دسته بندی--</option>
                                    @foreach ($permission_categories as $permission_category )
                                    <option value="{{ $permission_category->id }}">
                                        {{ $permission_category->category_name }}
                                    </option>
                                    @endforeach
                                </select>
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

    {{-- add permission category --}}
    <div class="col-lg-4">
        <div class="card">
            <form action="{{ route('permission_category.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-header bg-info">
                    <h4 class="m-b-0 text-white">افزودن دسته بندی (permission category)</h4>
                </div>
                <div class="card-body">
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label class="control-label text-end col-md-2">نام</label>
                            <div class="col-md-8">
                                <input type="text" name="category_name"
                                    class="@error('category_name') is-invalid @enderror form-control" placeholder="">
                                @error('category_name')
                                <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
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

{{-- list permission --}}
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">لیست سطوح دسترسی (permission)</h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>دسته بندی</th>
                            <th>سطوح دستری های (permissions)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $key = 1 ?>
                        @foreach($permission_categories as $permission_category)
                            <tr>
                                <td>{{ $key++ }}</td>
                                <td>{{$permission_category->category_name}}</td>
                                <td>
                                    @foreach($permissions as $permission)
                                        @if($permission->permission_gategory_id == $permission_category->id)
                                            @if($permission->status == 0)
                                                <button class="btn btn-danger text-white">{{ $permission->description }}/button>
                                            @endif  
                                            <button class="btn btn-info text-white">{{ $permission->description }}</button>
                                        @endif
                                    @endforeach
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