@extends('layouts.master')
@section('content')
<div class="row page-titles">
    <div class="col-md-12 align-self-center text-end">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb justify-content-end">
                <li class="breadcrumb-item"><a href="javascript:void(0)">فعالیت های دیپارتمنت</a></li>
                <li class="breadcrumb-item active">تنظیمات پروژه ها</li>
            </ol>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-lg-12">
        <div class="card">
            {{-- add department_activity and edit  --}}
            @if($edit_department_activity == false)
                <form class="form" action="{{ route('department_activity.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header bg-info">
                        <h4 class="m-b-0 text-white">افزودن فعالیت</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <label class="control-labe col-3">نام *</label>
                                        <div class="col-md-9">
                                            <input type="text" value="{{ old('acitvity_name') }}" name="acitvity_name" class="@error('acitvity_name') is-invalid @enderror form-control" placeholder="">
                                            @error('acitvity_name')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <label class="control-label col-md-3">روز های</label>
                                        <div class="col-md-9">
                                            <input type="number" value="{{ old('acitvity_deys') }}" name="acitvity_deys" class="@error('acitvity_deys') is-invalid @enderror form-control" placeholder="">
                                            @error('acitvity_deys')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <label class="control-label col-md-3">فیصدی*</label>
                                        <div class="col-md-9">
                                            <input type="number" value="{{ old('acitvity_deys') }}" name="acitvity_percentage" class="@error('acitvity_deys') is-invalid @enderror form-control" placeholder="">
                                            @error('acitvity_deys')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group has-danger row">
                                        <label class="control-label col-md-4">دیپارتمنت*</label>
                                        <div class="col-md-8">
                                            <select name="department_id" class="form-control form-select">
                                                <option value="0">--انتخاب دیپارتمنت--</option>
                                                @foreach ($departments as $department )
                                                <option  value="{{ $department->id }}" >
                                                    {{ $department->name_da }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <label class="control-label col-md-3">ترتیب فعالیت*</label>
                                        <div class="col-md-9">
                                            <input type="number" value="{{ old('sort_of_activity') }}" name="sort_of_activity" class="@error('sort_of_activity') is-invalid @enderror form-control" placeholder="">
                                            @error('sort_of_activity')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
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
            @else
                <form action="{{ route('department_activity.update', $edit_department_activity->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="card-header bg-success">
                        <h4 class="m-b-0 text-white">ویرایش فعالیت</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <label class="control-labe col-3">نام *</label>
                                        <div class="col-md-9">
                                            <input type="text" value="{{ $edit_department_activity->acitvity_name }}" name="acitvity_name" class="@error('acitvity_name') is-invalid @enderror form-control" placeholder="">
                                            @error('acitvity_name')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <label class="control-label col-md-3">روز های</label>
                                        <div class="col-md-9">
                                            <input type="number" value="{{ $edit_department_activity->acitvity_deys }}" name="acitvity_deys" class="@error('acitvity_deys') is-invalid @enderror form-control" placeholder="">
                                            @error('acitvity_deys')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <label class="control-label col-md-3">فیصدی*</label>
                                        <div class="col-md-9">
                                            <input type="number" value="{{ $edit_department_activity->acitvity_percentage }}" name="acitvity_percentage" class="@error('acitvity_percentage') is-invalid @enderror form-control" placeholder="">
                                            @error('acitvity_percentage')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group has-danger row">
                                        <label class="control-label col-md-4">دیپارتمنت*</label>
                                        <div class="col-md-8">
                                            <select name="department_id" class="form-control form-select">
                                                <option value="0">--انتخاب دیپارتمنت--</option>
                                                @foreach ($departments as $department )
                                                <option  value="{{ $department->id }}" {{ ($department->id == $edit_department_activity->department_id) ? 'selected':'' }} >
                                                    {{ $department->name_da }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <label class="control-label col-md-3">ترتیب فعالیت*</label>
                                        <div class="col-md-9">
                                            <input type="number" value="{{ $edit_department_activity->sort_of_activity }}" name="sort_of_activity" class="@error('sort_of_activity') is-invalid @enderror form-control" placeholder="">
                                            @error('sort_of_activity')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                            <div class="col-md-1">
                                <button type="submit" class="btn btn-success w-100 text-white">
                                         ویرایش معلومات</button>
                            </div>
                        </div>
                    </div>
                </form>
            @endif
           {{-- end add department activity and edit --}}
           {{-- list department activity --}}
           <div class="row">
            <div class="col-lg-12 ">
                <div class="card">
                    <div class="card-header bg-info">

                        <h4 class="m-b-0 text-white">لیست فعالیت های دیپارتمنت ها</h4>

                    </div>
                    <div class="card-body">

                    </div>
                    <table id="config-table" class="table display table-striped border no-wrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>اسم</th>
                                <th>ترتیب فعالیت</th>
                                <th>روز ها</th>
                                <th>فیصدی</th>
                                <th>دیپارتمنت</th>
                                <th>حالت</th>
                                @can('edit_department_activity')
                                <th>ویرایش</th>
                                @endcan
                                @can('delete_department_activity')
                                <th>حذف</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($department_activities as $key => $department_activity)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $department_activity->acitvity_name }}</td>
                                <td>{{ $department_activity->sort_of_activity }}</td>
                                <td>{{ $department_activity->acitvity_deys }}</td>
                                <td>%{{ $department_activity->acitvity_percentage }}</td>
                                <td>
                                    @foreach ($department_activity->department_activities as $department_activit_name )

                                        {{ $department_activit_name->name_da }}
                                    @endforeach
                                </td>
                                @can('edit_department_activity')
                                    <td>
                                        @if ($department_activity->status == 0)
                                            <a href="{{ route('department_activity.status_department_activity', [$department_activity->id, $department_activity->department_id]) }}" type="submit" class="btn waves-effect waves-light btn-danger text-white"> غیر  فعال <i class=" fas fa-times"></i> </button>
                                        @else
                                            <a href="{{ route('department_activity.status_department_activity', [$department_activity->id, $department_activity->department_id]) }}" type="submit" class="btn waves-effect waves-light btn-success text-white"> فعال <i class=" fas fa-check"></i> </button>
                                        @endif
                                    </td>
                                @endcan
                                @can('edit_department_activity')
                                <td>
                                    <a href="{{ route('department_activity.edit',$department_activity->id) }}" type="submit" class="btn btn-success text-white">ویرایش <i class="fas fa-eye-dropper"></i> </a>
                                </td>
                                @endcan
                                @can('delete_department_activity')
                                <td>
                                    <form action="{{ route('department_activity.destroy',$department_activity->id) }}" method="POST">
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
            {{-- end list department activity --}}
        </div>
    </div>
</div>


@endsection
@section('script')

<script>
    $(function() {
        $('#myTable').DataTable();
        var table = $('#example').DataTable({
            "columnDefs": [{
                "visible": false,
                "targets": 2
            }],
            "order": [
                [2, 'asc']
            ],
            "displayLength": 25,
            "drawCallback": function(settings) {
                var api = this.api();
                var rows = api.rows({
                    page: 'current'
                }).nodes();
                var last = null;
                api.column(2, {
                    page: 'current'
                }).data().each(function(group, i) {
                    if (last !== group) {
                        $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
                        last = group;
                    }
                });
            }
        });
        // Order by the grouping
        $('#example tbody').on('click', 'tr.group', function() {
            var currentOrder = table.order()[0];
            if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                table.order([2, 'desc']).draw();
            } else {
                table.order([2, 'asc']).draw();
            }
        });
        // responsive table
        $('#config-table').DataTable({
            responsive: true
        });
    });
</script>
@endsection
