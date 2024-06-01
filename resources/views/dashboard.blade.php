@extends('layouts.master')
@section('style')
    <link href="{{ asset('assets/node_modules/morrisjs/morris.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h2 class="text-themecolor">دشبورد</h2>
        </div>
        <div class="col-md-7 align-self-center text-end">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">دشبورد</a></li>
                    <li class="breadcrumb-item active">دشبورد</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row col-12">
        <style>
            h2,h3,h4,li {
                font-family: Calibri;
            }
            li{
                font-size: 20px;
            }
        </style>
        <div class="col-lg-12">
            <div class="row">
                <!-- column -->
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">کاربران</h3>
                            <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                <span class="display-5 text-info"><i class="icon-people"></i></span>
                                <a href="javscript:void(0)" class="link display-5 ms-auto">{{ $users }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- column -->
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">تمام پروژه ها</h3>
                            <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                <span class="display-5 text-purple"><i class="icon-folder"></i></span>
                                <a href="javscript:void(0)" class="link display-5 ms-auto">{{ $all_project }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- column -->
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">پروژه های درحال جریان</h3>
                            <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                <span class="display-5 text-primary"><i class="icon-note"></i></span>
                                <a href="javscript:void(0)" class="link display-5 ms-auto">{{ $in_progress_project }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- column -->
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">پروژه های تکمیل شده</h3>
                            <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                <span class="display-5 text-success"><i class="icon-wallet"></i></span>
                                <a href="javscript:void(0)" class="link display-5 ms-auto">{{ $completed_project }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- column -->
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">گراف پروژه</h3>
                    <div id="morris-bar-chart"></div>
                </div>
            </div>
        </div>

        {{-- @dd($project); --}}

    @endsection
    @section('script')
        <script src="{{ asset('assets/node_modules/raphael/raphael-min.js') }}"></script>
        <script src="{{ asset('assets/node_modules/morrisjs/morris.js') }}"></script>
        <script>
            $(function () {
                var data = @json($all_project);
    // Morris bar chart
        Morris.Bar({
            element: 'morris-bar-chart',
            data: [{
                y: '2006',
                a: 100,
                b: 90,
                c: 60
            },
           ],
            xkey: 'y',
            ykeys: ['a', 'b', 'c'],
            labels: ['A', 'B', 'C'],
            barColors:['#55ce63', '#2f3d4a', '#009efb'],
            hideHover: 'auto',
            gridLineColor: '#eef0f2',
            resize: true
        });
     });
        </script>
      

    @endsection
