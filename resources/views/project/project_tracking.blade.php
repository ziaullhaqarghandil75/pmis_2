@extends('layouts.master')

@section('style')

<link href="{{ asset('dist/css/pages/timeline-vertical-horizontal.css') }}" rel="stylesheet">
<link href="{{ asset('dist/datepicker/node_modules/vazir-font/dist/font-face.css') }}" rel="stylesheet">
<link href="{{ asset('dist/date1/kamadatepicker.min.css') }}" rel="stylesheet">

<script src="{{ asset('dist/date1/kamadatepicker.min.js') }}"></script>
<script src="{{ asset('dist/date1/kamadatepicker.holidays.js') }}"></script>
<script src="{{ asset('dist/date1/kamadatepicker.js') }}"></script>


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

<?php
    $level = 1;
?>


<div class="row">
    <div class="card-header bg-info">
        <h4 class="m-b-0 text-white">{{ $project->name }}</h4>
    </div>
    <div class="row g-0">
        {{-- @dd($project) --}}
        @if(!$project->length == null or !$project->width == null)
        <div class=" col-md-2">
            <div class="card border">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex no-block align-items-center">
                                <div>
                                    <p class="text-muted">طول : {{ $project->length }}</p>
                                    <p class="text-muted">عرض : {{ $project->width }}</p>
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
                                    <p class="text-muted"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <div class="col-md-1">
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
        <div class="col-md-3">
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
        <div class="col-md-3">
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
        <div class="col-md-3">
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
                    @if($project_trackings->isEmpty() and auth()->user()->can('all_tracking_departments'))

                        <li class="timeline-inverted">
                            <button type="button" data-bs-target="#responsive-modal" data-bs-toggle="modal"
                                                class="btn btn-success text-white"><i class="fas fa-check"></i>  ارسال پروژه</button>
                                                <div id="shamsi-date"></div>

                        </li>
                    @else
                        @php $project_tracking_level = collect(); @endphp
                        @foreach($project_trackings as $key => $project_tracking)

                            @if (!$project_tracking_level->contains($project_tracking->department_id))

                                @if($project_tracking->reject_project_tracking == null)
                                    <?php $level++ ?>
                                    @php
                                         $project_tracking_level->push($project_tracking->department_id);
                                    @endphp
                                @endif

                            @endif

                            <li @if($loop->even) class="timeline-inverted" @endif>
                                <div class="timeline-badge success">
                                    {{$key+1}}
                                </div>
                                <?php
                                $percentage = App\Models\Project\ReportProjectTracking::where('report_project_tracking.project_id', $project_tracking->project_id)
                                                                                         ->where('report_project_tracking.department_id', $project_tracking->department_id)
                                                                                         ->where('report_project_tracking.project_tracking_id', $project_tracking->id)
                                                                                         ->where('report_project_tracking.reject_activity', null)
                                                                                         ->join('department_activities', 'department_activities.id', '=', 'report_project_tracking.department_activity_id')
                                                                                         ->sum('department_activities.acitvity_percentage');
                                ?>
                                <div  @if($percentage == 100) style="background-color: #fad4d4;" @endif id="myDiv" class="timeline-panel @if($project_tracking->reject_project_tracking != null) btn-warning @endif">
                                    <div class="timeline-heading">
                                        <h4 class="timeline-title">@foreach($project_tracking->project_departments as $project_department) {{ $project_department->name_da }} @endforeach</h4>
                                        <p><small class="text-muted"><i class="fa fa-clock-o"></i>تاریخ ارسال به این بخش : {{ jdate($project_tracking->date_of_send)->format('%A - d / m / Y') }}</small></p>
                                        <p>

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

                                        <a href="{{ asset($project_tracking->file) }}" class="btn btn-success text-white m-1"><i class="fas fa-download"></i>
                                            دانلود فایل ها</a>

                                        @if($loop->last)
                                            @if((auth()->user()->can('reject_project_tracking')))
                                                <button type="button" data-bs-toggle="modal" data-bs-target="#responsive-modal-reject"
                                                                         class="btn btn-primary text-white m-1" onclick="setProjectTrackingId({{ $project_tracking->id }})">
                                                                         <i class="far fa-share-square"></i> رد کردن
                                                                        </button>
                                            @endif

                                            @if((auth()->user()->can('all_tracking_departments')))

                                                @php $name_da = $project_tracking->project_departments->first()->name_da; @endphp
                                                {{-- @dd($name_da) --}}
                                                @if ((strpos($name_da, 'ریاست کار') !== false or strpos($name_da, 'حفظ و مراقبت') !== false))
                                                @elseif ((strpos($name_da, 'ریاست تنظیم') !== false or strpos($name_da, 'ریاست_تنظیم') !== false))
                                                @else
                                                    <button type="button" data-bs-target="#responsive-modal" data-bs-toggle="modal"
                                                    class="btn btn-primary text-white m-1"><i class="far fa-share-square"></i> ارسال پروژه</button>
                                                @endif

                                            @else
                                                @if($project_tracking->department_id == auth()->user()->department_id)

                                                    @php $name_da = $project_tracking->project_departments->first()->name_da; @endphp
                                                    {{-- @dd($name_da) --}}
                                                    @if ((strpos($name_da, 'ریاست کار') !== false or strpos($name_da, 'حفظ و مراقبت') !== false))
                                                    @elseif ((strpos($name_da, 'ریاست تنظیم') !== false or strpos($name_da, 'ریاست_تنظیم') !== false))
                                                    @else
                                                        <button type="button" data-bs-target="#responsive-modal" data-bs-toggle="modal"
                                                        class="btn btn-primary text-white m-1"><i class="far fa-share-square"></i> ارسال پروژه</button>
                                                    @endif

                                                    {{-- <button type="button" data-bs-target="#responsive-modal" data-bs-toggle="modal" --}}
                                                        {{-- class="btn btn-primary text-white m-1"><i class="far fa-share-square"></i> ارسال پروژه</button> --}}
                                                    {{-- @if((auth()->user()->can('reject_project_tracking')))
                                                        <button type="submit" data-bs-target="#responsive-modal-reject" data-bs-toggle="modal"
                                                            class="btn btn-primary text-white m-1"><i class="far fa-share-square" onclick="setProjectTrackingId({{ $project_tracking->id }})"></i>sdfsرد کردن</button>
                                                    @endif --}}

                                                    @if($project_tracking->reject_project_tracking == null)
                                                            <a href="{{ route('report_project_tracking.show',[$project->id,$project_tracking->department_id,$project_tracking->id]) }}"
                                                            class="btn btn-info text-white m-1"><i class="fas fa-info-circle"></i> گزارش</a>
                                                    @endif
                                                @endif
                                            @endif
                                        @endif
                                        @if((auth()->user()->can('all_tracking_departments')))
                                            @if($project_tracking->reject_project_tracking == null)
                                                <a href="{{ route('report_project_tracking.show',[$project->id,$project_tracking->department_id,$project_tracking->id]) }}"
                                                    class="btn btn-info text-white m-1"><i class="fas fa-info-circle"></i> گزارش</a>
                                            @endif
                                        @endif

                                        @can('add_budget_after_design')
                                            @foreach ($project->design_departments as $design_department)
                                                @if($percentage == 100 and $design_department->id == $project_tracking->department_id)
                                                    <button type="button" data-bs-target="#responsive-modal-budgets" data-bs-toggle="modal"
                                                    class="btn btn-info text-white m-1"><i class="fas fa-dollar-sign"></i> افزودن بودیجه بعد از دیزاین</button>
                                                @elseif($percentage == 100 and $project_tracking->department_id == auth()->user()->department_id)
                                                    <button type="button" data-bs-target="#responsive-modal-budgets" data-bs-toggle="modal"
                                                    class="btn btn-info text-white m-1"><i class="fas fa-dollar-sign"></i> افزودن بودیجه بعد از دیزاین</button>
                                                @endif
                                            @endforeach
                                        @endcan
                                        @can('add_contract_budget')
                                        @foreach ($project->impliment_departments as $impliment_department)
                                            @foreach($project_tracking->project_departments as $project_department)
                                                <?php
                                                $rocurement_department = App\Models\Plan\Depratment::where('name_da','LIKE','%تدارکات%')->first();
                                                ?>

                                                @if (
                                                    ($impliment_department->name_da == 'سکتور خصوصی' or  $impliment_department->name_da == 'سکتور_خصوصی')
                                                and !$rocurement_department == null
                                                and ($project_department->name_da == 'ریاست تدارکات' or $project_department->name_da == 'ریاست_تدارکات' or $project_department->name_da == 'تدارکات')
                                                )
                                                    @if($project_tracking->reject_project_tracking == null)
                                                        <button type="button" data-bs-target="#responsive-modal-contract_budget" data-bs-toggle="modal"
                                                            class="btn btn-info text-white"><i class="fas fa-dollar-sign"></i>افزودن بودیجه قرار داد شده</button>
                                                    @endif
                                                @elseif ($percentage == 100 and $impliment_department->id == $project_tracking->department_id)
                                                    @if($project_tracking->reject_project_tracking == null)
                                                        <button type="button" data-bs-target="#responsive-modal-contract_budget" data-bs-toggle="modal"
                                                        class="btn btn-info text-white"><i class="fas fa-dollar-sign"></i>افزودن بودیجه قرار داد شده</button>
                                                    @endif

                                                @endif
                                            @endforeach
                                        @endforeach
                                    @endcan
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

                        <div class="card-header bg-info">
                            <h4 class="m-b-0 text-white">ارسال پروژه به :

                                @if ($level == 1 )

                                    @foreach($project->design_departments as $design_department)
                                        {{ $design_department->name_da }}
                                        <input name="department_id" value="{{ $design_department->id }}" type="hidden">
                                    @endforeach

                                @elseif ($level == 2)
                                    {{-- @foreach($impliment_department = $project->impliment_departments->first() as ) --}}
                                    @php $impliment_department = $project->impliment_departments->first() @endphp
                                        @if (
                                               $impliment_department->name_da == 'سکتور خصوصی'
                                            or $impliment_department->name_da == 'سکتور_خصوصی'
                                            or $impliment_department->name_da == 'سکتورخصوصی'
                                            or $impliment_department->name_en == 'Private Sector'
                                            or $impliment_department->name_en == 'Private_Sector'
                                            or $impliment_department->name_en == 'private sector'
                                            or $impliment_department->name_en == 'private_sector'
                                            )
                                            <?php
                                            $rocurement_department = App\Models\Plan\Depratment::where('name_da','LIKE','%تدارکات%')->first();

                                            ?>
                                            {{ $rocurement_department->name_da }}
                                            <input name="department_id" value="{{ $rocurement_department->id }}" type="hidden">
                                        @else

                                            {{ $impliment_department->name_da }}
                                            <input name="department_id" value="{{ $impliment_department->id }}" type="hidden"
                                        @endif

                                @elseif ($level == 3)
                                    @php $management_department = $project->management_departments->first() @endphp
                                        {{ $management_department->name_da }}

                                        <input name="department_id" value="{{ $management_department->id }}" type="hidden">
                                @endif
                            </h4>
                        </div>

                        {{-- </select> --}}
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="form-label">فایل*</label>
                        <input name="file" type="file" class="form-control" id="recipient-name">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="form-label">تاریخ ارسال*</label>
                        {{-- <input type="text" id="date2"> --}}
                        <input name="date_of_send" id="date2"  type="text" class="form-control">
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
{{-- @dd(jdate('2024/5/19')) --}}

