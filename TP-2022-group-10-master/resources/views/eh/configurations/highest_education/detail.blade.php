{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('eh/configurations/highest_education/detail.title_html'))
@section('page_title', __('eh/configurations/highest_education/detail.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('eh/configurations/highest_education/detail.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active">{{ __('eh/configurations/highest_education/detail.breadcrumb_level_2') }}</li>
    <li class="breadcrumb-item"><a
            href="{{ route('eh.configurations.highest_education.index') }}">{{ __('eh/configurations/highest_education/detail.breadcrumb_level_3') }}</a></li>

    @if($mode['isModeCreate'])
        <li class="breadcrumb-item active">{{ __('eh/configurations/highest_education/detail.breadcrumb_create') }}</li>
    @else
        @if($mode['isModeEdit'])
            <li class="breadcrumb-item active">{{ $he->id }} {{ $he->id }}</li>
            <li class="breadcrumb-item active">{{ __('eh/configurations/highest_education/detail.breadcrumb_edit') }}</li>
        @endif
    @endif
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    {{-- Panel --}}
    @if($mode['isModeShow'])
        <div class="card">
            <div class="card-body">
                @include('eh.configurations.highest_education.detail_panel')
            </div>
        </div>
    @endif

    <div class="card">
        {{-- Form --}}
        <form id="v_form" enctype="multipart/form-data" class="block form-horizontal form-label-left"
              action="@if(!$mode['isModeEdit']){{route('eh.configurations.highest_education.store')}}@elseif($mode['isModeEdit']){{route('eh.configurations.highest_education.update', $he->id)}}@endif"
              method="post">
            @if($mode['isModeEdit'])
                {{method_field('put')}}
            @endif
            <div class="card-body">

                <x-inputs.text
                    :label="__('eh/configurations/highest_education/detail.lb_highest_education_en_gb')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$he->highest_education['en-GB'] ?? ''}}"
                    name="highest_education[en-GB]"
                />

                <x-inputs.text
                    :label="__('eh/configurations/highest_education/detail.lb_highest_education_zh_hk')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$he->highest_education['zh_HK'] ?? ''}}"
                    name="highest_education[zh_HK]"
                />

                <x-inputs.text
                    :label="__('eh/configurations/highest_education/detail.lb_highest_education_zh_cn')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$he->highest_education['zh_CN'] ?? ''}}"
                    name="highest_education[zh_CN]"
                />

                <x-inputs.switch2
                    label="{{ __('eh/configurations/highest_education/detail.lb_is_active') }}"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$he->is_active ?? true}}"
                    name="is_active"
                    onText="{{ __('eh/configurations/highest_education/detail.select_option_yes') }}"
                    offText="{{ __('eh/configurations/highest_education/detail.select_option_no') }}"
                />

                {{-- Timestamp Panel --}}
                @if($mode['isModeShow'])
                    <x-inputs.timestamp :updatedAt="$he->updated_at" :createdAt="$he->created_at" />
                @endif
            </div>
            {{-- Panel --}}
            @if(!$mode['isModeShow'])
                <div class="card-footer">
                    @include('eh.configurations.highest_education.detail_panel')
                </div>
            @endif
        </form>
    </div>
@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')

@endpush
