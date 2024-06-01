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
                    <div class="col-md-5">
                        <div class="form-group row">
                            <label class="control-label text-end col-md-4">نام دسته بندی</label>
                            <div class="col-md-8">
                                <!-- <?php  ?> -->
                                <input type="text"  name="name" class="@error('name') is-invalid @enderror form-control" placeholder="">
                                @error('name')
                                <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                            <div class="form-group has-danger row">
                                <label class="control-label col-md-3">هداف</label>
                                <div class="col-md-8">
                                    <select name="goal_id" class="form-control form-select">
                                        <option value="0">--انتخاب هدف--</option>
                                        @foreach ($goals as $goal )
                                        <option  value="{{ $goal->id }}" >
                                            {{ $goal->goal_name }}
                                        </option>
                                        @endforeach
                                    </select>
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
                    <h4 class="m-b-0 text-white">تصحیح دسته بندی هدف</h4>
                </div>
                <div class="card-body">
                </div>
                <div class="row">
                    <div class="col-md-5">
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
                        <div class="col-md-5">
                            <div class="form-group has-danger row">
                                <label class="control-label col-md-3">هدف</label>
                                <div class="col-md-8">
                                    <select name="goal_id" class="form-control form-select">
                                        <option value="0">--انتخاب هدف--</option>
                                        @foreach ($goals as $goal )
                                        <option  value="{{ $goal->id }}" {{ ( $goal->id == $edit_goal_category->goal_id ) ? 'selected':'' }} >
                                            {{ $goal->goal_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    <div class="col-md-2">
                            <button type="submit" class="btn btn-success text-white">تصحیح</button>
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
                            <th>هدف</th>
                            <th>تصحیح</th>
                            <th>حذف</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($goal_categories as $key => $goal_category)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{$goal_category->name}}</td>
                            <td>@foreach($goal_category->goals as $goal){{$goal->goal_name}} @endforeach</td>
                            <td>
                                <a href="{{ route('goal_category.edit',$goal_category->id) }}" type="submit" class="btn btn-success text-white">تصحیح <i class="fas fa-edit"></i> </a>
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


