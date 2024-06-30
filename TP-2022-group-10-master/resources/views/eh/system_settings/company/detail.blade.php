{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('eh/system_settings/company/detail.title_html'))
@section('page_title', __('eh/system_settings/company/detail.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('eh/system_settings/company/detail.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active">{{ __('eh/system_settings/company/detail.breadcrumb_level_2') }}</li>
    <li class="breadcrumb-item"><a href="{{ route('eh.system_settings.company.index') }}">{{ __('eh/system_settings/company/detail.breadcrumb_level_3') }}</a></li>

    @if($mode['isModeCreate'])
        <li class="breadcrumb-item active">{{ __('eh/system_settings/company/detail.breadcrumb_create') }}</li>
    @else
        @if($mode['isModeEdit'])
            <li class="breadcrumb-item active">{{ $c->name }}</li>
            <li class="breadcrumb-item active">{{ __('eh/system_settings/company/detail.breadcrumb_edit') }}</li>
        @endif
    @endif
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    {{-- Panel --}}
    @if($mode['isModeShow'])
        <div class="card">
            <div class="card-body">
                @include('eh.system_settings.company.detail.panel')
            </div>
        </div>
    @endif

    <div class="card">
        {{-- Form --}}
        <form id="v_form" enctype="multipart/form-data" class="block form-horizontal form-label-left" action="@if(!$mode['isModeEdit']){{route('eh.system_settings.company.store')}}@elseif($mode['isModeEdit']){{route('eh.system_settings.company.update', $c->id)}}@endif" method="post">
            @if($mode['isModeEdit'])
                {{method_field('put')}}
            @endif
            <div class="card-body">

                <x-inputs.text
                    :label="__('eh/system_settings/company/detail.lb_name')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$c->name ?? ''}}"
                    name="name"
                    required="true"
                />

                <x-inputs.text
                    type="text"
                    :label="__('eh/system_settings/company/detail.lb_address')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$c->default['address'] ?? ''}}"
                    name="default[address]"
                    required="true"
                />

                <x-inputs.text
                    type="email"
                    :label="__('eh/system_settings/company/detail.lb_contact_email')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$c->default['contact_email'] ?? ''}}"
                    name="default[contact_email]"
                    required="true"
                />

                <x-inputs.text
                    type="text"
                    :label="__('eh/system_settings/company/detail.lb_contact_number')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$c->default['contact_number'] ?? ''}}"
                    name="default[contact_number]"
                    required="true"
                />
                <x-inputs.text
                    :label="__('eh/system_settings/company/detail.lb_company_website')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$c->default['company_website'] ?? ''}}"
                    name="default[company_website]"
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
                    @include('eh.system_settings.company.detail.panel')
                </div>
            @endif
        </form>
    </div>
@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')

@endpush
