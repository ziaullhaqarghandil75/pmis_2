@extends('layouts.master')
@section('content')
<div class="row page-titles">
    <div class="col-md-12 align-self-center text-end">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb justify-content-end">
                <li class="breadcrumb-item"><a href="javascript:void(0)">ویرایش دیپارتمنت ها</a></li>
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
                    <h4 class="m-b-0 text-white">ویرایش دیپارتمنت</h4>
                </div>
                <div class="card-body">
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group row">
                            <label class="control-label text-end col-md-2">نام فارسی</label>
                            <div class="col-md-8">
                                <input type="text" name="name_da" value="{{ $department->name_da }}" class="@error('name_fa') is-invalid @enderror form-control" placeholder="">
                                @error('name_fa')
                                <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group row">
                            <label class="control-label text-end col-md-2">نام انگلیسی</label>
                            <div class="col-md-8">
                                <input type="text" name="name_en" value="{{ $department->name_en }}" class="@error('name_en') is-invalid @enderror form-control" placeholder="">
                                @error('name_en')
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
                                    <input type="radio" name="status" value="1" id="customRadio3" class="form-check-input" @if($department->status == 1) checked @endif>
                                    <label class="form-check-label" for="customRadio3">فعال</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="status" value="0" id="customRadio4" class="form-check-input" @if($department->status == 0) checked @endif>
                                    <label class="form-check-label" for="customRadio4">غیر فعال</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="card-body">
                            <button type="submit" class="btn btn-success text-white"> <i class="fa fa-check"></i>
                                ویرایش</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- end add department --}}

@endsection