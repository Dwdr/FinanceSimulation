{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_jobs')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('jobs/seeker/detail.title_html'))
@section('page_title', __('jobs/seeker/detail.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('jobs/seeker/detail.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active">{{ __('jobs/seeker/detail.breadcrumb_level_2') }}</li>
    <li class="breadcrumb-item"><a href="{{ route('jobs.seeker.index') }}">{{ __('jobs/seeker/detail.breadcrumb_level_3') }}</a></li>

    @if($mode['isModeCreate'])
        <li class="breadcrumb-item active">{{ __('jobs/seeker/detail.breadcrumb_create') }}</li>
    @else
        @if($mode['isModeEdit'])
            <li class="breadcrumb-item active">{{ $s->name }}</li>
            <li class="breadcrumb-item active">{{ __('jobs/seeker/detail.breadcrumb_edit') }}</li>
        @endif
    @endif
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    {{-- Panel --}}
    @if($mode['isModeShow'])
        <div class="card">
            <div class="card-body">
                @include('jobs.seeker.detail_panel')
            </div>
        </div>
    @endif

    <div class="card">
        {{-- Form --}}
        <form id="v_form" enctype="multipart/form-data" class="block form-horizontal form-label-left" action="@if(!$mode['isModeEdit']){{route('jobs.seeker.store')}}@elseif($mode['isModeEdit']){{route('jobs.seeker.update', $s->uuid)}}@endif" method="post">
            @if($mode['isModeEdit'])
                {{method_field('put')}}
            @endif
            <div class="card-body">

                <x-inputs.text
                    :label="__('jobs/seeker/detail.lb_name')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{ $s->name ?? '' }}"
                    name="name"
                    required="true"
                />

                <x-inputs.textarea
                    :label="__('jobs/seeker/detail.lb_introduction')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$s->introduction ?? ''}}"
                    name="introduction"
                />

                <x-inputs.text
                    :label="__('jobs/seeker/detail.lb_email')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{ $s->email ?? '' }}"
                    name="email"
                    required="true"
                />

                <x-inputs.text
                    :label="__('jobs/seeker/detail.lb_contact_number')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$s->contact_number ?? ''}}"
                    name="contact_number"
                    required="true"
                />

                <x-inputs.switch2
                    label="{{ __('jobs/seeker/detail.lb_is_active') }}"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$s->is_active ?? true}}"
                    name="is_active"
                    onText="{{ __('jobs/seeker/detail.select_option_yes') }}"
                    offText="{{ __('jobs/seeker/detail.select_option_no') }}"
                />

                {{-- Timestamp Panel --}}
                @if($mode['isModeShow'])
                    <x-inputs.timestamp :updatedAt="$s->updated_at" :createdAt="$s->created_at" />
                @endif
            </div>
            {{-- Panel --}}
            @if(!$mode['isModeShow'])
                <div class="card-footer">
                    @include('jobs.seeker.detail_panel')
                </div>
            @endif
        </form>
    </div>
@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')

@endpush
