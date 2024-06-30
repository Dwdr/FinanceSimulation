{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('eh/configurations/title/detail.title_html'))
@section('page_title', __('eh/configurations/title/detail.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('eh/configurations/title/detail.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active">{{ __('eh/configurations/title/detail.breadcrumb_level_2') }}</li>
    <li class="breadcrumb-item"><a href="{{ route('eh.configurations.title.index') }}">{{ __('eh/configurations/title/detail.breadcrumb_level_3') }}</a></li>

    @if($mode['isModeCreate'])
        <li class="breadcrumb-item active">{{ __('eh/configurations/title/detail.breadcrumb_create') }}</li>
    @else
        @if($mode['isModeEdit'])
            <li class="breadcrumb-item active">{{ $t->id }} {{ $t->id }}</li>
            <li class="breadcrumb-item active">{{ __('eh/configurations/title/detail.breadcrumb_edit') }}</li>
        @endif
    @endif
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    {{-- Panel --}}
    @if($mode['isModeShow'])
        <div class="card">
            <div class="card-body">
                @include('eh.configurations.title.detail_panel')
            </div>
        </div>
    @endif

    <div class="card">
        {{-- Form --}}
        <form id="v_form" enctype="multipart/form-data" class="block form-horizontal form-label-left" action="@if(!$mode['isModeEdit']){{route('eh.configurations.title.store')}}@elseif($mode['isModeEdit']){{route('eh.configurations.title.update', $t->id)}}@endif" method="post">
            @if($mode['isModeEdit'])
                {{method_field('put')}}
            @endif
            <div class="card-body">

                <x-inputs.text
                    :label="__('eh/configurations/title/detail.lb_title_en_gb')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$t->title['en-GB'] ?? ''}}"
                    name="title[en-GB]"
                    required="true"
                />

                <x-inputs.text
                    :label="__('eh/configurations/title/detail.lb_title_zh_hk')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$t->title['zh_HK'] ?? ''}}"
                    name="title[zh_HK]"
                    required="true"
                />

                <x-inputs.text
                    :label="__('eh/configurations/title/detail.lb_title_zh_cn')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$t->title['zh_CN'] ?? ''}}"
                    name="title[zh_CN]"
                    required="true"
                />

                <x-inputs.switch2
                    label="{{ __('eh/configurations/title/detail.lb_is_active') }}"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$t->is_active ?? true}}"
                    name="is_active"
                    onText="{{ __('eh/configurations/title/detail.select_option_yes') }}"
                    offText="{{ __('eh/configurations/title/detail.select_option_no') }}"
                />

                {{-- Timestamp Panel --}}
                @if($mode['isModeShow'])
                <x-inputs.timestamp :updatedAt="$t->updated_at" :createdAt="$t->created_at" />
                @endif
            </div>
            {{-- Panel --}}
            @if(!$mode['isModeShow'])
                <div class="card-footer">
                    @include('eh.configurations.title.detail_panel')
                </div>
            @endif
        </form>
    </div>
@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')

@endpush
