{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('eh/configurations/holiday_type/detail.title_html'))
@section('page_title', __('eh/configurations/holiday_type/detail.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('eh/configurations/holiday_type/detail.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active">{{ __('eh/configurations/holiday_type/detail.breadcrumb_level_2') }}</li>
    <li class="breadcrumb-item"><a
            href="{{ route('eh.configurations.holiday-type.index') }}">{{ __('eh/configurations/holiday_type/detail.breadcrumb_level_3') }}</a></li>

    @if($mode['isModeCreate'])
        <li class="breadcrumb-item active">{{ __('eh/configurations/holiday_type/detail.breadcrumb_create') }}</li>
    @else
        @if($mode['isModeEdit'])
            <li class="breadcrumb-item active">{{ $t->title }}</li>
            <li class="breadcrumb-item active">{{ __('eh/configurations/holiday_type/detail.breadcrumb_edit') }}</li>
        @endif
    @endif
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    {{-- Panel --}}
    @if($mode['isModeShow'])
        <div class="card">
            <div class="card-body">
                @include('eh.configurations.holiday_type.detail_panel')
            </div>
        </div>
    @endif

    <div class="card">
        {{-- Form --}}
        <form id="v_form" enctype="multipart/form-data" class="block form-horizontal form-label-left"
              action="@if(!$mode['isModeEdit']){{route('eh.configurations.holiday-type.store')}}@elseif($mode['isModeEdit']){{route('eh.configurations.holiday-type.update', $t->id)}}@endif"
              method="post">
            @if($mode['isModeEdit'])
                {{method_field('put')}}
            @endif
            <div class="card-body">
                <x-inputs.text
                    :label="__('eh/configurations/holiday_type/detail.lb_code')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$t->code ?? ''}}"
                    name="code"
                    required="true"
                />
                <x-inputs.text
                    type="year"
                    :label="__('eh/configurations/holiday_type/detail.lb_name')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$t->name ?? ''}}"
                    name="name"
                    required="true"
                />
                <x-inputs.switch2
                    label="{{ __('eh/configurations/holiday_type/detail.lb_is_nwd') }}"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$t->is_nwd ?? false}}"
                    name="is_nwd"
                    onText="{{ __('eh/configurations/holiday_type/detail.select_option_yes') }}"
                    offText="{{ __('eh/configurations/holiday_type/detail.select_option_no') }}"
                />
                <x-inputs.switch2
                    label="{{ __('eh/configurations/holiday_type/detail.lb_is_adj') }}"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$t->is_adj ?? false}}"
                    name="is_adj"
                    onText="{{ __('eh/configurations/holiday_type/detail.select_option_yes') }}"
                    offText="{{ __('eh/configurations/holiday_type/detail.select_option_no') }}"
                />
                <x-inputs.switch2
                    label="{{ __('eh/configurations/holiday_type/detail.lb_is_rse') }}"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$t->is_rse ?? false}}"
                    name="is_rse"
                    onText="{{ __('eh/configurations/holiday_type/detail.select_option_yes') }}"
                    offText="{{ __('eh/configurations/holiday_type/detail.select_option_no') }}"
                />
                <x-inputs.text
                    type="number"
                    :label="__('eh/configurations/holiday_type/detail.lb_percentage')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$t->percentage ?? ''}}"
                    name="percentage"
                    required="true"
                    min="0"
                />
                {{-- Timestamp Panel --}}
                @if($mode['isModeShow'])
                    <x-inputs.timestamp :updatedAt="$t->updated_at" :createdAt="$t->created_at" />
                @endif
            </div>
            {{-- Panel --}}
            @if(!$mode['isModeShow'])
                <div class="card-footer">
                    @include('eh.configurations.holiday_type.detail_panel')
                </div>
            @endif
        </form>
    </div>
@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')
    <script>
        $().ready(function () {

        })
    </script>
@endpush
