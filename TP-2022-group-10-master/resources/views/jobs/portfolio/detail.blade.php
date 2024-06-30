{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_jobs')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('jobs/portfolio/detail.title_html'))
@section('page_title', __('jobs/portfolio/detail.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('jobs/portfolio/detail.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active">{{ __('jobs/portfolio/detail.breadcrumb_level_2') }}</li>
    <li class="breadcrumb-item"><a href="{{ route('jobs.portfolio.index') }}">{{ __('jobs/portfolio/detail.breadcrumb_level_3') }}</a></li>

    @if($mode['isModeCreate'])
        <li class="breadcrumb-item active">{{ __('jobs/portfolio/detail.breadcrumb_create') }}</li>
    @else
        @if($mode['isModeEdit'])
            <li class="breadcrumb-item active">{{ $e->name }}</li>
            <li class="breadcrumb-item active">{{ __('jobs/portfolio/detail.breadcrumb_edit') }}</li>
        @endif
    @endif
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    {{-- Panel --}}
    @if($mode['isModeShow'])
        <div class="card">
            <div class="card-body">
                @include('jobs.portfolio.detail_panel')
            </div>
        </div>
    @endif

    <div class="card">
        {{-- Form --}}
        <form id="v_form" enctype="multipart/form-data" class="block form-horizontal form-label-left" action="@if(!$mode['isModeEdit']){{route('jobs.portfolio.store')}}@elseif($mode['isModeEdit']){{route('jobs.portfolio.update', $e->uuid)}}@endif" method="post">
            @if($mode['isModeEdit'])
                {{method_field('put')}}
            @endif
            <div class="card-body">

                <x-inputs.text
                    :label="__('jobs/portfolio/detail.lb_type')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{ $p->type ?? '' }}"
                    name="type"
                    required="true"
                />

                <x-inputs.text
                    :label="__('jobs/portfolio/detail.lb_file')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{ $p->file ?? '' }}"
                    name="file"
                    required="true"
                />

                <x-inputs.text
                    :label="__('jobs/portfolio/detail.lb_title')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{ $p->title ?? '' }}"
                    name="title"
                    required="true"
                />

                <x-inputs.textarea
                    :label="__('jobs/job/detail.lb_description')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$p->description ?? ''}}"
                    name="description"
                />








                <x-inputs.switch2
                    label="{{ __('jobs/portfolio/detail.lb_is_active') }}"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$e->is_active ?? true}}"
                    name="is_active"
                    onText="{{ __('jobs/portfolio/detail.select_option_yes') }}"
                    offText="{{ __('jobs/portfolio/detail.select_option_no') }}"
                />

                {{-- Timestamp Panel --}}
                @if($mode['isModeShow'])
                    <x-inputs.timestamp :updatedAt="$e->updated_at" :createdAt="$e->created_at" />
                @endif
            </div>
            {{-- Panel --}}
            @if(!$mode['isModeShow'])
                <div class="card-footer">
                    @include('jobs.portfolio.detail_panel')
                </div>
            @endif
        </form>
    </div>
@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')

@endpush
