{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('eh/configurations/employee_type/detail.title_html'))
@section('page_title', __('eh/configurations/employee_type/detail.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('eh/configurations/employee_type/detail.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active">{{ __('eh/configurations/employee_type/detail.breadcrumb_level_2') }}</li>
    <li class="breadcrumb-item"><a href="{{ route('eh.configurations.employee_type.index') }}">{{ __('eh/configurations/employee_type/detail.breadcrumb_level_3') }}</a></li>

    @if($mode['isModeCreate'])
        <li class="breadcrumb-item active">{{ __('eh/configurations/employee_type/detail.breadcrumb_create') }}</li>
    @else
        @if($mode['isModeEdit'])
            <li class="breadcrumb-item active">{{ $et->name }}</li>
            <li class="breadcrumb-item active">{{ __('eh/configurations/employee_type/detail.breadcrumb_edit') }}</li>
        @endif
    @endif
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    {{-- Panel --}}
    @if($mode['isModeShow'])
        <div class="card">
            <div class="card-body">
                @include('eh.configurations.employee_type.detail_panel')
            </div>
        </div>
    @endif

    <div class="card">
        {{-- Form --}}
        <form id="v_form" enctype="multipart/form-data" class="block form-horizontal form-label-left" action="@if(!$mode['isModeEdit']){{route('eh.configurations.employee_type.store')}}@elseif($mode['isModeEdit']){{route('eh.configurations.employee_type.update', $et->id)}}@endif" method="post">
            @if($mode['isModeEdit'])
                {{method_field('put')}}
            @endif
            <div class="card-body">

                <x-inputs.text
                    :label="__('eh/configurations/employee_type/detail.lb_name')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$et->name ?? ''}}"
                    name="name"
                    required="true"
                />

                <x-inputs.switch2
                    label="{{ __('eh/configurations/employee_type/detail.lb_is_active') }}"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$et->is_active ?? true}}"
                    name="is_active"
                    onText="{{ __('eh/configurations/employee_type/detail.select_option_yes') }}"
                    offText="{{ __('eh/configurations/employee_type/detail.select_option_no') }}"
                />

                {{-- Timestamp Panel --}}
                    @if($mode['isModeShow'])
                    <x-inputs.timestamp :updatedAt="$et->updated_at" :createdAt="$et->created_at" />
                    @endif
            </div>
            {{-- Panel --}}
            @if(!$mode['isModeShow'])
                <div class="card-footer">
                    @include('eh.configurations.employee_type.detail_panel')
                </div>
            @endif
        </form>
    </div>
@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')

@endpush
