@extends('layouts.master')

@section('style')

<link href="{{ asset('assets/node_modules/footable/css/footable.bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('dist/css/pages/footable-page.css') }}" rel="stylesheet" type="text/css" />

@endsection

@section('content')
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
</div>
<!-- end show project info -->

<!-- start lsit project report -->
<div class="card">
    <div class="card-body">
        <div class="row">

            <h4 class="card-title col-1">لیست گزارشات</h4>
            
            @if($percentage == 100)
            
            <h4 class="label label-danger col-2">فیصدی گزارش شما 100 فیصد تکمیل است </h4>
            @else
            <h4 class="card-title col-2"><a href=""  data-bs-target="#send-report-modal" data-bs-toggle="modal"
            class="btn btn-success text-white"><i class="fas fa-plus-circle"></i> ارسال گزارش</a></h4>
            @endif
        </div>
        <!-- Accordian -->
        <div class="accordion" id="accordionTable">
            <div class="card m-b-5">
                <div id="col1" class="collapse show" aria-labelledby="heading1" data-parent="#accordionTable">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="demo-foo-accordion" class="table table-bordered m-b-0 toggle-arrow-tiny" data-filtering="true" data-paging="true" data-sorting="true">
                                <thead>
                                    <tr class="footable-filtering">
                                        <th data-bs-toggle="true"> #</th>
                                        <th data-hide="all"> توضیحات </th>
                                        <th data-hide="all"> فیصدی </th>
                                        <th data-hide="all"> تاریخ </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reports as $key => $report)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $report->description }}</td>
                                            <td>{{ $report->percentage }}</td>
                                            <td>{{ jdate($report->create_at)->format('%A - d / m / Y')  }}</td>
                                        </tr>
                                        
                                    @endforeach
                                </tbody>
                            </table>
                            <table>
                                <td  class="label-info" >مجموع فصیدی تکیمیل شده : {{ $percentage }}</td>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>                           
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
                        <label for="recipient-name" class="form-label">فیصدی کار انجام شده*</label>
                        <input name="percentage" type="number" class="form-control" id="recipient-name">
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


@endsection
@section('script')

<script src="{{ asset('assets/node_modules/footable/js/footable.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('dist/js/pages/footable-init.js') }}" type="text/javascript"></script>

@endsection