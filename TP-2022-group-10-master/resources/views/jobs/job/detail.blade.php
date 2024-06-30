{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_jobs')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('jobs/job/detail.title_html'))
@section('page_title', __('jobs/job/detail.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('jobs/job/detail.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active">{{ __('jobs/job/detail.breadcrumb_level_2') }}</li>
    <li class="breadcrumb-item"><a href="{{ route('jobs.job.index') }}">{{ __('jobs/job/detail.breadcrumb_level_3') }}</a></li>

    @if($mode['isModeCreate'])
        <li class="breadcrumb-item active">{{ __('jobs/job/detail.breadcrumb_create') }}</li>
    @else
        @if($mode['isModeEdit'])
            <li class="breadcrumb-item active">{{ $j->name }}</li>
            <li class="breadcrumb-item active">{{ __('jobs/job/detail.breadcrumb_edit') }}</li>
        @endif
    @endif
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    {{-- Panel --}}
    @if($mode['isModeShow'])
        <div class="card">
            <div class="card-body">
                @include('jobs.job.detail_panel')
            </div>
        </div>
    @endif

    <div class="card">
        {{-- Form --}}
        <form id="v_form" enctype="multipart/form-data" class="block form-horizontal form-label-left" action="@if(!$mode['isModeEdit']){{route('jobs.job.store')}}@elseif($mode['isModeEdit']){{route('jobs.job.update', $j->uuid)}}@endif" method="post">
            @if($mode['isModeEdit'])
                {{method_field('put')}}
            @endif
            <div class="card-body">
                <x-inputs.text
                    :label="__('jobs/job/detail.lb_uuid')"
                    :isReadonly=true
                    value="{{ $j->uuid ?? '' }}"
                    name="uuid"
                    required="true"
                />

                <x-inputs.text
                    :label="__('jobs/job/detail.lb_title')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{ $j->title ?? '' }}"
                    name="title"
                    required="true"
                />

                <x-inputs.textarea
                    :label="__('jobs/job/detail.lb_description')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$j->description ?? ''}}"
                    name="description"
                />

                <x-inputs.textarea
                    :label="__('jobs/job/detail.lb_requirement')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$j->requirement ?? ''}}"
                    name="requirement"
                />

                <x-inputs.textarea
                    :label="__('jobs/job/detail.lb_remarks')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$j->remarks ?? ''}}"
                    name="remarks"
                />

                <x-inputs.text
                    :label="__('jobs/job/detail.lb_deadline')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{ $j->deadline ?? '' }}"
                    name="deadline"
                    required="true"
                />

                <x-inputs.switch2
                    label="{{ __('jobs/job/detail.lb_is_active') }}"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$j->is_active ?? true}}"
                    name="is_active"
                    onText="{{ __('jobs/job/detail.select_option_yes') }}"
                    offText="{{ __('jobs/job/detail.select_option_no') }}"
                />

                {{-- Timestamp Panel --}}
                @if($mode['isModeShow'])
                    <x-inputs.timestamp :updatedAt="$j->updated_at" :createdAt="$j->created_at" />
                @endif
            </div>
            {{-- Panel --}}
            @if(!$mode['isModeShow'])
                <div class="card-footer">
                    @include('jobs.job.detail_panel')
                </div>
            @endif
        </form>
    </div>
@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')

@endpush