{{-- @dd($project->impliment_departments) --}}
{{-- @dd($project->management_departments) --}}
{{-- @dd($project_trackings->project_departments) --}}

@can('add_budget_after_design')
<!-- start send modal content budget after design -->
<div id="responsive-modal-budgets" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">بودیجه بعد از دیزاین</h4>
                <button type="submit" class="btn-close" data-bs-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('budget_after_design.add_budget_after_design', $project->id ) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <div class="card-header bg-info">
                            <?php $budget_after_design = 0 ?>
                                <h4 class="m-b-0 text-white">
                                    تعهد بودجوی : {{ number_format($project->budgets()->first()->main_budget) }} افغانی
                                </h4>
                                <hr>
                                @foreach ($project->budgets->year_budgets as $year_budget)
                                    <h4 class="m-b-0 text-white">
                                        بودیجه برای سال
                                        {{ jdate($year_budget->year )->format('Y') }}
                                        : {{ number_format($year_budget->this_year_budget) }} افغانی
                                    </h4>
                                    <hr>
                                @endforeach
                                <h4 class="m-b-0 text-white">
                                    بودیجه بعد از دیزاین :
                                    {{ number_format($project->budgets()->first()->budget_after_design) }} افغانی
                                </h4>
                                <?php $budget_after_design = $project->budgets()->first()->budget_after_design ?>
                        </div>
                    </div>
                    @if ($budget_after_design == 0)
                    <div class="form-group">
                        <label for="recipient-name" class="form-label">بودیجه*</label>
                        <input name="budget_after_design" value="{{ $budget_after_design }}" id="date2"  type="number" class="form-control">
                    </div>
                    <div class="modal-footer">
                    <button type="submit" class="btn btn-success text-white"> <i class="far fa-share-square"></i>
                                ذخیر معلومات</button>
                    </div>
                    @endif
                </form>
            </div>

        </div>
    </div>
