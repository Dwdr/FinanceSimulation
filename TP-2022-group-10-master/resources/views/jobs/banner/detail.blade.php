{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_jobs')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('jobs/banner/detail.title_html'))
@section('page_title', __('jobs/banner/detail.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('jobs/banner/detail.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active">{{ __('jobs/banner/detail.breadcrumb_level_2') }}</li>
    <li class="breadcrumb-item"><a href="{{ route('jobs.banner.index') }}">{{ __('jobs/banner/detail.breadcrumb_level_3') }}</a></li>

    @if($mode['isModeCreate'])
        <li class="breadcrumb-item active">{{ __('jobs/banner/detail.breadcrumb_create') }}</li>
    @else
        @if($mode['isModeEdit'])
            <li class="breadcrumb-item active">{{ $b->name }}</li>
            <li class="breadcrumb-item active">{{ __('jobs/banner/detail.breadcrumb_edit') }}</li>
        @endif
    @endif
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    {{-- Panel --}}
    @if($mode['isModeShow'])
        <div class="card">
            <div class="card-body">
                @include('jobs.banner.detail_panel')
            </div>
        </div>
    @endif

    <div class="card">
        {{-- Form --}}
        <form id="v_form" enctype="multipart/form-data" class="block form-horizontal form-label-left" action="@if(!$mode['isModeEdit']){{route('jobs.banner.store')}}@elseif($mode['isModeEdit']){{route('jobs.banner.update', $b->uuid)}}@endif" method="post">
            @if($mode['isModeEdit'])
                {{method_field('put')}}
            @endif
            <div class="card-body">

                <x-inputs.text
                    :label="__('jobs/banner/detail.lb_company_name')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{ $b->company_name ?? '' }}"
                    name="company_name"
                    required="true"
                />

                <x-inputs.text
                    :label="__('jobs/banner/detail.lb_office_address')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{ $b->office_address ?? '' }}"
                    name="office_address"
                    required="true"
                />

                <x-inputs.text
                    :label="__('jobs/banner/detail.lb_website')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{ $b->website ?? '' }}"
                    name="website"
                    required="true"
                />

                <x-inputs.text
                    :label="__('jobs/banner/detail.lb_email')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{ $b->email ?? '' }}"
                    name="email"
                    required="true"
                />

                <x-inputs.text
                    :label="__('jobs/banner/detail.lb_contact_person')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$b->contact_person ?? ''}}"
                    name="contact_person"
                    required="true"
                />

                <x-inputs.text
                    :label="__('jobs/banner/detail.lb_contact_number')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$b->contact_number ?? ''}}"
                    name="contact_number"
                    required="true"
                />

                <x-inputs.switch2
                    label="{{ __('jobs/banner/detail.lb_is_active') }}"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$b->is_active ?? true}}"
                    name="is_active"
                    onText="{{ __('jobs/banner/detail.select_option_yes') }}"
                    offText="{{ __('jobs/banner/detail.select_option_no') }}"
                />

                {{-- Timestamp Panel --}}
                @if($mode['isModeShow'])
                    <x-inputs.timestamp :updatedAt="$b->updated_at" :createdAt="$b->created_at" />
                @endif
            </div>
            {{-- Panel --}}
            @if(!$mode['isModeShow'])
                <div class="card-footer">
                    @include('jobs.banner.detail_panel')
                </div>
            @endif
        </form>
    </div>
@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')

@endpush
