{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('eh/configurations/index.title_html'))
@section('page_title', __('eh/configurations/index.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('eh/configurations/index.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active">{{ __('eh/configurations/index.breadcrumb_level_2') }}</li>
@endsection

{{-- Body Main Content --}}
@section('body_main_content')
    <div>
        @include('layouts.adminlte_3.components.alert')
        <h5 class="mb-2">Employee</h5>
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header text-center">
                        {{ __('eh/configurations/index.lb_designation') }}
                    </div>
                    <div class="card-body text-center">
                        <a class="btn bg-olive w-50" href="{{route('eh.configurations.designation.index')}}">
                            {{ __('eh/configurations/index.btn_config') }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <div class="card-header text-center">
                        {{ __('eh/configurations/index.lb_gender') }}
                    </div>
                    <div class="card-body text-center">
                        <a class="btn bg-olive w-50" href="{{route('eh.configurations.gender.index')}}">
                            {{ __('eh/configurations/index.btn_config') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header text-center">
                        {{ __('eh/configurations/index.lb_grade') }}
                    </div>
                    <div class="card-body text-center">
                        <a class="btn bg-olive w-50" href="{{route('eh.configurations.grade.index')}}">
                            {{ __('eh/configurations/index.btn_config') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header text-center">
                        {{ __('eh/configurations/index.lb_highest_education') }}
                    </div>
                    <div class="card-body text-center">
                        <a class="btn bg-olive w-50" href="{{route('eh.configurations.highest_education.index')}}">
                            {{ __('eh/configurations/index.btn_config') }}
                        </a>
                    </div>
                </div>
            </div>





            <div class="col-md-3">
                <div class="card">
                    <div class="card-header text-center">
                        {{ __('eh/configurations/index.lb_martial_status') }}
                    </div>
                    <div class="card-body text-center">
                        <a class="btn bg-olive w-50" href="{{route('eh.configurations.martial_status.index')}}">
                            {{ __('eh/configurations/index.btn_config') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header text-center">
                        {{ __('eh/configurations/index.lb_nationality') }}
                    </div>
                    <div class="card-body text-center">
                        <a class="btn bg-olive w-50" href="{{route('eh.configurations.nationality.index')}}">
                            {{ __('eh/configurations/index.btn_config') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header text-center">
                        {{ __('eh/configurations/index.lb_relationship') }}
                    </div>
                    <div class="card-body text-center">
                        <a class="btn bg-olive w-50" href="{{route('eh.configurations.relationship.index')}}">
                            {{ __('eh/configurations/index.btn_config') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header text-center">
                        {{ __('eh/configurations/index.lb_title') }}
                    </div>
                    <div class="card-body text-center">
                        <a class="btn bg-olive w-50" href="{{route('eh.configurations.title.index')}}">
                            {{ __('eh/configurations/index.btn_config') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>


        <h5 class="mb-2">Finance</h5>
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header text-center">
                        {{ __('eh/configurations/index.lb_bank') }}
                    </div>
                    <div class="card-body text-center">
                        <a class="btn bg-olive w-50" href="{{route('eh.configurations.bank.index')}}">
                            {{ __('eh/configurations/index.btn_config') }}
                        </a>
                    </div>
                </div>
            </div>





        </div>
        <h5 class="mb-2">Company</h5>
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header text-center">
                        {{ __('eh/configurations/index.lb_exit_type') }}
                    </div>
                    <div class="card-body text-center">
                        <a class="btn bg-olive w-50" href="{{route('eh.configurations.exit_type.index')}}">
                            {{ __('eh/configurations/index.btn_config') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header text-center">
                        {{ __('eh/configurations/index.lb_employee_type') }}
                    </div>
                    <div class="card-body text-center">
                        <a class="btn bg-olive w-50" href="{{route('eh.configurations.employee_type.index')}}">
                            {{ __('eh/configurations/index.btn_config') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header text-center">
                        {{ __('eh/configurations/index.lb_department') }}
                    </div>
                    <div class="card-body text-center">
                        <a class="btn bg-olive w-50" href="{{route('eh.configurations.department.index')}}">
                            {{ __('eh/configurations/index.btn_config') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header text-center">
                        {{ __('eh/configurations/index.lb_work_schedule') }}
                    </div>
                    <div class="card-body text-center">
                        <a class="btn bg-olive w-50" href="{{route('eh.configurations.work_schedule.index')}}">
                            {{ __('eh/configurations/index.btn_config') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <h5 class="mb-2">Leave & Holiday</h5>
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header text-center">
                        {{ __('eh/configurations/index.lb_holiday') }}
                    </div>
                    <div class="card-body text-center">
                        <a class="btn bg-olive w-50" href="{{route('eh.configurations.holiday.index')}}">
                            {{ __('eh/configurations/index.btn_config') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header text-center">
                        {{ __('eh/configurations/index.lb_holiday_type') }}
                    </div>
                    <div class="card-body text-center">
                        <a class="btn bg-olive w-50" href="{{route('eh.configurations.holiday-type.index')}}">
                            {{ __('eh/configurations/index.btn_config') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header text-center">
                        {{ __('eh/configurations/index.lb_leave_type') }}
                    </div>
                    <div class="card-body text-center">
                        <a class="btn bg-olive w-50" href="{{route('eh.configurations.leave_type.index')}}">
                            {{ __('eh/configurations/index.btn_config') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <h5 class="mb-2">Clock In/Out</h5>
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header text-center">
                        {{ __('eh/configurations/index.lb_site') }}
                    </div>
                    <div class="card-body text-center">
                        <a class="btn bg-olive w-50" href="{{route('eh.configurations.site.index')}}">
                            {{ __('eh/configurations/index.btn_config') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')

@endpush
