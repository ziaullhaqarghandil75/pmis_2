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
                    <h4 class="m-b-0 text-white">افزودن دیپارتمنت</h4>
                </div>
                <div class="card-body">
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group row">
                            <label class="control-label text-end col-md-2">نام فارسی</label>
                            <div class="col-md-8">
                                <input type="text" name="name_da" class="@error('name_fa') is-invalid @enderror form-control" placeholder="">
                                @error('name_fa')
                                <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group row">
                            <label class="control-label text-end col-md-2">نام انگلیسی</label>
                            <div class="col-md-8">
                                <input type="text" name="name_en" class="@error('name_en') is-invalid @enderror form-control" placeholder="">
                                @error('name_en')
                                <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group row">
                            <label class="control-label text-end col-md-2">نوع دیپارتمنت</label>
                            <div class="col-md-8">
                                <input type="text" name="name_en" class="@error('name_en') is-invalid @enderror form-control" placeholder="">
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
                                    <input type="radio" name="status" value="1" id="customRadio3" class="form-check-input" checked>
                                    <label class="form-check-label" for="customRadio3">فعال</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="status" value="0" id="customRadio4" class="form-check-input">
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
                            <th>حالت</th>
                            <th>ویرایش</th>
                            <th>حذف</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $key = 1 ?>
                        @foreach($departments as $department)
                        <tr>
                            <td>{{ $key++ }}</td>
                            <td>{{$department->name_da}}</td>
                            <td>{{$department->name_en}}</td>
                            <td>
                                @if ($department->status == 0)
                                <button type="button" class="btn waves-effect waves-light btn-danger text-white">غیر فعال <i class=" fas fa-times"></i> </button>
                                @else
                                <button type="submit" class="btn waves-effect waves-light btn-success text-white"> فعال <i class="fas fa-check"></i> </button>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('department.edit',$department->id) }}" type="submit" class="btn btn-success text-white">ویرایش <i class="fas fa-eye-dropper"></i> </a>
                            </td>
                            <td>
                                <form action="{{ route('department.destroy',$department->id) }}" method="POST">
                                    @method('delete')
                                    @csrf
                                    <button type="submit" class="btn waves-effect waves-light btn-danger text-white">حذف <i class="fas fa-trash-alt"></i> </button>
                                </form>
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
