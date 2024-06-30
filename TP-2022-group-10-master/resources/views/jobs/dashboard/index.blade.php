{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_jobs')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('jobs/dashboard/index.title_html'))
@section('page_title', __('jobs/dashboard/index.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('jobs/dashboard/index.breadcrumb_level_1') }}</li>
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

{{--    <div class="row">--}}
{{--        <div class="col-lg-12 col-12">--}}
{{--            <div class="small-box bg-danger">--}}
{{--                <div class="inner">--}}
{{--                    <h3>jobs DEBUG</h3>--}}
{{--                    <p>--}}
{{--                        dump(Auth::user()->getRoleNames()[0])<br>--}}
{{--                        {{ dump(Auth::user()->getRoleNames()[0]) }}<br>--}}
{{--                        config('constants.ROLE.ADMIN')<br>--}}
{{--                        {{ config('constants.ROLE.USER') }}<br>--}}
{{--                        auth()->user()->roles[0]->id<br>--}}
{{--                        {{ dump(auth()->user()->roles[0]->id) }}<br>--}}

{{--                        <br><br><br>--}}
{{--                        Auth::user()->hasRole(config('constants.ROLE.ADMIN')):{{ Auth::user()->hasRole(config('constants.ROLE.ADMIN')) }}<br>--}}
{{--                        Auth::user()->hasRole(config('constants.ROLE.USER')):{{ Auth::user()->hasRole(config('constants.ROLE.USER')) }}<br>--}}

{{--                    </p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="row">--}}
{{--        <div class="col-lg-12 col-12">--}}
{{--            <div class="small-box bg-danger">--}}
{{--                <div class="inner">--}}
{{--                    <h3>USER</h3>--}}
{{--                    <p>--}}
{{--                        {{ dump(Auth::user()) }}--}}
{{--                    </p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')

@endpush
