{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_jobs')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('jobs/post/detail.title_html'))
@section('page_title', __('jobs/post/detail.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('jobs/post/detail.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active">{{ __('jobs/post/detail.breadcrumb_level_2') }}</li>
    <li class="breadcrumb-item"><a href="{{ route('jobs.post.index') }}">{{ __('jobs/post/detail.breadcrumb_level_3') }}</a></li>

    @if($mode['isModeCreate'])
        <li class="breadcrumb-item active">{{ __('jobs/post/detail.breadcrumb_create') }}</li>
    @else
        @if($mode['isModeEdit'])
            <li class="breadcrumb-item active">{{ $p->name }}</li>
            <li class="breadcrumb-item active">{{ __('jobs/post/detail.breadcrumb_edit') }}</li>
        @endif
    @endif
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    {{-- Panel --}}
    @if($mode['isModeShow'])
        <div class="card">
            <div class="card-body">
                @include('jobs.post.detail_panel')
            </div>
        </div>
    @endif

    <div class="card">
        {{-- Form --}}
        <form id="v_form" enctype="multipart/form-data" class="block form-horizontal form-label-left" action="@if(!$mode['isModeEdit']){{route('jobs.post.store')}}@elseif($mode['isModeEdit']){{route('jobs.post.update', $p->uuid)}}@endif" method="post">
            @if($mode['isModeEdit'])
                {{method_field('put')}}
            @endif
            <div class="card-body">

                <x-inputs.text
                    :label="__('jobs/post/detail.lb_company_name')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{ $p->company_name ?? '' }}"
                    name="company_name"
                    required="true"
                />

                <x-inputs.text
                    :label="__('jobs/post/detail.lb_office_address')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{ $p->office_address ?? '' }}"
                    name="office_address"
                    required="true"
                />

                <x-inputs.text
                    :label="__('jobs/post/detail.lb_website')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{ $p->website ?? '' }}"
                    name="website"
                    required="true"
                />

                <x-inputs.text
                    :label="__('jobs/post/detail.lb_email')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{ $p->email ?? '' }}"
                    name="email"
                    required="true"
                />

                <x-inputs.text
                    :label="__('jobs/post/detail.lb_contact_person')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$p->contact_person ?? ''}}"
                    name="contact_person"
                    required="true"
                />

                <x-inputs.text
                    :label="__('jobs/post/detail.lb_contact_number')"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$p->contact_number ?? ''}}"
                    name="contact_number"
                    required="true"
                />

                <x-inputs.switch2
                    label="{{ __('jobs/post/detail.lb_is_active') }}"
                    :isReadonly="$mode['isModeShow']"
                    value="{{$p->is_active ?? true}}"
                    name="is_active"
                    onText="{{ __('jobs/post/detail.select_option_yes') }}"
                    offText="{{ __('jobs/post/detail.select_option_no') }}"
                />

                {{-- Timestamp Panel --}}
                @if($mode['isModeShow'])
                    <x-inputs.timestamp :updatedAt="$p->updated_at" :createdAt="$p->created_at" />
                @endif
            </div>
            {{-- Panel --}}
            @if(!$mode['isModeShow'])
                <div class="card-footer">
                    @include('jobs.post.detail_panel')
                </div>
            @endif
        </form>
    </div>
@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')

@endpush
