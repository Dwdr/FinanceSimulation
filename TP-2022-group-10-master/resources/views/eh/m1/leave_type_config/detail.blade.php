{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('eh/m1/leave_type_config/detail.title_html'))
@section('page_title', __('eh/m1/leave_type_config/detail.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('eh/m1/leave_type_config/detail.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active">{{ __('eh/m1/leave_type_config/detail.breadcrumb_level_2') }}</li>
    <li class="breadcrumb-item"><a
            href="{{ route('m1.leave-type-config.index') }}">{{ __('eh/m1/leave_type_config/detail.breadcrumb_level_3') }}</a></li>

    @if($mode['isModeCreate'])
        <li class="breadcrumb-item active">{{ __('eh/m1/leave_type_config/detail.breadcrumb_create') }}</li>
    @else
        @if($mode['isModeEdit'])
            <li class="breadcrumb-item active">{{ $c->title }}</li>
            <li class="breadcrumb-item active">{{ __('eh/m1/leave_type_config/detail.breadcrumb_edit') }}</li>
        @endif
    @endif
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    {{-- Panel --}}
    @if($mode['isModeShow'])
        <div class="card">
            <div class="card-body">
                @include('eh.m1.leave_type_config.detail_panel')
            </div>
        </div>
    @endif

    <div class="card">
        {{-- Form --}}
        <form id="v_form" enctype="multipart/form-data" class="block form-horizontal form-label-left"
              action="@if(!$mode['isModeEdit']){{route('m1.leave-type-config.store')}}@elseif($mode['isModeEdit']){{route('m1.leave-type-config.update', $c->id)}}@endif"
              method="post">
            @if($mode['isModeEdit'])
                {{method_field('put')}}
            @endif
            <div class="card-body">
                <x-inputs.text
                    :label="__('eh/m1/leave_type_config/detail.lb_code')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$c->code ?? ''}}"
                    name="code"
                    required="true"
                />
                <x-inputs.text
                    type="year"
                    :label="__('eh/m1/leave_type_config/detail.lb_name')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$c->name ?? ''}}"
                    name="name"
                    required="true"
                />
                <x-inputs.switch2
                    label="{{ __('eh/m1/leave_type_config/detail.lb_is_nwd') }}"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$c->is_nwd ?? false}}"
                    name="is_nwd"
                    onText="{{ __('eh/m1/leave_type_config/detail.select_option_yes') }}"
                    offText="{{ __('eh/m1/leave_type_config/detail.select_option_no') }}"
                />
                <x-inputs.switch2
                    label="{{ __('eh/m1/leave_type_config/detail.lb_is_adj') }}"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$c->is_adj ?? false}}"
                    name="is_adj"
                    onText="{{ __('eh/m1/leave_type_config/detail.select_option_yes') }}"
                    offText="{{ __('eh/m1/leave_type_config/detail.select_option_no') }}"
                />
                <x-inputs.switch2
                    label="{{ __('eh/m1/leave_type_config/detail.lb_is_rse') }}"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$c->is_rse ?? false}}"
                    name="is_rse"
                    onText="{{ __('eh/m1/leave_type_config/detail.select_option_yes') }}"
                    offText="{{ __('eh/m1/leave_type_config/detail.select_option_no') }}"
                />
                <x-inputs.text
                    type="percentage"
                    :label="__('eh/m1/leave_type_config/detail.lb_percentage')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$c->percentage ?? ''}}"
                    name="percentage"
                    required="true"
                />
                {{-- Timestamp Panel --}}
                @if($mode['isModeShow'])
                    <x-inputs.timestamp :updatedAt="$c->updated_at" :createdAt="$c->created_at" />
                @endif
            </div>
            {{-- Panel --}}
            @if(!$mode['isModeShow'])
                <div class="card-footer">
                    @include('eh.m1.leave_type_config.detail_panel')
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
