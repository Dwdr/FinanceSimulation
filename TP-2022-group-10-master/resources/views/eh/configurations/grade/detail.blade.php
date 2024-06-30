{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('eh/configurations/grade/detail.title_html'))
@section('page_title', __('eh/configurations/grade/detail.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('eh/configurations/grade/detail.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active">{{ __('eh/configurations/grade/detail.breadcrumb_level_2') }}</li>
    <li class="breadcrumb-item"><a
            href="{{ route('eh.configurations.grade.index') }}">{{ __('eh/configurations/grade/detail.breadcrumb_level_3') }}</a></li>

    @if($mode['isModeCreate'])
        <li class="breadcrumb-item active">{{ __('eh/configurations/grade/detail.breadcrumb_create') }}</li>
    @else
        @if($mode['isModeEdit'])
            <li class="breadcrumb-item active">{{ $g->id }} {{ $g->id }}</li>
            <li class="breadcrumb-item active">{{ __('eh/configurations/grade/detail.breadcrumb_edit') }}</li>
        @endif
    @endif
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    {{-- Panel --}}
    @if($mode['isModeShow'])
        <div class="card">
            <div class="card-body">
                @include('eh.configurations.grade.detail_panel')
            </div>
        </div>
    @endif

    <div class="card">
        {{-- Form --}}
        <form id="v_form" enctype="multipart/form-data" class="block form-horizontal form-label-left"
              action="@if(!$mode['isModeEdit']){{route('eh.configurations.grade.store')}}@elseif($mode['isModeEdit']){{route('eh.configurations.grade.update', $g->id)}}@endif"
              method="post">
            @if($mode['isModeEdit'])
                {{method_field('put')}}
            @endif
            <div class="card-body">

                <x-inputs.text
                    :label="__('eh/configurations/grade/detail.lb_grade_en_gb')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$g->grade['en-GB'] ?? ''}}"
                    name="grade[en-GB]"
                />

                <x-inputs.text
                    :label="__('eh/configurations/grade/detail.lb_grade_zh_hk')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$g->grade['zh_HK'] ?? ''}}"
                    name="grade[zh_HK]"
                />

                <x-inputs.text
                    :label="__('eh/configurations/grade/detail.lb_grade_zh_cn')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$g->grade['zh_CN'] ?? ''}}"
                    name="grade[zh_CN]"
                />

                <x-inputs.switch2
                    label="{{ __('eh/configurations/grade/detail.lb_is_active') }}"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$g->is_active ?? true}}"
                    name="is_active"
                    onText="{{ __('eh/configurations/grade/detail.select_option_yes') }}"
                    offText="{{ __('eh/configurations/grade/detail.select_option_no') }}"
                />

                {{-- Timestamp Panel --}}
                @if($mode['isModeShow'])
                    <x-inputs.timestamp :updatedAt="$g->updated_at" :createdAt="$g->created_at" />
                @endif
            </div>
            {{-- Panel --}}
            @if(!$mode['isModeShow'])
                <div class="card-footer">
                    @include('eh.configurations.grade.detail_panel')
                </div>
            @endif
        </form>
    </div>
@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')

@endpush
