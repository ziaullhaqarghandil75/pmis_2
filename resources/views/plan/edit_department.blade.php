@extends('layouts.master')
@section('content')
<div class="row page-titles">
    <div class="col-md-12 align-self-center text-end">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb justify-content-end">
                <li class="breadcrumb-item"><a href="javascript:void(0)">تصحیح دیپارتمنت ها</a></li>
                <li class="breadcrumb-item"><a href="{{ route('department.index') }}">دیپارتمنت ها</a></li>
                <li class="breadcrumb-item active">تنظیمات پلان</li>
            </ol>
        </div>
    </div>
</div>
{{-- edit department --}}
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <form action="{{ route('department.update',$department->id ) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="card-header bg-info">
                    <h4 class="m-b-0 text-white">تصحیح دیپارتمنت</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="control-labe col-3">نام فارسی*</label>
                                    <div class="col-md-9">
                                        <input type="text" value="{{ $department->name_da }}" name="name_da" class="@error('name_da') is-invalid @enderror form-control" placeholder="">
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
                                        <input type="text" value="{{ $department->name_en }}" name="name_en" class="@error('name_en') is-invalid @enderror form-control" placeholder="">
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

                                            <option  value="1" {{ ($department->type_of_department == 1) ? 'selected':''}}>تطبیق کننده </option>
                                            <option  value="2" {{ ($department->type_of_department == 2) ? 'selected':''}}>مدیریت کننده </option>
                                            <option  value="3" {{ ($department->type_of_department == 3) ? 'selected':''}}>دیزاین کننده </option>
                                            <option  value="4" {{ ($department->type_of_department == 4) ? 'selected':''}}>نظارت کننده کننده </option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group row">
                                <label class="control-label col-md-4">حالت</label>
                                <div class="col-md-8">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" name="status" value="1" id="customRadio3" class="form-check-input" {{ ($department->status == 1) ? 'checked':''}}>
                                        <label class="form-check-label" for="customRadio3">فعال</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" name="status" value="0" id="customRadio4" class="form-check-input" {{ ($department->status == 0) ? 'checked':''}}>
                                        <label class="form-check-label" for="customRadio4">غیر فعال</label>
                                    </div>
                                </div>
                            </div>
                    </div>
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-success w-100 text-white">
                                     تصحیح معلومات</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- end add department --}}

@endsection
