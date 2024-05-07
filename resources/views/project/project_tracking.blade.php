@extends('layouts.master')

@section('style')
<link href="{{ asset('dist/css/pages/timeline-vertical-horizontal.css') }}" rel="stylesheet">
<link href="{{ asset('dist/css/pages/timeline-vertical-horizontal.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="row page-titles">
    <div class="col-md-12 align-self-center text-end">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb justify-content-end">
                <li class="breadcrumb-item"><a href="javascript:void(0)">تعقیب پروژه </a></li>
                <li class="breadcrumb-item active">تنظیمات پروژه ها</li>
            </ol>
        </div>
    </div>
</div>


<!-- start send modal content -->
<div id="responsive-modal" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">ارسال پروژه به بخش بعدی</h4>
                <button type="submit" class="btn-close" data-bs-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('project_tracking.update', $project->id ) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('put')

                    <div class="form-group">
                        <label class="form-label">انتخاب دیپارتمنت*</label>


                        <select name="department_id" class="form-select col-12" id="inlineFormCustomSelect">
                                <option value="0" selected="">انتخاب دیپارتمنت</option>
                            @foreach($departments as $department)
                                @if((auth()->user()->can('all_tracking_departments')))
                                    <option value="{{ $department->id }}">{{ $department->name_da }}</option>
                                @elseif(auth()->user()->department_id != $department->id)
                                    <option value="{{ $department->id }}">{{ $department->name_da }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="form-label">فایل*</label>
                        <input name="file" type="file" class="form-control" id="recipient-name">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="form-label">تاریخ ارسال*</label>
                        <input name="date_of_send" type="datetime-local" class="form-control" id="recipient-name">
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




<div class="row">
    <div class="card-header bg-info">
        <h4 class="m-b-0 text-white">{{ $project->name }}</h4>
    </div>
    <div class="row g-0">
        <div class="col-lg-1 col-md-1">
            <div class="card border">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex no-block align-items-center">
                                <div>
                                    <p class="text-muted">طول : {{ $project->length }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-1 col-md-1">
            <div class="card border">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex no-block align-items-center">
                                <div>
                                    <p class="text-muted">عرض : {{ $project->width }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if(!$project->number == null)
        <div class="col-lg-1 col-md-1">
            <div class="card border">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex no-block align-items-center">
                                <div>
                                    <p class="text-muted">عرض : {{ $project->number }}</p>
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
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <ul class="timeline">
                    @if($project_trackings->isEmpty())
                        <li class="timeline-inverted">
                            <button type="button" data-bs-target="#responsive-modal" data-bs-toggle="modal"
                                                class="btn btn-success text-white"><i class="fas fa-check"></i>  ارسال پروژه</button>
                        </li>
                    @else
                        <?php  $percentage = 0 ?>
                        @foreach($project_trackings as $key => $project_tracking)
                            <li @if($loop->even) class="timeline-inverted" @endif>
                                <div class="timeline-badge success">
                                    @foreach($project_tracking->project_departments as $project_department) {{ $project_department->name_da }} @endforeach
                                </div>
                                <div @if(!$percentage == 100) style="background-color: #FFF7F7;" @endif class="timeline-panel">
                                    <div class="timeline-heading">
                                        <h4 class="timeline-title">@foreach($project_tracking->project_departments as $project_department) {{ $project_department->name_da }} @endforeach</h4>
                                        <p><small class="text-muted"><i class="fa fa-clock-o"></i>تاریخ ارسال به این بخش : {{ jdate($project_tracking->date_of_send)->format('%A - d / m / Y') }}</small></p>
                                        <p>
                                                <?php
                                                   $percentage = App\Models\Project\ReportProjectTracking::where('project_id','=',$project_tracking->project_id)->where('project_tracking_id','=',$project_tracking->id)->where('department_id','=',$project_tracking->department_id)->sum('percentage');
                                                 ?>
                                            فیصدی کار انجام شده : {{ $percentage }}
                                            <div class="progress progress-xs margin-vertical-10 ">
                                                <div class="progress-bar bg-success progress-bar-striped" style="width: <?php echo $percentage; ?>% ;height:15px;">{{ $percentage }}</div>
                                            </div>
                                        </p>

                                    </div>
                                    <div class="timeline-body">
                                        <p>{{ $project_tracking->description}}</p>
                                    </div>
                                    <br>
                                    <div class="timeline-body">

                                        <a href="{{ asset($project_tracking->file) }}" class="btn btn-success text-white"><i class="fas fa-download"></i>
                                            دانلود فایل ها</a>

                                        @if($loop->last)
                                            @if((auth()->user()->can('all_tracking_departments')))

                                                <button type="button" data-bs-target="#responsive-modal" data-bs-toggle="modal"
                                                        class="btn btn-primary text-white"><i class="far fa-share-square"></i> ارسال پروژه</button>
                                            @else

                                                @if($project_tracking->department_id == auth()->user()->department_id)
                                                    <button type="button" data-bs-target="#responsive-modal" data-bs-toggle="modal"
                                                        class="btn btn-primary text-white"><i class="far fa-share-square"></i> ارسال پروژه</button>
                                                @endif
                                            @endif
                                        @endif
                                        <a href="{{ route('report_project_tracking.show',[$project->id,$project_tracking->department_id,$project_tracking->id]) }}"
                                                class="btn btn-info text-white"><i class="fas fa-info-circle"></i> گزارش</a>
                                    </div>
                                </div>

                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
    </div>

</div>

</div>

@endsection
@section('script')
<script src="{{ asset('assets/node_modules/horizontal-timeline/js/horizontal-timeline.js') }}"></script>


@endsection
