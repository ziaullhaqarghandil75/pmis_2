@extends('layouts.master')
@section('content')
<div class="row page-titles">
    <div class="col-md-12 align-self-center text-end">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb justify-content-end">
                <li class="breadcrumb-item"><a href="javascript:void(0)">اهداف</a></li>
                <li class="breadcrumb-item active">تنظیمات پلان</li>
            </ol>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-lg-6">
        <div class="card">
            {{-- add goal and edit  --}}
            @if($edit_goal == false)
                <form action="{{ route('goal.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header bg-info">
                        <h4 class="m-b-0 text-white">افزودن هدف</h4>
                    </div>
                    <div class="card-body">
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group row">
                                <label class="control-label text-end col-md-2">نام </label>
                                <div class="col-md-8">
                                    <input type="text" value="{{ old('goal_name') }}" name="goal_name" class="@error('goal_name') is-invalid @enderror form-control" placeholder="">
                                    @error('goal_name')
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
                <form action="{{ route('goal.update', $edit_goal->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="card-header bg-success">
                        <h4 class="m-b-0 text-white">ویرایش هدف</h4>
                    </div>
                    <div class="card-body">
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group row">
                                <label class="control-label text-end col-md-2">نام </label>
                                <div class="col-md-8">
                                    <input type="text" value="{{ $edit_goal->goal_name }}" name="goal_name" class="@error('goal_name') is-invalid @enderror form-control" placeholder="">
                                    @error('goal_name')
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
            @endif
           {{-- end add goal and edit --}}
           {{-- list goal --}}
            <div class="card-body">
                <h4 class="card-title">لیست اهداف</h4>
                    <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>هدف</th>
                                <th>ویرایش</th>
                                <th>حذف</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($goals as $key => $goal)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{$goal->goal_name}}</td>
                                <td>
                                    <a href="{{ route('goal.edit',$goal->id) }}" type="submit" class="btn btn-success text-white">ویرایش <i class="fas fa-eye-dropper"></i> </a>
                                </td>
                                <td>
                                    <form action="{{ route('goal.destroy',$goal->id) }}" method="POST">
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
            {{-- end list goal --}}
        </div>
    </div>
    @include('plan.goal_category')
</div>


@endsection