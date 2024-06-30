{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_held_style')
@endsection

{{-- Title --}}
@section('html_title', __('eh/employee/log/detail.title_html'))
@section('page_title', __('eh/employee/log/detail.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('eh/employee/movement/detail.breadcrumb_level_1') }}</li>

    <li class="breadcrumb-item active">
        <a href="{{route('eh.employee.index')}}">
            {{ __('eh/employee/log/detail.breadcrumb_level_2') }}
        </a>
    </li>

    <li class="breadcrumb-item active">
            {{ __('eh/employee/log/detail.breadcrumb_level_3') }}
    </li>


    @if($mode['isModeShow'])
        <li class="breadcrumb-item active">{{ $log->created_at }}</li>
    @endif
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    {{-- Panel --}}
    @if($mode['isModeShow'])
        <div class="card">
            <div class="card-body">
                @include('eh.employee.log.detail.panel')
            </div>
        </div>
    @endif

    <div class="card">
        <div class="card-body">

            <div>
                <label>{{__('eh/employee/log/detail.lb_creator')}}</label>
                @if($log->creator->hasRole(config('constants.ROLE.SUPER_ADMIN')))
                    <p><strong class="text-primary">{{$log->creator->profile->name}}</strong></p>
                @else
                    <p>{{$log->creator->employee->first_name.' '.$log->creator->employee->last_name}}</p>
                @endif
            </div>

{{--            TODO link to config text--}}
            <x-inputs.text
                :label="__('eh/employee/log/detail.lb_type')"
                :isReadonly="$mode['isModeShow']"
                value="{{$log->type ?? ''}}"
                name="type"
            />

            <x-inputs.text
                :label="__('eh/employee/log/detail.lb_event')"
                :isReadonly="$mode['isModeShow']"
                value="{{$log->event ?? ''}}"
                name="event"
            />

            <x-inputs.text
                :label="__('eh/employee/log/detail.lb_source')"
                :isReadonly="$mode['isModeShow']"
                value="{{$log->source ?? ''}}"
                name="source"
            />

            <div class="form-group">
                <label class="form-control-label" for="id_old_data">{{__('eh/employee/log/detail.lb_old_data')}}</label>
                <pre class="bg-secondary rounded">{{ json_encode($log->original_data??[],JSON_PRETTY_PRINT) }}</pre>
            </div>

            <div class="form-group">
                <label class="form-control-label" for="id_new_data">{{__('eh/employee/log/detail.lb_new_data')}}</label>
                <pre class="bg-secondary rounded">{{ json_encode($log->updated_data??[],JSON_PRETTY_PRINT) }}</pre>
            </div>

            <x-inputs.text
                :label="__('eh/employee/log/detail.lb_description')"
                :isReadonly="$mode['isModeShow']"
                value="{{$log->description ?? ''}}"
                name="description"
            />

            {{-- Timestamp Panel --}}
            <x-inputs.timestamp :createdAt="$log->created_at"/>

        </div>


@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')

@endpush
