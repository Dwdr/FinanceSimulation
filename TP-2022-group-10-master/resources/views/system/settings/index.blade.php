{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')

@endsection

{{-- Title --}}
@section('html_title', 'Settings')
@section('page_title', 'Settings')

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">Settings</li>
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    {{--
    todo settings

    -------School management---------

    config school name
    config school icon/logo
    config school address
    config school contact number
    config panel theme (color/backgrand image)
    config panel theme

    ------- END School management---------

    --}}

    @can('cs.settings.r')

    <div class="row">
        <div class="col-md-4 col-sm-6 col-12">
            <div class="callout callout-warning d-flex align-items-end justify-content-between p-4">
                <div class="pr-1">
                <span class="font-weight-bold h4">School Information</span>
                </div>
                <div>
                <a class="btn btn-primary text-decoration-none text-light" href="{{route('cs.settings.school_info.show')}}">Config</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-sm-6 col-12">
            <div class="callout callout-warning d-flex align-items-end justify-content-between p-4">
                <div class="pr-1">
                    <span class="font-weight-bold h4">Statement of Account</span>
                </div>
                <div>
                    <a class="btn btn-primary text-decoration-none text-light" href="{{route('cs.settings.statement_of_account.show')}}">Config</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-sm-6 col-12">
            <div class="callout callout-warning d-flex align-items-end justify-content-between p-4">
                <div class="pr-1">
                    <span class="font-weight-bold h4">Global Alert</span>
                </div>
                <div>
                    <a class="btn btn-primary text-decoration-none text-light" href="{{route('cs.settings.global_alert.show')}}">Config</a>
                </div>
            </div>
        </div>


        <div class="col-md-4 col-sm-6 col-12">
            <div class="callout callout-warning d-flex align-items-end justify-content-between p-4">
                <div class="pr-1">
                    <span class="font-weight-bold h4">Currency</span>
                </div>
                <div>
                    <a class="btn btn-primary text-decoration-none text-light" href="{{route('system.settings.currency.index')}}">Config</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-sm-6 col-12">
            <div class="callout callout-warning d-flex align-items-end justify-content-between p-4">
                <div class="pr-1">
                    <span class="font-weight-bold h4">App Image</span>
                </div>
                <div>
                    <a class="btn btn-primary text-decoration-none text-light" href="{{route('cs.settings.app_image.index')}}">Config</a>
                </div>
            </div>
        </div>

    </div>

    @endcan



@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')

@endpush
