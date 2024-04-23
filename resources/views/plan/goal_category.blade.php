<div class="col-lg-6">
        <div class="card">
            {{-- add goal category --}}
            @if($edit_goal_category == false)
            <form action="{{ route('goal_category.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-header bg-info">
                    <h4 class="m-b-0 text-white">افزودن دسته بندی هدف</h4>
                </div>
                <div class="card-body">
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="control-label text-end col-md-3">نام دسته بندی</label>
                            <div class="col-md-8">
                                <!-- <?php  ?> -->
                                <input type="text"  name="name" class="@error('name') is-invalid @enderror form-control" placeholder="">
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
            <form action="{{ route('goal_category.update', $edit_goal_category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="card-header bg-success">
                    <h4 class="m-b-0 text-white">ویرایش دسته بندی هدف</h4>
                </div>
                <div class="card-body">
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="control-label text-end col-md-3">نام دسته بندی</label>
                            <div class="col-md-8">
                                <!-- <?php  ?> -->
                                <input type="text" value="{{ $edit_goal_category->name }}"  name="name" class="@error('name') is-invalid @enderror form-control" placeholder="">
                                @error('name')
                                <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                            <button type="submit" class="btn btn-success text-white">ویرایش</button>   
                    </div>
                </div>
            </form>
            @endif
            {{-- end add goal category --}}
            {{-- list goal category --}}
            <div class="card-body">
            <h4 class="card-title">لیست دسته بندی هدف</h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>نام</th>
                            <th>ویرایش</th>
                            <th>حذف</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $key = 1 ?>
                        @foreach($goal_categories as $goal_category)
                        <tr>
                            <td>{{ $key++ }}</td>
                            <td>{{$goal_category->name}}</td>                          
                            <td>
                                <a href="{{ route('goal_category.edit',$goal_category->id) }}" type="submit" class="btn btn-success text-white">ویرایش <i class="fas fa-eye-dropper"></i> </a>
                            </td>
                            <td>
                                <form action="{{ route('goal_category.destroy',$goal_category->id) }}" method="POST">
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
            {{-- end list goal category --}}
        </div>
        </div>
</div>


