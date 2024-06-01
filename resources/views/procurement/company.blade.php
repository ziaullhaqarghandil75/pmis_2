@extends('layouts.master')
@section('style')
<style>
    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-header button {
        order: 1;
    }
    #formContainer {
            display: none; /* فرم به صورت پیش فرض مخفی است */
    }
</style>
@endsection
@section('content')
<div class="row page-titles">
    <div class="col-md-12 align-self-center text-end">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb justify-content-end">
                <li class="breadcrumb-item"><a href="javascript:void(0)">شرکت های خصوصی</a></li>
                <li class="breadcrumb-item active">تنظیمات تدارکات</li>
            </ol>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-lg-12">
        <div class="card">
            {{-- add company  --}}
            @if($edit_company == false)
                @can('add_company')
                    <form action="{{ route('companies.store') }}" method="POST" enctype="multipart/form-data" id="formContainer">
                        @csrf
                        <div class="card-header bg-info">
                            <h4 class="m-b-0 text-white">افزودن شرکت جدید</h4>
                            <button type="submit" class="btn btn-success text-white"> <i class="fa fa-check"></i>
                                        ذخیره معلومات</button>

                        </div>
                        <div class="card-body" >
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label col-md-2">نام شرکت *</label>
                                        <div class="col-md-8">
                                            <input type="text" value="{{ old('company_name') }}" name="company_name" class="@error('company_name') is-invalid @enderror form-control" placeholder="">
                                            @error('company_name')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label col-md-2">نام نماینده شرکت *</label>
                                        <div class="col-md-8">
                                            <input type="text" value="{{ old('agent_name') }}" name="agent_name" class="@error('agent_name') is-invalid @enderror form-control" placeholder="">
                                            @error('agent_name')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label col-md-2">شماره تماس *</label>
                                        <div class="col-md-8">
                                            <input type="text" value="{{ old('phone') }}" name="phone" class="@error('phone') is-invalid @enderror form-control" placeholder="">
                                            @error('phone')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label col-md-2">ایمیل *</label>
                                        <div class="col-md-8">
                                            <input type="email" value="{{ old('email') }}" name="email" class="@error('email') is-invalid @enderror form-control" placeholder="">
                                            @error('email')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label col-md-2">نمبر جواز *</label>
                                        <div class="col-md-8">
                                            <input type="text" value="{{ old('licence_number') }}" name="licence_number" class="@error('licence_number') is-invalid @enderror form-control" placeholder="">
                                            @error('licence_number')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label col-md-2">فایل *</label>
                                        <div class="col-md-8">
                                            <input type="file" value="{{ old('file') }}" name="file" class="@error('file') is-invalid @enderror form-control" placeholder="">
                                            @error('file')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                @endcan
            @else
                @can('edit_company')
                    <form action="{{ route('companies.update', $edit_company->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="card-header bg-success">
                            <h4 class="m-b-0 text-white">تصحیح معلومات شرکت</h4>
                            <button type="submit" class="btn btn-info text-white"> <i class="fa fa-check"></i>
                                تحصیح معلومات</button>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label col-md-2">نام شرکت </label>
                                        <div class="col-md-8">
                                            <input type="text" value="{{ $edit_company->company_name }}" name="company_name" class="@error('company_name') is-invalid @enderror form-control" placeholder="">
                                            @error('company_name')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label col-md-2">نام نماینده شرکت </label>
                                        <div class="col-md-8">
                                            <input type="text" value="{{ $edit_company->agent_name }}" name="agent_name" class="@error('agent_name') is-invalid @enderror form-control" placeholder="">
                                            @error('agent_name')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label col-md-2">شماره تماس </label>
                                        <div class="col-md-8">
                                            <input type="text" value="{{ $edit_company->phone }}" name="phone" class="@error('phone') is-invalid @enderror form-control" placeholder="">
                                            @error('phone')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label col-md-2">ایمیل </label>
                                        <div class="col-md-8">
                                            <input type="email" value="{{ $edit_company->email }}" name="email" class="@error('email') is-invalid @enderror form-control" placeholder="">
                                            @error('email')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label col-md-2">نمبر جواز *</label>
                                        <div class="col-md-8">
                                            <input type="text" value="{{ $edit_company->licence_number }}" name="licence_number" class="@error('licence_number') is-invalid @enderror form-control" placeholder="">
                                            @error('licence_number')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label col-md-2">فایل *</label>
                                        <div class="col-md-8">
                                            <input type="file" name="file" class="@error('file') is-invalid @enderror form-control" placeholder="">
                                            @error('file')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                @endcan
            @endif
           {{-- end add company --}}
           {{-- list company --}}
           <div class="card-header bg-info">
               <h4 class="m-b-0 text-white">لیست شرکت ها</h4>
               <button id="toggleButton" type="submit" class="btn btn-success text-white"> <i class=" fas fa-address-card"></i>افزودن شرکت جدید</button>
           </div>
            <div class="card-body">
                    <div class="table-responsive">
                        <table id="config-table" class="table display table-striped border no-wrap">
                            <thead>
                                <tr>
                                    <th>اسم شرکت</th>
                                    <th>نماینده</th>
                                    <th>شماره تماس</th>
                                    <th>ایمیل</th>
                                    <th>نمبر جواز</th>
                                    <th>دانلود فایل</th>
                                    {{-- <th>تصویر</th> --}}
                                    {{-- <th>حالت</th> --}}
                                    @can('edit_company')
                                        <th>تصحیح</th>
                                    @endcan
                                    @can('delete_company')
                                        <th>حذف</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($companies as $company)
                                <tr>
                                    <td>{{ $company->company_name }}</td>
                                    <td>{{ $company->agent_name }}</td>
                                    <td>{{ $company->phone }}</td>
                                    <td>{{ $company->email }}</td>
                                    <td>{{ $company->licence_number }}</td>
                                    <td><a href="{{ asset($company->file) }}" class="btn btn-info text-white m-1"><i class="fas fa-download"></i>
                                        دانلود فایل ها</a></td>

                                    @can('edit_company')
                                    <td>
                                        <a href="{{ route('companies.edit',$company->id) }}" type="submit" class="btn btn-success text-white">تصحیح <i class="fas fa-edit"></i> </a>
                                    </td>
                                    @endcan
                                    @can('delete_company')
                                    <td>
                                        <form action="{{ route('companies.destroy',$company->id) }}" method="POST" class="d-inline">
                                            @method('delete')
                                            @csrf
                                            <button type="submit"   class="btn waves-effect waves-light btn-danger text-white delete-button">حذف <i class="fas fa-trash-alt"></i> </button>
                                        </form>
                                    </td>
                                    @endcan
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                </div>
            </div>
            {{-- end list unit --}}
        </div>
    </div>
</div>
@endsection
@section('script')
{{-- <script src="{{ asset('assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset ('assets/node_modules/sweetalert2/sweet-alert.init.js')}}"></script> --}}

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
    document.getElementById('toggleButton').addEventListener('click', function() {
        var formContainer = document.getElementById('formContainer');
        if (formContainer.style.display === 'none' || formContainer.style.display === '') {
            formContainer.style.display = 'block';
            toggleButton.textContent = 'صرف نظر';
        } else {
            formContainer.style.display = 'none';
            toggleButton.textContent = 'افزودن شرکت جدید';
        }
    });
</script>

@endsection
