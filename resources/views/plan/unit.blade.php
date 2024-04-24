@extends('layouts.master')
@section('content')
<div class="row page-titles">
    <div class="col-md-12 align-self-center text-end">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb justify-content-end">
                <li class="breadcrumb-item"><a href="javascript:void(0)">واحد ها</a></li>
                <li class="breadcrumb-item active">تنظیمات پلان</li>
            </ol>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-lg-12">
        <div class="card">
            {{-- add unit  --}}
            @if($edit_unit == false)
                <form action="{{ route('unit.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header bg-info">
                        <h4 class="m-b-0 text-white">افزودن واحد</h4>
                    </div>
                    <div class="card-body">
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group row">
                                <label class="control-label text-end col-md-2">نام فارسی </label>
                                <div class="col-md-8">
                                    <input type="text" value="{{ old('unit_name_fa') }}" name="unit_name_fa" class="@error('unit_name_fa') is-invalid @enderror form-control" placeholder="">
                                    @error('unit_name_fa')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group row">
                                <label class="control-label text-end col-md-2">نام انگلیسی </label>
                                <div class="col-md-8">
                                    <input type="text" value="{{ old('unit_name_en') }}" name="unit_name_en" class="@error('unit_name_en') is-invalid @enderror form-control" placeholder="">
                                    @error('unit_name_en')
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
                <form action="{{ route('unit.update', $edit_unit->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="card-header bg-success">
                        <h4 class="m-b-0 text-white">ویرایش واحد</h4>
                    </div>
                    <div class="card-body">
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group row">
                                <label class="control-label text-end col-md-2">نام فارسی </label>
                                <div class="col-md-8">
                                    <input type="text" value="{{ $edit_unit->unit_name_fa }}" name="unit_name_fa" class="@error('unit_name_fa') is-invalid @enderror form-control" placeholder="">
                                    @error('unit_name_fa')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group row">
                                <label class="control-label text-end col-md-2">نام انگلیسی </label>
                                <div class="col-md-8">
                                    <input type="text" value="{{ $edit_unit->unit_name_en }}" name="unit_name_en" class="@error('unit_name_en') is-invalid @enderror form-control" placeholder="">
                                    @error('unit_name_en')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                       
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-success text-white"> <i class="fa fa-check"></i>
                                    ویرایش</button>
                        </div>
                    </div>
                </form>
            @endif
           {{-- end add unit --}}
           {{-- list unit --}}
            <div class="card-body">
                <h4 class="card-title">لیست واحد</h4>
                    <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>نام فارسی</th>
                                <th>نام انگلیسی</th>
                                <th>ویرایش</th>
                                <th>حذف</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $key = 1 ?>
                            @foreach($units as $unit)
                            <tr>
                                <td>{{ $key++ }}</td>
                                <td>{{$unit->unit_name_fa}}</td>
                                <td>{{$unit->unit_name_en}}</td>
                                <td>
                                    <a href="{{ route('unit.edit',$unit->id) }}" type="submit" class="btn btn-success text-white">ویرایش <i class="fas fa-eye-dropper"></i> </a>
                                </td>
                                <td>
                                    <form action="{{ route('unit.destroy',$unit->id) }}" method="POST">
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
            {{-- end list unit --}}
        </div>
    </div>
</div>
@endsection