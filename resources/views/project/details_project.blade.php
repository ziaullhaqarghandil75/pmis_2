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
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item"> <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#home5" role="tab" aria-controls="home5" aria-expanded="true"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Home</span></a> </li>
                                    <li class="nav-item"> <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#profile5" role="tab" aria-controls="profile"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Profile</span></a></li>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="javascript:void(0)" role="button" aria-haspopup="true" aria-expanded="false">
                                            <span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">Dropdown</span>
                                        </a>
                                        <div class="dropdown-menu"> <a class="dropdown-item" id="dropdown1-tab" href="#dropdown1" role="tab" data-bs-toggle="tab" aria-controls="dropdown1">@fat</a> <a class="dropdown-item" id="dropdown2-tab" href="#dropdown2" role="tab" data-bs-toggle="tab" aria-controls="dropdown2">@mdo</a> </div>
                                    </li>
                                </ul>
                                <div class="tab-content tabcontent-border p-20" id="myTabContent">
                                    <div role="tabpanel" class="tab-pane fade show active" id="home5" aria-labelledby="home-tab">
                                    <div class="row">
                                            <div class="col-md-3 col-xs-6 b-r"> <strong>هدف اصلی پروژ</strong>
                                                <br>
                                                <p class="text-muted">Johnathan Deo</p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                  
</div>


@endsection
@section('script')

@endsection