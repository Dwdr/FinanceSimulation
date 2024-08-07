{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('eh/leave_application/index.title_html'))
@section('page_title', __('eh/leave_application/index.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('eh/leave_application/index.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active">{{ __('eh/leave_application/index.breadcrumb_level_2') }}</li>
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    @can(config("constants.PERMISSION.EH-LEAVE-APPLICATION-C"))
        <div class="card">
            <div class="card-body">
                @include('eh.leave_application.index.panel')
            </div>
        </div>
    @endcan

    {{-- Table --}}
    <div class="card">
        <div class="card-body">
            <table id="dataTable" style="width: 100%;" class="table dataTable no-footer" role="grid" aria-describedby="datatable1_info" data-turbolinks="false">
                <thead>
                <tr role="row">
                    <th>{{ __('eh/leave_application/index.th_date') }}</th>
                    <th>{{ __('eh/leave_application/index.th_applicant') }}</th>
                    <th>{{ __('eh/leave_application/index.th_leave_type') }}</th>
                    <th>{{ __('eh/leave_application/index.th_start_at') }}</th>
                    <th>{{ __('eh/leave_application/index.th_end_at') }}</th>
{{--                    <th>{{ __('eh/leave_application/index.th_duration') }}</th>--}}
                    <th>{{ __('eh/leave_application/index.th_status') }}</th>
                    <th></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>{{ __('eh/leave_application/index.th_date') }}</th>
                    <th>{{ __('eh/leave_application/index.th_applicant') }}</th>
                    <th>{{ __('eh/leave_application/index.th_leave_type') }}</th>
                    <th>{{ __('eh/leave_application/index.th_start_at') }}</th>
                    <th>{{ __('eh/leave_application/index.th_end_at') }}</th>
{{--                    <th>{{ __('eh/leave_application/index.th_duration') }}</th>--}}
                    <th>{{ __('eh/leave_application/index.th_status') }}</th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($leave_applications as $la)
                    <tr>
                        <td>
                            <a href="{{ route('eh.leave_application.show',$la->uuid) }}">
                                {{ $la->created_at }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('eh.leave_application.show',$la->uuid) }}">
                                {{ $la->employee->first_name }} {{ $la->employee->last_name }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('eh.leave_application.show',$la->uuid) }}">
                                {{ $la->leaveType->name??'-' }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('eh.leave_application.show',$la->uuid) }}">
                                {{ $la->period_start??'-' }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('eh.leave_application.show',$la->uuid) }}">
                                {{ $la->period_end??'-' }}
                            </a>
                        </td>
{{--                        <td>--}}
{{--                            <a href="{{ route('eh.leave_application.show',$la->uuid) }}">--}}
{{--                                {{ $la->duration['day']??'-' }}--}}
{{--                                天--}}
{{--                                {{ $la->duration['hour']??'-' }} --}}
{{--                                小時--}}
{{--                            </a>--}}
{{--                        </td>--}}
                        <td>
                            <a href="{{ route('eh.leave_application.show',$la->uuid) }}">
                                @switch($la->status)
                                    @case(config('constants.LEAVE_APPLICATION.STATUS.PENDING'))
                                    <span class="badge bg-secondary">{{ __('eh/leave_application/detail.config_constants_LEAVE_APPLICATION_STATUS_PENDING') }}</span>
                                    @break
                                    @case(config('constants.LEAVE_APPLICATION.STATUS.APPROVE'))
                                    <span class="badge bg-success">{{ __('eh/leave_application/detail.config_constants_LEAVE_APPLICATION_STATUS_APPROVE') }}</span>
                                    @break
                                    @case(config('constants.LEAVE_APPLICATION.STATUS.REFUSE'))
                                    <span class="badge bg-dark">{{ __('eh/leave_application/detail.config_constants_LEAVE_APPLICATION_STATUS_REFUSE') }}</span>
                                    @break
                                    @case(config('constants.LEAVE_APPLICATION.STATUS.WAIT_ADMIN'))
                                    <span class="badge bg-warning">{{ __('eh/leave_application/detail.config_constants_LEAVE_APPLICATION_STATUS_WAIT_ADMIN') }}</span>
                                    @break
                                    @default
                                    -
                                    @break
                                @endswitch
                            </a>
                        </td>
                        <td>
                            @can(config("constants.PERMISSION.EH-LEAVE-APPLICATION-U"))
                                <a href="{{ route('eh.leave_application.edit',$la->uuid) }}"><i class="fas fa-edit"></i></a>
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
    @include('eh.leave_application.index.script_table')
@endpush
