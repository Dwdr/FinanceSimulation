{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('eh/system_settings/backup/index.title_html'))
@section('page_title', __('eh/system_settings/backup/index.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('eh/system_settings/backup/index.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active">{{ __('eh/system_settings/backup/index.breadcrumb_level_2') }}</li>
    <li class="breadcrumb-item active">{{ __('eh/system_settings/backup/index.breadcrumb_level_3') }}</li>
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    <livewire:eh.system_settings.backup.index/>

@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')

@endpush
