@extends('layouts.master')
@section('content')
    <div class="row page-titles">
        <div class="col-md-12 align-self-center text-end">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">توضیحات پروژه</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('project.index') }}">لیست پروژه</a></li>
                    <li class="breadcrumb-item active">تنظیمات پروژه ها</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h4 class="m-b-0 text-white">توضیحات پروژه: {{ $project->name }}</h4>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home"
                                type="button" role="tab" aria-controls="home" aria-selected="true">معلومات عمومی
                                برنامه</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                                type="button" role="tab" aria-controls="profile" aria-selected="false">تعقیب
                                برنامه</button>
                        </li>
                    </ul>
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <style>
                        .scrollable>table {
                        width: 100%;
                        }
                        th{
                            font-size: 16px;
                        }
                        th,td{
                            border: 2px solid rgb(192, 185, 185);
                            text-align: center;
                            font-family: B Nazanin;
                        }
                        h2,h5,h4 {
                            font-family: B Nazanin;
                        }
                        button {
                            font-family: B Nazanin;
                            font-size: 16px;
                        }
                        scrollable-table{
                            height: 10px;
                            overflow-x: auto;
                            scroll-snap-type: x mandatory;
                        }
                    </style>
                    <div class="tab-content" id="myTabContent">
                        {{-- start general information --}}
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="row">
                                <div class="col-lg-4 col-md-6 m-t-2">
                                    <div class="card">
                                        <div class="card-body border border-light p-3" style="box-shadow: 3px 3px 3px #ccc;">
                                            <h4 class="card-title">نام پروژه </h4>
                                            <div class="d-flex no-block align-items-center m-t-20 m-b-20">
                                                <div id="sparklinedash"><canvas width="67" height="30"
                                                        style="display: inline-block; width: 67px; height: 30px; vertical-align: top;"></canvas>
                                                </div>
                                                <div class="ms-auto">
                                                    <h5 class="text-purple"> <span
                                                            class="counter">{{ $project->name }}</span></h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="sparkline8" class="sparkchart"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="card">
                                        <div class="card-body  border border-light p-3" style="box-shadow: 3px 3px 3px #ccc;">
                                            <h4 class="card-title">برنامه</h4>
                                            <div class="d-flex no-block align-items-center m-t-20 m-b-20">
                                                <div id="sparklinedash2"><canvas width="67" height="30"
                                                        style="display: inline-block; width: 67px; height: 30px; vertical-align: top;"></canvas>
                                                </div>
                                                <div class="ms-auto">
                                                    <h5 class="text-purple"> <span class="counter">

                                                                {{$project->goal_category->first()->goals->first()->goal_name}}

                                                        </span></h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="sparkline8" class="sparkchart"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="card">
                                        <div class="card-body  border border-light p-3" style="box-shadow: 3px 3px 3px #ccc;">
                                            <h4 class="card-title">موقیعت</h4>
                                            <div class="d-flex no-block align-items-center m-t-20 m-b-20" >
                                                <div id="sparklinedash3"><canvas width="67" height="30"
                                                        style="display: inline-block; width: 67px; height: 30px; vertical-align: top;"></canvas>
                                                </div>
                                                <div class="ms-auto">
                                                    <h5 class="text-purple"> <span class="counter">
                                                        @foreach ($project->districts as $district)
                                                            {{ $district->name }} ,
                                                        @endforeach
                                                        </span></h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="sparkline8" class="sparkchart"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="card">
                                        <div class="card-body  border border-light p-3" style="box-shadow: 3px 3px 3px #ccc;">
                                            <h4 class="card-title">ابعاد اولیه</h4>
                                            <div class="d-flex no-block align-items-center" >

                                                <div class="ms-auto table-responsive">
                                                        <table  class="table table-hover no-wrap contact-list" data-paging="true">
                                                            <thead style="background-color: rgb(218, 222, 228)">
                                                                <th>طول</th>
                                                                <th>عرض</th>
                                                                <th>واحد</th>
                                                            </thead>
                                                            <tbody>
                                                                </tr>
                                                                    <td>{{ $project->length }}</td>
                                                                    <td>{{ $project->width }}</td>
                                                                    <td>{{ $project->units()->first()->unit_name_fa}}</td>
                                                                <tr>
                                                            </tbody>
                                                        </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="sparkline8" class="sparkchart"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="card">
                                        <div class="card-body  border border-light p-3" style="box-shadow: 3px 3px 3px #ccc;">
                                            <h4 class="card-title">بخش بودیجه
                                                {{-- <div class="col-lg-2 col-md-4"> --}}
                                                    <button class="btn btn-info">نوعیت تدارکات : {{ ($project->procurement_type == 0) ? 'تدارکات داخلی':'تدارکات ملی'}}</button>
                                                {{-- </div> --}}
                                                {{-- <div class="label label-table label-success">نوعیت تدارکات</div> --}}
                                            </h4>
                                            <div class="d-flex no-block align-items-center" >

                                                <div class="ms-auto table-responsive">
                                                    <table  class="table table-hover no-wrap contact-list" data-paging="true">
                                                        <thead style="background-color: rgb(218, 222, 228)">
                                                            <th>تعهد بودیجه وی</th>
                                                            <th>بودیجه بعد از دیزاین</th>
                                                            <th>بودیجه قرار داد شده</th>
                                                        </thead>
                                                        <tbody>
                                                            </tr>
                                                                <td>{{ number_format($project->budgets()->first()->main_budget) }} افغانی</td>
                                                                <td>{{ number_format($project->budgets()->first()->budget_after_design) }} افغانی</td>
                                                                <td>{{ number_format($project->budgets()->first()->contract_budget) }} افغانی</td>
                                                            <tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="sparkline8" class="sparkchart"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="card">
                                        <div class="card-body  border border-light p-3" style="box-shadow: 3px 3px 3px #ccc;">
                                            <h4 class="card-title">بودیجه اختصاصی برای هر سال</h4>
                                            <div class="d-flex no-block align-items-center" >

                                                <div class="ms-auto table-responsive">
                                                        <table  class="table table-hover no-wrap contact-list" data-paging="true">
                                                            <thead style="background-color: rgb(218, 222, 228)">
                                                                <th>سال</th>
                                                                <th>فیصدی</th>
                                                                <th>مبلغ</th>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                    $total_this_year_budget            = 0;
                                                                    $total_this_year_budget_percentage = 0;
                                                                 ?>
                                                                @foreach ($project->budgets->year_budgets as $year_budget)
                                                                    @php
                                                                        $total_this_year_budget += $year_budget->this_year_budget;
                                                                        $total_this_year_budget_percentage += number_format(($year_budget->this_year_budget * 100) / $project->budgets()->first()->main_budget);
                                                                    @endphp
                                                                    </tr>
                                                                        <td>{{ jdate($year_budget->year )->format('Y') }}</td>

                                                                        <td>{{ number_format(($year_budget->this_year_budget * 100) / $project->budgets()->first()->main_budget) }} %</td>
                                                                        <td>{{ number_format($year_budget->this_year_budget) }} افغانی</td>
                                                                    <tr>

                                                                @endforeach
                                                                <tr style="background-color: rgb(218, 222, 228)">
                                                                    <td>مجموعه</td>
                                                                    <td>{{ $total_this_year_budget_percentage }} %</td>
                                                                    <td>{{ number_format($total_this_year_budget) }} افغانی</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        {{-- end start general information --}}

                        {{-- start report project tracking --}}

                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="accordion" id="accordionExample">
                                    <div class="accordion accordion-flush" id="accordionFlushExample">
                                        @foreach ($project->project_trackings as $key => $project_tracking)
                                        <?php
                                        $total_percentage = App\Models\Project\ReportProjectTracking::where('report_project_tracking.project_id', $project_tracking->project_id)
                                                                                         ->where('report_project_tracking.department_id', $project_tracking->department_id)
                                                                                         ->where('report_project_tracking.project_tracking_id', $project_tracking->id)
                                                                                         ->where('report_project_tracking.reject_activity', null)
                                                                                         ->join('department_activities', 'department_activities.id', '=', 'report_project_tracking.department_activity_id')
                                                                                         ->sum('department_activities.acitvity_percentage');
                                        ?>
                                            <div class="progress m-t-20">
                                                {{-- bg-success --}}
                                                <div class="progress-bar bg-success" style="width: {{$total_percentage}}%; height:15px;" role="progressbar">{{ $total_percentage }}%</div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="flush-headingOne{{ $key }}">
                                                    <button class="accordion-button collapsed col-12" type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#flush-collapseOne{{ $key }}" aria-expanded="false"
                                                        aria-controls="flush-collapseOne{{ $key }}">
                                                        {{ $project_tracking->project_departments->first()->name_da }}
                                                    </button>
                                                </h2>
                                                <div id="flush-collapseOne{{ $key }}" class="accordion-collapse collapse"
                                                    aria-labelledby="flush-headingOne{{ $key }}" data-bs-parent="#accordionFlushExample">
                                                    <div class="accordion-body">
                                                        <table  class="table no-wrap contact-list" data-paging="true">
                                                            <thead style="background-color: rgb(218, 222, 228)">
                                                                <th>#</th>
                                                                <th>اسم فعالیت</th>
                                                                <th>فیصدی فعالیت</th>
                                                                <th>روز های فعالیت</th>
                                                                <th>توضیحات</th>
                                                                <th>علت مستردی</th>
                                                                <th>تاریخ</th>
                                                            </thead>
                                                            <tbody>

                                                                @foreach ($project_tracking->project_tracking_details as $count => $project_tracking_detail)
                                                                    <tr style="{{ ($project_tracking_detail->reject_activity != null) ? 'background-color: rgb(226, 43, 83);color: white;':'' }}">
                                                                        {{-- <?php $acitvity_percentage += $project_tracking_detail->department_activities->first()->acitvity_percentage ?> --}}
                                                                        <td>{{ $count+1 }}</td>
                                                                        <td>{{ $project_tracking_detail->department_activities->first()->acitvity_name }}</td>
                                                                        <td>{{ $project_tracking_detail->department_activities->first()->acitvity_percentage }}%</td>
                                                                        <td>{{ ($project_tracking_detail->department_activities->first()->acitvity_deys == null)? "0":$project_tracking_detail->department_activities->first()->acitvity_deys  }}</td>
                                                                        <td>{{ $project_tracking_detail->description}}</td>
                                                                        <td>{{ ($project_tracking_detail->reject_comment_activity != null) ? $project_tracking_detail->reject_comment_activity:'' }}</td>
                                                                        <td>{{ jdate($project_tracking_detail->created_at)->format('l - d / m / Y')  }}</td>

                                                                    </tr>
                                                                @endforeach
                                                                @if ($project_tracking->reject_project_tracking_comment != null)
                                                                <tr class="btn-warning">
                                                                    <td>
                                                                        علت مستری این بخش
                                                                    </td>
                                                                    <td colspan="6">
                                                                        {{ $project_tracking->reject_project_tracking_comment }}
                                                                    </td>
                                                                </tr>
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        {{-- end report project tracking --}}
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('script')
@endsection
