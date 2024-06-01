@extends('layouts.master')
@section('content')
<div class="row page-titles">
    <div class="col-md-12 align-self-center text-end">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb justify-content-end">
                <li class="breadcrumb-item"><a href="javascript:void(0)">نواحی</a></li>
                <li class="breadcrumb-item active">تنظیمات پلان</li>
            </ol>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            {{-- add district  --}}
            @if($edit_district == false)
                <form action="{{ route('district.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header bg-info">
                        <h4 class="m-b-0 text-white">افزودن ناحیه</h4>
                    </div>
                    <div class="card-body">
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group row">
                                <label class="control-label text-end col-md-2">نام </label>
                                <div class="col-md-8">
                                    <input type="text" value="{{ old('name') }}" name="name" class="@error('name') is-invalid @enderror form-control" placeholder="">
                                    @error('name')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror

                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-success text-white"> <i class="fa fa-check"></i>
                                    ذخیره</button>
                        </div>
                    </div>
                </form>
            @else
                <form action="{{ route('district.update', $edit_district->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="card-header bg-success">
                        <h4 class="m-b-0 text-white">تصحیح ناحیه</h4>
                    </div>
                    <div class="card-body">
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group row">
                                <label class="control-label text-end col-md-2">نام فارسی </label>
                                <div class="col-md-8">
                                    <input  type="text" value="{{ $edit_district->name }}" name="name" class="@error('name') is-invalid @enderror form-control" placeholder="">
                                    @error('name')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-success text-white"> <i class="fa fa-check"></i>
                                    تصحیح</button>
                        </div>
                    </div>
                </form>
            @endif
           {{-- end add district --}}
           {{-- list district --}}
            <div class="card-body">
                <h4 class="card-title">لیست نواحی</h4>
                    <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>نام</th>
                                <th>تصحیح</th>
                                <th>حذف</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $key = 1 ?>
                            @foreach($districts as $district)
                            <tr>
                                <td>{{ $key++ }}</td>
                                <td>{{$district->name}}</td>
                                <td>
                                    <a href="{{ route('district.edit',$district->id) }}" type="submit" class="btn btn-success text-white">تصحیح <i class="fas fa-edit"></i> </a>
                                </td>
                                <td>
                                    <form action="{{ route('district.destroy',$district->id) }}" method="POST">
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
            {{-- end list district --}}
        </div>
    </div>
</div>

@endsection
