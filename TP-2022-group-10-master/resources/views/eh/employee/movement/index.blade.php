{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('eh/employee/movement/index.title_html'))
@section('page_title', __('eh/employee/movement/index.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('eh/employee/movement/index.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active">
        <a href="{{route('eh.employee.index')}}">
            {{ __('eh/employee/movement/index.breadcrumb_level_2') }}
        </a>
    </li>
    <li class="breadcrumb-item active">
        <a href="{{route('eh.employee.show',$e->uuid)}}">
            {{$e->employee_id}}
        </a>
    </li>
    <li class="breadcrumb-item active">{{ __('eh/employee/movement/index.breadcrumb_level_3') }}</li>
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    @can(config("constants.PERMISSION.EH-EMPLOYEE-MOVEMENT-C"))
        @if($e->type != config('constants.EMPLOYEE.TYPE.RESIGNED')||!isset($e->termination->hash_id))
            <div class="card">
                <div class="card-body">
                    @include('eh.employee.movement.index.panel')
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
                    <th>{{ __('eh/employee/movement/index.th_date') }}</th>
                    <th>{{ __('eh/employee/movement/index.th_employee') }}</th>
                    <th>{{ __('eh/employee/movement/index.th_effective_date') }}</th>
                    <th>{{ __('eh/employee/movement/index.th_status') }}</th>
                    {{--                    <th></th>--}}
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>{{ __('eh/employee/movement/index.th_date') }}</th>
                    <th>{{ __('eh/employee/movement/index.th_employee') }}</th>
                    <th>{{ __('eh/employee/movement/index.th_effective_date') }}</th>
                    <th>{{ __('eh/employee/movement/index.th_status') }}</th>
                    {{--                    <th></th>--}}
                </tr>
                </tfoot>
                <tbody>
                @foreach($e->employeeMovement as $m)
                    <tr>
                        <td>
                            <a href="{{ route('eh.employee.movement.show',['uuid'=>$e->uuid,'hash_id'=>$m->hash_id]) }}">
                                {{ $m->created_at }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('eh.employee.movement.show',['uuid'=>$e->uuid,'hash_id'=>$m->hash_id]) }}">
                                {{ $m->employee->first_name }} {{ $m->employee->last_name }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('eh.employee.movement.show',['uuid'=>$e->uuid,'hash_id'=>$m->hash_id]) }}">
                                {{ $m->effective_date??'-' }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('eh.employee.movement.show',['uuid'=>$e->uuid,'hash_id'=>$m->hash_id]) }}">
                                @switch($m->status)
                                    @case(config('constants.EMPLOYEE_LOG.STATUS.PENDING'))
                                    <span class="badge bg-secondary">{{__('eh/employee/movement/detail.lb_status_pending')}}</span>
                                    @break
                                    @case(config('constants.EMPLOYEE_LOG.STATUS.APPROVED'))
                                    <span class="badge bg-success">{{__('eh/employee/movement/detail.lb_status_approved')}}</span>
                                    @break
                                @endswitch
                            </a>
                        </td>
                        {{--                        <td>--}}
                        {{--                            @can(config("constants.PERMISSION.EH-EMPLOYEE-U"))--}}
                        {{--                                <a href="{{ route('eh.employee.movement.edit',['uuid'=>$e->uuid,'movement_uuid'=>$m->uuid]) }}"><i class="fas fa-edit"></i></a>--}}
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
    @include('eh.employee.movement.index.script_table')
@endpush
