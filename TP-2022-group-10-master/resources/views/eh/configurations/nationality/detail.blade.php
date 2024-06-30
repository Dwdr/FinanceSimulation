{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('eh/configurations/nationality/detail.title_html'))
@section('page_title', __('eh/configurations/nationality/detail.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('eh/configurations/nationality/detail.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active">{{ __('eh/configurations/nationality/detail.breadcrumb_level_2') }}</li>
    <li class="breadcrumb-item"><a
            href="{{ route('eh.configurations.nationality.index') }}">{{ __('eh/configurations/nationality/detail.breadcrumb_level_3') }}</a></li>

    @if($mode['isModeCreate'])
        <li class="breadcrumb-item active">{{ __('eh/configurations/nationality/detail.breadcrumb_create') }}</li>
    @else
        @if($mode['isModeEdit'])
            <li class="breadcrumb-item active">{{ $n->id }} {{ $n->id }}</li>
            <li class="breadcrumb-item active">{{ __('eh/configurations/nationality/detail.breadcrumb_edit') }}</li>
        @endif
    @endif
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    {{-- Panel --}}
    @if($mode['isModeShow'])
        <div class="card">
            <div class="card-body">
                @include('eh.configurations.nationality.detail_panel')
            </div>
        </div>
    @endif

    <div class="card">
        {{-- Form --}}
        <form id="v_form" enctype="multipart/form-data" class="block form-horizontal form-label-left"
              action="@if(!$mode['isModeEdit']){{route('eh.configurations.nationality.store')}}@elseif($mode['isModeEdit']){{route('eh.configurations.nationality.update', $n->id)}}@endif"
              method="post">
            @if($mode['isModeEdit'])
                {{method_field('put')}}
            @endif
            <div class="card-body">

                <x-inputs.text
                    :label="__('eh/configurations/nationality/detail.lb_nationality_alpha_2_code')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$n->alpha_2_code ?? ''}}"
                    name="alpha_2_code"
                    required="true"
                />

                <x-inputs.text
                    :label="__('eh/configurations/nationality/detail.lb_nationality_alpha_3_code')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$n->alpha_3_code ?? ''}}"
                    name="alpha_3_code"
                    required="true"
                />

                <x-inputs.text
                    :label="__('eh/configurations/nationality/detail.lb_nationality_en_gb')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$n->nationality['en-GB'] ?? ''}}"
                    name="nationality[en-GB]"
                    required="true"
                />

                <x-inputs.text
                    :label="__('eh/configurations/nationality/detail.lb_nationality_zh_hk')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$n->nationality['zh_HK'] ?? ''}}"
                    name="nationality[zh_HK]"
                    required="true"
                />

                <x-inputs.text
                    :label="__('eh/configurations/nationality/detail.lb_nationality_zh_cn')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$n->nationality['zh_CN'] ?? ''}}"
                    name="nationality[zh_CN]"
                    required="true"
                />

                <x-inputs.switch2
                    label="{{ __('eh/configurations/nationality/detail.lb_is_active') }}"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$n->is_active ?? true}}"
                    name="is_active"
                    onText="{{ __('eh/configurations/nationality/detail.select_option_yes') }}"
                    offText="{{ __('eh/configurations/nationality/detail.select_option_no') }}"
                />

                {{-- Timestamp Panel --}}
                @if($mode['isModeShow'])
                    <x-inputs.timestamp :updatedAt="$n->updated_at" :createdAt="$n->created_at" />
                @endif
            </div>
            {{-- Panel --}}
            @if(!$mode['isModeShow'])
                <div class="card-footer">
                    @include('eh.configurations.nationality.detail_panel')
                </div>
            @endif
        </form>
    </div>
@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')

@endpush
