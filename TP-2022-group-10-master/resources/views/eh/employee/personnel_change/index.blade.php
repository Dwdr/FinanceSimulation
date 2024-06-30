{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('eh/employee/personnel_change/index.title_html'))
@section('page_title', __('eh/employee/personnel_change/index.title_page'))

@section('body_page_breadcrumb')
    @unlessrole(config('constants.ROLE.USER'))
    <li class="breadcrumb-item active">{{ __('eh/employee/personnel_change/index.breadcrumb_level_1') }}</li>
    @endunlessrole
    @role(config('constants.ROLE.USER'))
    <li class="breadcrumb-item active">
        <a href="{{route('profile.index')}}">
            {{ __('eh/employee/personnel_change/detail.breadcrumb_level_2') }}
        </a>
    </li>
    @else
        <li class="breadcrumb-item active">
            <a href="{{route('eh.employee.index')}}">
                {{ __('eh/employee/personnel_change/detail.breadcrumb_level_2_admin') }}
            </a>
        </li>
    @endif
    <li class="breadcrumb-item active">{{ __('eh/employee/personnel_change/index.breadcrumb_level_3') }}</li>
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    @can(config("constants.PERMISSION.ACCOUNT-U"))
        @if(session('route_prefix')==config('constants.ROUTE-PREFIX.SELF-SERVICE-CENTER'))
            <div class="card">
                <div class="card-body">
                    @include('eh.employee.personnel_change.index.panel')
                </div>
            </div>
        @endif
    @endcan

    {{-- Table --}}
    <div class="card">
        <div class="card-body">
            <table id="dataTable" style="width: 100%;" class="table dataTable no-footer" role="grid" aria-describedby="datatable1_info"
                   data-turbolinks="false">
                <thead>
                <tr role="row">
                    <th>{{ __('eh/employee/personnel_change/index.th_date') }}</th>
                    @hasanyrole(config('constants.ROLE.ADMIN').'|'.config('constants.ROLE.SUPER_ADMIN'))
                    <th>{{ __('eh/employee/personnel_change/index.th_employee') }}</th>
                    @endhasanyrole
                    <th>{{ __('eh/employee/personnel_change/index.th_effective_date') }}</th>
                    <th>{{ __('eh/employee/personnel_change/index.th_status') }}</th>
                    {{--                    <th></th>--}}
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>{{ __('eh/employee/personnel_change/index.th_date') }}</th>
                    @hasanyrole(config('constants.ROLE.ADMIN').'|'.config('constants.ROLE.SUPER_ADMIN'))
                    <th>{{ __('eh/employee/personnel_change/index.th_employee') }}</th>
                    @endhasanyrole
                    <th>{{ __('eh/employee/personnel_change/index.th_effective_date') }}</th>
                    <th>{{ __('eh/employee/personnel_change/index.th_status') }}</th>
                    {{--                    <th></th>--}}
                </tr>
                </tfoot>
                <tbody>
                @foreach($ep as $e)
                    <tr>
                        <td>
                            <a href="{{ route('eh.personnel_change.show',$e->hash_id) }}">
                                {{ $e->created_at }}
                            </a>
                        </td>
                        @hasanyrole(config('constants.ROLE.ADMIN').'|'.config('constants.ROLE.SUPER_ADMIN'))
                        <td>
                            <a href="{{ route('eh.personnel_change.show',$e->hash_id) }}">
                                {{ $e->employee->first_name }} {{ $e->employee->last_name }}
                            </a>
                        </td>
                        @endhasanyrole
                        <td>
                            <a href="{{ route('eh.personnel_change.show',$e->hash_id) }}">
                                {{ $e->effective_date??'-' }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('eh.personnel_change.show',$e->hash_id) }}">
                                @switch($e->status)
                                    @case(config('constants.EMPLOYEE_LOG.STATUS.SUBMITTED'))
                                        <span class="badge bg-secondary">{{__('eh/employee/personnel_change/detail.lb_status_submitted')}}</span>
                                    @break
                                    @case(config('constants.EMPLOYEE_LOG.STATUS.APPROVED'))
                                    @case(config('constants.EMPLOYEE_LOG.STATUS.APPROVED_UPDATED'))
                                        <span class="badge bg-primary">{{__('eh/employee/personnel_change/detail.lb_status_approved')}}</span>
                                    @break
                                    @case(config('constants.EMPLOYEE_LOG.STATUS.DECLINED'))
                                        <span class="badge bg-danger">{{__('eh/employee/personnel_change/detail.lb_status_declined')}}</span>
                                    @break
                                    @case(config('constants.EMPLOYEE_LOG.STATUS.CANCELED'))
                                        <span class="badge bg-secondary">{{__('eh/employee/personnel_change/detail.lb_status_canceled')}}</span>
                                    @break
                                @endswitch
                            </a>
                        </td>
                        {{--                        <td>--}}
                        {{--                            @can(config("constants.PERMISSION.EH-EMPLOYEE-U"))--}}
                        {{--                                <a href="{{ route('eh.employee.personnel_change.edit',['uuid'=>$e->uuid,'movement_uuid'=>$m->uuid]) }}"><i class="fas fa-edit"></i></a>--}}
                        {{--                            @endcan--}}
                        {{--                        </td>--}}
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')
    @include('eh.employee.personnel_change.index.script_table')
@endpush
