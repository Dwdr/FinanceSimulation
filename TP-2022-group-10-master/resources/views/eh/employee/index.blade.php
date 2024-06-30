{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('eh/employee/index.title_html'))
@section('page_title', __('eh/employee/index.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('eh/employee/index.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active">{{ __('eh/employee/index.breadcrumb_level_2') }}</li>
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    @can(config("constants.PERMISSION.EH-EMPLOYEE-C"))
        <div class="card">
            <div class="card-body">
                @include('eh.employee.index.panel')
            </div>
        </div>
    @endcan

    {{-- Table --}}
    <div class="card">
        <div class="card-body">
            <table id="dataTable" style="width: 100%;" class="table dataTable no-footer" role="grid" aria-describedby="datatable1_info" data-turbolinks="false">
                <thead>
                <tr role="row">
                    <th>{{ __('eh/employee/index.th_employee_id') }}</th>
                    <th>{{ __('eh/employee/index.th_employee') }}</th>
                    <th>{{ __('eh/employee/index.th_department') }}</th>
                    <th>{{ __('eh/employee/index.th_designation') }}</th>
                    <th>{{ __('eh/employee/index.th_employee_type') }}</th>
                    <th>{{ __('eh/employee/index.th_type') }}</th>
                    <th>{{ __('eh/employee/index.th_active') }}</th>
                    <th></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>{{ __('eh/employee/index.th_employee_id') }}</th>
                    <th>{{ __('eh/employee/index.th_employee') }}</th>
                    <th>{{ __('eh/employee/index.th_department') }}</th>
                    <th>{{ __('eh/employee/index.th_designation') }}</th>
                    <th>{{ __('eh/employee/index.th_joining_date') }}</th>
                    <th>{{ __('eh/employee/index.th_type') }}</th>
                    <th>{{ __('eh/employee/index.th_active') }}</th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($employees as $e)
                    <tr>
                        <td>
                            <a href="{{ route('eh.employee.show',$e->uuid) }}">
                                {{ $e->employee_id }}
                            </a>
                        </td>
                        <td>
                            <div class="row">
                                @if(isset($e->avatar_file['file_path']))
                                    <img
                                        src="{{route('files',['s'=>$e->organization->name_slug,'p'=>$e->avatar_file['file_path'].$e->avatar_file['file_name'],'fn'=>$e->avatar_file['file_source_name'],'dl'=>false])}}"
                                        class="img-size-25 mr-1 img-circle" alt="user-avatar" loading="lazy"/>
                                @else
                                    <img src="{{asset('/images/user.jpg')}}" class="img-size-25 mr-1 img-circle" alt="user-avatar" loading="lazy"/>
                                @endif
                                <a href="{{ route('eh.employee.show',$e->uuid) }}" class="mt-auto">
                                    {{ $e->first_name }} {{ $e->last_name }}
                                </a>
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('eh.employee.show',$e->uuid) }}">
                                {{ $e->department->name??'-' }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('eh.employee.show',$e->uuid) }}">
                                {{ $e->designation->name??'-' }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('eh.employee.show',$e->uuid) }}">
                                {{ $e->employeeType->name??'-' }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('eh.employee.show',$e->uuid) }}">
                                @switch($e->type)
                                    @case(config('constants.EMPLOYEE.TYPE.TRIAL'))
                                    <span class="badge bg-warning">{{ __('eh/employee/detail.config_constants_EMPLOYEE_TYPE_TRIAL') }}</span>
                                    @break
                                    @case(config('constants.EMPLOYEE.TYPE.REGULAR'))
                                    <span class="badge bg-primary">{{ __('eh/employee/detail.config_constants_EMPLOYEE_TYPE_REGULAR') }}</span>
                                    @break
                                    @case(config('constants.EMPLOYEE.TYPE.RESIGNED'))
                                    <span class="badge bg-dark">{{ __('eh/employee/detail.config_constants_EMPLOYEE_TYPE_RESIGNED') }}</span>
                                    @break
                                    @default
                                    <span class="badge bg-secondary">{{ __('eh/employee/detail.config_constants_EMPLOYEE_TYPE_UNKNOWN') }}</span>
                                    @break
                                @endswitch
                            </a>
                        </td>
                        <td>
                            @switch($e->user->is_active)
                                @case(true)
                                <span class="badge  bg-success ">{{__('eh/employee/detail.lb_is_active_enable')}}</span>
                                @break
                                @case(false)
                                <span class="badge  bg-danger ">{{__('eh/employee/detail.lb_is_active_disable')}}</span>
                                @break
                            @endswitch
                        </td>
                        <td>
                            @can(config("constants.PERMISSION.EH-EMPLOYEE-U"))
                                <a href="{{ route('eh.employee.edit',$e->uuid) }}"><i class="fas fa-edit"></i></a>
                            @endcan
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('control_sidebar')
    @include('eh.employee.control_sidebar')
@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')
    @include('eh.employee.index.script_table')
@endpush
