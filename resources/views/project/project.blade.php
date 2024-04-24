@extends('layouts.master')
@section('content')
<div class="row page-titles">
    <div class="col-md-12 align-self-center text-end">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb justify-content-end">
                <li class="breadcrumb-item"><a href="javascript:void(0)">پروژه ها</a></li>
                <li class="breadcrumb-item active">تنظیمات پروژه ها</li>
            </ol>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 ">
        <div class="card">
            <div class="card-header bg-info">
            
                <h4 class="m-b-0 text-white">لیست پروژه ها</h4>
            
            </div>
            <div class="card-body">
            @can("add_project")
                <div class="col-lg-2 col-md-4">
                    <a href="{{ route('project.create') }}" class="btn w-100 btn-outline-info"><i class="fa fa-plus-circle"></i> افزودن پروژه جدید</a>
                </div>
            @endcan
            </div>
            <table id="config-table" class="table display table-striped border no-wrap">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>نام</th>
                        <th>هدف</th>
                        <th>دسته بندی هدف</th>
                        <th>اسم پروژه</th>
                        <th>ابعاد</th>
                        <th>موقعیت</th>
                        <th>بودیجه</th>
                        <th>تطبیق کننده</th>
                        <th>مدیریت کننده</th>
                        <th>دیزاین کننده</th>
                        <th>نوعیت</th>
                        <th>حالت فعلی</th>
                        <th>عملیه ها</th>
                    </tr>
                </thead>
                <tbody>
                   
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