@extends('layouts.master')
@section('style')
<link href="{{ asset('assets/node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
{{-- <link href="{{ asset('assets/node_modules/bootstrap-select/bootstrap-select.min.css') }}" rel="stylesheet" /> --}}
{{-- <link href="{{ asset('assets/node_modules/multiselect/css/multi-select.css') }}" rel="stylesheet" type="text/css" /> --}}


@section('content')
<div class="row page-titles">
    <div class="col-md-12 align-self-center text-end">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb justify-content-end">
            <li class="breadcrumb-item"><a href="javascript:void(0)">ویرایش پروژه جدید</a></li>
            <li class="breadcrumb-item"><a href="{{ route('project.index') }}">پروژه ها</a></li>
                <li class="breadcrumb-item active">تنظیمات پروژه ها</li>
            </ol>
        </div>
    </div>
</div>
{{-- add project --}}
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <form action="{{ route('project.update', $project->id ) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="card-header bg-success">
                    <h4 class="m-b-0 text-white">ویرایش پروژه</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group row">
                                <label class="control-label col-md-2">انتخاب برنامه*</label>
                                <div class="col-md-8" data-select2-id="7">
                                    <select name="goal_id" class="select2 form-control form-select select2-hidden-accessible" style="width: 100%" data-select2-id="2" tabindex="-1" aria-hidden="true">
                                        <option value="0" data-select2-id="2">انتخاب</option>
                                        <!-- <optgroup label="Alaskan/Hawaiian Time Zone" data-select2-id="13"> -->
                                        @foreach($goals as $goal)
                                        <option value="{{ $goal->id }}" {{ ($project->goal_id == $goal->id) ? 'selected':'' }} >{{ $goal->name }}</option>
                                        @endforeach
                                        <!-- </optgroup>  -->
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group has-danger row">
                                <label class="control-label col-md-2">اسم پروژه*   </label>
                                <div class="col-md-9">
                                    <input value="{{ $project->name }}" type="text" name="name"
                                        class="@error('name') is-invalid @enderror form-control" placeholder="">
                                    @error('name')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group has-danger row">
                                <label class="control-label col-md-2">طول</label>
                                <div class="col-md-8">
                                    <input value="{{ $project->length }}" type="number" name="length_p"
                                        class="@error('length_p') is-invalid @enderror form-control" placeholder="">
                                    @error('length_p')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group has-danger row">
                                <label class="control-label col-md-2">عرض</label>
                                <div class="col-md-9">
                                    <input value="{{ $project->width }}" type="number" name="width"
                                        class="@error('width') is-invalid @enderror form-control" placeholder="">
                                    @error('width')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group has-danger row">
                                <label class="control-label col-md-2">تعداد</label>
                                <div class="col-md-8">
                                    <input value="{{ $project->number }}" type="number" name="number"
                                        class="@error('number') is-invalid @enderror form-control" placeholder="">
                                    @error('number')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group has-danger row">
                                <label class="control-label col-md-2">انتخاب واحد*</label>
                                <div class="col-md-9">
                                    <select name="unit_id" class="select2 form-control form-select select2-hidden-accessible" style="width: 100%" data-select2-id="1" tabindex="-1" aria-hidden="true">
                                        @foreach($units as $unit)
                                        <option value="{{ $unit->id }}" {{ ($project->unit_id == $unit->id) ? 'selected':'' }} >{{ $unit->unit_name_fa }}</option>
                                        @endforeach
                                        <!-- </optgroup>  -->
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group has-danger row">
                                <label class="control-label col-md-2">تطبیق کننده*</label>
                                <div class="col-md-8">
                                    <select name="impliment_department_id" class="select2 form-control form-select select2-hidden-accessible" style="width: 100%" data-select2-id="3" tabindex="-1" aria-hidden="true">
                                        @foreach($depratments as $department)
                                            @if ($department->type_of_department == 1)
                                                <option value="{{ $department->id }}" {{ ($project->impliment_department_id == $department->id) ? 'selected':'' }} >{{ $department->name_da }}</option>
                                            @endif
                                        @endforeach
                                        <!-- </optgroup>  -->
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group has-danger row">
                                <label class="control-label col-md-2">مدیریت کننده*</label>
                                <div class="col-md-9">
                                    <select name="management_department_id" class="select2 form-control form-select select2-hidden-accessible" style="width: 100%" data-select2-id="4" tabindex="-1" aria-hidden="true">
                                        @foreach($depratments as $depratment)
                                            @if ($depratment->type_of_department == 2)
                                                <option value="{{ $depratment->id }}" {{ ($project->management_department_id == $depratment->id) ? 'selected':'' }}>{{ $depratment->name_da }}</option>
                                            @endif
                                        @endforeach
                                        <!-- </optgroup>  -->
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group has-danger row">
                                <label class="control-label col-md-2">دیزاین کننده*</label>
                                <div class="col-md-8">
                                    <select name="design_department_id" class="select2 form-control form-select select2-hidden-accessible" style="width: 100%" data-select2-id="5" tabindex="-1" aria-hidden="true">
                                        @foreach($depratments as $depratment)
                                            @if ($depratment->type_of_department == 3)
                                                <option value="{{ $depratment->id }}" {{ ($project->design_department_id == $depratment->id) ? 'selected':'' }} >{{ $depratment->name_da }}</option>
                                            @endif
                                        @endforeach
                                        <!-- </optgroup>  -->
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group has-danger row">
                                <label class="control-label col-md-2">موقعیت(ناحیه)*</label>
                                <div class="col-md-9">
                                    <select name="district_id[]" class="select2 m-b-10 select2-multiple" style="width: 100%" multiple="multiple" data-placeholder="Choose">
                                            <!-- <optgroup label="Alaskan/Hawaiian Time Zone" data-select2-id="13"> -->
                                        @foreach($districts as $district)
                                            <option value="{{ $district->id }}" @foreach($project->districts as $project_district_id) {{ ($project_district_id->id == $district->id) ? 'selected':'' }} @endforeach>{{ $district->name }}</option>
                                        @endforeach
                                            <!-- </optgroup>  -->
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-header bg-success">
                            <h4 class="m-b-0 text-white">بخش بودیجه</h4>
                        </div>
                        <?php $budget =  $project->budgets->first() ?>
                            <div class=" card-body">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group has-danger row">
                                                <label class="control-label col-md-2">تعهد بودجوی* </label>
                                                <div class="col-md-9">
                                                    <input value="{{ ($budget != null) ? $budget->main_budget : '' }}" type="number" name="main_budget"
                                                        class="@error('main_budget') is-invalid @enderror form-control" placeholder="">
                                                    @error('main_budget')
                                                    <p class="invalid-feedback">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group has-danger row">
                                                <label class="control-label col-md-2">بودجه اختصاصی برای این سال*</label>
                                                <div class="col-md-9">
                                                    <input value="{{ ($budget != null) ? $budget->for_this_year : '' }}" type="number" name="for_this_year"
                                                        class="@error('for_this_year') is-invalid @enderror form-control" placeholder="">
                                                    @error('for_this_year')
                                                    <p class="invalid-feedback">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <div class="form-actions">
                                <div class="card-body">
                                    <button type="submit" class="btn btn-success text-white"> <i class="fa fa-check"></i>
                                        ویرایش</button>
                                </div>
                            </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- end add user --}}
@endsection
@section('script')
@section('script')
<script src="{{ asset('assets/node_modules/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
{{-- <script src="{{ asset('assets/node_modules/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script> --}}
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
    // $('#select-all').click(function () {
    //     $('#public-methods').multiSelect('select_all');
    //     return false;
    // });
    // $('#deselect-all').click(function () {
    //     $('#public-methods').multiSelect('deselect_all');
    //     return false;
    // });
    // $('#refresh').on('click', function () {
    //     $('#public-methods').multiSelect('refresh');
    //     return false;
    // });
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
