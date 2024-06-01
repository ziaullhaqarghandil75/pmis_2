@extends('layouts.master')
@section('content')
<div class="row page-titles">
    <div class="col-md-12 align-self-center text-end">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb justify-content-end">
                <li class="breadcrumb-item"><a href="javascript:void(0)">دیپارتمنت ها</a></li>
                <li class="breadcrumb-item active">تنظیمات پلان</li>
            </ol>
        </div>
    </div>
</div>
{{-- add department --}}
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <form action="{{ route('department.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header bg-info">
                        <h4 class="m-b-0 text-white">افزودن فعالیت</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class="control-labe col-3">نام فارسی*</label>
                                        <div class="col-md-9">
                                            <input type="text" value="{{ old('name_da') }}" name="name_da" class="@error('name_da') is-invalid @enderror form-control" placeholder="">
                                            @error('name_da')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class="control-label col-md-3">نام انگلیسی*</label>
                                        <div class="col-md-9">
                                            <input type="text" value="{{ old('name_en') }}" name="name_en" class="@error('name_en') is-invalid @enderror form-control" placeholder="">
                                            @error('name_en')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group has-danger row">
                                        <label class="control-label col-md-3">نو عیت دیپارتمنت*</label>
                                        <div class="col-md-8">
                                            <select name="type_of_department" class="form-control form-select">
                                                <option value="0">--انتخاب نو عیت دیپارتمنت--</option>

                                                <option  value="1" >تطبیق کننده </option>
                                                <option  value="2" >مدیریت کننده </option>
                                                <option  value="3" >دیزاین کننده </option>
                                                <option  value="4" >نظارت کننده </option>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group row">
                                    <label class="control-label col-md-4">حالت</label>
                                    <div class="col-md-8">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="status" value="1" id="customRadio3" class="form-check-input" checked="">
                                            <label class="form-check-label" for="customRadio3">فعال</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="status" value="0" id="customRadio4" class="form-check-input">
                                            <label class="form-check-label" for="customRadio4">غیر فعال</label>
                                        </div>
                                    </div>
                                </div>
                        </div>
                            <div class="col-md-1">
                                <button type="submit" class="btn btn-success w-100 text-white">
                                         ذخیر معلومات</button>
                            </div>
                        </div>
                    </div>

            </form>
        </div>
    </div>
</div>
{{-- end add department --}}

{{-- list department --}}
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">لیست دیپارتمنت ها</h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>نام فارسی</th>
                            <th>نام انگلیسی</th>
                            <th>نوعیت دیپارتمنت</th>
                            <th>حالت</th>
                            @can('edit_department')
                            <th>تصحیح</th>
                            @endcan
                            @can('delete_department')
                            <th>حذف</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($departments as $key => $department)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{$department->name_da}}</td>
                            <td>{{$department->name_en}}</td>
                            <td>
                                @if ($department->type_of_department == 1)
                                        <p>تطبیق کنننده</p>
                                @elseif ($department->type_of_department == 2)
                                        <p>مدیریت کنننده</p>
                                @elseif ($department->type_of_department == 3)
                                        <p>دیزاین کنننده</p>
                                @elseif ($department->type_of_department == 4)
                                        <p>نظارت کنننده</p>
                                @endif
                            </td>
                            <td>
                                @if ($department->status == 0)
                                <button type="button" class="btn waves-effect waves-light btn-danger text-white">غیر فعال <i class=" fas fa-times"></i> </button>
                                @else
                                <button type="submit" class="btn waves-effect waves-light btn-success text-white"> فعال <i class="fas fa-check"></i> </button>
                                @endif
                            </td>
                            @can('edit_department')
                            <td>
                                <a href="{{ route('department.edit',$department->id) }}" type="submit" class="btn btn-success text-white">تصحیح <i class="fas fa-edit"></i> </a>
                            </td>
                            @endcan
                            @can('delete_department')
                            <td>
                                <form action="{{ route('department.destroy',$department->id) }}" method="POST">
                                    @method('delete')
                                    @csrf
                                    <button type="submit" class="btn waves-effect waves-light btn-danger text-white">حذف <i class="fas fa-trash-alt"></i> </button>
                                </form>
                            </td>
                            @endcan
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
