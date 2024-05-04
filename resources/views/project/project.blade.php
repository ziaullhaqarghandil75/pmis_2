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
                        <th>هدف</th>
                        <!-- <th>دسته بندی هدف</th> -->
                        <th>اسم پروژه</th>
                        <th>موقعیت</th>
                        <th>بودیجه</th>
                        <th>تطبیق کننده</th>
                        <th>مدیریت کننده</th>
                        <th>دیزاین کننده</th>
                        <th>حالت فعلی</th>
                        <th>عملیه ها</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @foreach($projects as  $key => $project)
                        @if(!$project_trackings == false)
                            @foreach($project_trackings as $key => $project_tracking )
                                @if($project_tracking->project_id == $project->id)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>@foreach($project->goals as $goal){{ $goal->name }} @endforeach</td>
                                        <td>{{ $project->name }}</td>
                                        <td>@foreach($project->districts as $district){{ $district->name }} @endforeach</td>
                                        <td>10000 افغانی</td>
                                        <td>@foreach($project->impliment_departments as $impliment_department){{ $impliment_department->name_da }} @endforeach</td>
                                        <td>@foreach($project->management_departments as $management_department){{ $management_department->name_da }} @endforeach</td>
                                        <td>@foreach($project->design_departments as $design_department){{ $design_department->name_da }} @endforeach</td>
                                        <?php
                                            $project_modes = App\Models\Project\ProjectTracking::with('project_departments','percentage_project_view')->where('project_id','=',$project_tracking->project_id)->orderByDesc('id')->first();
                                        ?>
                                           
                                        <td>
                                            @foreach($project_modes->project_departments as $project_department)
                                            <?php
                                                $project_modes_p = 0;
                                                $project_modes_p = App\Models\Project\ReportProjectTracking::where('project_id','=',$project_modes->project_id)
                                                                                                            ->where('department_id','=',$project_modes->department_id)
                                                                                                            ->where('project_tracking_id','=',$project_modes->id)->sum('percentage');
                                            ?>
                                                {{ $project_department->name_da }}
                                                <div class="progress m-t-20">
                                                <div class="progress-bar bg-success" style="width: <?php echo $project_modes_p?>%; height:15px;" role="progressbar">{{ $project_modes_p }}%</div>
                                                </div>
                                            @endforeach</td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="ti-settings"></i>
                                                </button>

                                                <div class="dropdown-menu animated flipInY">
                                                <a  class="dropdown-item bg-info" href="{{ route('project.show',$project->id) }}" type="submit" class="btn btn-info text-white">توضیحات <i class="icons-Info-Window"></i> </a>
                                            
                                                @can('edit_project')
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item bg-info " href="{{ route('project.edit',$project->id) }}" type="submit" class="btn btn-success text-white">ویرایش <i class="fas fa-eye-dropper"></i> </a>
                                                @endcan

                                                @can('delete_project')
                                                <div class="dropdown-divider"></div>
                                                <form action="{{ route('project.destroy',$project->id) }}" method="POST">
                                                    @method('delete')
                                                    @csrf
                                                        <button type="submit" class="dropdown-item btn bg-danger ">حذف <i class="fas fa-trash-alt"></i> </button>
                                                </form>    
                                                @endcan
                                            <div class="dropdown-divider"></div>
                                                <a class="dropdown-item bg-info " href="{{ route('project_tracking.show',$project->id) }}" type="submit" class="btn btn-success text-white">تعقیب پروژه <i class="icons-Management"></i> </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @else
                            <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>@foreach($project->goals as $goal){{ $goal->name }} @endforeach</td>
                                        <td>{{ $project->name }}</td>
                                        <td>@foreach($project->districts as $district){{ $district->name }} @endforeach</td>
                                        <td>10000 افغانی</td>
                                        <td>@foreach($project->impliment_departments as $impliment_department){{ $impliment_department->name_da }} @endforeach</td>
                                        <td>@foreach($project->management_departments as $management_department){{ $management_department->name_da }} @endforeach</td>
                                        <td>@foreach($project->design_departments as $design_department){{ $design_department->name_da }} @endforeach</td>
                                        <?php
                                            $project_modes = App\Models\Project\ProjectTracking::with('project_departments','percentage_project_view')->where('project_id','=',$project->id)->orderByDesc('id')->first();
                                        ?>
                                        <td>
                                            @if(!$project_modes == null)
                                                @foreach($project_modes->project_departments as $project_department)
                                                <?php
                                                    $project_modes_p = 0;
                                                    $project_modes_p = App\Models\Project\ReportProjectTracking::where('project_id','=',$project_modes->project_id)
                                                                                                                ->where('department_id','=',$project_modes->department_id)
                                                                                                                ->where('project_tracking_id','=',$project_modes->id)->sum('percentage');
                                                ?>
                                                    {{ $project_department->name_da }}
                                                    <div class="progress m-t-20">
                                                        @if($project_modes_p == '0')
                                                            <div class="progress-bar bg-danger" style="width: 100%; height:15px;" role="progressbar">0%</div>
                                                        @else
                                                            <div class="progress-bar bg-success" style="width: <?php echo $project_modes_p?>%; height:15px;" role="progressbar">{{ $project_modes_p }}%</div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            @else
                                            پروژ انتقال نه شده است.    
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="ti-settings"></i>
                                                </button>

                                                <div class="dropdown-menu animated flipInY">
                                                <a  class="dropdown-item bg-info" href="{{ route('project.show',$project->id) }}" type="submit" class="btn btn-info text-white">توضیحات <i class="icons-Info-Window"></i> </a>
                                                @can('edit_project')
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item bg-info " href="{{ route('project.edit',$project->id) }}" type="submit" class="btn btn-success text-white">ویرایش <i class="fas fa-eye-dropper"></i> </a>
                                                @endcan

                                                @can('delete_project')
                                                <div class="dropdown-divider"></div>
                                                <form action="{{ route('project.destroy',$project->id) }}" method="POST">
                                                    @method('delete')
                                                    @csrf
                                                        <button type="submit" class="dropdown-item btn bg-danger ">حذف <i class="fas fa-trash-alt"></i> </button>
                                                </form> 
                                                @endcan

                                            <div class="dropdown-divider"></div>
                                                <a class="dropdown-item bg-info " href="{{ route('project_tracking.show',$project->id) }}" type="submit" class="btn btn-success text-white">تعقیب پروژه <i class="icons-Management"></i> </a>
                                            </div>
                                        </td>
                            </tr>
                        @endif
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