@extends('layouts.master')

@section('style')

{{-- <link href="{{ asset('assets/node_modules/footable/css/footable.bootstrap.min.css') }}" rel="stylesheet" type="text/css" /> --}}
{{-- <link href="{{ asset('dist/css/pages/footable-page.css') }}" rel="stylesheet" type="text/css" /> --}}

@endsection

@section('content')
<?php  $sort_department = 1 ?>
<?php  $national_procurement =  false?>
<?php  $color =  false?>

<div class="row page-titles">
    <div class="col-md-12 align-self-center text-end">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb justify-content-end">
                <li class="breadcrumb-item"><a href="javascript:void(0)">گزارش پروژه </a></li>
                <li class="breadcrumb-item active">تنظیمات پروژه ها</li>
            </ol>
        </div>
    </div>
</div>


<!-- start show project info -->
<div class="row">
    <div class="card-header bg-info">
        <h4 class="m-b-0 text-white">{{ $project->name }}</h4>
    </div>
    <div class="row g-0">
        @if(!$project->length == null or  !$project->width == null)
        <div class="col-md-2">
            <div class="card border">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex no-block align-items-center">
                                <div>
                                    <p class="text-muted">طول : {{ $project->length }}</p>
                                    <p class="text-muted">طول : {{ $project->width }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @endif
        @if(!$project->number == null)
        <div class="col-md-2">
            <div class="card border">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex no-block align-items-center">
                                <div>
                                    <p class="text-muted">تعداد : {{ $project->number }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <div class="col-lg-1 col-md-1">
            <div class="card border">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex no-block align-items-center">
                                <div>
                                    <p class="text-muted">واحد :
                                        @foreach($project->units as $unit){{ $unit->unit_name_fa }} @endforeach</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3">
            <div class="card border">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex no-block align-items-center">
                                <div>
                                    <p class="text-muted">تطبیق کننده :
                                        @foreach($project->impliment_departments as $impliment_department)
                                        {{ $impliment_department->name_da }}
                                        @endforeach
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3">
            <div class="card border">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex no-block align-items-center">
                                <div>
                                    <p class="text-muted">مدیریت کننده :
                                        @foreach($project->management_departments as $management_department)
                                        {{ $management_department->name_da }}
                                        @endforeach
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3">
            <div class="card border">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex no-block align-items-center">
                                <div>
                                    <p class="text-muted">دیزاین کننده :
                                        @foreach($project->design_departments as $design_department)
                                        {{ $design_department->name_da }}
                                        @endforeach
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end show project info -->

<!-- start lsit project report -->
<div class="card">
    <div class="card-body">
        <div class="row">

            @if($total_percentage == 100)

                <h4 class="label label-danger col-2">فیصدی گزارش شما 100 فیصد تکمیل است </h4>
            @else
                <h4 class="card-title col-md-2"><a href=""  data-bs-target="#send-report-modal" data-bs-toggle="modal"
                class="btn btn-success text-white"><i class="fas fa-plus-circle"></i> ارسال گزارش</a></h4>
                <?php $impliment_departments = $project->impliment_departments()->first();?>

                @if (($impliment_departments->name_da == 'سکتور خصوصی' or $impliment_departments->name_da == 'سکتور_خصوصی'))
                    @if($project->procurement_type == 0)

                        @if ($reports->IsEmpty())

                            <?php $depratment = App\Models\Plan\Depratment::where('name_da','LIKE','%تدارکات%')->where('status','=','1')->first(); ?>
                                @if ($depratment->id == $department_id)
                                    <h4 class="card-title col-md-2"><a href="{{ route('procurement_type.changes_procurement_type',$project->id) }}"
                                    class="btn btn-info text-white"><i class="fas fa-plus-circle"></i> تدارکات ملی </a></h4>
                                @endif

                        @endif
                    @else

                    <div class="alert alert-info col-md-3">
                        <h5><i class="fa fa-exclamation-circle"></i> برای این پروژه مراحل تدارکاتی ملی انتخاب شده است </h5>
                    </div>

                    @endif
                @endif

            @endif
        </div>
        <h4 class="card-title col-md-1">لیست گزارشات</h4>

        <!-- Accordian -->
        <table id="config-table" class="table display table-striped border no-wrap">
            <thead>
                <tr class="footable-filtering">
                    <th data-bs-toggle="true"> #</th>
                    <th data-hide="all"> اسم فعالیت </th>
                    <th data-hide="all"> توضیحات </th>
                    <th data-hide="all"> فیصدی </th>
                    <th data-hide="all"> تاریخ </th>
                    <th data-hide="all"> ردکردن فعالیت </th>
                </tr>
            </thead>
            <tbody>
                @foreach($reports as  $key => $report)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>
                            @foreach($report->department_activities  as $department_activity) {{ $department_activity->acitvity_name }} @endforeach
                        </td>
                        <td>{{ $report->description }}</td>
                        <td>
                          <?php $department_activity = $report->department_activities->first(); ?>
                               {{ $department_activity->acitvity_percentage }}%
                        </td>
                        <td>{{ jdate($report->created_at)->format('l - d / m / Y')  }}</td>
                        <td >
                            @if ($report->reject_activity == null)
                                @if($total_percentage == 100)
                                    <button type="submit" class="btn btn-success text-white"><i class="fas fa-check"></i> تکمیل شد</button>
                                @else
                                    <button type="submit" data-bs-target="#reject_activity" data-bs-toggle="modal" class="btn btn-danger text-white" onclick="setRejectActivityId({{$report->id}})">
                                        <i class="fas fa-trash-alt"></i> رد گزارش
                                    </button>
                                @endif
                                <?php $sort_department += 1 ?>
                            @else
                               {{$report->reject_comment_activity}}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <table>
            <td  class="label-info" >مجموع فصیدی تکیمیل شده : {{ $total_percentage  }}</td>
        </table>
    </div>
</div>
<!-- end lsit project report -->


<!-- start send modal content -->
<div id="send-report-modal" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">ارسال گزارش</h4>
                <button type="submit" class="btn-close" data-bs-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('report_project_tracking.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <input  name="department_id" type="hidden" value="{{ $department_id }}">
                        <input name="project_id" type="hidden" value="{{ $id }}">
                        <input name="project_tracking_id" type="hidden" value="{{ $project_tracking_id }}">
                    </div>
                    <div class="form-group">
                         <?php $lable = 'info' ?>

                        @foreach ($department_activities as $department_activity)
                            <div class="col-12 label label-table label-{{$lable}}"><h4>ارسال گزارش فعالیت: {{ $department_activity->acitvity_name }}</h4></div>


                                @if ($department_activity_for_add_after_insert != null)
                                    @if ($department_activity->id == $department_activity_for_add_after_insert->department_activity_id and $department_activity_for_add_after_insert->number == 0  )
                                        <input name="department_activity_id" type="hidden" value="{{ $department_activity->id }}">
                                        <input name="department_activity_for_add" type="hidden" value="{{ $department_activity_for_add_after_insert->id }}">
                                        <?php $lable = 'danger' ?>
                                    @endif
                                @else

                                    @if ($department_activity->sort_of_activity == $sort_department)
                                        <input name="department_activity_id" type="hidden" value="{{ $department_activity->id }}">
                                        <?php $lable = 'danger' ?>
                                    @endif
                                @endif
                        @endforeach


                    </div>
                    <div class="form-group">
                        <label for="message-text" class="form-label">توضیحات*</label>
                        <textarea name="description" rows="5" class="form-control" id="message-text"></textarea>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-bs-dismiss="modal">لغو</button>
                    <button type="submit" class="btn btn-success text-white"> <i class="far fa-share-square"></i>
                                ارسال</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<!-- end send modal content -->
{{-- @dd($sort_department) --}}
<!-- start reject activity  -->
<div id="reject_activity" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> ارسال گزارش ردکردن فعالیت</h4>
                <button type="submit" class="btn-close" data-bs-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('reject_activity_reported.reject_activity') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('patch')

                    <div class="form-group">
                        <input name="report_project_tracking_id" type="hidden" id="reject_activity_id_1">

                    </div>
                    <div class="form-group">
                        <label for="message-text" class="form-label">توضیحات*</label>
                        <textarea name="reject_comment_activity" rows="5" class="form-control" id="message-text"></textarea>
                    </div>
                    <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-default waves-effect" data-bs-dismiss="modal">لغو</button> --}}
                    <button type="submit" class="btn btn-success text-white"> <i class="far fa-share-square"></i>
                                ارسال</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<!-- end reject activity -->

@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment-jalaali.min.js"></script>

<script>
    var shamsiDate = moment().format('jYYYY/jM/jD');
    document.getElementById('shamsi-date').innerHTML = shamsiDate;
</script>
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

<script>
    function setRejectActivityId(id) {
         const inputElement = document.getElementById('reject_activity_id_1');

         inputElement.value = id;
     }

</script>
@endsection
