@extends('layouts.master')

@section('style')
<link href="{{ asset('dist/css/pages/timeline-vertical-horizontal.css') }}" rel="stylesheet">
<link href="{{ asset('dist/css/pages/timeline-vertical-horizontal.css') }}" rel="stylesheet">
<link href="{{ asset('assets/node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/node_modules/bootstrap-select/bootstrap-select.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/node_modules/multiselect/css/multi-select.css') }}" rel="stylesheet" type="text/css" />

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
                                <option value="{{ $department->id }}">{{ $department->name_da }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="form-label">فایل*</label>
                        <input name="file" type="file" class="form-control" id="recipient-name">
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
                                <div class="timeline-panel">
                                    <div class="timeline-heading">
                                        <h4 class="timeline-title">@foreach($project_tracking->project_departments as $project_department) {{ $project_department->name_da }} @endforeach</h4>
                                        <p><small class="text-muted"><i class="fa fa-clock-o"></i>{{ $project_tracking->created_at->format('m/d/Y') }}</small></p>
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
                                            <button type="button" data-bs-target="#responsive-modal" data-bs-toggle="modal"
                                                class="btn btn-primary text-white"><i class="far fa-share-square"></i> ارسال پروژه</button>
                                        @endif
                                        <!-- <a href=""  data-bs-target="#show-report-modal" data-bs-toggle="modal"
                                                class="btn btn-info text-white"><i class="fas fa-info-circle"></i> نمایش گزارش</a> -->
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

<script src="{{ asset('assets/node_modules/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>

<script>
   
$(function() {

    $(".select2").select2();
    $('.selectpicker').selectpicker();
    //Bootstrap-TouchSpin
    // $(".vertical-spin").TouchSpin({
    //     verticalbuttons: true
    // });
    var vspinTrue = $(".vertical-spin").TouchSpin({
        verticalbuttons: true
    });
    if (vspinTrue) {
        $('.vertical-spin').prev('.bootstrap-touchspin-prefix').remove();
    }
    $("input[name='tch1']").TouchSpin({
        min: 0,
        max: 100,
        step: 0.1,
        decimals: 2,
        boostat: 5,
        maxboostedstep: 10,
        postfix: '%'
    });
    $("input[name='tch2']").TouchSpin({
        min: -1000000000,
        max: 1000000000,
        stepinterval: 50,
        maxboostedstep: 10000000,
        prefix: '$'
    });
    $("input[name='tch3']").TouchSpin();
    $("input[name='tch3_22']").TouchSpin({
        initval: 40
    });
    $("input[name='tch5']").TouchSpin({
        prefix: "pre",
        postfix: "post"
    });
    // For multiselect
    $('#pre-selected-options').multiSelect();
    $('#optgroup').multiSelect({
        selectableOptgroup: true
    });
    $('#public-methods').multiSelect();
    $('#select-all').click(function() {
        $('#public-methods').multiSelect('select_all');
        return false;
    });
    $('#deselect-all').click(function() {
        $('#public-methods').multiSelect('deselect_all');
        return false;
    });
    $('#refresh').on('click', function() {
        $('#public-methods').multiSelect('refresh');
        return false;
    });
    $('#add-option').on('click', function() {
        $('#public-methods').multiSelect('addOption', {
            value: 42,
            text: 'test 42',
            index: 0
        });
        return false;
    });
    $(".ajax").select2({
        ajax: {
            url: "https://api.github.com/search/repositories",
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function(data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                params.page = params.page || 1;
                return {
                    results: data.items,
                    pagination: {
                        more: (params.page * 30) < data.total_count
                    }
                };
            },
            cache: true
        },
        escapeMarkup: function(markup) {
            return markup;
        }, // let our custom formatter work
        minimumInputLength: 1,
        //templateResult: formatRepo, // omitted for brevity, see the source of this page
        //templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
    });
});
</script>

@endsection