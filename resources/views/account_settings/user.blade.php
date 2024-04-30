@extends('layouts.master')
@section('content')
<div class="row page-titles">
    <div class="col-md-12 align-self-center text-end">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb justify-content-end">
                <li class="breadcrumb-item"><a href="javascript:void(0)">کاربران</a></li>
                <li class="breadcrumb-item active">تنظیمات حساب کاربری</li>
            </ol>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 ">
        <div class="card">
            <div class="card-header bg-info">
            
                <h4 class="m-b-0 text-white">لیست کاربران</h4>
            
            </div>
            <div class="card-body">
            @can("add_user")
                <div class="col-lg-2 col-md-4">
                    <a href="{{ route('user.create') }}" class="btn w-100 btn-outline-info"><i class="fa fa-plus-circle"></i> افزودن کاربر جدید</a>
                </div>
            @endcan
            </div>
            <table id="config-table" class="table display table-striped border no-wrap">
                <thead>
                    <tr>
                        <th>نام</th>
                        <th>تخلص</th>
                        <th>شماره تماس</th>
                        <th>ایمیل</th>
                        <th>سطح دسترسی</th>
                        <th>دیپارتمنت</th>
                        <th>تصویر</th>
                        <th>حالت</th>
                        <th>ویرایش</th>
                        <th>حذف</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->last_name }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->name }}</td>
                        <td>
                            @if($user->img == null)
                                <img width="50" height="50" src="{{ asset('img/user.jpg') }}" >
                            @else
                                <img width="50" height="50" src="{{ asset($user->img) }}" >
                            @endif
                        </td>
                        <td>
                            @if ($user->status == 0)
                            <button type="button" class="btn waves-effect waves-light btn-danger text-white">غیر فعال <i class=" fas fa-times"></i> </button>
                            @else
                            <button type="submit" class="btn waves-effect waves-light btn-success text-white"> فعال <i class="fas fa-check"></i> </button>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('user.edit',$user->id) }}" type="submit" class="btn btn-success text-white">ویرایش <i class="fas fa-eye-dropper"></i> </a>
                        </td>
                        <td>
                            <form action="{{ route('user.destroy',$user->id) }}" method="POST">
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