</div>
<!-- end send modal content budget after design  -->
@endcan

@can('add_contract_budget')
<!-- start send modal content budget after design -->
<div id="responsive-modal-contract_budget" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">بودیجه بعد از قرار داد </h4>
                <button type="submit" class="btn-close" data-bs-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('contract_budget.add_contract_budget', $project->id ) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <div class="card-header bg-info">
                           <?php $contract_budget = 0 ?>
                                <h4 class="m-b-0 text-white">
                                    تعهد بودجوی : {{ number_format($project->budgets()->first()->main_budget) }} افغانی

                                </h4>
                                <hr>
                                @foreach ($project->budgets->year_budgets as $year_budget)
                                    <h4 class="m-b-0 text-white">
                                        بودیجه برای سال
                                        {{ jdate($year_budget->year )->format('Y') }}
                                        : {{ number_format($year_budget->this_year_budget) }} افغانی
                                    </h4>
                                    <hr>
                                @endforeach
                                <h4 class="m-b-0 text-white">
                                    بودیجه بعد از دیزاین :
                                    {{ number_format($project->budgets()->first()->budget_after_design) }} افغانی
                                </h4>
                                <hr>
                                <h4 class="m-b-0 text-white">
                                    بودیجه قرار داد شده :
                                    {{ number_format($project->budgets()->first()->contract_budget) }} افغانی
                                </h4>
                                <?php $contract_budget = $project->budgets()->first()->contract_budget ?>
                        </div>

                        {{-- </select> --}}
                    </div>
                    @if ($contract_budget == 0)
                    <div class="form-group">
                        <label for="recipient-name" class="form-label">بودیجه*</label>
                        <input name="contract_budget" value="{{ $contract_budget }}" id="date2"  type="number" class="form-control">
                        {{-- <input name="contract_budget" value="34123" id="date2"  type="number" class="form-control"> --}}
                    </div>

                    <div class="modal-footer">
                    <button type="submit" class="btn btn-success text-white"> <i class="far fa-share-square"></i>
                                ذخیر معلومات</button>
                    </div>
                    @endif
                </form>
            </div>

        </div>
    </div>
