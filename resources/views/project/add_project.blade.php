@extends('layouts.master')
@section('style')
    <link href="../assets/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/node_modules/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
    <link href="../assets/node_modules/multiselect/css/multi-select.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="row page-titles">
    <div class="col-md-12 align-self-center text-end">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb justify-content-end">
            <li class="breadcrumb-item"><a href="javascript:void(0)">افزودن پروژه جدید</a></li>
            <li class="breadcrumb-item"><a href="{{ route('user.index') }}">پروژه ها</a></li>
                <li class="breadcrumb-item active">تنظیمات پروژه ها</li>
            </ol>
        </div>
    </div>
</div>
{{-- add project --}}
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <form action="{{ route('project.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-header bg-info">
                    <h4 class="m-b-0 text-white">افزودن پروژه جدید</h4>
                </div>
                <div class="card-body">
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group row">
                            <label class="control-label text-end col-md-2">انتخاب هدف*</label>
                            <div class="col-md-8" data-select2-id="7">
                                <select name="" class="select2 form-control form-select select2-hidden-accessible" style="width: 100%" data-select2-id="1" tabindex="-1" aria-hidden="true">
                                    <option data-select2-id="3">انتخاب</option>
                                    <!-- <optgroup label="Alaskan/Hawaiian Time Zone" data-select2-id="13"> -->
                                    @foreach($goles as $gole)   
                                    <option value="{{ $gole->id }}">{{ $gole->name }}</option>
                                    @endforeach
                                    <!-- </optgroup>  -->
                                </select>                                  
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group has-danger row">
                            <label class="control-label text-end col-md-2">اسم پروژه</label>
                            <div class="col-md-8">
                                <input type="text" name="name"
                                    class="@error('name') is-invalid @enderror form-control" placeholder="">
                                @error('name')
                                <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group has-danger row">
                            <label class="control-label text-end col-md-2">شماره تماس</label>
                            <div class="col-md-8">
                                <input type="text" name="phone"
                                    class="@error('phone') is-invalid @enderror form-control" placeholder="">
                                @error('phone')
                                <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group has-danger row">
                            <label class="control-label text-end col-md-3">ایمل*</label>
                            <div class="col-md-8">
                                <input type="email" name="email"
                                    class="@error('email') is-invalid @enderror form-control" placeholder="">
                                @error('email')
                                <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group has-danger row">
                            <label class="control-label text-end col-md-3">پسورد*</label>
                            <div class="col-md-8">
                                <input type="password" name="password"
                                    class="@error('password') is-invalid @enderror form-control" placeholder="">
                                @error('password')
                                <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group has-danger row">
                            <label class="control-label text-end col-md-3">تصویر</label>
                            <div class="col-md-8">
                                <input type="file" name="img"
                                    class="@error('img') is-invalid @enderror form-control" placeholder="">
                                @error('img')
                                <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group has-danger row">
                            <label class="control-label text-end col-md-3">دیپارتمنت*</label>
                            <div class="col-md-8">
                                <select name="department_id" class="form-control form-select">
                                    <option>--انتخاب دیپارتمنت--</option>
                                    @foreach ($departments as $department )
                                    <option value="{{ $department->id }}">
                                        {{ $department->name_da }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('department_id')
                                <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group has-danger row">
                            <label class="control-label text-end col-md-3">سطح دسترسی (role)*</label>
                            <div class="col-md-8">
                                <select name="role_id" class="form-control form-select">
                                    <option>--انتخاب سطح دسترسی (role)--</option>
                                    @foreach ($units as $unit )
                                    <option value="{{ $unit->id }}">
                                        {{ $unit->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('department_id')
                                <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group row">
                            <label class="control-label text-end col-md-3">حالت</label>
                            <div class="col-md-8">
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="status" value="1" id="customRadio3"
                                        class="form-check-input" checked>
                                    <label class="form-check-label" for="customRadio3">فعال</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="status" value="0" id="customRadio4"
                                        class="form-check-input">
                                    <label class="form-check-label" for="customRadio4">غیر فعال</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="card-body">
                            <button type="submit" class="btn btn-success text-white"> <i class="fa fa-check"></i>
                                ذخیره</button>
                            <button type="reset" class="btn btn-dark">لفوه</button>
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
    <!--  <script src="../assets/node_modules/switchery/dist/switchery.min.js"></script> -->
    <script src="../assets/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
    <!-- <script src="../assets/node_modules/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script> -->
    <!-- <script src="../assets/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script> -->
    <!-- <script src="../assets/node_modules/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js" type="text/javascript"></script> -->
    <!-- <script src="../assets/node_modules/dff/dff.js" type="text/javascript"></script> -->
    <!-- <script type="text/javascript" src="../assets/node_modules/multiselect/js/jquery.multi-select.js"></script> -->
    <!-- <script src="../assets/node_modules/switchery/dist/switchery.min.js"></script> -->
    <script src="../assets/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
    <!-- <script src="../assets/node_modules/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script> -->
    <!-- <script src="../assets/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script> -->
    <!-- <script src="../assets/node_modules/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js" type="text/javascript"></script> -->
    <!-- <script src="../assets/node_modules/dff/dff.js" type="text/javascript"></script> -->
    <!-- <script type="text/javascript" src="../assets/node_modules/multiselect/js/jquery.multi-select.js"></script> --> -->
  
  <script>
        $(function () {
          
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
            $('#select-all').click(function () {
                $('#public-methods').multiSelect('select_all');
                return false;
            });
            $('#deselect-all').click(function () {
                $('#public-methods').multiSelect('deselect_all');
                return false;
            });
            $('#refresh').on('click', function () {
                $('#public-methods').multiSelect('refresh');
                return false;
            });
            $('#add-option').on('click', function () {
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
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            page: params.page
                        };
                    },
                    processResults: function (data, params) {
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
                escapeMarkup: function (markup) {
                    return markup;
                }, // let our custom formatter work
                minimumInputLength: 1,
                //templateResult: formatRepo, // omitted for brevity, see the source of this page
                //templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
            });
        });
    </script>

@endsection