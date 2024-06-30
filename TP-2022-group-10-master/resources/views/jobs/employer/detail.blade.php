{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_jobs')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('jobs/employer/detail.title_html'))
@section('page_title', __('jobs/employer/detail.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('jobs/employer/detail.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active">{{ __('jobs/employer/detail.breadcrumb_level_2') }}</li>
    <li class="breadcrumb-item"><a href="{{ route('jobs.employer.index') }}">{{ __('jobs/employer/detail.breadcrumb_level_3') }}</a></li>

    @if($mode['isModeCreate'])
        <li class="breadcrumb-item active">{{ __('jobs/employer/detail.breadcrumb_create') }}</li>
    @else
        @if($mode['isModeEdit'])
            <li class="breadcrumb-item active">{{ $e->name }}</li>
            <li class="breadcrumb-item active">{{ __('jobs/employer/detail.breadcrumb_edit') }}</li>
        @endif
    @endif
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    {{-- Panel --}}
    @if($mode['isModeShow'])
        <div class="card">
            <div class="card-body">
                @include('jobs.employer.detail_panel')
            </div>
        </div>
    @endif

    <div class="card">
        {{-- Form --}}
        <form id="v_form" enctype="multipart/form-data" class="block form-horizontal form-label-left" action="@if(!$mode['isModeEdit']){{route('jobs.employer.store')}}@elseif($mode['isModeEdit']){{route('jobs.employer.update', $e->uuid)}}@endif" method="post">
            @if($mode['isModeEdit'])
                {{method_field('put')}}
            @endif
            <div class="card-body">
                <x-inputs.text
                    :label="__('jobs/job/detail.lb_uuid')"
                    :isReadonly=true
                    value="{{ $e->uuid ?? '' }}"
                    name="uuid"
                    required="true"
                />

                <x-inputs.text
                    :label="__('jobs/employer/detail.lb_company_name')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{ $e->company_name ?? '' }}"
                    name="company_name"
                    required="true"
                />

                <x-inputs.text
                    :label="__('jobs/employer/detail.lb_office_address')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{ $e->office_address ?? '' }}"
                    name="office_address"
                    required="true"
                />

                <x-inputs.text
                    :label="__('jobs/employer/detail.lb_website')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{ $e->website ?? '' }}"
                    name="website"
                    required="true"
                />

                <x-inputs.text
                    :label="__('jobs/employer/detail.lb_email')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{ $e->email ?? '' }}"
                    name="email"
                    required="true"
                />

                <x-inputs.text
                    :label="__('jobs/employer/detail.lb_contact_person')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$e->contact_person ?? ''}}"
                    name="contact_person"
                    required="true"
                />

                <x-inputs.text
                    :label="__('jobs/employer/detail.lb_contact_number')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$e->contact_number ?? ''}}"
                    name="contact_number"
                    required="true"
                />

                <x-inputs.switch2
                    label="{{ __('jobs/employer/detail.lb_is_active') }}"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$e->is_active ?? true}}"
                    name="is_active"
                    onText="{{ __('jobs/employer/detail.select_option_yes') }}"
                    offText="{{ __('jobs/employer/detail.select_option_no') }}"
                />

                {{-- Timestamp Panel --}}
                @if($mode['isModeShow'])
                    <x-inputs.timestamp :updatedAt="$e->updated_at" :createdAt="$e->created_at" />
                @endif
            </div>
            {{-- Panel --}}
            @if(!$mode['isModeShow'])
                <div class="card-footer">
                    @include('jobs.employer.detail_panel')
                </div>
            @endif
        </form>
    </div>
@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')

@endpush