</div>
<!-- end send modal content budget after design  -->
@endcan

{{-- @dd($project_trackings->isEmpty()) --}}

@can('reject_project_tracking')
<!-- start reject project tracking -->
<div id="responsive-modal-reject" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">رد کردن پروسه</h4>
                <button type="submit" class="btn-close" data-bs-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                @php
                    $project_tracking_id = !$project_trackings->isEmpty() ? $project_tracking->id : 1;
                @endphp
                {{-- <form action="{{ route('project_tracking.reject_project_tracking', $project_tracking->id) }}" method="POST" enctype="multipart/form-data"> --}}
                <form action="{{ route('project_tracking.reject_project_tracking', $project_tracking_id ) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        {{-- <input name="project_tracking_id" type="test" id="project_tracking_id"> --}}
                        <input name="project_tracking_id" type="hidden" id="project_tracking_id" class="form-control">
                    </div>
                    {{-- <div class="col-md-6"> --}}
                        <div class="form-group">
                            <label class="form-label">دیپارتمنت</label>
                            <select class="form-control form-select" name="department_id">
                                @php $addedDepartments = collect(); @endphp

                                @foreach ($project_trackings as $project_tracking)
                                    @php $department = $project_tracking->project_departments->first(); @endphp

                                    @if (!$addedDepartments->contains($department->id))
                                        <option value="{{ $department->id }}">{{ $department->name_da }}</option>
                                        @php
                                            $addedDepartments->push($department->id);
                                        @endphp
                                    @endif
                                @endforeach

                            </select>
                        </div>
                    {{-- </div> --}}
                    <div class="form-group">
                        <label for="message-text" class="form-label">توضیحات*</label>
                        <textarea name="reject_project_tracking_comment" rows="5" class="form-control" id="message-text"></textarea>
                    </div>
                    <div class="modal-footer">
                    <button type="submit" class="btn btn-success text-white"> <i class="far fa-share-square"></i>
                                ذخیر معلومات</button>
                    </div>
                    {{-- @endif --}}
                </form>
            </div>

        </div>
    </div>
