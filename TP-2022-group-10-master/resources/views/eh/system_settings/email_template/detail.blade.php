{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('eh/system_settings/email_template/detail.title_html'))
@section('page_title', __('eh/system_settings/email_template/detail.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('eh/system_settings/email_template/detail.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active">{{ __('eh/system_settings/email_template/detail.breadcrumb_level_2') }}</li>
    <li class="breadcrumb-item"><a href="{{ route('eh.system_settings.email_template.index') }}">{{ __('eh/system_settings/email_template/detail.breadcrumb_level_3') }}</a></li>

    @if($mode['isModeCreate'])
        <li class="breadcrumb-item active">{{ __('eh/system_settings/email_template/detail.breadcrumb_create') }}</li>
    @else
        @if($mode['isModeEdit'])
            <li class="breadcrumb-item active">{{ array_search($template->type, config('constants.EMAIL-TYPE')) }}</li>
            <li class="breadcrumb-item active">{{ __('eh/system_settings/email_template/detail.breadcrumb_edit') }}</li>
        @else
            <li class="breadcrumb-item active">{{ array_search($template->type, config('constants.EMAIL-TYPE')) }}</li>
        @endif
    @endif
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    {{-- Panel --}}
    @if($mode['isModeShow'])
        <div class="card">
            <div class="card-body">
                @include('eh.system_settings.email_template.detail.panel')
            </div>
        </div>
    @endif

    <div class="card">
        {{-- Form --}}
        <form id="v_form" enctype="multipart/form-data" class="block form-horizontal form-label-left" action="@if($mode['isModeEdit']){{route('eh.system_settings.email_template.update', $template->type)}}@endif" method="post">
            @if($mode['isModeEdit'])
                {{method_field('put')}}
            @endif
            <div class="card-body">

                <x-inputs.text
                    :label="__('eh/system_settings/email_template/detail.lb_email_template_type')"
                    :isReadonly="true"
                    value="{{ array_search($template->type, config('constants.EMAIL-TYPE')) }}"
                />

                <x-inputs.text
                    :label="__('eh/system_settings/email_template/detail.lb_subject')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$template->subject ?? ''}}"
                    name="subject"
                    required="true"
                />

                <x-inputs.textarea
                    :label="__('eh/system_settings/email_template/detail.lb_body')"
                    :isReadonly="$mode['isModeShow']"
                    :value="$template->body ?? ''"
                    name="body"
                    row="10"
                    isSummernote="true"
                    :hints="trans()->has('eh/system_settings/email_template/detail.lb_type_template_hints_'.array_search($template->type, config('constants.EMAIL-TYPE')))?__('eh/system_settings/email_template/detail.lb_type_template_hints_'.array_search($template->type, config('constants.EMAIL-TYPE'))):''"
                />

                {{-- Timestamp Panel --}}
                    @if($mode['isModeShow'])
                    <x-inputs.timestamp :updatedAt="$template->updated_at" :createdAt="$template->created_at" />
                    @endif
            </div>
            {{-- Panel --}}
            @if(!$mode['isModeShow'])
                <div class="card-footer">
                    @include('eh.system_settings.email_template.detail.panel')
                </div>
            @endif
        </form>
    </div>
@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')

@endpush
