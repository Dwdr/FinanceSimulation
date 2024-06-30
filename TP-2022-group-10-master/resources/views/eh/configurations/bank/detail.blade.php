{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('eh/configurations/bank/detail.title_html'))
@section('page_title', __('eh/configurations/bank/detail.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('eh/configurations/bank/detail.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active">{{ __('eh/configurations/bank/detail.breadcrumb_level_2') }}</li>
    <li class="breadcrumb-item"><a href="{{ route('eh.configurations.bank.index') }}">{{ __('eh/configurations/bank/detail.breadcrumb_level_3') }}</a></li>

    @if($mode['isModeCreate'])
        <li class="breadcrumb-item active">{{ __('eh/configurations/bank/detail.breadcrumb_create') }}</li>
    @else
        @if($mode['isModeEdit'])
            <li class="breadcrumb-item active">{{ $b->id }} {{ $b->id }}</li>
            <li class="breadcrumb-item active">{{ __('eh/configurations/bank/detail.breadcrumb_edit') }}</li>
        @endif
    @endif
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    {{-- Panel --}}
    @if($mode['isModeShow'])
        <div class="card">
            <div class="card-body">
                @include('eh.configurations.bank.detail_panel')
            </div>
        </div>
    @endif

    <div class="card">
        {{-- Form --}}
        <form id="v_form" enctype="multipart/form-data" class="block form-horizontal form-label-left" action="@if(!$mode['isModeEdit']){{route('eh.configurations.bank.store')}}@elseif($mode['isModeEdit']){{route('eh.configurations.bank.update', $b->id)}}@endif" method="post">
            @if($mode['isModeEdit'])
                {{method_field('put')}}
            @endif
            <div class="card-body">

                <x-inputs.text
                    :label="__('eh/configurations/bank/detail.lb_bank_en_gb')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$b->bank['en-GB'] ?? ''}}"
                    name="bank[en-GB]"
                />

                <x-inputs.text
                    :label="__('eh/configurations/bank/detail.lb_bank_zh_hk')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$b->bank['zh_HK'] ?? ''}}"
                    name="bank[zh_HK]"
                />

                <x-inputs.text
                    :label="__('eh/configurations/bank/detail.lb_bank_zh_cn')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$b->bank['zh_CN'] ?? ''}}"
                    name="bank[zh_CN]"
                />

                <x-inputs.text
                    :label="__('eh/configurations/bank/detail.lb_code')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$b->code ?? ''}}"
                    name="code"
                    min="3"
                    max="3"
                />

                <x-inputs.text
                    :label="__('eh/configurations/bank/detail.lb_swift')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$b->swift ?? ''}}"
                    name="swift"
                />

                <x-inputs.switch2
                    label="{{ __('eh/configurations/bank/detail.lb_is_active') }}"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$b->is_active ?? true}}"
                    name="is_active"
                    onText="{{ __('eh/configurations/bank/detail.select_option_yes') }}"
                    offText="{{ __('eh/configurations/bank/detail.select_option_no') }}"
                />

                {{-- Timestamp Panel --}}
                    @if($mode['isModeShow'])
                    <x-inputs.timestamp :updatedAt="$b->updated_at" :createdAt="$b->created_at" />
                    @endif
            </div>
            {{-- Panel --}}
            @if(!$mode['isModeShow'])
                <div class="card-footer">
                    @include('eh.configurations.bank.detail_panel')
                </div>
            @endif
        </form>
    </div>
@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')

@endpush