</div>
<!-- end reject project tracking -->
@endcan

@endsection
@section('script')
<script src="{{ asset('assets/node_modules/horizontal-timeline/js/horizontal-timeline.js') }}"></script>
<script>
    kamaDatepicker('date1', { buttonsColor: "red" });

    var customOptions = {
        placeholder: "روز / ماه / سال"
        , twodigit: true
        , closeAfterSelect: true
        , nextButtonIcon: "fa fa-arrow-circle-right"
        , previousButtonIcon: "fa fa-arrow-circle-left"
        , buttonsColor: "blue"
        , forceFarsiDigits: true
        , markToday: true
        , markHolidays: true
        , highlightSelectedDay: true
        , sync: true
        , gotoToday: true
    }
    kamaDatepicker('date2', customOptions);

    kamaDatepicker('date3', {
        nextButtonIcon: "assets/timeir_prev.png"
        , previousButtonIcon: "assets/timeir_next.png"
        , forceFarsiDigits: true
        , markToday: true
        , markHolidays: true
        , highlightSelectedDay: true
        , sync: true
        , pastYearsCount: 0
        , futureYearsCount: 3
        , swapNextPrev: true
        , holidays: HOLIDAYS // from kamadatepicker.holidays.js
        , disableHolidays: true
    });


    kamaDatepicker('date5-1', {
        position: 'auto' // top, bottom or auto
        , parentId: 'date5-parent'
    });
    kamaDatepicker('date5-2', {
        position: 'auto' // top, bottom or auto
        , parentId: 'date5-parent'
    });

    // init without ids inputs
    document.querySelectorAll('#without-ids input').forEach(input => { kamaDatepicker(input); });
</script>

<script>
    function setProjectTrackingId(id) {
        console.log('Setting project tracking ID:', id);
        const inputElement = document.getElementById('project_tracking_id');
            inputElement.value = id;
    }
</script>

@endsection
