{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('eh/report/index.title_html'))
@section('page_title', __('eh/report/index.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('eh/report/index.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active">{{ __('eh/report/index.breadcrumb_level_2') }}</li>
@endsection

{{-- Body Main Content --}}
@section('body_main_content')
    <div class="row">
        <!-- /.col-md-6 -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header border-0">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title">{{ __('eh/report/index.lb_chart_employee') }}</h3>
                        <a href="javascript:void(0);">{{ __('eh/report/index.lb_chart_view_report') }}</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex">
                        <p class="d-flex flex-column">
                            <span class="text-bold text-lg">{{$current_employee}}</span>
                            <span>{{ __('eh/report/index.lb_chart_current_employee') }}</span>
                        </p>
                        <p class="ml-auto d-flex flex-column text-right">
                    <span class="text-success">
                      <i class="fas fa-arrow-up"></i> 33.1%
                    </span>
                            <span class="text-muted">{{ __('eh/report/index.lb_chart_since_last_month') }}</span>
                        </p>
                    </div>
                    <!-- /.d-flex -->

                    <div class="position-relative mb-4">
                        <canvas id="employee-chart" height="200"></canvas>
                    </div>

                    <div class="d-flex flex-row justify-content-end">
                  <span class="mr-2">
                    <i class="fas fa-square text-primary"></i> {{ __('eh/report/index.lb_chart_new_employee') }}
                  </span>

                        <span>
                    <i class="fas fa-square text-gray"></i> {{ __('eh/report/index.lb_chart_exit_employee') }}
                  </span>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>

        <div class="col-lg-6">
            <!-- Donut chart -->
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">
                        <i class="far fa-chart-bar"></i>
                        {{ __('eh/report/index.lb_chart_employee_gender') }}
                    </h3>

                </div>
                <div class="card-body">
                    <div id="employee-gender-chart" style="height: 320px;"></div>
                </div>
                <!-- /.card-body-->
            </div>
        </div>

        <div class="col-lg-6">
            <!-- Donut chart -->
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">
                        <i class="far fa-chart-bar"></i>
                        {{ __('eh/report/index.lb_chart_exit_employee_gender') }}
                    </h3>

                </div>
                <div class="card-body">
                    <div id="exit-employee-gender-chart" style="height: 320px;"></div>
                </div>
                <!-- /.card-body-->
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">{{ __('eh/report/index.lb_chart_employee_age_range') }}</h3>

                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="ageRangeChart" style="min-height: 320px; height: 320px; max-height: 320px; max-width: 100%;"></canvas>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
@endsection

@section('control_sidebar')
    @include('eh.report.control_sidebar')
@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')
    @include('eh.report.scripts')
    @include('eh.report.chart')
@endpush
