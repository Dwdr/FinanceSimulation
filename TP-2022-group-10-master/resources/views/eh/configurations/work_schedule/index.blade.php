{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('eh/configurations/work_schedule/index.title_html'))
@section('page_title', __('eh/configurations/work_schedule/index.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('eh/configurations/work_schedule/index.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active">{{ __('eh/configurations/work_schedule/index.breadcrumb_level_2') }}</li>
    <li class="breadcrumb-item active">{{ __('eh/configurations/work_schedule/index.breadcrumb_level_3') }}</li>
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    @can(config("constants.PERMISSION.EH-SETTINGS-WORK-SCHEDULE-C"))
        <div class="card">
            <div class="card-body">
                @include('eh.configurations.work_schedule.index_panel')
            </div>
        </div>
    @endcan

    {{-- Table --}}
    <div class="card">
        <div class="card-body">
            <table id="dataTable" style="width: 100%;" class="table dataTable no-footer" role="grid" aria-describedby="datatable1_info"
                   data-turbolinks="false">
                <thead>
                <tr role="row">
                    <th>{{ __('eh/configurations/work_schedule/index.th_employee_type') }}</th>
                    <th>{{ __('eh/configurations/work_schedule/index.th_working_day') }}</th>
                    <th>{{ __('eh/configurations/work_schedule/index.th_from_date') }}</th>
                    <th>{{ __('eh/configurations/work_schedule/index.th_to_date') }}</th>
                    <th></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>{{ __('eh/configurations/work_schedule/index.th_employee_type') }}</th>
                    <th>{{ __('eh/configurations/work_schedule/index.th_working_day') }}</th>
                    <th>{{ __('eh/configurations/work_schedule/index.th_from_date') }}</th>
                    <th>{{ __('eh/configurations/work_schedule/index.th_to_date') }}</th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($work_schedules as $ws)
                    <tr>
                        <td>
                            <a href="{{ route('eh.configurations.work_schedule.show',$ws->id) }}">
                                {{ $ws->employeeType->name??'-' }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('eh.configurations.work_schedule.show',$ws->id) }}">
                                @foreach($ws->working_day as $wd)
                                    <span
                                        class="badge bg-secondary">{{trans('eh/configurations/work_schedule/detail.checkbox_option_'.strtolower(array_keys(config('constants.WORK_SCHEDULE.WORKING_DAY'))[$wd-1]))}}</span>
                                @endforeach
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('eh.configurations.work_schedule.show',$ws->id) }}">
                                {{ $ws->from_date }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('eh.configurations.work_schedule.show',$ws->id) }}">
                                @if($ws->to_date_type == config('constants.WORK_SCHEDULE.TO_DATE.NEVER'))
                                    {{__('eh/configurations/work_schedule/detail.radio_option_never')}}
                                @else
                                    {{ $ws->to_date }}
                                @endif
                            </a>
                        </td>
                        <td>
                            @can(config("constants.PERMISSION.EH-SETTINGS-TITLE-U"))
                                <a href="{{ route('eh.configurations.work_schedule.edit',$ws->id) }}"><i class="fas fa-edit"></i></a>
                            @endcan
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')
    @include('eh.configurations.work_schedule.index_script_table')
@endpush
